<?php
global $app, $lang;

$app->loadLang('art');

$account = $app->user->account ?? '';

$config->pi->dtable = new stdclass();
$config->pi->dtable->fieldList['rawID']['name']     = 'rawID';
$config->pi->dtable->fieldList['rawID']['title']    = $lang->idAB;
$config->pi->dtable->fieldList['rawID']['fixed']    = 'left';
$config->pi->dtable->fieldList['rawID']['sortType'] = true;
$config->pi->dtable->fieldList['rawID']['group']    = 1;

$config->pi->dtable->fieldList['name']['name']         = 'name';
$config->pi->dtable->fieldList['name']['title']        = $lang->pi->name;
$config->pi->dtable->fieldList['name']['type']         = 'title';
$config->pi->dtable->fieldList['name']['fixed']        = 'left';
$config->pi->dtable->fieldList['name']['nestedToggle'] = true;
$config->pi->dtable->fieldList['name']['link']         = array('module' => 'pi', 'method' => 'team', 'params' => "id={id}");
$config->pi->dtable->fieldList['name']['group']        = 1;

$config->pi->dtable->fieldList['product']['name']  = 'product';
$config->pi->dtable->fieldList['product']['title'] = $lang->pi->product;
$config->pi->dtable->fieldList['product']['type']  = 'text';
$config->pi->dtable->fieldList['product']['hint']  = true;
$config->pi->dtable->fieldList['product']['group'] = 2;

$config->pi->dtable->fieldList['RTE']['name']  = 'RTE';
$config->pi->dtable->fieldList['RTE']['title'] = $lang->pi->RTE;
$config->pi->dtable->fieldList['RTE']['type']  = 'user';
$config->pi->dtable->fieldList['RTE']['group'] = 3;

$config->pi->dtable->fieldList['manager']['name']     = 'manager';
$config->pi->dtable->fieldList['manager']['title']    = $lang->art->manager;
$config->pi->dtable->fieldList['manager']['type']     = 'text';
$config->pi->dtable->fieldList['manager']['hint']     = true;
$config->pi->dtable->fieldList['manager']['minWidth'] = '100';
$config->pi->dtable->fieldList['manager']['group']    = 4;

$config->pi->dtable->fieldList['PO']['name']     = 'PO';
$config->pi->dtable->fieldList['PO']['title']    = $lang->pi->PO;
$config->pi->dtable->fieldList['PO']['type']     = 'text';
$config->pi->dtable->fieldList['PO']['hint']     = true;
$config->pi->dtable->fieldList['PO']['minWidth'] = '100';
$config->pi->dtable->fieldList['PO']['group']    = 5;

$config->pi->dtable->fieldList['architect']['name']     = 'architect';
$config->pi->dtable->fieldList['architect']['title']    = $lang->pi->architect;
$config->pi->dtable->fieldList['architect']['type']     = 'text';
$config->pi->dtable->fieldList['architect']['hint']     = true;
$config->pi->dtable->fieldList['architect']['minWidth'] = '100';
$config->pi->dtable->fieldList['architect']['group']    = 6;

$config->pi->dtable->fieldList['status']['name']       = 'status';
$config->pi->dtable->fieldList['status']['title']      = $lang->pi->status;
$config->pi->dtable->fieldList['status']['type']       = 'status';
$config->pi->dtable->fieldList['status']['statusMap']  = $lang->pi->statusList;
$config->pi->dtable->fieldList['status']['group']      = 7;

$config->pi->dtable->fieldList['createdDate']['name']  = 'createdDate';
$config->pi->dtable->fieldList['createdDate']['title'] = $lang->pi->createdDate;
$config->pi->dtable->fieldList['createdDate']['type']  = 'date';
$config->pi->dtable->fieldList['createdDate']['group'] = 8;

$config->pi->dtable->fieldList['actions']['name']  = 'actions';
$config->pi->dtable->fieldList['actions']['title'] = $lang->actions;
$config->pi->dtable->fieldList['actions']['type']  = 'actions';
$config->pi->dtable->fieldList['actions']['fixed'] = 'right';
$config->pi->dtable->fieldList['actions']['list']  = $config->pi->actionList;
$config->pi->dtable->fieldList['actions']['menu']  = array('edit', 'activate|close' ,'delete');

$app->loadLang('story');
$config->pi->story = new stdclass();
$config->pi->story->dtable = new stdclass();

$config->pi->story->dtable->fieldList['id']['name']     = 'id';
$config->pi->story->dtable->fieldList['id']['title']    = $lang->idAB;
$config->pi->story->dtable->fieldList['id']['fixed']    = 'left';
$config->pi->story->dtable->fieldList['id']['required'] = 'yes';
$config->pi->story->dtable->fieldList['id']['type']     = 'checkID';
$config->pi->story->dtable->fieldList['id']['checkbox'] = true;
$config->pi->story->dtable->fieldList['id']['show']     = true;
$config->pi->story->dtable->fieldList['id']['sortType'] = true;
$config->pi->story->dtable->fieldList['id']['group']    = 1;

$config->pi->story->dtable->fieldList['title']['name']         = 'title';
$config->pi->story->dtable->fieldList['title']['title']        = $lang->pi->storyTitle;
$config->pi->story->dtable->fieldList['title']['type']         = 'title';
$config->pi->story->dtable->fieldList['title']['link']         = helper::createLink('requirement', 'view', 'storyID={id}');
$config->pi->story->dtable->fieldList['title']['fixed']        = 'left';
$config->pi->story->dtable->fieldList['title']['sortType']     = true;
$config->pi->story->dtable->fieldList['title']['minWidth']     = '342';
$config->pi->story->dtable->fieldList['title']['required']     = 'yes';
$config->pi->story->dtable->fieldList['title']['nestedToggle'] = true;
$config->pi->story->dtable->fieldList['title']['show']         = true;
$config->pi->story->dtable->fieldList['title']['group']        = 1;
$config->pi->story->dtable->fieldList['title']['data-app']     = $app->tab;

