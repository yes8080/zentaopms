<?php
global $app;

$account = $app->user->account ?? '';
$now     = helper::now();

$config->review->form = new stdclass();
$config->review->form->createFlow['objectID']    = array('required' => true,  'type' => 'int',    'default' => 0);
$config->review->form->createFlow['flow']        = array('required' => true,  'type' => 'int',    'default' => 0);
$config->review->form->createFlow['objectType']  = array('required' => false, 'type' => 'string', 'default' => 'deliverable');
$config->review->form->createFlow['relatedBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->review->form->createFlow['relatedDate'] = array('required' => false, 'type' => 'string', 'default' => $now);
$config->review->form->createFlow['extra']       = array('required' => false, 'type' => 'string', 'default' => 'review');

$config->review->form->editFlow['flow']        = array('required' => true,  'type' => 'int',    'default' => 0);
$config->review->form->editFlow['relatedBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->review->form->editFlow['relatedDate'] = array('required' => false, 'type' => 'string', 'default' => $now);

$config->review->form->create['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->review->form->edit['comment']   = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->review->form->assess['opinion'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
