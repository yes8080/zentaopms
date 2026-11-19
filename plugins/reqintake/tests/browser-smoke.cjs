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
        assert.equal(await page.locator('zen-editor').count(), 2);
        assert.equal(await form.locator('zen-editor').count(), 2);
        const columns = app.locator('#reqintake-column-settings');
        await columns.locator('summary').click();
        await columns.locator('input[value=customer]').uncheck();
        const customerHeader = app.locator('th[data-column=customer]');
        assert.equal(await customerHeader.isVisible(), false);
        await page.reload();
        await customerHeader.waitFor({state:'hidden'});
        await columns.locator('summary').click();
        await columns.locator('input[value=customer]').check();
        await customerHeader.waitFor({state:'visible'});
        const previousProduct = process.env.REQINTAKE_PREVIEW_RACE_PRODUCT;
        const productPicker = form.locator('[name=product]');
        if (previousProduct) {
            const options = await productPicker.locator('option').evaluateAll(items =>
                Object.fromEntries(items.map(item => [item.label, item.value])));
            assert.ok(options[previousProduct] && options[product] && previousProduct !== product);
            const firstPreview = url => url.searchParams.get('previewProduct') === options[previousProduct];
            const initialTitle = 'Draft survives product switch';
            await form.locator('[name=title]').fill(initialTitle);
            let releaseFirst;
            const firstResponseGate = new Promise(resolve => { releaseFirst = resolve; });
            let firstPreviewData;
            await page.route(firstPreview, async route => {
                const response = await route.fetch();
                firstPreviewData = await response.json();
                await firstResponseGate;
                await route.fulfill({response});
            }, {times:1});
            const started = page.waitForRequest(request => firstPreview(new URL(request.url())));
            await productPicker.selectOption({label:previousProduct});
            await started;
            await productPicker.selectOption({label:product});
            const preview = form.locator('output');
            await preview.getByText(/待配置负责人/).waitFor();
            const selectedPreview = await preview.textContent();
            const released = page.waitForResponse(response => firstPreview(new URL(response.url())));
            releaseFirst();
            await (await released).finished();
            await page.evaluate(() => new Promise(resolve => requestAnimationFrame(() => requestAnimationFrame(resolve))));
            assert.equal(firstPreviewData.pending, false);
            assert.equal(await preview.textContent(), selectedPreview);
            assert.equal(await form.locator('[name=title]').inputValue(), initialTitle);
        }
        await productPicker.selectOption({label:product});
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
        const attachmentBytes = Buffer.from([0, 255, 13, 10, 1]);
        await form.locator('input[name=attachment]').setInputFiles({
            name:'initial-attachment.bin', mimeType:'application/octet-stream', buffer:attachmentBytes
        });
        await form.locator('[name=estimate]').fill('-1');
        await form.getByRole('button',{name:'提交需求'}).click();
        await form.getByRole('alert').getByText(/请选择有效来源/).waitFor();
        assert.equal(await form.locator('input[name=attachment]').evaluate(input => input.files[0].name), 'initial-attachment.bin');
        assert.equal(await form.locator('[name=title]').inputValue(), title);
        await editor.locator('img[src]').waitFor();
        await form.locator('[name=estimate]').fill('1');
        await form.getByRole('button',{name:'提交需求'}).click();
        await app.getByText(/已登记反馈 #\d+/).waitFor();
        assert.match(page.url(), /[?&]f=detail(?:&|$)/);
        await app.getByRole('heading',{name:new RegExp(title)}).waitFor();
        await app.locator('dl').getByText('Browser acceptance',{exact:true}).waitFor();
        assert.equal(await app.locator('dd img').count(),1);
        const attachment = app.getByRole('link',{name:'initial-attachment.bin',exact:true});
        const download = await api.get(new URL(await attachment.getAttribute('href'),base).href);
        assert.equal(download.status(),200);
        assert.deepEqual(await download.body(),attachmentBytes);
        if (branchModule) await app.locator('dl').getByText(branchModule, {exact:false}).waitFor();
        const content = await app.locator('.reqintake-detail-content').boundingBox();
        const info = await app.locator('.reqintake-detail-info').boundingBox();
        assert.ok(content && info && content.x < info.x);
        await app.locator('[data-reqintake-open=reqintake-workflow]').click();
        assert.equal(await app.locator('#reqintake-workflow').getAttribute('open'), '');
        await app.locator('[data-reqintake-open=reqintake-edit]').click();
        assert.equal(await app.locator('#reqintake-edit').getAttribute('open'), '');
        await app.locator('#reqintake-workflow button[value=start]').click();
        await app.locator('.reqintake-detail-info').getByText('跟进中', {exact:true}).waitFor();
        await app.locator('.reqintake-detail-content').getByText(/admin · 开始跟进/).waitFor();
        const reply = app.locator('form:has(button[name=closeAfterReply])');
        await reply.locator('..').locator('summary').click();
        await reply.locator('[name=summary]').fill('Browser customer');
        await reply.locator('[name=replyChannel]').fill('Phone');
        await reply.locator('[name=details]').fill('Customer confirmed the fix');
        await reply.locator('[name=reason]').fill('Adjusted settings and verified with the customer');
        await reply.locator('[name=verified]').check();
        await reply.getByRole('button',{name:'记录答复并结案'}).click();
        await app.locator('.reqintake-detail-info').getByText('已关闭',{exact:true}).waitFor();
        await app.locator('.reqintake-detail-content').getByText(/客户确认.*Adjusted settings/).waitFor();
        assert.deepEqual(errors,[]);
        if (process.env.REQINTAKE_SCREENSHOT) await page.screenshot({path:process.env.REQINTAKE_SCREENSHOT,fullPage:true});
        console.log('Browser verified product preview, editor input, clipboard PNG, submission and detail');
    } finally { await browser.close(); }
})().catch(e => {console.error(e);process.exitCode=1});
