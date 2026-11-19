<?php
global $lang;
$config->issue->form = new stdclass();
$config->issue->form->batchcreate = array();
$config->issue->form->batchcreate['execution']  = array('name' => 'execution',  'label' => $lang->issue->execution,  'control' => 'picker',         'required' => false, 'width' => '150px', 'type' => 'int',    'default' => 0);
$config->issue->form->batchcreate['title']      = array('name' => 'title',      'label' => $lang->issue->title,      'control' => 'input',          'required' => true,  'width' => '150px', 'type' => 'string', 'default' => '', 'base' => true);
$config->issue->form->batchcreate['type']       = array('name' => 'type',       'label' => $lang->issue->type,       'control' => 'picker',         'required' => true,  'width' => '120px', 'type' => 'string', 'default' => '', 'items' => $lang->issue->typeList);
$config->issue->form->batchcreate['severity']   = array('name' => 'severity',   'label' => $lang->issue->severity,   'control' => 'severityPicker', 'required' => true,  'width' => '120px', 'type' => 'int',    'default' => 0, 'items' => $lang->issue->severityList);
$config->issue->form->batchcreate['desc']       = array('name' => 'desc',       'label' => $lang->issue->desc,       'control' => 'textarea',       'required' => false, 'width' => '150px', 'type' => 'string', 'default' => '');
$config->issue->form->batchcreate['pri']        = array('name' => 'pri',        'label' => $lang->issue->pri,        'control' => 'priPicker',      'required' => false, 'width' => '100px', 'type' => 'int',    'default' => 0, 'items' => $lang->issue->priList);
$config->issue->form->batchcreate['deadline']   = array('name' => 'deadline',   'label' => $lang->issue->deadline,   'control' => 'datePicker',     'required' => false, 'width' => '120px', 'type' => 'date',   'default' => null);
$config->issue->form->batchcreate['assignedTo'] = array('name' => 'assignedTo', 'label' => $lang->issue->assignedTo, 'control' => 'picker',         'required' => false, 'width' => '120px', 'type' => 'string', 'default' => '');
$config->issue->form->batchcreate['owner']      = array('name' => 'owner',      'label' => $lang->issue->owner,      'control' => 'picker',         'required' => false, 'width' => '120px', 'type' => 'string', 'default' => '');

$config->issue->form->confirm = array();
$config->issue->form->confirm['desc'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->storyform = array();
$config->issue->form->storyform['spec']   = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->issue->form->storyform['verify'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->cancel = array();
$config->issue->form->cancel['desc'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->close = array();
$config->issue->form->close['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->resolveform = array();
$config->issue->form->resolveform['resolutionComment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->taskform = array();
$config->issue->form->taskform['desc'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->resolve = array();
$config->issue->form->resolve['resolutionComment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->assignto = array();
$config->issue->form->assignto['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->create = array();
$config->issue->form->create['desc'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->edit = array();
$config->issue->form->edit['desc'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->issue->form->bugform = array();
$config->issue->form->bugform['steps'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');