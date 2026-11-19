<?php
$lang->aiprocedure->common              = 'AI Procedure';
$lang->aiprocedure->browse              = 'Browse Procedure';
$lang->aiprocedure->create              = 'Create Procedure';
$lang->aiprocedure->view                = 'Procedure Detail';
$lang->aiprocedure->edit                = 'Edit';
$lang->aiprocedure->design              = 'Design';
$lang->aiprocedure->publish             = 'Publish';
$lang->aiprocedure->unpublish           = 'Unpublish';
$lang->aiprocedure->delete              = 'Delete Procedure';
$lang->aiprocedure->name                = 'Name';
$lang->aiprocedure->module              = 'Display Location';
$lang->aiprocedure->desc                = 'Description';
$lang->aiprocedure->status              = 'Status';
$lang->aiprocedure->createdBy           = 'Created By';
$lang->aiprocedure->createdDate         = 'Created Date';
$lang->aiprocedure->finishedDate        = 'Finished Date';
$lang->aiprocedure->publishedBy         = 'Published By';
$lang->aiprocedure->unpublishedBy       = 'Unpublished By';
$lang->aiprocedure->lastEdited          = 'Last Edited';
$lang->aiprocedure->basicInfo           = 'Basic Info';
$lang->aiprocedure->steps               = 'Steps';
$lang->aiprocedure->back                = 'Back';
$lang->aiprocedure->noData              = 'No procedure';
$lang->aiprocedure->notFound            = 'Procedure not found';
$lang->aiprocedure->confirmDelete       = 'After deleting, the procedure will no longer be available. Are you sure you want to delete it?';
$lang->aiprocedure->designNeedUnpublish = 'Unpublish the procedure before designing it';
$lang->aiprocedure->publishNeedSteps    = 'Publishing failed. Design execution steps for the procedure before publishing it';
$lang->aiprocedure->saveNeedFinishRun   = 'Saving failed. A procedure is in progress. Complete or end it before saving';
$lang->aiprocedure->procedureRef        = '"%s" procedure';
$lang->aiprocedure->agentUnpublishNotice = 'The published %s are using this agent. Unpublishing the agent will also unpublish those procedures, and you will need to publish them manually again.';
$lang->aiprocedure->publishNeedActiveAgents = 'Publishing failed. The agent "%s" in the procedure is unpublished or deleted. Publish the agent before publishing the procedure.';
$lang->aiprocedure->viewHistory         = 'View procedure history';
$lang->aiprocedure->history             = 'Procedure History';
$lang->aiprocedure->noHistory           = 'No history records';
$lang->aiprocedure->procedureRunCreated = 'The procedure task has been created, please execute the steps in the workbench';
$lang->aiprocedure->procedureRunStopped = 'Procedure ended';
$lang->aiprocedure->stopProcedureRunFailed = 'Unable to end the procedure. Please refresh and try again.';
$lang->aiprocedure->start               = 'Start';

$lang->aiprocedure->appLabels = array();
$lang->aiprocedure->appLabels['load-failed-title']     = 'Data Load Failed';
$lang->aiprocedure->appLabels['load-failed-message']   = 'Please try again later';
$lang->aiprocedure->appLabels['save-failed-title']     = 'Save Failed';
$lang->aiprocedure->appLabels['save-failed-message']   = 'Please check if the content is correct';
$lang->aiprocedure->appLabels['save-success']          = 'Save Successful';
$lang->aiprocedure->appLabels['publish-success']       = 'Publish Successful';
$lang->aiprocedure->appLabels['step-config']           = 'Step Config';
$lang->aiprocedure->appLabels['step-output']           = 'Step output';
$lang->aiprocedure->appLabels['last-step-warning']     = 'At least one step must be kept';
$lang->aiprocedure->appLabels['select-agent']          = 'Select Agent';
$lang->aiprocedure->appLabels['agent-required']        = 'Please select an agent';
$lang->aiprocedure->appLabels['select-input']          = 'Select Input';
$lang->aiprocedure->appLabels['select-input-hint']     = 'Select previous step outputs as this step prompt';
$lang->aiprocedure->appLabels['output-last-answer']    = 'Last Answer';
$lang->aiprocedure->appLabels['output-modified-object']= 'Modified Object';
$lang->aiprocedure->appLabels['output-docs']           = 'Document';
$lang->aiprocedure->appLabels['save']                  = 'Save';
$lang->aiprocedure->appLabels['publish']               = 'Publish';
$lang->aiprocedure->appLabels['agent-status-draft']    = 'Unpublished';
$lang->aiprocedure->appLabels['agent-status-deleted']  = 'Deleted';
$lang->aiprocedure->appLabels['publish-failed-title']  = 'Publishing failed';
$lang->aiprocedure->appLabels['publish-need-active-agents'] = 'The agent "%s" in the procedure is unpublished or deleted. Publish the agent before publishing the procedure.';
$lang->aiprocedure->appLabels['confirm']               = 'Confirm';
$lang->aiprocedure->appLabels['agent-process-object']  = 'Process Object';
$lang->aiprocedure->appLabels['agent-action-purpose']  = 'Action Purpose';
$lang->aiprocedure->appLabels['agent-display-position']= 'Display Position';
$lang->aiprocedure->appLabels['agent-role']            = 'Role';
$lang->aiprocedure->appLabels['agent-purpose']         = 'Prompt';
$lang->aiprocedure->appLabels['agent-skills-list']     = 'Skills';
$lang->aiprocedure->appLabels['agent-knowledge-list']  = 'Knowledge Libs';
$lang->aiprocedure->appLabels['start']                 = 'Start';
$lang->aiprocedure->appLabels['end']                   = 'End';
$lang->aiprocedure->appLabels['step']                  = 'Step';

