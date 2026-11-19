<?php
$config->alert->form = new stdClass();
$config->alert->form->create['name']         = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->alert->form->create['objectType']   = array('required' => true,  'type' => 'string');
$config->alert->form->create['alertType']    = array('required' => true,  'type' => 'string');
$config->alert->form->create['alertValue']   = array('required' => true,  'type' => 'int');
$config->alert->form->create['alertLevel']   = array('required' => true,  'type' => 'string');
$config->alert->form->create['notifyMethod'] = array('required' => true,  'type' => 'array', 'filter' => 'join');
$config->alert->form->create['notifyUsers']  = array('required' => true,  'type' => 'array', 'filter' => 'join');
$config->alert->form->edit = $config->alert->form->create;