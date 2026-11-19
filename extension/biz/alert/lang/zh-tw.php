<?php
$lang->alert = new stdClass();
$lang->alert->common  = '預警規則';
$lang->alert->browse  = '預警規則列表';
$lang->alert->create  = '創建預警規則';
$lang->alert->edit    = '編輯預警規則';
$lang->alert->delete  = '刪除';
$lang->alert->enable  = '啟用';
$lang->alert->disable = '停用';

$lang->alert->name           = '規則名稱';
$lang->alert->objectType     = '預警對象';
$lang->alert->alertRule      = '預警規則';
$lang->alert->alertLevel     = '預警級別';
$lang->alert->notifyMethod   = '通知方式';
$lang->alert->notifyUsers    = '通知人';
$lang->alert->status         = '狀態';
$lang->alert->createdBy      = '創建人';
$lang->alert->createdDate    = '創建時間';
$lang->alert->lastEditedBy   = '編輯人';
$lang->alert->lastEditedDate = '編輯時間';
$lang->alert->days           = '天';

$lang->alert->featureBar['browse']['all']     = '全部';
$lang->alert->featureBar['browse']['normal']  = '啟用';
$lang->alert->featureBar['browse']['disable'] = '停用';

$lang->alert->statusList['normal']  = '啟用';
$lang->alert->statusList['disable'] = '停用';

$lang->alert->objectList['project']   = '項目';
$lang->alert->objectList['execution'] = '執行';
$lang->alert->objectList['task']      = '任務';

global $config;
if(in_array($config->edition, array('max', 'ipd')))
{
    $lang->alert->objectList['risk']  = '風險';
    $lang->alert->objectList['issue'] = '問題';
}

$lang->alert->levelList['notice']  = '提示';
$lang->alert->levelList['warning'] = '警告';
$lang->alert->levelList['serious'] = '嚴重';

$lang->alert->notifyMethodList['message'] = '系統消息';
$lang->alert->notifyMethodList['mail']    = '郵件';

$lang->alert->beginBefore    = '計劃開始日期前';
$lang->alert->beginOverdue   = '逾期開始';
$lang->alert->endBefore      = '計劃完成日期前';
$lang->alert->endOverdue     = '延期';
$lang->alert->svGreater      = '進度偏差率(SV)大於';
$lang->alert->resolveBefore  = '計劃解決日期前';
$lang->alert->resolveOverdue = '延期解決';

$lang->alert->alertRuleList = new stdClass();
$lang->alert->alertRuleList->project = array(
    'begin_before'  => $lang->alert->beginBefore,
    'begin_overdue' => $lang->alert->beginOverdue,
    'end_before'    => $lang->alert->endBefore,
    'end_overdue'   => $lang->alert->endOverdue,
    'sv_greater'    => $lang->alert->svGreater,
);

$lang->alert->alertRuleList->execution = array(
    'begin_before'  => $lang->alert->beginBefore,
    'begin_overdue' => $lang->alert->beginOverdue,
    'end_before'    => $lang->alert->endBefore,
    'end_overdue'   => $lang->alert->endOverdue,
);

$lang->alert->alertRuleList->task = array(
    'begin_before'  => $lang->alert->beginBefore,
    'begin_overdue' => $lang->alert->beginOverdue,
    'end_before'    => $lang->alert->endBefore,
    'end_overdue'   => $lang->alert->endOverdue,
);

$lang->alert->alertRuleList->risk = array(
    'resolve_before'  => $lang->alert->resolveBefore,
    'resolve_overdue' => $lang->alert->resolveOverdue,
);

$lang->alert->alertRuleList->issue = $lang->alert->alertRuleList->risk;

$lang->alert->pm          = '負責人';
$lang->alert->openedBy    = '創建人';
$lang->alert->projectPM   = '項目負責人';
$lang->alert->executionPM = '執行負責人';
$lang->alert->assignedTo  = '指派人';

$lang->alert->notifyUserList = new stdClass();
$lang->alert->notifyUserList->project   = array('pm' => $lang->alert->pm, 'openedBy' => $lang->alert->openedBy);
$lang->alert->notifyUserList->execution = array('pm' => $lang->alert->pm, 'openedBy' => $lang->alert->openedBy, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->task      = array('assignedTo' => $lang->alert->assignedTo, 'openedBy' => $lang->alert->openedBy, 'executionPM' => $lang->alert->executionPM, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->risk      = array('assignedTo' => $lang->alert->assignedTo, 'createdBy' => $lang->alert->createdBy, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->issue     = $lang->alert->notifyUserList->risk;

$lang->alert->projectModelTip = '只檢查瀑布、融合瀑布、IPD類型項目。';
$lang->alert->confirmDelete   = '您確定要刪除嗎？';

$lang->alert->notice = new stdClass();
$lang->alert->notice->enable           = '您確定要啟用該規則嗎？';
$lang->alert->notice->disable          = '您確定要停用該規則嗎？';
$lang->alert->notice->nameUnique       = '規則名稱已存在，請更換。';
$lang->alert->notice->emptyNodes       = '預警規則內容為空，無法啟用。';
$lang->alert->notice->invalidAlertType = '預警規則類型無效，請重新選擇。';