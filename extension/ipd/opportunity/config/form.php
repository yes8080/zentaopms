<?php
global $lang, $app;

$config->opportunity->form = new stdclass();

$config->opportunity->form->create = array();
$config->opportunity->form->create['desc']       = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->opportunity->form->create['prevention'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->batchcreate = array();
$config->opportunity->form->batchcreate['execution'] = array('required' => false, 'type' => 'int',    'default' => 0);
$config->opportunity->form->batchcreate['name']      = array('required' => true,  'type' => 'string', 'default' => '', 'base' => true);
$config->opportunity->form->batchcreate['source']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->opportunity->form->batchcreate['impact']    = array('required' => false, 'type' => 'int',    'default' => 3);
$config->opportunity->form->batchcreate['chance']    = array('required' => false, 'type' => 'int',    'default' => 3);
$config->opportunity->form->batchcreate['pri']       = array('required' => false, 'type' => 'int',    'default' => 2);
$config->opportunity->form->batchcreate['desc']      = array('required' => false, 'type' => 'string', 'default' => '');

$config->opportunity->form->edit = array();
$config->opportunity->form->edit['desc']       = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->opportunity->form->edit['prevention'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->opportunity->form->edit['resolution'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->batchedit = array();
$config->opportunity->form->batchedit['id']     = array('required' => true,  'type' => 'int',    'default' => '', 'base' => true);
$config->opportunity->form->batchedit['name']   = array('required' => true,  'type' => 'string', 'default' => '');
$config->opportunity->form->batchedit['source'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->opportunity->form->batchedit['impact'] = array('required' => true,  'type' => 'string', 'default' => '');
$config->opportunity->form->batchedit['chance'] = array('required' => true,  'type' => 'string', 'default' => '');
$config->opportunity->form->batchedit['ratio']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->opportunity->form->batchedit['pri']    = array('required' => false, 'type' => 'string', 'default' => '');

$config->opportunity->form->activate = array();
$config->opportunity->form->activate['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->assign = array();
$config->opportunity->form->assign['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->cancel = array();
$config->opportunity->form->cancel['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->close = array();
$config->opportunity->form->close['resolution'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->hangup = array();
$config->opportunity->form->hangup['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->opportunity->form->track = array();
$config->opportunity->form->track['desc']       = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->opportunity->form->track['prevention'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->opportunity->form->track['resolution'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->opportunity->form->track['comment']    = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
