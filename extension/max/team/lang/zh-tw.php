<?php
$lang->team->browse       = '團隊列表';
$lang->team->edit         = '編輯';
$lang->team->create       = '創建';
$lang->team->batchCreate  = '批量創建';
$lang->team->enable       = '激活';
$lang->team->disband      = '解散';
$lang->team->view         = '團隊詳情';
$lang->team->delete       = '刪除';
$lang->team->addMember    = '添加成員';
$lang->team->removeMember = '移除成員';

$lang->team->id            = '編號';
$lang->team->type          = '類型';
$lang->team->logo          = '團隊logo';
$lang->team->name          = '團隊名稱';
$lang->team->manager       = '負責人';
$lang->team->parent        = '所屬團隊';
$lang->team->status        = '狀態';
$lang->team->slogan        = '團隊口號';
$lang->team->declaration   = '團隊信條';
$lang->team->number        = '成員數';
$lang->team->createdBy     = '由誰創建';
$lang->team->createdDate   = '創建日期';
$lang->team->member        = '團隊成員';
$lang->team->members       = '團隊成員';
$lang->team->joinAB        = '加入';
$lang->team->deleted       = '已刪除';
$lang->team->disbandedDate = '解散日期';

$lang->team->createAction  = '創建團隊';
$lang->team->editAction    = '編輯團隊';
$lang->team->enableAction  = '激活團隊';
$lang->team->disbandAction = '解散團隊';
$lang->team->deleteAction  = '刪除團隊';

$lang->team->tips = new stdclass();
$lang->team->tips->type        = '父團隊中展示子團隊的彙總信息，子團隊中可以維護團隊成員。';
$lang->team->tips->disbandTeam = '%s成員所屬團隊%s已解散，激活後對應成員的所屬團隊將清空。';

$lang->team->typeList = array();
$lang->team->typeList['parent'] = '父團隊';
$lang->team->typeList['child']  = '子團隊';

$lang->team->statusList = array();
$lang->team->statusList['enable']  = '正常';
$lang->team->statusList['disband'] = $lang->team->disband;

$lang->team->featureBar['browse']['all']     = '全部';
$lang->team->featureBar['browse']['enable']  = '正常';
$lang->team->featureBar['browse']['disband'] = '已解散';

$lang->team->parentDisbanded        = '原所屬團隊已解散或刪除';
$lang->team->parentHasLinkedProject = '該團隊的子團隊關聯了未關閉的項目、執行，無法解散。';
$lang->team->childHasLinkedProject  = '該團隊關聯了未關閉的項目、執行，無法解散。';
$lang->team->childHasLinkedPI       = '該團隊關聯了未關閉的規劃，無法解散。';
$lang->team->disbandParent          = '您確定解散團隊“%s”嗎？解散後其子團隊均會被解散。';
$lang->team->confirmDisband         = '您確定解散團隊“%s”嗎？';
$lang->team->linkedPI               = '該團隊關聯了規劃，無法刪除。';
$lang->team->hasConsumed            = '該團隊成員已在關聯項目、執行中填寫工時，無法刪除。';
$lang->team->hasChild               = '該團隊有子團隊，無法刪除。';
$lang->team->confirmDelete          = '您確定刪除團隊“%s”嗎？';
$lang->team->parentTeamDeleted      = '該團隊的父團隊“%s”已刪除，請先恢復父團隊。';
$lang->team->linkedProject          = '移除後，該成員參與的項目和執行中，所屬團隊清空。';

$lang->teamgroup = $lang->team;
