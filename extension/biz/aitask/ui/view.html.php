<?php
namespace zin;

include './common.html.php';

/* 格式化耗时 */
function formatDuration($seconds): string
{
    if(empty($seconds)) return '';

    $seconds = (float)$seconds;

    if($seconds < 60) return round($seconds) . 's';
    if($seconds < 3600) return round($seconds / 60) . 'min';

    return round($seconds / 3600, 1) . 'h';
}

/* 构建表格 */
$buildTable = function() use ($fields, $lang)
{
    if(empty($fields)) return $lang->aitask->noParams;

    $rows = array();
    foreach($fields as $field)
    {
        $rows[] = h::tr(
            h::td(
                setClass('text-center'),
                $field['name']
            ),
            h::td(
                setClass('text-center'),
                $field['value']
            )
        );
    }

    return h::table(setClass('table bordered'),
        h::tbody($rows)
    );
};

/* 构建主要内容区域 */
$buildDefaultSection = function() use ($lang, $agent, $objectTypeName, $objectName, $task, $buildTable, $config)
{
    $sections = array();

    $linkProps = array();
    if(!empty($task->objectType) && !in_array($task->objectType, array('product', 'project', 'productplan')))
    {
        $linkProps['data-toggle'] = 'modal';
        $linkProps['data-size']   = 'lg';
    }

    $sections[] = setting()
        ->title($lang->aitask->taskObject)
        ->render(function() use ($lang, $task, $objectTypeName, $objectName, $linkProps)
        {
            $moduleKey    = $config->ai->moduleNameMap[$task->objectType] ?? $task->objectType;
            $objectModule = $moduleKey == 'case' ? 'testcase' : ($task->objectType == 'plan' ? 'productplan' : $moduleKey);
            if($task->objectID)
            {
                return array(
                    span($lang->aitask->objectHint),
                    a(
                        set::href(createLink($objectModule, 'view', "id={$task->objectID}")),
                        set($linkProps),
                        "{$objectTypeName}#{$task->objectID} {$objectName}"
                    )
                );
            }

            return array(
                span($lang->aitask->objectHint),
                span(setClass('text-gray'), $objectTypeName)
            );
        });

    $sections[] = setting()
        ->title($lang->aitask->content)
        ->control('html')
        ->content(isset($agent->desc) ? $agent->desc : '');

    $sections[] = setting()
        ->title($lang->aitask->taskParams)
        ->render($buildTable);

    return $sections;
};

/* 构建结果区域 */
$buildSections = function() use ($lang, $buildTaskResults, $task)
{
    return array(
        div(
            setClass('detail-sections canvas shadow rounded px-6 py-4'),
            div(
                setClass('detail-section'),
                div(
                    setClass('detail-section-title row justify-between items-center gap-2'),
                    span(
                        setClass('text-md py-1 font-bold'),
                        $lang->aitask->result
                    ),
                    $task->result ? btn(
                        setClass('text-primary'),
                        set::type('ghost'),
                        on::click()->call('parent.openAITaskPopup', $task->id),
                        $lang->aitask->viewFullContent
                    ) : null
                ),
                div(
                    setClass('detail-section-content py-1'),
                    $buildTaskResults($task)
                )
            )
        )
    );
};

