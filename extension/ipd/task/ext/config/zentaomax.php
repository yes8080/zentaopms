<?php
$config->task->form->create['design']      = array('type' => 'int',   'required' => false, 'default' => 0);
$config->task->form->create['deliverable'] = array('type' => 'array', 'required' => false, 'default' => array(), 'filter' => 'join');

$config->task->form->edit['design']      = array('type' => 'int',   'required' => false, 'default' => 0);
$config->task->form->edit['deliverable'] = array('type' => 'array', 'required' => false, 'default' => array(), 'filter' => 'join');

$config->task->form->close['deliverable'] = array('type' => 'array', 'required' => false, 'default' => array());

$config->task->form->batchcreate['deliverable']     = array('type' => 'array', 'required' => false, 'default' => array(), 'filter' => 'join');
$config->task->form->batchcreate['fromDeliverable'] = array('type' => 'int',   'required' => false, 'default' => 0);

$config->task->form->batchedit['deliverable'] = array('type' => 'array', 'required' => false, 'default' => array(), 'filter' => 'join');

$config->task->form->autoSchedule = array();
$config->task->form->autoSchedule['id']         = array('type' => 'int',  'required' => false, 'base' => true);
$config->task->form->autoSchedule['estStarted'] = array('type' => 'date', 'required' => false, 'default' => null);
$config->task->form->autoSchedule['deadline']   = array('type' => 'date', 'required' => false, 'default' => null);

global $app;
$app->loadLang('project');
$app->loadLang('deliverable');
$app->loadLang('review');

$config->task->deliverableActionList = array();
$config->task->deliverableActionList['submitReview']['icon']        = 'sub-review';
$config->task->deliverableActionList['submitReview']['hint']        = $lang->project->submitDeliverable;
$config->task->deliverableActionList['submitReview']['text']        = $lang->project->submitDeliverable;
$config->task->deliverableActionList['submitReview']['url']         = array('module' => 'review', 'method' => 'submit', 'params' => 'reviewID={review}&from=task');
$config->task->deliverableActionList['submitReview']['data-toggle'] = 'modal';

$config->task->deliverableActionList['recallDeliverable']['icon']         = 'back';
$config->task->deliverableActionList['recallDeliverable']['hint']         = $lang->project->recallDeliverable;
$config->task->deliverableActionList['recallDeliverable']['text']         = $lang->project->recallDeliverable;
$config->task->deliverableActionList['recallDeliverable']['url']          = array('module' => 'review', 'method' => 'recall', 'params' => 'reviewID={review}');
$config->task->deliverableActionList['recallDeliverable']['className']    = 'ajax-submit';
$config->task->deliverableActionList['recallDeliverable']['data-confirm'] = $lang->review->confirmRecall;

$config->task->deliverableActionList['reviewDeliverable']['icon']        = 'glasses';
$config->task->deliverableActionList['reviewDeliverable']['hint']        = $lang->project->reviewDeliverable;
$config->task->deliverableActionList['reviewDeliverable']['text']        = $lang->project->reviewDeliverable;
$config->task->deliverableActionList['reviewDeliverable']['url']         = array('module' => 'review', 'method' => 'assess', 'params' => 'reviewID={review}');

$config->task->deliverableActionList['editDeliverable']['icon']        = 'edit';
$config->task->deliverableActionList['editDeliverable']['hint']        = $lang->project->editDeliverable;
$config->task->deliverableActionList['editDeliverable']['text']        = $lang->project->editDeliverable;
$config->task->deliverableActionList['editDeliverable']['url']         = array('module' => 'project', 'method' => 'deliverable', 'params' => 'id={id}');
$config->task->deliverableActionList['editDeliverable']['data-toggle'] = 'modal';

$config->task->deliverableActionList['deleteDeliverable']['icon']         = 'trash';
$config->task->deliverableActionList['deleteDeliverable']['hint']         = $lang->project->deleteDeliverable;
$config->task->deliverableActionList['deleteDeliverable']['text']         = $lang->project->deleteDeliverable;
$config->task->deliverableActionList['deleteDeliverable']['url']          = array('module' => 'project', 'method' => 'deleteDeliverable', 'params' => 'id={id}&from=task');
$config->task->deliverableActionList['deleteDeliverable']['className']    = 'ajax-submit';
$config->task->deliverableActionList['deleteDeliverable']['data-confirm'] = $lang->project->confirmDeleteDeliverable;

