<?php

namespace zin;

$getCurrentPrompt = function() use ($prompt, $lang, $currentPrompt)
{
    if(!empty($currentPrompt)) return $currentPrompt;
    if(empty($prompt->type) || $prompt->type != 'timer') return $currentPrompt;
    return zget($lang->ai->timer->promptTemplate, $prompt->operation, '');
};

jsVar('promptID', $promptID);
jsVar('currentFields', array_values($currentFields));
jsVar('knowledgeLibs', array_values($knowledgeLibs));
jsVar('skills', array_values($skills));
jsVar('currentPrompt', $getCurrentPrompt());
jsVar('knowledgeLibAdd', $lang->ai->miniPrograms->knowledgeLibAdd);
jsVar('knowledgeLibAddTip', $lang->ai->miniPrograms->knowledgeLibAddTip);
jsVar('skillAdd', $lang->ai->miniPrograms->skillAdd);
jsVar('skillAddTip', $lang->ai->miniPrograms->skillAddTip);
jsVar('unpublished', $lang->ai->knowledgeLibs->unpublished);
jsVar('skillUnpublished', $lang->ai->skills->statusList['draft']);
jsVar('deleted', $lang->ai->knowledgeLibs->deleted);
jsVar('confirmDelete', $lang->confirmDelete);
jsVar('saveFailed', $lang->ai->saveFail);
jsVar('promptPlaceholder', $lang->ai->miniPrograms->placeholder->prompt);

include './promptnav.html.php';

$promptTitle = array($lang->ai->miniPrograms->field->prompt);
if(empty($prompt->displayPosition) || $prompt->displayPosition != 'form')
{
    $promptTitle[] = icon('help');
    $promptTitle[] = small(
        set::title($lang->ai->miniPrograms->field->prompterDesignTip),
        setClass('text-ellipsis'),
        $lang->ai->miniPrograms->field->prompterDesignTip
    );
}

formPanel(
    setClass('panel-form prompt-set-purpose'),
    to::heading
    (
        div
        (
            set::className('panel-title text-lg'),
            $lang->ai->designStepNav['setprompt']
        )
    ),
    set::actions
    (
        array
        (
            array('text' => $lang->ai->nextStep, 'class' => 'btn primary', 'id' => 'btn-save', 'btnType' => 'button')
        )
    ),
    div(
        setClass('panels'),
        div(
            setClass('form-panel'),
            div(
                setClass('section-content'),
                div(
                    setClass('panel-area'),
                    h3(
                        setClass('text-md'),
                        $lang->ai->prompts->role
                    ),
                    textarea(
                        set::name('role'),
                        set::value(!empty($prompt->role) ? $prompt->role : ''),
                        set::rows(4),
                        set::placeholder($lang->ai->prompts->rolePlaceholder)
                    )
                ),
                div(
                    setClass('panel-area'),
                    h3(
                        setClass('text-md field-required'),
                        ...$promptTitle
                    ),
                    div(
                        setID('prompt-editor')
                    )
                ),
                div(
                    setClass('panel-area'),
                    h3(
                        setClass('text-md'),
                        $lang->ai->miniPrograms->field->skills
                    ),
                    ol(
                        setID('mounted-skills'),
                        setClass('field-list')
                    )
                ),
                div(
                    setClass('panel-area'),
                    h3(
                        setClass('text-md'),
                        $lang->ai->miniPrograms->field->knowledgeLibs
                    ),
                    ol(
                        setID('knowledge-libs'),
                        setClass('field-list')
                    )
                )
            )
        )
    )
);