$config->pi->story->dtable->fieldList['pri']['name']     = 'pri';
$config->pi->story->dtable->fieldList['pri']['title']    = $lang->priAB;
$config->pi->story->dtable->fieldList['pri']['fixed']    = 'left';
$config->pi->story->dtable->fieldList['pri']['sortType'] = true;
$config->pi->story->dtable->fieldList['pri']['type']     = 'pri';
$config->pi->story->dtable->fieldList['pri']['show']     = true;
$config->pi->story->dtable->fieldList['pri']['group']    = 2;

$config->pi->story->dtable->fieldList['status']['name']      = 'status';
$config->pi->story->dtable->fieldList['status']['title']     = $lang->statusAB;
$config->pi->story->dtable->fieldList['status']['sortType']  = true;
$config->pi->story->dtable->fieldList['status']['type']      = 'status';
$config->pi->story->dtable->fieldList['status']['statusMap'] = $lang->story->statusList + $lang->pi->storyAppendStatusList;
$config->pi->story->dtable->fieldList['status']['show']      = true;
$config->pi->story->dtable->fieldList['status']['group']     = 4;

$config->pi->story->dtable->fieldList['openedBy']['name']     = 'openedBy';
$config->pi->story->dtable->fieldList['openedBy']['title']    = $lang->story->openedByAB;
$config->pi->story->dtable->fieldList['openedBy']['sortType'] = true;
$config->pi->story->dtable->fieldList['openedBy']['type']     = 'user';
$config->pi->story->dtable->fieldList['openedBy']['show']     = true;
$config->pi->story->dtable->fieldList['openedBy']['group']    = 5;

$config->pi->story->dtable->fieldList['openedDate']['name']     = 'openedDate';
$config->pi->story->dtable->fieldList['openedDate']['title']    = $lang->story->openedDate;
$config->pi->story->dtable->fieldList['openedDate']['sortType'] = true;
$config->pi->story->dtable->fieldList['openedDate']['type']     = 'date';
$config->pi->story->dtable->fieldList['openedDate']['group']    = 5;

$config->pi->story->dtable->fieldList['estimate']['name']     = 'estimate';
$config->pi->story->dtable->fieldList['estimate']['title']    = $lang->story->estimateAB;
$config->pi->story->dtable->fieldList['estimate']['sortType'] = true;
$config->pi->story->dtable->fieldList['estimate']['type']     = 'number';
$config->pi->story->dtable->fieldList['estimate']['show']     = true;
$config->pi->story->dtable->fieldList['estimate']['group']    = 5;

$config->pi->story->dtable->fieldList['stage']['name']      = 'stage';
$config->pi->story->dtable->fieldList['stage']['title']     = $lang->story->stageAB;
$config->pi->story->dtable->fieldList['stage']['sortType']  = true;
$config->pi->story->dtable->fieldList['stage']['type']      = 'status';
$config->pi->story->dtable->fieldList['stage']['statusMap'] = $lang->story->stageList;
$config->pi->story->dtable->fieldList['stage']['show']      = true;
$config->pi->story->dtable->fieldList['stage']['group']     = 6;

$config->pi->story->dtable->fieldList['assignedTo']['name']        = 'assignedTo';
$config->pi->story->dtable->fieldList['assignedTo']['title']       = $lang->story->assignedTo;
$config->pi->story->dtable->fieldList['assignedTo']['sortType']    = true;
$config->pi->story->dtable->fieldList['assignedTo']['currentUser'] = $account;
$config->pi->story->dtable->fieldList['assignedTo']['assignLink']  = array('module' => 'story', 'method' => 'assignTo', 'params' => 'storyID={id}');
$config->pi->story->dtable->fieldList['assignedTo']['type']        = 'assign';
$config->pi->story->dtable->fieldList['assignedTo']['show']        = true;
$config->pi->story->dtable->fieldList['assignedTo']['group']       = 6;

$config->pi->story->dtable->fieldList['reviewer']['name']     = 'reviewedBy';
$config->pi->story->dtable->fieldList['reviewer']['title']    = $lang->story->reviewedBy;
$config->pi->story->dtable->fieldList['reviewer']['sortType'] = true;
$config->pi->story->dtable->fieldList['reviewer']['type']     = 'text';
$config->pi->story->dtable->fieldList['reviewer']['show']     = true;
$config->pi->story->dtable->fieldList['reviewer']['align']    = 'center';
$config->pi->story->dtable->fieldList['reviewer']['group']    = 7;

$config->pi->story->dtable->fieldList['product']['name']  = 'product';
$config->pi->story->dtable->fieldList['product']['title'] = $lang->story->product;
$config->pi->story->dtable->fieldList['product']['type']  = 'text';
$config->pi->story->dtable->fieldList['product']['group'] = 8;

$config->pi->story->dtable->fieldList['plan']['name']  = 'plan';
$config->pi->story->dtable->fieldList['plan']['title'] = $lang->story->plan;
$config->pi->story->dtable->fieldList['plan']['type']  = 'category';
$config->pi->story->dtable->fieldList['plan']['group'] = 9;

$config->pi->story->dtable->fieldList['actions']['name']     = 'actions';
$config->pi->story->dtable->fieldList['actions']['title']    = $lang->actions;
$config->pi->story->dtable->fieldList['actions']['fixed']    = 'right';
$config->pi->story->dtable->fieldList['actions']['required'] = 'yes';
$config->pi->story->dtable->fieldList['actions']['width']    = 'auto';
$config->pi->story->dtable->fieldList['actions']['type']     = 'actions';
