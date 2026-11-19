<?php
$config->rule = new stdClass();
$config->rule->actions = new stdclass();
$config->rule->actions->view = array();
$config->rule->actions->view['mainActions']   = array('design', 'enable', 'disable', 'log', 'notify');
$config->rule->actions->view['suffixActions'] = array('edit', 'copy', 'delete');

$config->rule->defaultNodes = array();
$config->rule->defaultNodes[] = array('type' => 'when', 'id' => 'when', 'data' => array());
$config->rule->defaultNodes[] = array
(
    'type' => 'conditions',
    'data' => array
    (
        array
        (
            'condition' => array('type' => 'condition', 'data' => array()),
            'actions' => array
            (
                'type' => 'actions',
                'data' => array
                (
                    array('type' => 'action', 'data' => array())
                )
            )
        )
    )
);

global $lang;
$config->rule->search['module']                   = 'rule';
$config->rule->search['fields']['name']           = $lang->rule->name;
$config->rule->search['fields']['type']           = $lang->rule->type;
$config->rule->search['fields']['status']         = $lang->rule->status;
$config->rule->search['fields']['workflowGroup']  = $lang->rule->workflowGroup;
$config->rule->search['fields']['method']         = $lang->rule->method;
$config->rule->search['fields']['createdBy']      = $lang->rule->createdBy;
$config->rule->search['fields']['lastEditedBy']   = $lang->rule->lastEditedBy;
$config->rule->search['fields']['lastEditedDate'] = $lang->rule->lastEditedDate;
$config->rule->search['fields']['lastRunTime']    = $lang->rule->lastRunTime;
$config->rule->search['fields']['lastRunResult']  = $lang->rule->lastRunResult;

$config->rule->search['params']['name']           = array('operator' => 'include', 'control' => 'input',   'values' => '');
$config->rule->search['params']['type']           = array('operator' => '=',       'control' => 'select',  'values' => $lang->rule->typeList);
$config->rule->search['params']['status']         = array('operator' => '=',       'control' => 'select',  'values' => $lang->rule->statusList);
$config->rule->search['params']['workflowGroup']  = array('operator' => 'include', 'control' => 'select',  'values' => '');
$config->rule->search['params']['method']         = array('operator' => '=',       'control' => 'select',  'values' => $lang->rule->methodList);
$config->rule->search['params']['createdBy']      = array('operator' => '=',       'control' => 'select',  'values' => 'users');
$config->rule->search['params']['lastEditedBy']   = array('operator' => '=',       'control' => 'select',  'values' => 'users');
$config->rule->search['params']['lastEditedDate'] = array('operator' => '=',       'control' => 'date',    'values' => '');
$config->rule->search['params']['lastRunTime']    = array('operator' => '=',       'control' => 'date',    'values' => '');
$config->rule->search['params']['lastRunResult']  = array('operator' => '=',       'control' => 'select',  'values' => $lang->rule->resultList);

$config->rule->objectForm = new stdclass();
$config->rule->objectForm->requiredFields = new stdclass();
$config->rule->objectForm->requiredFields->project     = 'model,products,workflowGroup,multiple';
$config->rule->objectForm->requiredFields->product     = 'workflowGroup,type';
$config->rule->objectForm->requiredFields->execution   = 'project,products,type';
$config->rule->objectForm->requiredFields->epic        = 'product';
$config->rule->objectForm->requiredFields->requirement = 'product';
$config->rule->objectForm->requiredFields->story       = 'product';
$config->rule->objectForm->requiredFields->bug         = 'product';

$config->rule->objectForm->allFields = new stdclass();
$config->rule->objectForm->allFields->project     = array('parent', 'name', 'code', 'multiple', 'hasProduct', 'PM', 'budget', 'begin', 'end', 'desc', 'acl', 'model', 'products', 'workflowGroup');
$config->rule->objectForm->allFields->product     = array('program', 'type', 'name', 'code', 'PO', 'QD', 'RD', 'desc', 'acl', 'workflowGroup');
$config->rule->objectForm->allFields->epic        = array('product', 'branch', 'module', 'plan', 'assignedTo', 'reviewer', 'source', 'sourceNote', 'reviewer', 'parent', 'title', 'category', 'pri', 'estimate', 'spec', 'verify', 'keywords');
$config->rule->objectForm->allFields->requirement = $config->rule->objectForm->allFields->epic;
$config->rule->objectForm->allFields->story       = $config->rule->objectForm->allFields->epic;
$config->rule->objectForm->allFields->execution   = array('project', 'name', 'code', 'begin', 'end', 'desc', 'lifetime', 'attribute', 'products', 'PM', 'PO', 'QD', 'RD', 'acl');
$config->rule->objectForm->allFields->bug         = array('title', 'openedBuild', 'product', 'branch', 'module', 'project', 'execution', 'assignedTo', 'deadline', 'type', 'os', 'browser', 'severity', 'pri', 'steps', 'story', 'task', 'case', 'keywords');
$config->rule->objectForm->allFields->task        = array('execution', 'type', 'parent', 'assignedTo', 'module', 'story', 'name', 'pri', 'estimate', 'desc', 'estStarted', 'deadline', 'keywords');
$config->rule->objectForm->allFields->testcase    = array('product', 'branch', 'module', 'type', 'stage', 'story', 'title', 'pri', 'precondition', 'keywords');

