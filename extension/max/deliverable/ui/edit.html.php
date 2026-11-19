<?php
namespace zin;

$stages = $deliverable->stages;

jsVar('designModule', $designModule ? (string)$designModule : '');

/* 检查环节按类型分组：任务/执行/项目关闭时。 */
$taskStageList      = $stageList['task'];
$executionStageList = $stageList['execution'];

/* 敏捷项目执行关闭时与项目一致,只保留必填下拉。 */
$isScrum = isset($executionStageList['sprint']);

$isDesign  = !empty($designModule) && (string)$deliverable->module === (string)$designModule;
$isBuildin = in_array($deliverable->category, $this->config->deliverable->builtinCategoryList) || $deliverable->systemList == 1 || $isDesign;

$projectChecked  = false;
$projectRequired = '1';
$taskStages      = array();
$execStages      = array();
foreach($stages as $stageRow)
{
    if($stageRow->type == 'task')
    {
        $taskStages[$stageRow->stage] = $stageRow->required;
    }
    elseif($stageRow->type == 'project')
    {
        $projectChecked  = true;
        $projectRequired = $stageRow->required;
    }
    else
    {
        $execStages[$stageRow->stage] = $stageRow->required;
    }
}
$taskChecked = !empty($taskStages);
$execChecked = !empty($execStages);
if(empty($taskStages)) $taskStages = array('' => '1');
if(empty($execStages)) $execStages = array('' => '1');

/* 构建执行关闭时检查的阶段行，敏捷项目只保留必填下拉。*/
$execRowsData = array();
if(!$isScrum)
{
    foreach($execStages as $stage => $required)
    {
        if($stage === '') continue;
        $execRowsData[] = array('execStage' => $stage, 'execRequired' => $required);
    }
}

/* 构建任务关闭时检查的任务类型行，内置交付物不支持配置任务关闭时检查 */
$taskRowsData = array();
if(!$isBuildin)
{
    foreach($taskStages as $stage => $required)
    {
        if($stage === '') continue;
        $taskRowsData[] = array('taskStage' => $stage, 'taskRequired' => $required);
    }
}

formGridPanel
(
    set::title($lang->deliverable->editTitle),
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
            set::value($deliverable->module),
            set::items($modules),
            set::disabled(!empty($deliverable->systemList))
        )
    ),
    formGroup(set::width('1/2')),
    formGroup
    (
        set::disabled(in_array($deliverable->category, $this->config->deliverable->builtinCategoryList) || !empty($deliverable->builtin)),
        set::width('1/2'),
        set::label($lang->deliverable->name),
        set::value($deliverable->name),
        set::name('name')
    ),
    formGroup(set::width('1/2')),
    formGroup
    (
        set::width('full'),
        set::label($lang->deliverable->desc),
        editor
        (
            set::value($deliverable->desc),
            set::name('desc')
        )
    ),
    formGroup
    (
        set::label($lang->deliverable->template),
        set::width('full'),
        set::hidden(!empty($deliverable->systemList)),
        deliverable
        (
            set::formName('template'),
            set::items($deliverable->template),
            set::extraCategory(false),
            set::isTemplate(true)
        )
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->deliverable->activity),
        set::required(true),
        $hasProcess ? '' : set::hidden(true),
        picker
        (
            set::name('activity'),
            set::value($deliverable->activity),
            set::items($activities)
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
            set::value($deliverable->trimmable),
            set::items($lang->deliverable->trimmableList),
            set::disabled($activity && $activity->optional == 'yes')
        ),
        input(setClass('hidden'), set::name('trimmable'), set::id('trimmable'), set::value('1'), set::disabled(empty($activity) || $activity->optional != 'yes'))
    ),
    formGroup
    (
        set::width('full'),
        set::label($lang->deliverable->trimRule),
        $hasProcess ? '' : set::hidden(true),
        input
        (
            set::name('trimRule'),
            set::value($deliverable->trimRule),
            set::disabled($deliverable->trimmable == '0')
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
            !$isBuildin ? checkbox
            (
                set::name('taskClose'),
                set::text($lang->deliverable->taskCloseCheck),
                set::checked($taskChecked)
            ) : null,
            !$isBuildin ? div
            (
                set::id('taskCloseConfig'),
                setClass('check-step-config', $taskChecked ? '' : 'hidden'),
                formBatch
                (
                    set::minRows(1),
                    set::mode('add'),
                    set::tagName('div'),
                    set::actions(array()),
                    !empty($taskRowsData) ? set::data($taskRowsData) : null,
                    set::items(array
                    (
                        array('label' => '', 'name' => 'taskStage', 'control' => array('control' => 'picker', 'shareSelections' => 'deliverableTaskStage'), 'items' => $taskStageList, 'placeholder' => $lang->deliverable->placeholderTaskType),
                        array('label' => '', 'name' => 'taskRequired', 'control' => 'picker', 'items' => $lang->deliverable->requiredList, 'value' => '1', 'required' => true)
                    ))
                )
            ) : null,
            /* 执行关闭时检查:敏捷项目只保留必填下拉,瀑布项目可加多行。 */
            checkbox
            (
                set::name('executionClose'),
                set::text($lang->deliverable->executionCloseCheck),
                set::checked($execChecked)
            ),
            div
            (
                set::id('executionCloseConfig'),
                setClass('check-step-config', $execChecked ? '' : 'hidden'),
                $isScrum
                ? div
                  (
                      setClass('execution-required-config'),
                      input(set::type('hidden'), set::name('execStage[]'), set::value('sprint'), set::disabled(!$execChecked)),
                      picker
                      (
                          set::name('execRequired[]'),
                          set::value(isset($execStages['sprint']) ? $execStages['sprint'] : '1'),
                          set::items($lang->deliverable->requiredList),
                          set::required(true),
                          set::disabled(!$execChecked)
                      )
                  )
                : formBatch
                  (
                      set::minRows(1),
                      set::mode('add'),
                      set::tagName('div'),
                      set::actions(array()),
                      !empty($execRowsData) ? set::data($execRowsData) : null,
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
                set::text($lang->deliverable->projectCloseCheck),
                set::checked($projectChecked)
            ),
            div
            (
                set::id('projectCloseConfig'),
                setClass('check-step-config', $projectChecked ? '' : 'hidden'),
                input(set::type('hidden'), set::name('projectStage[]'), set::value('project'), set::disabled(!$projectChecked)),
                picker
                (
                    set::name('projectRequired[]'),
                    set::value($projectRequired),
                    set::items($lang->deliverable->requiredList),
                    set::required(true),
                    set::disabled(!$projectChecked)
                )
            )
        )
    )
);
