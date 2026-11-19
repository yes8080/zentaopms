<?php
namespace zin;

formPanel
(
    set::title($title),
    set::submitBtnText($lang->save),
    set::actions(array('submit', array('text' => $lang->aiprocedure->back, 'data-dismiss' => 'modal'))),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->aiprocedure->name),
        set::name('name'),
        set::value($procedure->name),
        set::required(true),
        set::control(array('control' => 'input', 'maxlength' => 255))
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->aiprocedure->module),
        set::name('module'),
        set::value($procedure->module),
        set::required(true),
        set::items($lang->aiprocedure->moduleList),
        set::control('picker')
    ),
    formGroup
    (
        set::label($lang->aiprocedure->desc),
        set::name('desc'),
        set::value($procedure->desc),
        set::control(array('control' => 'textarea', 'rows' => 4))
    )
);
