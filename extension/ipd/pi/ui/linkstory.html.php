<?php
/**
 * The linkStory view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('piID', $PI->id);
jsVar('columnID', $columnID);
jsVar('from', $from);
jsVar('browseType', $browseType);
jsVar('gradeGroups', $gradeGroups);

$cols = array();
foreach($config->pi->defaultFields['linkstory'] as $field) $cols[$field] = zget($config->pi->story->dtable->fieldList, $field, array());
$cols = array_map(function($col){$col['show'] = true; return $col;}, $cols);
$cols['title']['link']         = $this->createLink('story', 'view', "storyID={id}");
$cols['title']['nestedToggle'] = false;
$cols['title']['data-toggle']  = 'modal';
$cols['title']['data-size']    = 'lg';
$cols['assignedTo']['type']    = 'user';
$cols['product']['type']       = 'category';
$cols['product']['map']        = $products;
$cols['plan']['map']           = $plans;
$cols['product']['width']      = 200;

foreach($stories as $story)
{
    $story->estimate = helper::formatHours($story->estimate) . $config->hourUnit;

    $planTitle = array();
    foreach(explode(',', $story->plan) as $planID) $planTitle[] = zget($plans, $planID, '');
    $story->plan = implode(',', $planTitle);
}

set::title($lang->pi->linkStory);
set::bodyClass('linkstory-modal-body');

$options = array();

div(set::className('mt-2 mb-2 flex items-center'), $options);
if($from != 'plan')
{
    searchForm
    (
        set::module('pistory'),
        set::simple(true),
        set::show(true)
    );
}

formBase
(
    set::actions(''),
    dtable
    (
        set::id('linkStoryList'),
        set::userMap($users),
        set::cols($cols),
        set::data(array_values($stories)),
        set::onRenderCell(jsRaw('window.renderStoryCell')),
        set::footToolbar(array('items' => array(array
        (
            'text'      => $lang->pi->linkStory,
            'btnType'   => 'primary',
            'className' => 'size-sm linkObjectBtn batch-btn',
            'data-type' => 'story',
            'data-url'  => inlink('linkStory', "piID={$PI->id}&columnID={$columnID}&from=$from&fromLane=$fromLane&toLane=$toLane"),
        ))
    )),
    set::orderBy($orderBy),
    set::sortLink(inlink('linkStory', "piID={$PI->id}&columnID={$columnID}&from=$from&fromLane=$fromLane&toLane=$toLane&browseType={$browseType}&param={$param}&orderBy={name}_{sortType}")),
    set::footPager(usePager(array
    (
        'recPerPage'  => $pager->recPerPage,
        'recTotal'    => $pager->recTotal,
        'linkCreator' => helper::createLink('pi', 'linkStory', "piID={$PI->id}&columnID={$columnID}&from=$from&fromLane=$fromLane&toLane=$toLane&browseType={$browseType}&param={$param}&orderBy={$orderBy}&recTotal={$pager->recTotal}&recPerPage={recPerPage}&page={page}")
    ))))
);
