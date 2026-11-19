#!/usr/bin/env python3
import argparse
import hashlib
import html
import json
from concurrent.futures import ThreadPoolExecutor
from threading import Barrier
from html.parser import HTMLParser
from pathlib import Path
from urllib.error import HTTPError
from urllib.parse import urlencode
from urllib.request import Request, build_opener, HTTPCookieProcessor
from uuid import uuid4

parser = argparse.ArgumentParser(description='Check the administrator intake flow on a disposable ZenTao instance.')
parser.add_argument('base_url')
parser.add_argument('password_file', type=Path)
parser.add_argument('--target', nargs=2, action='append', default=[], metavar=('TYPE', 'ID'),
                    help='Existing native work on Smoke Product to check in both directions')
parser.add_argument('--task-conversion', action='store_true', help='Verify creating a task in a linked execution')
parser.add_argument('--native-product', action='store_true',
                    help='Create a disposable product to verify the native owner field')
parser.add_argument('--conversion', nargs='+', choices=('story', 'requirement', 'epic', 'bug'), default=[],
                    help='Verify native creation and idempotent replay for the selected types')
args = parser.parse_args()
base = args.base_url.rstrip('/') + '/'
opener = build_opener(HTTPCookieProcessor())

def request(path, data=None, client=opener):
    headers = {'Referer': base + 'index.php?m=user&f=login'}
    if data is not None:
        headers['X-Requested-With'] = 'XMLHttpRequest'
    encoded = None if data is None else urlencode(data, doseq=True).encode()
    with client.open(Request(base + path, encoded, headers), timeout=30) as response:
        return response.read().decode()

def md5(value):
    return hashlib.md5(value.encode(), usedforsecurity=False).hexdigest()

def sign_in(client):
    assert '<title>用户登录 - 禅道</title>' in request('', client=client)
    rand = request('index.php?m=user&f=refreshRandom', client=client).strip()
    assert rand
    password = args.password_file.read_text().strip()
    result = json.loads(request('index.php?m=user&f=login', {
        'account': 'admin', 'password': md5(md5(password) + rand),
        'passwordStrength': '2', 'verifyRand': rand, 'referer': '/',
    }, client=client))
    assert result.get('result') == 'success', result.get('message', 'login failed')
    page = request('index.php?m=my&f=index', client=client)
    assert '<title>用户登录' not in page and 'admin' in page and '<title>' in page


sign_in(opener)
print('Administrator login and authenticated workspace check passed')
import re
route = 'index.php?m=reqintake&f=index'
page = request(route)
keys = {k:re.search(f'name="{k}" value="([^"]+)"',page)[1] for k in ('operation','token')}
product = re.search(r'<option value="(\d+)"[^>]*>Smoke Product',page)[1]
payload = dict(keys,product=product,title='Reqintake integration request',description='Integration description',customer='Test customer',channel='test',
               category='performance', priority='2', acceptance='Acceptance criteria integration check',
               source='market', sourceNote='Private interview notes', keywords='integration tag', estimate='2.75', customerVersion='Customer release 2026.11')
def submit(data):
    with opener.open(Request(base+route,urlencode(data, doseq=True).encode(), {'Referer':base+route}),timeout=10) as response:
        return response.read().decode()
first = submit(payload)
second = submit(payload)
for output in (first,second):
    if '已登记反馈 #' not in output:
        raise RuntimeError('Missing saved confirmation')
    assert '待配置负责人' in output
assert re.search(r'已登记反馈 #(\d+)',first)[1] == re.search(r'已登记反馈 #(\d+)',second)[1]
print('Intake submission and identical retry passed')
id = re.search(r'已登记反馈 #(\d+)',first)[1]
dashboard = html.unescape(request('index.php?m=my&f=index'))
assert '待处理反馈' in dashboard and f'm=reqintake&f=detail&id={id}' in dashboard
def transition(version,action,reason=''):
    return submit(dict(keys,intent='transition',feedbackID=id,version=version,action=action,reason=reason))
