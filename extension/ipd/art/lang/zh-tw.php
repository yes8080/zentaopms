<?php
$lang->art->browse   = '項目組列表';
$lang->art->create   = '創建項目組';
$lang->art->createPI = '創建規劃';
$lang->art->view     = '項目組詳情';
$lang->art->close    = '解散項目組';
$lang->art->activate = '激活項目組';
$lang->art->edit     = '編輯項目組';
$lang->art->delete   = '刪除項目組';

$lang->art->name        = '項目組名稱';
$lang->art->product     = '關聯產品';
$lang->art->RTE         = '負責人';
$lang->art->manager     = '業務負責人';
$lang->art->PO          = '產品經理';
$lang->art->architect   = '系統架構師';
$lang->art->status      = '狀態';
$lang->art->createdBy   = '由誰創建';
$lang->art->createdDate = '創建時間';
$lang->art->actions     = '操作';
$lang->art->team        = '團隊';
$lang->art->teamInfo    = '團隊信息';
$lang->art->piInfo      = '規劃信息';
$lang->art->desc        = '描述';
$lang->art->acl         = '訪問控制';
$lang->art->whitelist   = '白名單';

$lang->art->basicInfo = '基本信息';
$lang->art->deleted   = '已刪除';

$lang->art->statusList['normal'] = '正常';
$lang->art->statusList['closed'] = '解散';

$lang->art->featureBar['browse']['all']    = '全部';
$lang->art->featureBar['browse']['normal'] = $lang->art->statusList['normal'];
$lang->art->featureBar['browse']['closed'] = '已解散';

$lang->art->notice = new stdclass();
$lang->art->notice->noPrivilege         = '您沒有權限訪問該項目組';
$lang->art->notice->confirmDelete       = '您確定要刪除該項目組嗎？';
$lang->art->notice->hasPI               = '項目組下存在規劃，不允許刪除。';
$lang->art->notice->cannotRemoveTeam    = '項目組中存在未關閉的規劃關聯該團隊，不允許移除。';
$lang->art->notice->cannotRemoveProduct = '項目組中存在未關閉的規劃關聯該產品，請先將規劃與產品解除關聯。';
$lang->art->notice->cannotCloseART      = '該項目組存在未關閉的規劃，請先關閉規劃。';
$lang->art->notice->confirmDisband      = '您確定解散項目組“ %s” 嗎？';

$lang->art->aclList['open']    = '公開（有項目組視圖權限即可訪問）';
$lang->art->aclList['private'] = '私有（只有創建人、負責人、業務負責人、產品經理、系統架構師、團隊成員和白名單可訪問）';

$lang->art->aclAbbrList['open']    = '公開';
$lang->art->aclAbbrList['private'] = '私有';
