<?php
$config->alert->dtable = new stdclass();

$config->alert->dtable->fieldList['id']['title']    = $lang->idAB;
$config->alert->dtable->fieldList['id']['name']     = 'id';
$config->alert->dtable->fieldList['id']['type']     = 'id';
$config->alert->dtable->fieldList['id']['sortType'] = true;
$config->alert->dtable->fieldList['id']['width']    = '80';
$config->alert->dtable->fieldList['id']['required'] = true;

$config->alert->dtable->fieldList['name']['title']    = $lang->alert->name;
$config->alert->dtable->fieldList['name']['name']     = 'name';
$config->alert->dtable->fieldList['name']['type']     = 'title';
$config->alert->dtable->fieldList['name']['sortType'] = true;
$config->alert->dtable->fieldList['name']['fixed']    = 'left';
$config->alert->dtable->fieldList['name']['required'] = true;

$config->alert->dtable->fieldList['objectType']['title'] = $lang->alert->objectType;
$config->alert->dtable->fieldList['objectType']['name']  = 'objectType';
$config->alert->dtable->fieldList['objectType']['type']  = 'category';
$config->alert->dtable->fieldList['objectType']['map']   = $lang->alert->objectList;
$config->alert->dtable->fieldList['objectType']['width'] = '100';
$config->alert->dtable->fieldList['objectType']['show']  = 1;

$config->alert->dtable->fieldList['alertRule']['title'] = $lang->alert->alertRule;
$config->alert->dtable->fieldList['alertRule']['name']  = 'alertRule';
$config->alert->dtable->fieldList['alertRule']['type']  = 'text';
$config->alert->dtable->fieldList['alertRule']['width'] = '220';
$config->alert->dtable->fieldList['alertRule']['show']  = 1;

$config->alert->dtable->fieldList['alertLevel']['title']    = $lang->alert->alertLevel;
$config->alert->dtable->fieldList['alertLevel']['name']     = 'alertLevel';
$config->alert->dtable->fieldList['alertLevel']['type']     = 'category';
$config->alert->dtable->fieldList['alertLevel']['sortType'] = true;
$config->alert->dtable->fieldList['alertLevel']['map']      = $lang->alert->levelList;
$config->alert->dtable->fieldList['alertLevel']['width']    = '100';
$config->alert->dtable->fieldList['alertLevel']['show']     = 1;

$config->alert->dtable->fieldList['status']['title'] = $lang->alert->status;
$config->alert->dtable->fieldList['status']['name']  = 'status';
$config->alert->dtable->fieldList['status']['type']  = 'category';
$config->alert->dtable->fieldList['status']['map']   = $lang->alert->statusList;
$config->alert->dtable->fieldList['status']['width'] = '100';
$config->alert->dtable->fieldList['status']['show']  = 1;

$config->alert->dtable->fieldList['createdBy']['title']  = $lang->alert->createdBy;
$config->alert->dtable->fieldList['createdBy']['name']   = 'createdBy';
$config->alert->dtable->fieldList['createdBy']['type']   = 'user';

$config->alert->dtable->fieldList['createdDate']['title']  = $lang->alert->createdDate;
$config->alert->dtable->fieldList['createdDate']['name']   = 'createdDate';
$config->alert->dtable->fieldList['createdDate']['type']   = 'date';
$config->alert->dtable->fieldList['createdDate']['width']  = '110';

$config->alert->dtable->fieldList['lastEditedBy']['title']  = $lang->alert->lastEditedBy;
$config->alert->dtable->fieldList['lastEditedBy']['name']   = 'lastEditedBy';
$config->alert->dtable->fieldList['lastEditedBy']['type']   = 'user';

$config->alert->dtable->fieldList['lastEditedDate']['title']  = $lang->alert->lastEditedDate;
$config->alert->dtable->fieldList['lastEditedDate']['name']   = 'lastEditedDate';
$config->alert->dtable->fieldList['lastEditedDate']['type']   = 'date';
$config->alert->dtable->fieldList['lastEditedDate']['width']  = '110';

$config->alert->dtable->fieldList['actions']['title'] = $lang->actions;
$config->alert->dtable->fieldList['actions']['type']  = 'actions';
$config->alert->dtable->fieldList['actions']['width'] = '140';
$config->alert->dtable->fieldList['actions']['list']  = $config->alert->actionList;
$config->alert->dtable->fieldList['actions']['menu']  = array('enable|disable', 'edit', 'delete');
