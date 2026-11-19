<?php
$lang->rule->name             = '规则名称';
$lang->rule->type             = '适配类型';
$lang->rule->workflowGroup    = '适配模板';
$lang->rule->method           = '执行方式';
$lang->rule->status           = '状态';
$lang->rule->createdBy        = '创建人';
$lang->rule->createdDate      = '创建日期';
$lang->rule->lastEditedBy     = '最后修改';
$lang->rule->lastEditedDate   = '最后修改日期';
$lang->rule->lastRunTime      = '最后运行时间';
$lang->rule->lastRunResult    = '最后运行结果';
$lang->rule->products         = '关联产品';
$lang->rule->currentProduct   = '当前产品';
$lang->rule->currentProject   = '当前项目';
$lang->rule->currentExecution = '当前执行';
$lang->rule->currentStory     = '当前需求';
$lang->rule->currentTask      = '当前任务';
$lang->rule->currentUser      = '规则触发人';
$lang->rule->field            = '字段';
$lang->rule->when             = '当';
$lang->rule->value            = '值';
$lang->rule->objectType       = '对象';
$lang->rule->actionName       = '动作';
$lang->rule->after            = '之后';
$lang->rule->requiredFields   = '必填字段';
$lang->rule->otherFields      = '其他字段';
$lang->rule->copyField        = '引用字段';
$lang->rule->notifyUsers      = '通知人';
$lang->rule->notifyMethod     = '通知方式';
$lang->rule->relation         = '对象关系匹配';
$lang->rule->selectObject     = '选择对象';
$lang->rule->editField        = '属性修改';
$lang->rule->modify           = '修改为';
$lang->rule->begin            = '开始日期';
$lang->rule->end              = '结束日期';
$lang->rule->deptManager      = '部门负责人';

global $config;
$lang->rule->objectList['product'] = $lang->productCommon;
if($config->enableER) $lang->rule->objectList['epic']        = $lang->ERCommon;
if($config->URAndSR)  $lang->rule->objectList['requirement'] = $lang->URCommon;
$lang->rule->objectList['story']     = $lang->SRCommon;
$lang->rule->objectList['project']   = $lang->projectCommon;
$lang->rule->objectList['execution'] = '执行';
$lang->rule->objectList['task']      = '任务';
$lang->rule->objectList['bug']       = 'Bug';
$lang->rule->objectList['testcase']  = '用例';

$lang->rule->actionList['create'] = '创建对象';
$lang->rule->actionList['edit']   = '编辑对象';
//$lang->rule->actionList['delete'] = '删除对象';
$lang->rule->actionList['notify'] = '通知';

$lang->rule->notifyMethodList['fail']   = '每次执行失败时通知';
$lang->rule->notifyMethodList['always'] = '每次执行时通知';
$lang->rule->notifyMethodList['closed'] = '不通知';

$lang->rule->typeList['global'] = '全局级';
$lang->rule->typeList['group']  = '流程模板级';

$lang->rule->typeNoticeList['global'] = '（系统全局生效）';
$lang->rule->typeNoticeList['group']  = '（仅在流程模板内生效）';

$lang->rule->methodList['sync']  = '同步';
$lang->rule->methodList['async'] = '异步';

$lang->rule->statusList['normal']  = '启用';
$lang->rule->statusList['disable'] = '停用';

$lang->rule->resultList['success'] = '成功';
$lang->rule->resultList['fail']    = '失败';

$lang->rule->browse  = '规则列表';
$lang->rule->create  = '创建规则';
$lang->rule->design  = '设计';
$lang->rule->enable  = '启用';
$lang->rule->disable = '停用';
$lang->rule->log     = '执行日志';
$lang->rule->view    = '规则详情';
$lang->rule->notify  = '通知设置';
$lang->rule->copy    = '复制';
$lang->rule->edit    = '编辑';
$lang->rule->delete  = '删除';

$lang->rule->basicInfo = '基本信息';

