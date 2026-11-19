<?php
$lang->rulequeue = new stdClass();

$lang->rulequeue->triggeredBy   = 'Triggered By';
$lang->rulequeue->triggeredDate = 'Triggered Date';
$lang->rulequeue->executedTime  = 'Executed Time';
$lang->rulequeue->status        = 'Status';
$lang->rulequeue->log           = 'Log';
$lang->rulequeue->run           = 'Run Rule';

$lang->rulequeue->statusList['wait']    = 'Waiting';
$lang->rulequeue->statusList['doing']   = 'Doing';
$lang->rulequeue->statusList['success'] = 'Success';
$lang->rulequeue->statusList['fail']    = 'Fail';

$lang->rulequeue->noUpdateList  = 'No updatable object found.';
$lang->rulequeue->noDeleteList  = 'No deletable object found.';
$lang->rulequeue->affectObjects = 'Affected objects: %s';
$lang->rulequeue->maxLimit      = 'A single rule can update a maximum of 200 objects. Currently, %s objects have been matched, and the rule will not be executed.';

$lang->rulequeue->error = new stdClass();
$lang->rulequeue->error->overParentBegin          = 'Execution start and end time cannot exceed the project start and end time.';
$lang->rulequeue->error->noPriv                   = 'The triggering user does not have permission';
$lang->rulequeue->error->productNotInProject      = 'The associated product is not in the project.';
$lang->rulequeue->error->projectCannotBeChanged   = 'Closed projects cannot be modified.';
$lang->rulequeue->error->productCannotBeChanged   = 'Closed products cannot be modified.';
$lang->rulequeue->error->executionCannotBeChanged = 'Closed executions cannot be modified.';
$lang->rulequeue->error->apiUnsupported           = 'Object type "%s" is not supported via API V2 yet.';
$lang->rulequeue->error->apiNoBaseUrl             = 'Cannot resolve site URL for API V2 (check host or mail domain).';
$lang->rulequeue->error->apiInvalidResponse       = 'API V2 returned an invalid response.';
$lang->rulequeue->error->apiFail                  = 'API V2 request failed.';
$lang->rulequeue->error->apiNoId                  = 'API V2 create succeeded but returned no object ID.';
$lang->rulequeue->error->runAsInvalid             = 'Run-as account "%s" is invalid.';

$lang->rulequeue->alert = new stdClass();
$lang->rulequeue->alert->noticeTitle    = 'Alert Notice';
$lang->rulequeue->alert->defaultContent = '[%s] You have %s %s triggered "%s" rule. Please pay attention!';
$lang->rulequeue->alert->objectItem     = '<a href="%s">[#%s::%s]</a>.';
$lang->rulequeue->alert->mailSubject    = 'Alert digest';
$lang->rulequeue->alert->mailItem       = 'Rule "%s" matched %s item(s)';
$lang->rulequeue->alert->noticeItem     = 'Alert rule "%s" matched %s object(s).';
$lang->rulequeue->alert->idAB           = 'ID';
$lang->rulequeue->alert->beginDate      = 'Start Date';
$lang->rulequeue->alert->deadline       = 'Deadline';
$lang->rulequeue->alert->svRate         = 'Schedule Variance';

$lang->rulequeue->alert->objectTitle['project']   = 'Project Title';
$lang->rulequeue->alert->objectTitle['execution'] = 'Execution Title';
$lang->rulequeue->alert->objectTitle['task']      = 'Task Title';
$lang->rulequeue->alert->objectTitle['risk']      = 'Risk Title';
$lang->rulequeue->alert->objectTitle['issue']     = 'Issue Title';
