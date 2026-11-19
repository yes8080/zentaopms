<?php

$lang->aichat->chatNotFound            = 'Chat not found.';
$lang->aichat->saveChatFailed          = 'Failed to save chat.';
$lang->aichat->chatNotExistsInExternal = 'Chat not created in ZAI.';
$lang->aichat->createExternalChatFailed = 'Failed to create AI chat. Please ensure ZAI is configured correctly and check the API key and parameters.';

/* Agent global tools: */
$lang->aichat->globalTools = [];

$lang->aichat->globalTools['complete'] = [];
$lang->aichat->globalTools['complete']['name']        = 'complete';
$lang->aichat->globalTools['complete']['description'] = 'Mark the current task as completed.';
$lang->aichat->globalTools['complete']['parameters']  = ['type' => 'object', 'properties' => ['summary' => ['type' => 'string', 'description' => 'Task summary.']]];

$lang->aichat->globalTools['fail'] = [];
$lang->aichat->globalTools['fail']['name']        = 'fail';
$lang->aichat->globalTools['fail']['description'] = 'Mark the current task as failed.';
$lang->aichat->globalTools['fail']['parameters']  = ['type' => 'object', 'properties' => ['reason' => ['type' => 'string', 'description' => 'Reason for task failure.']]];

$lang->aichat->toolResults = [];
$lang->aichat->toolResults['complete'] = 'Task executed successfully';
$lang->aichat->toolResults['fail']     = 'Task executed failed';
$lang->aichat->completeToolReturn      = 'Task marked as completed. Please output the full final result in your reply.';
$lang->aichat->failToolReturn          = 'Task marked as failed.';

$lang->aichat->agentToolResult        = "ZenTao Agent \"%s\" Execution result";
$lang->aichat->agentResultTitleDesc   = 'Solution title, if no suitable title can be omitted';
$lang->aichat->agentResultSummaryDesc  = 'Explanation of the changes in the data of the solution, explain the changed attributes as accurately as possible.';

