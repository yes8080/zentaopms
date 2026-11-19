<?php
global $lang;

$config->aiprocedure         = new stdclass();
$config->aiprocedure->create = new stdclass();
$config->aiprocedure->edit   = new stdclass();

$config->aiprocedure->create->requiredFields = 'name,module';
$config->aiprocedure->edit->requiredFields   = 'name,module';

$config->aiprocedure->actions = new stdclass();
$config->aiprocedure->actions->browse = array('design', 'edit', 'unpublish|publish', 'delete');
$config->aiprocedure->actions->view   = array();
$config->aiprocedure->actions->view['mainActions']   = array('design', 'publish', 'unpublish');
$config->aiprocedure->actions->view['suffixActions'] = array('edit', 'delete');

$config->aiprocedure->actionList = array();
$config->aiprocedure->actionList['edit']['icon']         = 'edit';
$config->aiprocedure->actionList['edit']['text']         = $lang->aiprocedure->edit;
$config->aiprocedure->actionList['edit']['hint']         = $lang->aiprocedure->edit;
$config->aiprocedure->actionList['edit']['url']          = array('module' => 'aiprocedure', 'method' => 'edit', 'params' => 'id={id}');
$config->aiprocedure->actionList['edit']['data-toggle']  = 'modal';

$config->aiprocedure->actionList['design']['icon'] = 'design';
$config->aiprocedure->actionList['design']['text'] = $lang->aiprocedure->design;
$config->aiprocedure->actionList['design']['hint'] = $lang->aiprocedure->design;
$config->aiprocedure->actionList['design']['url']  = array('module' => 'aiprocedure', 'method' => 'design', 'params' => 'id={id}');

$config->aiprocedure->actionList['publish']['icon']         = 'publish';
$config->aiprocedure->actionList['publish']['text']         = $lang->aiprocedure->publish;
$config->aiprocedure->actionList['publish']['hint']         = $lang->aiprocedure->publish;
$config->aiprocedure->actionList['publish']['url']          = array('module' => 'aiprocedure', 'method' => 'publish', 'params' => 'id={id}');
$config->aiprocedure->actionList['publish']['className']    = 'ajax-submit';
$config->aiprocedure->actionList['publish']['notLoadModel'] = true;

$config->aiprocedure->actionList['unpublish']['icon']         = 'ban';
$config->aiprocedure->actionList['unpublish']['text']         = $lang->aiprocedure->unpublish;
$config->aiprocedure->actionList['unpublish']['hint']         = $lang->aiprocedure->unpublish;
$config->aiprocedure->actionList['unpublish']['url']          = array('module' => 'aiprocedure', 'method' => 'unpublish', 'params' => 'id={id}');
$config->aiprocedure->actionList['unpublish']['className']    = 'ajax-submit';
$config->aiprocedure->actionList['unpublish']['notLoadModel'] = true;
$config->aiprocedure->actionList['unpublish']['data-confirm'] = $lang->aiprocedure->unpublishNotice;

$config->aiprocedure->actionList['delete']['icon']         = 'trash';
$config->aiprocedure->actionList['delete']['text']         = $lang->delete;
$config->aiprocedure->actionList['delete']['hint']         = $lang->delete;
$config->aiprocedure->actionList['delete']['url']          = array('module' => 'aiprocedure', 'method' => 'delete', 'params' => 'id={id}');
$config->aiprocedure->actionList['delete']['className']    = 'ajax-submit';
$config->aiprocedure->actionList['delete']['data-confirm'] = $lang->aiprocedure->confirmDelete;
$config->aiprocedure->actionList['delete']['notLoadModel'] = true;
