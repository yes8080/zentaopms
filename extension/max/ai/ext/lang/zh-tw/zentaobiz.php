<?php
$lang->ai->list                             = '列表';
$lang->ai->designPrompt                     = '設計禪道智能體';
$lang->ai->apply                            = '應用';
$lang->ai->assistant->createTip             = '配置完成後將在客戶端的語言模型對話下展示';
$lang->ai->miniPrograms->downloadTip        = '發佈後將在通用智能體模型廣場中顯示，客戶端將會同步更新。';
$lang->ai->miniPrograms->knowledgeLibAdd    = '掛載知識庫';
$lang->ai->miniPrograms->knowledgeLibAddTip = '掛載知識庫增強通用智能體能力。';
$lang->ai->miniPrograms->skillAdd           = '掛載技能';
$lang->ai->miniPrograms->skillAddTip        = '掛載技能增強智能體能力。';

$lang->ai->configZaiHint = '請先進行 ZAI 配置';

$lang->ai->prompts->displayPositionDescList = array();
$lang->ai->prompts->displayPositionDescList['detail'] = '在對象詳情頁左側區塊顯示智能體入口。';
$lang->ai->prompts->displayPositionDescList['form']   = '在創建或編輯表單中顯示智能體入口。';

$lang->ai->audit = new stdclass();
$lang->ai->audit->designPrompt          = '提詞設計';
$lang->ai->audit->afterSave             = '保存後';
$lang->ai->audit->promptForModel        = '輸入給模型';

$lang->ai->audit->backLocationList      = array();
$lang->ai->audit->backLocationList['0'] = '返回調試頁面';
$lang->ai->audit->backLocationList['1'] = '返回調試頁面並重新生成';

if(!isset($lang->ai->knowledgeLibs)) $lang->ai->knowledgeLibs = new stdclass();
$lang->ai->knowledgeLibs->common           = '知識庫';
$lang->ai->knowledgeLibs->noData           = '暫無知識庫。';
$lang->ai->knowledgeLibs->create           = '創建知識庫';
$lang->ai->knowledgeLibs->myKnowledgeLib   = '我的知識庫';
$lang->ai->knowledgeLibs->teamKnowledgeLib = '組織知識庫';
$lang->ai->knowledgeLibs->addFileLabel     = '添加本地檔案';

$lang->ai->knowledgeLibs->importActions['doc']    = '從文檔庫導入';
$lang->ai->knowledgeLibs->importActions['asset']  = '從資產庫導入';
$lang->ai->knowledgeLibs->importTypes['doclib']   = '文檔庫';
$lang->ai->knowledgeLibs->importTypes['assetlib'] = '資產庫';

$lang->ai->knowledgeLibs->customAdd                = '自定義添加';
$lang->ai->knowledgeLibs->zentaoData               = '禪道對象數據';
$lang->ai->knowledgeLibs->importFromAsset          = '資產庫導入';
$lang->ai->knowledgeLibs->duplicateImport          = '該%s已導入，無法重複導入';
$lang->ai->knowledgeLibs->draft                    = '草稿';
$lang->ai->knowledgeLibs->published                = '已發佈';
$lang->ai->knowledgeLibs->unavailable              = '暫不可用';
$lang->ai->knowledgeLibs->unpublished              = '已下架';
$lang->ai->knowledgeLibs->deleted                  = '已刪除';
$lang->ai->knowledgeLibs->createdTime              = '創建時間: %s';
$lang->ai->knowledgeLibs->confirmPublish           = '發佈後可在智能會話和智能體中掛載知識庫。';
$lang->ai->knowledgeLibs->confirmUnpublish         = '下架後，智能會話和智能體中將無法掛載該知識庫，您確定要下架嗎？';
$lang->ai->knowledgeLibs->confirmDelete            = '確定刪除該知識庫？';
$lang->ai->knowledgeLibs->confirmDeleteFile        = '確認要刪除該知識？';
$lang->ai->knowledgeLibs->aiChat                   = 'AI 問答';
$lang->ai->knowledgeLibs->searchTest               = '搜索測試';
$lang->ai->knowledgeLibs->addKnowledge             = '添加知識';
$lang->ai->knowledgeLibs->viewSourceData           = '查看原數據';
$lang->ai->knowledgeLibs->selectContent            = '請選擇要查看的內容';
$lang->ai->knowledgeLibs->AddToKnowledgeLib        = '添加到知識庫';
$lang->ai->knowledgeLibs->getKnowledgeChunksFailed = '獲取知識內容塊失敗';
$lang->ai->knowledgeLibs->needSyncKnowledgeItem    = '需要先同步更新知識內容';
$lang->ai->knowledgeLibs->syncingKnowledgeItem     = '正在向量化，請稍後查看';
$lang->ai->knowledgeLibs->emptyKnowledgeData       = '暫無知識內容';
$lang->ai->knowledgeLibs->exitSearchTest           = '退出搜索測試';
$lang->ai->knowledgeLibs->testText                 = '測試文本';
$lang->ai->knowledgeLibs->inputContent             = '輸入內容';
$lang->ai->knowledgeLibs->lastSyncedTime           = '最後同步';
$lang->ai->knowledgeLibs->neverSynced              = '未同步';
$lang->ai->knowledgeLibs->syncFailed               = '同步失敗';
$lang->ai->knowledgeLibs->syncFailedHint           = '請檢查 ZAI 配置，確保 ZAI 服務可用';
$lang->ai->knowledgeLibs->syncFailedCountAlert     = '%s 個數據同步失敗，請檢查 ZAI 配置，確保 ZAI 服務可用';
$lang->ai->knowledgeLibs->updateListData           = '更新列表數據';
$lang->ai->knowledgeLibs->syncListToZAI            = '同步列表數據到 ZAI';
$lang->ai->knowledgeLibs->syncListToZAIConfirm     = '是否將當前列表 %s 個數據同步到 ZAI 向量化資料庫中？';
$lang->ai->knowledgeLibs->noDataNeedToUpdate       = '暫無數據需要更新';
$lang->ai->knowledgeLibs->syncingData              = '正在同步數據……';
$lang->ai->knowledgeLibs->updateFromSourceData     = '從原始數據更新列表';
$lang->ai->knowledgeLibs->updateFromSourceConfirm  = '更新列表數據後將重新向量化，確認更新？';
$lang->ai->knowledgeLibs->cannotExtractFileContent = '無法提取檔案內容';
$lang->ai->knowledgeLibs->fileNotFound             = '原始檔案不存在';
$lang->ai->knowledgeLibs->emptyKnowledgeContent    = '知識內容為空，請點擊“查看原始數據”並輸入內容';

