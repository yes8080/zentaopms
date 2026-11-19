<?php
global $lang;
$config->alert = new stdClass();

$config->alert->search['module']                   = 'alert';
$config->alert->search['fields']['name']           = $lang->alert->name;
$config->alert->search['fields']['objectType']     = $lang->alert->objectType;
$config->alert->search['fields']['alertLevel']     = $lang->alert->alertLevel;
$config->alert->search['fields']['status']         = $lang->alert->status;
$config->alert->search['fields']['createdBy']      = $lang->alert->createdBy;
$config->alert->search['fields']['createdDate']    = $lang->alert->createdDate;
$config->alert->search['fields']['lastEditedBy']   = $lang->alert->lastEditedBy;
$config->alert->search['fields']['lastEditedDate'] = $lang->alert->lastEditedDate;

$config->alert->search['params']['name']           = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->alert->search['params']['objectType']     = array('operator' => '=',       'control' => 'select', 'values' => $lang->alert->objectList);
$config->alert->search['params']['alertLevel']     = array('operator' => '=',       'control' => 'select', 'values' => $lang->alert->levelList);
$config->alert->search['params']['status']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->alert->statusList);
$config->alert->search['params']['createdBy']      = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->alert->search['params']['createdDate']    = array('operator' => '=',       'control' => 'date',   'values' => '');
$config->alert->search['params']['lastEditedBy']   = array('operator' => '=',       'control' => 'select', 'values' => 'users');
$config->alert->search['params']['lastEditedDate'] = array('operator' => '=',       'control' => 'date',   'values' => '');
