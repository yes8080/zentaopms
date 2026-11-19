<?php
/**
 * The create file of alert module of ZenTaoPMS.
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

$ruleItems = (array)$alertRuleItems->project;
$userItems = (array)$alertNotifyUsers->project;

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
            set::name('name')
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
            set::items($lang->alert->objectList)
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
                set::items($ruleItems)
            ),
            input
            (
                setClass('w-16'),
                set::name('alertValue'),
                set::type('number'),
                set::value(3)
            ),
            span
            (
                setID('alertValueUnit'),
                setClass('input-group-addon'),
                $lang->alert->days
            )
        ),
        div
        (
            setID('projectModelTipBox'),
            setClass('hidden text-warning mt-2'),
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
            set::value('notice')
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
            set::value(array('message', 'mail')),
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
            set::items($userItems)
        )
    )
);
