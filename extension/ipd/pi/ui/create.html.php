<?php
/**
 * The create view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('executionName', $lang->pi->execution);
jsVar('holidays', array_values($holidays));
jsVar('weekend', $config->execution->weekend);
jsVar('restDay', isset($config->execution->restDay) ? $config->execution->restDay : 2);

$plans = array();
for($index = 0; $index <= 4; $index ++)
{
    $plans[] = div
    (
        set::className('form-batch-control'),
        inputGroup
        (
            set::className('mb-2'),
            set('data-index', $index),
            input(set::name("execution[$index]"), set::value($lang->pi->abbr->execution . ($index + 1)), set::placeholder($lang->pi->execution)),
            span(set::className('input-group-addon'), $lang->pi->planDate),
            datePicker(set::id("beginPicker{$index}"), set::name("begin[$index]")),
            span(set::className('input-group-addon'), $lang->hyphen),
            datePicker(set::id("endPicker{$index}"), set::name("end[$index]")),
            btn(setClass('btn ghost addLine ml-2'), icon('plus')),
            btn(setClass('btn ghost removeLine'), icon('trash'))
        )
    );
}

formPanel
(
    on::change('[name=ART]',  'changeART'),
    on::change('[name=acl]',  'changeAcl'),
    on::change('[name^=end]', 'computeDays'),
    on::click('.addLine', 'addLine'),
    on::click('.removeLine', 'removeLine'),
    set::title($lang->pi->create),
    formRow
    (
        formGroup(set::width('1/2'), set::label($lang->pi->name), set::name('name'))
    ),
    formRow
    (
        formGroup
        (
            set::required(true),
            set::width('1/2'),
            set::label($lang->pi->ART),
            picker
            (
                set::name('ART'),
                set::items($ARTList),
                set::value($artID)
            )
        )
    ),
    formRow
    (
        formGroup
        (
            set::id('productRow'),
            set::required(true),
            set::label($lang->pi->product),
            picker
            (
                set::multiple(true),
                set::name('product'),
                set::items($products),
                set::value(!empty($ART->product) ? $ART->product : '')
            )
        )
    ),
    formRow
    (
        formGroup
        (
            set::id('teamRow'),
            set::required(true),
            set::label($lang->pi->team),
            picker
            (
                set::multiple(true),
                set::name('team'),
                set::items($teams),
                set::value(!empty($ART->team) ? $ART->team : '')
            )
        )
    ),
    formRow(formGroup(set::required(true), set::label($lang->pi->plan), set::id('plansBox'), $plans)),
    formRow
    (
        formGroup
        (
            set::label($lang->pi->desc),
            editor(set::name('desc'))
        )
    ),
    formRow
    (
        formGroup
        (
            set::label($lang->pi->acl),
            radioList(set::name('acl'), set::items($lang->pi->aclList), set::value('extends'))
        )
    ),
    formRow
    (
        set::className('hidden'),
        formGroup
        (
            set::label($lang->pi->whitelist),
            picker
            (
                set::multiple(true),
                set::name('whitelist'),
                set::items($users)
            )
        )
    )
);
