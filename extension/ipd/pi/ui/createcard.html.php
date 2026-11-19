<?php
/**
 * The create card view file of PI module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     PI
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader(set::title($lang->pi->createCard));

formPanel
(
    formRow
    (
        formGroup
        (
            set::required(true),
            set::width('1/2'),
            set::label($lang->kanbancard->name),
            input
            (
                set::name('name')
            )
        ),
        formGroup
        (
            set::width('1/2'),
            set::label($lang->kanbancard->pri),
            inputGroup(priPicker(set::name('pri'), set::value(3), set::required(true), set::items($lang->kanbancard->priList)), span(setClass('input-group-addon ghost'), $lang->kanbancard->estimate), input(set::type('number'), set::name('estimate'), set::max('99999'), set::min('0'), set::step('0.01'), set::placeholder($config->hourUnit)))
        )
    ),
    formRow(formGroup
    (
        set::label($lang->kanbancard->lane),
        set::required(true),
        picker
        (
            set::name('lane'),
            set::required(true),
            set::items($lanes)
        )
    )),
    formRow(formGroup
    (
        set::label($lang->kanbancard->assignedTo),
        picker
        (
            set::name('assignedTo'),
            set::items($users)
        )
    )),
    formRow(formGroup
    (
        set::label($lang->kanbancard->progress),
        set::width('1/2'),
        inputGroup(input(set::name('progress')), span(setClass('input-group-addon'), '%'))
    )),
    formRow(formGroup
    (
        set::label($lang->kanbancard->beginAndEnd),
        inputGroup(datePicker(set::name('begin'), set::placeholder($lang->kanbancard->begin)), span(setClass('input-group-addon ghost'), $lang->kanbancard->to), datePicker(set::name('end'), set::placeholder($lang->kanbancard->end)))
    )),
    formGroup
    (
        set::label($lang->kanbancard->desc),
        editor(set::name('desc'), set::placeholder($lang->kanbancard->desc))
    )
);
