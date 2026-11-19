<?php
/**
 * The create view file of team module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     team
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('typeTip', $lang->team->tips->type);
set::title($lang->team->createAction);
formPanel
(
    on::change('[name=type]', 'changeType'),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::label($lang->team->type),
            set::required(true),
            radioList
            (
                set::name('type'),
                set::items($lang->team->typeList),
                set::value('child'),
                set::inline(true)
            ),
            div
            (
                set::className('flex self-center ml-4 pb-1'),
                icon('help', set('id', 'typeHover'), set::className('text-gray'))
            )
        )
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->team->parent),
        picker(set::name('parent'), set::items($parentTeams))
    ),
    formGroup(set::label($lang->team->name), set::name('name')),
    formGroup
    (
        set::label($lang->team->manager),
        set::required(true),
        picker(set::multiple(true), set::name('manager'), set::items($users))
    ),
    formRow
    (
        set::className('childParams'),
        formGroup(set::label($lang->team->slogan), set::name('slogan'))
    ),
    formRow
    (
        set::className('childParams'),
        formGroup(set::label($lang->team->declaration), editor(set::name('declaration')))
    ),
    formRow
    (
        set::className('childParams'),
        formGroup(set::label($lang->team->logo), fileSelector(set::maxFileCount(1)))
    )
);
