<?php
/**
 * The edit milestone view file of PI module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     PI
 * @link        https://www.zentao.net
 */
namespace zin;

$isMilestone = false;
if($lane && $lane->type == 'milestone') $isMilestone = true;
modalHeader(set::title($isMilestone ? $lang->pi->editMilestone : $lang->pi->editObjective));

formPanel
(
    formGroup
    (
        set::required(true),
        set::label($lang->pi->milestone->name),
        input(set::name('name'), set::value($milestone->name))
    ),
    formGroup
    (
        set::label($lang->pi->milestone->end),
        set::required(true),
        datePicker(set::name('end'), set::value($milestone->end))
    ),
    formGroup
    (
        set::label($lang->pi->milestone->assignedTo),
        picker(set::name('assignedTo'), set::items($users), set::value($milestone->assignedTo))
    ),
    formGroup
    (
        set::label($lang->pi->milestone->status),
        picker(set::name('status'), set::value($milestone->status), set::required(true), set::items($lang->pi->milestone->statusList))
    )
);
