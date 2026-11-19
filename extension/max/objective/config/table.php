<?php
global $lang;

$config->objective->dtable = new stdclass();
$config->objective->dtable->fieldList['id']['name']     = 'id';
$config->objective->dtable->fieldList['id']['title']    = $lang->idAB;
$config->objective->dtable->fieldList['id']['fixed']    = 'left';
$config->objective->dtable->fieldList['id']['sortType'] = true;
$config->objective->dtable->fieldList['id']['group']    = 1;

$config->objective->dtable->fieldList['name']['name']         = 'name';
$config->objective->dtable->fieldList['name']['title']        = $lang->objective->name;
$config->objective->dtable->fieldList['name']['type']         = 'title';
$config->objective->dtable->fieldList['name']['nestedToggle'] = true;
$config->objective->dtable->fieldList['name']['fixed']        = 'left';
$config->objective->dtable->fieldList['name']['group']        = 1;

$config->objective->dtable->fieldList['promise']['name']  = 'promise';
$config->objective->dtable->fieldList['promise']['title'] = $lang->objective->promise;
$config->objective->dtable->fieldList['promise']['type']  = 'category';
$config->objective->dtable->fieldList['promise']['map']   = $lang->objective->promiseList;
$config->objective->dtable->fieldList['promise']['group'] = 2;

$config->objective->dtable->fieldList['team']['name']  = 'team';
$config->objective->dtable->fieldList['team']['title'] = $lang->objective->team;
$config->objective->dtable->fieldList['team']['type']  = 'category';
$config->objective->dtable->fieldList['team']['group'] = 3;

$config->objective->dtable->fieldList['BV']['name']     = 'BV';
$config->objective->dtable->fieldList['BV']['title']    = $lang->objective->BV;
$config->objective->dtable->fieldList['BV']['type']     = 'number';
$config->objective->dtable->fieldList['BV']['sortType'] = false;
$config->objective->dtable->fieldList['BV']['group']    = 4;

$config->objective->dtable->fieldList['AV']['name']     = 'AV';
$config->objective->dtable->fieldList['AV']['title']    = $lang->objective->AV;
$config->objective->dtable->fieldList['AV']['type']     = 'number';
$config->objective->dtable->fieldList['AV']['sortType'] = false;
$config->objective->dtable->fieldList['AV']['group']    = 5;

$config->objective->dtable->fieldList['actions']['name']  = 'actions';
$config->objective->dtable->fieldList['actions']['title'] = $lang->actions;
$config->objective->dtable->fieldList['actions']['type']  = 'actions';
$config->objective->dtable->fieldList['actions']['fixed'] = 'right';
$config->objective->dtable->fieldList['actions']['list']  = $config->objective->actionList;
$config->objective->dtable->fieldList['actions']['menu']  = array('edit', 'link|unlink', 'delete');
