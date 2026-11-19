<?php
$lang->reqintake->common = '需求池';
$lang->reqintake->index  = '插件加载检查';
$lang->reqintake->ready  = '需求池插件已加载。';
$lang->reqintake->fields = array('product' => '产品', 'title' => '标题', 'description' => '描述', 'customer' => '客户', 'channel' => '渠道');
$lang->reqintake->submit = '提交需求';
$lang->reqintake->saved = '已登记反馈 #%d';
$lang->reqintake->invalid = '请检查填写内容。';
$lang->reqintake->errors = array('product' => '请选择有权访问的产品。', 'submissionConflict' => '该提交已用于其他内容。请重新打开表单。');
$lang->reqintake->ownerAccount = '负责人账号（留空清除配置）';
$lang->reqintake->saveOwner = '保存负责人';
$lang->reqintake->ownerSaved = '负责人配置已保存。';
$lang->reqintake->errors['owner'] = '该账号无权访问此产品或已删除。';
$lang->reqintake->recent = '最近 50 条反馈';
$lang->reqintake->emptyList = '暂无反馈。';
$lang->reqintake->ownerPending = '待配置负责人';
$lang->reqintake->listColumns = array('编号', '标题', '产品', '负责人', '状态');
$lang->reqintake->states = array('pending' => '待评估', 'tracking' => '跟进中', 'closed' => '已关闭');
$lang->reqintake->actionsLabel = '操作';
$lang->reqintake->actions = array('start' => '开始跟进', 'close' => '关闭', 'reopen' => '重开');
$lang->reqintake->errors['staleFeedback'] = '反馈状态已变化，请根据当前状态重新操作。';
$lang->reqintake->transitionReason = '原因（关闭和重开必填）';
$lang->reqintake->errors['transitionReason'] = '关闭或重开时请填写原因，最多 500 字。';
$lang->reqintake->history = '办理历史';
$lang->reqintake->scopes = array_combine(array('all', 'mine', 'assigned'), array('全部', '我提交的', '待我处理'));
$lang->reqintake->submitter = '提报人';
$lang->reqintake->errors['handler'] = '只有实际负责人可以办理这条反馈。';
$lang->reqintake->allProducts = '全部产品';
$lang->reqintake->linkedStories = '关联原生单据';
$lang->reqintake->storyID = '单据编号';
$lang->reqintake->linkScope = '承接范围';
$lang->reqintake->linkStory = '关联已有需求';
$lang->reqintake->errors['linkTarget'] = '请选择同一产品下该类型的有效单据。';
$lang->reqintake->errors['linkScope'] = '承接范围超长，或此需求已用不同范围关联。';
$lang->reqintake->storyUnavailable = '承接单据不可用，请复核关联。';
$lang->reqintake->storyType = '单据类型';
$lang->reqintake->storyTypes = array('story' => '研发需求', 'requirement' => '用户需求', 'epic' => '业务需求');
$lang->reqintake->storyTypes['bug'] = 'Bug';
$lang->reqintake->storyTypes['task'] = '执行任务';
$lang->reqintake->batchSelect = '选择反馈';
$lang->reqintake->batchLink = '批量关联已有需求';
$lang->reqintake->batchScope = '每条反馈的共同承接范围';
$lang->reqintake->batchSuccess = '已关联 %d 条反馈。';
$lang->reqintake->errors['batchSelection'] = '请选择 1 至 50 条反馈。';
$lang->reqintake->errors['batchProduct'] = '请选择同一产品下的反馈。';
$lang->reqintake->checkedDate = '最近后台核对：%s';
$lang->reqintake->editFeedback = '编辑反馈';
$lang->reqintake->revisionHistory = '反馈修订历史';
$lang->reqintake->followupHistory = '沟通与转交记录';
$lang->reqintake->followup = '记录沟通';
$lang->reqintake->transfer = '转交反馈';
$lang->reqintake->transferAssignee = '新负责人账号';
$lang->reqintake->followupMessage = '说明';
$lang->reqintake->transferred = '从 %s 转交给 %s';
$lang->reqintake->errors['followupMessage'] = '请输入说明，最多 500 个字符。';
$lang->reqintake->errors['sameAssignee'] = '请选择其他负责人。';
$lang->reqintake->ownerPreviewUnavailable = '暂时无法预览负责人';
$lang->reqintake->productOwnerSaveFailed = '产品已保存，需求池负责人未保存。请从产品编辑页补配有权办理的账号。';
$lang->reqintake->createTarget = '新建%s';
$lang->reqintake->batchCreate = '批量新建一张需求';
$lang->reqintake->batchCreateSummary = '用 %d 条反馈创建 1 条%s';
$lang->reqintake->taskExecution = '所属执行';
$lang->reqintake->errors['taskConversionUncertain'] = '任务创建结果待核对，请在执行中核对后关联已有任务。';
$lang->reqintake->errors['taskConversionMode'] = '请使用单任务模式。';
$lang->reqintake->fields['category'] = '类别';
$lang->reqintake->fields['priority'] = '优先级';
$lang->reqintake->fields['acceptance'] = '验收标准';
$lang->reqintake->errors['attributes'] = '请选择有效的类别和优先级，并检查验收标准的长度。';
$lang->reqintake->scopes['pendingOwner'] = '待配置负责人';
$lang->reqintake->pagination = '反馈分页';
$lang->reqintake->firstPage = '第一页';
$lang->reqintake->nextPage = '下一页';
$lang->reqintake->attachments = '附件';
$lang->reqintake->removeAttachment = '移除';
$lang->reqintake->attachmentLimit = '选择文件（最多 5 MiB）';
$lang->reqintake->uploadAttachment = '上传';
$lang->reqintake->errors['attachment'] = '请选择有效的附件，单个文件不超过 5 MiB。';
$lang->reqintake->errors['richTextSize'] = '富文本内容超过 4 MiB。';
$lang->reqintake->fields['source'] = '来源';
$lang->reqintake->fields['sourceNote'] = '来源备注';
$lang->reqintake->fields['keywords'] = '关键词';
$lang->reqintake->fields['estimate'] = '预计工时（小时）';
$lang->reqintake->errors['demandFields'] = '请选择有效来源，并填写最多两位小数的非负预计工时。';
$lang->reqintake->fields['branch'] = '分支／平台';
$lang->reqintake->fields['module'] = '模块';
$lang->reqintake->errors['productScope'] = '请选择归属当前产品的分支及模块。';
$lang->reqintake->handlingPlan = '跟进计划';
$lang->reqintake->handlingNext = '下一步';
$lang->reqintake->handlingRemaining = '剩余事项';
$lang->reqintake->handlingEdit = '更新计划';
$lang->reqintake->handlingReply = '记录对客答复';
$lang->reqintake->handlingRecipient = '答复对象';
$lang->reqintake->handlingContent = '答复内容';
$lang->reqintake->handlingHistory = '计划与答复历史';
$lang->reqintake->errors['handlingFields'] = '请填写答复对象、渠道和内容，或缩短计划说明。';
$lang->reqintake->duplicateOf = '原反馈编号';
$lang->reqintake->closeDuplicate = '按重复反馈关闭';
$lang->reqintake->duplicateReason = '结案原因';
$lang->reqintake->errors['duplicateTarget'] = '请选择同产品下的另一条反馈，并确保关联不会形成循环。';
$lang->reqintake->additionalBranches = '其他适用分支／平台';
$lang->reqintake->branchNotSelected = '不适用';
$lang->reqintake->updatedDate = '最近业务更新';
$lang->reqintake->basicInfo = '基本信息';
$lang->reqintake->sortFeedback = '反馈排序';
$lang->reqintake->sortRecent = '最新提报';
$lang->reqintake->visibleColumns = '显示列';

