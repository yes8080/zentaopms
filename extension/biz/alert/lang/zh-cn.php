<?php
$lang->alert = new stdClass();
$lang->alert->common  = '预警规则';
$lang->alert->browse  = '预警规则列表';
$lang->alert->create  = '创建预警规则';
$lang->alert->edit    = '编辑预警规则';
$lang->alert->delete  = '删除';
$lang->alert->enable  = '启用';
$lang->alert->disable = '停用';

$lang->alert->name           = '规则名称';
$lang->alert->objectType     = '预警对象';
$lang->alert->alertRule      = '预警规则';
$lang->alert->alertLevel     = '预警级别';
$lang->alert->notifyMethod   = '通知方式';
$lang->alert->notifyUsers    = '通知人';
$lang->alert->status         = '状态';
$lang->alert->createdBy      = '创建人';
$lang->alert->createdDate    = '创建时间';
$lang->alert->lastEditedBy   = '编辑人';
$lang->alert->lastEditedDate = '编辑时间';
$lang->alert->days           = '天';

$lang->alert->featureBar['browse']['all']     = '全部';
$lang->alert->featureBar['browse']['normal']  = '启用';
$lang->alert->featureBar['browse']['disable'] = '停用';

$lang->alert->statusList['normal']  = '启用';
$lang->alert->statusList['disable'] = '停用';

$lang->alert->objectList['project']   = '项目';
$lang->alert->objectList['execution'] = '执行';
$lang->alert->objectList['task']      = '任务';

global $config;
if(in_array($config->edition, array('max', 'ipd')))
{
    $lang->alert->objectList['risk']  = '风险';
    $lang->alert->objectList['issue'] = '问题';
}

$lang->alert->levelList['notice']  = '提示';
$lang->alert->levelList['warning'] = '警告';
$lang->alert->levelList['serious'] = '严重';

$lang->alert->notifyMethodList['message'] = '系统消息';
$lang->alert->notifyMethodList['mail']    = '邮件';

$lang->alert->beginBefore    = '计划开始日期前';
$lang->alert->beginOverdue   = '逾期开始';
$lang->alert->endBefore      = '计划完成日期前';
$lang->alert->endOverdue     = '延期';
$lang->alert->svGreater      = '进度偏差率(SV)大于';
$lang->alert->resolveBefore  = '计划解决日期前';
$lang->alert->resolveOverdue = '延期解决';

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

$lang->alert->pm          = '负责人';
$lang->alert->openedBy    = '创建人';
$lang->alert->projectPM   = '项目负责人';
$lang->alert->executionPM = '执行负责人';
$lang->alert->assignedTo  = '指派人';

$lang->alert->notifyUserList = new stdClass();
$lang->alert->notifyUserList->project   = array('pm' => $lang->alert->pm, 'openedBy' => $lang->alert->openedBy);
$lang->alert->notifyUserList->execution = array('pm' => $lang->alert->pm, 'openedBy' => $lang->alert->openedBy, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->task      = array('assignedTo' => $lang->alert->assignedTo, 'openedBy' => $lang->alert->openedBy, 'executionPM' => $lang->alert->executionPM, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->risk      = array('assignedTo' => $lang->alert->assignedTo, 'createdBy' => $lang->alert->createdBy, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->issue     = $lang->alert->notifyUserList->risk;

$lang->alert->projectModelTip = '只检查瀑布、融合瀑布、IPD类型项目。';
$lang->alert->confirmDelete   = '您确定要删除吗？';

$lang->alert->notice = new stdClass();
$lang->alert->notice->enable           = '您确定要启用该规则吗？';
$lang->alert->notice->disable          = '您确定要停用该规则吗？';
$lang->alert->notice->nameUnique       = '规则名称已存在，请更换。';
$lang->alert->notice->emptyNodes       = '预警规则内容为空，无法启用。';
$lang->alert->notice->invalidAlertType = '预警规则类型无效，请重新选择。';