<?php
global $lang;
$config->rule->actionList = array();
$config->rule->actionList['design']['icon']  = 'treemap';
$config->rule->actionList['design']['text']  = $lang->rule->design;
$config->rule->actionList['design']['hint']  = $lang->rule->design;
$config->rule->actionList['design']['url']   = array('module' => 'rule', 'method' => 'design', 'params' => 'id={id}');

$config->rule->actionList['enable']['icon']      = 'magic';
$config->rule->actionList['enable']['text']      = $lang->rule->enable;
$config->rule->actionList['enable']['hint']      = $lang->rule->enable;
$config->rule->actionList['enable']['url']       = array('module' => 'rule', 'method' => 'enable', 'params' => 'id={id}');
$config->rule->actionList['enable']['className'] = 'ajax-submit';

$config->rule->actionList['disable']['icon']         = 'off';
$config->rule->actionList['disable']['text']         = $lang->rule->disable;
$config->rule->actionList['disable']['hint']         = $lang->rule->disable;
$config->rule->actionList['disable']['url']          = array('module' => 'rule', 'method' => 'disable', 'params' => 'id={id}');
$config->rule->actionList['disable']['className']    = 'ajax-submit';
$config->rule->actionList['disable']['data-confirm'] = $lang->rule->notice->disable;

$config->rule->actionList['log']['icon']        = 'list';
$config->rule->actionList['log']['text']        = $lang->rule->log;
$config->rule->actionList['log']['hint']        = $lang->rule->log;
$config->rule->actionList['log']['url']         = array('module' => 'rule', 'method' => 'log', 'params' => 'id={id}');
$config->rule->actionList['log']['data-toggle'] = 'modal';
$config->rule->actionList['log']['data-size']   = 'lg';

$config->rule->actionList['notify']['icon']        = 'cog';
$config->rule->actionList['notify']['text']        = $lang->rule->notify;
$config->rule->actionList['notify']['hint']        = $lang->rule->notify;
$config->rule->actionList['notify']['url']         = array('module' => 'rule', 'method' => 'notify', 'params' => 'id={id}');
$config->rule->actionList['notify']['data-toggle'] = 'modal';

$config->rule->actionList['copy']['icon']        = 'copy';
$config->rule->actionList['copy']['text']        = $lang->rule->copy;
$config->rule->actionList['copy']['hint']        = $lang->rule->copy;
$config->rule->actionList['copy']['url']         = array('module' => 'rule', 'method' => 'copy', 'params' => 'id={id}');
$config->rule->actionList['copy']['data-toggle'] = 'modal';

$config->rule->actionList['edit']['icon']        = 'edit';
$config->rule->actionList['edit']['text']        = $lang->rule->edit;
$config->rule->actionList['edit']['hint']        = $lang->rule->edit;
$config->rule->actionList['edit']['url']         = array('module' => 'rule', 'method' => 'edit', 'params' => 'id={id}');
$config->rule->actionList['edit']['data-toggle'] = 'modal';
$config->rule->actionList['edit']['data-size']   = 'default';

$config->rule->actionList['delete']['icon']         = 'trash';
$config->rule->actionList['delete']['text']         = $lang->rule->delete;
$config->rule->actionList['delete']['hint']         = $lang->rule->delete;
$config->rule->actionList['delete']['url']          = array('module' => 'rule', 'method' => 'delete', 'params' => 'id={id}');
$config->rule->actionList['delete']['className']    = 'ajax-submit';
$config->rule->actionList['delete']['data-confirm'] = $lang->rule->notice->delete;