assert '采纳、关闭或重开时请填写原因' in transition(1,'accept')
assert '跟进中' in transition(1,'accept','Approved after product review')
assert '反馈状态已变化' in transition(1,'close','stale')
assert '采纳、关闭或重开时请填写原因' in transition(2,'close')
assert 'Closure evidence' in transition(2,'close','Closure evidence')
assert 'Reopen evidence' in transition(3,'reopen','Reopen evidence')
page=request('index.php?m=reqintake&f=detail&id='+id)
assert all(text in page for text in ('Integration description', 'Test customer', 'Smoke Product',
                                     '跟进中', '性能', '· 采纳 · Approved after product review', payload['acceptance'], '市场',
                                     payload['sourceNote'], payload['keywords'], payload['estimate'], payload['customerVersion']))
assert '请选择有效来源' in submit(dict(payload, estimate='-1'))
assert '客户使用版本最多填写' in submit(dict(payload, customerVersion='x' * 101))
assert '请选择归属当前产品' in submit(dict(payload, module='999999'))
assert '请选择有效的类别和优先级' in submit(dict(payload, category='invalid_category'))
for scope in ('mine','assigned'):
    assert 'Reqintake integration request' in request(route+'&scope='+scope)
print('Lifecycle, reason history, detail and personal filters passed')

product_view = f'index.php?m=product&f=view&productID={product}'
assert 'data-reqintake-owner="pending"' in request(product_view)
preview_route = f'{route}&scope=all&filterProduct=0&previewProduct={product}'
assert 'updatePreview' in request(route)
assert json.loads(request(preview_route))['pending'] is True
assert '该账号无权访问此产品或已删除' in submit(dict(keys, intent='owner', product=product, owner='missing_account_123'))
try:
    assert '负责人配置已保存' in submit(dict(keys, intent='owner', product=product, owner='admin'))
    assert json.loads(request(preview_route))['pending'] is False
    assert 'data-reqintake-owner="configured"' in request(product_view)
    page = request(route)
    new_keys = {k: re.search(f'name="{k}" value="([^"]+)"', page)[1] for k in ('operation', 'token')}
    assigned = submit(dict(payload, **new_keys))
    assigned_id = re.search(r'已登记反馈 #(\d+)', assigned)[1]
    assert assigned_id != id
    assert '待配置负责人' not in request('index.php?m=reqintake&f=detail&id=' + assigned_id)
    assert '待配置负责人' in request('index.php?m=reqintake&f=detail&id=' + id)
finally:
    assert '负责人配置已保存' in submit(dict(keys, intent='owner', product=product, owner=''))
assert json.loads(request(preview_route))['pending'] is True
print('Owner validation, assignment preview, preservation and clear passed')


detail_route = 'index.php?m=reqintake&f=detail&id='
pending_detail = detail_route + id
detail_token = re.search(r'name="token" value="([^"]+)"', request(pending_detail))[1]
followup = dict(token=detail_token, intent='followup', version=4, message='Customer confirmed reproduction')
assert 'Customer confirmed reproduction' in request(pending_detail, followup)
assert '反馈状态已变化' in request(pending_detail, dict(followup, message='Stale duplicate note'))

transfer = dict(token=detail_token, intent='transfer', version=5, assignee='admin',
                message='Administrator took ownership of the unconfigured feedback')
invalid = request(pending_detail, dict(transfer, assignee='missing_account_123'))
assert '该账号无权访问此产品或已删除' in invalid
assert transfer['message'] not in invalid
page = request(pending_detail, transfer)
assert all(text in page for text in (transfer['message'], '转交给 admin', '跟进中'))
assert '待配置负责人' not in page
assert '反馈状态已变化' in request(pending_detail, transfer)
assert 'Stale duplicate note' not in request(pending_detail)
print('Communication and transfer preserve workflow state and reject stale writes')

if args.target:
    detail = 'index.php?m=reqintake&f=detail&id=' + id
    token = re.search(r'name="token" value="([^"]+)"', request(detail))[1]
    parameters = {'story': 'storyID', 'requirement': 'storyID', 'epic': 'storyID', 'bug': 'bugID', 'task': 'taskID'}
    for version, (kind, target_id) in enumerate(args.target, 6):
        assert kind in parameters and target_id.isdecimal(), (kind, target_id)
        target_route = f'index.php?m={kind}&f=view&{parameters[kind]}={target_id}'
        link = dict(token=token, version=version, storyID=target_id, storyType=kind, linkScope='Bidirectional smoke scope')
        assert target_route in html.unescape(request(detail, link))
        assert detail in html.unescape(request(target_route))
        print(f'{kind} #{target_id} links in both directions')

