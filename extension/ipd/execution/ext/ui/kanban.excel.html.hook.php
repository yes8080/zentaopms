<?php
namespace zin;

$lang      = data('lang');
$execution = data('execution');
$orderBy   = data('orderBy');

$canImport = common::canModify('execution', $execution) && hasPriv('task', 'import');
$importBtn = $canImport ? btn
(
    set
    (
        array
        (
            'class' => 'btn ghost btn-default',
            'url'   => createLink('task', 'import', "executionID={$execution->id}"),
            'icon'  => 'import',
            'data-toggle' => 'modal'
        )
    ),
    $lang->task->importCase,
) : null;

$exportItems = array();
if(hasPriv('task', 'export'))         $exportItems[] = array('text' => $lang->task->exportTaskData, 'data-toggle' => 'modal', 'data-size' => 'sm', 'url' => createLink('task', 'export', "execution={$execution->id}&orderBy={$orderBy}&type=all"));
if(hasPriv('task', 'exportTemplate')) $exportItems[] = array('text' => $lang->task->exportTaskTmp,  'data-toggle' => 'modal', 'data-size' => 'sm', 'url' => createLink('task', 'exportTemplate', "executionID={$execution->id}"));
$exportBtn = $exportItems ? dropdown
(
    btn
    (
        setClass('ghost btn btn-default'),
        set::icon('export'),
        $lang->export
    ),
    set::items($exportItems),
    set::placement('bottom-end')
) : null;

query('#actionBar div.btn-group')->prepend(array($importBtn, $exportBtn));
