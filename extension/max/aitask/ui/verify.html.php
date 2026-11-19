<?php
namespace zin;

include './common.html.php';

$taskID = $task->id;

formPanel(
    set::id('verifyForm'),
    set::title($title),
    set::actions(array(
        array('text' => $lang->confirm, 'class' => 'primary', 'id' => 'confirmBtn', 'btnType' => 'submit'),
        array('text' => $lang->save, 'class' => 'primary hidden', 'id' => 'saveBtn', 'btnType' => 'submit')
    )),
    set::layout('horizontal'),
    formRow(
        formGroup(
            set::label($lang->aitask->result),
            $buildTaskResults($task),
            $task->result ? btn(
                setClass('text-primary btn-detail'),
                set::type('ghost'),
                on::click()->call('parent.openAITaskPopup', $taskID),
                $lang->aitask->viewFullContent
            ) : null
        )
    ),
    formRow(
        formGroup(
            setClass('w-1/3'),
            set::label($lang->aitask->reviewOpinion),
            picker(
                set::name('result'),
                set::items($lang->aitask->resultList),
                set::value('pass'),
                on::change('handleResultChange')
            )
        )
    ),
    formRow(
        setID('remarkRow'),
        setClass('hidden'),
        formGroup(
            set::label($lang->aitask->desc),
            set::required(true),
            set::control(array('control' => 'textarea', 'rows' => 4)),
            set::name('remark'),
            set::placeholder($lang->aitask->remarkPlaceholder)
        )
    )
);
