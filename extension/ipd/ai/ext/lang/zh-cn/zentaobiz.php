<?php
$lang->ai->list                             = '列表';
$lang->ai->designPrompt                     = '设计禅道智能体';
$lang->ai->apply                            = '应用';
$lang->ai->assistant->createTip             = '配置完成后将在客户端的语言模型对话下展示';
$lang->ai->miniPrograms->downloadTip        = '发布后将在通用智能体模型广场中显示，客户端将会同步更新。';
$lang->ai->miniPrograms->knowledgeLibAdd    = '挂载知识库';
$lang->ai->miniPrograms->knowledgeLibAddTip = '挂载知识库增强通用智能体能力。';
$lang->ai->miniPrograms->skillAdd           = '挂载技能';
$lang->ai->miniPrograms->skillAddTip        = '挂载技能增强智能体能力。';

$lang->ai->configZaiHint = '请先进行 ZAI 配置';

$lang->ai->prompts->displayPositionDescList = array();
$lang->ai->prompts->displayPositionDescList['detail'] = '在对象详情页左侧区块显示智能体入口。';
$lang->ai->prompts->displayPositionDescList['form']   = '在创建或编辑表单中显示智能体入口。';

$lang->ai->audit = new stdclass();
$lang->ai->audit->designPrompt          = '提词设计';
$lang->ai->audit->afterSave             = '保存后';
$lang->ai->audit->promptForModel        = '输入给模型';

$lang->ai->audit->backLocationList      = array();
$lang->ai->audit->backLocationList['0'] = '返回调试页面';
$lang->ai->audit->backLocationList['1'] = '返回调试页面并重新生成';

if(!isset($lang->ai->knowledgeLibs)) $lang->ai->knowledgeLibs = new stdclass();
$lang->ai->knowledgeLibs->common           = '知识库';
$lang->ai->knowledgeLibs->noData           = '暂无知识库。';
$lang->ai->knowledgeLibs->create           = '创建知识库';
$lang->ai->knowledgeLibs->myKnowledgeLib   = '我的知识库';
$lang->ai->knowledgeLibs->teamKnowledgeLib = '组织知识库';
$lang->ai->knowledgeLibs->addFileLabel     = '添加本地文件';

$lang->ai->knowledgeLibs->importActions['doc']    = '从文档库导入';
$lang->ai->knowledgeLibs->importActions['asset']  = '从资产库导入';
$lang->ai->knowledgeLibs->importTypes['doclib']   = '文档库';
$lang->ai->knowledgeLibs->importTypes['assetlib'] = '资产库';