batch_target = next(((kind, target_id) for kind, target_id in args.target
                     if kind in ('story', 'requirement', 'epic')), None)
if batch_target:
    kind, target_id = batch_target
    page = request(route)
    fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
             for key in ('operation', 'token')}
    other = submit(dict(payload, **fresh))
    other_id = re.search(r'已登记反馈 #(\d+)', other)[1]
    scope = 'Atomic batch smoke scope'
    base_detail = 'index.php?m=reqintake&f=detail&id='

    def batch_link(other_version):
        return submit(dict(keys, intent='batchLink', storyID=target_id, storyType=kind,
                           linkScope=scope, **{'sources[]': [assigned_id + ':1',
                                                               f'{other_id}:{other_version}']}))

    assert '反馈状态已变化' in batch_link(2)
    assert scope not in request(base_detail + assigned_id)
    assert '已关联 2 条反馈' in batch_link(1)
    for source_id in (assigned_id, other_id):
        assert scope in request(base_detail + source_id)
    assert '已关联 2 条反馈' in batch_link(1)
    print('Batch linking rolls back on stale version and accepts identical retry')


if args.native_product:
    create = 'index.php?m=product&f=create'
    name = 'Owner fixture '+uuid4().hex[:10]
    assert 'reqintakeOwner' in request(create)
    data = dict(name=name,code=name.replace(' ',''),type='normal',acl='open',program=0,
                status='normal',shadow=0,desc='',line=0,reqintakeOwner='ri_tester')
    result = json.loads(request(create,data))
    assert result['result'] == 'success', result
    product_id = result['changes']['objectList'][0]
    detail = f'index.php?m=product&f=view&productID={product_id}'
    edit = f'index.php?m=product&f=edit&productID={product_id}'
    assert 'data-reqintake-owner="configured"' in request(detail)
    assert 'reqintakeOwner' in request(edit)
    other_preview = f'{route}&scope=all&filterProduct=0&previewProduct={product_id}'
    initial_preview = json.loads(request(other_preview))
    assert initial_preview['pending'] is False
    assert json.loads(request(preview_route))['pending'] is True
    assert json.loads(request(other_preview)) == initial_preview

    def open_intake():
        page = request(route)
        fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
                 for key in ('operation', 'token')}
        return dict(payload, **fresh) | dict(product=product_id)

    def saved_feedback(fields, owner, pending=False):
        response = submit(fields)
        feedback_id = re.search(r'已登记反馈 #(\d+)', response)[1]
        page = request(detail_route + feedback_id)
        suffix = ' (待配置负责人)' if pending else ''
        assert f'<dd>{owner}{suffix}</dd>' in page, (feedback_id, owner, pending)
        return feedback_id

    existing = open_intake()
    existing_id = saved_feedback(existing, 'ri_tester')
    open_form = open_intake()
    assert json.loads(request(edit, dict(data, reqintakeOwner='admin')))['result'] == 'success'
    changed_preview = json.loads(request(other_preview))
    assert changed_preview['pending'] is False and changed_preview['name'] != initial_preview['name']
    new_id = saved_feedback(open_form, 'admin')
    assert saved_feedback(existing, 'ri_tester') == existing_id
    assert existing_id != new_id
    assert json.loads(request(edit,dict(data,reqintakeOwner='')))['result'] == 'success'
    assert 'data-reqintake-owner="pending"' in request(detail)
    invalid = json.loads(request(edit,dict(data,reqintakeOwner='missing_account_123')))
    assert invalid['result'] == 'fail', invalid
    assert 'data-reqintake-owner="pending"' in request(detail)
    assert json.loads(request(other_preview))['pending'] is True
    saved_feedback(open_intake(), 'admin', pending=True)
    assert saved_feedback(open_form, 'admin') == new_id
    print(f'Product {product_id} owner change applies on submit; feedback {existing_id} and {new_id} retain their owners')