$config->task->deliverable = new stdclass();
$config->task->deliverable->dtable = new stdclass();
$config->task->deliverable->dtable->fieldList = array();

$config->task->deliverable->dtable->fieldList['name']['title']    = $lang->deliverable->name;
$config->task->deliverable->dtable->fieldList['name']['name']     = 'name';
$config->task->deliverable->dtable->fieldList['name']['type']     = 'text';
$config->task->deliverable->dtable->fieldList['name']['width']    = '136';
$config->task->deliverable->dtable->fieldList['name']['fixed']    = 'left';
$config->task->deliverable->dtable->fieldList['name']['show']     = true;
$config->task->deliverable->dtable->fieldList['name']['sortType'] = false;

$config->task->deliverable->dtable->fieldList['id']['title']    = $lang->idAB;
$config->task->deliverable->dtable->fieldList['id']['name']     = 'id';
$config->task->deliverable->dtable->fieldList['id']['fixed']    = 'left';
$config->task->deliverable->dtable->fieldList['id']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['id']['group']    = 1;

$config->task->deliverable->dtable->fieldList['title']['title']    = $lang->deliverable->title;
$config->task->deliverable->dtable->fieldList['title']['name']     = 'title';
$config->task->deliverable->dtable->fieldList['title']['type']     = 'title';
$config->task->deliverable->dtable->fieldList['title']['width']    = '276';
$config->task->deliverable->dtable->fieldList['title']['fixed']    = 'left';
$config->task->deliverable->dtable->fieldList['title']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['title']['link']     = array('module' => 'project', 'method' => 'viewDeliverable', 'params' => 'id={id}');

$config->task->deliverable->dtable->fieldList['version']['title']    = $lang->deliverable->version;
$config->task->deliverable->dtable->fieldList['version']['name']     = 'version';
$config->task->deliverable->dtable->fieldList['version']['type']     = 'text';
$config->task->deliverable->dtable->fieldList['version']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['version']['show']     = true;

$config->task->deliverable->dtable->fieldList['versionStatus']['title']    = $lang->deliverable->versionStatus;
$config->task->deliverable->dtable->fieldList['versionStatus']['name']     = 'versionStatus';
$config->task->deliverable->dtable->fieldList['versionStatus']['type']     = 'text';
$config->task->deliverable->dtable->fieldList['versionStatus']['map']      = $lang->deliverable->versionStatusList;
$config->task->deliverable->dtable->fieldList['versionStatus']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['versionStatus']['show']     = true;

$config->task->deliverable->dtable->fieldList['isBaseline']['title']    = $lang->deliverable->isBaseline;
$config->task->deliverable->dtable->fieldList['isBaseline']['name']     = 'isBaseline';
$config->task->deliverable->dtable->fieldList['isBaseline']['type']     = 'category';
$config->task->deliverable->dtable->fieldList['isBaseline']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['isBaseline']['map']      = $lang->deliverable->baselineList;
$config->task->deliverable->dtable->fieldList['isBaseline']['width']    = '90';
$config->task->deliverable->dtable->fieldList['isBaseline']['show']     = true;

$config->task->deliverable->dtable->fieldList['status']['title']     = $lang->deliverable->reviewStatus;
$config->task->deliverable->dtable->fieldList['status']['name']      = 'status';
$config->task->deliverable->dtable->fieldList['status']['type']      = 'status';
$config->task->deliverable->dtable->fieldList['status']['width']     = '140';
$config->task->deliverable->dtable->fieldList['status']['align']     = 'left';
$config->task->deliverable->dtable->fieldList['status']['sortType']  = false;
$config->task->deliverable->dtable->fieldList['status']['show']      = true;

$config->task->deliverable->dtable->fieldList['submittedBy']['title']    = $lang->project->submitedBy;
$config->task->deliverable->dtable->fieldList['submittedBy']['name']     = 'submittedBy';
$config->task->deliverable->dtable->fieldList['submittedBy']['type']     = 'user';
$config->task->deliverable->dtable->fieldList['submittedBy']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['submittedBy']['show']     = true;
$config->task->deliverable->dtable->fieldList['submittedBy']['width']    = '120';

