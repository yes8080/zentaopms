<?php
global $lang;

$config->art->actionList = array();

$config->art->actionList['createPI']['icon']         = 'plus';
$config->art->actionList['createPI']['text']         = $lang->art->createPI;
$config->art->actionList['createPI']['hint']         = $lang->art->createPI;
$config->art->actionList['createPI']['url']          = array('module' => 'pi', 'method' => 'create', 'params' => 'id={id}');
$config->art->actionList['createPI']['notLoadModel'] = true;

$config->art->actionList['close']['icon']      = 'unlink';
$config->art->actionList['close']['text']      = $lang->art->close;
$config->art->actionList['close']['hint']      = $lang->art->close;
$config->art->actionList['close']['url']       = array('module' => 'art', 'method' => 'close', 'params' => 'id={id}');
$config->art->actionList['close']['className'] = 'ajax-submit';

$config->art->actionList['activate']['icon']        = 'magic';
$config->art->actionList['activate']['text']        = $lang->art->activate;
$config->art->actionList['activate']['hint']        = $lang->art->activate;
$config->art->actionList['activate']['url']         = array('module' => 'art', 'method' => 'activate', 'params' => 'id={id}');
$config->art->actionList['activate']['className']   = 'ajax-submit';
$config->art->actionList['activate']['data-toggle'] = 'modal';

$config->art->actionList['edit']['icon'] = 'edit';
$config->art->actionList['edit']['hint'] = $lang->art->edit;
$config->art->actionList['edit']['url']  = array('module' => 'art', 'method' => 'edit', 'params' => 'artID={id}');

$config->art->actionList['delete']['icon']         = 'trash';
$config->art->actionList['delete']['hint']         = $lang->art->delete;
$config->art->actionList['delete']['url']          = array('module' => 'art', 'method' => 'delete', 'params' => 'artID={id}');
$config->art->actionList['delete']['className']    = 'ajax-submit';
$config->art->actionList['delete']['data-confirm'] = $lang->art->notice->confirmDelete;
