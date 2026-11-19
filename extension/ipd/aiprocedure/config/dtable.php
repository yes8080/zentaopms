<?php
global $lang, $config;

$config->aiprocedure->dtable = new stdclass();
$config->aiprocedure->dtable->fieldList = array();

$config->aiprocedure->dtable->fieldList['id']['title']    = $lang->idAB;
$config->aiprocedure->dtable->fieldList['id']['type']     = 'checkedID';
$config->aiprocedure->dtable->fieldList['id']['fixed']    = 'left';
$config->aiprocedure->dtable->fieldList['id']['sortType'] = true;
$config->aiprocedure->dtable->fieldList['id']['required'] = true;

$config->aiprocedure->dtable->fieldList['name']['title']    = $lang->aiprocedure->name;
$config->aiprocedure->dtable->fieldList['name']['type']     = 'title';
$config->aiprocedure->dtable->fieldList['name']['fixed']    = 'left';
$config->aiprocedure->dtable->fieldList['name']['link']     = array('module' => 'aiprocedure', 'method' => 'view', 'params' => "id={id}");
$config->aiprocedure->dtable->fieldList['name']['width']    = 200;
$config->aiprocedure->dtable->fieldList['name']['show']     = true;
$config->aiprocedure->dtable->fieldList['name']['sortType'] = true;
$config->aiprocedure->dtable->fieldList['name']['required'] = true;

$config->aiprocedure->dtable->fieldList['module']['title']    = $lang->aiprocedure->module;
$config->aiprocedure->dtable->fieldList['module']['sortType'] = true;
$config->aiprocedure->dtable->fieldList['module']['type']     = 'category';
$config->aiprocedure->dtable->fieldList['module']['map']      = $lang->aiprocedure->moduleList;
$config->aiprocedure->dtable->fieldList['module']['show']     = true;

$config->aiprocedure->dtable->fieldList['status']['title']     = $lang->aiprocedure->status;
$config->aiprocedure->dtable->fieldList['status']['sortType']  = true;
$config->aiprocedure->dtable->fieldList['status']['type']      = 'status';
$config->aiprocedure->dtable->fieldList['status']['statusMap'] = $lang->aiprocedure->statusList;
$config->aiprocedure->dtable->fieldList['status']['show']      = true;

$config->aiprocedure->dtable->fieldList['desc']['title']    = $lang->aiprocedure->desc;
$config->aiprocedure->dtable->fieldList['desc']['type']     = 'text';
$config->aiprocedure->dtable->fieldList['desc']['show']     = true;
$config->aiprocedure->dtable->fieldList['desc']['sortType'] = false;
$config->aiprocedure->dtable->fieldList['desc']['hint']     = true;

$config->aiprocedure->dtable->fieldList['createdBy']['title']    = $lang->aiprocedure->createdBy;
$config->aiprocedure->dtable->fieldList['createdBy']['type']     = 'user';
$config->aiprocedure->dtable->fieldList['createdBy']['sortType'] = true;
$config->aiprocedure->dtable->fieldList['createdBy']['show']     = true;

$config->aiprocedure->dtable->fieldList['createdDate']['title']    = $lang->aiprocedure->createdDate;
$config->aiprocedure->dtable->fieldList['createdDate']['sortType'] = true;
$config->aiprocedure->dtable->fieldList['createdDate']['type']     = 'datetime';
$config->aiprocedure->dtable->fieldList['createdDate']['show']     = true;

$config->aiprocedure->dtable->fieldList['actions']['fixed']    = 'right';
$config->aiprocedure->dtable->fieldList['actions']['width']    = 140;
$config->aiprocedure->dtable->fieldList['actions']['type']     = 'actions';
$config->aiprocedure->dtable->fieldList['actions']['required'] = true;
$config->aiprocedure->dtable->fieldList['actions']['list']     = $config->aiprocedure->actionList;
$config->aiprocedure->dtable->fieldList['actions']['menu']     = $config->aiprocedure->actions->browse;