<?php
/**
 * The view card view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming <sunguangming@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

detailHeader
(
    to::title
    (
        entityLabel
        (
            set(array('entityID' => $card->id, 'level' => 1,)),
            $card->name
        ),
        $card->deleted ? span(set::className('label danger'), $lang->pi->deleted) : null
    )
);

$actionList = $this->loadModel('common')->buildOperateMenu($card);

detailBody
(
    sectionList
    (
        section
        (
            set::title($lang->kanbancard->desc),
            set::content($card->desc),
            set::useHtml(true)
        ),
        history(set::objectID($card->id), set::objectType('picard'), set::hasComment(false))
    ),
    floatToolbar(set::object($card), set::main($actionList['mainActions']), set::suffix($actionList['suffixActions'])),
    detailSide
    (
        tabs
        (
            tabPane
            (
                set::key('legendBasicInfo'),
                set::title($lang->kanbancard->legendBasicInfo),
                set::active(true),
                tableData
                (
                    item(set::name($lang->kanbancard->assignedTo), \zget($users, $card->assignedTo)),
                    item(set::name($lang->kanbancard->begin),      helper::isZeroDate($card->begin) ? '' : $card->begin),
                    item(set::name($lang->kanbancard->end),        helper::isZeroDate($card->end) ? '' : $card->end),
                    item(set::name($lang->kanbancard->status),     span(setClass("status-{$card->status}"), \zget($lang->pi->cardStatusList, $card->status))),
                    item(set::name($lang->kanbancard->pri),        span(setClass("pri-{$card->pri}"), \zget($lang->kanbancard->priList, $card->pri))),
                    item(set::name($lang->kanbancard->estimate),   $card->estimate . 'h')
                )
            ),
            tabPane
            (
                set::key('legendLifeTime'),
                set::title($lang->kanbancard->legendLifeTime),
                tableData
                (
                    item(set::name($lang->kanbancard->createdBy), \zget($users, $card->createdBy) . $lang->at . $card->createdDate),
                    item(set::name($lang->kanbancard->lastEditedBy), $card->lastEditedDate ? \zget($users, $card->lastEditedBy) . $lang->at . $card->lastEditedDate : '')
                )
            )
        )
    )
);