$lang->ai->knowledgeLibs->customAdd                = '自定义添加';
$lang->ai->knowledgeLibs->zentaoData               = '禅道对象数据';
$lang->ai->knowledgeLibs->importFromAsset          = '资产库导入';
$lang->ai->knowledgeLibs->duplicateImport          = '该%s已导入，无法重复导入';
$lang->ai->knowledgeLibs->draft                    = '草稿';
$lang->ai->knowledgeLibs->published                = '已发布';
$lang->ai->knowledgeLibs->unavailable              = '暂不可用';
$lang->ai->knowledgeLibs->unpublished              = '已下架';
$lang->ai->knowledgeLibs->deleted                  = '已删除';
$lang->ai->knowledgeLibs->createdTime              = '创建时间: %s';
$lang->ai->knowledgeLibs->confirmPublish           = '发布后可在智能会话和智能体中挂载知识库。';
$lang->ai->knowledgeLibs->confirmUnpublish         = '下架后，智能会话和智能体中将无法挂载该知识库，您确定要下架吗？';
$lang->ai->knowledgeLibs->confirmDelete            = '确定删除该知识库？';
$lang->ai->knowledgeLibs->confirmDeleteFile        = '确认要删除该知识？';
$lang->ai->knowledgeLibs->aiChat                   = 'AI 问答';
$lang->ai->knowledgeLibs->searchTest               = '搜索测试';
$lang->ai->knowledgeLibs->addKnowledge             = '添加知识';
$lang->ai->knowledgeLibs->viewSourceData           = '查看原数据';
$lang->ai->knowledgeLibs->selectContent            = '请选择要查看的内容';
$lang->ai->knowledgeLibs->AddToKnowledgeLib        = '添加到知识库';
$lang->ai->knowledgeLibs->getKnowledgeChunksFailed = '获取知识内容块失败';
$lang->ai->knowledgeLibs->needSyncKnowledgeItem    = '需要先同步更新知识内容';
$lang->ai->knowledgeLibs->syncingKnowledgeItem     = '正在向量化，请稍后查看';
$lang->ai->knowledgeLibs->emptyKnowledgeData       = '暂无知识内容';
$lang->ai->knowledgeLibs->exitSearchTest           = '退出搜索测试';
$lang->ai->knowledgeLibs->testText                 = '测试文本';
$lang->ai->knowledgeLibs->inputContent             = '输入内容';
$lang->ai->knowledgeLibs->lastSyncedTime           = '最后同步';
$lang->ai->knowledgeLibs->neverSynced              = '未同步';
$lang->ai->knowledgeLibs->syncFailed               = '同步失败';
$lang->ai->knowledgeLibs->syncFailedHint           = '请检查 ZAI 配置，确保 ZAI 服务可用';
$lang->ai->knowledgeLibs->syncFailedCountAlert     = '%s 个数据同步失败，请检查 ZAI 配置，确保 ZAI 服务可用';
$lang->ai->knowledgeLibs->updateListData           = '更新列表数据';
$lang->ai->knowledgeLibs->syncListToZAI            = '同步列表数据到 ZAI';
$lang->ai->knowledgeLibs->syncListToZAIConfirm     = '是否将当前列表 %s 个数据同步到 ZAI 向量化数据库中？';
$lang->ai->knowledgeLibs->noDataNeedToUpdate       = '暂无数据需要更新';
$lang->ai->knowledgeLibs->syncingData              = '正在同步数据……';
$lang->ai->knowledgeLibs->updateFromSourceData     = '从原始数据更新列表';
$lang->ai->knowledgeLibs->updateFromSourceConfirm  = '更新列表数据后将重新向量化，确认更新？';
$lang->ai->knowledgeLibs->cannotExtractFileContent = '无法提取文件内容';
$lang->ai->knowledgeLibs->fileNotFound             = '原始文件不存在';
$lang->ai->knowledgeLibs->emptyKnowledgeContent    = '知识内容为空，请点击“查看原始数据”并输入内容';

$lang->ai->knowledgeLibs->createMyKnowledgeLib        = '创建我的知识库';
$lang->ai->knowledgeLibs->createTeamKnowledgeLib      = '创建组织知识库';
$lang->ai->knowledgeLibs->editMyKnowledgeLib          = '编辑我的知识库';
$lang->ai->knowledgeLibs->editTeamKnowledgeLib        = '编辑组织知识库';
$lang->ai->knowledgeLibs->noKnowledgeLib              = '知识库不存在';
$lang->ai->knowledgeLibs->knowledgeLibName            = '知识库名称';
$lang->ai->knowledgeLibs->knowledgeLibDesc            = '知识库描述';
$lang->ai->knowledgeLibs->knowledgeLibDescPlaceholder = '知识库的具体描述信息';

$lang->ai->knowledgeLibs->acl                = '访问控制';
$lang->ai->knowledgeLibs->myPrivateAccess    = '私有（仅创建者可见）';
$lang->ai->knowledgeLibs->teamPublicAccess   = '公开（有组织知识库视图权限即可访问）';
$lang->ai->knowledgeLibs->teamPrivateAccess  = '私有（仅创建者和白名单用户可见）';
$lang->ai->knowledgeLibs->defaultAccess      = '默认（有所选文档库访问控制权限的用户即可访问）';
$lang->ai->knowledgeLibs->whiteList          = '白名单';
$lang->ai->knowledgeLibs->group              = '用户组';
$lang->ai->knowledgeLibs->user               = '用户';
$lang->ai->knowledgeLibs->noPrivToView       = '没有权限查看该知识库';

