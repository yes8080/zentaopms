<?php
$lang->pi->browse                 = '規劃列表';
$lang->pi->create                 = '創建規劃';
$lang->pi->edit                   = '編輯規劃';
$lang->pi->activate               = '激活規劃';
$lang->pi->close                  = '關閉規劃';
$lang->pi->delete                 = '刪除規劃';
$lang->pi->linkCard               = '設置卡片依賴關係';
$lang->pi->unlinkCard             = '解除卡片依賴關係';
$lang->pi->createStory            = "提{$lang->SRCommon}";
$lang->pi->createRequirement      = "提{$lang->URCommon}";
$lang->pi->createEpic             = "提{$lang->ERCommon}";
$lang->pi->linkStory              = "關聯需求";
$lang->pi->unlinkStory            = "移除需求";
$lang->pi->createMilestone        = '創建里程碑目標';
$lang->pi->editMilestone          = '編輯里程碑目標';
$lang->pi->deleteMilestone        = '刪除里程碑目標';
$lang->pi->createTeamCard         = '創建團隊目標';
$lang->pi->createMilestoneAction  = '創建目標卡片';
$lang->pi->editMilestoneAction    = '編輯目標卡片';
$lang->pi->deleteMilestoneAction  = '刪除目標卡片';
$lang->pi->createLane             = '創建泳道';
$lang->pi->editLane               = '編輯泳道';
$lang->pi->deleteLane             = '刪除泳道';
$lang->pi->createCard             = '創建卡片';
$lang->pi->editCard               = '編輯卡片';
$lang->pi->finishCard             = '完成卡片';
$lang->pi->viewCard               = '卡片詳情';
$lang->pi->activateCard           = '激活卡片';
$lang->pi->deleteCard             = '刪除卡片';
$lang->pi->setCapacity            = '設置產能';
$lang->pi->fullscreen             = '全屏';
$lang->pi->setKanban              = '設置看板';
$lang->pi->setColumn              = '設置看板列';
$lang->pi->setLane                = '設置看板泳道';
$lang->pi->moveCard               = '移動卡片';
$lang->pi->viewAllART             = '所有項目組';
$lang->pi->createART              = '創建項目組';

$lang->pi->name              = '規劃名稱';
$lang->pi->teamKanban        = '規劃板';
$lang->pi->planKanban        = '目標板';
$lang->pi->ART               = '所屬項目組';
$lang->pi->product           = '關聯產品';
$lang->pi->RTE               = '負責人';
$lang->pi->PO                = '產品經理';
$lang->pi->architect         = '系統架構師';
$lang->pi->status            = '狀態';
$lang->pi->team              = '團隊';
$lang->pi->desc              = '描述';
$lang->pi->acl               = '訪問控制';
$lang->pi->plan              = '規劃';
$lang->pi->execution         = '周期名稱';
$lang->pi->workhour          = '工作量';
$lang->pi->capacity          = '產能';
$lang->pi->workload          = '工作負荷';
$lang->pi->planDate          = '計划起止日期';
$lang->pi->begin             = '計劃開始日期';
$lang->pi->end               = '計劃結束日期';
$lang->pi->whitelist         = '白名單';
$lang->pi->width             = '寬度';
$lang->pi->createdBy         = '由誰創建';
$lang->pi->createdDate       = '創建日期';
$lang->pi->closedBy          = '由誰關閉';
$lang->pi->closedDate        = '關閉日期';
$lang->pi->closedReason      = '關閉原因';
$lang->pi->selectTeam        = '請選擇團隊';
$lang->pi->selectProduct     = '請選擇產品';
$lang->pi->toLane            = '目標泳道';
$lang->pi->createObjective   = '創建目標';
$lang->pi->editObjective     = '編輯目標';
$lang->pi->deleteObjective   = '刪除目標';
$lang->pi->deleted           = '已刪除';
$lang->pi->features          = '特性';
$lang->pi->newProject        = "創建{$lang->projectCommon}";
$lang->pi->selectRequirement = "按{$lang->URCommon}篩選";
$lang->pi->storyTitle        = "需求標題";

$lang->pi->abbr = new stdclass();
$lang->pi->abbr->execution = $lang->executionCommon;
$lang->pi->abbr->unCreated = '未創建';

$lang->pi->storyAppendStatusList['launched']  = '已立項';
$lang->pi->storyAppendStatusList['completed'] = '已結項';
$lang->pi->storyAppendStatusList['canceled']  = '已取消';

$lang->pi->error = new stdclass();
$lang->pi->error->duplicate            = "存在重複的周期名稱，請修改任意一條";
$lang->pi->error->projectNameEmpty     = "{$lang->projectCommon}名稱不能為空。";
$lang->pi->error->executionNameEmpty   = "周期名稱不能為空。";
$lang->pi->error->projectNameDuplicate = '已存在相同名稱的項目，請修改。';
$lang->pi->error->maxColWidth          = '最大列寬必須大於最小列寬，請修改。';

