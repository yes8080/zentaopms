<?php
global $lang;
$now = helper::now();

$config->feedback->form = new stdclass();

$config->feedback->form->create = array();
$config->feedback->form->create['desc'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->edit = array();
$config->feedback->form->edit['desc'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->assignTo = array();
$config->feedback->form->assignTo['assignedTo']   = array('type' => 'string', 'default' => '');
$config->feedback->form->assignTo['assignedDate'] = array('type' => 'date',   'default' => $now);
$config->feedback->form->assignTo['editedBy']     = array('type' => 'string', 'default' => '');
$config->feedback->form->assignTo['editedDate']   = array('type' => 'date',   'default' => $now);
$config->feedback->form->assignTo['mailto']       = array('type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->feedback->form->assignTo['comment']      = array('type' => 'string', 'default' => '',        'control' => 'editor');

$config->feedback->form->batchcreate['module']      = array('label' => $lang->feedback->module,      'name' => 'module',      'type' => 'int',    'control' => array('control' => 'picker', 'required' => true), 'required' => false, 'width' => '200px', 'default' => 0, 'ditto' => true);
$config->feedback->form->batchcreate['title']       = array('label' => $lang->feedback->title,       'name' => 'title',       'type' => 'string', 'control' => 'text',      'required' => true, 'width' => '240px', 'default' => '', 'filter'  => 'trim', 'base' => true);
$config->feedback->form->batchcreate['desc']        = array('label' => $lang->feedback->desc,        'name' => 'desc',        'type' => 'string', 'control' => 'textarea',  'required' => false, 'width' => '160px', 'default' => '');
$config->feedback->form->batchcreate['public']      = array('label' => $lang->feedback->public,      'name' => 'public',      'type' => 'int',    'control' => array('control' => 'radioList', 'inline' => true), 'required' => false, 'width' => '100px', 'defalue' => 1, 'value' => '1', 'items' => $lang->feedback->publicListAB);
$config->feedback->form->batchcreate['pri']         = array('label' => $lang->feedback->pri,         'name' => 'pri',         'type' => 'int',    'control' => 'priPicker', 'required' => false, 'width' => '120px', 'default' => 3, 'value' => '3', 'ditto' => true, 'items' => array_filter($lang->feedback->priList));
$config->feedback->form->batchcreate['type']        = array('label' => $lang->feedback->type,        'name' => 'type',        'type' => 'string', 'control' => 'picker',    'required' => false, 'width' => '160px', 'default' => '', 'ditto' => true, 'items' => $lang->feedback->typeList);
$config->feedback->form->batchcreate['feedbackBy']  = array('label' => $lang->feedback->feedbackBy,  'name' => 'feedbackBy',  'type' => 'string', 'control' => 'text',      'required' => false, 'width' => '160px', 'default' => '');
$config->feedback->form->batchcreate['source']      = array('label' => $lang->feedback->source,      'name' => 'source',      'type' => 'string', 'control' => 'text',      'required' => false, 'width' => '160px', 'default' => '');
$config->feedback->form->batchcreate['notifyEmail'] = array('label' => $lang->feedback->notifyEmail, 'name' => 'notifyEmail', 'type' => 'string', 'control' => 'text',      'required' => false, 'width' => '160px', 'default' => '');
$config->feedback->form->batchcreate['keywords']    = array('label' => $lang->feedback->keywords,    'name' => 'keywords',    'type' => 'string', 'control' => 'text',      'required' => false, 'width' => '160px', 'default' => '');
$config->feedback->form->batchcreate['mailto']      = array('label' => $lang->feedback->mailto,      'name' => 'mailto',      'type' => 'array',  'control' => 'picker',    'required' => false, 'width' => '200px', 'default' => array(''), 'multiple' => true, 'filter' => 'join');

$config->feedback->form->batchEdit['product']    = array('label' => $lang->feedback->product,    'type' => 'int',    'required' => false, 'default' => 0);
$config->feedback->form->batchEdit['module']     = array('label' => $lang->feedback->module,     'type' => 'int',    'required' => false, 'default' => 0);
$config->feedback->form->batchEdit['title']      = array('label' => $lang->feedback->title,      'type' => 'string', 'required' => false, 'default' => '');
$config->feedback->form->batchEdit['assignedTo'] = array('label' => $lang->feedback->assignedTo, 'type' => 'string', 'required' => false, 'default' => '');

$config->feedback->form->showimport = array();
$config->feedback->form->showimport['id']           = array('required' => false, 'type' => 'int',    'default' => 0, 'layout' => false);
$config->feedback->form->showimport['product']      = array('required' => true,  'type' => 'int',    'default' => 0);
$config->feedback->form->showimport['module']       = array('required' => false, 'type' => 'int',    'default' => 0);
$config->feedback->form->showimport['type']         = array('required' => false, 'type' => 'string', 'default' => '');
$config->feedback->form->showimport['title']        = array('required' => true,  'type' => 'string', 'default' => '', 'base' => true);
$config->feedback->form->showimport['pri']          = array('required' => false, 'type' => 'int',    'default' => 3);
$config->feedback->form->showimport['desc']         = array('required' => false, 'type' => 'string', 'default' => '');
$config->feedback->form->showimport['source']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->feedback->form->showimport['feedbackBy']   = array('required' => false, 'type' => 'string', 'default' => '');
$config->feedback->form->showimport['notifyEmail']  = array('required' => false, 'type' => 'string', 'default' => '');
$config->feedback->form->showimport['public']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->feedback->form->showimport['notify']       = array('required' => false, 'type' => 'string', 'default' => '');

$config->feedback->form->review = array();
$config->feedback->form->review['comment'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->activate = array();
$config->feedback->form->activate['comment'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->close = array();
$config->feedback->form->close['comment'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->ask = array();
$config->feedback->form->ask['comment'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->reply = array();
$config->feedback->form->reply['comment'] = array('type' => 'string', 'default' => '', 'control' => 'editor');

$config->feedback->form->comment = array();
$config->feedback->form->comment['comment'] = array('type' => 'string', 'default' => '', 'control' => 'editor');
