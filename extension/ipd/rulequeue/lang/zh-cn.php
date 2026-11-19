<?php
$lang->rulequeue = new stdClass();

$lang->rulequeue->triggeredBy   = '触发人';
$lang->rulequeue->triggeredDate = '触发日期';
$lang->rulequeue->executedTime  = '执行时间';
$lang->rulequeue->status        = '状态';
$lang->rulequeue->log           = '执行日志';
$lang->rulequeue->run           = '执行规则';

$lang->rulequeue->statusList['wait']    = '等待执行';
$lang->rulequeue->statusList['doing']   = '执行中';
$lang->rulequeue->statusList['success'] = '执行成功';
$lang->rulequeue->statusList['fail']    = '执行失败';

$lang->rulequeue->noUpdateList  = '未找到可更新的对象。';
$lang->rulequeue->noDeleteList  = '未找到可删除的对象。';
$lang->rulequeue->affectObjects = '影响的对象: %s';
$lang->rulequeue->maxLimit      = '单条规则最多更新200个对象，当前命中%s个对象，规则将不会执行。';

$lang->rulequeue->error = new stdClass();
$lang->rulequeue->error->overParentBegin          = '执行的起止时间不能超过项目的起止时间。';
$lang->rulequeue->error->noPriv                   = '触发用户没有权限执行。';
$lang->rulequeue->error->productNotInProject      = '执行关联的产品不在项目中。';
$lang->rulequeue->error->projectCannotBeChanged   = '已关闭的项目不能修改。';
$lang->rulequeue->error->productCannotBeChanged   = '已关闭的产品不能修改。';
$lang->rulequeue->error->executionCannotBeChanged = '已关闭的执行不能修改。';
$lang->rulequeue->error->apiUnsupported           = '对象类型「%s」尚未支持通过 API V2 写入，无法执行。';
$lang->rulequeue->error->apiNoBaseUrl             = '无法解析站点地址，规则引擎无法调用 API V2（请检查访问域名或邮件域名配置）。';
$lang->rulequeue->error->apiInvalidResponse       = 'API V2 返回了无效响应。';
$lang->rulequeue->error->apiFail                  = 'API V2 调用失败。';
$lang->rulequeue->error->apiNoId                  = 'API V2 创建成功但未返回对象 ID。';
$lang->rulequeue->error->runAsInvalid             = '执行身份「%s」无效或不存在。';

$lang->rulequeue->alert = new stdClass();
$lang->rulequeue->alert->noticeTitle    = '预警通知';
$lang->rulequeue->alert->defaultContent = "【%s】您有%s个%s触发“%s”规则，请及时关注!";
$lang->rulequeue->alert->objectItem     = '<a href="%s">[#%s::%s]</a>';
$lang->rulequeue->alert->mailSubject    = '预警汇总通知';
$lang->rulequeue->alert->mailItem       = '规则「%s」命中 %s 条';
$lang->rulequeue->alert->noticeItem     = '预警规则「%s」命中 %s 条对象。';
$lang->rulequeue->alert->idAB           = 'ID';
$lang->rulequeue->alert->beginDate      = '开始日期';
$lang->rulequeue->alert->deadline       = '截止日期';
$lang->rulequeue->alert->svRate         = '进度偏差率';

$lang->rulequeue->alert->objectTitle['project']   = '项目标题';
$lang->rulequeue->alert->objectTitle['execution'] = '执行标题';
$lang->rulequeue->alert->objectTitle['task']      = '任务标题';
$lang->rulequeue->alert->objectTitle['risk']      = '风险标题';
$lang->rulequeue->alert->objectTitle['issue']     = '问题标题';
