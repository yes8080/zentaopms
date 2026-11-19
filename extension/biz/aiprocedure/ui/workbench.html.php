<?php
namespace zin;

$objectIcons = [];
$objectIcons['story']    = 'story';
$objectIcons['task']     = 'task-box';
$objectIcons['bug']      = 'bug';
$objectIcons['feedback'] = 'feedback';
$objectIcons['ticket']   = 'ticket';

$buildObjectScope = function($object) use ($products, $projects)
{
    $projectName = $object->projectName ?? '';
    if(empty($projectName) && !empty($object->project) && is_numeric($object->project)) $projectName = $projects[$object->project];
    if($projectName) return span(setClass('text-gray flex items-center gap-0.5'), icon('project'), $projectName);

    $productTitle = $object->productTitle ?? $object->product ?? '';
    if($productTitle && is_numeric($productTitle)) $productTitle = $products[$productTitle];
    if($productTitle) return span(setClass('text-gray flex items-center gap-0.5'), icon('product'), $productTitle);
    return null;
};

$todoCount  = count($procedureruns) + count($objects);
$todoList   = [];
$today      = helper::today();
$detailID   = 0;
$detailType = '';
foreach($procedureruns as $procedurerun)
{
    $object      = (object)json_decode($procedurerun->objectData);
    $objectTitle = isset($object->title) ? $object->title : $object->name;
    $todoItem    = [];

    $todoItem['selected'] = $current == $procedurerun->id;
    $todoItem['zui-key']  = $procedurerun->id;
    $todoItem['url']      = createLink('aiprocedure', 'workbench', "types={$objectTypes}&current={$procedurerun->id}");
    $todoItem['title']    = wg
    (
        icon(isset($objectIcons[$procedurerun->objectType]) ? $objectIcons[$procedurerun->objectType] : $procedurerun->objectType, setClass('text-gray')),
        div(setClass('flex-auto min-w-0'), div(setClass('whitespace-nowrap overflow-hidden text-ellipsis text-md text-fore'), $objectTitle))
    );
    $todoItem['subtitle'] = wg
    (
        $buildObjectScope($object),
        div
        (
            setClass('text-gray flex-auto'),
            empty($object->deadline) ? null : sprintf($lang->aiprocedure->deadlineInfo, $object->deadline)
        ),
        div
        (
            setClass('flex-none flex gap-1 items-center ai-procedure-run-status'),
            setData('doing-text', $lang->aiprocedure->procedureRunStatus['doing']),
            setData('running-text', $lang->aiprocedure->appLang->running),
            span(setClass("flex-none label label-dot ring-0 bg-current status-{$procedurerun->status}")),
            span(setClass('text text-gray'), \zget($lang->aiprocedure->procedureRunStatus, $procedurerun->status))
        )
    );

    $todoList[$procedurerun->id] = $todoItem;
}

if(!empty($todoList) && !empty($objects)) $todoList[] = ['type' => 'divider'];

foreach($objects as $object)
{
    $todoItem = [];
    $todoItem['selected'] = $current == $object->id;
    $todoItem['zui-key']  = $object->id;
    $todoItem['url']      = createLink('aiprocedure', 'workbench', "types={$objectTypes}&current={$object->id}");
    $todoItem['title']    = wg
    (
        icon(isset($objectIcons[$object->objectType]) ? $objectIcons[$object->objectType] : $object->objectType, setClass('text-gray')),
        div(setClass('flex-auto min-w-0'), div(setClass('whitespace-nowrap overflow-hidden text-ellipsis text-md text-fore'), $object->name))
    );
    $todoItem['subtitle'] = wg
    (
        $buildObjectScope($object),
        empty($object->deadline) ? null : div
        (
            setClass('text-gray'),
            sprintf($lang->aiprocedure->deadlineInfo, $object->deadline)
        )
    );
    $todoList[$object->id] = $todoItem;

    if($current == $object->id)
    {
        $detailID   = $object->objectID;
        $detailType = $object->objectType;
    }
}

$objectTypePickerItems = [];
foreach($lang->aiprocedure->objectTypes as $type => $objectTypeName)
{
    $objectTypePickerItems[] = ['text' => $objectTypeName, 'key' => $type];
}

sidebar
(
    setClass('ai-workbench-sidebar col h-full open-in-workbench'),
    setData('current', $current),
    set::width(320),
    div
    (
        setClass('row items-center p-3 border-b flex-none bg-primary-50'),
        h5
        (
            setClass('flex-auto row items-center'),
            $lang->aiprocedure->myTodo,
            span
            (
                setClass('text-gray text-base font-normal'),
                "($todoCount)"
            )
        ),
        btn
        (
            setID('workbenchRefreshBtn'),
            setClass('mr-2 hidden'),
            set::icon('refresh'),
            set::size('sm'),
            on::click()->call('window.loadAIWorkbenchPanel'),
            $lang->refresh
        ),
        zui::objectTypesPicker
        (
            set::items($objectTypePickerItems),
            set::selections($objectTypes),
            set::selectedTypesText($lang->aiprocedure->selectedTypes)
        )
    ),
    empty($todoList) ? div
    (
        setClass('text-gray center p-3 h-full'),
        $lang->aiprocedure->noTodo
    ) : simpleList
    (
        setClass('aiworkbench-todo-list py-3 px-3 space-y-3 flex-auto min-h-0 overflow-y-auto scrollbar-hover'),
        set::items(array_values($todoList))
    ),
    on::init()->call('window.initAIWorkbenchPanel', jsRaw('$element'), createLink('aiprocedure', 'workbench', "types={$objectTypes}&current={$current}"))
);

$mainView = null;
if($detailID)
{
    $mainView = zui::zentaoEntityDetail
    (
        set::_class('aiworkbench-object-detail'),
        set::id($detailID),
        set::type($detailType)
    );
}
elseif($procedureRun)
{
    $mainView = zui::aiProcedureRun
    (
        set::_class('h-full'),
        set::procedureRun($procedureRun),
        set::langData($lang->aiprocedure->appLang)
    );
}

div
(
    setID('aiWorkbenchMain'),
    setData('appsLabel', $lang->aiprocedure->workbench),
    setClass('ai-workbench-main h-full flex-auto'),
    div
    (
        setKey($detailID ? 'detail' : 'procedure'),
        setClass('h-full'),
        $mainView
    )
);
