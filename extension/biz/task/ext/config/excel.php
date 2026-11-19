<?php
$config->task->listFields     = "module,assignedTo,mode,story,pri,type";
$config->task->sysListFields  = "module,story";
$config->task->templateFields = "module,story,assignedTo,mode,level,name,desc,type,pri,estimate,estStarted,deadline";

$config->task->exportFields = '
    id, project, execution, module, story, fromBug, level,
    name, desc, parent,
    type, pri, estStarted, realStarted, deadline, status,estimate, consumed, left,
    mailto, progress, mode,
    openedBy, openedDate, assignedTo, assignedDate,
    finishedBy, finishedDate, canceledBy, canceledDate,
    closedBy, closedDate, closedReason,
    lastEditedBy, lastEditedDate,files
    ';

$config->task->cascade = array('story' => 'module');

$config->task->form->showimport = array();
$config->task->form->showimport['id']         = array('required' => false, 'type' => 'int',    'default' => 0);
$config->task->form->showimport['module']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->task->form->showimport['story']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->task->form->showimport['assignedTo'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->task->form->showimport['mode']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->task->form->showimport['level']      = array('required' => false, 'type' => 'string', 'default' => '');
$config->task->form->showimport['name']       = array('required' => true,  'type' => 'string', 'default' => '', 'filter' => 'trim', 'base' => true);
$config->task->form->showimport['desc']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->task->form->showimport['type']       = array('required' => true,  'type' => 'string', 'default' => '');
$config->task->form->showimport['pri']        = array('required' => false, 'type' => 'int',    'default' => 0);
$config->task->form->showimport['estimate']   = array('required' => false, 'type' => 'float',  'default' => 0);
$config->task->form->showimport['estStarted'] = array('required' => false, 'type' => 'date',   'default' => null);
$config->task->form->showimport['deadline']   = array('required' => false, 'type' => 'date',   'default' => null);
