<?php
namespace zin;

global $lang, $app, $config;
$version  = data('version');
$task     = data('task');
$onItem   = $version ? $version : $task->version;
$taskSpec = data('taskSpec');

jsVar('canViewProgress', hasPriv('approval', 'progress'));
jsVar('viewApprovalProgress',  $lang->project->viewApprovalProgress);
jsVar('deliverableFrozenTips', $lang->project->deliverableFrozenTips);
jsVar('updateVersionLang',     $lang->project->updateVersion);

$versionItems = array();
for($i = $task->version; $i > 0; $i--)
{
    $versionItems[] = array('value' => $i, 'text' => "#{$i}", 'url' => createLink('task', 'view', "taskID={$taskID}&version={$i}"), 'active' => $onItem == $i);
}

if($version)
{
    $task->name       = $taskSpec->name;
    $task->estStarted = $taskSpec->estStarted;
    $task->deadline   = $taskSpec->deadline;
    if(in_array($task->status, array('wait', 'doing'))) $task->delay = helper::diffDate(helper::today(), $taskSpec->deadline);
}

$project        = $app->control->loadModel('project')->fetchById($task->project);
$hasDeliverable = $project ? $app->control->loadModel('workflowgroup')->hasFeature($project->workflowGroup, 'deliverable') : true;
if($hasDeliverable)
{
    $app->loadLang('review');
    $taskDeliverables = $app->control->task->getDeliverables($task->id);
    $taskDeliverables = initTableData($taskDeliverables, $config->task->deliverable->dtable->fieldList, $app->control->project);

    foreach($taskDeliverables as $deliverable)
    {
        if(empty($deliverable->status)) continue;

        if($deliverable->hasApproval == 0)
        {
            $deliverable->status = $deliverable->status == 'pass' ? $lang->project->confirmed : $lang->project->needConfirm;
        }
        else
        {
            $deliverable->status = zget($lang->review->statusList, $deliverable->status) . ($deliverable->isConditionalPassApproval ? '(' . $lang->review->resultList['conditional'] . ')' : '');
        }
    }

    $config->task->deliverable->dtable->fieldList['status']['statusMap'] = $lang->review->statusList;
    if(!empty($task->deleted)) unset($config->task->deliverable->dtable->fieldList['actions']);

    query('detail')->each(function($node) use($versionItems, $onItem, $task, $taskDeliverables)
    {
        global $lang, $config;

        $title[] = $task->name;
        $title[] = dropdown
        (
            btn(setClass('ml-2 text-base font-medium ghost bg-gray-200 bg-opacity-50'), "#{$onItem}"),
            set::items($versionItems)
        );

        $submitActions    = array();
        $dtableConfig     = array();
        $firstDeliverable = current($taskDeliverables);
        if(!empty($firstDeliverable) && empty($task->deleted)) $submitActions = array(array('text' => $lang->task->submit, 'size' => 'sm', 'class' => 'ghost', 'icon' => 'plus', 'url' => createLink('project', 'createDeliverable', "projectID={$task->project}&deliverableID=" . zget($firstDeliverable, 'deliverableID', 0) . "&taskID={$task->id}"), 'data-toggle' => 'modal'));
        if(!empty($taskDeliverables)) $dtableConfig  = array('control' => 'dtable', 'cols' => array_values($config->task->deliverable->dtable->fieldList), 'data' => $taskDeliverables, 'userMap' => data('users'), 'plugins' => array('cellspan'), 'getCellSpan' => jsRaw('window.getCellSpan'), 'onRenderCell' => jsRaw('window.onRenderCell'));

        $sections = $node->prop('sections');
        $sections[] = setting()
            ->title($lang->task->deliverable)
            ->control($dtableConfig)
            ->titleActions($submitActions);

        $node->setProp('object', $task);
        $node->setProp('title', $title);
        $node->setProp('titleProps', $task->name);
        $node->setProp('sections', $sections);
    });
}
