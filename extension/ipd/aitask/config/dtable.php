<?php
$config->aitask->dtable = new stdclass();
$config->aitask->dtable->browse = array();
$config->aitask->dtable->browse['id']['title']    = 'ID';
$config->aitask->dtable->browse['id']['type']     = 'id';
$config->aitask->dtable->browse['id']['sortType'] = true;
$config->aitask->dtable->browse['id']['required'] = true;
$config->aitask->dtable->browse['id']['fixed']    = 'left';

$config->aitask->dtable->browse['name']['type']     = 'title';
$config->aitask->dtable->browse['name']['fixed']    = 'left';
$config->aitask->dtable->browse['name']['width']    = 240;
$config->aitask->dtable->browse['name']['title']    = $lang->aitask->name;
$config->aitask->dtable->browse['name']['sortType'] = true;
$config->aitask->dtable->browse['name']['required'] = true;
$config->aitask->dtable->browse['name']['link']     = array('module' => 'aitask', 'method' => 'view', 'params' => "taskID={id}");
if(isInModal())
{
    $config->aitask->dtable->browse['name']['data-dismiss'] = 'modal';
    $config->aitask->dtable->browse['name']['data-toggle']  = 'modal';
    $config->aitask->dtable->browse['name']['data-size']    = 'lg';
}

$config->aitask->dtable->browse['objectType']['title']    = $lang->aitask->object;
$config->aitask->dtable->browse['objectType']['sortType'] = true;
$config->aitask->dtable->browse['objectType']['required'] = true;

$config->aitask->dtable->browse['assignedTo']['title']    = $lang->aitask->assignedTo;
$config->aitask->dtable->browse['assignedTo']['sortType'] = true;
$config->aitask->dtable->browse['assignedTo']['required'] = true;
$config->aitask->dtable->browse['assignedTo']['type']     = 'user';

$config->aitask->dtable->browse['status']['title']    = $lang->aitask->status;
$config->aitask->dtable->browse['status']['sortType'] = true;
$config->aitask->dtable->browse['status']['required'] = true;
$config->aitask->dtable->browse['status']['map']      = $lang->aitask->statusList;

$config->aitask->dtable->browse['type']['title']    = $lang->aitask->type;
$config->aitask->dtable->browse['type']['sortType'] = true;
$config->aitask->dtable->browse['type']['required'] = true;
$config->aitask->dtable->browse['type']['width']    = '160';

$config->aitask->dtable->browse['createdDate']['title']      = $lang->aitask->createdDate;
$config->aitask->dtable->browse['createdDate']['sortType']   = true;
$config->aitask->dtable->browse['createdDate']['required']   = true;
$config->aitask->dtable->browse['createdDate']['formatDate'] = 'YYYY-MM-dd';
$config->aitask->dtable->browse['createdDate']['width']      = 90;

$config->aitask->dtable->browse['actions']['fixed'] = 'right';
$config->aitask->dtable->browse['actions']['width'] = '100';
$config->aitask->dtable->browse['actions']['type']  = 'actions';
$config->aitask->dtable->browse['actions']['list']  = $config->aitask->actionList;
$config->aitask->dtable->browse['actions']['menu']  = $config->aitask->actions->browse;
