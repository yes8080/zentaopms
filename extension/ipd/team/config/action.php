<?php
global $lang;

$config->team->actionList = array();
$config->team->actionList['edit']['icon']        = 'edit';
$config->team->actionList['edit']['text']        = $lang->team->edit;
$config->team->actionList['edit']['hint']        = $lang->team->edit;
$config->team->actionList['edit']['url']         = array('module' => 'team', 'method' => 'edit', 'params' => 'teamID={id}');
$config->team->actionList['edit']['data-toggle'] = 'modal';

$config->team->actionList['enable']['icon']        = 'magic';
$config->team->actionList['enable']['text']        = $lang->team->enable;
$config->team->actionList['enable']['hint']        = $lang->team->enable;
$config->team->actionList['enable']['url']         = array('module' => 'team', 'method' => 'enable', 'params' => 'teamID={id}');
$config->team->actionList['enable']['data-toggle'] = 'modal';

$config->team->actionList['disband']['icon']      = 'unlink';
$config->team->actionList['disband']['text']      = $lang->team->disband;
$config->team->actionList['disband']['hint']      = $lang->team->disband;
$config->team->actionList['disband']['url']       = array('module' => 'team', 'method' => 'disband', 'params' => 'teamID={id}');
$config->team->actionList['disband']['className'] = 'ajax-submit';

$config->team->actionList['delete']['icon']      = 'trash';
$config->team->actionList['delete']['text']      = $lang->team->delete;
$config->team->actionList['delete']['hint']      = $lang->team->delete;
$config->team->actionList['delete']['url']       = array('module' => 'team', 'method' => 'delete', 'params' => 'teamID={id}');
$config->team->actionList['delete']['className'] = 'ajax-submit';
