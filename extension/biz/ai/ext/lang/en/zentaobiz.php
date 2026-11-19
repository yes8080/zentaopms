<?php
$lang->ai->list                             = 'List';
$lang->ai->designPrompt                     = 'Design ZenTao Agent';
$lang->ai->apply                            = 'Apply';
$lang->ai->assistant->createTip             = 'After the configuration is completed, it will be displayed under the AI chat on the client.';
$lang->ai->miniPrograms->downloadTip        = 'After publishing, it will be displayed in the general agent model marketplace, and the client will synchronize updates.';
$lang->ai->miniPrograms->knowledgeLibAdd    = 'Mount Knowledge Library';
$lang->ai->miniPrograms->knowledgeLibAddTip = 'Mount knowledge libraries to enhance general agent capabilities.';
$lang->ai->miniPrograms->skillAdd           = 'Mount Skill';
$lang->ai->miniPrograms->skillAddTip        = 'Mount skills to enhance agent capabilities.';

$lang->ai->configZaiHint = 'Please configure ZAI first';

$lang->ai->prompts->displayPositionDescList = array();
$lang->ai->prompts->displayPositionDescList['detail'] = 'Show the agent entry on object detail pages.';
$lang->ai->prompts->displayPositionDescList['form']   = 'Show the agent entry in create or edit forms.';

$lang->ai->audit = new stdclass();
$lang->ai->audit->designPrompt          = 'Design Prompt';
$lang->ai->audit->afterSave             = 'After Save';
$lang->ai->audit->promptForModel        = 'Input to Model';
$lang->ai->audit->backLocationList      = array();
$lang->ai->audit->backLocationList['0'] = 'Back to Audit Page';
$lang->ai->audit->backLocationList['1'] = 'Back to Audit Page and Re-generate';

if(!isset($lang->ai->knowledgeLibs)) $lang->ai->knowledgeLibs = new stdclass();
$lang->ai->knowledgeLibs->common            = 'Knowledge Library';
$lang->ai->knowledgeLibs->noData            = 'No data.';
$lang->ai->knowledgeLibs->create            = 'Create Knowledge Library';
$lang->ai->knowledgeLibs->myKnowledgeLib    = 'My Knowledge Library';
$lang->ai->knowledgeLibs->teamKnowledgeLib  = 'Team Knowledge Library';
$lang->ai->knowledgeLibs->addFileLabel      = 'Add Local File';

$lang->ai->knowledgeLibs->importActions['doc']    = 'Import from Document Library';
$lang->ai->knowledgeLibs->importActions['asset']  = 'Import from Asset Library';
$lang->ai->knowledgeLibs->importTypes['doclib']   = 'Document Library';
$lang->ai->knowledgeLibs->importTypes['assetlib'] = 'Asset Library';