for kind in args.conversion:
    page = request(route)
    fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
             for key in ('operation', 'token')}
    conversion_payload = dict(payload, **fresh)
    if args.native_product and kind == 'story':
        assert '请选择有效的抄送账号' in submit(conversion_payload | {'mailto[]': ['unknown_account_99']})
        conversion_payload['mailto[]'] = ['ri_tester', 'ri_product_manager', 'ri_tester']
    created = submit(conversion_payload)
    source_id = re.search(r'已登记反馈 #(\d+)', created)[1]
    source_route = detail_route + source_id
    links = (html.unescape(link).lstrip('/')
             for link in re.findall(r'href="([^"]+riOperation[^"]+)"', request(source_route)))
    native_form = next(link for link in links if f'm={kind}&' in link)
    form = request(native_form)
    assert payload['title'] in form and payload['description'] in form and payload['sourceNote'] not in form and payload['customerVersion'] not in form
    if kind == 'story':
        assert payload['estimate'] in form and payload['keywords'] in form
        if args.native_product:
            assert 'ri_product_manager,ri_tester' in html.unescape(form)
    native_title = 'Converted feedback ' + uuid4().hex
    native_fields = dict(product=product, title=native_title, spec='Public description',
                         category='feature', pri=3, needNotReview=1, status='active', module=0,
                         branch=0, **{'reviewer[]': ''})
    if kind == 'story':
        second_client = build_opener(HTTPCookieProcessor())
        sign_in(second_client)
        request(route, client=second_client)
        second_source = request(source_route, client=second_client)
        second_form = next(html.unescape(link).lstrip('/')
                           for link in re.findall(r'href="([^"]+riOperation[^"]+)"', second_source)
                           if 'm=story&' in html.unescape(link))
        request(second_form, client=second_client)
        gate = Barrier(2)

        def save_story(client, form):
            gate.wait(timeout=10)
            return json.loads(request(form, native_fields, client=client))

        with ThreadPoolExecutor(max_workers=2) as pool:
            first_save = pool.submit(save_story, opener, native_form)
            second_save = pool.submit(save_story, second_client, second_form)
            first, second = first_save.result(), second_save.result()
        assert first['result'] == second['result'] == 'success', (first, second)
        story_id, = first['changes']['objectList']
        assert second['changes']['objectList'] == [story_id]
        print(f'Two authenticated sessions concurrently submit feedback {source_id} and share story {story_id}')
    if kind == 'bug':
        bug_fields = dict(product=product, title=native_title, type='codeerror',
                          steps='Confirmed steps', severity=3, pri=3, module=0,
                          branch=0, **{'openedBuild[]': 'trunk'})
        first = json.loads(request(native_form, bug_fields))
        assert first['result'] == 'success', first
        before = request(source_route)
        second = json.loads(request(native_form, bug_fields))
        assert second['result'] == 'success', second
        after = request(source_route)
        pattern = r'm=bug&amp;f=view&amp;bugID=(\d+)'
        matches = re.findall(pattern, before)
        assert len(matches) == 1 and re.findall(pattern, after) == matches
        assert native_title in after and '跟进中' in after
        print('Native bug creation and replay preserve a single feedback link')
        continue
    first = json.loads(request(native_form, native_fields))
    assert first['result'] == 'success', first
    second = json.loads(request(native_form, native_fields))
    assert second['result'] == 'success', second
    assert first['changes']['objectList'] == second['changes']['objectList']
    saved = request(source_route)
    assert native_title in saved and '跟进中' in saved
    print(f'Native {kind} creation, feedback association and idempotent replay passed')


