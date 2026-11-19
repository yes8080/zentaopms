<?php
global $lang;

$config->objective->actionList = array();
$config->objective->actionList['edit']['icon']        = 'edit';
$config->objective->actionList['edit']['text']        = $lang->objective->edit;
$config->objective->actionList['edit']['hint']        = $lang->objective->edit;
$config->objective->actionList['edit']['url']         = array('module' => 'objective', 'method' => 'edit', 'params' => 'objectiveID={id}');
$config->objective->actionList['edit']['data-toggle'] = 'modal';

$config->objective->actionList['link']['icon']        = 'link';
$config->objective->actionList['link']['text']        = $lang->objective->link;
$config->objective->actionList['link']['hint']        = $lang->objective->link;
$config->objective->actionList['link']['url']         = array('module' => 'objective', 'method' => 'link', 'params' => 'id={id}');
$config->objective->actionList['link']['data-toggle'] = 'modal';
$config->objective->actionList['link']['data-size']   = 'lg';

$config->objective->actionList['unlink']['icon']         = 'unlink';
$config->objective->actionList['unlink']['text']         = $lang->objective->unlink;
$config->objective->actionList['unlink']['hint']         = $lang->objective->unlink;
$config->objective->actionList['unlink']['url']          = array('module' => 'objective', 'method' => 'unlink', 'params' => 'id={parent}&unlinkID={id}');
$config->objective->actionList['unlink']['className']    = 'ajax-submit';
$config->objective->actionList['unlink']['data-confirm'] = $lang->objective->notice->confirmUnlink;

$config->objective->actionList['delete']['icon']         = 'trash';
$config->objective->actionList['delete']['text']         = $lang->objective->delete;
$config->objective->actionList['delete']['hint']         = $lang->objective->delete;
$config->objective->actionList['delete']['url']          = array('module' => 'objective', 'method' => 'delete', 'params' => 'objectiveID={id}');
$config->objective->actionList['delete']['className']    = 'ajax-submit';
$config->objective->actionList['delete']['data-confirm'] = $lang->objective->notice->confirmDelete;
