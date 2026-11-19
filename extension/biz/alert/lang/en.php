<?php
$lang->alert = new stdClass();
$lang->alert->common  = 'Alert Rule';
$lang->alert->browse  = 'Alert Rule List';
$lang->alert->create  = 'Create Alert Rule';
$lang->alert->edit    = 'Edit Alert Rule';
$lang->alert->delete  = 'Delete';
$lang->alert->enable  = 'Enable';
$lang->alert->disable = 'Disable';

$lang->alert->name           = 'Rule Name';
$lang->alert->objectType     = 'Alert Object';
$lang->alert->alertRule      = 'Alert Rule';
$lang->alert->alertLevel     = 'Alert Level';
$lang->alert->notifyMethod   = 'Notify Method';
$lang->alert->notifyUsers    = 'Notify Users';
$lang->alert->status         = 'Status';
$lang->alert->createdBy      = 'Created By';
$lang->alert->createdDate    = 'Created Date';
$lang->alert->lastEditedBy   = 'Last Edited By';
$lang->alert->lastEditedDate = 'Last Edited Date';
$lang->alert->days           = 'day(s)';

$lang->alert->featureBar['browse']['all']     = 'All';
$lang->alert->featureBar['browse']['normal']  = 'Enabled';
$lang->alert->featureBar['browse']['disable'] = 'Disabled';

$lang->alert->statusList['normal']  = 'Enabled';
$lang->alert->statusList['disable'] = 'Disabled';

$lang->alert->objectList['project']   = 'Project';
$lang->alert->objectList['execution'] = 'Execution';
$lang->alert->objectList['task']      = 'Task';

global $config;
if(in_array($config->edition, array('max', 'ipd')))
{
    $lang->alert->objectList['risk']      = 'Risk';
    $lang->alert->objectList['issue']     = 'Issue';
}

$lang->alert->levelList['notice']  = 'Notice';
$lang->alert->levelList['warning'] = 'Warning';
$lang->alert->levelList['serious'] = 'Serious';

$lang->alert->notifyMethodList['message'] = 'System Message';
$lang->alert->notifyMethodList['mail']    = 'Mail';

$lang->alert->beginBefore    = 'Before planned start date';
$lang->alert->beginOverdue   = 'Overdue start';
$lang->alert->endBefore      = 'Before planned finish date';
$lang->alert->endOverdue     = 'Overdue';
$lang->alert->svGreater         = 'Schedule variance (SV) greater than';
$lang->alert->resolveBefore  = 'Before planned resolution date';
$lang->alert->resolveOverdue = 'Overdue resolution';

$lang->alert->alertRuleList = new stdClass();
$lang->alert->alertRuleList->project = array(
    'begin_before'  => $lang->alert->beginBefore,
    'begin_overdue' => $lang->alert->beginOverdue,
    'end_before'    => $lang->alert->endBefore,
    'end_overdue'   => $lang->alert->endOverdue,
    'sv_greater'       => $lang->alert->svGreater,
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

$lang->alert->pm          = 'Owner';
$lang->alert->openedBy    = 'Created By';
$lang->alert->projectPM   = 'Project Owner';
$lang->alert->executionPM = 'Execution Owner';
$lang->alert->assignedTo  = 'Assigned To';

$lang->alert->notifyUserList = new stdClass();
$lang->alert->notifyUserList->project   = array('pm' => $lang->alert->pm, 'openedBy' => $lang->alert->openedBy);
$lang->alert->notifyUserList->execution = array('pm' => $lang->alert->pm, 'openedBy' => $lang->alert->openedBy, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->task      = array('assignedTo' => $lang->alert->assignedTo, 'openedBy' => $lang->alert->openedBy, 'executionPM' => $lang->alert->executionPM, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->risk      = array('assignedTo' => $lang->alert->assignedTo, 'createdBy' => $lang->alert->createdBy, 'projectPM' => $lang->alert->projectPM);
$lang->alert->notifyUserList->issue     = $lang->alert->notifyUserList->risk;

$lang->alert->projectModelTip = 'Only waterfall, waterfallplus, and IPD projects are checked.';
$lang->alert->confirmDelete   = 'Are you sure you want to delete?';

$lang->alert->notice = new stdClass();
$lang->alert->notice->enable           = 'Are you sure you want to enable this rule?';
$lang->alert->notice->disable          = 'Are you sure you want to disable this rule?';
$lang->alert->notice->nameUnique       = 'Rule name already exists. Please choose another.';
$lang->alert->notice->emptyNodes       = 'Alert rule content is empty and cannot be enabled.';
$lang->alert->notice->invalidAlertType = 'Invalid alert rule type. Please select again.';
