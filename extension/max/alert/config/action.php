<?php
global $lang;
$config->alert->actionList = array();

$config->alert->actionList['enable']['icon']         = 'magic';
$config->alert->actionList['enable']['text']         = $lang->alert->enable;
$config->alert->actionList['enable']['hint']         = $lang->alert->enable;
$config->alert->actionList['enable']['url']          = array('module' => 'alert', 'method' => 'enable', 'params' => 'id={id}');
$config->alert->actionList['enable']['data-confirm'] = $lang->alert->notice->enable;
$config->alert->actionList['enable']['className']    = 'ajax-submit';

$config->alert->actionList['disable']['icon']         = 'off';
$config->alert->actionList['disable']['text']         = $lang->alert->disable;
$config->alert->actionList['disable']['hint']         = $lang->alert->disable;
$config->alert->actionList['disable']['url']          = array('module' => 'alert', 'method' => 'disable', 'params' => 'id={id}');
$config->alert->actionList['disable']['className']    = 'ajax-submit';
$config->alert->actionList['disable']['data-confirm'] = $lang->alert->notice->disable;

$config->alert->actionList['edit']['icon']        = 'edit';
$config->alert->actionList['edit']['text']        = $lang->alert->edit;
$config->alert->actionList['edit']['hint']        = $lang->alert->edit;
$config->alert->actionList['edit']['url']         = array('module' => 'alert', 'method' => 'edit', 'params' => 'id={id}');
$config->alert->actionList['edit']['data-toggle'] = 'modal';

$config->alert->actionList['delete']['icon']         = 'trash';
$config->alert->actionList['delete']['text']         = $lang->alert->delete;
$config->alert->actionList['delete']['hint']         = $lang->alert->delete;
$config->alert->actionList['delete']['url']          = array('module' => 'alert', 'method' => 'delete', 'params' => 'id={id}');
$config->alert->actionList['delete']['className']    = 'ajax-submit';
$config->alert->actionList['delete']['data-confirm'] = $lang->alert->confirmDelete;
