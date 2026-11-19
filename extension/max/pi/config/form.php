<?php
$config->pi->form = new stdclass();
$config->pi->form->create = array();
$config->pi->form->create['name']        = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->create['ART']         = array('required' => true,  'type' => 'int',    'default' => 0);
$config->pi->form->create['product']     = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->pi->form->create['team']        = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->pi->form->create['plan']        = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->create['execution']   = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->create['begin']       = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->create['end']         = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->create['desc']        = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->pi->form->create['acl']         = array('required' => false, 'type' => 'string', 'default' => 'extends');
$config->pi->form->create['whitelist']   = array('required' => false, 'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->pi->form->create['createdDate'] = array('required' => false, 'type' => 'string', 'default' => date('Y-m-d'));

$config->pi->form->close = array();
$config->pi->form->close['closedReason'] = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->close['closedDate']   = array('required' => true,  'type' => 'string', 'default' => date('Y-m-d'));
$config->pi->form->close['closedBy']     = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->close['status']       = array('required' => true,  'type' => 'string', 'default' => 'closed');
$config->pi->form->close['comment']      = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->pi->form->activate = array();
$config->pi->form->activate['activatedDate'] = array('required' => true,  'type' => 'string', 'default' => date('Y-m-d'));
$config->pi->form->activate['activatedBy']   = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->activate['comment']       = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->pi->form->activate['status']        = array('required' => true,  'type' => 'string', 'default' => 'normal');

$config->pi->form->edit = array();
$config->pi->form->edit['name']      = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->edit['product']   = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->pi->form->edit['team']      = array('required' => true,  'type' => 'array',  'default' => array(), 'filter' => 'join');
$config->pi->form->edit['plan']      = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->edit['execution'] = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->edit['begin']     = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->edit['end']       = array('required' => true,  'type' => 'array',  'default' => array());
$config->pi->form->edit['desc']      = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->pi->form->edit['acl']       = array('required' => false, 'type' => 'string', 'default' => 'extends');
$config->pi->form->edit['whitelist'] = array('required' => false, 'type' => 'array',  'default' => array(), 'filter' => 'join');

$config->pi->form->createMilestone = array();
$config->pi->form->createMilestone['name']       = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->createMilestone['lane']       = array('required' => false, 'type' => 'int',    'default' => 0);
$config->pi->form->createMilestone['end']        = array('required' => true,  'type' => 'date',   'default' => '');
$config->pi->form->createMilestone['assignedTo'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->pi->form->createMilestone['status']     = array('required' => true,  'type' => 'string', 'default' => 'normal');

$config->pi->form->createLane = array();
$config->pi->form->createLane['name']  = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->createLane['color'] = array('required' => true,  'type' => 'string', 'default' => '');

$config->pi->form->createCard = array();
$config->pi->form->createCard['name']       = array('required' => true,  'type' => 'string', 'default' => '');
$config->pi->form->createCard['pri']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->pi->form->createCard['estimate']   = array('required' => false, 'type' => 'float',  'default' => '');
$config->pi->form->createCard['lane']       = array('required' => true,  'type' => 'int',    'default' => '');
$config->pi->form->createCard['begin']      = array('required' => false, 'type' => 'date',   'default' => '');
$config->pi->form->createCard['end']        = array('required' => false, 'type' => 'date',   'default' => '');
$config->pi->form->createCard['assignedTo'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->pi->form->createCard['status']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->pi->form->createCard['desc']       = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->pi->form->createCard['progress']   = array('required' => false, 'type' => 'float',  'default' => '');

$config->pi->form->activateCard = array();
$config->pi->form->activateCard['begin']    = array('required' => false, 'type' => 'date',   'default' => '');
$config->pi->form->activateCard['end']      = array('required' => false, 'type' => 'date',   'default' => '');
$config->pi->form->activateCard['desc']     = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->pi->form->activateCard['progress'] = array('required' => false, 'type' => 'float',  'default' => '');

$config->pi->form->setKanban = array();
$config->pi->form->setKanban['fluidBoard']   = array('required' => false, 'type' => 'int', 'default' => '0');
$config->pi->form->setKanban['colWidth']     = array('required' => false, 'type' => 'int', 'default' => '0');
$config->pi->form->setKanban['maxColWidth']  = array('required' => false, 'type' => 'int', 'default' => '0');
$config->pi->form->setKanban['minColWidth']  = array('required' => false, 'type' => 'int', 'default' => '0');
$config->pi->form->setKanban['heightType']   = array('required' => false, 'type' => 'int', 'default' => '0');
$config->pi->form->setKanban['displayCards'] = array('required' => false, 'type' => 'int', 'default' => '0');
