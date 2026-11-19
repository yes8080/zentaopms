<?php
$config->client->require = new stdclass();
$config->client->require->creat = 'version, strategy, downloads, status';
$config->client->require->edit  = 'version, strategy, downloads, status';
$config->client->expirationDays = 3;

$config->client->upgradeApi         = 'https://www.xuanim.com/xxbversion-api%s.json';
$config->client->downloadLinkPrefix = 'https://www.xuanim.com/dl/xuanxuan/';

$config->client->dataRoot          = 'data/client/';
$config->client->commonDirPattern  = 'data/client/%s/_common/'; // %s = version

$config->client->downloadList = array();
$config->client->downloadList['win64']    = 'xuanxuan.%s.ee.win64.setup.exe';
$config->client->downloadList['win32']    = 'xuanxuan.%s.ee.win32.setup.exe';
$config->client->downloadList['linux64']  = 'xuanxuan.%s.ee.linux.amd64.deb';
$config->client->downloadList['linuxarm'] = 'xuanxuan.%s.ee.linux.arm64.deb';
$config->client->downloadList['mac']      = 'xuanxuan.%s.ee.mac.dmg';
$config->client->downloadList['mac.m1']   = 'xuanxuan.%s.ee.mac.m1.dmg';
