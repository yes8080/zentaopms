<?php
global $app;

$config->aiprocedure->form = new stdclass();

$config->aiprocedure->form->create = array();
$config->aiprocedure->form->create['name']        = array('required' => true,  'type' => 'string',   'filter' => 'trim');
$config->aiprocedure->form->create['module']      = array('required' => true,  'type' => 'string',   'filter' => 'trim');
$config->aiprocedure->form->create['desc']        = array('required' => false, 'type' => 'string',   'default' => '', 'filter' => 'trim');
$config->aiprocedure->form->create['status']      = array('required' => false, 'type' => 'string',   'default' => 'draft');
$config->aiprocedure->form->create['createdBy']   = array('required' => false, 'type' => 'string',   'default' => isset($app->user->account) ? $app->user->account : '');
$config->aiprocedure->form->create['createdDate'] = array('required' => false, 'type' => 'datetime', 'default' => helper::now());

$config->aiprocedure->form->edit = array();
$config->aiprocedure->form->edit['name']       = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->aiprocedure->form->edit['module']     = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->aiprocedure->form->edit['desc']       = array('required' => false, 'type' => 'string', 'default' => '', 'filter' => 'trim');
$config->aiprocedure->form->edit['editedBy']   = array('required' => false, 'type' => 'string',   'default' => isset($app->user->account) ? $app->user->account : '');
$config->aiprocedure->form->edit['editedDate'] = array('required' => false, 'type' => 'datetime', 'default' => helper::now());
