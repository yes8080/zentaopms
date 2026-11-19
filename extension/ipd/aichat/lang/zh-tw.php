<?php

$lang->aichat->chatNotFound            = '對話不存在。';
$lang->aichat->saveChatFailed          = '保存對話失敗。';
$lang->aichat->chatNotExistsInExternal = '未在ZAI中創建對話。';
$lang->aichat->createExternalChatFailed = '創建AI對話失敗，請確保ZAI配置正確，檢查API密鑰和參數。';

/* 智能體全局工具： */
$lang->aichat->globalTools = [];

$lang->aichat->globalTools['complete'] = [];
$lang->aichat->globalTools['complete']['name']        = 'complete';
$lang->aichat->globalTools['complete']['description'] = '標記當前任務已完成。';
$lang->aichat->globalTools['complete']['parameters']  = ['type' => 'object', 'properties' => ['summary' => ['type' => 'string', 'description' => '任務總結。']]];

$lang->aichat->globalTools['fail'] = [];
$lang->aichat->globalTools['fail']['name']        = 'fail';
$lang->aichat->globalTools['fail']['description'] = '標記當前任務失敗。';
$lang->aichat->globalTools['fail']['parameters']  = ['type' => 'object', 'properties' => ['reason' => ['type' => 'string', 'description' => '任務失敗原因。']]];

$lang->aichat->toolResults = [];
$lang->aichat->toolResults['complete'] = '任務執行成功';
$lang->aichat->toolResults['fail']     = '任務執行失敗';
$lang->aichat->completeToolReturn      = '任務已標記完成。請在回覆中輸出完整的最終結果。';
$lang->aichat->failToolReturn          = '任務已標記失敗。';

$lang->aichat->agentToolResult        = "禪道智能體“%s”執行結果";
$lang->aichat->agentResultTitleDesc   = '方案標題，如果沒有合適標題可以省略';
$lang->aichat->agentResultSummaryDesc  = '對方案中數據的變化進行解釋，儘量對變化的屬性分別進行說明。';

