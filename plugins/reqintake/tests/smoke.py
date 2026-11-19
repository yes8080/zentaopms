#!/usr/bin/env python3
import argparse
import hashlib
import html
import json
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import urlencode
from urllib.request import Request, build_opener, HTTPCookieProcessor

parser = argparse.ArgumentParser(description='Check the administrator intake flow on a disposable ZenTao instance.')
parser.add_argument('base_url')
parser.add_argument('password_file', type=Path)
parser.add_argument('--target', nargs=2, action='append', default=[], metavar=('TYPE', 'ID'),
                    help='Existing native work on Smoke Product to check in both directions')
args = parser.parse_args()
base = args.base_url.rstrip('/') + '/'
opener = build_opener(HTTPCookieProcessor())

def request(path, data=None):
    headers = {'Referer': base + 'index.php?m=user&f=login'}
    if data is not None:
        headers['X-Requested-With'] = 'XMLHttpRequest'
    encoded = None if data is None else urlencode(data, doseq=True).encode()
    with opener.open(Request(base + path, encoded, headers), timeout=30) as response:
        return response.read().decode()

def md5(value):
    return hashlib.md5(value.encode(), usedforsecurity=False).hexdigest()

assert '<title>用户登录 - 禅道</title>' in request('')
rand = request('index.php?m=user&f=refreshRandom').strip()
assert rand
password = args.password_file.read_text().strip()
result = json.loads(request('index.php?m=user&f=login', {
    'account': 'admin', 'password': md5(md5(password) + rand),
    'passwordStrength': '2', 'verifyRand': rand, 'referer': '/',
}))
assert result.get('result') == 'success', result.get('message', 'login failed')
page = request('index.php?m=my&f=index')
assert '<title>用户登录' not in page and 'admin' in page and '<title>' in page
print('Administrator login and authenticated workspace check passed')
import re
route = 'index.php?m=reqintake&f=index'
page = request(route)
keys = {k:re.search(f'name="{k}" value="([^"]+)"',page)[1] for k in ('operation','token')}
product = re.search(r'<option value="(\d+)"[^>]*>Smoke Product',page)[1]
payload = dict(keys,product=product,title='Reqintake integration request',description='Integration description',customer='Test customer',channel='test')
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
def transition(version,action,reason=''):
    return submit(dict(keys,intent='transition',feedbackID=id,version=version,action=action,reason=reason))
assert '跟进中' in transition(1,'start')
assert '反馈状态已变化' in transition(1,'close','stale')
assert '关闭或重开时请填写原因' in transition(2,'close')
assert 'Closure evidence' in transition(2,'close','Closure evidence')
assert 'Reopen evidence' in transition(3,'reopen','Reopen evidence')
page=request('index.php?m=reqintake&f=detail&id='+id)
assert all(text in page for text in ('Integration description','Test customer','Smoke Product','跟进中'))
for scope in ('mine','assigned'):
    assert 'Reqintake integration request' in request(route+'&scope='+scope)
print('Lifecycle, reason history, detail and personal filters passed')

preview_route = f'{route}&scope=all&filterProduct=0&previewProduct={product}'
assert 'updatePreview' in request(route)
assert json.loads(request(preview_route))['pending'] is True
assert '该账号无权访问此产品或已删除' in submit(dict(keys, intent='owner', product=product, owner='missing_account_123'))
try:
    assert '负责人配置已保存' in submit(dict(keys, intent='owner', product=product, owner='admin'))
    assert json.loads(request(preview_route))['pending'] is False
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