$lang->aiprocedure->moduleList = array();
$lang->aiprocedure->moduleList['story']       = $lang->SRCommon;
$lang->aiprocedure->moduleList['requirement'] = $lang->URCommon;
$lang->aiprocedure->moduleList['epic']        = $lang->ERCommon;
$lang->aiprocedure->moduleList['task']        = 'Task';
$lang->aiprocedure->moduleList['bug']         = 'Bug';
$lang->aiprocedure->moduleList['feedback']    = 'Feedback';
$lang->aiprocedure->moduleList['ticket']      = 'Ticket';

$lang->aiprocedure->statusList = array();
$lang->aiprocedure->statusList['draft']  = 'Draft';
$lang->aiprocedure->statusList['active'] = 'Published';

$lang->aiprocedure->featureBar['browse']['all']    = 'All';
$lang->aiprocedure->featureBar['browse']['active'] = 'Published';
$lang->aiprocedure->featureBar['browse']['draft']  = 'Draft';

$lang->aiprocedure->workbench   = 'Workbench';
$lang->aiprocedure->myTodo      = 'My To-Dos';
$lang->aiprocedure->objectTypes = array_merge(array('all' => 'All'), $lang->aiprocedure->moduleList);

foreach($lang->aiprocedure->moduleList as $type => $objectTypeName)
{
    $lang->aiprocedure->moduleList[$type] = $objectTypeName . ' Detail';
}

$lang->aiprocedure->procedureRunStatus = [];
$lang->aiprocedure->procedureRunStatus['doing'] = 'Pending';
$lang->aiprocedure->procedureRunStatus['done']  = 'Done';
$lang->aiprocedure->procedureRunStatus['ended'] = 'Terminated';

$lang->aiprocedure->deadlineInfo    = 'Due %s';
$lang->aiprocedure->alreadyRunning  = 'A procedure is already running and a new one cannot be started';
$lang->aiprocedure->unpublishNotice = 'After unpublishing, the procedure will no longer be available. Are you sure you want to unpublish it?';
$lang->aiprocedure->selectedTypes   = '{count} types selected';
$lang->aiprocedure->noTodo          = 'No to-do items';

$lang->aiprocedure->appLang = new stdClass();

$lang->aiprocedure->appLang->objectTypes          = $lang->aiprocedure->objectTypes;
$lang->aiprocedure->appLang->fillFormInfo         = 'Please fill in the form content:';
$lang->aiprocedure->appLang->generate             = 'Start step';
$lang->aiprocedure->appLang->regenerate           = 'Regenerate';
$lang->aiprocedure->appLang->returnToCurrentStep  = 'Return to current step';
$lang->aiprocedure->appLang->historyReadonlyHint  = 'Viewing a previous step. Forms and conversations are read-only and cannot be changed or regenerated.';
$lang->aiprocedure->appLang->stepFormData         = 'Step form data';
$lang->aiprocedure->appLang->noStepFormData       = 'No saved form data for this step';
$lang->aiprocedure->appLang->noStepChat           = 'No conversation history for this step';
$lang->aiprocedure->appLang->acceptAndContinue    = 'Next step';
$lang->aiprocedure->appLang->complete             = 'Complete procedure';
$lang->aiprocedure->appLang->stopProcedureRun     = 'End procedure';
$lang->aiprocedure->appLang->running              = 'Running';
$lang->aiprocedure->appLang->confirmStopProcedureRun = 'End the procedure "{name}"? Saved step data will be kept, and remaining steps will not run.';
$lang->aiprocedure->appLang->stopProcedureRunFailed = $lang->aiprocedure->stopProcedureRunFailed;
$lang->aiprocedure->appLang->noChatHint           = 'Enter information on the left, then click "Start step" to begin the AI conversation';
$lang->aiprocedure->appLang->generating           = 'Generating...';
$lang->aiprocedure->appLang->generateFailed       = 'Generation failed. Please try again.';
$lang->aiprocedure->appLang->stepResultPrefix     = 'The execution result of step {title} is as follows:';
$lang->aiprocedure->appLang->stepResultActions    = ['add' => 'Added', 'update' => 'Updated', 'delete' => 'Deleted'];
$lang->aiprocedure->appLang->stepResultChangeInfo = '{action} {count} {objectName} ({objectType}), ID: {ids};';
$lang->aiprocedure->appLang->stepPromptPrefix     = 'The object initially selected by the user is {objectType} #{objectID}.';
$lang->aiprocedure->appLang->stepPurposeHint      = 'If related data is missing while completing the user task, ask the user or use the `getZentaoObject` tool to obtain enough information. If multiple objects need to be processed but cannot be handled at once, process them one by one.';
$lang->aiprocedure->appLang->promptExecuteFailed  = 'The ZenTao agent call failed. Please use the ZenTao API instead to complete the "{action}" operation.';
