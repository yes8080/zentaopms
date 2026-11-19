<?php
/**
 * AI 模块配置扩展。
 * AI module configuration extension.
 */

global $lang, $app;
if(!isset($lang->ai)) $app->loadLang('ai');
if(!isset($lang->ai->skills)) $app->loadLang('ai');

/* 我的知识库搜索配置 */
$config->ai->myknowledgelib = new stdclass();
$config->ai->myknowledgelib->search = array();
$config->ai->myknowledgelib->search['module'] = 'myknowledgelib';

$config->ai->myknowledgelib->search['fields']['name']        = $lang->ai->knowledgeLibs->knowledgeLibName;
$config->ai->myknowledgelib->search['fields']['published']   = $lang->ai->knowledgeLibs->status;
$config->ai->myknowledgelib->search['fields']['importType']  = $lang->ai->knowledgeLibs->importType;
$config->ai->myknowledgelib->search['fields']['desc']        = $lang->ai->knowledgeLibs->knowledgeLibDesc;
$config->ai->myknowledgelib->search['fields']['createdBy']   = $lang->ai->knowledgeLibs->creator;
$config->ai->myknowledgelib->search['fields']['createdDate'] = $lang->ai->knowledgeLibs->createdDate;

$config->ai->myknowledgelib->search['params']['name']        = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->ai->myknowledgelib->search['params']['desc']        = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->ai->myknowledgelib->search['params']['published']   = array('operator' => '=', 'control' => 'select', 'values' => $lang->ai->knowledgeLibs->publishedList);
$config->ai->myknowledgelib->search['params']['importType']  = array('operator' => '=', 'control' => 'select', 'values' => $lang->ai->knowledgeLibs->importTypeList);
$config->ai->myknowledgelib->search['params']['createdBy']   = array('operator' => '=', 'control' => 'select', 'values' => 'users');
$config->ai->myknowledgelib->search['params']['createdDate'] = array('operator' => '>=', 'control' => 'input', 'class' => 'date', 'values' => '');

/* 团队知识库搜索配置 */
$config->ai->teamknowledgelib = new stdclass();
$config->ai->teamknowledgelib->search = $config->ai->myknowledgelib->search;
$config->ai->teamknowledgelib->search['module'] = 'teamknowledgelib';

$config->ai->myknowledgelib->acceptFileTypes = '.pdf,.docx,.doc,.xlsx,.xls,.csv,.ppt,.pptx,.json,.yaml,.yml,.txt,.md';

$config->ai->queryModule = array();
$config->ai->queryModule['myknowledgelib']   = 'myknowledgelib';
$config->ai->queryModule['teamknowledgelib'] = 'teamknowledgelib';

$config->ai->browseskill = new stdclass();
$config->ai->browseskill->search = array();
$config->ai->browseskill->search['module'] = 'browseskill';
$config->ai->browseskill->search['fields']['name']        = $lang->ai->skills->name;
$config->ai->browseskill->search['fields']['category']    = $lang->ai->skills->category;
$config->ai->browseskill->search['fields']['fromID']      = $lang->ai->skills->source;
$config->ai->browseskill->search['fields']['desc']        = $lang->ai->skills->desc;
$config->ai->browseskill->search['fields']['status']      = $lang->ai->skills->status;
$config->ai->browseskill->search['fields']['createdBy']   = $lang->ai->skills->createdBy;
$config->ai->browseskill->search['fields']['createdDate'] = $lang->ai->skills->createdDate;
$config->ai->browseskill->search['fields']['editedBy']    = $lang->ai->skills->editedBy;
$config->ai->browseskill->search['fields']['editedDate']  = $lang->ai->skills->editedDate;
$config->ai->browseskill->search['params']['name']        = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->ai->browseskill->search['params']['category']    = array('operator' => '=', 'control' => 'select', 'values' => array());
$config->ai->browseskill->search['params']['fromID']      = array('operator' => '>', 'control' => 'select', 'values' => array('' => '', '0' => $lang->ai->skills->square));
$config->ai->browseskill->search['params']['desc']        = array('operator' => 'include', 'control' => 'input', 'values' => '');
$config->ai->browseskill->search['params']['status']      = array('operator' => '=', 'control' => 'select', 'values' => $lang->ai->skills->statusList);
$config->ai->browseskill->search['params']['createdBy']   = array('operator' => '=', 'control' => 'select', 'values' => 'users');
$config->ai->browseskill->search['params']['createdDate'] = array('operator' => '>=', 'control' => 'input', 'class' => 'date', 'values' => '');
$config->ai->browseskill->search['params']['editedBy']    = array('operator' => '=', 'control' => 'select', 'values' => 'users');
$config->ai->browseskill->search['params']['editedDate']  = array('operator' => '>=', 'control' => 'input', 'class' => 'date', 'values' => '');