$config->rule->objectForm->ignoreFields = new stdclass();
$config->rule->objectForm->ignoreFields->product     = array('workflowGroup', 'acl');
$config->rule->objectForm->ignoreFields->project     = array('model', 'products', 'workflowGroup', 'multiple', 'program', 'acl');
$config->rule->objectForm->ignoreFields->execution   = array('project', 'lifetime', 'attribute', 'products', 'acl', 'type');
$config->rule->objectForm->ignoreFields->epic        = array('title', 'product', 'module', 'plan', 'spec', 'verify');
$config->rule->objectForm->ignoreFields->story       = $config->rule->objectForm->ignoreFields->epic;
$config->rule->objectForm->ignoreFields->requirement = $config->rule->objectForm->ignoreFields->epic;
$config->rule->objectForm->ignoreFields->task        = array('story', 'module', 'execution', 'parent');
$config->rule->objectForm->ignoreFields->bug         = array('product', 'module', 'story', 'task', 'openedBuild', 'project', 'execution');
$config->rule->objectForm->ignoreFields->testcase    = array('product', 'module', 'story');

$config->rule->conditionForm = new stdclass();
$config->rule->conditionForm->ignoreFields = new stdclass();
$config->rule->conditionForm->ignoreFields->project   = array('project', 'parent', 'output', 'path', 'grade', 'pri', 'version', 'parentVersion', 'order', 'vision', 'openedVersion');
$config->rule->conditionForm->ignoreFields->execution = array('parent', 'output', 'path', 'grade', 'pri', 'version', 'lifetime', 'parentVersion', 'order', 'vision', 'fluidBoard', 'openedVersion');
$config->rule->conditionForm->ignoreFields->task      = array('lines', 'v1', 'v2', 'vision', 'mr', 'entry', 'repo', 'finishedList', 'color');

$config->rule->relationList['product']['include'] = array('epic', 'requirement', 'story', 'bug', 'testcase');
$config->rule->relationList['product']['related'] = array('project', 'execution');

$config->rule->relationList['epic']['belong']  = array('product');
$config->rule->relationList['epic']['parent']  = array('epic');
$config->rule->relationList['epic']['child']   = array('epic');
$config->rule->relationList['epic']['related'] = array('project', 'execution');

$config->rule->relationList['requirement']['belong']  = array('product');
$config->rule->relationList['requirement']['parent']  = array('epic', 'requirement');
$config->rule->relationList['requirement']['child']   = array('requirement', 'story');
$config->rule->relationList['requirement']['related'] = array('project', 'execution');

$config->rule->relationList['story']['belong']          = array('product');
$config->rule->relationList['story']['parent']          = array('requirement', 'story');
$config->rule->relationList['story']['child']           = array('story');
$config->rule->relationList['story']['related']         = array('project', 'execution');
$config->rule->relationList['story']['generated']       = array('task', 'bug', 'testcase');
$config->rule->relationList['story']['transferredfrom'] = array('bug');

$config->rule->relationList['project']['related'] = array('product', 'epic', 'requirement', 'story', 'testcase');
$config->rule->relationList['project']['include'] = array('execution', 'task', 'bug');

$config->rule->relationList['execution']['related'] = array('product', 'epic', 'requirement', 'story', 'testcase');
$config->rule->relationList['execution']['belong']  = array('project');
$config->rule->relationList['execution']['parent']  = array('execution');
$config->rule->relationList['execution']['child']   = array('execution');
$config->rule->relationList['execution']['include'] = array('task', 'bug');

$config->rule->relationList['task']['derivedfrom']     = array('story');
$config->rule->relationList['task']['transferredfrom'] = array('bug');
$config->rule->relationList['task']['belong']          = array('project', 'execution');

$config->rule->relationList['bug']['belong']        = array('product', 'project', 'execution');
$config->rule->relationList['bug']['derivedfrom']   = array('story', 'testcase');
$config->rule->relationList['bug']['transferredto'] = array('task', 'story');

$config->rule->relationList['testcase']['related']     = array('project', 'execution');
$config->rule->relationList['testcase']['belong']      = array('product');
$config->rule->relationList['testcase']['derivedfrom'] = array('story');
$config->rule->relationList['testcase']['generated']   = array('bug');
