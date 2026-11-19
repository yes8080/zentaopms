<?php
namespace zin;

$fields = fieldList('task.edit');
$fields->field('docs')
    ->position('info')
    ->width('full')
    ->control(function()
    {
        $task = data('task');
        return doclist(set::data($task));
    })
    ->moveBefore('files');
