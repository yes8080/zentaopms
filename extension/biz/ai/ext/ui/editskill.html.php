<?php

namespace zin;

$labelWidth = common::checkNotCN() ? '200px' : '100px';
$publishText = $skill->type == 'public' ? $lang->ai->skills->release : $lang->ai->skills->publish;

formPanel
(
    set::id('editSkillForm'),
    set::title($title),
    set::ajax(array('beforeSubmit' => jsRaw("clickSubmit"))),
    set::actions
    (
        array
        (
            array('text' => $lang->save, 'class' => 'btn secondary', 'id' => 'save-skill', 'btnType' => 'submit', 'data-status' => 'draft'),
            array('text' => $publishText, 'class' => 'btn primary', 'id' => 'publish-skill', 'btnType' => 'submit', 'data-status' => 'active')
        )
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->ai->skills->name),
        set::labelWidth($labelWidth),
        set::name('name'),
        set::required(true),
        set::value($skill->name),
        set::control(array('control' => 'input', 'maxlength' => 255))
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->ai->skills->category),
        set::labelWidth($labelWidth),
        set::name('category'),
        set::items($categories),
        set::value($skill->category),
        set::required(true),
        set::control(array('control' => 'picker', 'required' => true))
    ),
    formGroup
    (
        set::label($lang->ai->skills->desc),
        set::labelWidth($labelWidth),
        set::control(array('control' => 'textarea', 'rows' => 4)),
        set::name('desc'),
        set::value($skill->desc)
    ),
    formGroup
    (
        set::label($lang->ai->skills->uploadFile),
        set::labelWidth($labelWidth),
        set::required(true),
        fileSelector
        (
            set::maxFileCount(1),
            set::name('files'),
            set::accept('.zip'),
            set::tip($lang->ai->skills->tips->uploadFileTip),
            !empty($skill->files) ? set::defaultFiles(array_values($skill->files)) : null
        )
    ),
    input
    (
        set::name('status'),
        set::type('hidden'),
        set::value($skill->status)
    )
);
