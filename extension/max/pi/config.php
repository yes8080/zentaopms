<?php
$config->pi->create = new stdclass();
$config->pi->create->requiredFields = 'name,ART,product,team';

$config->pi->edit = new stdclass();
$config->pi->edit->requiredFields = 'name,ART,product,team';

$config->pi->actions = new stdclass();
$config->pi->actions->view = array();
$config->pi->actions->view['mainActions']   = array('enable', 'disband');
$config->pi->actions->view['suffixActions'] = array('edit', 'delete');

$config->pi->actions->viewcard['mainActions']   = array('finishCard', 'activateCard');
$config->pi->actions->viewcard['suffixActions'] = array('editCard');

$config->pi->defaultFields['linkstory'] = array('id', 'title', 'product', 'plan', 'pri', 'status', 'openedBy', 'assignedTo', 'estimate', 'stage');

$config->pi->editor = new stdclass();
$config->pi->editor->create   = array('id' => 'desc');
$config->pi->editor->edit     = array('id' => 'desc');
$config->pi->editor->close    = array('id' => 'comment');
$config->pi->editor->activate = array('id' => 'desc');