$config->task->deliverable->dtable->fieldList['submittedDate']['title']    = $lang->project->submitedDate;
$config->task->deliverable->dtable->fieldList['submittedDate']['name']     = 'submittedDate';
$config->task->deliverable->dtable->fieldList['submittedDate']['type']     = 'datetime';
$config->task->deliverable->dtable->fieldList['submittedDate']['sortType'] = false;
$config->task->deliverable->dtable->fieldList['submittedDate']['show']     = true;
$config->task->deliverable->dtable->fieldList['submittedDate']['width']    = '120';

$config->task->deliverable->dtable->fieldList['actions']['title']    = $lang->actions;
$config->task->deliverable->dtable->fieldList['actions']['name']     = 'actions';
$config->task->deliverable->dtable->fieldList['actions']['type']     = 'actions';
$config->task->deliverable->dtable->fieldList['actions']['fixed']    = 'right';
$config->task->deliverable->dtable->fieldList['actions']['width']    = '100px';
$config->task->deliverable->dtable->fieldList['actions']['list']     = $config->task->deliverableActionList;
$config->task->deliverable->dtable->fieldList['actions']['menu']     = array('submitReview|recallDeliverable', 'reviewDeliverable', 'editDeliverable', 'deleteDeliverable');
$config->task->deliverable->dtable->fieldList['actions']['sortType'] = false;

$config->task->importDeliverable = new stdclass();
$config->task->importDeliverable->dtable = new stdclass();
$config->task->importDeliverable->dtable->fieldList['name']['title']    = $lang->deliverable->name;
$config->task->importDeliverable->dtable->fieldList['name']['name']     = 'name';
$config->task->importDeliverable->dtable->fieldList['name']['type']     = 'checkID';
$config->task->importDeliverable->dtable->fieldList['name']['width']    = '136';
$config->task->importDeliverable->dtable->fieldList['name']['fixed']    = 'left';
$config->task->importDeliverable->dtable->fieldList['name']['show']     = true;
$config->task->importDeliverable->dtable->fieldList['name']['sortType'] = false;

$config->task->importDeliverable->dtable->fieldList['activity']['title']    = $lang->deliverable->activity;
$config->task->importDeliverable->dtable->fieldList['activity']['name']     = 'activity';
$config->task->importDeliverable->dtable->fieldList['activity']['type']     = 'category';
$config->task->importDeliverable->dtable->fieldList['activity']['sortType'] = true;
$config->task->importDeliverable->dtable->fieldList['activity']['show']     = true;
$config->task->importDeliverable->dtable->fieldList['activity']['group']    = 'activity';

$config->task->importDeliverable->dtable->fieldList['stage']['title']    = $lang->deliverable->when;
$config->task->importDeliverable->dtable->fieldList['stage']['name']     = 'stage';
$config->task->importDeliverable->dtable->fieldList['stage']['type']     = 'category';
$config->task->importDeliverable->dtable->fieldList['stage']['sortType'] = false;
$config->task->importDeliverable->dtable->fieldList['stage']['width']    = '120';
$config->task->importDeliverable->dtable->fieldList['stage']['show']     = true;
$config->task->importDeliverable->dtable->fieldList['stage']['group']    = 'stage';

$config->task->importDeliverable->dtable->fieldList['required']['title']    = $lang->deliverable->required;
$config->task->importDeliverable->dtable->fieldList['required']['name']     = 'required';
$config->task->importDeliverable->dtable->fieldList['required']['type']     = 'category';
$config->task->importDeliverable->dtable->fieldList['required']['map']      = $lang->deliverable->requiredList;
$config->task->importDeliverable->dtable->fieldList['required']['sortType'] = false;
$config->task->importDeliverable->dtable->fieldList['required']['width']    = '100';
$config->task->importDeliverable->dtable->fieldList['required']['show']     = true;
$config->task->importDeliverable->dtable->fieldList['required']['group']    = 'required';

$config->task->importDeliverable->dtable->fieldList['desc']['title']    = $lang->deliverable->desc;
$config->task->importDeliverable->dtable->fieldList['desc']['name']     = 'desc';
$config->task->importDeliverable->dtable->fieldList['desc']['type']     = 'html';
$config->task->importDeliverable->dtable->fieldList['desc']['sortType'] = false;
$config->task->importDeliverable->dtable->fieldList['desc']['width']    = '200';
$config->task->importDeliverable->dtable->fieldList['desc']['show']     = true;
$config->task->importDeliverable->dtable->fieldList['desc']['group']    = 'desc';
