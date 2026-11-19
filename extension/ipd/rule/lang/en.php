<?php
$lang->rule->name             = 'Rule Name';
$lang->rule->type             = 'Rule Type';
$lang->rule->method           = 'Method';
$lang->rule->status           = 'Status';
$lang->rule->createdBy        = 'Created By';
$lang->rule->createdDate      = 'Created Date';
$lang->rule->lastEditedBy     = 'Last Edited By';
$lang->rule->lastEditedDate   = 'Last Edited Date';
$lang->rule->lastRunTime      = 'Last Run Time';
$lang->rule->lastRunResult    = 'Last Run Result';
$lang->rule->products         = 'Link Products';
$lang->rule->currentProduct   = 'Current Product';
$lang->rule->currentProject   = 'Current Project';
$lang->rule->currentExecution = 'Current Execution';
$lang->rule->currentStory     = 'Current Story';
$lang->rule->currentTask      = 'Current Task';
$lang->rule->currentUser      = 'Current User';
$lang->rule->workflowGroup    = 'Workflow Group';
$lang->rule->field            = 'Field';
$lang->rule->when             = 'When';
$lang->rule->value            = 'Value';
$lang->rule->objectType       = 'Object';
$lang->rule->actionName       = 'Action';
$lang->rule->after            = 'After';
$lang->rule->requiredFields   = 'Required Fields';
$lang->rule->otherFields      = 'Other Fields';
$lang->rule->copyField        = 'Copy Field';
$lang->rule->notifyUsers      = 'Notify Users';
$lang->rule->notifyMethod     = 'Notify Method';
$lang->rule->relation         = 'Relation';
$lang->rule->selectObject     = 'Select Object';
$lang->rule->editField        = 'Edit Field';
$lang->rule->modify           = 'Modify';
$lang->rule->begin            = 'Begin Time';
$lang->rule->end              = 'End Time';
$lang->rule->deptManager      = 'Dept Manager';

global $config;
$lang->rule->objectList['product'] = $lang->productCommon;
if($config->enableER) $lang->rule->objectList['epic']        = $lang->ERCommon;
if($config->URAndSR)  $lang->rule->objectList['requirement'] = $lang->URCommon;
$lang->rule->objectList['story']     = $lang->SRCommon;
$lang->rule->objectList['project']   = $lang->projectCommon;
$lang->rule->objectList['execution'] = 'Execution';
$lang->rule->objectList['task']      = 'Task';
$lang->rule->objectList['bug']       = 'Bug';
$lang->rule->objectList['testcase']  = 'Testcase';

$lang->rule->actionList['create'] = 'Create Object';
$lang->rule->actionList['edit']   = 'Edit Object';
//$lang->rule->actionList['delete'] = 'Delete Object';
$lang->rule->actionList['notify'] = 'Notify';

$lang->rule->notifyMethodList['fail']   = 'Notify on Fail';
$lang->rule->notifyMethodList['always'] = 'Always Notify';
$lang->rule->notifyMethodList['closed'] = 'Closed';

$lang->rule->typeList['global'] = 'Global';
$lang->rule->typeList['group']  = 'Group';

$lang->rule->typeNoticeList['global'] = '(Effective in global)';
$lang->rule->typeNoticeList['group']  = '(Only effective in workflow group)';

$lang->rule->methodList['sync']  = 'Sync';
$lang->rule->methodList['async'] = 'Async';

$lang->rule->statusList['normal']  = 'Enable';
$lang->rule->statusList['disable'] = 'Disable';

$lang->rule->resultList['success'] = 'Success';
$lang->rule->resultList['fail']    = 'Fail';

$lang->rule->browse  = 'Rule List';
$lang->rule->create  = 'Create Rule';
$lang->rule->design  = 'Design Rule';
$lang->rule->enable  = 'Enable';
$lang->rule->disable = 'Disable';
$lang->rule->log     = 'Rule Log';
$lang->rule->view    = 'View Rule';
$lang->rule->notify  = 'Notify';
$lang->rule->copy    = 'Copy';
$lang->rule->edit    = 'Edit';
$lang->rule->delete  = 'Delete';

$lang->rule->basicInfo = 'Basic Info';

