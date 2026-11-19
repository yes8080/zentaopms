<?php
$lang->aitask->name        = 'Name';
$lang->aitask->object      = 'Related Object';
$lang->aitask->assignedTo  = 'Assigned To';
$lang->aitask->status      = 'Status';
$lang->aitask->taskStatus  = 'Task Status';
$lang->aitask->type        = 'Task Type';
$lang->aitask->createdDate = 'Created Date';
$lang->aitask->list        = 'Teammate Task List';
$lang->aitask->verified    = 'Verified';
$lang->aitask->noResults   = 'No results';
$lang->aitask->refined     = 'Refined';
$lang->aitask->retry       = 'Retry';
$lang->aitask->cancel      = 'Cancel';
$lang->aitask->activate    = 'Activate';
$lang->aitask->exec        = 'Execute';
$lang->aitask->mine        = 'With Me';
$lang->aitask->noTask      = 'No AI teammate tasks';
$lang->aitask->browse      = 'Browse AI teammate task';
$lang->aitask->viewOption  = 'View AI teammate task detail';

$lang->aitask->activateSuccess = 'Activated Success';
$lang->aitask->cancelSuccess   = 'Cancelled Success';
$lang->aitask->retrySuccess    = 'Retried successfully';

$lang->aitask->statusList['done']   = 'Done';
$lang->aitask->statusList['wait']   = 'Wait';
$lang->aitask->statusList['closed'] = 'Closed';
$lang->aitask->statusList['doing']  = 'Doing';
$lang->aitask->statusList['fail']   = 'Fail';
$lang->aitask->statusList['cancel'] = 'Cancel';

$lang->aitask->featureBar['browse']['all'] = 'All Tasks';
$lang->aitask->featureBar['browse']        = array_merge($lang->aitask->featureBar['browse'], $lang->aitask->statusList);

$lang->aitask->view          = 'View AI teammate task';
$lang->aitask->basicInfo     = 'Basic Info';
$lang->aitask->lifeTime      = 'Task Lifetime';
$lang->aitask->content       = 'Task Content';
$lang->aitask->result        = 'Task Result';
$lang->aitask->userPrompt    = 'Prompt';
$lang->aitask->consumed      = 'Total Consumed';
$lang->aitask->tokenUsed     = 'Token Used';
$lang->aitask->teammate      = 'AI Teammate';
$lang->aitask->createdBy     = 'Created By';
$lang->aitask->createdDate   = 'Created Date';
$lang->aitask->verifiedBy    = 'Verified By';
$lang->aitask->verifiedDate  = 'Verified Date';
$lang->aitask->closedBy      = 'Closed By';
$lang->aitask->closedDate    = 'Closed Date';
$lang->aitask->cancelledBy   = 'Cancelled By';
$lang->aitask->cancelledDate = 'Cancelled Date';
$lang->aitask->activatedBy   = 'Activated By';
$lang->aitask->activatedDate = 'Activated Date';
$lang->aitask->desc          = 'Description';
$lang->aitask->objectType    = 'Object Type';
$lang->aitask->objectID      = 'Object ID';
$lang->aitask->agents        = 'Agents';
$lang->aitask->agentsData    = 'Form Data';
$lang->aitask->klibs         = 'Knowledge Libraries';
$lang->aitask->chatID        = 'Chat ID';
$lang->aitask->token         = 'Tokens Consumed';
$lang->aitask->notFound      = 'Task not found';
$lang->aitask->titleFormat   = 'To %s %s Perform %s';
$lang->aitask->taskObject    = 'Task Object';
$lang->aitask->objectHint    = 'The object that needs to be processed is ';
$lang->aitask->taskParams    = 'Task Params';
$lang->aitask->noParams      = 'No Params';
$lang->aitask->executedBy    = 'Executed By';
$lang->aitask->executedDate  = 'Executed Date';
$lang->aitask->finishedDate  = 'Finished Date';
$lang->aitask->failedReason  = 'Failed Reason';

$lang->aitask->reviewOpinion     = 'Review Opinion';
$lang->aitask->remarkPlaceholder = 'Enter description';
$lang->aitask->viewFullContent   = 'View full context';

$lang->aitask->resultList['pass']   = 'Pass';
$lang->aitask->resultList['refine'] = 'Refine';

$lang->aitask->action = new stdclass();
$lang->aitask->action->retried   = '$date, retried by <strong>$actor</strong>.';
$lang->aitask->action->canceled  = '$date, cancelled by <strong>$actor</strong>.';
$lang->aitask->action->activated = '$date, activated by <strong>$actor</strong>.';
$lang->aitask->action->verified  = '$date, verified by <strong>$actor</strong>.';
$lang->aitask->action->refined   = '$date, refined by <strong>$actor</strong>.';
$lang->aitask->action->executing = '$date, executed by <strong>$actor</strong>, $extra.';
$lang->aitask->action->assigned  = '$date, <strong>$actor</strong> assigned to <strong>$extra</strong>.';

$lang->aitask->tips = new stdclass();
$lang->aitask->tips->confirmDelete   = 'Are you sure you want to delete it?';
$lang->aitask->tips->confirmCancel   = 'Are you sure you want to cancel it?';
$lang->aitask->tips->confirmActivate = 'After activation, the selected task status changes to Not Started. Are you sure you want to activate it?';
$lang->aitask->tips->confirmVerify   = 'Are you sure you want to verify it?';
$lang->aitask->tips->confirmRetry    = 'Are you sure you want to retry it?';
$lang->aitask->tips->consumedTips    = 'The sum of cumulative consumption time accumulated by AI Teammates processing tasks.';
$lang->aitask->tips->tokenUsedTips   = 'The sum of cumulative Tokens consumed by AI Teammates processing tasks.';

/* AI Task Execution: */
$lang->aitask->exceedsMaxParallel = 'Exceeds maximum parallel execution tasks, please try again later';
$lang->aitask->noWaitingTask      = 'No waiting tasks';
$lang->aitask->taskIsNotWaiting   = 'Task is not in waiting status';
$lang->aitask->startExecuting     = 'Start executing task';
$lang->aitask->executeFailed      = 'Task execution failed, please retry';
$lang->aitask->timeout            = 'Timeout';
$lang->aitask->executeTimeout     = 'Task execution timeout, please retry';
$lang->aitask->executeSuccess     = 'Task executed successfully';
$lang->aitask->noAgentToExecute   = 'No available agent, please check agent status';
$lang->aitask->taskFailed         = 'Task execution failed';
$lang->aitask->taskExecuted       = 'Task executed successfully';
$lang->aitask->assignTo           = 'Assign';
$lang->aitask->assignToAction     = $lang->aitask->assignTo;
$lang->aitask->noPermission       = 'No permission';
$lang->aitask->onlyPostRequest    = 'Only POST requests are allowed';
