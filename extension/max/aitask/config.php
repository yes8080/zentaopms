<?php
global $lang;

/* Action 模块配置：用于 modalHeader 显示任务名称 */
if(!isset($config->action)) $config->action = new stdclass();
if(!isset($config->action->objectNameFields)) $config->action->objectNameFields = array();
$config->action->objectNameFields['aitask'] = 'name';

$config->aitask = new stdclass();
$config->aitask->actions = new stdclass();
$config->aitask->actions->browse = array('verify', 'activate|cancel', 'delete');

$config->aitask->actions->view = array();
$config->aitask->actions->view['mainActions']   = array('assignTo', 'cancel', 'verify', 'activate', 'retry');
$config->aitask->actions->view['suffixActions'] = array('delete');

$config->aitask->browse = new stdclass();
$config->aitask->browse->search = array();
$config->aitask->browse->search['module'] = 'aitask';

$config->aitask->browse->search['fields']['name']        = $lang->aitask->name;
$config->aitask->browse->search['fields']['type']        = $lang->aitask->type;
$config->aitask->browse->search['fields']['status']      = $lang->aitask->status;
$config->aitask->browse->search['fields']['assignedTo']  = $lang->aitask->assignedTo;
$config->aitask->browse->search['fields']['createdDate'] = $lang->aitask->createdDate;

$config->aitask->browse->search['params']['name']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->aitask->browse->search['params']['type']        = array('operator' => '=',       'control' => 'select', 'values' => '');
$config->aitask->browse->search['params']['status']      = array('operator' => '=',       'control' => 'select', 'values' => $lang->aitask->statusList);
$config->aitask->browse->search['params']['assignedTo']  = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->aitask->browse->search['params']['createdDate'] = array('operator' => '=',       'control' => 'date',   'values' => '');

$config->aitask->actionList = array();
$config->aitask->actionList['assignTo']['key']          = 'assignTo';
$config->aitask->actionList['assignTo']['icon']         = 'hand-right';
$config->aitask->actionList['assignTo']['text']         = $lang->aitask->assignTo;
$config->aitask->actionList['assignTo']['hint']         = $lang->aitask->assignTo;
$config->aitask->actionList['assignTo']['url']          = array('module' => 'aitask', 'method' => 'assignTo', 'params' => 'taskID={id}');
$config->aitask->actionList['assignTo']['data-toggle']  = 'modal';
$config->aitask->actionList['assignTo']['data-size']    = 'md';
$config->aitask->actionList['assignTo']['notLoadModel'] = true;

$config->aitask->actionList['verify']['key']          = 'verify';
$config->aitask->actionList['verify']['icon']         = 'glasses';
$config->aitask->actionList['verify']['text']         = $lang->aitask->verified;
$config->aitask->actionList['verify']['hint']         = $lang->aitask->verified;
$config->aitask->actionList['verify']['url']          = array('module' => 'aitask', 'method' => 'verify', 'params' => 'taskID={id}');
$config->aitask->actionList['verify']['data-dismiss'] = 'modal';
$config->aitask->actionList['verify']['data-toggle']  = 'modal';
$config->aitask->actionList['verify']['data-size']    = 'md';
$config->aitask->actionList['verify']['notLoadModel'] = true;
if(isInModal()) $config->aitask->actionList['verify']['url'] = array('module' => 'aitask', 'method' => 'verify', 'params' => 'taskID={id}&inModal=yes');

$config->aitask->form = new stdclass();
$config->aitask->form->verify = array();
$config->aitask->form->verify['result'] = array('type' => 'string', 'required' => true, 'default' => 'pass');
$config->aitask->form->verify['remark'] = array('type' => 'string', 'required' => false, 'default' => '', 'filter' => 'trim');

$config->aitask->form->assignedTo = array();
$config->aitask->form->assignedTo['assignedTo']   = array('type' => 'string',   'required' => true,  'default' => '');
$config->aitask->form->assignedTo['assignedDate'] = array('type' => 'datetime', 'required' => false, 'default' => helper::now());
$config->aitask->form->assignedTo['comment']      = array('type' => 'string',   'required' => false, 'default' => '', 'control' => 'editor');

$config->aitask->actionList['activate']['key']          = 'activate';
$config->aitask->actionList['activate']['icon']         = 'magic';
$config->aitask->actionList['activate']['text']         = $lang->activate;
$config->aitask->actionList['activate']['hint']         = $lang->activate;
$config->aitask->actionList['activate']['url']          = array('module' => 'aitask', 'method' => 'activate', 'params' => 'taskID={id}');
$config->aitask->actionList['activate']['className']    = 'ajax-submit';
$config->aitask->actionList['activate']['data-confirm'] = array('message' => $lang->aitask->tips->confirmActivate, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');
$config->aitask->actionList['activate']['notLoadModel'] = true;

$config->aitask->actionList['cancel']['key']          = 'cancel';
$config->aitask->actionList['cancel']['icon']         = 'cancel';
$config->aitask->actionList['cancel']['text']         = $lang->cancel;
$config->aitask->actionList['cancel']['hint']         = $lang->cancel;
$config->aitask->actionList['cancel']['url']          = array('module' => 'aitask', 'method' => 'cancel', 'params' => 'taskID={id}');
$config->aitask->actionList['cancel']['className']    = 'ajax-submit';
$config->aitask->actionList['cancel']['data-confirm'] = array('message' => $lang->aitask->tips->confirmCancel, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');
$config->aitask->actionList['cancel']['notLoadModel'] = true;

$config->aitask->actionList['delete']['key']          = 'delete';
$config->aitask->actionList['delete']['icon']         = 'trash';
$config->aitask->actionList['delete']['text']         = $lang->delete;
$config->aitask->actionList['delete']['hint']         = $lang->delete;
$config->aitask->actionList['delete']['url']          = array('module' => 'aitask', 'method' => 'delete', 'params' => 'taskID={id}');
$config->aitask->actionList['delete']['className']    = 'ajax-submit';
$config->aitask->actionList['delete']['data-confirm'] = array('message' => $lang->aitask->tips->confirmDelete, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');
$config->aitask->actionList['delete']['notLoadModel'] = true;

$config->aitask->actionList['retry']['key']          = 'retry';
$config->aitask->actionList['retry']['icon']         = 'refresh';
$config->aitask->actionList['retry']['text']         = $lang->aitask->retry;
$config->aitask->actionList['retry']['hint']         = $lang->aitask->retry;
$config->aitask->actionList['retry']['url']          = array('module' => 'aitask', 'method' => 'retry', 'params' => 'taskID={id}');
$config->aitask->actionList['retry']['className']    = 'ajax-submit';
$config->aitask->actionList['retry']['data-confirm'] = array('message' => $lang->aitask->tips->confirmRetry, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');
$config->aitask->actionList['retry']['notLoadModel'] = true;

/* AI 任务执行相关配置：*/
$config->aitask->maxParallel = 10;     // 最大并发执行任务数
$config->aitask->maxRounds   = 10;     // 最大迭代轮数
$config->aitask->maxTime     = 600;    // 最大执行时间（秒）
$config->aitask->maxTokens   = 100000; // 最大Token数
