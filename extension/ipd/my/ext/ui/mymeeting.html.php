<?php
/**
 * The meeting view file of my module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     my
 * @link        https://www.zentao.net
 */
namespace zin;

include $app->getModuleRoot() . 'my/ui/header.html.php';

featureBar
(
    set::current($browseType),
    set::linkParams("mode={$mode}&type={key}&param=&orderBy={$orderBy}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}"),
    li(searchToggle(set::module('workMeeting'), set::open($browseType == 'bysearch')))
);

$cols = $this->loadModel('datatable')->getSetting('my', 'meeting');
if(isset($cols['dept']))      $cols['dept']['map']      = $depts;
if(isset($cols['project']))   $cols['project']['map']   = $projects;
if(isset($cols['execution'])) $cols['execution']['map'] = $executions;
if(isset($cols['room']))      $cols['room']['map']      = array('0' => '') + $rooms;

$meetings = initTableData($meetings, $cols, $this->meeting);

foreach($meetings as $meeting)
{
    $begin = !empty($meeting->begin) ? ' ' . date('H:i', strtotime($meeting->begin)) : '';
    $end   = !empty($meeting->end)   ? ' ' . date('H:i', strtotime($meeting->end))   : '';
    $meeting->begin = trim(($meeting->date ?? '') . $begin);
    $meeting->end   = trim(($meeting->date ?? '') . $end);
}

dtable
(
    set::cols(array_values($cols)),
    set::data(array_values($meetings)),
    set::userMap($users),
    set::customCols(true),
    set::moduleName('my'),
    set::methodName('meeting'),
    set::orderBy($orderBy),
    set::sortLink(createLink('my', $app->rawMethod, "mode={$mode}&type={$browseType}&param={$param}&orderBy={name}_{sortType}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}")),
    set::footPager(usePager())
);

render();
