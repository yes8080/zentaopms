<?php
$lang->pi->browse                 = '规划列表';
$lang->pi->create                 = '创建规划';
$lang->pi->edit                   = '编辑规划';
$lang->pi->activate               = '激活规划';
$lang->pi->close                  = '关闭规划';
$lang->pi->delete                 = '删除规划';
$lang->pi->linkCard               = '设置卡片依赖关系';
$lang->pi->unlinkCard             = '解除卡片依赖关系';
$lang->pi->createStory            = "提{$lang->SRCommon}";
$lang->pi->createRequirement      = "提{$lang->URCommon}";
$lang->pi->createEpic             = "提{$lang->ERCommon}";
$lang->pi->linkStory              = "关联需求";
$lang->pi->unlinkStory            = "移除需求";
$lang->pi->createMilestone        = '创建里程碑目标';
$lang->pi->editMilestone          = '编辑里程碑目标';
$lang->pi->deleteMilestone        = '删除里程碑目标';
$lang->pi->createTeamCard         = '创建团队目标';
$lang->pi->createMilestoneAction  = '创建目标卡片';
$lang->pi->editMilestoneAction    = '编辑目标卡片';
$lang->pi->deleteMilestoneAction  = '删除目标卡片';
$lang->pi->createLane             = '创建泳道';
$lang->pi->editLane               = '编辑泳道';
$lang->pi->deleteLane             = '删除泳道';
$lang->pi->createCard             = '创建卡片';
$lang->pi->editCard               = '编辑卡片';
$lang->pi->finishCard             = '完成卡片';
$lang->pi->viewCard               = '卡片详情';
$lang->pi->activateCard           = '激活卡片';
$lang->pi->deleteCard             = '删除卡片';
$lang->pi->setCapacity            = '设置产能';
$lang->pi->fullscreen             = '全屏';
$lang->pi->setKanban              = '设置看板';
$lang->pi->setColumn              = '设置看板列';
$lang->pi->setLane                = '设置看板泳道';
$lang->pi->moveCard               = '移动卡片';
$lang->pi->viewAllART             = '所有项目组';
$lang->pi->createART              = '创建项目组';

$lang->pi->name              = '规划名称';
$lang->pi->teamKanban        = '规划板';
$lang->pi->planKanban        = '目标板';
$lang->pi->ART               = '所属项目组';
$lang->pi->product           = '关联产品';
$lang->pi->RTE               = '负责人';
$lang->pi->PO                = '产品经理';
$lang->pi->architect         = '系统架构师';
$lang->pi->status            = '状态';
$lang->pi->team              = '团队';
$lang->pi->desc              = '描述';
$lang->pi->acl               = '访问控制';
$lang->pi->plan              = '规划';
$lang->pi->execution         = '周期名称';
$lang->pi->workhour          = '工作量';
$lang->pi->capacity          = '产能';
$lang->pi->workload          = '工作负荷';
$lang->pi->planDate          = '计划起止日期';
$lang->pi->begin             = '计划开始日期';
$lang->pi->end               = '计划结束日期';
$lang->pi->whitelist         = '白名单';
$lang->pi->width             = '宽度';
$lang->pi->createdBy         = '由谁创建';
$lang->pi->createdDate       = '创建日期';
$lang->pi->closedBy          = '由谁关闭';
$lang->pi->closedDate        = '关闭日期';
$lang->pi->closedReason      = '关闭原因';
$lang->pi->selectTeam        = '请选择团队';
$lang->pi->selectProduct     = '请选择产品';
$lang->pi->toLane            = '目标泳道';
$lang->pi->createObjective   = '创建目标';
$lang->pi->editObjective     = '编辑目标';
$lang->pi->deleteObjective   = '删除目标';
$lang->pi->deleted           = '已删除';
$lang->pi->features          = '特性';
$lang->pi->newProject        = "创建{$lang->projectCommon}";
$lang->pi->selectRequirement = "按{$lang->URCommon}筛选";
$lang->pi->storyTitle        = "需求标题";

$lang->pi->abbr = new stdclass();
$lang->pi->abbr->execution = $lang->executionCommon;
$lang->pi->abbr->unCreated = '未创建';

$lang->pi->storyAppendStatusList['launched']  = '已立项';
$lang->pi->storyAppendStatusList['completed'] = '已结项';
$lang->pi->storyAppendStatusList['canceled']  = '已取消';

$lang->pi->error = new stdclass();
$lang->pi->error->duplicate            = "存在重复的周期名称，请修改任意一条";
$lang->pi->error->projectNameEmpty     = "{$lang->projectCommon}名称不能为空。";
$lang->pi->error->executionNameEmpty   = "周期名称不能为空。";
$lang->pi->error->projectNameDuplicate = '已存在相同名称的项目，请修改。';
$lang->pi->error->maxColWidth          = '最大列宽必须大于最小列宽，请修改。';

