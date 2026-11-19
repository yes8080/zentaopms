<?php
namespace zin;

jsVar('page', 'assignedto');

data('aitask', $task);

modalHeader(set::title($lang->aitask->assignToAction));

formPanel(
    set::submitBtnText($lang->aitask->assignToAction),
    formGroup(
        set::width('1/3'),
        set::name('assignedTo'),
        set::label($lang->aitask->assignedTo),
        set::value($task->assignedTo),
        set::items($users),
        set::required(true)
    ),
    formGroup(
        set::label($lang->comment),
        set::name('comment'),
        set::control('editor'),
        set::rows(6)
    )
);
hr();
history(set::objectID($task->id));
