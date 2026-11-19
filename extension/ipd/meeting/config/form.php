<?php
global $lang;
$config->meeting->form = new stdclass();

$config->meeting->form->minutes = array();
$config->meeting->form->minutes['minutes'] = array('required' => false, 'type' => 'string', 'default' => '', 'control' => 'editor');