<?php

namespace zin;

/**
 * Build navigation steps for prompt design
 * 构建提示设计页面的步骤导航
 *
 * @param array $stepSequence 步骤序列
 * @param array $stepStatus 步骤状态
 * @param object $prompt 提示对象
 * @param array $stepNav 步骤导航配置
 * @return mixed Any type supported by zin widget function
 */
function buildNavSteps(array $stepSequence, array $stepStatus, object $prompt, array $stepNav, array $stepMethods)
{
    return menu(
        setClass('nav nav-steps'),
        ...array_map(function ($stepKey) use ($stepStatus, $prompt, $stepNav, $stepMethods) {
            $currentStepStatus = $stepStatus[$stepKey] ?? 'disabled';
            $stepLang = zget($stepNav, $stepKey, $stepKey);
            $stepMethod = zget($stepMethods, $stepKey, $stepKey);
            $itemClass = 'nav-item item';
            if($stepKey == 'setinputfields' && !empty($prompt->displayPosition) && $prompt->displayPosition == 'form') $itemClass .= ' hidden';

            /* 根据状态设置CSS类 */
            $linkClass = '';
            switch ($currentStepStatus) {
                case 'active':
                    $linkClass = 'selected';
                    break;
                case 'current':
                    $linkClass = 'active';
                    break;
                case 'clickable':
                    $linkClass = '';
                    break;
                case 'disabled':
                    $linkClass = 'disabled';
                    break;
            }

            $stepLink = createLink('ai', (strpos($stepMethod, 'timer') === 0 ? $stepMethod : "prompt$stepMethod"), (strpos($stepMethod, 'timer') === 0 ? "promptID=" : "prompt=") . ($prompt->id ?? '0'));

            return li(
                setClass($itemClass),
                setData('step', $stepKey),
                a(
                    setClass($linkClass),
                    set::href($currentStepStatus == 'disabled' ? 'javascript:void(0);' : $stepLink),
                    span(
                        setClass('text'),
                        $stepLang
                    )
                )
            );
        }, $stepSequence)
    );
}

/* 步骤导航逻辑 */
if(!is_object($prompt)) $prompt = (object)array('id' => 0, 'type' => '');
$step = $currentStep ?? preg_replace('/^prompt/', '', $app->methodName ?? 'basicinfo');
if($step == 'timerbasicinfo') $step = 'basicinfo';
$isTimerAgent = !empty($prompt->type) && $prompt->type == 'timer';

if($isTimerAgent)
{
    $activeStepSequence  = array('basicinfo', 'setprompt', 'preview');
    $displayStepSequence = $step == 'basicinfo' ? $activeStepSequence : array();
    $stepSequence        = empty($displayStepSequence) ? $activeStepSequence : $displayStepSequence;
    $stepMethods         = array('basicinfo' => 'timerbasicinfo', 'setprompt' => 'setpurpose', 'preview' => 'finalize');
    $stepNavLang         = $lang->ai->designStepNavTimer;
}
else
{
    $displayStepSequence = $step == 'basicinfo'
        ? array('basicinfo', 'setinputfields', 'setinputform', 'setprompt', 'preview')
        : array();
    $activeStepSequence = !empty($prompt->displayPosition) && $prompt->displayPosition == 'form'
        ? array('basicinfo', 'setinputform', 'setprompt', 'preview')
        : array('basicinfo', 'setinputfields', 'setinputform', 'setprompt', 'preview');
    $stepSequence = empty($displayStepSequence) ? $activeStepSequence : $displayStepSequence;
    $stepMethods  = array('setprompt' => 'setpurpose', 'preview' => 'finalize');
    $stepNavLang  = $lang->ai->designStepNav;
}

if($step == 'setpurpose') $step = 'setprompt';
if($step == 'finalize') $step = 'preview';

$stepStatus = $this->ai->getPromptDesignStepStatus($activeStepSequence, (string)$step, (string)($lastActiveStep ?? 'basicinfo'), (int)($prompt->id ?? 0));

/**
 * Prompt Design 页面共享头部
 */
div
(
    setClass('prompt-header'),
    btn(
        setClass('btn-back'),
        set::type('ghost'),
        set::url(createLink('ai', 'prompts')),
        set::icon('angle-left'),
        set::text($lang->goback)
    ),
    buildNavSteps($stepSequence, $stepStatus, $prompt, $stepNavLang, $stepMethods)
);
