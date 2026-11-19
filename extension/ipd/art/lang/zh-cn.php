<?php
$lang->art->browse   = '项目组列表';
$lang->art->create   = '创建项目组';
$lang->art->createPI = '创建规划';
$lang->art->view     = '项目组详情';
$lang->art->close    = '解散项目组';
$lang->art->activate = '激活项目组';
$lang->art->edit     = '编辑项目组';
$lang->art->delete   = '删除项目组';

$lang->art->name        = '项目组名称';
$lang->art->product     = '关联产品';
$lang->art->RTE         = '负责人';
$lang->art->manager     = '业务负责人';
$lang->art->PO          = '产品经理';
$lang->art->architect   = '系统架构师';
$lang->art->status      = '状态';
$lang->art->createdBy   = '由谁创建';
$lang->art->createdDate = '创建时间';
$lang->art->actions     = '操作';
$lang->art->team        = '团队';
$lang->art->teamInfo    = '团队信息';
$lang->art->piInfo      = '规划信息';
$lang->art->desc        = '描述';
$lang->art->acl         = '访问控制';
$lang->art->whitelist   = '白名单';

$lang->art->basicInfo = '基本信息';
$lang->art->deleted   = '已删除';

$lang->art->statusList['normal'] = '正常';
$lang->art->statusList['closed'] = '解散';

$lang->art->featureBar['browse']['all']    = '全部';
$lang->art->featureBar['browse']['normal'] = $lang->art->statusList['normal'];
$lang->art->featureBar['browse']['closed'] = '已解散';

$lang->art->notice = new stdclass();
$lang->art->notice->noPrivilege         = '您没有权限访问该项目组';
$lang->art->notice->confirmDelete       = '您确定要删除该项目组吗？';
$lang->art->notice->hasPI               = '项目组下存在规划，不允许删除。';
$lang->art->notice->cannotRemoveTeam    = '项目组中存在未关闭的规划关联该团队，不允许移除。';
$lang->art->notice->cannotRemoveProduct = '项目组中存在未关闭的规划关联该产品，请先将规划与产品解除关联。';
$lang->art->notice->cannotCloseART      = '该项目组存在未关闭的规划，请先关闭规划。';
$lang->art->notice->confirmDisband      = '您确定解散项目组“ %s” 吗？';

$lang->art->aclList['open']    = '公开（有项目组视图权限即可访问）';
$lang->art->aclList['private'] = '私有（只有创建人、负责人、业务负责人、产品经理、系统架构师、团队成员和白名单可访问）';

$lang->art->aclAbbrList['open']    = '公开';
$lang->art->aclAbbrList['private'] = '私有';
