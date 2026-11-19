<?php
global $lang, $app;

$config->risk->form = new stdclass();

$config->risk->form->create = array();
$config->risk->form->create['remedy']     = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->risk->form->create['prevention'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->edit = array();
$config->risk->form->edit['remedy']     = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->risk->form->edit['prevention'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->risk->form->edit['resolution'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->batchcreate = array();
$config->risk->form->batchcreate['execution']   = array('required' => false, 'type' => 'int',    'default' => '');
$config->risk->form->batchcreate['name']        = array('required' => true,  'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['source']      = array('required' => false, 'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['category']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['strategy']    = array('required' => false, 'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['impact']      = array('required' => true,  'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['probability'] = array('required' => true,  'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['rate']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->risk->form->batchcreate['pri']         = array('required' => true,  'type' => 'string', 'default' => '');

$config->risk->form->activate = array();
$config->risk->form->activate['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->assignto = array();
$config->risk->form->assignto['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->cancel = array();
$config->risk->form->cancel['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->close = array();
$config->risk->form->close['resolution'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->hangup = array();
$config->risk->form->hangup['comment'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');

$config->risk->form->track = array();
$config->risk->form->track['prevention'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->risk->form->track['resolution'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
$config->risk->form->track['comment']    = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');
