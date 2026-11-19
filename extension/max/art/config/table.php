<?php
global $lang;

$config->art->dtable = new stdclass();
$config->art->dtable->fieldList['id']['name']     = 'id';
$config->art->dtable->fieldList['id']['title']    = $lang->idAB;
$config->art->dtable->fieldList['id']['fixed']    = 'left';
$config->art->dtable->fieldList['id']['sortType'] = true;
$config->art->dtable->fieldList['id']['group']    = 1;

$config->art->dtable->fieldList['name']['name']  = 'name';
$config->art->dtable->fieldList['name']['title'] = $lang->art->name;
$config->art->dtable->fieldList['name']['type']  = 'title';
$config->art->dtable->fieldList['name']['fixed'] = 'left';
$config->art->dtable->fieldList['name']['link']  = array('module' => 'art', 'method' => 'view', 'params' => "artID={id}");
$config->art->dtable->fieldList['name']['group'] = 1;

$config->art->dtable->fieldList['product']['name']  = 'product';
$config->art->dtable->fieldList['product']['title'] = $lang->art->product;
$config->art->dtable->fieldList['product']['type']  = 'text';
$config->art->dtable->fieldList['product']['hint']  = true;
$config->art->dtable->fieldList['product']['group'] = 2;

$config->art->dtable->fieldList['RTE']['name']  = 'RTE';
$config->art->dtable->fieldList['RTE']['title'] = $lang->art->RTE;
$config->art->dtable->fieldList['RTE']['type']  = 'user';
$config->art->dtable->fieldList['RTE']['hint']  = true;
$config->art->dtable->fieldList['RTE']['group'] = 3;

$config->art->dtable->fieldList['manager']['name']  = 'manager';
$config->art->dtable->fieldList['manager']['title'] = $lang->art->manager;
$config->art->dtable->fieldList['manager']['type']  = 'text';
$config->art->dtable->fieldList['manager']['hint']  = true;
$config->art->dtable->fieldList['manager']['group'] = 4;

$config->art->dtable->fieldList['PO']['name']  = 'PO';
$config->art->dtable->fieldList['PO']['title'] = $lang->art->PO;
$config->art->dtable->fieldList['PO']['type']  = 'text';
$config->art->dtable->fieldList['PO']['hint']  = true;
$config->art->dtable->fieldList['PO']['group'] = 5;

$config->art->dtable->fieldList['architect']['name']  = 'architect';
$config->art->dtable->fieldList['architect']['title'] = $lang->art->architect;
$config->art->dtable->fieldList['architect']['type']  = 'text';
$config->art->dtable->fieldList['architect']['hint']  = true;
$config->art->dtable->fieldList['architect']['group'] = 6;

$config->art->dtable->fieldList['status']['name']      = 'status';
$config->art->dtable->fieldList['status']['title']     = $lang->art->status;
$config->art->dtable->fieldList['status']['type']      = 'status';
$config->art->dtable->fieldList['status']['statusMap'] = $lang->art->statusList;
$config->art->dtable->fieldList['status']['group']     = 7;

$config->art->dtable->fieldList['createdDate']['name']  = 'createdDate';
$config->art->dtable->fieldList['createdDate']['title'] = $lang->art->createdDate;
$config->art->dtable->fieldList['createdDate']['type']  = 'date';
$config->art->dtable->fieldList['createdDate']['group'] = 8;

$config->art->dtable->fieldList['actions']['name']  = 'actions';
$config->art->dtable->fieldList['actions']['title'] = $lang->actions;
$config->art->dtable->fieldList['actions']['type']  = 'actions';
$config->art->dtable->fieldList['actions']['fixed'] = 'right';
$config->art->dtable->fieldList['actions']['list']  = $config->art->actionList;
$config->art->dtable->fieldList['actions']['menu']  = array('createPI', 'edit', 'activate|close', 'delete');
