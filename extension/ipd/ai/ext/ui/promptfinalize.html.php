<?php

namespace zin;

jsVar('promptID', $promptID);
jsVar('saveFailed', $lang->ai->saveFail);

include './promptnav.html.php';

$isTimerAgent = !empty($prompt->type) && $prompt->type === $lang->ai->agentType->timer;
$users = $this->loadModel('user')->getPairs('noletter');

function buildPreviewList($lang, $prompt, $dataPreview, $currentPrompt, $isTimerAgent = false, $users = array(), $ai = null)
{
    $items = array();
    if($isTimerAgent)
    {
        $cycleText = $ai->formatCycleConfigText($prompt);
        $items[] = li(h5($lang->ai->timer->cycleType), p($cycleText));
        if(($prompt->operation ?? '') === 'notify')
        {
            $notifyRule = $ai->parseNotifyRule($prompt->notifyRule ?? '');
            $sep = isset($lang->comma) ? $lang->comma : ',';
            $notifyText = $ai->formatNotifyTargetsText($notifyRule, $users);
            $methodText = implode($sep, array_map(function($method) use ($lang) { return zget($lang->ai->timer->notifyMethodList, $method, $method); }, (array)$notifyRule->methods));
            $items[] = li(h5($lang->ai->timer->notifyRoles), p($notifyText));
            $items[] = li(h5($lang->ai->timer->notifyMethods), p($methodText));
        }
    }
    else
    {
        $items[] = li(h5($lang->ai->prompts->dataPreview), p(setClass('pre'), $dataPreview));
    }

    $items[] = li(h5($lang->ai->prompts->rolePreview), p(setClass('pre'), $prompt->role));
    $items[] = li(h5($lang->ai->prompts->promptPreview), p(setClass('pre'), $currentPrompt));

    return ul(setClass('preview-list'), ...$items);
}

$actions = array(
    array('text' => $lang->ai->prompts->action->publish, 'class' => 'btn primary', 'id' => 'finalize-submit', 'btnType' => 'button', 'name' => 'publish', 'value' => '1')
);
if(!$isTimerAgent)
{
    $actions[] = array('text' => $lang->ai->goTesting, 'class' => 'btn btn-secondary', 'id' => 'finalize-go-test-btn', 'btnType' => 'button', 'name' => 'goTesting', 'value' => '1');
}

formPanel
(
    setClass('panel-form prompt-finalize'),
    to::heading
    (
        div
        (
            set::className('panel-title text-lg'),
            $isTimerAgent ? $lang->ai->designStepNavTimer['preview'] : $lang->ai->designStepNav['preview']
        )
    ),
    set::id('mainForm'),
    set::actions($actions),
    div(
        setClass('preview-panel'),
        div(
            setClass('section-content'),
            buildPreviewList($lang, $prompt, $dataPreview, $currentPrompt, $isTimerAgent, $users, $this->ai)
        )
    )
);