for kind in (kind for kind in args.conversion if kind != 'bug'):

    def receive_source(customer=payload['customer'], **attributes):
        page = request(route)
        fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
                 for key in ('operation', 'token')}
        return re.search(r'已登记反馈 #(\d+)', submit(dict(payload, **fresh) | dict(customer=customer) | attributes))[1]

    def open_batch(sources, overrides=None):
        data = dict(keys, intent='batchCreate', storyType=kind, linkScope='Shared follow-up',
                    **{'sources[]': sources})
        for source, scope in (overrides or {}).items():
            data[f'sourceScopes[{source}]'] = scope
        req = Request(base + route, urlencode(data, doseq=True).encode(), {'Referer': base + route})
        with opener.open(req, timeout=10) as response:
            return response.url.removeprefix(base), response.read().decode()

    def picker_defaults(page):
        configs = (json.loads(html.unescape(value)) for value in re.findall(r'zui-create-(?:picker|priPicker)="([^"]+)"', page))
        return {config.get('name'): str(config.get('defaultValue')) for config in configs}

    source_ids = [receive_source(customer) for customer in ('Customer A', 'Customer B', 'Customer C')]
    partial = 'Exports only; leave approver column pending'
    native_form, page = open_batch([f'{source}:1' for source in source_ids], {source_ids[2]: partial})
    assert 'Shared follow-up' in page and partial in page and all(f'#{source}' in page for source in source_ids)
    assert payload['description'] not in page
    defaults = picker_defaults(page)
    assert defaults['category'] == payload['category'], defaults.get('category')
    assert defaults['pri'] == payload['priority'], defaults.get('pri')
    native_title = 'Batch conversion ' + uuid4().hex
    native_fields.update(title=native_title)
    first = json.loads(request(native_form, native_fields))
    assert first['result'] == 'success', first
    second = json.loads(request(native_form, native_fields))
    assert second['changes']['objectList'] == first['changes']['objectList']
    for source in source_ids:
        page = request(detail_route + source)
        expected_scope = partial if source == source_ids[2] else 'Shared follow-up'
        assert all(text in page for text in (native_title, expected_scope, '跟进中', '<span>新建转单</span>'))
        assert ('<span>' + partial + '</span>' in page) == (source == source_ids[2])

    target_id, = first['changes']['objectList']
    fourth = receive_source('Customer D')
    fourth_route = detail_route + fourth
    token = re.search(r'name="token" value="([^"]+)"', request(fourth_route))[1]
    attached = request(fourth_route, dict(token=token, version=1, storyID=target_id,
                                          storyType=kind, linkScope='Later customer'))
    assert native_title in attached and 'Later customer' in attached and '<span>关联已有单据</span>' in attached
    target_route = f'index.php?m={kind}&f=view&storyID={target_id}'
    backlinks = html.unescape(request(target_route))
    for source in (*source_ids, fourth):
        assert re.search(re.escape(detail_route + source) + r'(?!\d)', backlinks)

    def handle_source(source, **fields):
        path = detail_route + source
        page = request(path)
        token = re.search(r'name="token" value="([^"]+)"', page)[1]
        version = re.search(r'name="version" value="(\d+)"', page)[1]
        return request(path, dict(token=token, version=version, **fields))

    confirmed, waiting, extra = source_ids
    confirmation = 'Confirmed warehouse inventory export'
    upgrade = 'Wait for customer upgrade'
    remainder = 'Approver column remains outstanding'
    close = dict(intent='handling', kind='reply', summary='Customer A', details=confirmation,
                 replyChannel='phone', closeAfterReply='1', reason='Customer verified the export')
    assert '请核实剩余事项' in handle_source(confirmed, **close)
    assert confirmation not in request(detail_route + confirmed)
    stale_path = detail_route + confirmed
    stale_token = re.search(r'name="token" value="([^"]+)"', request(stale_path))[1]
    stale = request(stale_path, dict(close, token=stale_token, version=1, verified='1'))
    assert '反馈状态已变化' in stale and confirmation not in stale
    result = handle_source(confirmed, **close, verified='1')
    assert '已关闭' in result and '· 客户确认 ·' in result and confirmation in result
    assert upgrade in handle_source(waiting, intent='handling', kind='plan', summary=upgrade, details='')
    assert remainder in handle_source(extra, intent='handling', kind='plan', summary='Check extra requirement',
                                       details=remainder)
    for source, state, marker in ((confirmed, '已关闭', confirmation), (waiting, '跟进中', upgrade),
                                  (extra, '跟进中', remainder), (fourth, '跟进中', None)):
        page = request(detail_route + source)
        assert state in page and native_title in page
        for note in (confirmation, upgrade, remainder):
            assert (note in page) == (note == marker), (source, note)
    print(f'Shared {kind} #{target_id}: feedback {confirmed}, {waiting}, {extra}, {fourth} retain independent outcomes')

    stale_ids = [receive_source(), receive_source(category='feature')]
    native_form, mixed_page = open_batch([f'{source}:1' for source in stale_ids])
    defaults = picker_defaults(mixed_page)
    assert defaults['category'] == 'feature' and defaults['pri'] == payload['priority'], defaults
    submit(dict(keys, intent='transition', feedbackID=stale_ids[0], version=1, action='start'))
    native_fields.update(title='Rejected stale batch ' + uuid4().hex)
    failure = json.loads(request(native_form, native_fields))
    assert failure['result'] == 'fail' and '反馈状态已变化' in json.dumps(failure, ensure_ascii=False), failure
    assert native_fields['title'] not in request(detail_route + stale_ids[1])
    print(f'Batch {kind} conversion links every source, reuses the native ID, and rejects stale selections')
    if args.native_product:
        page = request(route)
        fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
                 for key in ('operation', 'token')}
        other = submit(dict(payload, **fresh) | {'product': product_id})
        other_source = re.search(r'已登记反馈 #(\d+)', other)[1]
        rejected_route, rejected = open_batch([f'{stale_ids[1]}:1', f'{other_source}:1'])
        assert 'riOperation' not in rejected_route
        assert '同一产品' in rejected
        print('Batch creation rejects feedback from different products')


