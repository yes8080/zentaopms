<?php
/**
 * The importDeliverable view file of task module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang<wangyuting@chandao.com>
 * @package     task
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('executionID',  $executionID);
jsVar('leastOne',     $lang->task->leastOne);
jsVar('repeatImport', $lang->task->deliverableTips->repeatImport);
jsVar('deliverables', $deliverablePairs);
jsVar('importedList', $importedList);

modalHeader(set::title($title), set::titleClass('font-bold text-lg'), to::suffix(icon('help', setClass('ml-2 mr-1')), $lang->task->onlyTask));

$config->task->importDeliverable->dtable->fieldList['activity']['map'] = $activities;
$config->task->importDeliverable->dtable->fieldList['stage']['map']    = zget($stageList, 'task', array());

formPanel
(
    set::ajax(array('beforeSubmit' => jsRaw("clickSubmit"))),
    set::actionsClass('form-group no-label disabled'),
    set::submitBtnText($lang->task->next),
    dtable
    (
        set::cols($config->task->importDeliverable->dtable->fieldList),
        set::data($deliverables),
        set::checkable(true),
        set::checkInfo(jsRaw('function(checks){ if(checks.length) {$(".form-actions").removeClass("disabled");} else {$(".form-actions").addClass("disabled");} return "' . $lang->task->toTaskName . '"}')),
    )
);