/* 构建信息区域 */
$buildTabs = function() use ($lang, $task, $users, $processStatus)
{
    $tabs = array();

    $statusList     = $lang->aitask->statusList;
    $basicInfoItems = array
    (
        $lang->aitask->teammate   => !empty($task->teammateName) ? $task->teammateName : '',
        $lang->aitask->assignedTo => !empty($task->assignedTo) ? zget($users, $task->assignedTo, $task->assignedTo) : '',
        $lang->aitask->type       => !empty($task->type) ? $task->type : '',
        $lang->aitask->taskStatus => array
        (
            'control' => 'status',
            'status'  => $task->status,
            'text'    => isset($statusList[$task->status]) ? $statusList[$task->status] : $task->status
        ),
        $lang->aitask->consumed   => array
        (
            'class'   => 'with-hint',
            'content' => function() use ($lang, $task)
            {
                return div
                (
                    icon('help', set::title($lang->aitask->tips->consumedTips)),
                    span(formatDuration($task->consumed ?? 0))
                );
            }
        ),
        $lang->aitask->tokenUsed  => array
        (
            'class'   => 'with-hint',
            'content' => function() use ($lang, $task)
            {
                return div
                (
                    icon('help', set::title($lang->aitask->tips->tokenUsedTips)),
                    span(isset($task->token) ? $task->token : '')
                );
            }
        )
    );

    $tabs[] = setting()
        ->group('basic')
        ->title($lang->aitask->basicInfo)
        ->control('datalist')
        ->labelWidth(100)
        ->items($basicInfoItems)
        ->statusText($processStatus);

    $lifeInfoItems = array
    (
        $lang->aitask->createdBy     => !empty($task->createdBy) && !empty($task->createdDate) ? zget($users, $task->createdBy, $task->createdBy) . $lang->at . $task->createdDate : '',
        $lang->aitask->verifiedBy    => !empty($task->verifiedBy) && !empty($task->verifiedDate) ? zget($users, $task->verifiedBy, $task->verifiedBy) . $lang->at . $task->verifiedDate : '',
        $lang->aitask->closedBy      => !empty($task->closedBy) && !empty($task->closedDate) ? zget($users, $task->closedBy, $task->closedBy) . $lang->at . $task->closedDate : '',
        $lang->aitask->cancelledBy   => !empty($task->cancelledBy) && !empty($task->cancelledDate) ? zget($users, $task->cancelledBy, $task->cancelledBy) . $lang->at . $task->cancelledDate : '',
        $lang->aitask->activatedBy   => !empty($task->activatedBy) && !empty($task->activatedDate) ? zget($users, $task->activatedBy, $task->activatedBy) . $lang->at . $task->activatedDate : ''
    );

    $tabs[] = setting()
        ->group('basic')
        ->title($lang->aitask->lifeTime)
        ->control('datalist')
        ->labelWidth(100)
        ->items($lifeInfoItems);

    return $tabs;
};

/* 构建操作区域 */
$buildActions = function() use ($operateActions, $task, $isAssignedTo)
{
    $actions = $operateActions;

    foreach($actions as $key => &$action)
    {
        if(!is_array($action) || (isset($action['type']) && $action['type'] === 'divider')) continue;

        $actionKey = isset($action['key']) ? $action['key'] : (is_string($key) ? $key : '');

        if($actionKey == 'back') continue;

        if($actionKey == 'assignTo' && !$isAssignedTo)
        {
            unset($actions[$key]);
            continue;
        }

        if($actionKey == 'delete')
        {
            if(!$isAssignedTo)
            {
                unset($actions[$key]);
                continue;
            }
            if(isset($action['url'])) $action['url'] .= '&from=view';
        }

        if($actionKey == 'verify' && (!$isAssignedTo || $task->status != 'done'))
        {
            unset($actions[$key]);
            continue;
        }

        if($actionKey == 'cancel' && (!$isAssignedTo || !in_array($task->status, array('wait', 'doing', 'done', 'fail'))))
        {
            unset($actions[$key]);
            continue;
        }

        if($actionKey == 'activate' && (!$isAssignedTo || $task->status != 'cancel'))
        {
            unset($actions[$key]);
            continue;
        }

        if($actionKey == 'retry' && (!$isAssignedTo || $task->status != 'fail'))
        {
            unset($actions[$key]);
        }
    }
    unset($action);

    $actions = array_values($actions);

    foreach($actions as $index => $action)
    {
        if(($action['type'] ?? '') !== 'divider') continue;

        $isEdge   = ($index === 0 || $index === count($actions) - 1);
        $isRepeat = (($actions[$index - 1]['type'] ?? '') === 'divider');

        if($isEdge || $isRepeat) unset($actions[$index]);
    }

    $actions = array_values($actions);

    return $actions;
};

detail(
    set::objectType('aitask'),
    set::objectID($task->id),
    set::object($task),
    set::title($title),
    set::urlFormatter(array('{id}' => $task->id)),
    set::backBtn(array('url' => createLink('aitask', 'browse') . '#app=aiapp')),
    set::sections($buildDefaultSection()),
    set::tabs($buildTabs()),
    set::actions($buildActions()),
    to::sections($buildSections())
);
