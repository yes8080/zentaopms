<?php
$config->art->form = new stdclass();
$config->art->form->create = array();
$config->art->form->create['name']      = array('required' => true,  'type' => 'string', 'default' => '');
$config->art->form->create['product']   = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->art->form->create['RTE']       = array('required' => true,  'type' => 'string', 'default' => '');
$config->art->form->create['manager']   = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->create['PO']        = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->create['architect'] = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->create['whitelist'] = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->create['acl']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->art->form->create['team']      = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->create['desc']      = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->art->form->edit = array();
$config->art->form->edit['name']      = array('required' => true,  'type' => 'string', 'default' => '');
$config->art->form->edit['product']   = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->art->form->edit['RTE']       = array('required' => true,  'type' => 'string', 'default' => '');
$config->art->form->edit['manager']   = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->edit['PO']        = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->edit['architect'] = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->edit['acl']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->art->form->edit['whitelist'] = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->edit['team']      = array('required' => false, 'type' => 'array',  'default' => '', 'filter' => 'join');
$config->art->form->edit['desc']      = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->art->form->edit['status']    = array('required' => false, 'type' => 'string', 'default' => '');
