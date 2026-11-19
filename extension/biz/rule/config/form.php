<?php
$config->rule->form = new stdclass();

$config->rule->form->create = array();
$config->rule->form->create['name']          = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->rule->form->create['type']          = array('required' => true,  'type' => 'string');
$config->rule->form->create['workflowGroup'] = array('required' => false, 'type' => 'array', 'filter' => 'join');
$config->rule->form->create['method']        = array('required' => false, 'type' => 'string');

$config->rule->form->edit = $config->rule->form->create;
$config->rule->form->copy = $config->rule->form->create;

$config->rule->form->notify = array();
$config->rule->form->notify['notifyUsers']  = array('required' => false,  'type' => 'array', 'filter' => 'join');
$config->rule->form->notify['notifyMethod'] = array('required' => false,  'type' => 'string');

$config->rule->form->saveWhen = array();
$config->rule->form->saveWhen['objectType'] = array('required' => true, 'type' => 'string');
$config->rule->form->saveWhen['action']     = array('required' => true, 'type' => 'string');
