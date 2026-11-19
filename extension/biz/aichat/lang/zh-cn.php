<?php

$lang->aichat->chatNotFound            = '对话不存在。';
$lang->aichat->saveChatFailed          = '保存对话失败。';
$lang->aichat->chatNotExistsInExternal = '未在ZAI中创建对话。';
$lang->aichat->createExternalChatFailed = '创建AI对话失败，请确保ZAI配置正确，检查API密钥和参数。';

/* 智能体全局工具： */
$lang->aichat->globalTools = [];

$lang->aichat->globalTools['complete'] = [];
$lang->aichat->globalTools['complete']['name']        = 'complete';
$lang->aichat->globalTools['complete']['description'] = '标记当前任务已完成。';
$lang->aichat->globalTools['complete']['parameters']  = ['type' => 'object', 'properties' => ['summary' => ['type' => 'string', 'description' => '任务总结。']]];

$lang->aichat->globalTools['fail'] = [];
$lang->aichat->globalTools['fail']['name']        = 'fail';
$lang->aichat->globalTools['fail']['description'] = '标记当前任务失败。';
$lang->aichat->globalTools['fail']['parameters']  = ['type' => 'object', 'properties' => ['reason' => ['type' => 'string', 'description' => '任务失败原因。']]];

$lang->aichat->toolResults = [];
$lang->aichat->toolResults['complete'] = '任务执行成功';
$lang->aichat->toolResults['fail']     = '任务执行失败';
$lang->aichat->completeToolReturn      = '任务已标记完成。请在回复中输出完整的最终结果。';
$lang->aichat->failToolReturn          = '任务已标记失败。';

$lang->aichat->agentToolResult        = "禅道智能体“%s”执行结果";
$lang->aichat->agentResultTitleDesc   = '方案标题，如果没有合适标题可以省略';
$lang->aichat->agentResultSummaryDesc  = '对方案中数据的变化进行解释，尽量对变化的属性分别进行说明。';