if args.task_conversion:
    page = request(route)
    fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
             for key in ('operation', 'token')}
    task_source = re.search(r'已登记反馈 #(\d+)', submit(dict(payload, **fresh)))[1]
    source_route = detail_route + task_source
    page = request(source_route)
    token = re.search(r'name="token" value="([^"]+)"', page)[1]
    execution = re.search(r'<select name="execution" required>\s*<option value=""></option>\s*<option value="(\d+)">', page)[1]
    inputs = dict(intent='taskCreate', token=token, version=1, execution=execution)
    assert '请选择同一产品' in request(source_route, dict(inputs, execution=999999))
    req = Request(base + source_route, urlencode(inputs).encode(), {'Referer': base + source_route})
    with opener.open(req, timeout=10) as response:
        native = response.url.removeprefix(base)
        form = response.read().decode()
    assert 'riOperation' in native and payload['title'] in form and payload['description'] in form
    task_name = 'Task from feedback ' + uuid4().hex
    fields = dict(execution=execution, name=task_name, type='devel', story=1, pri=3, estimate=0, module=0)
    assert json.loads(request(native, dict(fields, type='affair')))['result'] == 'fail'
    first = json.loads(request(native, fields))
    assert first['result'] == 'success', first
    second = json.loads(request(native, fields))
    assert first['changes']['objectList'] == second['changes']['objectList']
    assert task_name in request(source_route)
    print('Task conversion checks execution, rejects multiple-task modes, and reuses the native ID')


page = request(route)
assert all(re.search(r'<zen-editor[^>]+name="' + field + '"', page)
           for field in ('description', 'acceptance'))
fresh = {key: re.search(f'name="{key}" value="([^"]+)"', page)[1]
         for key in ('operation', 'token')}
image = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+aUioAAAAASUVORK5CYII='
rich = dict(payload, **fresh) | dict(bodyFormat='rich',
    description='<p>Formatted <strong>description</strong></p>',
    acceptance=f'<ol><li>First criterion</li></ol><p><img src="{image}" alt="Inline image"></p>'
               '<p><img src="/untrusted-image.png" alt="external image"></p>')
failed_create = submit(dict(rich, estimate='-1'))
assert '请选择有效来源' in failed_create and image in failed_create
assert rich['operation'] in failed_create and '<strong>description</strong>' in html.unescape(failed_create)
source = re.search(r'已登记反馈 #(\d+)', submit(rich))[1]
assert re.search(r'已登记反馈 #(\d+)', submit(rich))[1] == source
source_route = detail_route + source
page = request(source_route)
assert '<strong>description</strong>' in page and '<ol><li>First criterion</li></ol>' in page
assert image in page and 'untrusted-image.png' not in page
token = re.search(r'name="token" value="([^"]+)"', page)[1]
revision = dict(rich, token=token, intent='revise', version=1,
                description='<p><em>Edited and formatted</em></p>', customer='Revised client name', customerVersion='Customer release 2026.12')
