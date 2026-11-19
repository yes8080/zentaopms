<?php
$config->ai->timerCycleType      = array('day' => 'day', 'week' => 'week', 'month' => 'month');
$config->ai->timerNotifyMethod   = array('mail', 'message', 'webhook');
$config->ai->timerProjectModules = array('project', 'execution', 'task', 'risk', 'issue', 'opportunity');
$config->ai->timerBatchSize      = 4;
$config->ai->timerDoingTimeout   = 30;

$config->ai->form->timerBasicInfo                   = array();
$config->ai->form->timerBasicInfo['module']         = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->ai->form->timerBasicInfo['operation']      = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->ai->form->timerBasicInfo['cycleType']      = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->ai->form->timerBasicInfo['name']           = array('required' => true,  'type' => 'string', 'filter' => 'trim', 'control' => 'input');
$config->ai->form->timerBasicInfo['model']          = array('type' => 'string', 'filter' => 'trim');
$config->ai->form->timerBasicInfo['desc']           = array('type' => 'string', 'filter' => 'trim', 'control' => 'textarea');
$config->ai->form->timerBasicInfo['notifyTo']       = array('type' => 'array', 'required' => false, 'default' => array());
$config->ai->form->timerBasicInfo['notifyMethods']  = array('type' => 'array', 'required' => false, 'default' => array());
