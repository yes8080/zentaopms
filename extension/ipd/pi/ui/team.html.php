<?php
/**
 * The team view file of pi module of ZenTaoPMS.
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
$cookieCardSize = $this->cookie->teamCardSize;
if($cookieCardSize)
{
    $cookieCardSize = json_decode($cookieCardSize, true);
    if($cookieCardSize && isset($cookieCardSize[$PI->teamkanban])) $cardSize = $cookieCardSize[$PI->teamkanban];
}

$privs = array
(
    'canSetCapacity'     => common::hasPriv('pi', 'setCapacity'),
    'canEditLane'        => common::hasPriv('pi', 'editLane'),

    'canCreateRisk'      => common::hasPriv('risk', 'create'),
    'canEditRisk'        => common::hasPriv('risk', 'edit'),
    'canViewRisk'        => common::hasPriv('risk', 'view'),
    'canCloseRisk'       => common::hasPriv('risk', 'close'),
    'canActivateRisk'    => common::hasPriv('risk', 'activate'),
    'canDeleteRisk'      => common::hasPriv('risk', 'delete'),
    'canMoveCard'        => common::hasPriv('pi', 'moveCard'),
    'canViewCard'        => common::hasPriv('pi', 'viewCard'),
    'canEditCard'        => common::hasPriv('pi', 'editCard'),
    'canFinishCard'      => common::hasPriv('pi', 'finishCard'),
    'canActivateCard'    => common::hasPriv('pi', 'activateCard'),
    'canDeleteCard'      => common::hasPriv('pi', 'deleteCard'),

    'canCreateStory'     => common::hasPriv('story', 'create'),
    'canCreateRequirement' => common::hasPriv('requirement', 'create'),
    'canCreateEpic'      => common::hasPriv('epic', 'create'),
    'canViewStory'       => common::hasPriv('story', 'view'),
    'canAssignToStory'   => common::hasPriv('story', 'assignTo'),
    'canLinkStory'       => common::hasPriv('pi', 'linkStory'),
    'canUnlinkStory'     => common::hasPriv('pi', 'unlinkStory'),
    'canCreateCard'      => common::hasPriv('pi', 'createCard'),

    'canCreateObjective' => common::hasPriv('pi', 'createMilestone'),
    'canEditObjective'   => common::hasPriv('pi', 'editMilestone'),
    'canDeleteObjective' => common::hasPriv('pi', 'deleteMilestone'),
);

if(!$config->URAndSR) $privs['canCreateRequirement'] = false;
if(!$config->enableER) $privs['canCreateEpic']       = false;

$products = explode(',', $PI->product);
$product  = reset($products);

jsVar('piID',             $PI->id);
jsVar('kanbanType',       'teamkanban');
jsVar('product',          $product);
jsVar('hourUnit',         $config->hourUnit);
jsVar('confirmUnlink',    $lang->pi->notice->confirmUnlinkStory);
jsVar('editLabel',        $lang->edit);
jsVar('createStory',      $lang->pi->createStory);
jsVar('createRequirement',$lang->pi->createRequirement);
jsVar('createEpic',       $lang->pi->createEpic);
jsVar('createCard',       $lang->pi->createCard);
jsVar('editCard',         $lang->pi->editCard);
jsVar('finishCard',       $lang->pi->finishCard);
jsVar('activateCard',     $lang->pi->activateCard);
jsVar('deleteCard',       $lang->pi->deleteCard);
jsVar('confirmDeleteCard',$lang->pi->notice->confirmDeleteCard);
jsVar('linkStory',        $lang->pi->linkStory);
jsVar('unlinkStory',      $lang->pi->unlinkStory);
jsVar('workhourLabel',    $lang->pi->workhour);
jsVar('capacityLabel',    $lang->pi->capacity);
jsVar('workloadLabel',    $lang->pi->workload);
jsVar('editObjective',    $lang->pi->editObjective);
jsVar('deleteObjective',  $lang->pi->deleteObjective);
jsVar('confirmDelete',    $lang->pi->milestone->confirmDelete);
jsVar('confirmMoveStory', $lang->pi->notice->confirmMoveStory);
jsVar('riskLang',         $lang->risk);
jsVar('estimateLang',     $lang->story->estimateAB);
jsVar('editLane',         $lang->pi->editLane);
jsVar('featuresLang',     $lang->pi->features);
jsVar('privs',            $privs);
jsVar('teamID',           $teamID);

dropmenu(set::tab('pi'), set::objectID($PI->id));

$teamItems = array();
$teamItems[] = array('text' => $lang->all, 'active' => !$teamID, 'url' => $this->createLink('pi', 'team', "id={$PI->id}&teamID=0"));
foreach($teams as $currentID => $team) $teamItems[] = array('text' => $team, 'active' => $currentID == $teamID, 'hint' => $team, 'url' => $this->createLink('pi', 'team', "id={$PI->id}&teamID={$currentID}"));

featureBar
(
    dropdown
    (
        setClass('mr-2'),
        btn
        (
            setClass('ghost'),
            \zget($teams, $teamID, $lang->all)
        ),
        set::items($teamItems)
    ),
    div
    (
        set::className('border circle bg-white'),
        btn
        (
            set::className('ghost square size-xs m-2 minus'),
            $cardSize == 1 ? set('disabled', true) : null,
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

toolbar
(
    common::hasPriv('pi', 'setKanban') ? item
    (
        set
        (
            array
            (
                'text'  => $lang->pi->setKanban,
                'url'   => $this->createLink('pi', 'setKanban', "kanban=$PI->teamkanban"),
                'icon'  => 'cog',
                'class' => 'btn primary',
                'data-toggle' => 'modal'
            )
        )
    ) : null
);

$kanbanList = array();
foreach($kanban as $groupID => $kanbanData)
{
    $kanbanItem = array();
    $kanbanItem['key']           = "group{$groupID}";
    $kanbanItem['colWidth']      = $kanbanData['colWidth'];
    $kanbanItem['laneHeight']    = $kanbanData['laneHeight'];
    $kanbanItem['data']          = $kanbanData;
    $kanbanItem['onDropNewItem'] = jsRaw('window.onDropNewItem');
    $kanbanItem['onDrop']        = jsRaw('window.onDrop');
    $kanbanItem['canDrop']       = jsRaw('window.canDrop');
    $kanbanItem['getItem']       = jsRaw('window.getItem');
    $kanbanItem['getCol']        = jsRaw('window.getCol');
    $kanbanItem['getLane']       = jsRaw('window.getLane');
    $kanbanItem['colProps']      = array('actions' => jsRaw('window.getColActions'));
    $kanbanItem['itemProps']     = array('actions' => jsRaw('window.getItemActions'));
    $kanbanItem['laneProps']     = array('actions' => jsRaw('window.getLaneActions'));

    if($privs['canMoveCard']) $kanbanItem['draggable'] = array('dragContainer' => '#kanban-container');

    if(!empty($kanbanData['minColWidth']))   $kanbanItem['minColWidth']   = $kanbanData['minColWidth'];
    if(!empty($kanbanData['maxColWidth']))   $kanbanItem['maxColWidth']   = $kanbanData['maxColWidth'];
    if(!empty($kanbanData['minLaneHeight'])) $kanbanItem['minLaneHeight'] = $kanbanData['minLaneHeight'];
    if(!empty($kanbanData['maxLaneHeight'])) $kanbanItem['maxLaneHeight'] = $kanbanData['maxLaneHeight'];
    $kanbanList[] = $kanbanItem;
}

div
(
    set::id('kanban-container'),
    div
    (
        setClass('min-w-0'),
        zui::kanbanList
        (
            on::inited()->call('window.initedKanban'),
            set('$replace', false),
            set::key('teamKanban'),
            setData(array('id' => $PI->teamkanban, 'type' => 'team')),
            set::items($kanbanList),
            set::kanbanProps(array('itemCountPerRow' => $cardSize)),
            set::height('calc(100vh - 120px)')
        )
    )
);

render();