$lang->ai->knowledgeLibs->selectedSpace            = '选择空间';
$lang->ai->knowledgeLibs->space                    = '所属空间';
$lang->ai->knowledgeLibs->selectedDocLibrary       = '选择文档库';
$lang->ai->knowledgeLibs->selectedAssetType        = '选择分组';
$lang->ai->knowledgeLibs->selectedAssetLib         = '选择资产库';
$lang->ai->knowledgeLibs->selectKnowledgeLib       = '选择知识库';
$lang->ai->knowledgeLibs->knowledgeLibSpace        = '知识库空间';
$lang->ai->knowledgeLibs->pleaseSelectKnowledgeLib = '请选择知识库';

$lang->ai->knowledgeLibs->addDoc             = '添加文档';
$lang->ai->knowledgeLibs->knowledgeTypeName  = '知识类型';
$lang->ai->knowledgeLibs->customText         = '自定义文本';
$lang->ai->knowledgeLibs->localFile          = '本地文件';
$lang->ai->knowledgeLibs->file               = '文件';
$lang->ai->knowledgeLibs->creator            = $lang->openedByAB;
$lang->ai->knowledgeLibs->status             = $lang->statusAB;
$lang->ai->knowledgeLibs->category           = '分类';
$lang->ai->knowledgeLibs->createdDate        = '创建日期';
$lang->ai->knowledgeLibs->addKnowledgeTip    = '为你的知识库添加知识吧';
$lang->ai->knowledgeLibs->noPrivAddKnowledge = '暂无添加知识权限，请联系管理员开通';

$lang->ai->knowledgeLibs->spaces['mine']    = '我的空间';
$lang->ai->knowledgeLibs->spaces['custom']  = '团队空间';
$lang->ai->knowledgeLibs->spaces['product'] = '产品空间';
$lang->ai->knowledgeLibs->spaces['project'] = '项目空间';
$lang->ai->knowledgeLibs->spaces['api']     = '接口空间';

$lang->ai->knowledgeLibs->assets['story']       = '需求库';
$lang->ai->knowledgeLibs->assets['case']        = '用例库';
$lang->ai->knowledgeLibs->assets['issue']       = '问题库';
$lang->ai->knowledgeLibs->assets['risk']        = '风险库';
$lang->ai->knowledgeLibs->assets['opportunity'] = '机会库';
$lang->ai->knowledgeLibs->assets['practice']    = '最佳实践库';
$lang->ai->knowledgeLibs->assets['component']   = '组件库';

$lang->ai->knowledgeLibs->objectLabels['feedback']    = '反馈';
$lang->ai->knowledgeLibs->objectLabels['ticket']      = '工单';
$lang->ai->knowledgeLibs->objectLabels['issue']       = '问题';
$lang->ai->knowledgeLibs->objectLabels['risk']        = '风险';
$lang->ai->knowledgeLibs->objectLabels['opportunity'] = '机会';
$lang->ai->knowledgeLibs->objectLabels['practice']    = '最佳实践';
$lang->ai->knowledgeLibs->objectLabels['component']   = '组件';

$lang->ai->knowledgeLibs->knowledgeTypes         = array();
$lang->ai->knowledgeLibs->knowledgeTypes['text'] = array('label' => $lang->ai->knowledgeLibs->customText, 'icon' => 'file-text', 'action' => 'createtextknowledge');
$lang->ai->knowledgeLibs->knowledgeTypes['file'] = array('label' => $lang->ai->knowledgeLibs->localFile,  'icon' => 'folder-o',  'action' => 'createfileknowledge');

