<?php
$config->team->form = new stdclass();
$config->team->form->create = array();
$config->team->form->create['type']        = array('required' => true,  'type' => 'string', 'default' => 'parent');
$config->team->form->create['parent']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->team->form->create['name']        = array('required' => true,  'type' => 'string', 'default' => '');
$config->team->form->create['manager']     = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->team->form->create['slogan']      = array('required' => false, 'type' => 'string', 'default' => '');
$config->team->form->create['declaration'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->team->form->edit = array();
$config->team->form->edit['parent']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->team->form->edit['name']        = array('required' => true,  'type' => 'string', 'default' => '');
$config->team->form->edit['manager']     = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->team->form->edit['slogan']      = array('required' => false, 'type' => 'string', 'default' => '');
$config->team->form->edit['declaration'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->team->form->addMember = array();
$config->team->form->addMember['members'] = array('required' => true, 'type' => 'array', 'default' => '');
