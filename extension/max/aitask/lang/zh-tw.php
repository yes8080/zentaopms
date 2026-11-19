<?php
$lang->aitask->name        = '名稱';
$lang->aitask->object      = '相關對象';
$lang->aitask->assignedTo  = '負責人';
$lang->aitask->status      = '狀態';
$lang->aitask->taskStatus  = '任務狀態';
$lang->aitask->type        = '任務類型';
$lang->aitask->createdDate = '創建時間';
$lang->aitask->list        = '數字員工任務列表';
$lang->aitask->verified    = '驗收';
$lang->aitask->noResults   = '暫無結果';
$lang->aitask->refined     = '繼續完善';
$lang->aitask->retry       = '重試';
$lang->aitask->cancel      = '取消';
$lang->aitask->activate    = '激活';
$lang->aitask->exec        = '執行';
$lang->aitask->mine        = '與我相關';
$lang->aitask->noTask      = '暫無數字員工任務';
$lang->aitask->browse      = '瀏覽數字員工任務';
$lang->aitask->viewOption  = '查看數字員工任務詳情';

$lang->aitask->activateSuccess = '激活成功';
$lang->aitask->cancelSuccess   = '取消成功';
$lang->aitask->retrySuccess    = '重試成功';

$lang->aitask->statusList['done']   = '待驗收';
$lang->aitask->statusList['wait']   = '未開始';
$lang->aitask->statusList['closed'] = '已關閉';
$lang->aitask->statusList['doing']  = '進行中';
$lang->aitask->statusList['fail']   = '執行失敗';
$lang->aitask->statusList['cancel'] = '已取消';

$lang->aitask->featureBar['browse']['all'] = '全部任務';
$lang->aitask->featureBar['browse']        = array_merge($lang->aitask->featureBar['browse'], $lang->aitask->statusList);

$lang->aitask->view          = '查看數字員工任務';
$lang->aitask->basicInfo     = '基本信息';
$lang->aitask->lifeTime      = '任務的一生';
$lang->aitask->content       = '任務內容';
$lang->aitask->result        = '任務成果';
$lang->aitask->userPrompt    = '提示詞';
$lang->aitask->consumed      = '總計耗時';
$lang->aitask->tokenUsed     = 'Token 使用';
$lang->aitask->teammate      = '數字員工';
$lang->aitask->createdBy     = '由誰創建';
$lang->aitask->createdDate   = '創建時間';
$lang->aitask->verifiedBy    = '由誰驗收';
$lang->aitask->verifiedDate  = '驗收時間';
$lang->aitask->closedBy      = '由誰關閉';
$lang->aitask->closedDate    = '關閉時間';
$lang->aitask->cancelledBy   = '由誰取消';
$lang->aitask->cancelledDate = '取消時間';
$lang->aitask->activatedBy   = '由誰激活';
$lang->aitask->activatedDate = '激活時間';
$lang->aitask->desc          = '描述';
$lang->aitask->objectType    = '對象類型';
$lang->aitask->objectID      = '對象ID';
$lang->aitask->agents        = '智能體';
$lang->aitask->agentsData    = '表單數據';
$lang->aitask->klibs         = '知識庫';
$lang->aitask->chatID        = '對話ID';
$lang->aitask->token         = '消耗Token';
$lang->aitask->notFound      = '任務不存在';
$lang->aitask->titleFormat   = '對 %s %s 進行 %s';
$lang->aitask->taskObject    = '任務對象';
$lang->aitask->objectHint    = '需要處理的對象是 ';
$lang->aitask->taskParams    = '任務參數';
$lang->aitask->noParams      = '暫無參數';
$lang->aitask->executedBy    = '由誰執行';
$lang->aitask->executedDate  = '執行日期';
$lang->aitask->finishedDate  = '完成時間';
$lang->aitask->failedReason  = '失敗原因';

$lang->aitask->reviewOpinion     = '評審意見';
$lang->aitask->remarkPlaceholder = '輸入內容';
$lang->aitask->viewFullContent   = '查看完整上下文';

$lang->aitask->resultList['pass']   = '通過';
$lang->aitask->resultList['refine'] = '繼續完善';

$lang->aitask->action = new stdclass();
$lang->aitask->action->retried   = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->retry . '。';
$lang->aitask->action->canceled  = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->cancel . '。';
$lang->aitask->action->activated = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->activate . '。';
$lang->aitask->action->verified  = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->verified . '。';
$lang->aitask->action->refined   = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->refined . '。';
$lang->aitask->action->executing = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->exec . '，$extra。';
$lang->aitask->action->assigned  = '$date, 由 <strong>$actor</strong> 轉交給 <strong>$extra</strong>。';

$lang->aitask->tips = new stdclass();
$lang->aitask->tips->confirmDelete   = '確定要刪除嗎？';
$lang->aitask->tips->confirmCancel   = '確定要取消嗎？';
$lang->aitask->tips->confirmActivate = '激活後，選中任務狀態變為未開始，確定要激活嗎？';
$lang->aitask->tips->confirmVerify   = '確定要驗收嗎？';
$lang->aitask->tips->confirmRetry    = '確定要重試嗎？';
$lang->aitask->tips->consumedTips    = '數字員工處理任務累計的消耗時間之和';
$lang->aitask->tips->tokenUsedTips   = '數字員工處理任務累計消耗的 Token 之和';

/* AI 任務執行相關：*/
$lang->aitask->exceedsMaxParallel = '超過最大並發執行任務數，請稍後再試';
$lang->aitask->noWaitingTask      = '沒有等待執行的任務';
$lang->aitask->taskIsNotWaiting   = '任務不是等待執行狀態';
$lang->aitask->startExecuting     = '開始執行任務';
$lang->aitask->executeFailed      = '任務執行失敗，請重試';
$lang->aitask->timeout            = '執行超時';
$lang->aitask->executeTimeout     = '任務執行超時，請重試';
$lang->aitask->executeSuccess     = '任務執行成功';
$lang->aitask->noAgentToExecute   = '沒有可用的智能體，請檢查智能體狀態';
$lang->aitask->taskFailed         = '任務執行失敗';
$lang->aitask->taskExecuted       = '任務執行成功';
$lang->aitask->assignTo           = '責任轉交';
$lang->aitask->assignToAction     = '轉交';
$lang->aitask->noPermission       = '無權限操作';
$lang->aitask->onlyPostRequest    = '只能通過 POST 請求執行';
