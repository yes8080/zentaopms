<?php
define('TABLE_AI_TEAMMATE',     '`' . $config->db->prefix . 'ai_teammate`');
define('TABLE_AI_TASK',         '`' . $config->db->prefix . 'ai_task`');
define('TABLE_AI_CHAT',         '`' . $config->db->prefix . 'ai_chat`');
define('TABLE_AI_CHAT_MESSAGE', '`' . $config->db->prefix . 'ai_chat_message`');

define('TABLE_AI_PROCEDURE',        '`' . $config->db->prefix . 'ai_procedure`');
define('TABLE_AI_PROCEDURESTEP',    '`' . $config->db->prefix . 'ai_procedurestep`');
define('TABLE_AI_PROCEDURERUN',     '`' . $config->db->prefix . 'ai_procedurerun`');

$config->objectTables['procedure']    = TABLE_AI_PROCEDURE;
$config->objectTables['procedurerun'] = TABLE_AI_PROCEDURERUN;

$config->enableAITeammate = true;

$config->logonMethods[] = 'aiteammate.uploadavatar';
$config->logonMethods[] = 'aiteammate.cropavatar';
$config->logonMethods[] = 'aiteammate.assignaitask';
$config->logonMethods[] = 'aitask.assignto';
$config->logonMethods[] = 'aitask.cancel';
$config->logonMethods[] = 'aitask.activate';
$config->logonMethods[] = 'aitask.delete';
$config->logonMethods[] = 'aitask.verify';
$config->logonMethods[] = 'aitask.retry';

$config->ajaxDependencies['aiprocedure.ajaxgetinfo']              = 'aiprocedure.design';
$config->ajaxDependencies['aiprocedure.ajaxgetagents']            = 'aiprocedure.design';
$config->ajaxDependencies['aiprocedure.ajaxeditprocedure']        = 'aiprocedure.design';
$config->ajaxDependencies['aiprocedure.ajaxrunprocedure']         = 'aiprocedure.workbench';
$config->ajaxDependencies['aiprocedure.ajaxsaveprocedurerunstep'] = 'aiprocedure.workbench';
$config->ajaxDependencies['aitask.ajaxgetlist']                   = 'aitask.browse';
$config->ajaxDependencies['aitask.ajaxgetmessages']               = 'aitask.browse';
$config->ajaxDependencies['aiprocedure.ajaxstopprocedurerun']     = 'aiprocedure.workbench';

$filter->aitask = new stdClass();
$filter->aitask->browse = new stdClass();
$filter->aitask->browse->cookie['involved'] = 'code';
