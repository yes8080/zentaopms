<?php
$lang->aiprocedure->common              = '工序';
$lang->aiprocedure->browse              = '浏览工序';
$lang->aiprocedure->create              = '创建工序';
$lang->aiprocedure->view                = '工序详情';
$lang->aiprocedure->edit                = '编辑';
$lang->aiprocedure->design              = '设计';
$lang->aiprocedure->publish             = '发布';
$lang->aiprocedure->unpublish           = '下架';
$lang->aiprocedure->delete              = '删除工序';
$lang->aiprocedure->name                = '工序名称';
$lang->aiprocedure->module              = '显示位置';
$lang->aiprocedure->desc                = '描述';
$lang->aiprocedure->status              = '状态';
$lang->aiprocedure->createdBy           = '由谁创建';
$lang->aiprocedure->createdDate         = '创建时间';
$lang->aiprocedure->finishedDate        = '完成时间';
$lang->aiprocedure->publishedBy         = '由谁发布';
$lang->aiprocedure->unpublishedBy       = '由谁下架';
$lang->aiprocedure->lastEdited          = '最后编辑';
$lang->aiprocedure->basicInfo           = '基本信息';
$lang->aiprocedure->steps               = '步骤';
$lang->aiprocedure->back                = '返回';
$lang->aiprocedure->noData              = '暂无工序';
$lang->aiprocedure->notFound            = '工序不存在';
$lang->aiprocedure->confirmDelete       = '删除后，工序将不能继续使用，您确定要删除吗？';
$lang->aiprocedure->designNeedUnpublish = '已发布工序需先下架后才能设计';
$lang->aiprocedure->publishNeedSteps    = '发布失败，需为工序设计执行步骤再发布';
$lang->aiprocedure->saveNeedFinishRun   = '保存失败，有工序正在处理中，请完成或结束工序后再保存';
$lang->aiprocedure->procedureRef        = '"%s"工序';
$lang->aiprocedure->agentUnpublishNotice = '已上架的%s中使用了该智能体。智能体下架后，工序也会同步下架，后续需要重新手动上架工序。';
$lang->aiprocedure->publishNeedActiveAgents = '发布失败，工序中的智能体"%s"未上架或已被删除，请先上架智能体后再发布工序。';
$lang->aiprocedure->viewHistory         = '查看历史工序';
$lang->aiprocedure->history             = '历史工序记录';
$lang->aiprocedure->noHistory           = '暂无历史记录';
$lang->aiprocedure->procedureRunCreated = '工序任务已创建，请在工作台执行步骤';
$lang->aiprocedure->procedureRunStopped = '工序已结束';
$lang->aiprocedure->stopProcedureRunFailed = '无法结束工序，请刷新后重试';
$lang->aiprocedure->start               = '开始';

$lang->aiprocedure->appLabels = array();
$lang->aiprocedure->appLabels['load-failed-title']     = '数据加载失败';
$lang->aiprocedure->appLabels['load-failed-message']   = '请稍后重试';
$lang->aiprocedure->appLabels['save-failed-title']     = '保存失败';
$lang->aiprocedure->appLabels['save-failed-message']   = '请检查内容是否正确';
$lang->aiprocedure->appLabels['save-success']          = '保存成功';
$lang->aiprocedure->appLabels['publish-success']       = '发布成功';
$lang->aiprocedure->appLabels['step-config']           = '步骤配置';
$lang->aiprocedure->appLabels['step-output']           = '步骤的输出结果';
$lang->aiprocedure->appLabels['last-step-warning']     = '至少需要保留一个步骤';
$lang->aiprocedure->appLabels['select-agent']          = '选择禅道智能体';
$lang->aiprocedure->appLabels['agent-required']        = '请选择禅道智能体';
$lang->aiprocedure->appLabels['select-input']          = '选择输入内容';
$lang->aiprocedure->appLabels['select-input-hint']     = '选择之前步骤的输出结果作为这一步骤的提词';
$lang->aiprocedure->appLabels['output-last-answer']    = '最后一次回答';
$lang->aiprocedure->appLabels['output-modified-object']= '修改的对象';
$lang->aiprocedure->appLabels['output-docs']           = '具体文档';
$lang->aiprocedure->appLabels['save']                  = '保存';
$lang->aiprocedure->appLabels['publish']               = '发布';
$lang->aiprocedure->appLabels['agent-status-draft']    = '未发布';
$lang->aiprocedure->appLabels['agent-status-deleted']  = '已删除';
$lang->aiprocedure->appLabels['publish-failed-title']  = '发布失败';
$lang->aiprocedure->appLabels['publish-need-active-agents'] = '工序中的智能体"%s"未上架或已被删除，请先上架智能体后再发布工序。';
$lang->aiprocedure->appLabels['confirm']               = '确定';
$lang->aiprocedure->appLabels['agent-process-object']  = '处理对象';
$lang->aiprocedure->appLabels['agent-action-purpose']  = '操作对象';
$lang->aiprocedure->appLabels['agent-display-position']= '显示位置';
$lang->aiprocedure->appLabels['agent-role']            = '角色';
$lang->aiprocedure->appLabels['agent-purpose']         = '提词';
$lang->aiprocedure->appLabels['agent-skills-list']     = '挂载技能';
$lang->aiprocedure->appLabels['agent-knowledge-list']  = '挂载知识库';
$lang->aiprocedure->appLabels['start']                 = '开始';
$lang->aiprocedure->appLabels['end']                   = '结束';
$lang->aiprocedure->appLabels['step']                  = '步骤';

