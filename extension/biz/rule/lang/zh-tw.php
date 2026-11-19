<?php
$lang->rule->name             = '規則名稱';
$lang->rule->type             = '適配類型';
$lang->rule->workflowGroup    = '適配模板';
$lang->rule->method           = '執行方式';
$lang->rule->status           = '狀態';
$lang->rule->createdBy        = '創建人';
$lang->rule->createdDate      = '創建日期';
$lang->rule->lastEditedBy     = '最後修改';
$lang->rule->lastEditedDate   = '最後修改日期';
$lang->rule->lastRunTime      = '最後運行時間';
$lang->rule->lastRunResult    = '最後運行結果';
$lang->rule->products         = '關聯產品';
$lang->rule->currentProduct   = '當前產品';
$lang->rule->currentProject   = '當前項目';
$lang->rule->currentExecution = '當前執行';
$lang->rule->currentStory     = '當前需求';
$lang->rule->currentTask      = '當前任務';
$lang->rule->currentUser      = '規則觸發人';
$lang->rule->field            = '欄位';
$lang->rule->when             = '當';
$lang->rule->value            = '值';
$lang->rule->objectType       = '對象';
$lang->rule->actionName       = '動作';
$lang->rule->after            = '之後';
$lang->rule->requiredFields   = '必填欄位';
$lang->rule->otherFields      = '其他欄位';
$lang->rule->copyField        = '引用欄位';
$lang->rule->notifyUsers      = '通知人';
$lang->rule->notifyMethod     = '通知方式';
$lang->rule->relation         = '對象關係匹配';
$lang->rule->selectObject     = '選擇對象';
$lang->rule->editField        = '屬性修改';
$lang->rule->modify           = '修改為';
$lang->rule->begin            = '開始日期';
$lang->rule->end              = '結束日期';
$lang->rule->deptManager      = '部門負責人';

global $config;
$lang->rule->objectList['product'] = $lang->productCommon;
if($config->enableER) $lang->rule->objectList['epic']        = $lang->ERCommon;
if($config->URAndSR)  $lang->rule->objectList['requirement'] = $lang->URCommon;
$lang->rule->objectList['story']     = $lang->SRCommon;
$lang->rule->objectList['project']   = $lang->projectCommon;
$lang->rule->objectList['execution'] = '執行';
$lang->rule->objectList['task']      = '任務';
$lang->rule->objectList['bug']       = 'Bug';
$lang->rule->objectList['testcase']  = '用例';

$lang->rule->actionList['create'] = '創建對象';
$lang->rule->actionList['edit']   = '編輯對象';
//$lang->rule->actionList['delete'] = '刪除對象';
$lang->rule->actionList['notify'] = '通知';

$lang->rule->notifyMethodList['fail']   = '每次執行失敗時通知';
$lang->rule->notifyMethodList['always'] = '每次執行時通知';
$lang->rule->notifyMethodList['closed'] = '不通知';

$lang->rule->typeList['global'] = '全局級';
$lang->rule->typeList['group']  = '流程模板級';

$lang->rule->typeNoticeList['global'] = '（系統全局生效）';
$lang->rule->typeNoticeList['group']  = '（僅在流程模板內生效）';

$lang->rule->methodList['sync']  = '同步';
$lang->rule->methodList['async'] = '非同步';

$lang->rule->statusList['normal']  = '啟用';
$lang->rule->statusList['disable'] = '停用';

$lang->rule->resultList['success'] = '成功';
$lang->rule->resultList['fail']    = '失敗';

$lang->rule->browse  = '規則列表';
$lang->rule->create  = '創建規則';
$lang->rule->design  = '設計';
$lang->rule->enable  = '啟用';
$lang->rule->disable = '停用';
$lang->rule->log     = '執行日誌';
$lang->rule->view    = '規則詳情';
$lang->rule->notify  = '通知設置';
$lang->rule->copy    = '複製';
$lang->rule->edit    = '編輯';
$lang->rule->delete  = '刪除';

$lang->rule->basicInfo = '基本信息';

