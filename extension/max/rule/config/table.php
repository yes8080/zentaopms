<?php
$config->rule->dtable = new stdclass();

$config->rule->dtable->fieldList['id']['title']    = $lang->idAB;
$config->rule->dtable->fieldList['id']['name']     = 'id';
$config->rule->dtable->fieldList['id']['type']     = 'checkID';
$config->rule->dtable->fieldList['id']['sortType'] = true;
$config->rule->dtable->fieldList['id']['checkbox'] = true;
$config->rule->dtable->fieldList['id']['width']    = '80';
$config->rule->dtable->fieldList['id']['required'] = true;

$config->rule->dtable->fieldList['name']['title']       = $lang->rule->name;
$config->rule->dtable->fieldList['name']['name']        = 'name';
$config->rule->dtable->fieldList['name']['type']        = 'title';
$config->rule->dtable->fieldList['name']['sortType']    = true;
$config->rule->dtable->fieldList['name']['required']    = true;
$config->rule->dtable->fieldList['name']['fixed']       = 'left';
$config->rule->dtable->fieldList['name']['link']        = array('module' => 'rule', 'method' => 'view', 'params' => "id={id}");
$config->rule->dtable->fieldList['name']['data-toggle'] = 'modal';
$config->rule->dtable->fieldList['name']['data-size']   = 'lg';

$config->rule->dtable->fieldList['type']['title']    = $lang->rule->type;
$config->rule->dtable->fieldList['type']['name']     = 'type';
$config->rule->dtable->fieldList['type']['type']     = 'category';
$config->rule->dtable->fieldList['type']['sortType'] = true;
$config->rule->dtable->fieldList['type']['width']    = '160';
$config->rule->dtable->fieldList['type']['map']      = $lang->rule->typeList;

$config->rule->dtable->fieldList['workflowGroup']['title']    = $lang->rule->workflowGroup;
$config->rule->dtable->fieldList['workflowGroup']['name']     = 'workflowGroup';
$config->rule->dtable->fieldList['workflowGroup']['type']     = 'text';
$config->rule->dtable->fieldList['workflowGroup']['width']    = '160';
$config->rule->dtable->fieldList['workflowGroup']['sortType'] = true;

$config->rule->dtable->fieldList['method']['title']    = $lang->rule->method;
$config->rule->dtable->fieldList['method']['name']     = 'method';
$config->rule->dtable->fieldList['method']['type']     = 'category';
$config->rule->dtable->fieldList['method']['sortType'] = true;
$config->rule->dtable->fieldList['method']['map']      = $lang->rule->methodList;

$config->rule->dtable->fieldList['status']['title']    = $lang->rule->status;
$config->rule->dtable->fieldList['status']['name']     = 'status';
$config->rule->dtable->fieldList['status']['type']     = 'category';
$config->rule->dtable->fieldList['status']['sortType'] = true;
$config->rule->dtable->fieldList['status']['map']      = $lang->rule->statusList;

$config->rule->dtable->fieldList['createdBy']['title']    = $lang->rule->createdBy;
$config->rule->dtable->fieldList['createdBy']['name']     = 'createdBy';
$config->rule->dtable->fieldList['createdBy']['type']     = 'user';
$config->rule->dtable->fieldList['createdBy']['sortType'] = true;

$config->rule->dtable->fieldList['lastEditedBy']['title']    = $lang->rule->lastEditedBy;
$config->rule->dtable->fieldList['lastEditedBy']['name']     = 'lastEditedBy';
$config->rule->dtable->fieldList['lastEditedBy']['type']     = 'user';
$config->rule->dtable->fieldList['lastEditedBy']['width']    = '120';
$config->rule->dtable->fieldList['lastEditedBy']['sortType'] = true;

$config->rule->dtable->fieldList['lastEditedDate']['title']    = $lang->rule->lastEditedDate;
$config->rule->dtable->fieldList['lastEditedDate']['name']     = 'lastEditedDate';
$config->rule->dtable->fieldList['lastEditedDate']['type']     = 'date';
$config->rule->dtable->fieldList['lastEditedDate']['width']    = '120';
$config->rule->dtable->fieldList['lastEditedDate']['sortType'] = true;

$config->rule->dtable->fieldList['lastRunTime']['title']    = $lang->rule->lastRunTime;
$config->rule->dtable->fieldList['lastRunTime']['name']     = 'lastRunTime';
$config->rule->dtable->fieldList['lastRunTime']['type']     = 'date';
$config->rule->dtable->fieldList['lastRunTime']['width']    = '140';
$config->rule->dtable->fieldList['lastRunTime']['sortType'] = true;

$config->rule->dtable->fieldList['lastRunResult']['title']    = $lang->rule->lastRunResult;
$config->rule->dtable->fieldList['lastRunResult']['name']     = 'lastRunResult';
$config->rule->dtable->fieldList['lastRunResult']['type']     = 'category';
$config->rule->dtable->fieldList['lastRunResult']['sortType'] = true;
$config->rule->dtable->fieldList['lastRunResult']['width']    = '140';
$config->rule->dtable->fieldList['lastRunResult']['map']      = $lang->rule->resultList;

$config->rule->dtable->fieldList['actions']['title']    = $lang->actions;
$config->rule->dtable->fieldList['actions']['type']     = 'actions';
$config->rule->dtable->fieldList['actions']['width']    = '140';
$config->rule->dtable->fieldList['actions']['sortType'] = false;
$config->rule->dtable->fieldList['actions']['fixed']    = 'right';
$config->rule->dtable->fieldList['actions']['list']     = $config->rule->actionList;
$config->rule->dtable->fieldList['actions']['menu']     = array('design', 'enable|disable', 'log', 'notify', 'copy', 'edit');
