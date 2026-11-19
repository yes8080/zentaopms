#!/usr/bin/env python3
import argparse
import hashlib
import json
from html.parser import HTMLParser
from pathlib import Path
from urllib.parse import urlencode
from urllib.request import Request, build_opener, HTTPCookieProcessor

parser = argparse.ArgumentParser(description='Check the administrator intake flow on a disposable ZenTao instance.')
parser.add_argument('base_url')
parser.add_argument('password_file', type=Path)
args = parser.parse_args()
base = args.base_url.rstrip('/') + '/'
opener = build_opener(HTTPCookieProcessor())

def request(path, data=None):
    headers = {'Referer': base + 'index.php?m=user&f=login'}
    if data is not None:
        headers['X-Requested-With'] = 'XMLHttpRequest'
    encoded = None if data is None else urlencode(data).encode()
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
    with opener.open(Request(base+route,urlencode(data).encode(), {'Referer':base+route}),timeout=10) as response:
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
