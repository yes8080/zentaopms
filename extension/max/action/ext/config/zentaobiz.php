<?php
$config->action->objectNameFields['charter']      = 'name';
$config->action->objectNameFields['baseline']     = 'title';
$config->action->objectNameFields['knowledgelib'] = 'name';
$config->action->objectNameFields['skill']        = 'name';
$config->action->objectNameFields['aiskill']      = 'name';

$config->objectTables['knowledgelib'] = TABLE_AI_KNOWLEDGELIB;
$config->objectTables['skill']        = TABLE_AI_SKILL;
$config->objectTables['aiskill']      = TABLE_AI_SKILL;
