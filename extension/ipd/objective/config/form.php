<?php
$config->objective->form = new stdclass();
$config->objective->form->create = array();
$config->objective->form->create['promise']     = array('required' => true,  'type' => 'string', 'default' => 'no');
$config->objective->form->create['name']        = array('required' => true,  'type' => 'string', 'default' => '');
$config->objective->form->create['BV']          = array('required' => false, 'type' => 'int',    'default' => 0);
$config->objective->form->create['AV']          = array('required' => false, 'type' => 'int',    'default' => 0);
$config->objective->form->create['createdDate'] = array('required' => false, 'type' => 'string', 'default' => date('Y-m-d'));

$config->objective->form->edit = array();
$config->objective->form->edit['promise']     = array('required' => true,  'type' => 'string', 'default' => 'no');
$config->objective->form->edit['name']        = array('required' => true,  'type' => 'string', 'default' => '');
$config->objective->form->edit['BV']          = array('required' => false, 'type' => 'int',    'default' => 0);
$config->objective->form->edit['AV']          = array('required' => false, 'type' => 'int',    'default' => 0);
