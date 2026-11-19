<?php
/**
 * The create milestone view file of PI module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     PI
 * @link        https://www.zentao.net
 */
namespace zin;

$title = $lang->pi->createMilestone;
if($lanes) $title = $lang->pi->createTeamCard;
if($from == 'team') $title = $lang->pi->createObjective;
modalHeader(set::title($title));

formPanel
(
    $lanes ? formGroup
    (
        set::label($lang->pi->milestone->lane),
        picker(set::name('lane'), set::items($lanes), set::required(true))
    ) : null,
    formGroup
    (
        set::required(true),
        set::label($lang->pi->milestone->name),
        input(set::name('name'))
    ),
    formGroup
    (
        set::label($lang->pi->milestone->end),
        set::required(true),
        datePicker(set::name('end'))
    ),
    formGroup
    (
        set::label($lang->pi->milestone->assignedTo),
        picker(set::name('assignedTo'), set::items($users))
    ),
    formGroup
    (
        set::label($lang->pi->milestone->status),
        picker(set::name('status'), set::value('normal'), set::required(true), set::items($lang->pi->milestone->statusList))
    )
);
