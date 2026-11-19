<?php
$lang->aiprocedure->common              = '工序';
$lang->aiprocedure->browse              = '瀏覽工序';
$lang->aiprocedure->create              = '創建工序';
$lang->aiprocedure->view                = '工序詳情';
$lang->aiprocedure->edit                = '編輯';
$lang->aiprocedure->design              = '設計';
$lang->aiprocedure->publish             = '發佈';
$lang->aiprocedure->unpublish           = '下架';
$lang->aiprocedure->delete              = '刪除工序';
$lang->aiprocedure->name                = '工序名稱';
$lang->aiprocedure->module              = '顯示位置';
$lang->aiprocedure->desc                = '描述';
$lang->aiprocedure->status              = '狀態';
$lang->aiprocedure->createdBy           = '由誰創建';
$lang->aiprocedure->createdDate         = '創建時間';
$lang->aiprocedure->finishedDate        = '完成時間';
$lang->aiprocedure->publishedBy         = '由誰發佈';
$lang->aiprocedure->unpublishedBy       = '由誰下架';
$lang->aiprocedure->lastEdited          = '最後編輯';
$lang->aiprocedure->basicInfo           = '基本信息';
$lang->aiprocedure->steps               = '步驟';
$lang->aiprocedure->back                = '返回';
$lang->aiprocedure->noData              = '暫無工序';
$lang->aiprocedure->notFound            = '工序不存在';
$lang->aiprocedure->confirmDelete       = '刪除後，工序將不能繼續使用，您確定要刪除嗎？';
$lang->aiprocedure->designNeedUnpublish = '已發佈工序需先下架後才能設計';
$lang->aiprocedure->publishNeedSteps    = '發佈失敗，需為工序設計執行步驟再發佈';
$lang->aiprocedure->saveNeedFinishRun   = '保存失敗，有工序正在處理中，請完成或結束工序後再保存';
$lang->aiprocedure->procedureRef        = '"%s"工序';
$lang->aiprocedure->agentUnpublishNotice = '已上架的%s中使用了該智能體。智能體下架後，工序也會同步下架，後續需要重新手動上架工序。';
$lang->aiprocedure->publishNeedActiveAgents = '發佈失敗，工序中的智能體"%s"未上架或已被刪除，請先上架智能體後再發佈工序。';
$lang->aiprocedure->viewHistory         = '查看歷史工序';
$lang->aiprocedure->history             = '歷史工序記錄';
$lang->aiprocedure->noHistory           = '暫無歷史記錄';
$lang->aiprocedure->procedureRunCreated = '工序任務已創建，請在工作台執行步驟';
$lang->aiprocedure->procedureRunStopped = '工序已結束';
$lang->aiprocedure->stopProcedureRunFailed = '無法結束工序，請刷新後重試';
$lang->aiprocedure->start               = '開始';

$lang->aiprocedure->appLabels = array();
$lang->aiprocedure->appLabels['load-failed-title']     = '數據加載失敗';
$lang->aiprocedure->appLabels['load-failed-message']   = '請稍後重試';
$lang->aiprocedure->appLabels['save-failed-title']     = '保存失敗';
$lang->aiprocedure->appLabels['save-failed-message']   = '請檢查內容是否正確';
$lang->aiprocedure->appLabels['save-success']          = '保存成功';
$lang->aiprocedure->appLabels['publish-success']       = '發佈成功';
$lang->aiprocedure->appLabels['step-config']           = '步驟配置';
$lang->aiprocedure->appLabels['step-output']           = '步驟的輸出結果';
$lang->aiprocedure->appLabels['last-step-warning']     = '至少需要保留一個步驟';
$lang->aiprocedure->appLabels['select-agent']          = '選擇禪道智能體';
$lang->aiprocedure->appLabels['agent-required']        = '請選擇禪道智能體';
$lang->aiprocedure->appLabels['select-input']          = '選擇輸入內容';
$lang->aiprocedure->appLabels['select-input-hint']     = '選擇之前步驟的輸出結果作為這一步驟的提詞';
$lang->aiprocedure->appLabels['output-last-answer']    = '最後一次回答';
$lang->aiprocedure->appLabels['output-modified-object']= '修改的對象';
$lang->aiprocedure->appLabels['output-docs']           = '具體文檔';
$lang->aiprocedure->appLabels['save']                  = '保存';
$lang->aiprocedure->appLabels['publish']               = '發佈';
$lang->aiprocedure->appLabels['agent-status-draft']    = '未發佈';
$lang->aiprocedure->appLabels['agent-status-deleted']  = '已刪除';
$lang->aiprocedure->appLabels['publish-failed-title']  = '發佈失敗';
$lang->aiprocedure->appLabels['publish-need-active-agents'] = '工序中的智能體"%s"未上架或已被刪除，請先上架智能體後再發佈工序。';
$lang->aiprocedure->appLabels['confirm']               = '確定';
$lang->aiprocedure->appLabels['agent-process-object']  = '處理對象';
$lang->aiprocedure->appLabels['agent-action-purpose']  = '操作對象';
$lang->aiprocedure->appLabels['agent-display-position']= '顯示位置';
$lang->aiprocedure->appLabels['agent-role']            = '角色';
$lang->aiprocedure->appLabels['agent-purpose']         = '提詞';
$lang->aiprocedure->appLabels['agent-skills-list']     = '掛載技能';
$lang->aiprocedure->appLabels['agent-knowledge-list']  = '掛載知識庫';
$lang->aiprocedure->appLabels['start']                 = '開始';
$lang->aiprocedure->appLabels['end']                   = '結束';
$lang->aiprocedure->appLabels['step']                  = '步驟';