failed_revision = request(source_route, dict(revision, estimate='-1'))
assert '请选择有效来源' in failed_revision
assert re.search(r'<details id="reqintake-edit"\s+open', failed_revision)
assert '<em>Edited and formatted</em>' in html.unescape(failed_revision)
assert 'Revised client name' in failed_revision and image in failed_revision
assert 'Revised client name' not in request(source_route)
page = request(source_route, revision)
assert '<em>Edited and formatted</em>' in page and '<strong>description</strong>' in page
assert revision['customerVersion'] in page
revision_diffs = re.search(r'<div class="reqintake-revision-changes">(.*?)</div>', page, re.S)[1]
assert '客户使用版本' in revision_diffs
assert payload['customerVersion'] in revision_diffs and revision['customerVersion'] in revision_diffs
assert image not in revision_diffs
if 'story' in args.conversion:
    rich_form = next(html.unescape(link).lstrip('/')
                     for link in re.findall(r'href="([^"]+riOperation[^"]+)"', page)
                     if 'm=story&' in html.unescape(link))
    native_rich = html.unescape(request(rich_form))
    assert '<em>Edited and formatted</em>' in native_rich and 'First criterion' in native_rich
    assert image not in native_rich
listing = request(route)
assert 'Revised client name' in listing and '最近业务更新' in listing
print('Rich description and acceptance round-trip, preserve history, and support replay')


boundary = uuid4().hex
file_content = b'Attachment binary \x00\xff bytes\r\n'
parts = []
for key, value in dict(token=token, intent='attachment', version='2').items():
    parts.append(f'--{boundary}\r\nContent-Disposition: form-data; name="{key}"\r\n\r\n{value}\r\n'.encode())
parts.append(f'--{boundary}\r\nContent-Disposition: form-data; name="attachment"; filename="fixture.bin"\r\n'
             'Content-Type: application/octet-stream\r\n\r\n'.encode() + file_content + b'\r\n')
parts.append(f'--{boundary}--\r\n'.encode())
upload = Request(base + source_route, b''.join(parts),
                 {'Content-Type': f'multipart/form-data; boundary={boundary}', 'Referer': base + source_route})
with opener.open(upload, timeout=10) as response:
    page = response.read().decode()
file_link = html.unescape(re.search(r'href="([^"]+attachmentID=\d+)"', page)[1]).lstrip('/')
file_id = file_link.rsplit('=', 1)[1]
with opener.open(base + file_link, timeout=10) as response:
    assert 'attachment;' in response.headers['Content-Disposition']
    assert response.read() == file_content

def assert_file_unavailable(path):
    try:
        opener.open(base + path, timeout=10)
    except HTTPError as error:
        assert error.code == 404
    else:
        raise AssertionError('Attachment was accessible outside its permitted link')

assert_file_unavailable(detail_route + id + '&attachmentID=' + file_id)
remove = dict(token=token, intent='attachment', version=2, removeAttachment=file_id)
assert '反馈状态已变化' in request(source_route, remove)
assert 'fixture.bin' not in request(source_route, dict(remove, version=3))
assert_file_unavailable(file_link)
print('Attachment bytes round-trip, are bound to the source, and are unavailable after removal')


plan = dict(token=token, intent='handling', kind='plan', version=4,
            summary='Arrange customer retest', details='Confirm supported browser versions')
page = request(source_route, plan)
assert plan['summary'] in page and plan['details'] in page
assert plan['summary'] in request(route)
assert '反馈状态已变化' in request(source_route, plan)
reply = dict(token=token, intent='handling', kind='reply', version=5,
             summary='Customer contact', details='Confirmed the next retest slot', replyChannel='email')
assert '请填写答复对象' in request(source_route, dict(reply, replyChannel=''))
page = request(source_route, reply)
assert all(reply[field] in page for field in ('summary', 'details', 'replyChannel'))
assert plan['summary'] in page
print('Follow-up plan and customer reply are saved with separate history and stale-write checks')


duplicate = dict(token=token, intent='duplicate', version=6, original=id, reason='Already tracked')
assert '请选择同产品' in request(source_route, dict(duplicate, original=source))
page = request(source_route, duplicate)
assert '已关闭' in page and detail_route + id in html.unescape(page)
original_route = detail_route + id
original_page = request(original_route)
original_token = re.search(r'name="token" value="([^"]+)"', original_page)[1]
original_version = re.search(r'name="version" value="(\d+)"', original_page)[1]
cycle = request(original_route, dict(duplicate, token=original_token, version=original_version, original=source))
assert '关联不会形成循环' in cycle
assert '跟进中' in request(original_route)
print('Duplicate closure keeps original open and rejects circular references')
