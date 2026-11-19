const {chromium} = require('playwright');
const {readFileSync} = require('node:fs');
const {createHash} = require('node:crypto');
const assert = require('node:assert/strict');
const {randomUUID} = require('node:crypto');
const [url, passwordFile, product = 'Smoke Product'] = process.argv.slice(2);
if (!url || !passwordFile) throw new Error('Usage: node browser-smoke.cjs BASE_URL PASSWORD_FILE [PRODUCT_NAME]');
(async () => {
    const browser = await chromium.launch({executablePath:process.env.REQINTAKE_CHROMIUM || '/usr/bin/chromium', headless:true, args:['--no-sandbox']});
    try {
        const context = await browser.newContext({viewport:{width:1440,height:960}});
        const base = url.replace(/\/$/, '') + '/';
        const page = await context.newPage();
        await page.goto(base);
        const api = context.request;
        const challenge = (await (await api.get(base+'index.php?m=user&f=refreshRandom')).text()).trim();
        const hash = value => createHash('md5').update(value).digest('hex');
        const password = readFileSync(passwordFile,'utf8').trim();
        const result = await (await api.post(base+'index.php?m=user&f=login',{
            form:{account:'admin',password:hash(hash(password)+challenge),passwordStrength:'2',verifyRand:challenge,referer:'/'},
            headers:{Referer:base+'index.php?m=user&f=login','X-Requested-With':'XMLHttpRequest'}
        })).json();
        assert.equal(result.result,'success');
        const errors = [];
        page.on('pageerror', err => errors.push(err.message));
        await page.goto(base+'index.php?m=my&f=index');
        await page.goto(base+'index.php?m=reqintake&f=index&_single=1',{referer:base+'index.php?m=user&f=login'});
        const app = page;
        const form = app.locator('#reqintake-receive');
        await form.waitFor({timeout:8000});
        await form.locator('[name=product]').selectOption({label:product});
        await page.waitForFunction(() => document.querySelector('#reqintake-receive output')?.textContent.includes('待配置负责人'),{},{timeout:5000}).catch(async e=>{console.log(await form.locator('output').textContent(),errors);throw e;});
        const branchModule = process.env.REQINTAKE_BRANCH_MODULE;
        if (branchModule) {
            const scope = form.locator('[data-reqintake-extra]');
            await scope.waitFor();
            await scope.locator('select').filter({has: page.getByRole('option', {name: branchModule})})
                .selectOption({label: branchModule});
        }
        const title = 'Browser clipboard smoke ' + randomUUID();
        await form.locator('[name=title]').fill(title);
        const editor = form.locator('zen-editor[name=description] .tiptap[contenteditable=true]');
        await editor.waitFor({timeout:20000});
        await editor.fill('Browser description');
        const acceptance = form.locator('zen-editor[name=acceptance] .tiptap[contenteditable=true]');
        await acceptance.fill('Browser acceptance');
        const png = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aUioAAAAASUVORK5CYII=';
        await editor.evaluate((element, png) => {
            element.focus();
            const bytes = Uint8Array.from(atob(png), c => c.charCodeAt(0));
            const clipboardData = new DataTransfer();
            clipboardData.items.add(new File([bytes],'fixture.png',{type:'image/png'}));
            element.dispatchEvent(new ClipboardEvent('paste',{clipboardData,bubbles:true,cancelable:true,composed:true}));
        },png);
        await editor.locator('img[src]').waitFor();
        await form.getByRole('button',{name:'提交需求'}).click();
        await app.getByText(/已登记反馈 #\d+/).waitFor();
        const detail = await app.getByRole('link',{name:title,exact:true}).getAttribute('href');
        await page.goto(new URL(detail,base).href+'&attachmentID=0&_single=1');
        await app.locator('dl').getByText('Browser acceptance',{exact:true}).waitFor();
        assert.equal(await app.locator('dd img').count(),1);
        if (branchModule) await app.locator('dl').getByText(branchModule, {exact:false}).waitFor();
        assert.deepEqual(errors,[]);
        if (process.env.REQINTAKE_SCREENSHOT) await page.screenshot({path:process.env.REQINTAKE_SCREENSHOT,fullPage:true});
        console.log('Browser verified product preview, editor input, clipboard PNG, submission and detail');
    } finally { await browser.close(); }
})().catch(e => {console.error(e);process.exitCode=1});
