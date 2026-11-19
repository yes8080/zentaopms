<?php

namespace zin;

jsVar('promptID', $promptID);
jsVar('currentFields', array_values($currentFields));
jsVar('deleteTip', $lang->ai->miniPrograms->deleteFieldTip);
jsVar('fieldAdd', $lang->ai->miniPrograms->field->add);
jsVar('fieldAddTip', $lang->ai->miniPrograms->field->addTip);
jsVar('fieldEdit', $lang->ai->miniPrograms->field->edit);
jsVar('fieldName', $lang->ai->miniPrograms->field->name);
jsVar('fieldOption', $lang->ai->miniPrograms->field->option);
jsVar('pleaseInput', $lang->ai->miniPrograms->placeholder->input);
jsVar('fieldPlaceholder', $lang->ai->miniPrograms->placeholder->input);
jsVar('emptyWarning', $lang->ai->miniPrograms->field->emptyNameWarning);
jsVar('duplicatedWarning', $lang->ai->miniPrograms->field->duplicatedNameWarning);
jsVar('emptyOptionWarning', $lang->ai->miniPrograms->field->emptyOptionWarning);
jsVar('saveFailed', $lang->ai->saveFail);

include './promptnav.html.php';

formPanel(
    setClass('panel-form prompt-set-input-form'),
    to::heading
    (
        div
        (
            set::className('panel-title text-lg'),
            $lang->ai->designStepNav['setinputform']
        )
    ),
    set::actions
    (
        array
        (
            array('text' => $lang->ai->nextStep, 'class' => 'btn primary', 'id' => 'btn-save', 'btnType' => 'button')
        )
    ),
    div
    (
        setClass('section-content w-full max-w-xl mx-auto'),
        ol(
            setID('field-list'),
            setClass('field-list sortable'),
            div(
                setID('add-field'),
                setClass('field-empty'),
                div(setClass('action text-primary'), icon('plus'), span($lang->ai->miniPrograms->field->add)),
                div(setClass('tips'), $lang->ai->miniPrograms->field->addTip)
            )
        )
    )
);

div
(
    setClass('modal fade'),
    setData('backdrop', 'static'),
    setID('field-modal'),
    div
    (
        setClass('modal-dialog shadow size-sm bd-none'),
        div
        (
            setClass('modal-content'),
            div(setClass('modal-header items-center'), span($lang->ai->miniPrograms->field->add)),
            div(setClass('modal-actions'), button(setClass('btn square ghost'), setData('dismiss', 'modal'), span(setClass('close')))),
            div(setClass('modal-body form form-horz'),
                formGroup(set::label($lang->ai->miniPrograms->field->name), set::required(true), input(set::name('field-name'), set::maxlength('16'))),
                formGroup(set::label($lang->ai->miniPrograms->field->type), select(set::name('field-type'), set::items(array('text' => $lang->ai->miniPrograms->field->typeList['text'], 'textarea' => $lang->ai->miniPrograms->field->typeList['textarea'], 'radio' => $lang->ai->miniPrograms->field->typeList['radio'], 'checkbox' => $lang->ai->miniPrograms->field->typeList['checkbox'])), set::value('text'), set::required(true))),
                formGroup(setID('field-placeholder'), set::label($lang->ai->miniPrograms->field->placeholder), input(set::name('field-placeholder'), set::placeholder($lang->ai->miniPrograms->placeholder->default))),
                formGroup(setID('field-options'), setClass('field-options hidden'), set::label('')),
                formGroup(set::label($lang->ai->miniPrograms->field->required), radioList(set::name('field-required'), set::items(array('1' => $lang->ai->miniPrograms->field->requiredOptions[1], '0' => $lang->ai->miniPrograms->field->requiredOptions[0])), set::value('1'), set::inline(true)))
            ),
            div(setClass('modal-footer flex items-center justify-center'), btn(setID('field-modal-save'), setClass('btn btn-wide primary'), $lang->save))
        )
    )
);
