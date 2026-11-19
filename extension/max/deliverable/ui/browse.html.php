<?php
namespace zin;

if(!$hasDeliverable)
{
    $currentModuleName = $lang->deliverable->common;
    include('../../common/ext/ui/closefeaturenotice.html.php');
    return;
}

jsVar('builtinConfirm', $lang->deliverable->builtinConfirm);
jsVar('selectedItems', $lang->selectedItems);
jsVar('pageSummary', sprintf($lang->deliverable->summary, count($deliverables)));
jsVar('groupID', $groupID);
jsVar('otherBatchTip', $lang->deliverable->otherBatchTip);
$deliverableCategoryMap = array();
foreach($deliverables as $deliverable) $deliverableCategoryMap[$deliverable->id] = $deliverable->category;
jsVar('deliverableCategory', $deliverableCategoryMap);
featureBar
(
    set::current('all'),
    set::linkParams("groupID={$groupID}&browseType={key}&param={$param}&orderBy={$orderBy}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}"),
    li(searchToggle(set::module('deliverable'), set::open($browseType == 'bysearch')))
);

$canCreate      = hasPriv('deliverable', 'create');
$canBatchCreate = hasPriv('deliverable', 'batchCreate');

$createItems = array();
if($canCreate)
{
    $createItems[] = array('text' => $lang->deliverable->createAbbr, 'url' => createLink('deliverable', 'create', "groupID={$groupID}&moduleID=$moduleID"), 'data-app' => $app->tab);
}
if($canBatchCreate)
{
    $createItems[] = array('text' => $lang->deliverable->batchCreate, 'url' => createLink('deliverable', 'batchCreate', "groupID={$groupID}&moduleID=$moduleID"), 'data-app' => $app->tab);
}
$currentCreateItem = current($createItems);

toolbar
(
    $currentCreateItem ? btngroup
    (
        btn
        (
            setClass('btn primary'),
            set::icon('plus'),
            set::url($currentCreateItem['url']),
            set(array('data-app' => $app->tab, 'class' => 'createBtn')),
            $currentCreateItem['text']
        ),
        count($createItems) > 1 ? dropdown
        (
            btn(setClass('btn primary dropdown-toggle'), setStyle(array('padding' => '6px', 'border-radius' => '0 2px 2px 0'))),
            set::items($createItems),
            set::placement('bottom-end')
        ) : null
    ) : null,
);

foreach($moduleTree as $tree)
{
    $hasDeliverable = !empty($modulePairs[$tree->id]);
    if(hasPriv('tree', 'edit')   && !in_array($tree->extra, array_keys($lang->deliverable->buildinModule))) $tree->actions['items'][] = array('icon' => 'edit',  'hint' => $lang->edit,   'url' => createLink('tree', 'edit', "moduleID={$tree->id}&type=deliverable"), 'data-toggle' => 'modal', 'data-size' => 'sm');
    if(hasPriv('tree', 'delete') && !in_array($tree->extra, array_keys($lang->deliverable->buildinModule))) $tree->actions['items'][] = array('icon' => 'trash', 'hint' => $lang->delete, 'url' => createLink('tree', 'delete', "moduleID={$tree->id}"), 'className' => 'btn ghost toolbar-item square size-sm rounded ajax-submit', 'data-confirm' => $hasDeliverable ? array('message' => $lang->deliverable->deleteModuleConfirm, 'actions' => 'cancel') : null);
}

sidebar
(
    moduleMenu
    (
        set::modules($moduleTree),
        set::activeKey($moduleID),
        set::closeLink(createLink('deliverable', 'browse', "id={$groupID}")),
        set::createModuleLink(hasPriv('tree', 'create') ? createLink('tree', 'create', "rootID={$groupID}&viewType=deliverable") : null),
        set::settingText($lang->deliverable->moduleSetting),
        set::showDisplay(false),
        set::app('admin')
    )
);

$cols = $this->loadModel('datatable')->getSetting('deliverable');
if(!$hasProcess)
{
    unset($cols['activity']);
    unset($cols['trimmable']);
    unset($cols['trimRule']);
}

$activities[0] = '';
if(isset($cols['activity'])) $cols['activity']['map'] = $activities;
if(isset($cols['module']))   $cols['module']['map']   = $modules;

