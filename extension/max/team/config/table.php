<?php
global $lang;

$config->team->dtable = new stdclass();
$config->team->dtable->fieldList['id']['name']     = 'id';
$config->team->dtable->fieldList['id']['title']    = $lang->idAB;
$config->team->dtable->fieldList['id']['fixed']    = 'left';
$config->team->dtable->fieldList['id']['sortType'] = true;
$config->team->dtable->fieldList['id']['group']    = 1;

$config->team->dtable->fieldList['name']['name']         = 'name';
$config->team->dtable->fieldList['name']['title']        = $lang->team->name;
$config->team->dtable->fieldList['name']['type']         = 'title';
$config->team->dtable->fieldList['name']['fixed']        = 'left';
$config->team->dtable->fieldList['name']['nestedToggle'] = true;
$config->team->dtable->fieldList['name']['link']         = array('module' => 'team', 'method' => 'view', 'params' => "teamID={id}");
$config->team->dtable->fieldList['name']['group']        = 1;

$config->team->dtable->fieldList['manager']['name']  = 'manager';
$config->team->dtable->fieldList['manager']['title'] = $lang->team->manager;
$config->team->dtable->fieldList['manager']['type']  = 'text';
$config->team->dtable->fieldList['manager']['hint']  = true;
$config->team->dtable->fieldList['manager']['group'] = 2;

$config->team->dtable->fieldList['number']['name']     = 'number';
$config->team->dtable->fieldList['number']['title']    = $lang->team->number;
$config->team->dtable->fieldList['number']['type']     = 'number';
$config->team->dtable->fieldList['number']['sortType'] = false;
$config->team->dtable->fieldList['number']['minWidth'] = '100';
$config->team->dtable->fieldList['number']['group']    = 3;

$config->team->dtable->fieldList['status']['name']       = 'status';
$config->team->dtable->fieldList['status']['title']      = $lang->team->status;
$config->team->dtable->fieldList['status']['type']       = 'status';
$config->team->dtable->fieldList['status']['statusMap']  = $lang->team->statusList;
$config->team->dtable->fieldList['status']['group']      = 5;

$config->team->dtable->fieldList['createdDate']['name']  = 'createdDate';
$config->team->dtable->fieldList['createdDate']['title'] = $lang->team->createdDate;
$config->team->dtable->fieldList['createdDate']['type']  = 'date';
$config->team->dtable->fieldList['createdDate']['group'] = 6;

$config->team->dtable->fieldList['actions']['name']  = 'actions';
$config->team->dtable->fieldList['actions']['title'] = $lang->actions;
$config->team->dtable->fieldList['actions']['type']  = 'actions';
$config->team->dtable->fieldList['actions']['fixed'] = 'right';
$config->team->dtable->fieldList['actions']['list']  = $config->team->actionList;
$config->team->dtable->fieldList['actions']['menu']  = array('edit', 'enable|disband', 'delete');