$lang->ai->knowledgeLibs->customAdd                = 'Custom Add';
$lang->ai->knowledgeLibs->zentaoData               = 'Zentao Data';
$lang->ai->knowledgeLibs->importFromAsset          = 'Import from Asset Library';
$lang->ai->knowledgeLibs->duplicateImport          = 'This %s has already been imported and cannot be imported again.';
$lang->ai->knowledgeLibs->draft                    = 'Draft';
$lang->ai->knowledgeLibs->published                = 'Published';
$lang->ai->knowledgeLibs->unavailable              = 'Unavailable';
$lang->ai->knowledgeLibs->unpublished              = 'Unpublished';
$lang->ai->knowledgeLibs->deleted                  = 'Deleted';
$lang->ai->knowledgeLibs->createdTime              = 'Created: %s';
$lang->ai->knowledgeLibs->confirmPublish           = 'After publishing, the knowledge library can be mounted in intelligent conversations and agents.';
$lang->ai->knowledgeLibs->confirmUnpublish         = 'After unpublishing, the knowledge library will not be available in intelligent conversations and agents. Are you sure you want to unpublish?';
$lang->ai->knowledgeLibs->confirmDelete            = 'Are you sure you want to delete this knowledge library?';
$lang->ai->knowledgeLibs->confirmDeleteFile        = 'Are you sure you want to delete this knowledge?';
$lang->ai->knowledgeLibs->aiChat                   = 'AI Q&A';
$lang->ai->knowledgeLibs->searchTest               = 'Search Test';
$lang->ai->knowledgeLibs->addKnowledge             = 'Add Knowledge';
$lang->ai->knowledgeLibs->viewSourceData           = 'View Source Data';
$lang->ai->knowledgeLibs->selectContent            = 'Please select the content to view';
$lang->ai->knowledgeLibs->AddToKnowledgeLib        = 'Add to Knowledge Library';
$lang->ai->knowledgeLibs->getKnowledgeChunksFailed = 'Failed to get knowledge chunks';
$lang->ai->knowledgeLibs->needSyncKnowledgeItem    = 'Need to sync update knowledge content first.';
$lang->ai->knowledgeLibs->syncingKnowledgeItem     = 'Syncing, please check later.';
$lang->ai->knowledgeLibs->emptyKnowledgeData       = 'No knowledge content.';
$lang->ai->knowledgeLibs->exitSearchTest           = 'Exit Search Test';
$lang->ai->knowledgeLibs->testText                 = 'Test Text';
$lang->ai->knowledgeLibs->inputContent             = 'Input Content';
$lang->ai->knowledgeLibs->lastSyncedTime           = 'Last Synced';
$lang->ai->knowledgeLibs->neverSynced              = 'Never Synced';
$lang->ai->knowledgeLibs->syncFailed               = 'Sync Failed';
$lang->ai->knowledgeLibs->syncFailedHint           = 'Please check the ZAI configuration to ensure the ZAI service is available';
$lang->ai->knowledgeLibs->syncFailedCountAlert     = '%s data synchronization failed, please check the ZAI configuration to ensure the ZAI service is available';
$lang->ai->knowledgeLibs->updateListData           = 'Update List Data';
$lang->ai->knowledgeLibs->syncListToZAI            = 'Sync list data to ZAI';
$lang->ai->knowledgeLibs->syncListToZAIConfirm     = 'Are you sure you want to sync %s items in the current list to the ZAI vector database?';
$lang->ai->knowledgeLibs->noDataNeedToUpdate       = 'No data need to sync';
$lang->ai->knowledgeLibs->syncingData              = 'Syncing data...';
$lang->ai->knowledgeLibs->updateFromSourceData     = 'Update list data from source';
$lang->ai->knowledgeLibs->updateFromSourceConfirm  = 'After updating the list data, the vectorization will be re-performed. Confirm update?';
$lang->ai->knowledgeLibs->cannotExtractFileContent = 'Cannot extract file content';
$lang->ai->knowledgeLibs->fileNotFound             = 'Original file not found';
$lang->ai->knowledgeLibs->emptyKnowledgeContent    = 'Knowledge content is empty, please click "View Source Data" and input content';

$lang->ai->knowledgeLibs->createMyKnowledgeLib        = 'Create My Knowledge Library';
$lang->ai->knowledgeLibs->createTeamKnowledgeLib      = 'Create Team Knowledge Library';
$lang->ai->knowledgeLibs->editMyKnowledgeLib          = 'Edit My Knowledge Library';
$lang->ai->knowledgeLibs->editTeamKnowledgeLib        = 'Edit Team Knowledge Library';
$lang->ai->knowledgeLibs->noKnowledgeLib              = 'Knowledge library not found';
$lang->ai->knowledgeLibs->knowledgeLibName            = 'Knowledge Library Name';
$lang->ai->knowledgeLibs->knowledgeLibDesc            = 'Knowledge Library Description';
$lang->ai->knowledgeLibs->knowledgeLibDescPlaceholder = 'Detailed description of the knowledge library';

$lang->ai->knowledgeLibs->acl                = 'Access Control';
$lang->ai->knowledgeLibs->myPrivateAccess    = 'Private (Only visible to creator)';
$lang->ai->knowledgeLibs->teamPublicAccess   = 'Public (Accessible to users with team KB view permission)';
$lang->ai->knowledgeLibs->teamPrivateAccess  = 'Private (Only visible to creator and whitelist users)';
$lang->ai->knowledgeLibs->defaultAccess      = 'Default (Accessible to users with access control permission of the selected document library)';
$lang->ai->knowledgeLibs->whiteList          = 'Whitelist';
$lang->ai->knowledgeLibs->group              = 'User Group';
$lang->ai->knowledgeLibs->user               = 'User';
$lang->ai->knowledgeLibs->noPrivToView       = 'No permission to view this knowledge library';

$lang->ai->knowledgeLibs->selectedSpace            = 'Select Space';
$lang->ai->knowledgeLibs->space                    = 'Space';
$lang->ai->knowledgeLibs->selectedDocLibrary       = 'Select Document Library';
$lang->ai->knowledgeLibs->selectedAssetType        = 'Select Asset Type';
$lang->ai->knowledgeLibs->selectedAssetLib         = 'Select Asset Library';
$lang->ai->knowledgeLibs->selectKnowledgeLib       = 'Select Knowledge Library';
$lang->ai->knowledgeLibs->knowledgeLibSpace        = 'Knowledge Library Space';
$lang->ai->knowledgeLibs->pleaseSelectKnowledgeLib = 'Please select knowledge library';

