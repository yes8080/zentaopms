<?php
$lang->team->browse       = '团队列表';
$lang->team->edit         = '编辑';
$lang->team->create       = '创建';
$lang->team->batchCreate  = '批量创建';
$lang->team->enable       = '激活';
$lang->team->disband      = '解散';
$lang->team->view         = '团队详情';
$lang->team->delete       = '删除';
$lang->team->addMember    = '添加成员';
$lang->team->removeMember = '移除成员';

$lang->team->id            = '编号';
$lang->team->type          = '类型';
$lang->team->logo          = '团队logo';
$lang->team->name          = '团队名称';
$lang->team->manager       = '负责人';
$lang->team->parent        = '所属团队';
$lang->team->status        = '状态';
$lang->team->slogan        = '团队口号';
$lang->team->declaration   = '团队信条';
$lang->team->number        = '成员数';
$lang->team->createdBy     = '由谁创建';
$lang->team->createdDate   = '创建日期';
$lang->team->member        = '团队成员';
$lang->team->members       = '团队成员';
$lang->team->joinAB        = '加入';
$lang->team->deleted       = '已删除';
$lang->team->disbandedDate = '解散日期';

$lang->team->createAction  = '创建团队';
$lang->team->editAction    = '编辑团队';
$lang->team->enableAction  = '激活团队';
$lang->team->disbandAction = '解散团队';
$lang->team->deleteAction  = '删除团队';

$lang->team->tips = new stdclass();
$lang->team->tips->type        = '父团队中展示子团队的汇总信息，子团队中可以维护团队成员。';
$lang->team->tips->disbandTeam = '%s成员所属团队%s已解散，激活后对应成员的所属团队将清空。';

$lang->team->typeList = array();
$lang->team->typeList['parent'] = '父团队';
$lang->team->typeList['child']  = '子团队';

$lang->team->statusList = array();
$lang->team->statusList['enable']  = '正常';
$lang->team->statusList['disband'] = $lang->team->disband;

$lang->team->featureBar['browse']['all']     = '全部';
$lang->team->featureBar['browse']['enable']  = '正常';
$lang->team->featureBar['browse']['disband'] = '已解散';

$lang->team->parentDisbanded        = '原所属团队已解散或删除';
$lang->team->parentHasLinkedProject = '该团队的子团队关联了未关闭的项目、执行，无法解散。';
$lang->team->childHasLinkedProject  = '该团队关联了未关闭的项目、执行，无法解散。';
$lang->team->childHasLinkedPI       = '该团队关联了未关闭的规划，无法解散。';
$lang->team->disbandParent          = '您确定解散团队“%s”吗？解散后其子团队均会被解散。';
$lang->team->confirmDisband         = '您确定解散团队“%s”吗？';
$lang->team->linkedPI               = '该团队关联了规划，无法删除。';
$lang->team->hasConsumed            = '该团队成员已在关联项目、执行中填写工时，无法删除。';
$lang->team->hasChild               = '该团队有子团队，无法删除。';
$lang->team->confirmDelete          = '您确定删除团队“%s”吗？';
$lang->team->parentTeamDeleted      = '该团队的父团队“%s”已删除，请先恢复父团队。';
$lang->team->linkedProject          = '移除后，该成员参与的项目和执行中，所属团队清空。';

$lang->teamgroup = $lang->team;
