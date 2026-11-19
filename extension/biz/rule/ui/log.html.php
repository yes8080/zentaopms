<?php
/**
 * The log file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('ruleID', $ruleID);
jsVar('orderBy', $orderBy);

set::title($lang->rule->log);
set::bodyClass('log-modal-body');

$options = array();
$options[] = div(setClass('option-box ml-4 flex'), span
(
    set::className('flex items-center team-title mr-4'),
    $lang->rule->begin
), datePicker(set::name('begin'), set::value($begin), set::width(200), on::change('changeDate')));

$options[] = div(setClass('option-box ml-4 flex'), span
(
    set::className('flex items-center team-title mr-4'),
    $lang->rule->end
), datePicker(set::name('end'), set::value($end), set::width(200), on::change('changeDate')));

div(set::className('mt-2 mb-2 flex items-center'), $options);

$cols = $this->config->rulequeue->dtable->fieldList;
foreach($logs as $key => $log)
{
    $logs[$key]->statusLabel = zget($lang->rulequeue->statusList, $log->status);
}

dtable
(
    setID('logTable'),
    set::userMap($users),
    set::cols($cols),
    set::footPager(usePager(array())),
    set::orderBy($orderBy),
    set::sortLink(inlink('log', "ruleID=$ruleID&orderBy={name}_{sortType}")),
    set::data(array_values($logs)),
    set::onRenderCell(jsRaw('window.renderLogCell'))
);