$lang->ai->knowledgeLibs->createMyKnowledgeLib        = '創建我的知識庫';
$lang->ai->knowledgeLibs->createTeamKnowledgeLib      = '創建組織知識庫';
$lang->ai->knowledgeLibs->editMyKnowledgeLib          = '編輯我的知識庫';
$lang->ai->knowledgeLibs->editTeamKnowledgeLib        = '編輯組織知識庫';
$lang->ai->knowledgeLibs->noKnowledgeLib              = '知識庫不存在';
$lang->ai->knowledgeLibs->knowledgeLibName            = '知識庫名稱';
$lang->ai->knowledgeLibs->knowledgeLibDesc            = '知識庫描述';
$lang->ai->knowledgeLibs->knowledgeLibDescPlaceholder = '知識庫的具體描述信息';

$lang->ai->knowledgeLibs->acl                = '訪問控制';
$lang->ai->knowledgeLibs->myPrivateAccess    = '私有（僅創建者可見）';
$lang->ai->knowledgeLibs->teamPublicAccess   = '公開（有組織知識庫視圖權限即可訪問）';
$lang->ai->knowledgeLibs->teamPrivateAccess  = '私有（僅創建者和白名單用戶可見）';
$lang->ai->knowledgeLibs->defaultAccess      = '預設（有所選文檔庫訪問控制權限的用戶即可訪問）';
$lang->ai->knowledgeLibs->whiteList          = '白名單';
$lang->ai->knowledgeLibs->group              = '用戶組';
$lang->ai->knowledgeLibs->user               = '用戶';
$lang->ai->knowledgeLibs->noPrivToView       = '沒有權限查看該知識庫';

$lang->ai->knowledgeLibs->selectedSpace            = '選擇空間';
$lang->ai->knowledgeLibs->space                    = '所屬空間';
$lang->ai->knowledgeLibs->selectedDocLibrary       = '選擇文檔庫';
$lang->ai->knowledgeLibs->selectedAssetType        = '選擇分組';
$lang->ai->knowledgeLibs->selectedAssetLib         = '選擇資產庫';
$lang->ai->knowledgeLibs->selectKnowledgeLib       = '選擇知識庫';
$lang->ai->knowledgeLibs->knowledgeLibSpace        = '知識庫空間';
$lang->ai->knowledgeLibs->pleaseSelectKnowledgeLib = '請選擇知識庫';

$lang->ai->knowledgeLibs->addDoc             = '添加文檔';
$lang->ai->knowledgeLibs->knowledgeTypeName  = '知識類型';
$lang->ai->knowledgeLibs->customText         = '自定義文本';
$lang->ai->knowledgeLibs->localFile          = '本地檔案';
$lang->ai->knowledgeLibs->file               = '檔案';
$lang->ai->knowledgeLibs->creator            = $lang->openedByAB;
$lang->ai->knowledgeLibs->status             = $lang->statusAB;
$lang->ai->knowledgeLibs->category           = '分類';
$lang->ai->knowledgeLibs->createdDate        = '創建日期';
$lang->ai->knowledgeLibs->addKnowledgeTip    = '為你的知識庫添加知識吧';
$lang->ai->knowledgeLibs->noPrivAddKnowledge = '暫無添加知識權限，請聯繫管理員開通';

