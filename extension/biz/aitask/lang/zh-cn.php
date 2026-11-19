<?php
$lang->aitask->name        = '名称';
$lang->aitask->object      = '相关对象';
$lang->aitask->assignedTo  = '负责人';
$lang->aitask->status      = '状态';
$lang->aitask->taskStatus  = '任务状态';
$lang->aitask->type        = '任务类型';
$lang->aitask->createdDate = '创建时间';
$lang->aitask->list        = '数字员工任务列表';
$lang->aitask->verified    = '验收';
$lang->aitask->noResults   = '暂无结果';
$lang->aitask->refined     = '继续完善';
$lang->aitask->retry       = '重试';
$lang->aitask->cancel      = '取消';
$lang->aitask->activate    = '激活';
$lang->aitask->exec        = '执行';
$lang->aitask->mine        = '与我相关';
$lang->aitask->noTask      = '暂无数字员工任务';
$lang->aitask->browse      = '浏览数字员工任务';
$lang->aitask->viewOption  = '查看数字员工任务详情';

$lang->aitask->activateSuccess = '激活成功';
$lang->aitask->cancelSuccess   = '取消成功';
$lang->aitask->retrySuccess    = '重试成功';

$lang->aitask->statusList['done']   = '待验收';
$lang->aitask->statusList['wait']   = '未开始';
$lang->aitask->statusList['closed'] = '已关闭';
$lang->aitask->statusList['doing']  = '进行中';
$lang->aitask->statusList['fail']   = '执行失败';
$lang->aitask->statusList['cancel'] = '已取消';

$lang->aitask->featureBar['browse']['all'] = '全部任务';
$lang->aitask->featureBar['browse']        = array_merge($lang->aitask->featureBar['browse'], $lang->aitask->statusList);

$lang->aitask->view          = '查看数字员工任务';
$lang->aitask->basicInfo     = '基本信息';
$lang->aitask->lifeTime      = '任务的一生';
$lang->aitask->content       = '任务内容';
$lang->aitask->result        = '任务成果';
$lang->aitask->userPrompt    = '提示词';
$lang->aitask->consumed      = '总计耗时';
$lang->aitask->tokenUsed     = 'Token 使用';
$lang->aitask->teammate      = '数字员工';
$lang->aitask->createdBy     = '由谁创建';
$lang->aitask->createdDate   = '创建时间';
$lang->aitask->verifiedBy    = '由谁验收';
$lang->aitask->verifiedDate  = '验收时间';
$lang->aitask->closedBy      = '由谁关闭';
$lang->aitask->closedDate    = '关闭时间';
$lang->aitask->cancelledBy   = '由谁取消';
$lang->aitask->cancelledDate = '取消时间';
$lang->aitask->activatedBy   = '由谁激活';
$lang->aitask->activatedDate = '激活时间';
$lang->aitask->desc          = '描述';
$lang->aitask->objectType    = '对象类型';
$lang->aitask->objectID      = '对象ID';
$lang->aitask->agents        = '智能体';
$lang->aitask->agentsData    = '表单数据';
$lang->aitask->klibs         = '知识库';
$lang->aitask->chatID        = '对话ID';
$lang->aitask->token         = '消耗Token';
$lang->aitask->notFound      = '任务不存在';
$lang->aitask->titleFormat   = '对 %s %s 进行 %s';
$lang->aitask->taskObject    = '任务对象';
$lang->aitask->objectHint    = '需要处理的对象是 ';
$lang->aitask->taskParams    = '任务参数';
$lang->aitask->noParams      = '暂无参数';
$lang->aitask->executedBy    = '由谁执行';
$lang->aitask->executedDate  = '执行日期';
$lang->aitask->finishedDate  = '完成时间';
$lang->aitask->failedReason  = '失败原因';

$lang->aitask->reviewOpinion     = '评审意见';
$lang->aitask->remarkPlaceholder = '输入内容';
$lang->aitask->viewFullContent   = '查看完整上下文';

$lang->aitask->resultList['pass']   = '通过';
$lang->aitask->resultList['refine'] = '继续完善';

$lang->aitask->action = new stdclass();
$lang->aitask->action->retried   = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->retry . '。';
$lang->aitask->action->canceled  = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->cancel . '。';
$lang->aitask->action->activated = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->activate . '。';
$lang->aitask->action->verified  = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->verified . '。';
$lang->aitask->action->refined   = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->refined . '。';
$lang->aitask->action->executing = '$date, 由 <strong>$actor</strong> ' . $lang->aitask->exec . '，$extra。';
$lang->aitask->action->assigned  = '$date, 由 <strong>$actor</strong> 转交给 <strong>$extra</strong>。';

$lang->aitask->tips = new stdclass();
$lang->aitask->tips->confirmDelete   = '确定要删除吗？';
$lang->aitask->tips->confirmCancel   = '确定要取消吗？';
$lang->aitask->tips->confirmActivate = '激活后，选中任务状态变为未开始，确定要激活吗？';
$lang->aitask->tips->confirmVerify   = '确定要验收吗？';
$lang->aitask->tips->confirmRetry    = '确定要重试吗？';
$lang->aitask->tips->consumedTips    = '数字员工处理任务累计的消耗时间之和';
$lang->aitask->tips->tokenUsedTips   = '数字员工处理任务累计消耗的 Token 之和';

/* AI 任务执行相关：*/
$lang->aitask->exceedsMaxParallel = '超过最大并发执行任务数，请稍后再试';
$lang->aitask->noWaitingTask      = '没有等待执行的任务';
$lang->aitask->taskIsNotWaiting   = '任务不是等待执行状态';
$lang->aitask->startExecuting     = '开始执行任务';
$lang->aitask->executeFailed      = '任务执行失败，请重试';
$lang->aitask->timeout            = '执行超时';
$lang->aitask->executeTimeout     = '任务执行超时，请重试';
$lang->aitask->executeSuccess     = '任务执行成功';
$lang->aitask->noAgentToExecute   = '没有可用的智能体，请检查智能体状态';
$lang->aitask->taskFailed         = '任务执行失败';
$lang->aitask->taskExecuted       = '任务执行成功';
$lang->aitask->assignTo           = '责任转交';
$lang->aitask->assignToAction     = '转交';
$lang->aitask->noPermission       = '无权限操作';
$lang->aitask->onlyPostRequest    = '只能通过 POST 请求执行';