$tableData = initTableData($deliverables, $cols, $this->deliverable);
$data      = array();
foreach($tableData as $key => $row)
{
    $row->rowID = $row->id;
    if(!empty($row->stages))
    {
        foreach($row->stages as $stage)
        {
            $row->rowID = "{$row->id}_{$stage->id}";
            $stageType  = !empty($stage->type) ? $stage->type : 'execution';
            if($stage->stage == 'project') $stageType = 'project'; // 兼容历史数据 type 未写入的 project 行
            $row->stage = $stage->stage == 'all' ? $lang->deliverable->allStage : zget($stageList[$stageType], $stage->stage, '');

            $row->required = zget($lang->deliverable->requiredList, $stage->required, '');
            $row->rowspan  = count($row->stages);
            $data[] = clone $row;
        }
    }
    else
    {
        $data[] = $row;
    }
}

$canBatchCheck   = hasPriv('deliverable', 'batchCheck');
$canBatchEdit    = hasPriv('deliverable', 'batchEdit');
$canBatchEnable  = hasPriv('deliverable', 'batchEnable');
$canBatchDisable = hasPriv('deliverable', 'batchDisable');
$canBatchDelete  = hasPriv('deliverable', 'batchDelete');
$canBatch        = $canBatchCheck || $canBatchEdit || $canBatchDelete || $canBatchEnable || $canBatchDisable;
$summary         = sprintf($lang->deliverable->summary, count($deliverables));
$footToolbar     = array();
if($canBatchEnable) $footToolbar[] = array
(
    'type' => 'btn-group',
    'items' => array
    (
        array
        (
            'text' => $lang->deliverable->enableTip,
            'className' => 'secondary batch-btn',
            'data-formaction' => createLink('deliverable', 'batchEnable')
        )
    )
);
if($canBatchDisable) $footToolbar[] = array
(
    'type' => 'btn-group',
    'items' => array
    (
        array
        (
            'text' => $lang->deliverable->disableTip,
            'className' => 'secondary batch-btn',
            'data-formaction' => createLink('deliverable', 'batchDisable')
        )
    )
);
if($canBatchCheck) $footToolbar[] = array
(
    'type' => 'btn-group',
    'items' => array
    (
        array
        (
            'text' => $lang->deliverable->when,
            'className' => 'secondary batch-btn batch-check-btn',
            'data-formaction' => createLink('deliverable', 'batchCheck', "groupID=$groupID")
        )
    )
);
if($canBatchEdit) $footToolbar[] = array
(
    'type' => 'btn-group',
    'items' => array
    (
        array
        (
            'text' => $lang->edit,
            'className' => 'secondary batch-btn',
            'data-page' => 'batch',
            'data-formaction' => createLink('deliverable', 'batchEdit', "groupID=$groupID")
        )
    )
);
if($canBatchDelete) $footToolbar[] = array
(
    'type' => 'btn-group',
    'items' => array
    (
        array
        (
            'text' => $lang->delete,
            'className' => 'secondary batch-btn',
            'data-formaction' => createLink('deliverable', 'batchDelete', "groupID=$groupID")
        )
    )
);

dtable
(
    set::rowKey('rowID'),
    set::id('deliverableTable'),
    set::cols($cols),
    set::data($data),
    set::userMap($users),
    set::orderBy($orderBy),
    set::customCols(array('url' => createLink('datatable', 'ajaxcustom', "module=deliverable&method=browse&extra=$groupID"))),
    set::plugins(array('cellspan')),
    set::checkable($canBatch),
    set::sortLink(createLink('deliverable', 'browse', "groupID={$groupID}&browseType=$browseType&param={$param}&orderBy={name}_{sortType}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}")),
    set::getCellSpan(jsRaw('window.getCellSpan')),
    set::onRenderCell(jsRaw('window.onRenderCell')),
    set::footToolbar($footToolbar),
    $canBatch ? set::checkInfo(jsRaw('window.getCheckInfo')) : set::footer(array($summary, 'flex', 'pager')),
    set::footPager(usePager(array
    (
        'recTotal'    => $pager->recTotal,
        'recPerPage'  => $pager->recPerPage,
        'linkCreator' => helper::createLink('deliverable', 'browse', "groupID={$groupID}&browseType=$browseType&param={$param}&orderBy=$orderBy&recTotal={$pager->recTotal}&recPerPage={recPerPage}&page={page}")
    )))
);