$lang->ai->knowledgeLibs->spaces['mine']    = '我的空間';
$lang->ai->knowledgeLibs->spaces['custom']  = '團隊空間';
$lang->ai->knowledgeLibs->spaces['product'] = '產品空間';
$lang->ai->knowledgeLibs->spaces['project'] = '項目空間';
$lang->ai->knowledgeLibs->spaces['api']     = '介面空間';

$lang->ai->knowledgeLibs->assets['story']       = '需求庫';
$lang->ai->knowledgeLibs->assets['case']        = '用例庫';
$lang->ai->knowledgeLibs->assets['issue']       = '問題庫';
$lang->ai->knowledgeLibs->assets['risk']        = '風險庫';
$lang->ai->knowledgeLibs->assets['opportunity'] = '機會庫';
$lang->ai->knowledgeLibs->assets['practice']    = '最佳實踐庫';
$lang->ai->knowledgeLibs->assets['component']   = '組件庫';

$lang->ai->knowledgeLibs->objectLabels['feedback']    = '反饋';
$lang->ai->knowledgeLibs->objectLabels['ticket']      = '工單';
$lang->ai->knowledgeLibs->objectLabels['issue']       = '問題';
$lang->ai->knowledgeLibs->objectLabels['risk']        = '風險';
$lang->ai->knowledgeLibs->objectLabels['opportunity'] = '機會';
$lang->ai->knowledgeLibs->objectLabels['practice']    = '最佳實踐';
$lang->ai->knowledgeLibs->objectLabels['component']   = '組件';

$lang->ai->knowledgeLibs->knowledgeTypes         = array();
$lang->ai->knowledgeLibs->knowledgeTypes['text'] = array('label' => $lang->ai->knowledgeLibs->customText, 'icon' => 'file-text', 'action' => 'createtextknowledge');
$lang->ai->knowledgeLibs->knowledgeTypes['file'] = array('label' => $lang->ai->knowledgeLibs->localFile,  'icon' => 'folder-o',  'action' => 'createfileknowledge');

$lang->ai->knowledgeLibs->knowledgeName      = '知識名稱';
$lang->ai->knowledgeLibs->knowledgeContent   = '知識內容';
$lang->ai->knowledgeLibs->generateTitleByAI  = '根據知識內容 AI 生成';
$lang->ai->knowledgeLibs->objectTypeList     = '%s列表';
$lang->ai->knowledgeLibs->viewContent        = '查看內容';
$lang->ai->knowledgeLibs->confirmBatchDelete = '您確認刪除已選中的%s嗎？';
$lang->ai->knowledgeLibs->noItemSelected     = '請至少選擇一項';

$lang->ai->knowledgeLibs->knowledgeObjectTypes = array(
    'story' => array(
        'label' => $lang->ai->moduleList['story']['common'],
        'icon'  => 'lightbulb'
    ),
    'task' => array(
        'label'  => $lang->ai->moduleList['task']['common'],
        'icon'   => 'check-list',
        'priv'   => 'taskBrowse',
        'module' => 'execution',
        'method' => 'task',
        'params' => 'execution=0&status=unclosed&param=0&orderBy=&recTotal=0&recPerPage=100&pageID=1&from=ai'
    ),
    'case' => array(
        'label' => $lang->ai->moduleList['case']['common'],
        'icon'  => 'testcase'
    ),
    'bug' => array(
        'label' => $lang->ai->moduleList['bug']['common'],
        'icon'  => 'bug'
    ),
    'plan' => array(
        'label'  => $lang->ai->moduleList['productplan']['common'],
        'icon'   => 'calendar',
        'key'    => 'productPlan',
        'priv'   => 'productplanBrowse',
        'module' => 'productplan',
        'method' => 'browse',
        'params' => 'productID=0&branch=&browseType=undone&queryID=0&orderBy=begin_desc&recTotal=0&recPerPage=20&pageID=1&from=ai'
    ),
    'release' => array(
        'label' => $lang->ai->moduleList['release']['common'],
        'icon'  => 'publish'
    ),
    'feedback' => array(
        'label'  => $lang->ai->knowledgeLibs->objectLabels['feedback'],
        'icon'   => 'feedback',
        'priv'   => 'feedbackBrowse',
        'module' => 'feedback',
        'method' => 'admin',
        'params' => 'browseType=wait&param=0&orderBy=editedDate_desc,id_desc&recTotal=0&recPerPage=20&pageID=1&from=ai'
    ),
    'ticket' => array(
        'label'  => $lang->ai->knowledgeLibs->objectLabels['ticket'],
        'icon'   => 'ticket',
        'priv'   => 'ticketBrowse',
        'module' => 'ticket',
        'method' => 'browse',
        'params' => 'browseType=wait&param=0&orderBy=id_desc&recTotal=0&recPerPage=20&pageID=1&from=ai'
    ),
    'doc' => array(
        'label'  => $lang->ai->moduleList['doc']['common'],
        'icon'   => 'doc',
        'action' => 'adddoc'
    ),
);

