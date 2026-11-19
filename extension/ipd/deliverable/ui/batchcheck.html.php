<?php
/**
 * The batchCheck view file of deliverable module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @package     deliverable
 * @link        https://www.zentao.net
 */
namespace zin;

/* 检查环节按类型分组：任务/执行/项目关闭时。 */
$taskStageList      = $stageList['task'];
$executionStageList = $stageList['execution'];

/* 敏捷项目执行关闭时与项目一致,只保留必填下拉。 */
$isScrum = isset($executionStageList['sprint']);

modalHeader(set::title($lang->deliverable->batchCheck));
formPanel
(
    formHidden('deliverableIdList', implode(',', $deliverableIdList)),
    formHidden('saveBatchCheck', '1'),
    on::change('[name="taskClose"], [name="executionClose"], [name="projectClose"]', 'toggleCheckConfig'),
    div
    (
        setClass('check-step'),
        /* 任务关闭时检查，可按任务类型加多行。 */
        checkbox
        (
            set::name('taskClose'),
            set::text($lang->deliverable->taskCloseCheck)
        ),
        div
        (
            set::id('taskCloseConfig'),
            setClass('check-step-config hidden'),
            formBatch
            (
                set::minRows(1),
                set::mode('add'),
                set::tagName('div'),
                set::actions(array()),
                set::items(array
                (
                    array('label' => '', 'name' => 'taskStage', 'control' => array('control' => 'picker', 'shareSelections' => 'deliverableTaskStage'), 'items' => $taskStageList, 'placeholder' => $lang->deliverable->placeholderTaskType),
                    array('label' => '', 'name' => 'taskRequired', 'control' => 'picker', 'items' => $lang->deliverable->requiredList, 'value' => '1', 'required' => true)
                ))
            )
        ),
        /* 执行关闭时检查:敏捷项目只保留必填下拉,瀑布项目可加多行。 */
        checkbox
        (
            set::name('executionClose'),
            set::text($lang->deliverable->executionCloseCheck)
        ),
        div
        (
            set::id('executionCloseConfig'),
            setClass('check-step-config hidden'),
            $isScrum
            ? div
              (
                  setClass('execution-required-config'),
                  input(set::type('hidden'), set::name('execStage[]'), set::value('sprint'), set::disabled(true)),
                  picker
                  (
                      set::name('execRequired[]'),
                      set::value('1'),
                      set::items($lang->deliverable->requiredList),
                      set::required(true),
                      set::disabled(true)
                  )
              )
            : formBatch
              (
                  set::minRows(1),
                  set::mode('add'),
                  set::tagName('div'),
                  set::actions(array()),
                  set::items(array
                  (
                      array('label' => '', 'name' => 'execStage', 'control' => array('control' => 'picker', 'shareSelections' => 'deliverableStage'), 'items' => $executionStageList, 'placeholder' => $lang->deliverable->placeholderStage),
                      array('label' => '', 'name' => 'execRequired', 'control' => 'picker', 'items' => $lang->deliverable->requiredList, 'value' => '1', 'required' => true)
                  ))
              )
        ),
        /* 项目关闭时检查，仅一个下拉。 */
        checkbox
        (
            set::name('projectClose'),
            set::text($lang->deliverable->projectCloseCheck)
        ),
        div
        (
            set::id('projectCloseConfig'),
            setClass('check-step-config hidden'),
            input(set::type('hidden'), set::name('projectStage[]'), set::value('project'), set::disabled(true)),
            picker
            (
                set::name('projectRequired[]'),
                set::value('1'),
                set::items($lang->deliverable->requiredList),
                set::required(true),
                set::disabled(true)
            )
        )
    ),
    div
    (
        setClass('text-gray'),
        $lang->deliverable->batchCheckBuiltinTip
    )
);