$config->ai->queryModule['browseskill'] = 'browseskill';
$config->ai->queryModule['myskill']     = 'myskill';

if(!isset($config->ai->groupPrivs)) $config->ai->groupPrivs = array();

$config->ai->actionList['editmyskill']['icon']        = 'edit';
$config->ai->actionList['editmyskill']['text']        = $lang->ai->skills->edit;
$config->ai->actionList['editmyskill']['hint']        = $lang->ai->skills->edit;
$config->ai->actionList['editmyskill']['url']         = array('module' => 'ai', 'method' => 'editMySkill', 'params' => 'id={id}');
$config->ai->actionList['editmyskill']['data-toggle'] = 'modal';

$config->ai->actionList['editsquareskill']['icon']        = 'edit';
$config->ai->actionList['editsquareskill']['text']        = $lang->ai->skills->edit;
$config->ai->actionList['editsquareskill']['hint']        = $lang->ai->skills->edit;
$config->ai->actionList['editsquareskill']['url']         = array('module' => 'ai', 'method' => 'editSquareSkill', 'params' => 'id={id}');
$config->ai->actionList['editsquareskill']['data-toggle'] = 'modal';

$config->ai->actionList['deleteskill']['icon']         = 'trash';
$config->ai->actionList['deleteskill']['text']         = $lang->delete;
$config->ai->actionList['deleteskill']['hint']         = $lang->delete;
$config->ai->actionList['deleteskill']['url']          = array('module' => 'ai', 'method' => 'deleteSkill', 'params' => 'skillID={id}');
$config->ai->actionList['deleteskill']['className']    = 'ajax-submit';
$config->ai->actionList['deleteskill']['data-confirm'] = array('message' => $lang->confirmDelete, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');

$config->ai->actionList['deletesquareskill']['icon']         = 'trash';
$config->ai->actionList['deletesquareskill']['text']         = $lang->delete;
$config->ai->actionList['deletesquareskill']['hint']         = $lang->delete;
$config->ai->actionList['deletesquareskill']['url']          = array('module' => 'ai', 'method' => 'deleteSquareSkill', 'params' => 'skillID={id}');
$config->ai->actionList['deletesquareskill']['className']    = 'ajax-submit';
$config->ai->actionList['deletesquareskill']['data-confirm'] = array('message' => $lang->confirmDelete, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');

$config->ai->actionList['removeskill']['icon']         = 'unlink';
$config->ai->actionList['removeskill']['text']         = $lang->ai->skills->remove;
$config->ai->actionList['removeskill']['hint']         = $lang->ai->skills->remove;
$config->ai->actionList['removeskill']['url']          = array('module' => 'ai', 'method' => 'removeSkill', 'params' => 'skillID={id}');
$config->ai->actionList['removeskill']['className']    = 'ajax-submit';
$config->ai->actionList['removeskill']['data-confirm'] = array('message' => $lang->ai->skills->confirmRemove, 'icon' => 'icon-exclamation-sign', 'iconClass' => 'warning-pale rounded-full icon-2x');

$config->ai->actions->viewskill = array();
$config->ai->actions->viewskill['mainActions']   = array();
$config->ai->actions->viewskill['suffixActions'] = array('deleteskill', 'deletesquareskill');
$config->ai->actions->viewmyskill     = $config->ai->actions->viewskill;
$config->ai->actions->viewsquareskill = $config->ai->actions->viewskill;
