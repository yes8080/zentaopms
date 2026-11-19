<?php
$config->deliverable->form = new stdclass();
$config->deliverable->form->create = array();
$config->deliverable->form->create['name']      = array('type' => 'string', 'required' => true, 'filter' => 'trim');
$config->deliverable->form->create['module']    = array('type' => 'int', 'required' => false);
$config->deliverable->form->create['activity']  = array('type' => 'int', 'required' => false);
$config->deliverable->form->create['trimmable'] = array('type' => 'int', 'required' => false);
$config->deliverable->form->create['trimRule']  = array('type' => 'string', 'required' => false);
$config->deliverable->form->create['desc']      = array('type' => 'string', 'required' => false, 'control' => 'editor');

$config->deliverable->form->edit = array();
$config->deliverable->form->edit['name']      = array('type' => 'string', 'required' => true, 'filter' => 'trim');
$config->deliverable->form->edit['module']    = array('type' => 'int', 'required' => true);
$config->deliverable->form->edit['activity']  = array('type' => 'int', 'required' => false);
$config->deliverable->form->edit['trimmable'] = array('type' => 'int', 'required' => false);
$config->deliverable->form->edit['trimRule']  = array('type' => 'string', 'required' => false);
$config->deliverable->form->edit['desc']      = array('type' => 'string', 'required' => false, 'control' => 'editor');

$config->deliverable->form->batchcreate = array();
$config->deliverable->form->batchcreate['name']      = array('type' => 'string', 'required' => true, 'filter' => 'trim', 'base' => true);
$config->deliverable->form->batchcreate['module']    = array('type' => 'int',    'required' => false);
$config->deliverable->form->batchcreate['template']  = array('type' => 'array',  'required' => false);
$config->deliverable->form->batchcreate['activity']  = array('type' => 'int',    'required' => false);
$config->deliverable->form->batchcreate['trimmable'] = array('type' => 'int',    'required' => false);
$config->deliverable->form->batchcreate['trimRule']  = array('type' => 'string', 'required' => false);

$config->deliverable->form->batchedit = array();
$config->deliverable->form->batchedit['name']      = array('type' => 'string', 'required' => true, 'filter' => 'trim', 'base' => true);
$config->deliverable->form->batchedit['module']    = array('type' => 'int',    'required' => true);
$config->deliverable->form->batchedit['activity']  = array('type' => 'int',    'required' => true);
$config->deliverable->form->batchedit['trimmable'] = array('type' => 'int',    'required' => false);
$config->deliverable->form->batchedit['trimRule']  = array('type' => 'string', 'required' => false);