$lang->pi->notice = new stdclass();
$lang->pi->notice->confirmDelete            = '您確定刪除規劃"%s"嗎？';
$lang->pi->notice->linkedExecution          = "規划下有{$lang->executionCommon}，不允許刪除。";
$lang->pi->notice->confirmUnlinkStory       = "確認移除該需求嗎？";
$lang->pi->notice->confirmDeleteLane        = '您確認刪除該泳道嗎？';
$lang->pi->notice->confirmDeleteCard        = '您確認刪除該卡片嗎？';
$lang->pi->notice->confirmRemoveTeam        = "移除團隊時會將{$lang->projectCommon}中創建的{$lang->executionCommon}同步刪除。";
$lang->pi->notice->confirmRemoveExecution   = "移除時間周期時會將{$lang->projectCommon}中創建的{$lang->executionCommon}同步刪除。";
$lang->pi->notice->confirmMoveStory         = "移動該{$lang->SRCommon}後，該{$lang->executionCommon}中{$lang->SRCommon}關聯的用例將被移除，該{$lang->SRCommon}關聯的任務將被取消，請確認。";
$lang->pi->notice->laneNotEmpty             = '所屬泳道不能為空。';
$lang->pi->notice->cannotRemoveProduct      = '規劃中已關聯該產品的需求，不允許移除。';
$lang->pi->notice->cannotRemoveTeam         = '規劃中該團隊已在團隊看板、規劃板關聯卡片，請先移除卡片';
$lang->pi->notice->cannotRemoveExecution    = "規劃中該規劃{$lang->executionCommon}已在團隊看板、規劃板關聯卡片，請先移除卡片";
$lang->pi->notice->choseTeam                = '選擇要設置的團隊';
$lang->pi->notice->choseProject             = "選擇已有{$lang->projectCommon}";
$lang->pi->notice->createExecution          = "創建{$lang->executionCommon}";
$lang->pi->notice->updateProjectDate        = "{$lang->projectCommon}的開始時間和結束時間變為：%s ~ %s 。";
$lang->pi->notice->updateProjectProducts    = "{$lang->projectCommon}自動關聯產品：%s 。";
$lang->pi->notice->allComplete              = '所有團隊均已完成設置。';
$lang->pi->notice->endNotLessThanBegin      = '結束時間不能小於開始時間。';
$lang->pi->notice->progressError            = '卡片進度只能為0到100的數字。';

$lang->pi->statusList = array();
$lang->pi->statusList['normal'] = '正常';
$lang->pi->statusList['closed'] = '已關閉';

$lang->pi->aclList = array();
$lang->pi->aclList['extends'] = '繼承項目組訪問權限（能訪問所屬項目組，即可訪問）';
$lang->pi->aclList['private'] = '私有（只有項目組的相關負責人和規劃的創建人、團隊成員可以訪問）';

$lang->pi->featureBar['browse']['all']    = '全部';
$lang->pi->featureBar['browse']['normal'] = $lang->pi->statusList['normal'];
$lang->pi->featureBar['browse']['closed'] = $lang->pi->statusList['closed'];

$lang->pi->closedReasonList = array();
$lang->pi->closedReasonList['complete'] = '已完成';
$lang->pi->closedReasonList['cancel']   = '已取消';

$lang->pi->appendColumnList = array();
$lang->pi->appendColumnList['risk']      = '風險';
$lang->pi->appendColumnList['objective'] = '團隊目標';

$lang->pi->childColumnList['promise']['yes'] = '已承諾目標';
$lang->pi->childColumnList['promise']['no']  = '未承諾目標';

$lang->pi->lane = new stdclass();
$lang->pi->lane->common = '泳道';
$lang->pi->lane->name   = '泳道名稱';
$lang->pi->lane->color  = '泳道顏色';

$lang->pi->cardStatusList['wait']   = '未開始';
$lang->pi->cardStatusList['doing']  = '進行中';
$lang->pi->cardStatusList['done']   = '已完成';
$lang->pi->cardStatusList['closed'] = '已關閉';

$lang->pi->milestone = new stdclass();
$lang->pi->milestone->common     = '項目組里程碑目標';
$lang->pi->milestone->name       = '目標名稱';
$lang->pi->milestone->lane       = '目標泳道';
$lang->pi->milestone->end        = '完成時間';
$lang->pi->milestone->assignedTo = '負責人';
$lang->pi->milestone->status     = '狀態';

$lang->pi->milestone->confirmDelete = '確認刪除該目標嗎？';

$lang->pi->milestone->statusList['normal'] = '正常';
$lang->pi->milestone->statusList['done']   = '完成';
$lang->pi->milestone->statusList['delay']  = '延期';

$lang->pi->columnWidth = array();
$lang->pi->columnWidth['0'] = '固定列寬';
$lang->pi->columnWidth['1'] = '自適應列寬';

$lang->pi->laneHeight = array();
$lang->pi->laneHeight['0'] = '固定行高';
$lang->pi->laneHeight['1'] = '自適應行高';

$lang->picard = new stdclass();
$lang->picard->statusList = $lang->pi->cardStatusList;
