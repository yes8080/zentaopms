<?php
$config->art->create = new stdclass();
$config->art->create->requiredFields = 'name,product,RTE';

$config->art->edit = new stdclass();
$config->art->edit->requiredFields = 'name,product,RTE';

$config->art->actions = new stdclass();
$config->art->actions->view = array();
$config->art->actions->view['mainActions']   = array('createPI', 'activate', 'close');
$config->art->actions->view['suffixActions'] = array('edit', 'delete');