$lang->ai->knowledgeLibs->addDoc             = 'Add Document';
$lang->ai->knowledgeLibs->knowledgeTypeName  = 'Knowledge Type';
$lang->ai->knowledgeLibs->customText         = 'Custom Text';
$lang->ai->knowledgeLibs->localFile          = 'Local File';
$lang->ai->knowledgeLibs->file               = 'File';
$lang->ai->knowledgeLibs->creator            = $lang->openedByAB;
$lang->ai->knowledgeLibs->status             = $lang->statusAB;
$lang->ai->knowledgeLibs->category           = 'Category';
$lang->ai->knowledgeLibs->createdDate        = 'Created Date';
$lang->ai->knowledgeLibs->addKnowledgeTip    = 'Add knowledge to your knowledge library';
$lang->ai->knowledgeLibs->noPrivAddKnowledge = 'There is currently no permission to add knowledge. Please contact the administrator to activate it';

$lang->ai->knowledgeLibs->spaces['mine']    = 'My Space';
$lang->ai->knowledgeLibs->spaces['custom']  = 'Team Space';
$lang->ai->knowledgeLibs->spaces['product'] = 'Product Space';
$lang->ai->knowledgeLibs->spaces['project'] = 'Project Space';
$lang->ai->knowledgeLibs->spaces['api']     = 'API Space';

$lang->ai->knowledgeLibs->assets['story']       = 'Story Library';
$lang->ai->knowledgeLibs->assets['case']        = 'Case Library';
$lang->ai->knowledgeLibs->assets['issue']       = 'Issue Library';
$lang->ai->knowledgeLibs->assets['risk']        = 'Risk Library';
$lang->ai->knowledgeLibs->assets['opportunity'] = 'Opportunity Library';
$lang->ai->knowledgeLibs->assets['practice']    = 'Practice Library';
$lang->ai->knowledgeLibs->assets['component']   = 'Component Library';

$lang->ai->knowledgeLibs->objectLabels['feedback']    = 'Feedback';
$lang->ai->knowledgeLibs->objectLabels['ticket']      = 'Ticket';
$lang->ai->knowledgeLibs->objectLabels['issue']       = 'Issue';
$lang->ai->knowledgeLibs->objectLabels['risk']        = 'Risk';
$lang->ai->knowledgeLibs->objectLabels['opportunity'] = 'Opportunity';
$lang->ai->knowledgeLibs->objectLabels['practice']    = 'Best Practice';
$lang->ai->knowledgeLibs->objectLabels['component']   = 'Component';

$lang->ai->knowledgeLibs->knowledgeTypes         = array();
$lang->ai->knowledgeLibs->knowledgeTypes['text'] = array('label' => 'Custom Text', 'icon' => 'file-text', 'action' => 'createtextknowledge');
$lang->ai->knowledgeLibs->knowledgeTypes['file'] = array('label' => 'Local File',  'icon' => 'folder-o',  'action' => 'createfileknowledge');

$lang->ai->knowledgeLibs->knowledgeName      = 'Knowledge Name';
$lang->ai->knowledgeLibs->knowledgeContent   = 'Knowledge Content';
$lang->ai->knowledgeLibs->generateTitleByAI  = 'Generate by AI from content';
$lang->ai->knowledgeLibs->objectTypeList     = '%s List';
$lang->ai->knowledgeLibs->viewContent        = 'View Content';
$lang->ai->knowledgeLibs->confirmBatchDelete = 'Are you sure you want to delete the selected %s?';
$lang->ai->knowledgeLibs->noItemSelected     = 'Please select at least one item';

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