$lang->rule->featureBar['browse']['all']     = '全部';
$lang->rule->featureBar['browse']['normal']  = '启用';
$lang->rule->featureBar['browse']['disable'] = '停用';

$lang->rule->titleList['when']      = '前置动作';
$lang->rule->titleList['condition'] = '触发条件';
$lang->rule->titleList['action']    = '执行动作';

$lang->rule->branchList['condition'] = '触发条件';
$lang->rule->branchList['action']    = '执行动作';

$lang->rule->relationList['include']         = '包含';
$lang->rule->relationList['belong']          = '从属于';
$lang->rule->relationList['parent']          = '父';
$lang->rule->relationList['child']           = '子';
$lang->rule->relationList['related']         = '关联';
$lang->rule->relationList['transferredto']   = '转化为';
$lang->rule->relationList['transferredfrom'] = '转化于';
$lang->rule->relationList['generated']       = '产生为';
$lang->rule->relationList['derivedfrom']     = '产生于';

$lang->rule->error = new stdClass();
$lang->rule->error->emptyObjectType       = '对象不能为空';
$lang->rule->error->emptyModuleOrRelation = '对象关系匹配与对象不能为空';
$lang->rule->error->emptyAction           = '动作不能为空';
$lang->rule->error->noPreActions          = '请设置前置动作';
$lang->rule->error->noCompleteRule        = '必须要有至少一条完整规则。';
$lang->rule->error->requiredFieldEmpty    = '必填项不能为空！';
$lang->rule->error->invalidEstimate       = '预计工时格式不正确！';
$lang->rule->error->notConsistency        = '检测到前置动作与触发条件、执行动作对象不一致，请重新设置触发条件和执行动作后保存。';
$lang->rule->error->errorBegin            = "执行的开始时间必须在项目起止时间内，项目起止时间为%s至%s";
$lang->rule->error->errorEnd              = "执行的结束时间必须在项目起止时间内，项目起止时间为%s至%s";
$lang->rule->error->beginGtEnd            = "计划开始时间不能大于计划结束时间";

$lang->rule->notifyList = new stdClass();
$lang->rule->notifyList->subject = '通知标题';
$lang->rule->notifyList->content = '通知内容';
$lang->rule->notifyList->toList  = '通知用户';
$lang->rule->notifyList->route   = '通知渠道';

$lang->rule->notice = new stdClass();
$lang->rule->notice->noCondition     = '无条件触发';
$lang->rule->notice->disable         = '您确定要停用该规则吗？';
$lang->rule->notice->enable          = '您确定要启用该规则吗？';
$lang->rule->notice->noRules         = '您还没有配置规则，请先进行配置。';
$lang->rule->notice->delete          = '您确定要删除该规则吗？删除规则后，规则的执行日志也会删除。该操作是不可逆的，无法恢复！';
$lang->rule->notice->needValue       = '值不能为空';
$lang->rule->notice->requiredFields  = '不能去掉必填字段！';
$lang->rule->notice->multiConditions = '多个触发条件从左向右匹配，只执行第一个匹配到的条件';
$lang->rule->notice->delCondition    = '您确定要删除该条件吗？删除后该条件下的执行动作也会删除。';
$lang->rule->notice->apiUnsupported  = '动作对象「%s」尚未支持 API V2，无法启用该规则。';
$lang->rule->notice->runAsInvalid    = '执行身份「%s」无效或不存在。';

$lang->rule->appendActionGroup = array();
$lang->rule->appendActionGroup['testcase'][] = array('text' => '执行用例', 'value' => 'run');

$lang->rule->action = new stdclass();
$lang->rule->action->executed = array('main' => '$date, 由 <strong>$actor</strong> 触发执行，执行结果为 <strong>$extra</strong>。', 'extra' => 'resultList');
$lang->rule->action->designed = array('main' => '$date, 由 <strong>$actor</strong> 设计规则。');
$lang->rule->action->enabled  = array('main' => '$date, 由 <strong>$actor</strong> 启用。');
$lang->rule->action->disabled = array('main' => '$date, 由 <strong>$actor</strong> 停用。');
