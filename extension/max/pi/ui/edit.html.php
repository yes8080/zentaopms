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
jsVar('piID', $PI->id);
jsVar('+oldProduct', $PI->product);
jsVar('+oldTeam', $PI->team);
jsVar('hasLinkedProducts', $hasLinkedProducts);
jsVar('hasLinkedTeams', $hasLinkedTeams);
jsVar('hasLinkedExecutions', $hasLinkedExecutions);
jsVar('linkedExecutionTeams', $linkedExecutionTeams);
jsVar('linkedExecutionPlans', $linkedExecutionPlans);
jsVar('cannotRemoveProduct', $lang->pi->notice->cannotRemoveProduct);
jsVar('cannotRemoveTeam', $lang->pi->notice->cannotRemoveTeam);
jsVar('cannotRemoveExecution', $lang->pi->notice->cannotRemoveExecution);
jsVar('confirmRemoveTeam', $lang->pi->notice->confirmRemoveTeam);
jsVar('confirmRemoveExecution', $lang->pi->notice->confirmRemoveExecution);
jsVar('executionName', $lang->pi->execution);

$plans = array();
$index = 0;
foreach($executions as $execution)
{
    $plans[] = div
    (
        set::className('form-batch-control'),
        inputGroup
        (
            set::className('mb-2'),
            set('data-index', $index),
            input(set::name("plan[$index]"), set::value($execution->id), set::className('hidden')),
            input(set::name("execution[$index]"), set::value($execution->name), set::placeholder($lang->pi->execution)),
            span(set::className('input-group-addon'), $lang->pi->planDate),
            datePicker(set::id("beginPicker{$index}"), set::name("begin[$index]"), set::value($execution->begin)),
            span(set::className('input-group-addon'), $lang->hyphen),
            datePicker(set::id("endPicker{$index}"), set::name("end[$index]"), set::value($execution->end)),
            btn(setClass('btn ghost addLine ml-2'), icon('plus')),
            btn(setClass('btn ghost removeLine'), count($executions) == 1 ? setStyle('visibility', 'hidden') : null, icon('trash'))
        )
    );
    $index ++;
}

formPanel
(
    on::change('[name=ART]', 'changeART'),
    on::change('[name=acl]',  'changeAcl'),
    on::change('[name^=product]', 'changeProduct'),
    on::change('[name^=team]', 'changeTeam'),
    on::click('.addLine', 'addLine'),
    on::click('.removeLine', 'removeLine'),
    set::title($lang->pi->edit),
    set::submitBtnText($lang->save),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::label($lang->pi->name),
            set::name('name'),
            set::value($PI->name)
        )
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
                set::disabled(true),
                set::required(true),
                set::name('ART'),
                set::items($ARTList),
                set::value($PI->ART)
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
                set::id('product'),
                set::name('product'),
                set::items($products),
                set::value($product)
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
                set::id('team'),
                set::name('team'),
                set::items($teams),
                set::value($team)
            )
        )
    ),
    formRow(formGroup(set::required(true), set::label($lang->pi->plan), set::id('plansBox'), $plans)),
    formRow
    (
        formGroup
        (
            set::label($lang->pi->desc),
            editor(set::name('desc'), html($PI->desc))
        )
    ),
    formRow
    (
        formGroup
        (
            set::label($lang->pi->acl),
            radioList(set::name('acl'), set::items($lang->pi->aclList), set::value($PI->acl))
        )
    ),
    formRow
    (
        set::className($PI->acl != 'private' ? 'hidden' : ''),
        formGroup
        (
            set::label($lang->pi->whitelist),
            picker
            (
                set::multiple(true),
                set::name('whitelist'),
                set::items($users),
                set::value($PI->whitelist)
            )
        )
    )
);
