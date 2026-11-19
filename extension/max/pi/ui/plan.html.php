<?php
/**
 * The plan view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

$firstKanban = reset($kanban);
$cardSize    = 1;
if($firstKanban && count($firstKanban['cols']) <= 3) $cardSize = 2;
$cookieCardSize = $this->cookie->planCardSize;
if($cookieCardSize)
{
    $cookieCardSize = json_decode($cookieCardSize, true);
    if($cookieCardSize && isset($cookieCardSize[$PI->plankanban])) $cardSize = $cookieCardSize[$PI->plankanban];
}

$privs = array
(
    'canViewStory'         => common::hasPriv('story', 'view'),
    'canLinkStory'         => common::hasPriv('pi', 'linkStory'),
    'canUnlinkStory'       => common::hasPriv('pi', 'unlinkStory'),
    'canAssignToStory'     => common::hasPriv('story', 'assignTo'),

    'canEditLane'          => common::hasPriv('pi', 'editLane'),
    'canDeleteLane'        => common::hasPriv('pi', 'deleteLane'),

    'canCreateMilestone'   => common::hasPriv('pi', 'createMilestone'),
    'canEditMilestone'     => common::hasPriv('pi', 'editMilestone'),
    'canDeleteMilestone'   => common::hasPriv('pi', 'deleteMilestone'),

    'canViewCard'          => common::hasPriv('pi', 'viewCard'),
    'canCreateCard'        => common::hasPriv('pi', 'createCard'),
    'canEditCard'          => common::hasPriv('pi', 'editCard'),
    'canFinishCard'        => common::hasPriv('pi', 'finishCard'),
    'canDeleteCard'        => common::hasPriv('pi', 'deleteCard'),
    'canActivateCard'      => common::hasPriv('pi', 'activateCard'),
    'canAssignToCard'      => common::hasPriv('pi', 'cardAssign'),
    'canMoveCard'          => common::hasPriv('pi', 'moveCard'),
);

jsVar('piID',             $PI->id);
jsVar('kanbanType',       'plankanban');
jsVar('piLang',           $lang->pi);
jsVar('kanbanLang',       $lang->kanban);
jsVar('estimateLang',     $lang->story->estimateAB);
jsVar('hourUnit',         $config->hourUnit);
jsVar('linkPairs',        $linkPairs);
jsVar('privs',            $privs);
jsVar('confirmMoveStory', $lang->pi->notice->confirmMoveStory);
jsVar('gradeGroups',      $gradeGroups);

dropmenu(set::tab('pi'), set::objectID($PI->id));

$kanbanList = array();
foreach($kanban as $groupID => $kanbanData)
{
    $kanbanItem = array();
    $kanbanItem['draggable']     = $privs['canMoveCard'];
    $kanbanItem['key']           = "group{$groupID}";
    $kanbanItem['data']          = $kanbanData;
    $kanbanItem['colWidth']      = $kanbanData['colWidth'];
    $kanbanItem['laneHeight']    = $kanbanData['laneHeight'];
    $kanbanItem['editLinks']     = $kanbanData['editLinks'] && hasPriv('pi', 'linkCard') && hasPriv('pi', 'unlinkCard');
    $kanbanItem['colProps']      = array('actions' => jsRaw('window.getColActions'));
    $kanbanItem['itemProps']     = array('actions' => jsRaw('window.getItemActions'));
    $kanbanItem['laneProps']     = array('actions' => jsRaw('window.getLaneActions'));
    $kanbanItem['onDrop']        = jsRaw('window.onDrop');
    $kanbanItem['canDrop']       = jsRaw('window.canDrop');
    $kanbanItem['getItem']       = jsRaw('window.getItem');
    $kanbanItem['onAddLink']     = jsRaw('window.linkCard');
    $kanbanItem['onDeleteLink']  = jsRaw('window.unlinkCard');

    if(!empty($kanbanData['minColWidth']))   $kanbanItem['minColWidth']   = $kanbanData['minColWidth'];
    if(!empty($kanbanData['maxColWidth']))   $kanbanItem['maxColWidth']   = $kanbanData['maxColWidth'];
    if(!empty($kanbanData['minLaneHeight'])) $kanbanItem['minLaneHeight'] = $kanbanData['minLaneHeight'];
    if(!empty($kanbanData['maxLaneHeight'])) $kanbanItem['maxLaneHeight'] = $kanbanData['maxLaneHeight'];
    $kanbanList[] = $kanbanItem;
}

featureBar
(
    div
    (
        set::className('border circle bg-white'),
        btn
        (
            set::className('ghost square size-xs m-2 minus'),
            $cardSize == 1 ? set::disabled(true) : null,
            icon('minus', set::className('circle border scale-120')),
            set('data-on', 'click'),
            set('data-call', 'changeCardSize'),
            set('data-params', 'event')
        ),
        span(set::className('px-2'), set::id('cardsize'), $cardSize),
        btn
        (
            set::className('ghost square size-xs m-2 plus'),
            icon('plus', set::className('circle border scale-120')),
            set('data-on', 'click'),
            set('data-call', 'changeCardSize'),
            set('data-params', 'event')
        )
    )
);
toolbar(item
(
    set
    (
        array
        (
            'text'  => $lang->pi->fullscreen,
            'icon'  => 'fullscreen',
            'class' => 'btn ghost',
            'url' => "javascript:$(\"#kanbanList\").fullscreen();"
        )
    )
), common::hasPriv('pi', 'setKanban') ? item
(
    set
    (
        array
        (
            'text'  => $lang->pi->setKanban,
            'url'   => $this->createLink('pi', 'setKanban', "kanban=$PI->plankanban&type=plan"),
            'icon'  => 'cog',
            'class' => 'btn primary',
            'data-toggle' => 'modal'
        )
    )
) : null, common::hasPriv('pi', 'createLane') ? item
(
    set
    (
        array
        (
            'text'  => $lang->pi->createLane,
            'url'   => $this->createLink('pi', 'createLane', "kanban=$PI->plankanban"),
            'icon'  => 'plus',
            'class' => 'btn primary',
            'data-toggle' => 'modal'
        )
    )
) : null);

div
(
    set::className('bg-white p-4'),
    set::id('kanbanList'),
    zui::kanbanList
    (
        set::key('planKanban'),
        set::items($kanbanList),
        setData(array('id' => $PI->plankanban, 'type' => 'plan')),
        set::kanbanProps(array('itemCountPerRow' => $cardSize)),
        set::height('calc(100vh - 150px)')
    )
);

render();