$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['product']   = array(
    'label'  => 'Product Story List',
    'key'    => 'productStory',
    'priv'   => 'productStory',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=story&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['project']   = array(
    'label'  => 'Project Story List',
    'key'    => 'projectStory',
    'priv'   => 'projectStory',
    'module' => 'projectStory',
    'method' => 'story',
    'params' => 'projectID=0&productID=0&branch=&browseTyp=&param=0&storyType=story&orderBy=id_desc&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['execution'] = array(
    'label'  => 'Execution Story List',
    'key'    => 'executionStory',
    'priv'   => 'executionStory',
    'module' => 'execution',
    'method' => 'story',
    'params' => 'executionID=0&storyType=story&orderBy=&type=all&param=0&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['plan']      = array(
    'label'  => 'Plan Story List',
    'key'    => 'planStory',
    'priv'   => 'productplanView',
    'module' => 'productplan',
    'method' => 'story',
    'params' => 'productID=0&planID=0&blockID=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['business']  = array(
    'label'  => 'Epic List',
    'key'    => 'ER',
    'priv'   => 'epicBrowse',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=epic&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['story']['user']      = array(
    'label'  => 'Requirement List',
    'key'    => 'UR',
    'priv'   => 'requirementBrowse',
    'module' => 'product',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&browseType=&param=0&storyType=requirement&orderBy=&recTotal=0&recPerPage=20&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['case']['product']    = array(
    'label'  => 'Product Case List',
    'key'    => 'productCase',
    'priv'   => 'productBug',
    'module' => 'testcase',
    'method' => 'browse',
    'params' => 'productID=0&branch=&browseType=all&param=0&caseType=&orderBy=id_desc&recTotal=0&recPerPage=100&pageID=1&projectID=0&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['case']['caselib']    = array(
    'label'  => 'Case Library List',
    'key'    => 'caselibCase',
    'priv'   => 'productBug',
    'module' => 'caselib',
    'method' => 'browse',
    'params' => 'libID=0&browseType=all&param=0&orderBy=id_desc&recTotal=0&recPerPage=100&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['bug']['product']     = array(
    'label'  => 'Product Bug List',
    'key'    => 'productBug',
    'priv'   => 'productBug',
    'module' => 'bug',
    'method' => 'browse',
    'params' => 'productID=0&branch=&browseType=&param=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['bug']['plan']        = array(
    'label'  => 'Plan Bug List',
    'key'    => 'planBug',
    'priv'   => 'productplanView',
    'module' => 'productplan',
    'method' => 'bug',
    'params' => 'productID=0&planID=0&blockID=0&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['release']['product'] = array(
    'label'  => 'Product Release List',
    'key'    => 'productRelease',
    'priv'   => 'releaseBrowse',
    'module' => 'release',
    'method' => 'browse',
    'params' => 'productID=0&branch=all&type=all&orderBy=&param=0&recTotal=0&recPerPage=20&pageID=1&from=ai'
);
$lang->ai->knowledgeLibs->knowledgeObjectSubTypes['release']['project'] = array(
    'label'  => 'Project Release List',
    'key'    => 'projectRelease',
    'priv'   => 'projectReleaseBrowse',
    'module' => 'projectRelease',
    'method' => 'browse',
    'params' => 'projectID=0&executionID=0&type=all&orderBy=&recTotal=0&recPerPage=20&pageID=1&from=ai'
);

$lang->ai->featureBar['myknowledgelib']['']  = $lang->all;
$lang->ai->featureBar['myknowledgelib']['1'] = $lang->ai->knowledgeLibs->published;
$lang->ai->featureBar['myknowledgelib']['0'] = $lang->ai->knowledgeLibs->draft;

$lang->ai->featureBar['teamknowledgelib'] = $lang->ai->featureBar['myknowledgelib'];

$lang->ai->featureBar['adddoc']['all']   = 'All';
$lang->ai->featureBar['adddoc']['draft'] = 'Draft';

$lang->ai->knowledgeLibs->importType    = 'Import Type';

$lang->ai->knowledgeLibs->categoryList = array();
$lang->ai->knowledgeLibs->categoryList['']       = '';
$lang->ai->knowledgeLibs->categoryList['custom'] = 'Custom';
$lang->ai->knowledgeLibs->categoryList['doclib'] = 'Document Import';

$lang->ai->knowledgeLibs->importTypeList = array();
$lang->ai->knowledgeLibs->importTypeList['']       = '';
$lang->ai->knowledgeLibs->importTypeList['custom'] = $lang->ai->knowledgeLibs->customAdd;
$lang->ai->knowledgeLibs->importTypeList['doclib'] = 'Document Library';
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
$lang->ai->knowledgeLibs->columnName['default']['id']               = 'ID';
$lang->ai->knowledgeLibs->columnName['default']['title']            = 'Title';
$lang->ai->knowledgeLibs->columnName['doc']['title']                = 'Name';
$lang->ai->knowledgeLibs->columnName['doc']['addedByAB']            = 'CreatedBy';
$lang->ai->knowledgeLibs->columnName['doc']['addedDate']            = 'CreatedDate';
$lang->ai->knowledgeLibs->columnName['doc']['editedBy']             = 'UpdatedBy';
$lang->ai->knowledgeLibs->columnName['doc']['editedDate']           = 'UpdatedDate';
$lang->ai->knowledgeLibs->columnName['issue']['title']              = 'Issue Name';
$lang->ai->knowledgeLibs->columnName['issue']['pri']                = 'P';
$lang->ai->knowledgeLibs->columnName['issue']['severity']           = 'Severity';
$lang->ai->knowledgeLibs->columnName['issue']['status']             = 'Status';
$lang->ai->knowledgeLibs->columnName['issue']['issueType']          = 'Type';
$lang->ai->knowledgeLibs->columnName['issue']['assetCreatedBy']     = 'Created By';
$lang->ai->knowledgeLibs->columnName['issue']['assetCreatedDate']   = 'Created Date';
$lang->ai->knowledgeLibs->columnName['issue']['assignedTo']         = 'Approved';
$lang->ai->knowledgeLibs->columnName['issue']['approvedDate']       = 'Approved Date';
$lang->ai->knowledgeLibs->columnName['risk']['title']               = 'Name';
$lang->ai->knowledgeLibs->columnName['risk']['pri']                 = 'P';
$lang->ai->knowledgeLibs->columnName['risk']['status']              = 'Status';
$lang->ai->knowledgeLibs->columnName['risk']['strategy']            = 'Strategy';
$lang->ai->knowledgeLibs->columnName['risk']['assetCreatedBy']      = 'Created By';
$lang->ai->knowledgeLibs->columnName['risk']['assetCreatedDate']    = 'Created Date';
$lang->ai->knowledgeLibs->columnName['risk']['assignedTo']          = 'Approved';
$lang->ai->knowledgeLibs->columnName['risk']['approvedDate']        = 'Approved Date';

$lang->ai->knowledgeLibs->columnName['opportunity']['name']             = 'Name';
$lang->ai->knowledgeLibs->columnName['opportunity']['pri']              = 'P';
$lang->ai->knowledgeLibs->columnName['opportunity']['status']           = 'Status';
$lang->ai->knowledgeLibs->columnName['opportunity']['opportunityType']  = 'Type';
$lang->ai->knowledgeLibs->columnName['opportunity']['assetCreatedBy']   = 'Created By';
$lang->ai->knowledgeLibs->columnName['opportunity']['assetCreatedDate'] = 'Created Date';
$lang->ai->knowledgeLibs->columnName['opportunity']['assignedTo']       = 'Approved';
$lang->ai->knowledgeLibs->columnName['opportunity']['approvedDate']     = 'Approved Date';

/* 知识库对象列表 - 枚举映射配置 */
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['high']   = 'High';
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['middle'] = 'Medium';
$lang->ai->knowledgeLibs->columnValueMap['risk']['pri']['low']    = 'Low';

$lang->ai->knowledgeLibs->columnValueMap['issue']['severity'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['0'] = '';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['1'] = '1';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['2'] = '2';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['3'] = '3';
$lang->ai->knowledgeLibs->columnValueMap['issue']['severity']['4'] = '4';

$lang->ai->knowledgeLibs->columnValueMap['issue']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['status']['active'] = 'Inlib';
$lang->ai->knowledgeLibs->columnValueMap['issue']['status']['draft']  = 'Pending';

$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType'] = array();
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['']             = '';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['design']       = 'Design';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['code']         = 'Code';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['performance']  = 'Performance';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['version']      = 'Version';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storyadd']     = 'New Story';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storychanged'] = 'Story Change';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['storyremoved'] = 'Story Deleted';
$lang->ai->knowledgeLibs->columnValueMap['issue']['issueType']['data']         = 'Data';

$lang->ai->knowledgeLibs->columnValueMap['risk']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['status']['active'] = 'Inlib';
$lang->ai->knowledgeLibs->columnValueMap['risk']['status']['draft']  = 'Pending';

$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy'] = array();
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['']             = '';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['avoidance']    = 'Avoidance';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['mitigation']   = 'Mitigation';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['transference'] = 'Transfer';
$lang->ai->knowledgeLibs->columnValueMap['risk']['strategy']['acceptance']   = 'Acceptance';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['high']   = 'High';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['middle'] = 'Medium';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['pri']['low']    = 'Low';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status']['active'] = 'Inlib';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['status']['draft']  = 'Pending';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['']            = '';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['technical']   = 'Technology';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['manage']      = 'Management';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['business']    = 'Business';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['requirement'] = 'Requirement';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['resource']    = 'Resource';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['opportunityType']['others']      = 'Other';

$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy'] = array();
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['']        = '';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['monitor'] = 'Monitor';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['create']  = 'Create';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['utilize'] = 'Utilize';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['enhance'] = 'Enhance';
$lang->ai->knowledgeLibs->columnValueMap['opportunity']['strategy']['accept']  = 'Accept';

if(!isset($lang->ai->knowledgeLibs->tips)) $lang->ai->knowledgeLibs->tips = new stdclass();
$lang->ai->knowledgeLibs->tips->emptyFile  = 'Please select a file to upload';
$lang->ai->knowledgeLibs->tips->file       = 'Click to add to upload. Supports PDF, WORD, PPT, EXCEL, TXT, MD, JSON, YAML up to %s';
$lang->ai->knowledgeLibs->tips->searchTest = 'Please enter the test content and view the test results.';
$lang->ai->knowledgeLibs->tips->nameRepeat = 'The knowledge Library name already has a record of %s.';

$lang->ai->browseMyknowledgeLib        = 'Browse My Knowledge Library List';
$lang->ai->browseTeamknowledgeLib      = 'Browse Team Knowledge Library List';
$lang->ai->createKnowledgelibAction    = 'Create Knowledge Library';
$lang->ai->importFromDocAction         = 'Import Knowledge Library from Document Library';
$lang->ai->importFromAssetAction       = 'Import Knowledge Library from Asset Library';
$lang->ai->editKnowledgelibAction      = 'Edit Knowledge Library';
$lang->ai->publishKnowledgelibAction   = 'Publish Knowledge Library';
$lang->ai->unpublishKnowledgelibAction = 'Unpublish Knowledge Library';
$lang->ai->deleteKnowledgelibAction    = 'Delete Knowledge Library';
$lang->ai->searchKnowledgelibAction    = 'Search Test';
$lang->ai->searchKnowledgelibCheck     = 'Check';
$lang->ai->aiChatWithKnowledgeLib      = 'AI Q&A';
$lang->ai->createKnowledgeAction       = 'Add Knowledge';
$lang->ai->deleteKnowledgeAction       = 'Delete Knowledge';
$lang->ai->editKnowledgeAction         = 'Edit Knowledge';

$lang->ai->browseskillAction       = 'Browse Skills';
$lang->ai->myskillAction           = 'Browse My Skills';
$lang->ai->editskillcategory       = 'Manage Skill Categories';
$lang->ai->createsquareskill       = 'Upload Skill';
$lang->ai->createmyskill           = 'Upload Skill';
$lang->ai->editsquareskill         = 'Edit Skill';
$lang->ai->editmyskill             = 'Edit Skill';
$lang->ai->viewsquareskill         = 'View Skill';
$lang->ai->viewmyskill             = 'View Skill';
$lang->ai->deleteskill             = 'Delete Skill';
$lang->ai->deletesquareskill       = 'Delete Skill';
$lang->ai->addskill                = 'Add to My Skills';
$lang->ai->removeskill             = 'Remove Skill';
$lang->ai->publishskill            = 'Enable Skill';
$lang->ai->disableskill            = 'Disable Skill';
$lang->ai->releaseskilltosquare    = 'Publish to Skill Square';
$lang->ai->releaseskill            = 'Release Skill';
$lang->ai->disablesquareskill      = 'Offline Skill';

if(!isset($lang->ai->skills)) $lang->ai->skills = new stdclass();
$lang->ai->skills->common                 = 'Skill';
$lang->ai->skills->browse                 = 'Skill Square';
$lang->ai->skills->create                 = 'Upload';
$lang->ai->skills->edit                   = 'Edit';
$lang->ai->skills->view                   = 'View Skill';
$lang->ai->skills->delete                 = 'Delete';
$lang->ai->skills->release                = 'Release';
$lang->ai->skills->releaseToSquare        = 'Publish to Skill Square';
$lang->ai->skills->add                    = 'Add to My Skills';
$lang->ai->skills->added                  = 'Added';
$lang->ai->skills->remove                 = 'Remove';
$lang->ai->skills->publish                = 'Publish';
$lang->ai->skills->disable                = 'Offline';
$lang->ai->skills->stop                   = 'Disable';
$lang->ai->skills->offline                = 'Offline';
$lang->ai->skills->confirmDisable         = 'Are you sure you want to disable this skill? Other users and agents cannot use it after disabling.';
$lang->ai->skills->confirmStop            = 'Are you sure you want to disable this skill? Agents cannot use it after disabling.';
$lang->ai->skills->confirmReleaseToSquare = 'After release, this skill can only be maintained in Skill Square. Are you sure you want to upload it?';
$lang->ai->skills->confirmRemove          = 'Are you sure you want to remove this skill from My Skills?';
$lang->ai->skills->name                   = 'Name';
$lang->ai->skills->category               = 'Category';
$lang->ai->skills->maintenanceCategory    = 'Manage Skill Categories';
$lang->ai->skills->source                 = 'Source';
$lang->ai->skills->square                 = 'Skill Square';
$lang->ai->skills->desc                   = 'Description';
$lang->ai->skills->status                 = 'Status';
$lang->ai->skills->createdBy              = 'Created By';
$lang->ai->skills->createdDate            = 'Created Date';
$lang->ai->skills->editedBy               = 'Edited By';
$lang->ai->skills->editedDate             = 'Edited Date';
$lang->ai->skills->lastUpdate             = 'Last update: %s';
$lang->ai->skills->emptyList              = 'No skills.';
$lang->ai->skills->myEmptyList            = 'No skills yet. You can add skills from Skill Square or create a skill.';
$lang->ai->skills->squareEmptyList        = 'No skills yet.';

$lang->ai->skills->statusList = array();
$lang->ai->skills->statusList['']       = 'All';
$lang->ai->skills->statusList['draft']  = 'Unpublished';
$lang->ai->skills->statusList['active'] = 'Published';

$lang->ai->skills->myStatusList = array();
$lang->ai->skills->myStatusList['draft']   = 'Disabled';
$lang->ai->skills->myStatusList['active']  = 'Enabled';
$lang->ai->skills->myStatusList['offline'] = 'Offline';

$lang->ai->skills->squareStatusList = array();
$lang->ai->skills->squareStatusList['draft']  = 'Unpublished';
$lang->ai->skills->squareStatusList['active'] = 'Published';

$lang->ai->skills->selectFromSquare   = 'Select Skill from Skill Market';
$lang->ai->skills->searchPlaceholder  = 'Search skill name...';
$lang->ai->skills->use                = 'Use';
$lang->ai->skills->selected           = 'Selected';

$lang->ai->skills->uploadFile = 'Upload File';
$lang->ai->skills->skillFiles = 'Skill Files';
$lang->ai->skills->labelBasic = 'Basic Information';

$lang->ai->skills->tips = new stdclass();
$lang->ai->skills->tips->emptyFile     = 'Please select a file to upload';
$lang->ai->skills->tips->noSkillMd     = 'The zip package does not contain the SKILL.md file, please verify and upload again';
$lang->ai->skills->tips->uploadFileTip = 'Only zip packages can be uploaded, and the zip package must contain the SKILL.md file';
$lang->ai->skills->tips->nameRepeat    = 'The skill name already exists, please use another name';

$lang->ai->featureBar['browseskill']['']            = 'All';
$lang->ai->featureBar['browseskill']['draft']       = 'Unpublished';
$lang->ai->featureBar['browseskill']['active']      = 'Active';
$lang->ai->featureBar['browseskill']['createdByMe'] = 'Uploaded by me';

$lang->ai->featureBar['myskill'] = array();
$lang->ai->featureBar['myskill']['']        = 'All';
$lang->ai->featureBar['myskill']['draft']   = 'Disabled';
$lang->ai->featureBar['myskill']['active']  = 'Enabled';
$lang->ai->featureBar['myskill']['offline'] = 'Offline';

/* Timer agent. */
$lang->ai->agentType = new stdclass();
$lang->ai->agentType->normal = 'normal';
$lang->ai->agentType->timer  = 'timer';

$lang->ai->timer = new stdclass();
$lang->ai->timer->common             = 'Scheduled Agent';
$lang->ai->timer->create             = 'Create Scheduled Agent';
$lang->ai->timer->tag                = 'Scheduled';
$lang->ai->timer->operation          = 'Operation';
$lang->ai->timer->cycleType          = 'Cycle Type';
$lang->ai->timer->cycleConfig        = 'Cycle Settings';
$lang->ai->timer->notifyRoles        = 'Notify People';
$lang->ai->timer->notifyUsers        = 'Specific Users';
$lang->ai->timer->notifyRoleGroup    = 'Roles';
$lang->ai->timer->notifyUserGroup    = 'Users';
$lang->ai->timer->notifyMethods      = 'Notify Methods';
$lang->ai->timer->timerLog           = 'Schedule Logs';
$lang->ai->timer->emptyLog           = 'No schedule logs yet';
$lang->ai->timer->logSummary         = 'Processed %s object(s), failed: %s';
$lang->ai->timer->logCycle           = 'Success %s, failed %s';
$lang->ai->timer->notifyRequired     = 'Notify roles/users and methods are required for notification';
$lang->ai->timer->operationDenied    = 'This operation is not allowed for current edition or object';
$lang->ai->timer->editionDenied      = 'Scheduled agents are not available in current edition';
$lang->ai->timer->messageNotice      = 'The message content will be sent according to the content generated by AI, please configure the content you want to generate in the prompt setting.';
$lang->ai->timer->cycleDayFrom       = 'from %s';
$lang->ai->timer->cycleDayInterval   = 'every %s day(s)';
$lang->ai->timer->cycleMonthDay      = 'day %s';

$lang->ai->timer->moduleList = array();
$lang->ai->timer->moduleList['project'] = 'Project';

$lang->ai->timer->operationList = array();
$lang->ai->timer->operationList['notify'] = 'Send Notification';

global $config;
if($config->edition != 'biz')
{
    $lang->ai->timer->operationList['report'] = 'Output Report';
    $lang->ai->timer->operationList['risk']   = 'Create Risk';
}

$lang->ai->timer->cycleTypeList = array();
$lang->ai->timer->cycleTypeList['day']   = 'Daily';
$lang->ai->timer->cycleTypeList['week']  = 'Weekly';
$lang->ai->timer->cycleTypeList['month'] = 'Monthly';

$lang->ai->timer->notifyMethodList = array();
$lang->ai->timer->notifyMethodList['mail']    = 'Mail';
$lang->ai->timer->notifyMethodList['message'] = 'Message';
$lang->ai->timer->notifyMethodList['webhook'] = 'Webhook';

$lang->ai->timer->notifyRoleList = array();
$lang->ai->timer->notifyRoleList['createdBy']   = 'Project Creator';
$lang->ai->timer->notifyRoleList['PM']          = 'Project Manager';
//$lang->ai->timer->notifyRoleList['assignedTo']  = 'Assignee';
//$lang->ai->timer->notifyRoleList['mailto']      = 'Mailto';
//$lang->ai->timer->notifyRoleList['PO']          = 'Product Owner';
//$lang->ai->timer->notifyRoleList['QD']          = 'QA Director';
//$lang->ai->timer->notifyRoleList['RD']          = 'Release Director';
//$lang->ai->timer->notifyRoleList['feedback']    = 'Feedback Owner';
//$lang->ai->timer->notifyRoleList['ticket']      = 'Ticket Owner';
//$lang->ai->timer->notifyRoleList['executionPM'] = 'Execution Manager';

$lang->ai->timer->promptTemplate = array();
$lang->ai->timer->promptTemplate['notify'] = <<<EOT
Check the project by the rules: [check content/metrics].

Notification requirements:

Title: "[severity] + event", within 15 characters;

Body follows "what happened → impact → data → suggestion"; include time, object, data, impact, and suggestion;

Bold key numbers; mark unconfirmed information; do not invent data.

Notification example: [notification content]
EOT;
$lang->ai->timer->promptTemplate['report'] = <<<EOT
Create a report under the project, and analyze and output according to the following rules:

[Project overview]: show a summary of executions, stories, tasks, and bugs under the project. If there are active risks, list them.

[Title]: data and rules to show, expected format and font style, and how to handle special cases.

[Important]: output in markdown format, important information in bold.

EOT;
$lang->ai->timer->promptTemplate['risk'] = <<<EOT
Check risks of in-progress projects: [check content/metrics].

Risk requirements:

Name: one-sentence description, suggested format "object + potential event + consequence", e.g. "Core developer resignation causes Sprint 2 delay"

Priority: 1(High) / 2(Medium) / 3(Low)

Probability: 1 / 2 / 3 / 4 / 5

Impact: 1 / 2 / 3 / 4 / 5

Risk score: Probability * Impact

Response: specific action plan, owner, and deadline; required for high/medium risks

Assigned to: specify the risk owner (user account); required for high/medium risks

Planned close date: YYYY-MM-DD format; required for high risks, recommended for medium risks
EOT;

$lang->ai->designStepNavTimer = array();
$lang->ai->designStepNavTimer['basicinfo'] = 'Basic Info';
$lang->ai->designStepNavTimer['setprompt'] = 'Set Prompt';
$lang->ai->designStepNavTimer['preview']   = 'Preview';

$lang->ai->operation = $lang->ai->timer->operation;

$lang->ai->knowledgeAPI = new stdclass();
$lang->ai->knowledgeAPI->invalidParameter = 'Invalid parameter: %s.';
$lang->ai->knowledgeAPI->notFound         = 'The knowledge library or item does not exist, is deleted, or is unpublished.';
$lang->ai->knowledgeAPI->accessDenied     = 'Access to this knowledge library or item is denied.';
$lang->ai->knowledgeAPI->searchFailed     = 'The vector search service failed. Please try again later.';
$lang->ai->knowledgeAPI->methodNotAllowed = 'This HTTP request method is not supported.';
