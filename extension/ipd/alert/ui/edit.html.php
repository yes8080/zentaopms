<?php
/**
 * The edit file of alert module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader();

jsVar('alertRuleItems', $alertRuleItems);
jsVar('alertNotifyUsers', $alertNotifyUsers);
jsVar('projectModelTip', $lang->alert->projectModelTip);
jsVar('unitDay', $lang->alert->days);

$nodes               = $rule->nodes;
$notifyMethods       = $rule->notifyMethod ? explode(',', trim($rule->notifyMethod, ',')) : array();
$notifyUsersSelected = $rule->notifyUsers ? explode(',', trim($rule->notifyUsers, ',')) : array();
$ruleItems           = (array)$alertRuleItems->{$rule->objectType};
$userItems           = (array)$alertNotifyUsers->{$rule->objectType};
$alertType           = zget($nodes, 'alertType', array_key_first($ruleItems));
$alertValue          = zget($nodes, 'alertValue', 3);
$unit                = $alertType == 'sv_greater' ? '%' : $lang->alert->days;
$showProjectTip      = $rule->objectType == 'project' && $alertType == 'sv_greater';

formPanel
(
    on::change('[name=objectType]', 'changeObject'),
    on::change('[name=alertType]', 'changeAlertType'),
    set::submitBtnText($lang->save),
    formGroup
    (
        set::label($lang->alert->name),
        set::required(true),
        set::width('1/2'),
        input
        (
            set::name('name'),
            set::value($rule->name)
        )
    ),
    formGroup
    (
        set::label($lang->alert->objectType),
        set::required(true),
        set::width('1/2'),
        picker
        (
            set::required(true),
            set::name('objectType'),
            set::items($lang->alert->objectList),
            set::value($rule->objectType)
        )
    ),
    formGroup
    (
        set::label($lang->alert->alertRule),
        set::required(true),
        set::width('1/2'),
        inputGroup
        (
            picker
            (
                setClass('w-64'),
                set::required(true),
                set::name('alertType'),
                set::items($ruleItems),
                set::value($alertType)
            ),
            input
            (
                setClass('w-16'),
                set::name('alertValue'),
                set::type('number'),
                set::value($alertValue)
            ),
            span
            (
                setID('alertValueUnit'),
                setClass('input-group-addon'),
                $unit
            )
        ),
        div
        (
            setID('projectModelTipBox'),
            setClass($showProjectTip ? 'text-warning mt-2' : 'hidden text-warning mt-2'),
            $lang->alert->projectModelTip
        )
    ),
    formGroup
    (
        set::label($lang->alert->alertLevel),
        set::required(true),
        set::width('1/2'),
        picker
        (
            set::required(true),
            set::name('alertLevel'),
            set::items($lang->alert->levelList),
            set::value($rule->alertLevel)
        )
    ),
    formGroup
    (
        set::label($lang->alert->notifyMethod),
        set::required(true),
        checkList
        (
            setClass('flex-wrap'),
            set::name('notifyMethod[]'),
            set::items($lang->alert->notifyMethodList),
            set::value($notifyMethods),
            set::inline(true)
        )
    ),
    formGroup
    (
        set::label($lang->alert->notifyUsers),
        set::required(true),
        picker
        (
            set::name('notifyUsers'),
            set::multiple(true),
            set::items($userItems),
            set::value($notifyUsersSelected)
        )
    )
);
