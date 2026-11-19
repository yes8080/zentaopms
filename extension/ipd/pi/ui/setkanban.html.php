<?php
/**
 * The setkanban view file of PI module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     PI
 * @link        https://www.zentao.net
 */
namespace zin;

set::title($lang->pi->setKanban);
$app->loadLang('kanban');

formPanel
(
    formRow
    (
        formGroup
        (
            set::label($lang->pi->setColumn),
            radioList
            (
                set::name('fluidBoard'),
                set::items(array(1 => $lang->pi->columnWidth[1])),
                set::value($kanban->fluidBoard)
            ),
            div
            (
                set::className('flex items-center ml-5 py-1'),
                span($lang->pi->width),
                input(set::type('number'), set::min('240'), set::name('minColWidth'), set::className('w-16 size-sm mx-1'), set::value($kanban->minColWidth ? $kanban->minColWidth : 240)),
                span('px'),
                span('~', set::className('mx-1')),
                input(set::type('number'), set::min('240'), set::name('maxColWidth'), set::className('w-16 size-sm mx-1'), set::value($kanban->maxColWidth ? $kanban->maxColWidth : 500)),
                span('px')
            )
        )

    ),
    formRow
    (
        set::style(array('margin-top' => '0px')),
        formGroup
        (
            set::label(''),
            radioList
            (
                set::name('fluidBoard'),
                set::items(array('0' => $lang->pi->columnWidth[0])),
                set::value($kanban->fluidBoard)
            ),
            div
            (
                set::className('flex items-center ml-8 py-1'),
                set::style(array('padding-left' => '1px')),
                span($lang->pi->width),
                input(set::type('number'), set::min('200'), set::name('colWidth'), set::className('w-16 size-sm mx-1'), set::value($kanban->colWidth ? $kanban->colWidth : 200)),
                span('px')
            )
        )
    ),
    $type == 'team' ? formRow
    (
        formGroup
        (
            set::label($lang->pi->setLane),
            radioList
            (
                set::name('heightType'),
                set::items(array(0 => $lang->pi->laneHeight[1])),
                set::value($kanban->displayCards ? 1 : 0)
            )
        )
    ) : null,
    $type == 'team' ? formRow
    (
        set::style(array('margin-top' => '0px')),
        formGroup
        (
            set::label(''),
            radioList
            (
                set::name('heightType'),
                set::items(array(1 => $lang->pi->laneHeight[0])),
                set::value($kanban->displayCards ? 1 : 0)
            ),
            div
            (
                set::className('flex items-center ml-8 py-1'),
                span($lang->pi->width),
                input(set::type('number'), set::min('200'), set::name('displayCards'), set::className('w-16 size-sm mx-1'), set::value($kanban->displayCards ? $kanban->displayCards : 200)),
                span('px')
            )
        )
    ) : null
);