$lang->aiprocedure->moduleList = array();
$lang->aiprocedure->moduleList['story']       = $lang->SRCommon;
$lang->aiprocedure->moduleList['requirement'] = $lang->URCommon;
$lang->aiprocedure->moduleList['epic']        = $lang->ERCommon;
$lang->aiprocedure->moduleList['task']        = '任務';
$lang->aiprocedure->moduleList['bug']         = 'Bug';
$lang->aiprocedure->moduleList['feedback']    = '反饋';
$lang->aiprocedure->moduleList['ticket']      = '工單';

$lang->aiprocedure->statusList = array();
$lang->aiprocedure->statusList['draft']  = '待發佈';
$lang->aiprocedure->statusList['active'] = '已發佈';

$lang->aiprocedure->featureBar['browse']['all']    = '全部';
$lang->aiprocedure->featureBar['browse']['active'] = '已發佈';
$lang->aiprocedure->featureBar['browse']['draft']  = '待發佈';

$lang->aiprocedure->workbench   = '工作台';
$lang->aiprocedure->myTodo      = '我的待辦';
$lang->aiprocedure->objectTypes = array_merge(array('all' => '全部'), $lang->aiprocedure->moduleList);

foreach($lang->aiprocedure->moduleList as $type => $objectTypeName)
{
    $lang->aiprocedure->moduleList[$type] = $objectTypeName . '詳情';
}

$lang->aiprocedure->procedureRunStatus = [];
$lang->aiprocedure->procedureRunStatus['doing'] = '待處理';
$lang->aiprocedure->procedureRunStatus['done']  = '已完成';
$lang->aiprocedure->procedureRunStatus['ended'] = '已終止';

$lang->aiprocedure->deadlineInfo    = '%s截止';
$lang->aiprocedure->alreadyRunning  = '已有工序正在執行，無法啟動新的工序';
$lang->aiprocedure->unpublishNotice = '下架後，工序將不能繼續使用，您確定要下架嗎？';
$lang->aiprocedure->selectedTypes   = '已選{count}個類型';
$lang->aiprocedure->noTodo          = '暫無待辦事項';

$lang->aiprocedure->appLang = new stdClass();

$lang->aiprocedure->appLang->objectTypes          = $lang->aiprocedure->objectTypes;
$lang->aiprocedure->appLang->fillFormInfo         = '請補充下列表單內容：';
$lang->aiprocedure->appLang->generate             = '開始步驟';
$lang->aiprocedure->appLang->regenerate           = '重新生成';
$lang->aiprocedure->appLang->returnToCurrentStep  = '返回當前步驟';
$lang->aiprocedure->appLang->historyReadonlyHint  = '正在查看歷史步驟，僅可查看表單和對話記錄，不能修改或重新生成。';
$lang->aiprocedure->appLang->stepFormData         = '步驟填寫的表單';
$lang->aiprocedure->appLang->noStepFormData       = '此步驟沒有保存的表單數據';
$lang->aiprocedure->appLang->noStepChat           = '此步驟沒有對話記錄';
$lang->aiprocedure->appLang->acceptAndContinue    = '下一步';
$lang->aiprocedure->appLang->complete             = '完成工序';
$lang->aiprocedure->appLang->stopProcedureRun     = '結束工序';
$lang->aiprocedure->appLang->running              = '運行中';
$lang->aiprocedure->appLang->confirmStopProcedureRun = '確定結束工序“{name}”嗎？已保存的步驟數據會保留，剩餘步驟將不再執行。';
$lang->aiprocedure->appLang->stopProcedureRunFailed = $lang->aiprocedure->stopProcedureRunFailed;
$lang->aiprocedure->appLang->noChatHint           = '在左側輸入信息後點擊「開始步驟」開始AI對話';
$lang->aiprocedure->appLang->generating           = '正在生成...';
$lang->aiprocedure->appLang->generateFailed       = '生成失敗，請重試。';
$lang->aiprocedure->appLang->stepResultPrefix     = '步驟{title}執行結果如下：';
$lang->aiprocedure->appLang->stepResultActions    = ['add' => '新增', 'update' => '更新', 'delete' => '刪除'];
$lang->aiprocedure->appLang->stepResultChangeInfo = '{action}了 {count} 個 {objectName}（{objectType}），ID 為 {ids}；';
$lang->aiprocedure->appLang->stepPromptPrefix     = '用戶在初始選擇的對象是 {objectType} #{objectID}。';
$lang->aiprocedure->appLang->stepPurposeHint      = '如果在完成用戶任務的過程中缺少相關數據可以詢問用戶或通過 `getZentaoObject` 工具來獲取足夠的信息，如果需要處理的對象包括多個，但無法一次性處理，則可以處理完一個再處理下一個。';
$lang->aiprocedure->appLang->promptExecuteFailed  = '禪道智能體調用失敗，請改用禪道 API來完成“{action}”操作。';
