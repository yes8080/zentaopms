<?php

namespace zin;

include './promptnav.html.php';

$activeDataSource = $prompt->module;
$selectedSources  = $prompt->source ? explode(',', trim($prompt->source, ',')) : array();

jsVar('dataSource', $dataSource);
jsVar('moduleList', $lang->ai->moduleList);
jsVar('activeDataSource', $activeDataSource);
jsVar('selectedSources', $selectedSources);

formPanel(
    setClass('panel-form prompt-set-input-fields'),
    to::heading
    (
        div
        (
            set::className('panel-title text-lg'),
            $lang->ai->designStepNav['setinputfields']
        )
    ),
    set::id('mainForm'),
    set::actions(array(array('text' => $lang->ai->nextStep, 'class' => 'btn primary', 'id' => 'set-input-fields-submit', 'btnType' => 'submit'))),
    div(
        setClass('data-selector-container'),
        div(
            setClass('data-properties-section'),
            div(
                setClass('section-header'),
                h4(setClass('text-md'), $lang->ai->prompts->selectData),
                small(setClass('text-gray'), $lang->ai->prompts->selectDataTip)
            ),
            div(
                setClass('section-content'),
                div(setClass('category-groups'), setData('object-group', $activeDataSource))
            )
        ),
        div(
            setClass('data-selected-panel'),
            div(
                setClass('section-header'),
                h4
                (
                    setID('selected-title-text'),
                    setClass('text-md selected-title-text'),
                    setData('format', $lang->ai->prompts->selectedFormat)
                )
            ),
            div(setClass('section-content'), div(setID('selected-data-sorter'), setClass('selected-data-sorter')))
        )
    ),
    input(set::name('datasource'), set::id('datasource'), set::type('hidden'), set::value(implode(',', $selectedSources))),
    on::init()->call('initPromptSetInputFields')
);
