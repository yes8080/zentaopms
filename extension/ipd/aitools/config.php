<?php
$config->aitools = new stdclass();

$config->aitools->timeout = 30;

$config->aitools->writableTools = array(
    'createZentaoObject',
    'updateZentaoObject',
    'deleteZentaoObject',
    'executeZentaoModuleAction',
);

$config->aitools->moduleAliases = array(
    'report' => 'weekly',
);

include dirname(__FILE__) . '/config/modules.php';