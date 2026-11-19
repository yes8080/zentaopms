<?php
/**
 * The batchEdit view file of deliverable module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @package     deliverable
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('groupID', $groupID);
jsVar('optionalActivities', $optionalActivities);

$items = array();
$items[] = array('name' => 'id',        'label' => $lang->idAB,            'control' => 'index',  'width' => '32px');
$items[] = array('name' => 'module',    'label' => $lang->deliverable->module,    'control' => 'picker', 'required' => true, 'items' => $modules, 'width' => '160px');
$items[] = array('name' => 'name',      'label' => $lang->deliverable->name,      'control' => 'input',  'required' => true, 'width' => '200px');
$items[] = array('name' => 'activity',  'label' => $lang->deliverable->activity,  'control' => 'picker', 'required' => true, 'items' => $activities, 'width' => '200px', 'hidden' => !$hasProcess);
$items[] = array('name' => 'trimmable', 'label' => $lang->deliverable->trimmable, 'control' => array('control' => 'radioList', 'items' => $lang->deliverable->trimmableList), 'width' => '70px', 'hidden' => !$hasProcess);
$items[] = array('name' => 'trimRule',  'label' => $lang->deliverable->trimRule,  'control' => 'input', 'width' => '200px', 'hidden' => !$hasProcess);

formBatchPanel
(
    set::id('deliverableBatchEditForm'),
    set::title($lang->deliverable->batchEditTitle),
    set::backUrl(createLink('deliverable', 'browse', "groupID=$groupID")),
    set::mode('edit'),
    set::items($items),
    set::data(array_values($deliverables)),
    set::onRenderRow(jsRaw('renderDeliverableBatchRow')),
    on::change('[data-name="activity"]',  'changeBatchActivity'),
    on::change('[data-name="trimmable"]', 'changeBatchTrimmable')
);
render();
