<?php

namespace zin;

include './promptnav.html.php';

$moduleItems = $this->ai->getPromptProcessObjectList();
$moduleItems[''] = '';

$actionPurposeData          = $this->ai->getPromptActionPurposeListByModule($moduleItems);
$actionPurposeItemsByModule = $actionPurposeData['itemsByModule'];
$actionPurposeNameMap       = $actionPurposeData['nameMap'];

$activeModule = isset($prompt->module) ? $prompt->module : '';
$activeActionPurpose = isset($prompt->actionPurpose) ? $prompt->actionPurpose : '';
$actionPurposeItems = array_merge(array(array('text' => '', 'value' => '')), isset($actionPurposeItemsByModule[$activeModule]) ? $actionPurposeItemsByModule[$activeModule] : array());
$displayPositionList                = $this->ai->getPromptDisplayPositionList();
$displayPositionMap                 = $this->ai->getPromptDisplayPositionMap();
$displayPositionDescList            = isset($lang->ai->prompts->displayPositionDescList) ? $lang->ai->prompts->displayPositionDescList : array();
$displayPositionImageList           = array();
$displayPositionImageList['detail'] = $config->webRoot . 'theme/default/images/guide/prompt-display-detail.png';
$displayPositionImageList['form']   = $config->webRoot . 'theme/default/images/guide/prompt-display-form.png';
$allowedPositions                   = isset($displayPositionMap[$activeActionPurpose]) ? $displayPositionMap[$activeActionPurpose] : array_keys($displayPositionList);

$buildDisplayPositionItem = function(string $position, string $label) use ($displayPositionDescList, $displayPositionImageList): array
{
    $title       = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
    $desc        = isset($displayPositionDescList[$position]) ? htmlspecialchars($displayPositionDescList[$position], ENT_QUOTES, 'UTF-8') : '';
    $image       = isset($displayPositionImageList[$position]) ? htmlspecialchars($displayPositionImageList[$position], ENT_QUOTES, 'UTF-8') : '';
    $imageHtml   = $image ? "<img src='{$image}' alt='{$title}' />" : '';
    $contentHtml = "<div class='display-position-preview'>{$imageHtml}</div><div class='display-position-info'><div class='display-position-title'>{$title}</div><div class='display-position-desc'>{$desc}</div></div>";

    return array('value' => $position, 'text' => $label, 'content' => array('html' => $contentHtml, 'class' => 'display-position-box flex w-full border no-wrap pl-1 py-4'));
};

$displayPositionItems = array(array('text' => '', 'value' => ''));
foreach($allowedPositions as $position)
{
    if(isset($displayPositionList[$position])) $displayPositionItems[] = $buildDisplayPositionItem($position, $displayPositionList[$position]);
}

jsVar('actionPurposeItemsByModule', $actionPurposeItemsByModule);
jsVar('actionPurposeNameMap', $actionPurposeNameMap);
jsVar('displayPositionList', $displayPositionList);
jsVar('displayPositionMap', $displayPositionMap);
jsVar('displayPositionDescList', $displayPositionDescList);
jsVar('displayPositionImageList', $displayPositionImageList);

formPanel
(
    to::heading
    (
        div
        (
            set::className('panel-title text-lg'),
            $lang->ai->promptBasicInfo
        )
    ),
    set::actions
    (
        array
        (
            array('text' => $lang->ai->nextStep, 'class' => 'btn primary', 'id' => 'basic-info-submit', 'btnType' => 'submit')
        )
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->processObject),
        set::required(true),
        set::name('module'),
        set::items($moduleItems),
        set::value(isset($prompt->module) ? $prompt->module : ''),
        set::control(array('control' => 'picker', 'required' => false, 'emptyValue' => '', 'onChange' => jsRaw('(value) => window.changeProcessObject(value)')))
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->actionPurpose),
        set::required(true),
        set::name('actionPurpose'),
        set::items($actionPurposeItems),
        set::value(isset($prompt->actionPurpose) ? $prompt->actionPurpose : ''),
        set::control(array('control' => 'picker', 'required' => false, 'emptyValue' => '', 'onChange' => jsRaw('(value) => window.changeActionPurpose(value)')))
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->displayPosition),
        set::required(true),
        set::name('displayPosition'),
        set::items($displayPositionItems),
        set::value(isset($prompt->displayPosition) ? $prompt->displayPosition : ''),
        set::control(array('control' => 'picker', 'required' => false, 'emptyValue' => '', 'menu' => array('class' => 'display-position-menu'), 'onChange' => jsRaw('(value) => window.changePromptDisplayPosition(value)')))
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->name),
        set::required(true),
        input
        (
            set::name('name'),
            set::value($prompt->name),
            set::required(true),
            on::input()->call('window.changePromptBasicName', jsRaw('event'))
        )
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->model),
        set::required(true),
        div
        (
            setClass('w-full'),
            zui::AIModelPicker
            (
                set::name('model'),
                set::required(true),
                set::value(!empty($prompt->model) ? $prompt->model : '')
            )
        )
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->description),
        set::name('desc'),
        set::value($prompt->desc),
        set::control(array('control' => 'textarea', 'rows' => 4))
    )
);