$lang->ai->knowledgeLibs->knowledgeObjectImportTypes = array(
    'issue'       => array('label' => $lang->ai->knowledgeLibs->objectLabels['issue'],       'icon' => 'help'),
    'risk'        => array('label' => $lang->ai->knowledgeLibs->objectLabels['risk'],        'icon' => 'alert'),
    'opportunity' => array('label' => $lang->ai->knowledgeLibs->objectLabels['opportunity'], 'icon' => 'group'),
    'practice'    => array('label' => $lang->ai->knowledgeLibs->objectLabels['practice'],    'icon' => 'checked'),
    'component'   => array('label' => $lang->ai->knowledgeLibs->objectLabels['component'],   'icon' => 'icon-cog-outline'),
);

$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['product'] = array(
    'label'  => '產品需求列表',
    'key'    => 'productStory',
    'priv'   => 'productStory',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=story&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['project'] = array(
    'label'  => '項目需求列表',
    'key'    => 'projectStory',
    'priv'   => 'projectStory',
    'module' => 'projectStory',
    'method' => 'story',
    'params' => 'projectID=0&productID=0&branch=&browseTyp=&param=0&storyType=story&orderBy=id_desc&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['execution'] = array(
    'label'  => '執行需求列表',
    'key'    => 'executionStory',
    'priv'   => 'executionStory',
    'module' => 'execution',
    'method' => 'story',
    'params' => 'executionID=0&storyType=story&orderBy=&type=all&param=0&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['plan'] = array(
    'label'  => '計劃需求列表',
    'key'    => 'planStory',
    'priv'   => 'productplanView',
    'module' => 'productplan',
    'method' => 'story',
    'params' => 'productID=0&planID=0&blockID=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['business'] = array(
    'label'  => '業務需求列表',
    'key'    => 'ER',
    'priv'   => 'epicBrowse',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=epic&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['user'] = array(
    'label'  => '用戶需求列表',
    'key'    => 'UR',
    'priv'   => 'requirementBrowse',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=requirement&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['case']['product'] = array(
    'label'  => '產品用例列表',
    'key'    => 'productCase',
    'priv'   => 'productBug',
    'module' => 'testcase',
    'method' => 'browse',
    'params' => 'productID=0&branch=&browseType=all&param=0&caseType=&orderBy=id_desc&recTotal=0&recPerPage=100&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['case']['caselib'] = array(
    'label'  => '用例庫用例列表',
    'key'    => 'caselibCase',
    'priv'   => 'productBug',
    'module' => 'caselib',
    'method' => 'browse',
    'params' => 'libID=0&browseType=all&param=0&orderBy=id_desc&recTotal=0&recPerPage=100&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['bug']['product'] = array(
    'label'  => '產品Bug列表',
    'key'    => 'productBug',
    'priv'   => 'productBug',
    'module' => 'bug',
    'method' => 'browse',
    'params' => 'productID=0&branch=&browseType=&param=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['bug']['plan'] = array(
    'label'  => '計劃Bug列表',
    'key'    => 'planBug',
    'priv'   => 'productplanView',
    'module' => 'productplan',
    'method' => 'bug',
    'params' => 'productID=0&planID=0&blockID=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['release']['product'] = array(
    'label'  => '產品發佈列表',
    'key'    => 'productRelease',
    'priv'   => 'releaseBrowse',
    'module' => 'release',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&type=all&orderBy=&param=0&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['release']['project'] = array(
    'label'  => '項目發佈列表',
    'key'    => 'projectRelease',
    'priv'   => 'projectReleaseBrowse',
    'module' => 'projectRelease',
    'method' => 'browse',
    'params' => 'projectID=0&executionID=0&type=all&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);

$lang->ai->featureBar['myknowledgelib']['']     = $lang->all;
$lang->ai->featureBar['myknowledgelib']['1']    = $lang->ai->knowledgeLibs->published;
$lang->ai->featureBar['myknowledgelib']['0']    = $lang->ai->knowledgeLibs->draft;

$lang->ai->featureBar['teamknowledgelib'] = $lang->ai->featureBar['myknowledgelib'];

$lang->ai->featureBar['adddoc']['all']   = '全部';
$lang->ai->featureBar['adddoc']['draft'] = '草稿';

$lang->ai->knowledgeLibs->importType    = '導入類型';

$lang->ai->knowledgeLibs->categoryList = array();
$lang->ai->knowledgeLibs->categoryList['']       = '';
$lang->ai->knowledgeLibs->categoryList['custom'] = '自定義';
$lang->ai->knowledgeLibs->categoryList['doclib'] = '文檔導入';

$lang->ai->knowledgeLibs->importTypeList = array();
$lang->ai->knowledgeLibs->importTypeList['']       = '';
$lang->ai->knowledgeLibs->importTypeList['custom'] = $lang->ai->knowledgeLibs->customAdd;
$lang->ai->knowledgeLibs->importTypeList['doclib'] = $lang->ai->knowledgeLibs->importActions['doc'];
if(($this->config->edition == 'max' || $this->config->edition == 'ipd') && isset($lang->ai->knowledgeLibs->assets))
{
    foreach($lang->ai->knowledgeLibs->assets as $assetType => $assetName)
    {
        $lang->ai->knowledgeLibs->importTypeList[$assetType . 'lib'] = $assetName;
    }
}

$lang->ai->knowledgeLibs->publishedList = array();
$lang->ai->knowledgeLibs->publishedList['']  = '';
$lang->ai->knowledgeLibs->publishedList['0'] = $lang->ai->knowledgeLibs->draft;
$lang->ai->knowledgeLibs->publishedList['1'] = $lang->ai->knowledgeLibs->published;

/* 知識庫對象列表 - 列名 */
$lang->ai->knowledgeLibs->columnName['default']['id']              = 'ID';
$lang->ai->knowledgeLibs->columnName['default']['title']           = '標題';
$lang->ai->knowledgeLibs->columnName['doc']['title']               = '文檔標題';
$lang->ai->knowledgeLibs->columnName['doc']['addedByAB']           = '創建者';
$lang->ai->knowledgeLibs->columnName['doc']['addedDate']           = '創建日期';
$lang->ai->knowledgeLibs->columnName['doc']['editedBy']            = '修改者';
$lang->ai->knowledgeLibs->columnName['doc']['editedDate']          = '修改日期';
$lang->ai->knowledgeLibs->columnName['issue']['title']             = '問題名稱';
$lang->ai->knowledgeLibs->columnName['issue']['pri']               = 'P';
$lang->ai->knowledgeLibs->columnName['issue']['severity']          = '嚴重程度';
$lang->ai->knowledgeLibs->columnName['issue']['status']            = '狀態';
$lang->ai->knowledgeLibs->columnName['issue']['issueType']         = '類型';
$lang->ai->knowledgeLibs->columnName['issue']['assetCreatedBy']    = '創建者';
$lang->ai->knowledgeLibs->columnName['issue']['assetCreatedDate']  = '創建日期';
$lang->ai->knowledgeLibs->columnName['issue']['assignedTo']        = '審批人';
$lang->ai->knowledgeLibs->columnName['issue']['approvedDate']      = '審批日期';
$lang->ai->knowledgeLibs->columnName['risk']['title']              = '風險名稱';
$lang->ai->knowledgeLibs->columnName['risk']['pri']                = 'P';
$lang->ai->knowledgeLibs->columnName['risk']['status']             = '狀態';
$lang->ai->knowledgeLibs->columnName['risk']['strategy']           = '策略';
$lang->ai->knowledgeLibs->columnName['risk']['assetCreatedBy']     = '創建者';
$lang->ai->knowledgeLibs->columnName['risk']['assetCreatedDate']   = '創建日期';
$lang->ai->knowledgeLibs->columnName['risk']['assignedTo']         = '審批人';
$lang->ai->knowledgeLibs->columnName['risk']['approvedDate']       = '審批日期';

$lang->ai->knowledgeLibs->columnName['opportunity']['name']             = '機會名稱';
$lang->ai->knowledgeLibs->columnName['opportunity']['pri']              = 'P';
$lang->ai->knowledgeLibs->columnName['opportunity']['status']           = '狀態';
$lang->ai->knowledgeLibs->columnName['opportunity']['opportunityType']  = '類型';
$lang->ai->knowledgeLibs->columnName['opportunity']['assetCreatedBy']   = '創建者';
$lang->ai->knowledgeLibs->columnName['opportunity']['assetCreatedDate'] = '創建日期';
$lang->ai->knowledgeLibs->columnName['opportunity']['assignedTo']       = '審批人';
$lang->ai->knowledgeLibs->columnName['opportunity']['approvedDate']     = '審批日期';

/* 知識庫對象列表 - 枚舉映射配置 */
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['high']   = '高';
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['middle'] = '中';
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['low']    = '低';

$lang->ai->knowledgeLibs->columnValueMap['issue']['severity'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['0'] = '';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['1'] = '嚴重';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['2'] = '較嚴重';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['3'] = '較小';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['4'] = '建議';

$lang->ai->knowledgeLibs->columnValueMap['issue']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['status']['active'] = '已入庫';
$lang->ai->knowledgeLibs->columnValueMap['issue']['status']['draft']  = '待審批';

$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['']             = '';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['design']       = '設計問題';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['code']         = '程序缺陷';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['performance']  = '性能問題';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['version']      = '版本控制';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storyadd']     = '需求新增';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storychanged'] = '需求修改';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storyremoved'] = '需求刪除';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['data']         = '數據問題';

$lang->ai->knowledgeLibs->columnValueMap['risk']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['status']['active'] = '已入庫';
$lang->ai->knowledgeLibs->columnValueMap['risk']['status']['draft']  = '待審批';

$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['']             = '';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['avoidance']    = '規避';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['mitigation']   = '緩解';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['transference'] = '轉移';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['acceptance']   = '接受';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['high']   = '高';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['middle'] = '中';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['low']    = '低';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status']['active'] = '已入庫';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status']['draft']  = '待審批';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['']            = '';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['technical']   = '技術類';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['manage']      = '管理類';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['business']    = '業務類';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['requirement'] = '需求類';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['resource']    = '資源類';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['others']      = '其他';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['']        = '';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['monitor'] = '監控';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['create']  = '創造';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['utilize'] = '利用';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['enhance'] = '增強';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['accept']  = '接受';

if(!isset($lang->ai->knowledgeLibs->tips)) $lang->ai->knowledgeLibs->tips = new stdclass();
$lang->ai->knowledgeLibs->tips->emptyFile  = '請選擇要上傳的檔案';
$lang->ai->knowledgeLibs->tips->file       = '可點擊添加上傳，支持PDF、WORD、PPT、EXCEL、TXT、MD、JSON、YAML不超過 %s';
$lang->ai->knowledgeLibs->tips->searchTest = '請輸入測試內容後查看測試結果。';
$lang->ai->knowledgeLibs->tips->nameRepeat = '知識庫名稱已有%s這條記錄了。';

$lang->ai->browseMyknowledgeLib        = '瀏覽我的知識庫列表';
$lang->ai->browseTeamknowledgeLib      = '瀏覽組織知識庫列表';
$lang->ai->createKnowledgelibAction    = '創建知識庫';
$lang->ai->importFromDocAction         = '從文檔庫導入知識庫';
$lang->ai->importFromAssetAction       = '從資產庫導入知識庫';
$lang->ai->editKnowledgelibAction      = '編輯知識庫';
$lang->ai->publishKnowledgelibAction   = '發佈知識庫';
$lang->ai->unpublishKnowledgelibAction = '下架知識庫';
$lang->ai->deleteKnowledgelibAction    = '刪除知識庫';
$lang->ai->searchKnowledgelibAction    = '搜索測試';
$lang->ai->searchKnowledgelibCheck     = '測試';
$lang->ai->aiChatWithKnowledgeLib      = 'AI問答';
$lang->ai->createKnowledgeAction       = '添加知識';
$lang->ai->deleteKnowledgeAction       = '刪除知識';
$lang->ai->editKnowledgeAction         = '編輯知識';

$lang->ai->browseskillAction       = '瀏覽技能廣場';
$lang->ai->myskillAction           = '瀏覽我的技能';
$lang->ai->editskillcategory       = '維護技能分類';
$lang->ai->createsquareskill       = '上傳技能';
$lang->ai->createmyskill           = '上傳技能';
$lang->ai->editsquareskill         = '編輯技能';
$lang->ai->editmyskill             = '編輯技能';
$lang->ai->viewsquareskill         = '查看技能';
$lang->ai->viewmyskill             = '查看技能';
$lang->ai->deleteskill             = '刪除技能';
$lang->ai->deletesquareskill       = '刪除技能';
$lang->ai->addskill                = '添加到我的技能';
$lang->ai->removeskill             = '移除技能';
$lang->ai->publishskill            = '啟用技能';
$lang->ai->disableskill            = '停用技能';
$lang->ai->releaseskilltosquare    = '上架到廣場';
$lang->ai->releaseskill            = '上架技能';
$lang->ai->disablesquareskill      = '下架技能';

if(!isset($lang->ai->skills)) $lang->ai->skills = new stdclass();
$lang->ai->skills->common                 = '技能';
$lang->ai->skills->browse                 = '技能廣場';
$lang->ai->skills->create                 = '上傳';
$lang->ai->skills->edit                   = '編輯';
$lang->ai->skills->view                   = '技能詳情';
$lang->ai->skills->delete                 = '刪除';
$lang->ai->skills->release                = '上架';
$lang->ai->skills->releaseToSquare        = '上架到廣場';
$lang->ai->skills->add                    = '添加到我的技能';
$lang->ai->skills->added                  = '已添加';
$lang->ai->skills->remove                 = '移除';
$lang->ai->skills->publish                = '啟用';
$lang->ai->skills->disable                = '下架';
$lang->ai->skills->stop                   = '停用';
$lang->ai->skills->confirmDisable         = '您確定要下架嗎，下架後其他用戶和智能體均無法使用該技能。';
$lang->ai->skills->confirmStop            = '您確定要停用嗎，停用後智能體將無法使用該技能。';
$lang->ai->skills->confirmReleaseToSquare = '技能上架後，只能在技能廣場維護。您確定上傳嗎？';
$lang->ai->skills->confirmRemove          = '您確定要從我的技能中移除該技能嗎？';
$lang->ai->skills->name                   = '名稱';
$lang->ai->skills->category               = '分類';
$lang->ai->skills->maintenanceCategory    = '維護分類';
$lang->ai->skills->source                 = '來源';
$lang->ai->skills->square                 = '技能廣場';
$lang->ai->skills->desc                   = '描述';
$lang->ai->skills->status                 = '狀態';
$lang->ai->skills->offline                = '下架';
$lang->ai->skills->createdBy              = '創建人';
$lang->ai->skills->createdDate            = '創建時間';
$lang->ai->skills->editedBy               = '編輯人';
$lang->ai->skills->editedDate             = '編輯時間';
$lang->ai->skills->lastUpdate             = '最後更新：%s';
$lang->ai->skills->emptyList              = '暫時沒有技能';
$lang->ai->skills->myEmptyList            = '暫時沒有技能，可以去技能廣場添加技能或者上傳技能。';
$lang->ai->skills->squareEmptyList        = '暫時沒有技能。';

$lang->ai->skills->statusList = array();
$lang->ai->skills->statusList['']       = '全部';
$lang->ai->skills->statusList['draft']  = '下架';
$lang->ai->skills->statusList['active'] = '上架';

$lang->ai->skills->myStatusList = array();
$lang->ai->skills->myStatusList['draft']   = '停用';
$lang->ai->skills->myStatusList['active']  = '啟用';
$lang->ai->skills->myStatusList['offline'] = '下架';

$lang->ai->skills->squareStatusList = array();
$lang->ai->skills->squareStatusList['draft']  = '下架';
$lang->ai->skills->squareStatusList['active'] = '上架';

$lang->ai->skills->selectFromSquare   = '從技能市場選擇 Skill';
$lang->ai->skills->searchPlaceholder  = '搜索技能名稱...';
$lang->ai->skills->use                = '使用';
$lang->ai->skills->selected           = '已選擇';

$lang->ai->skills->uploadFile = '上傳檔案';
$lang->ai->skills->skillFiles = '技能檔案';
$lang->ai->skills->labelBasic = '基本信息';

$lang->ai->skills->tips = new stdclass();
$lang->ai->skills->tips->emptyFile     = '請選擇要上傳的檔案';
$lang->ai->skills->tips->noSkillMd     = '壓縮包中沒有SKILL.md檔案，請驗證後再次上傳';
$lang->ai->skills->tips->uploadFileTip = '只能上傳zip壓縮包，且壓縮包中必須包含SKILL.md檔案';
$lang->ai->skills->tips->nameRepeat    = '技能名稱已存在，請使用其他名稱';

$lang->ai->featureBar['browseskill']['']            = '全部';
$lang->ai->featureBar['browseskill']['active']      = '已上架';
$lang->ai->featureBar['browseskill']['draft']       = '已下架';
$lang->ai->featureBar['browseskill']['createdByMe'] = '由我上傳';

$lang->ai->featureBar['myskill'] = array();
$lang->ai->featureBar['myskill']['']        = '全部';
$lang->ai->featureBar['myskill']['active']  = '已啟用';
$lang->ai->featureBar['myskill']['draft']   = '已停用';
$lang->ai->featureBar['myskill']['offline'] = '已下架';

/* Timer agent. */
$lang->ai->agentType = new stdclass();
$lang->ai->agentType->normal = 'normal';
$lang->ai->agentType->timer  = 'timer';

$lang->ai->timer = new stdclass();
$lang->ai->timer->common             = '定時智能體';
$lang->ai->timer->create             = '創建定時智能體';
$lang->ai->timer->tag                = '定時';
$lang->ai->timer->operation          = '操作目的';
$lang->ai->timer->cycleType          = '周期類型';
$lang->ai->timer->cycleConfig        = '周期設置';
$lang->ai->timer->notifyRoles        = '通知人員';
$lang->ai->timer->notifyUsers        = '具體的人';
$lang->ai->timer->notifyRoleGroup    = '角色';
$lang->ai->timer->notifyUserGroup    = '人員';
$lang->ai->timer->notifyMethods      = '通知方式';
$lang->ai->timer->timerLog           = '定時日誌';
$lang->ai->timer->emptyLog           = '暫無定時日誌';
$lang->ai->timer->logSummary         = '處理對象 %s 個，失敗 %s 個';
$lang->ai->timer->logCycle           = '成功 %s 個，失敗 %s 個';
$lang->ai->timer->notifyRequired     = '發送通知時必須選擇通知人員和通知方式';
$lang->ai->timer->operationDenied    = '當前版本或處理對象不支持該操作目的';
$lang->ai->timer->editionDenied      = '當前版本不支持定時智能體';
$lang->ai->timer->messageNotice      = '消息內容將根據AI生成的內容發送，請在提詞設置中配置想要生成的內容。';
$lang->ai->timer->cycleDayFrom       = '從 %s';
$lang->ai->timer->cycleDayInterval   = '間隔 %s 天';
$lang->ai->timer->cycleMonthDay      = '%s號';

$lang->ai->timer->moduleList = array();
$lang->ai->timer->moduleList['project'] = '項目';

$lang->ai->timer->operationList = array();
$lang->ai->timer->operationList['notify'] = '發送通知';

global $config;
if($config->edition != 'biz')
{
    $lang->ai->timer->operationList['report'] = '輸出報告';
    $lang->ai->timer->operationList['risk']   = '創建風險';
}

$lang->ai->timer->cycleTypeList = array();
$lang->ai->timer->cycleTypeList['day']   = '按天';
$lang->ai->timer->cycleTypeList['week']  = '按周';
$lang->ai->timer->cycleTypeList['month'] = '按月';

$lang->ai->timer->notifyMethodList = array();
$lang->ai->timer->notifyMethodList['mail']    = '郵件';
$lang->ai->timer->notifyMethodList['message'] = '系統';
$lang->ai->timer->notifyMethodList['webhook'] = 'Webhook';

$lang->ai->timer->notifyRoleList = array();
$lang->ai->timer->notifyRoleList['createdBy']   = '項目創建人';
$lang->ai->timer->notifyRoleList['PM']          = '項目負責人';
//$lang->ai->timer->notifyRoleList['assignedTo']  = '指派人';
//$lang->ai->timer->notifyRoleList['mailto']      = '抄送人';
//$lang->ai->timer->notifyRoleList['PO']          = '產品負責人';
//$lang->ai->timer->notifyRoleList['QD']          = '產品測試負責人';
//$lang->ai->timer->notifyRoleList['RD']          = '發佈負責人';
//$lang->ai->timer->notifyRoleList['feedback']    = '產品反饋負責人';
//$lang->ai->timer->notifyRoleList['ticket']      = '產品工單負責人';
//$lang->ai->timer->notifyRoleList['executionPM'] = '執行負責人';

$lang->ai->timer->promptTemplate = array();
$lang->ai->timer->promptTemplate['notify'] = <<<EOT
按照規則檢查項目：[檢查內容/指標]。

通知要求：

標題：「[緊急程度] + 事件」，15 字以內；

內容按「發生了什麼→影響→數據→建議」結構，時間、對象、數據、影響、建議五要素齊全；


關鍵數字加粗，信息不足標註待確認，不編造數據。

通知內容舉例：[通知內容]
EOT;
$lang->ai->timer->promptTemplate['report'] = <<<EOT
在項目下創建報告，創建報告時按照下述規則進行分析和輸出:

[項目總覽]：展示項目下的執行、需求、任務、bug的彙總信息，如果項目下有激活的風險，一併列出。

[標題]：展示的數據及規則，希望的格式和字型樣式，特殊情況的處理。

[重要]：輸出格式採用markdown格式，重要信息加粗。

EOT;
$lang->ai->timer->promptTemplate['risk'] = <<<EOT
檢查進行中的項目風險：[檢查內容/指標]。

風險要求：

名稱 ：一句話描述，建議格式「對象 + 潛在事件 + 後果」，如「核心開發者離職導致迭代2延期」

優先順序：1(高) / 2(中) / 3(低)

發生概率：1 / 2 / 3 / 4 / 5

影響程度：1 / 2 / 3 / 4 / 5

風險係數：發生概率 * 影響程度

應對措施：寫明具體行動計劃、執行人、完成時限；高/中風險必須有

指派給：指定風險責任人（用戶account）；高/中風險必須有

計劃關閉日期 ：YYYY-MM-DD格式，高風險必須設置，中風險建議設置
EOT;

$lang->ai->designStepNavTimer = array();
$lang->ai->designStepNavTimer['basicinfo'] = '基礎信息';
$lang->ai->designStepNavTimer['setprompt'] = '設置提詞';
$lang->ai->designStepNavTimer['preview']   = '結果預覽';

$lang->ai->operation = $lang->ai->timer->operation;

$lang->ai->knowledgeAPI = new stdclass();
$lang->ai->knowledgeAPI->invalidParameter = '參數 %s 無效。';
$lang->ai->knowledgeAPI->notFound         = '知識庫或知識不存在、已刪除或未發佈。';
$lang->ai->knowledgeAPI->accessDenied     = '無權訪問此知識庫或知識。';
$lang->ai->knowledgeAPI->searchFailed     = '向量搜索服務請求失敗，請稍後重試。';
$lang->ai->knowledgeAPI->methodNotAllowed = '不支持此 HTTP 請求方法。';
