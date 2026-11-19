<?php
$lang->rulequeue = new stdClass();

$lang->rulequeue->triggeredBy   = '觸發人';
$lang->rulequeue->triggeredDate = '觸發日期';
$lang->rulequeue->executedTime  = '執行時間';
$lang->rulequeue->status        = '狀態';
$lang->rulequeue->log           = '執行日誌';
$lang->rulequeue->run           = '執行規則';

$lang->rulequeue->statusList['wait']    = '等待執行';
$lang->rulequeue->statusList['doing']   = '執行中';
$lang->rulequeue->statusList['success'] = '執行成功';
$lang->rulequeue->statusList['fail']    = '執行失敗';

$lang->rulequeue->noUpdateList  = '未找到可更新的對象。';
$lang->rulequeue->noDeleteList  = '未找到可刪除的對象。';
$lang->rulequeue->affectObjects = '影響的對象: %s';
$lang->rulequeue->maxLimit      = '單條規則最多更新200個對象，當前命中%s個對象，規則將不會執行。';

$lang->rulequeue->error = new stdClass();
$lang->rulequeue->error->overParentBegin          = '執行的起止時間不能超過項目的起止時間。';
$lang->rulequeue->error->noPriv                   = '觸發用戶沒有權限執行。';
$lang->rulequeue->error->productNotInProject      = '執行關聯的產品不在項目中。';
$lang->rulequeue->error->projectCannotBeChanged   = '已關閉的項目不能修改。';
$lang->rulequeue->error->productCannotBeChanged   = '已關閉的產品不能修改。';
$lang->rulequeue->error->executionCannotBeChanged = '已關閉的執行不能修改。';
$lang->rulequeue->error->apiUnsupported           = '對象類型「%s」尚未支持通過 API V2 寫入，無法執行。';
$lang->rulequeue->error->apiNoBaseUrl             = '無法解析站點地址，規則引擎無法調用 API V2（請檢查訪問域名或郵件域名配置）。';
$lang->rulequeue->error->apiInvalidResponse       = 'API V2 返回了無效響應。';
$lang->rulequeue->error->apiFail                  = 'API V2 調用失敗。';
$lang->rulequeue->error->apiNoId                  = 'API V2 創建成功但未返回對象 ID。';
$lang->rulequeue->error->runAsInvalid             = '執行身份「%s」無效或不存在。';

$lang->rulequeue->alert = new stdClass();
$lang->rulequeue->alert->noticeTitle    = '預警通知';
$lang->rulequeue->alert->defaultContent = "【%s】您有%s個%s觸發“%s”規則，請及時關注!";
$lang->rulequeue->alert->objectItem     = '<a href="%s">[#%s::%s]</a>';
$lang->rulequeue->alert->mailSubject    = '預警彙總通知';
$lang->rulequeue->alert->mailItem       = '規則「%s」命中 %s 條';
$lang->rulequeue->alert->noticeItem     = '預警規則「%s」命中 %s 條對象。';
$lang->rulequeue->alert->idAB           = 'ID';
$lang->rulequeue->alert->beginDate      = '開始日期';
$lang->rulequeue->alert->deadline       = '截止日期';
$lang->rulequeue->alert->svRate         = '進度偏差率';

$lang->rulequeue->alert->objectTitle['project']   = '項目標題';
$lang->rulequeue->alert->objectTitle['execution'] = '執行標題';
$lang->rulequeue->alert->objectTitle['task']      = '任務標題';
$lang->rulequeue->alert->objectTitle['risk']      = '風險標題';
$lang->rulequeue->alert->objectTitle['issue']     = '問題標題';