$lang->reqintake->workbench = '待处理反馈';

$lang->reqintake->fields['plan'] = '所属计划';
$lang->reqintake->errors['plan'] = '请选择当前产品及主选分支的计划。';

$lang->reqintake->fields['mailto'] = '抄送给';
$lang->reqintake->errors['mailto'] = '请选择有效的抄送账号。';

$lang->reqintake->fields['customerVersion'] = '客户使用版本';
$lang->reqintake->errors['customerVersion'] = '客户使用版本最多填写 100 个字符。';

$lang->reqintake->branchStageUnknown = '无该范围的阶段记录';

$lang->reqintake->linkMethods = array('created' => '新建转单', 'linked' => '关联已有单据');

$lang->reqintake->closeOutcome = '结案结果';
$lang->reqintake->closeOutcomes = array('other' => '其他', 'confirmed' => '客户确认', 'withdrawn' => '客户撤回', 'declined' => '不采纳', 'duplicate' => '重复反馈');
$lang->reqintake->closeVerification = '已核实剩余事项和约定的客户复测';
$lang->reqintake->errors['closeOutcome'] = '请选择有效的结案结果。';
$lang->reqintake->errors['closeVerification'] = '客户确认结案前，请核实剩余事项和约定的复测。';

$lang->reqintake->reselectAttachment = '修正表单后请重新选择附件。';

$lang->reqintake->reviewTarget = array('canceled' => '承接单据已取消或不再处理，请复核。', 'reopened' => '承接单据已重开，请复核。');

$lang->reqintake->anyFilter = '全部';
$lang->reqintake->filterFeedback = '筛选反馈';

$lang->reqintake->updatedFrom = '更新起始日期';
$lang->reqintake->updatedTo = '更新结束日期';

$lang->reqintake->sourceScope = '本条承接范围';
$lang->reqintake->wholeFeedback = '整条反馈';

$lang->reqintake->fields['suggestedGrade'] = '建议需求层级';
$lang->reqintake->errors['suggestedGrade'] = '请选择有效的需求层级建议。';

$lang->reqintake->fields['suggestedParent'] = '建议父需求编号';
$lang->reqintake->errors['suggestedParent'] = '请选择同一产品中可作为父需求的单据编号。';

$lang->reqintake->fields['suggestedReviewers'] = '建议评审人';
$lang->reqintake->errors['suggestedReviewers'] = '请选择该产品的有效评审人。';
