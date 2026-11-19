<?php
$config->bug->listFields     = "module,project,execution,plan,story,severity,pri,type,os,browser,openedBuild,assignedTo";
$config->bug->sysListFields  = "module,execution,story";
$config->bug->templateFields = "product,branch,module,project,execution,story,title,keywords,severity,pri,type,assignedTo,os,browser,steps,deadline,openedBuild,feedbackBy,notifyEmail";

$config->bug->form->showimport = array();
$config->bug->form->showimport['id']          = array('required' => false, 'type' => 'int',    'base' => true);
$config->bug->form->showimport['branch']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->showimport['module']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->showimport['project']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->showimport['execution']   = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->showimport['story']       = array('required' => false, 'type' => 'int',    'default' => 0);
$config->bug->form->showimport['title']       = array('required' => true,  'type' => 'string', 'filter'  => 'trim');
$config->bug->form->showimport['keywords']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->showimport['severity']    = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->showimport['pri']         = array('required' => false, 'type' => 'int',    'default' => 3);
$config->bug->form->showimport['type']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->showimport['assignedTo']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->showimport['os']          = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->showimport['browser']     = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->bug->form->showimport['steps']       = array('required' => false, 'type' => 'string', 'default' => $lang->bug->tplStep . $lang->bug->tplResult . $lang->bug->tplExpect, 'control' => 'importor');
$config->bug->form->showimport['deadline']    = array('required' => false, 'type' => 'date',   'default' => null);
$config->bug->form->showimport['openedBuild'] = array('required' => true,  'type' => 'array',  'filter'  => 'join');
$config->bug->form->showimport['feedbackBy']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->showimport['notifyEmail'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->showimport['injection']   = array('required' => false, 'type' => 'string', 'default' => '');
$config->bug->form->showimport['identify']    = array('required' => false, 'type' => 'string', 'default' => '');