$lang->pi->notice = new stdclass();
$lang->pi->notice->confirmDelete            = '您确定删除规划"%s"吗？';
$lang->pi->notice->linkedExecution          = "规划下有{$lang->executionCommon}，不允许删除。";
$lang->pi->notice->confirmUnlinkStory       = "确认移除该需求吗？";
$lang->pi->notice->confirmDeleteLane        = '您确认删除该泳道吗？';
$lang->pi->notice->confirmDeleteCard        = '您确认删除该卡片吗？';
$lang->pi->notice->confirmRemoveTeam        = "移除团队时会将{$lang->projectCommon}中创建的{$lang->executionCommon}同步删除。";
$lang->pi->notice->confirmRemoveExecution   = "移除时间周期时会将{$lang->projectCommon}中创建的{$lang->executionCommon}同步删除。";
$lang->pi->notice->confirmMoveStory         = "移动该{$lang->SRCommon}后，该{$lang->executionCommon}中{$lang->SRCommon}关联的用例将被移除，该{$lang->SRCommon}关联的任务将被取消，请确认。";
$lang->pi->notice->laneNotEmpty             = '所属泳道不能为空。';
$lang->pi->notice->cannotRemoveProduct      = '规划中已关联该产品的需求，不允许移除。';
$lang->pi->notice->cannotRemoveTeam         = '规划中该团队已在团队看板、规划板关联卡片，请先移除卡片';
$lang->pi->notice->cannotRemoveExecution    = "规划中该规划{$lang->executionCommon}已在团队看板、规划板关联卡片，请先移除卡片";
$lang->pi->notice->choseTeam                = '选择要设置的团队';
$lang->pi->notice->choseProject             = "选择已有{$lang->projectCommon}";
$lang->pi->notice->createExecution          = "创建{$lang->executionCommon}";
$lang->pi->notice->updateProjectDate        = "{$lang->projectCommon}的开始时间和结束时间变为：%s ~ %s 。";
$lang->pi->notice->updateProjectProducts    = "{$lang->projectCommon}自动关联产品：%s 。";
$lang->pi->notice->allComplete              = '所有团队均已完成设置。';
$lang->pi->notice->endNotLessThanBegin      = '结束时间不能小于开始时间。';
$lang->pi->notice->progressError            = '卡片进度只能为0到100的数字。';

$lang->pi->statusList = array();
$lang->pi->statusList['normal'] = '正常';
$lang->pi->statusList['closed'] = '已关闭';

$lang->pi->aclList = array();
$lang->pi->aclList['extends'] = '继承项目组访问权限（能访问所属项目组，即可访问）';
$lang->pi->aclList['private'] = '私有（只有项目组的相关负责人和规划的创建人、团队成员可以访问）';

$lang->pi->featureBar['browse']['all']    = '全部';
$lang->pi->featureBar['browse']['normal'] = $lang->pi->statusList['normal'];
$lang->pi->featureBar['browse']['closed'] = $lang->pi->statusList['closed'];

$lang->pi->closedReasonList = array();
$lang->pi->closedReasonList['complete'] = '已完成';
$lang->pi->closedReasonList['cancel']   = '已取消';

$lang->pi->appendColumnList = array();
$lang->pi->appendColumnList['risk']      = '风险';
$lang->pi->appendColumnList['objective'] = '团队目标';

$lang->pi->childColumnList['promise']['yes'] = '已承诺目标';
$lang->pi->childColumnList['promise']['no']  = '未承诺目标';

$lang->pi->lane = new stdclass();
$lang->pi->lane->common = '泳道';
$lang->pi->lane->name   = '泳道名称';
$lang->pi->lane->color  = '泳道颜色';

$lang->pi->cardStatusList['wait']   = '未开始';
$lang->pi->cardStatusList['doing']  = '进行中';
$lang->pi->cardStatusList['done']   = '已完成';
$lang->pi->cardStatusList['closed'] = '已关闭';

$lang->pi->milestone = new stdclass();
$lang->pi->milestone->common     = '项目组里程碑目标';
$lang->pi->milestone->name       = '目标名称';
$lang->pi->milestone->lane       = '目标泳道';
$lang->pi->milestone->end        = '完成时间';
$lang->pi->milestone->assignedTo = '负责人';
$lang->pi->milestone->status     = '状态';

$lang->pi->milestone->confirmDelete = '确认删除该目标吗？';

$lang->pi->milestone->statusList['normal'] = '正常';
$lang->pi->milestone->statusList['done']   = '完成';
$lang->pi->milestone->statusList['delay']  = '延期';

$lang->pi->columnWidth = array();
$lang->pi->columnWidth['0'] = '固定列宽';
$lang->pi->columnWidth['1'] = '自适应列宽';

$lang->pi->laneHeight = array();
$lang->pi->laneHeight['0'] = '固定行高';
$lang->pi->laneHeight['1'] = '自适应行高';

$lang->picard = new stdclass();
$lang->picard->statusList = $lang->pi->cardStatusList;