$lang->aiprocedure->moduleList = array();
$lang->aiprocedure->moduleList['story']       = $lang->SRCommon;
$lang->aiprocedure->moduleList['requirement'] = $lang->URCommon;
$lang->aiprocedure->moduleList['epic']        = $lang->ERCommon;
$lang->aiprocedure->moduleList['task']        = '任务';
$lang->aiprocedure->moduleList['bug']         = 'Bug';
$lang->aiprocedure->moduleList['feedback']    = '反馈';
$lang->aiprocedure->moduleList['ticket']      = '工单';

$lang->aiprocedure->statusList = array();
$lang->aiprocedure->statusList['draft']  = '待发布';
$lang->aiprocedure->statusList['active'] = '已发布';

$lang->aiprocedure->featureBar['browse']['all']    = '全部';
$lang->aiprocedure->featureBar['browse']['active'] = '已发布';
$lang->aiprocedure->featureBar['browse']['draft']  = '待发布';

$lang->aiprocedure->workbench   = '工作台';
$lang->aiprocedure->myTodo      = '我的待办';
$lang->aiprocedure->objectTypes = array_merge(array('all' => '全部'), $lang->aiprocedure->moduleList);

foreach($lang->aiprocedure->moduleList as $type => $objectTypeName)
{
    $lang->aiprocedure->moduleList[$type] = $objectTypeName . '详情';
}

$lang->aiprocedure->procedureRunStatus = [];
$lang->aiprocedure->procedureRunStatus['doing'] = '待处理';
$lang->aiprocedure->procedureRunStatus['done']  = '已完成';
$lang->aiprocedure->procedureRunStatus['ended'] = '已终止';

$lang->aiprocedure->deadlineInfo    = '%s截止';
$lang->aiprocedure->alreadyRunning  = '已有工序正在执行，无法启动新的工序';
$lang->aiprocedure->unpublishNotice = '下架后，工序将不能继续使用，您确定要下架吗？';
$lang->aiprocedure->selectedTypes   = '已选{count}个类型';
$lang->aiprocedure->noTodo          = '暂无待办事项';

$lang->aiprocedure->appLang = new stdClass();

$lang->aiprocedure->appLang->objectTypes          = $lang->aiprocedure->objectTypes;
$lang->aiprocedure->appLang->fillFormInfo         = '请补充下列表单内容：';
$lang->aiprocedure->appLang->generate             = '开始步骤';
$lang->aiprocedure->appLang->regenerate           = '重新生成';
$lang->aiprocedure->appLang->returnToCurrentStep  = '返回当前步骤';
$lang->aiprocedure->appLang->historyReadonlyHint  = '正在查看历史步骤，仅可查看表单和对话记录，不能修改或重新生成。';
$lang->aiprocedure->appLang->stepFormData         = '步骤填写的表单';
$lang->aiprocedure->appLang->noStepFormData       = '此步骤没有保存的表单数据';
$lang->aiprocedure->appLang->noStepChat           = '此步骤没有对话记录';
$lang->aiprocedure->appLang->acceptAndContinue    = '下一步';
$lang->aiprocedure->appLang->complete             = '完成工序';
$lang->aiprocedure->appLang->stopProcedureRun     = '结束工序';
$lang->aiprocedure->appLang->running              = '运行中';
$lang->aiprocedure->appLang->confirmStopProcedureRun = '确定结束工序“{name}”吗？已保存的步骤数据会保留，剩余步骤将不再执行。';
$lang->aiprocedure->appLang->stopProcedureRunFailed = $lang->aiprocedure->stopProcedureRunFailed;
$lang->aiprocedure->appLang->noChatHint           = '在左侧输入信息后点击「开始步骤」开始AI对话';
$lang->aiprocedure->appLang->generating           = '正在生成...';
$lang->aiprocedure->appLang->generateFailed       = '生成失败，请重试。';
$lang->aiprocedure->appLang->stepResultPrefix     = '步骤{title}执行结果如下：';
$lang->aiprocedure->appLang->stepResultActions    = ['add' => '新增', 'update' => '更新', 'delete' => '删除'];
$lang->aiprocedure->appLang->stepResultChangeInfo = '{action}了 {count} 个 {objectName}（{objectType}），ID 为 {ids}；';
$lang->aiprocedure->appLang->stepPromptPrefix     = '用户在初始选择的对象是 {objectType} #{objectID}。';
$lang->aiprocedure->appLang->stepPurposeHint      = '如果在完成用户任务的过程中缺少相关数据可以询问用户或通过 `getZentaoObject` 工具来获取足够的信息，如果需要处理的对象包括多个，但无法一次性处理，则可以处理完一个再处理下一个。';
$lang->aiprocedure->appLang->promptExecuteFailed  = '禅道智能体调用失败，请改用禅道 API来完成“{action}”操作。';