$lang->rule->featureBar['browse']['all']     = 'All';
$lang->rule->featureBar['browse']['normal']  = 'Enable';
$lang->rule->featureBar['browse']['disable'] = 'Disable';

$lang->rule->titleList['when']      = 'When';
$lang->rule->titleList['condition'] = 'Condition';
$lang->rule->titleList['action']    = 'Action';

$lang->rule->branchList['condition'] = 'Condition';
$lang->rule->branchList['action']    = 'Action';

$lang->rule->relationList['include']         = 'Include';
$lang->rule->relationList['belong']          = 'Belong';
$lang->rule->relationList['parent']          = 'Parent';
$lang->rule->relationList['child']           = 'Child';
$lang->rule->relationList['related']         = 'Related';
$lang->rule->relationList['transferredto']   = 'Transferred To';
$lang->rule->relationList['transferredfrom'] = 'Transferred From';
$lang->rule->relationList['generated']       = 'Generated';
$lang->rule->relationList['derivedfrom']     = 'Derived From';

$lang->rule->error = new stdClass();
$lang->rule->error->emptyObjectType       = 'Object Type cannot be empty';
$lang->rule->error->emptyModuleOrRelation = 'Module and Relation cannot be empty';
$lang->rule->error->emptyAction           = 'Action cannot be empty';
$lang->rule->error->noPreActions          = 'No pre-actions';
$lang->rule->error->noCompleteRule        = 'Must complete the rule';
$lang->rule->error->requiredFieldEmpty    = 'Required field cannot be empty';
$lang->rule->error->invalidEstimate       = 'Invalid estimate';
$lang->rule->error->notConsistency        = 'The system has detected a change in the pre-action. Please reset the trigger conditions and execution actions, then save.';
$lang->rule->error->errorBegin            = "The execution start time must be within the project start and end time, which are from %s to %s.";
$lang->rule->error->errorEnd              = "The execution end time must be within the project start and end time, which are from %s to %s.";
$lang->rule->error->beginGtEnd            = "The planned start time cannot be greater than the planned end time";

$lang->rule->notifyList = new stdClass();
$lang->rule->notifyList->subject = 'Mail Subject';
$lang->rule->notifyList->content = 'Mail Content';
$lang->rule->notifyList->toList  = 'Mail To';
$lang->rule->notifyList->route   = 'Mail Route';

$lang->rule->notice = new stdClass();
$lang->rule->notice->noCondition     = 'No conditions';
$lang->rule->notice->disable         = 'Are you sure you want to disable this rule?';
$lang->rule->notice->enable          = 'Are you sure you want to enable this rule?';
$lang->rule->notice->noRules         = "You haven't configured any rules yet. Please configure them first.";
$lang->rule->notice->delete          = 'Are you sure you want to delete this rule? Deleting the rule will also remove its execution logs. This action is irreversible and cannot be undone.';
$lang->rule->notice->needValue       = 'The value cannot be empty.';
$lang->rule->notice->requiredFields  = 'The mandatory fields cannot be removed.';
$lang->rule->notice->multiConditions = 'Multiple trigger conditions are matched from left to right, and only the first condition that is matched will be executed.';
$lang->rule->notice->delCondition    = 'Are you sure you want to delete this condition? Deleting it will also remove the execution actions under this condition.';
$lang->rule->notice->apiUnsupported  = 'Object type "%s" is not supported via API V2; the rule cannot be enabled.';
$lang->rule->notice->runAsInvalid    = 'Run-as account "%s" is invalid.';

$lang->rule->appendActionGroup = array();
$lang->rule->appendActionGroup['testcase'][] = array('text' => 'Run Case', 'value' => 'run');

$lang->rule->action = new stdclass();
$lang->rule->action->executed = array('main' => '$date, executed by <strong>$actor</strong>, the result is <strong>$extra</strong>.', 'extra' => 'resultList');
$lang->rule->action->designed = array('main' => '$date, designed by <strong>$actor</strong>.');
$lang->rule->action->enabled  = array('main' => '$date, enabled by <strong>$actor</strong>.');
$lang->rule->action->disabled = array('main' => '$date, disabled by <strong>$actor</strong>.');
