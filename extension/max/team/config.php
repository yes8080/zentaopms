<?php
$config->team->create = new stdclass();
$config->team->create->requiredFields = 'type,manager,name';

$config->team->edit = new stdclass();
$config->team->edit->requiredFields = 'manager,name';

$config->team->actions = new stdclass();
$config->team->actions->view = array();
$config->team->actions->view['mainActions']   = array('enable', 'disband');
$config->team->actions->view['suffixActions'] = array('edit', 'delete');
