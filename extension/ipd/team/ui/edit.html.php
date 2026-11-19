<?php
/**
 * The edit view file of team module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     team
 * @link        https://www.zentao.net
 */
namespace zin;

set::title($lang->team->editAction);
formPanel
(
    set::submitBtnText($lang->save),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::label($lang->team->parent),
            picker
            (
                set::name('parent'),
                set::items($parentTeams),
                set::value($team->parent)
            )
        )
    ),
    formGroup(set::label($lang->team->name), set::name('name'), set::value($team->name)),
    formRow
    (
        formGroup
        (
            set::label($lang->team->manager),
            set::required(true),
            picker
            (
                set::multiple(true),
                set::name('manager'),
                set::items($users),
                set::value($team->manager)
            )
        )
    ),
    formRow
    (
        set::className('childParams ' . ($team->type == 'parent' ? 'hidden' : '')),
        formGroup
        (
            set::label($lang->team->slogan),
            set::name('slogan'),
            set::value($team->slogan)
        )
    ),
    formRow
    (
        set::className('childParams ' . ($team->type == 'parent' ? 'hidden' : '')),
        formGroup
        (
            set::label($lang->team->declaration),
            editor(set::name('declaration'), html($team->declaration))
        )
    ),
    formRow
    (
        set::className('childParams ' . ($team->type == 'parent' ? 'hidden' : '')),
        formGroup(set::label($lang->team->logo), fileSelector(set::maxFileCount(1)))
    )
);
