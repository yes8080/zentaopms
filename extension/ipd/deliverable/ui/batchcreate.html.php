<?php
/**
 * The batchCreate view file of deliverable module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @package     deliverable
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('groupID', $groupID);

$items = array();
$items[] = array('name' => 'module',    'label' => $lang->deliverable->module,    'control' => 'picker', 'items' => $modules, 'value' => $moduleID, 'width' => '160px', 'ditto' => true);
$items[] = array('name' => 'name',      'label' => $lang->deliverable->name,      'control' => 'input', 'required' => true, 'width' => '200px');
$items[] = array('name' => 'template',  'label' => $lang->deliverable->template,  'control' => array('control' => 'remotePicker', 'multiple' => true, 'items' => createLink('doc', 'ajaxGetTemplateDocs', 'keyword={search}'), 'id' => '{GID}_template'), 'width' => '200px', 'ditto' => true);
$items[] = array('name' => 'activity',  'label' => $lang->deliverable->activity,  'control' => 'picker', 'items' => $activities, 'width' => '200px', 'ditto' => true, 'hidden' => !$hasProcess, 'value' => $hasProcess ? '' : $otherActivity->id);
$items[] = array('name' => 'trimmable', 'label' => $lang->deliverable->trimmable, 'control' => array('control' => 'radioList', 'items' => $lang->deliverable->trimmableList), 'width' => '100px', 'hidden' => !$hasProcess, 'value' => $hasProcess ? '0' : $otherActivity->optional);
$items[] = array('name' => 'trimRule',  'label' => $lang->deliverable->trimRule,  'control' => 'input',  'width' => '200px', 'hidden' => !$hasProcess, 'disabled' => true);

formBatchPanel
(
    set::id('deliverableBatchCreateForm'),
    set::title($lang->deliverable->batchCreateTitle),
    set::backUrl(createLink('deliverable', 'browse', "groupID=$groupID")),
    set::items($items),
    on::change('[data-name="activity"]',  'changeBatchActivity'),
    on::change('[data-name="trimmable"]', 'changeBatchTrimmable')
);
render();