$lang->ai->knowledgeLibs->knowledgeName      = '知识名称';
$lang->ai->knowledgeLibs->knowledgeContent   = '知识内容';
$lang->ai->knowledgeLibs->generateTitleByAI  = '根据知识内容 AI 生成';
$lang->ai->knowledgeLibs->objectTypeList     = '%s列表';
$lang->ai->knowledgeLibs->viewContent        = '查看内容';
$lang->ai->knowledgeLibs->confirmBatchDelete = '您确认删除已选中的%s吗？';
$lang->ai->knowledgeLibs->noItemSelected     = '请至少选择一项';

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
    'label'  => '产品需求列表',
    'key'    => 'productStory',
    'priv'   => 'productStory',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=story&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['project'] = array(
    'label'  => '项目需求列表',
    'key'    => 'projectStory',
    'priv'   => 'projectStory',
    'module' => 'projectStory',
    'method' => 'story',
    'params' => 'projectID=0&productID=0&branch=&browseTyp=&param=0&storyType=story&orderBy=id_desc&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['execution'] = array(
    'label'  => '执行需求列表',
    'key'    => 'executionStory',
    'priv'   => 'executionStory',
    'module' => 'execution',
    'method' => 'story',
    'params' => 'executionID=0&storyType=story&orderBy=&type=all&param=0&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['plan'] = array(
    'label'  => '计划需求列表',
    'key'    => 'planStory',
    'priv'   => 'productplanView',
    'module' => 'productplan',
    'method' => 'story',
    'params' => 'productID=0&planID=0&blockID=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['business'] = array(
    'label'  => '业务需求列表',
    'key'    => 'ER',
    'priv'   => 'epicBrowse',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=epic&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['user'] = array(
    'label'  => '用户需求列表',
    'key'    => 'UR',
    'priv'   => 'requirementBrowse',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=requirement&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['case']['product'] = array(
    'label'  => '产品用例列表',
    'key'    => 'productCase',
    'priv'   => 'productBug',
    'module' => 'testcase',
    'method' => 'browse',
    'params' => 'productID=0&branch=&browseType=all&param=0&caseType=&orderBy=id_desc&recTotal=0&recPerPage=100&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['case']['caselib'] = array(
    'label'  => '用例库用例列表',
    'key'    => 'caselibCase',
    'priv'   => 'productBug',
    'module' => 'caselib',
    'method' => 'browse',
    'params' => 'libID=0&browseType=all&param=0&orderBy=id_desc&recTotal=0&recPerPage=100&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['bug']['product'] = array(
    'label'  => '产品Bug列表',
    'key'    => 'productBug',
    'priv'   => 'productBug',
    'module' => 'bug',
    'method' => 'browse',
    'params' => 'productID=0&branch=&browseType=&param=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['bug']['plan'] = array(
    'label'  => '计划Bug列表',
    'key'    => 'planBug',
    'priv'   => 'productplanView',
    'module' => 'productplan',
    'method' => 'bug',
    'params' => 'productID=0&planID=0&blockID=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['release']['product'] = array(
    'label'  => '产品发布列表',
    'key'    => 'productRelease',
    'priv'   => 'releaseBrowse',
    'module' => 'release',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&type=all&orderBy=&param=0&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['release']['project'] = array(
    'label'  => '项目发布列表',
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

$lang->ai->knowledgeLibs->importType    = '导入类型';

$lang->ai->knowledgeLibs->categoryList = array();
$lang->ai->knowledgeLibs->categoryList['']       = '';
$lang->ai->knowledgeLibs->categoryList['custom'] = '自定义';
$lang->ai->knowledgeLibs->categoryList['doclib'] = '文档导入';

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

/* 知识库对象列表 - 列名 */
$lang->ai->knowledgeLibs->columnName['default']['id']              = 'ID';
$lang->ai->knowledgeLibs->columnName['default']['title']           = '标题';
$lang->ai->knowledgeLibs->columnName['doc']['title']               = '文档标题';
$lang->ai->knowledgeLibs->columnName['doc']['addedByAB']           = '创建者';
$lang->ai->knowledgeLibs->columnName['doc']['addedDate']           = '创建日期';
$lang->ai->knowledgeLibs->columnName['doc']['editedBy']            = '修改者';
$lang->ai->knowledgeLibs->columnName['doc']['editedDate']          = '修改日期';
$lang->ai->knowledgeLibs->columnName['issue']['title']             = '问题名称';
$lang->ai->knowledgeLibs->columnName['issue']['pri']               = 'P';
$lang->ai->knowledgeLibs->columnName['issue']['severity']          = '严重程度';
$lang->ai->knowledgeLibs->columnName['issue']['status']            = '状态';
$lang->ai->knowledgeLibs->columnName['issue']['issueType']         = '类型';
$lang->ai->knowledgeLibs->columnName['issue']['assetCreatedBy']    = '创建者';
$lang->ai->knowledgeLibs->columnName['issue']['assetCreatedDate']  = '创建日期';
$lang->ai->knowledgeLibs->columnName['issue']['assignedTo']        = '审批人';
$lang->ai->knowledgeLibs->columnName['issue']['approvedDate']      = '审批日期';
$lang->ai->knowledgeLibs->columnName['risk']['title']              = '风险名称';
$lang->ai->knowledgeLibs->columnName['risk']['pri']                = 'P';
$lang->ai->knowledgeLibs->columnName['risk']['status']             = '状态';
$lang->ai->knowledgeLibs->columnName['risk']['strategy']           = '策略';
$lang->ai->knowledgeLibs->columnName['risk']['assetCreatedBy']     = '创建者';
$lang->ai->knowledgeLibs->columnName['risk']['assetCreatedDate']   = '创建日期';
$lang->ai->knowledgeLibs->columnName['risk']['assignedTo']         = '审批人';
$lang->ai->knowledgeLibs->columnName['risk']['approvedDate']       = '审批日期';

$lang->ai->knowledgeLibs->columnName['opportunity']['name']             = '机会名称';
$lang->ai->knowledgeLibs->columnName['opportunity']['pri']              = 'P';
$lang->ai->knowledgeLibs->columnName['opportunity']['status']           = '状态';
$lang->ai->knowledgeLibs->columnName['opportunity']['opportunityType']  = '类型';
$lang->ai->knowledgeLibs->columnName['opportunity']['assetCreatedBy']   = '创建者';
$lang->ai->knowledgeLibs->columnName['opportunity']['assetCreatedDate'] = '创建日期';
$lang->ai->knowledgeLibs->columnName['opportunity']['assignedTo']       = '审批人';
$lang->ai->knowledgeLibs->columnName['opportunity']['approvedDate']     = '审批日期';

/* 知识库对象列表 - 枚举映射配置 */
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['high']   = '高';
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['middle'] = '中';
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['low']    = '低';

$lang->ai->knowledgeLibs->columnValueMap['issue']['severity'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['0'] = '';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['1'] = '严重';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['2'] = '较严重';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['3'] = '较小';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['4'] = '建议';

$lang->ai->knowledgeLibs->columnValueMap['issue']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['status']['active'] = '已入库';
$lang->ai->knowledgeLibs->columnValueMap['issue']['status']['draft']  = '待审批';

$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['']             = '';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['design']       = '设计问题';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['code']         = '程序缺陷';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['performance']  = '性能问题';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['version']      = '版本控制';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storyadd']     = '需求新增';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storychanged'] = '需求修改';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storyremoved'] = '需求删除';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['data']         = '数据问题';

$lang->ai->knowledgeLibs->columnValueMap['risk']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['status']['active'] = '已入库';
$lang->ai->knowledgeLibs->columnValueMap['risk']['status']['draft']  = '待审批';

$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['']             = '';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['avoidance']    = '规避';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['mitigation']   = '缓解';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['transference'] = '转移';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['acceptance']   = '接受';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['high']   = '高';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['middle'] = '中';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['low']    = '低';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status']['active'] = '已入库';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status']['draft']  = '待审批';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['']            = '';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['technical']   = '技术类';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['manage']      = '管理类';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['business']    = '业务类';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['requirement'] = '需求类';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['resource']    = '资源类';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['others']      = '其他';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['']        = '';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['monitor'] = '监控';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['create']  = '创造';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['utilize'] = '利用';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['enhance'] = '增强';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['accept']  = '接受';

if(!isset($lang->ai->knowledgeLibs->tips)) $lang->ai->knowledgeLibs->tips = new stdclass();
$lang->ai->knowledgeLibs->tips->emptyFile  = '请选择要上传的文件';
$lang->ai->knowledgeLibs->tips->file       = '可点击添加上传，支持PDF、WORD、PPT、EXCEL、TXT、MD、JSON、YAML不超过 %s';
$lang->ai->knowledgeLibs->tips->searchTest = '请输入测试内容后查看测试结果。';
$lang->ai->knowledgeLibs->tips->nameRepeat = '知识库名称已有%s这条记录了。';

$lang->ai->browseMyknowledgeLib        = '浏览我的知识库列表';
$lang->ai->browseTeamknowledgeLib      = '浏览组织知识库列表';
$lang->ai->createKnowledgelibAction    = '创建知识库';
$lang->ai->importFromDocAction         = '从文档库导入知识库';
$lang->ai->importFromAssetAction       = '从资产库导入知识库';
$lang->ai->editKnowledgelibAction      = '编辑知识库';
$lang->ai->publishKnowledgelibAction   = '发布知识库';
$lang->ai->unpublishKnowledgelibAction = '下架知识库';
$lang->ai->deleteKnowledgelibAction    = '删除知识库';
$lang->ai->searchKnowledgelibAction    = '搜索测试';
$lang->ai->searchKnowledgelibCheck     = '测试';
$lang->ai->aiChatWithKnowledgeLib      = 'AI问答';
$lang->ai->createKnowledgeAction       = '添加知识';
$lang->ai->deleteKnowledgeAction       = '删除知识';
$lang->ai->editKnowledgeAction         = '编辑知识';

$lang->ai->browseskillAction       = '浏览技能广场';
$lang->ai->myskillAction           = '浏览我的技能';
$lang->ai->editskillcategory       = '维护技能分类';
$lang->ai->createsquareskill       = '上传技能';
$lang->ai->createmyskill           = '上传技能';
$lang->ai->editsquareskill         = '编辑技能';
$lang->ai->editmyskill             = '编辑技能';
$lang->ai->viewsquareskill         = '查看技能';
$lang->ai->viewmyskill             = '查看技能';
$lang->ai->deleteskill             = '删除技能';
$lang->ai->deletesquareskill       = '删除技能';
$lang->ai->addskill                = '添加到我的技能';
$lang->ai->removeskill             = '移除技能';
$lang->ai->publishskill            = '启用技能';
$lang->ai->disableskill            = '停用技能';
$lang->ai->releaseskilltosquare    = '上架到广场';
$lang->ai->releaseskill            = '上架技能';
$lang->ai->disablesquareskill      = '下架技能';

if(!isset($lang->ai->skills)) $lang->ai->skills = new stdclass();
$lang->ai->skills->common                 = '技能';
$lang->ai->skills->browse                 = '技能广场';
$lang->ai->skills->create                 = '上传';
$lang->ai->skills->edit                   = '编辑';
$lang->ai->skills->view                   = '技能详情';
$lang->ai->skills->delete                 = '删除';
$lang->ai->skills->release                = '上架';
$lang->ai->skills->releaseToSquare        = '上架到广场';
$lang->ai->skills->add                    = '添加到我的技能';
$lang->ai->skills->added                  = '已添加';
$lang->ai->skills->remove                 = '移除';
$lang->ai->skills->publish                = '启用';
$lang->ai->skills->disable                = '下架';
$lang->ai->skills->stop                   = '停用';
$lang->ai->skills->confirmDisable         = '您确定要下架吗，下架后其他用户和智能体均无法使用该技能。';
$lang->ai->skills->confirmStop            = '您确定要停用吗，停用后智能体将无法使用该技能。';
$lang->ai->skills->confirmReleaseToSquare = '技能上架后，只能在技能广场维护。您确定上传吗？';
$lang->ai->skills->confirmRemove          = '您确定要从我的技能中移除该技能吗？';
$lang->ai->skills->name                   = '名称';
$lang->ai->skills->category               = '分类';
$lang->ai->skills->maintenanceCategory    = '维护分类';
$lang->ai->skills->source                 = '来源';
$lang->ai->skills->square                 = '技能广场';
$lang->ai->skills->desc                   = '描述';
$lang->ai->skills->status                 = '状态';
$lang->ai->skills->offline                = '下架';
$lang->ai->skills->createdBy              = '创建人';
$lang->ai->skills->createdDate            = '创建时间';
$lang->ai->skills->editedBy               = '编辑人';
$lang->ai->skills->editedDate             = '编辑时间';
$lang->ai->skills->lastUpdate             = '最后更新：%s';
$lang->ai->skills->emptyList              = '暂时没有技能';
$lang->ai->skills->myEmptyList            = '暂时没有技能，可以去技能广场添加技能或者上传技能。';
$lang->ai->skills->squareEmptyList        = '暂时没有技能。';

$lang->ai->skills->statusList = array();
$lang->ai->skills->statusList['']       = '全部';
$lang->ai->skills->statusList['draft']  = '下架';
$lang->ai->skills->statusList['active'] = '上架';

$lang->ai->skills->myStatusList = array();
$lang->ai->skills->myStatusList['draft']   = '停用';
$lang->ai->skills->myStatusList['active']  = '启用';
$lang->ai->skills->myStatusList['offline'] = '下架';

$lang->ai->skills->squareStatusList = array();
$lang->ai->skills->squareStatusList['draft']  = '下架';
$lang->ai->skills->squareStatusList['active'] = '上架';

$lang->ai->skills->selectFromSquare   = '从技能市场选择 Skill';
$lang->ai->skills->searchPlaceholder  = '搜索技能名称...';
$lang->ai->skills->use                = '使用';
$lang->ai->skills->selected           = '已选择';

$lang->ai->skills->uploadFile = '上传文件';
$lang->ai->skills->skillFiles = '技能文件';
$lang->ai->skills->labelBasic = '基本信息';

$lang->ai->skills->tips = new stdclass();
$lang->ai->skills->tips->emptyFile     = '请选择要上传的文件';
$lang->ai->skills->tips->noSkillMd     = '压缩包中没有SKILL.md文件，请验证后再次上传';
$lang->ai->skills->tips->uploadFileTip = '只能上传zip压缩包，且压缩包中必须包含SKILL.md文件';
$lang->ai->skills->tips->nameRepeat    = '技能名称已存在，请使用其他名称';

$lang->ai->featureBar['browseskill']['']            = '全部';
$lang->ai->featureBar['browseskill']['active']      = '已上架';
$lang->ai->featureBar['browseskill']['draft']       = '已下架';
$lang->ai->featureBar['browseskill']['createdByMe'] = '由我上传';

$lang->ai->featureBar['myskill'] = array();
$lang->ai->featureBar['myskill']['']        = '全部';
$lang->ai->featureBar['myskill']['active']  = '已启用';
$lang->ai->featureBar['myskill']['draft']   = '已停用';
$lang->ai->featureBar['myskill']['offline'] = '已下架';

/* Timer agent. */
$lang->ai->agentType = new stdclass();
$lang->ai->agentType->normal = 'normal';
$lang->ai->agentType->timer  = 'timer';

$lang->ai->timer = new stdclass();
$lang->ai->timer->common             = '定时智能体';
$lang->ai->timer->create             = '创建定时智能体';
$lang->ai->timer->tag                = '定时';
$lang->ai->timer->operation          = '操作目的';
$lang->ai->timer->cycleType          = '周期类型';
$lang->ai->timer->cycleConfig        = '周期设置';
$lang->ai->timer->notifyRoles        = '通知人员';
$lang->ai->timer->notifyUsers        = '具体的人';
$lang->ai->timer->notifyRoleGroup    = '角色';
$lang->ai->timer->notifyUserGroup    = '人员';
$lang->ai->timer->notifyMethods      = '通知方式';
$lang->ai->timer->timerLog           = '定时日志';
$lang->ai->timer->emptyLog           = '暂无定时日志';
$lang->ai->timer->logSummary         = '处理对象 %s 个，失败 %s 个';
$lang->ai->timer->logCycle           = '成功 %s 个，失败 %s 个';
$lang->ai->timer->notifyRequired     = '发送通知时必须选择通知人员和通知方式';
$lang->ai->timer->operationDenied    = '当前版本或处理对象不支持该操作目的';
$lang->ai->timer->editionDenied      = '当前版本不支持定时智能体';
$lang->ai->timer->messageNotice      = '消息内容将根据AI生成的内容发送，请在提词设置中配置想要生成的内容。';
$lang->ai->timer->cycleDayFrom       = '从 %s';
$lang->ai->timer->cycleDayInterval   = '间隔 %s 天';
$lang->ai->timer->cycleMonthDay      = '%s号';

$lang->ai->timer->moduleList = array();
$lang->ai->timer->moduleList['project'] = '项目';

$lang->ai->timer->operationList = array();
$lang->ai->timer->operationList['notify'] = '发送通知';

global $config;
if($config->edition != 'biz')
{
    $lang->ai->timer->operationList['report'] = '输出报告';
    $lang->ai->timer->operationList['risk']   = '创建风险';
}

$lang->ai->timer->cycleTypeList = array();
$lang->ai->timer->cycleTypeList['day']   = '按天';
$lang->ai->timer->cycleTypeList['week']  = '按周';
$lang->ai->timer->cycleTypeList['month'] = '按月';

$lang->ai->timer->notifyMethodList = array();
$lang->ai->timer->notifyMethodList['mail']    = '邮件';
$lang->ai->timer->notifyMethodList['message'] = '系统';
$lang->ai->timer->notifyMethodList['webhook'] = 'Webhook';

$lang->ai->timer->notifyRoleList = array();
$lang->ai->timer->notifyRoleList['createdBy']   = '项目创建人';
$lang->ai->timer->notifyRoleList['PM']          = '项目负责人';
//$lang->ai->timer->notifyRoleList['assignedTo']  = '指派人';
//$lang->ai->timer->notifyRoleList['mailto']      = '抄送人';
//$lang->ai->timer->notifyRoleList['PO']          = '产品负责人';
//$lang->ai->timer->notifyRoleList['QD']          = '产品测试负责人';
//$lang->ai->timer->notifyRoleList['RD']          = '发布负责人';
//$lang->ai->timer->notifyRoleList['feedback']    = '产品反馈负责人';
//$lang->ai->timer->notifyRoleList['ticket']      = '产品工单负责人';
//$lang->ai->timer->notifyRoleList['executionPM'] = '执行负责人';

$lang->ai->timer->promptTemplate = array();
$lang->ai->timer->promptTemplate['notify'] = <<<EOT
按照规则检查项目：[检查内容/指标]。

通知要求：

标题：「[紧急程度] + 事件」，15 字以内；

内容按「发生了什么→影响→数据→建议」结构，时间、对象、数据、影响、建议五要素齐全；


关键数字加粗，信息不足标注待确认，不编造数据。

通知内容举例：[通知内容]
EOT;
$lang->ai->timer->promptTemplate['report'] = <<<EOT
在项目下创建报告，创建报告时按照下述规则进行分析和输出:

[项目总览]：展示项目下的执行、需求、任务、bug的汇总信息，如果项目下有激活的风险，一并列出。

[标题]：展示的数据及规则，希望的格式和字体样式，特殊情况的处理。

[重要]：输出格式采用markdown格式，重要信息加粗。

EOT;
$lang->ai->timer->promptTemplate['risk'] = <<<EOT
检查进行中的项目风险：[检查内容/指标]。

风险要求：

名称 ：一句话描述，建议格式「对象 + 潜在事件 + 后果」，如「核心开发者离职导致迭代2延期」

优先级：1(高) / 2(中) / 3(低)

发生概率：1 / 2 / 3 / 4 / 5

影响程度：1 / 2 / 3 / 4 / 5

风险系数：发生概率 * 影响程度

应对措施：写明具体行动计划、执行人、完成时限；高/中风险必须有

指派给：指定风险责任人（用户account）；高/中风险必须有

计划关闭日期 ：YYYY-MM-DD格式，高风险必须设置，中风险建议设置
EOT;

$lang->ai->designStepNavTimer = array();
$lang->ai->designStepNavTimer['basicinfo'] = '基础信息';
$lang->ai->designStepNavTimer['setprompt'] = '设置提词';
$lang->ai->designStepNavTimer['preview']   = '结果预览';

$lang->ai->operation = $lang->ai->timer->operation;

$lang->ai->knowledgeAPI = new stdclass();
$lang->ai->knowledgeAPI->invalidParameter = '参数 %s 无效。';
$lang->ai->knowledgeAPI->notFound         = '知识库或知识不存在、已删除或未发布。';
$lang->ai->knowledgeAPI->accessDenied     = '无权访问此知识库或知识。';
$lang->ai->knowledgeAPI->searchFailed     = '向量搜索服务请求失败，请稍后重试。';
$lang->ai->knowledgeAPI->methodNotAllowed = '不支持此 HTTP 请求方法。';
