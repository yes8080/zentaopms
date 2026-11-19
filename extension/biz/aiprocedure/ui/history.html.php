<?php
namespace zin;

modalHeader(set::title($lang->aiprocedure->history), set::titleClass('text-lg font-bold'));

if(empty($runs)) return h::div(setClass('p-4 text-gray'), $lang->aiprocedure->noHistory);

$items = array();
foreach($runs as $run)
{
    $items[] = array(
        'id'      => (int)$run->id,
        'name'    => $run->procedureName,
        'status'  => $run->status,
        'created' => $run->createdDate,
        'finished'=> $run->finishedDate,
    );
}

$cols = [];
$cols[] = ['name' => 'id', 'title' => $lang->idAB, 'width' => 60, 'sort' => false];
$cols[] = ['name' => 'name', 'title' => $lang->aiprocedure->name, 'sort' => false];
$cols[] = ['name' => 'status', 'title' => $lang->aiprocedure->status, 'type' => 'status', 'statusMap' => $lang->aiprocedure->procedureRunStatus, 'sort' => false];
$cols[] = ['name' => 'created', 'title' => $lang->aiprocedure->createdDate, 'type' => 'datetime', 'sort' => false];
$cols[] = ['name' => 'finished', 'title' => $lang->aiprocedure->finishedDate, 'type' => 'datetime', 'sort' => false];


dtable
(
    set::cols($cols),
    set::data($items),
    set::emptyTip($lang->aiprocedure->noHistory)
);
