<?php

namespace zin;

include './promptnav.html.php';

$notifyItems = array
(
    array('text' => $lang->ai->timer->notifyRoleGroup, 'items' => array(), 'disabled' => true),
    array('text' => $lang->ai->timer->notifyUserGroup, 'items' => array(), 'disabled' => true)
);
foreach($lang->ai->timer->notifyRoleList as $roleKey => $roleName)
{
    $notifyItems[0]['items'][] = array('text' => $roleName, 'value' => $roleKey);
}
foreach($users as $account => $userName)
{
    if($account === '') continue;
    $notifyItems[1]['items'][] = array('text' => $userName, 'value' => $account);
}
$notifyValue = array_values(array_filter(array_merge((array)$notifyRule->roles, (array)$notifyRule->users)));

$cycleType = !empty($prompt->cycleType) ? $prompt->cycleType : 'day';
$weekValue = isset($cycleConfig->week) ? (is_array($cycleConfig->week) ? $cycleConfig->week : explode(',', (string)$cycleConfig->week)) : array();
$monthValue = isset($cycleConfig->month) ? (is_array($cycleConfig->month) ? $cycleConfig->month : explode(',', (string)$cycleConfig->month)) : array();

jsVar('notifyOperation', 'notify');
formPanel
(
    to::heading
    (
        div
        (
            set::className('panel-title text-lg'),
            $lang->ai->timer->common
        )
    ),
    set::actions
    (
        array
        (
            array('text' => $lang->ai->nextStep, 'class' => 'btn primary', 'id' => 'timer-basic-info-submit', 'btnType' => 'submit')
        )
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->processObject),
        set::required(true),
        set::name('module'),
        set::items($lang->ai->timer->moduleList),
        set::value(isset($prompt->module) ? $prompt->module : ''),
        set::control(array('control' => 'picker', 'required' => true))
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->timer->operation),
        set::required(true),
        set::name('operation'),
        set::items($lang->ai->timer->operationList),
        set::value(isset($prompt->operation) ? $prompt->operation : ''),
        set::control(array('control' => 'picker', 'required' => false, 'onChange' => jsRaw('(value) => window.changeTimerOperation(value)')))
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto notify-fields' . (($prompt->operation ?? '') === 'notify' ? '' : ' hidden')),
        set::label($lang->ai->timer->notifyRoles),
        set::name('notifyTo[]'),
        set::items($notifyItems),
        set::value($notifyValue),
        set::control(array('control' => 'picker', 'multiple' => true))
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto notify-fields' . (($prompt->operation ?? '') === 'notify' ? '' : ' hidden')),
        set::label($lang->ai->timer->notifyMethods),
        div
        (
            setClass('flex items-center w-full gap-1'),
            picker
            (
                setClass('flex-1 min-w-0'),
                set::name('notifyMethods[]'),
                set::items($lang->ai->timer->notifyMethodList),
                set::value($notifyRule->methods),
                set::multiple(true)
            ),
            btn
            (
                set::icon('help'),
                toggle::tooltip(array('placement' => 'right', 'title' => $lang->ai->timer->messageNotice, 'type' => 'white', 'class-name' => 'text-gray border border-light')),
                set::square(true),
                setClass('ghost h-6 tooltip-btn')
            )
        )
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->timer->cycleType),
        set::required(true),
        radioList
        (
            set::name('cycleType'),
            set::value($cycleType),
            set::inline(true),
            set::items($lang->ai->timer->cycleTypeList),
            on::change('window.changeTimerCycleType')
        )
    ),
    formRow
    (
        setClass('w-full max-w-2xl mx-auto cycle-type-detail type-day' . ($cycleType === 'day' ? '' : ' hidden')),
        formGroup
        (
            set::label($lang->todo->from),
            set::name('config[date]'),
            set::control('date'),
            set::value(isset($cycleConfig->begin) ? $cycleConfig->begin : (isset($cycleConfig->date) ? $cycleConfig->date : ''))
        ),
        formGroup
        (
            set::label($lang->todo->every),
            inputControl
            (
                set::suffix($lang->todo->cycleDay),
                set::suffixWidth('30'),
                input(set::name('config[day]'), set::value(isset($cycleConfig->day) ? $cycleConfig->day : '1'))
            )
        )
    ),
    formRow
    (
        setClass('w-full max-w-2xl mx-auto cycle-type-detail type-week' . ($cycleType === 'week' ? '' : ' hidden')),
        formGroup
        (
            set::label($lang->todo->weekly),
            set::name('config[week][]'),
            set::items($lang->todo->dayNames),
            set::value($weekValue),
            set::control(array('control' => 'picker', 'multiple' => true))
        )
    ),
    formRow
    (
        setClass('w-full max-w-2xl mx-auto cycle-type-detail type-month' . ($cycleType === 'month' ? '' : ' hidden')),
        formGroup
        (
            set::label($lang->todo->monthly),
            set::name('config[month][]'),
            set::items(array_combine(range(1, 31), range(1, 31))),
            set::value($monthValue),
            set::control(array('control' => 'picker', 'multiple' => true))
        )
    ),
    formGroup
    (
        setClass('w-full max-w-2xl mx-auto'),
        set::label($lang->ai->prompts->name),
        set::required(true),
        set::name('name'),
        set::value($prompt->name)
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
        set::label($lang->prompt->desc),
        textarea(set::name('desc'), set::value($prompt->desc), set::rows(3))
    )
);
