<?php
global $app, $lang;

$account = $app->user->account ?? '';
$now     = helper::now();

$config->ai->form = new stdclass();

$config->ai->form->createPrompt         = array();
$config->ai->form->createPrompt['name'] = array('type' => 'string', 'filter' => 'trim');
$config->ai->form->createPrompt['desc'] = array('type' => 'string', 'filter' => 'trim');

$config->ai->form->promptBasicInfo                    = array();
$config->ai->form->promptBasicInfo['module']          = array('required' => true, 'type' => 'string', 'filter' => 'trim', 'label' => $lang->ai->prompts->processObject);
$config->ai->form->promptBasicInfo['actionPurpose']   = array('required' => true, 'type' => 'string', 'filter' => 'trim', 'label' => $lang->ai->prompts->actionPurpose);
$config->ai->form->promptBasicInfo['displayPosition'] = array('required' => true, 'type' => 'string', 'filter' => 'trim', 'label' => $lang->ai->prompts->displayPosition);
$config->ai->form->promptBasicInfo['name']            = array('required' => true, 'type' => 'string', 'filter' => 'trim', 'control' => 'input', 'label' => $lang->ai->prompts->name);
$config->ai->form->promptBasicInfo['model']           = array('type' => 'string', 'filter' => 'trim');
$config->ai->form->promptBasicInfo['desc']            = array('type' => 'string', 'filter' => 'trim', 'control' => 'textarea');

$config->ai->form->knowledgeLib = new stdclass();

$config->ai->form->knowledgeLib->create                = array();
$config->ai->form->knowledgeLib->create['name']        = array('required' => true, 'type' => 'string', 'label' => $lang->ai->knowledgeLibs->knowledgeLibName);
$config->ai->form->knowledgeLib->create['desc']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->ai->form->knowledgeLib->create['acl']         = array('required' => false, 'type' => 'string', 'default' => 'open');
$config->ai->form->knowledgeLib->create['groups']      = array('type' => 'array', 'required' => false, 'default' => '', 'filter' => 'join');
$config->ai->form->knowledgeLib->create['users']       = array('type' => 'array', 'required' => false, 'default' => '', 'filter' => 'join');
$config->ai->form->knowledgeLib->create['createdBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->ai->form->knowledgeLib->create['createdDate'] = array('required' => false, 'type' => 'date',   'default' => $now);

$config->ai->form->knowledgeLib->edit                = array();
$config->ai->form->knowledgeLib->edit['name']        = array('required' => true, 'type' => 'string', 'label' => $lang->ai->knowledgeLibs->knowledgeLibName);
$config->ai->form->knowledgeLib->edit['desc']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->ai->form->knowledgeLib->edit['acl']         = array('required' => false, 'type' => 'string', 'default' => 'open');
$config->ai->form->knowledgeLib->edit['groups']      = array('type' => 'array', 'required' => false, 'default' => '', 'filter' => 'join');
$config->ai->form->knowledgeLib->edit['users']       = array('type' => 'array', 'required' => false, 'default' => '', 'filter' => 'join');
$config->ai->form->knowledgeLib->edit['editedBy']    = array('required' => false, 'type' => 'string', 'default' => $account);
$config->ai->form->knowledgeLib->edit['editedDate']  = array('required' => false, 'type' => 'date',   'default' => $now);

$config->ai->form->knowledgeLib->importFromDoc = array();
$config->ai->form->knowledgeLib->importFromDoc['importID']    = array('required' => true, 'type' => 'int', 'label' => $lang->ai->knowledgeLibs->selectedDocLibrary);
$config->ai->form->knowledgeLib->importFromDoc['name']        = array('required' => false, 'type' => 'string');
$config->ai->form->knowledgeLib->importFromDoc['createdBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->ai->form->knowledgeLib->importFromDoc['createdDate'] = array('required' => false, 'type' => 'date',   'default' => $now);

$config->ai->form->knowledgeLib->importFromAsset = array();
$config->ai->form->knowledgeLib->importFromAsset['assetType']   = array('required' => true, 'type' => 'string');
$config->ai->form->knowledgeLib->importFromAsset['importID']    = array('required' => true, 'type' => 'int');
$config->ai->form->knowledgeLib->importFromAsset['createdBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->ai->form->knowledgeLib->importFromAsset['createdDate'] = array('required' => false, 'type' => 'date',   'default' => $now);

$config->ai->form->knowledgeLib->search = array();
$config->ai->form->knowledgeLib->search['content'] = array('type' => 'string', 'filter' => 'trim');

$config->ai->form->knowledge = new stdclass();
$config->ai->form->knowledge->createText                = array();
$config->ai->form->knowledge->createText['title']       = array('required' => false, 'type' => 'string', 'filter' => 'trim');
$config->ai->form->knowledge->createText['content']     = array('required' => false, 'type' => 'string', 'default' => '', 'specialchars' => 'no');
$config->ai->form->knowledge->createText['type']        = array('required' => false, 'type' => 'string', 'default' => 'text');
$config->ai->form->knowledge->createText['contentType'] = array('required' => false, 'type' => 'string', 'default' => 'markdown');
$config->ai->form->knowledge->createText['createdBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->ai->form->knowledge->createText['createdDate'] = array('required' => false, 'type' => 'datetime', 'default' => $now);

$config->ai->form->knowledge->editText                = array();
$config->ai->form->knowledge->editText['title']       = array('required' => false, 'type' => 'string', 'filter' => 'trim');
$config->ai->form->knowledge->editText['content']     = array('required' => false, 'type' => 'string', 'default' => '', 'specialchars' => 'no');
$config->ai->form->knowledge->editText['type']        = array('required' => false, 'type' => 'string', 'default' => 'text');
$config->ai->form->knowledge->editText['contentType'] = array('required' => false, 'type' => 'string', 'default' => 'markdown');

$config->ai->form->knowledge->importZentao['type']   = array('type' => 'string', 'filter' => 'trim');
$config->ai->form->knowledge->importZentao['data']   = array('type' => 'string');
$config->ai->form->knowledge->importZentao['idList'] = array('type' => 'string');

$config->ai->form->skill = new stdclass();
$config->ai->form->skill->create['name']     = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->ai->form->skill->create['category'] = array('required' => true,  'type' => 'int');
$config->ai->form->skill->create['desc']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->ai->form->skill->create['status']   = array('required' => false, 'type' => 'string', 'default' => '');
$config->ai->form->skill->create['fromID']   = array('required' => false, 'type' => 'int',    'default' => 0);

$config->ai->form->skill->edit['name']       = array('required' => true,  'type' => 'string', 'filter' => 'trim');
$config->ai->form->skill->edit['category']   = array('required' => true,  'type' => 'int');
$config->ai->form->skill->edit['desc']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->ai->form->skill->edit['status']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->ai->form->skill->edit['editedBy']   = array('required' => false, 'type' => 'string', 'default' => $account);
$config->ai->form->skill->edit['editedDate'] = array('required' => false, 'type' => 'date',   'default' => $now);