$lang->rule->featureBar['browse']['all']     = '全部';
$lang->rule->featureBar['browse']['normal']  = '啟用';
$lang->rule->featureBar['browse']['disable'] = '停用';

$lang->rule->titleList['when']      = '前置動作';
$lang->rule->titleList['condition'] = '觸發條件';
$lang->rule->titleList['action']    = '執行動作';

$lang->rule->branchList['condition'] = '觸發條件';
$lang->rule->branchList['action']    = '執行動作';

$lang->rule->relationList['include']         = '包含';
$lang->rule->relationList['belong']          = '從屬於';
$lang->rule->relationList['parent']          = '父';
$lang->rule->relationList['child']           = '子';
$lang->rule->relationList['related']         = '關聯';
$lang->rule->relationList['transferredto']   = '轉化為';
$lang->rule->relationList['transferredfrom'] = '轉化于';
$lang->rule->relationList['generated']       = '產生為';
$lang->rule->relationList['derivedfrom']     = '產生於';

$lang->rule->error = new stdClass();
$lang->rule->error->emptyObjectType       = '對象不能為空';
$lang->rule->error->emptyModuleOrRelation = '對象關係匹配與對象不能為空';
$lang->rule->error->emptyAction           = '動作不能為空';
$lang->rule->error->noPreActions          = '請設置前置動作';
$lang->rule->error->noCompleteRule        = '必須要有至少一條完整規則。';
$lang->rule->error->requiredFieldEmpty    = '必填項不能為空！';
$lang->rule->error->invalidEstimate       = '預計工時格式不正確！';
$lang->rule->error->notConsistency        = '檢測到前置動作與觸發條件、執行動作對象不一致，請重新設置觸發條件和執行動作後保存。';
$lang->rule->error->errorBegin            = "執行的開始時間必須在項目起止時間內，項目起止時間為%s至%s";
$lang->rule->error->errorEnd              = "執行的結束時間必須在項目起止時間內，項目起止時間為%s至%s";
$lang->rule->error->beginGtEnd            = "計劃開始時間不能大於計劃結束時間";

$lang->rule->notifyList = new stdClass();
$lang->rule->notifyList->subject = '通知標題';
$lang->rule->notifyList->content = '通知內容';
$lang->rule->notifyList->toList  = '通知用戶';
$lang->rule->notifyList->route   = '通知渠道';

$lang->rule->notice = new stdClass();
$lang->rule->notice->noCondition     = '無條件觸發';
$lang->rule->notice->disable         = '您確定要停用該規則嗎？';
$lang->rule->notice->enable          = '您確定要啟用該規則嗎？';
$lang->rule->notice->noRules         = '您還沒有配置規則，請先進行配置。';
$lang->rule->notice->delete          = '您確定要刪除該規則嗎？刪除規則後，規則的執行日誌也會刪除。該操作是不可逆的，無法恢復！';
$lang->rule->notice->needValue       = '值不能為空';
$lang->rule->notice->requiredFields  = '不能去掉必填欄位！';
$lang->rule->notice->multiConditions = '多個觸發條件從左向右匹配，只執行第一個匹配到的條件';
$lang->rule->notice->delCondition    = '您確定要刪除該條件嗎？刪除後該條件下的執行動作也會刪除。';
$lang->rule->notice->apiUnsupported  = '動作對象「%s」尚未支持 API V2，無法啟用該規則。';
$lang->rule->notice->runAsInvalid    = '執行身份「%s」無效或不存在。';

$lang->rule->appendActionGroup = array();
$lang->rule->appendActionGroup['testcase'][] = array('text' => '執行用例', 'value' => 'run');

$lang->rule->action = new stdclass();
$lang->rule->action->executed = array('main' => '$date, 由 <strong>$actor</strong> 觸發執行，執行結果為 <strong>$extra</strong>。', 'extra' => 'resultList');
$lang->rule->action->designed = array('main' => '$date, 由 <strong>$actor</strong> 設計規則。');
$lang->rule->action->enabled  = array('main' => '$date, 由 <strong>$actor</strong> 啟用。');
$lang->rule->action->disabled = array('main' => '$date, 由 <strong>$actor</strong> 停用。');
