<?php
namespace zin;

jsVar('groupID', $groupID);
jsVar('designModule', $designModule ? (string)$designModule : '');

/* 检查环节按类型分组：任务/执行/项目关闭时。 */
$taskStageList      = $stageList['task'];
$executionStageList = $stageList['execution'];

/* 敏捷项目执行关闭时与项目一致,只保留必填下拉。 */
$isScrum = isset($executionStageList['sprint']);

formGridPanel
(
    set::title($lang->deliverable->createTitle),
    set::modeSwitcher(false),
    set::backUrl(createLink('deliverable', 'browse', "groupID=$groupID")),
    on::change('[name="taskClose"], [name="executionClose"], [name="projectClose"]', 'toggleCheckConfig'),
    on::change('[name="activity"]', 'changeActivity'),
    on::change('[name="trimmable"]', 'changeTrimmable'),
    on::change('[name="module"]', 'changeModule'),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->deliverable->module),
        picker
        (
            set::name('module'),
            set::items($modules),
            set::value($moduleID)
        )
    ),
    formGroup(set::width('1/2')),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->deliverable->name),
        set::name('name')
    ),
    formGroup(set::width('1/2')),
    formGroup
    (
        set::width('full'),
        set::label($lang->deliverable->desc),
        editor
        (
            set::name('desc')
        )
    ),
    formGroup
    (
        set::label($lang->deliverable->template),
        set::width('full'),
        deliverable
        (
            set::formName('template'),
            set::items(array(array('category' => $this->lang->other))),
            set::extraCategory(false),
            set::isTemplate(true)
        )
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->deliverable->activity),
        $hasProcess ?  '' : set::hidden(true),
        inputGroup
        (
            picker
            (
                set::name('activity'),
                set::items($activities),
                !$hasProcess ? set::value($otherActivity->id) : null
            ),
            common::hasPriv('activity', 'create') ? btnGroup
            (
                item(set(array
                (
                    'text' => $lang->deliverable->addActivity,
                    'icon' => 'plus',
                    'data-toggle' => 'modal',
                    'url' => createLink('activity', 'create', "groupID=$groupID&processID=0&from=deliverable"),
                    'class' => 'primary-pale btn ml-1'
                ))),
            ) : null
        )
    ),
    formGroup
    (
        set::width('full'),
        set::label($lang->deliverable->trimmable),
        set::labelHint($lang->deliverable->trimableNotice),
        $hasProcess ? '' : set::hidden(true),
        radioList
        (
            set::name('trimmable'),
            set::value($hasProcess ? '0' : $otherActivity->optional),
            set::items($lang->deliverable->trimmableList)
        ),
        input(setClass('hidden'), set::name('trimmable'), set::id('trimmable'), set::value('1'), set::disabled(true))
    ),
    formGroup
    (
        set::width('full'),
        set::label($lang->deliverable->trimRule),
        $hasProcess ? '' : set::hidden(true),
        input
        (
            set::name('trimRule'),
            set::disabled(true)
        )
    ),
    formGroup
    (
        set::width('full'),
        set::label($lang->deliverable->when),
        set::labelHint($lang->deliverable->whenNotice),
        set::required(true),
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
        )
    )
);
