<?php
$config->group->package->manageAITeammate = new stdclass();
$config->group->package->manageAITeammate->order  = 2032;
$config->group->package->manageAITeammate->subset = 'aiapp';
$config->group->package->manageAITeammate->privs  = array();
$config->group->package->manageAITeammate->privs['aiteammate-browse']      = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 10, 'depend' => array(), 'recommend' => array());
$config->group->package->manageAITeammate->privs['aiteammate-create']      = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 15, 'depend' => array('aiteammate-browse'), 'recommend' => array());
$config->group->package->manageAITeammate->privs['aiteammate-edit']        = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 20, 'depend' => array('aiteammate-browse'), 'recommend' => array());
$config->group->package->manageAITeammate->privs['aiteammate-enable']      = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 25, 'depend' => array('aiteammate-browse'), 'recommend' => array());
$config->group->package->manageAITeammate->privs['aiteammate-disable']     = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 30, 'depend' => array('aiteammate-browse'), 'recommend' => array());
$config->group->package->manageAITeammate->privs['aiteammate-delete']      = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 35, 'depend' => array('aiteammate-browse'), 'recommend' => array());
$config->group->package->manageAITeammate->privs['aiteammate-assignagent'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 40, 'depend' => array('ai-promptExecute', 'ai-promptExecutionReset'), 'recommend' => array());

$config->group->package->manageAITask = new stdclass();
$config->group->package->manageAITask->order  = 2033;
$config->group->package->manageAITask->subset = 'aiapp';
$config->group->package->manageAITask->privs  = array();
$config->group->package->manageAITask->privs['aitask-browse'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 10, 'depend' => array(), 'recommend' => array());
$config->group->package->manageAITask->privs['aitask-view']   = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 15, 'depend' => array('aitask-browse'), 'recommend' => array());

$config->group->package->applyAIProcedure = new stdclass();
$config->group->package->applyAIProcedure->order  = 2033;
$config->group->package->applyAIProcedure->subset = 'aiapp';
$config->group->package->applyAIProcedure->privs  = array();
$config->group->package->applyAIProcedure->privs['aiprocedure-workbench'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 10, 'depend' => array(), 'recommend' => array());
$config->group->package->applyAIProcedure->privs['aiprocedure-history']   = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 15, 'depend' => array('aiprocedure-browse'), 'recommend' => array());

$config->group->package->manageAIProcedure = new stdclass();
$config->group->package->manageAIProcedure->order  = 2034;
$config->group->package->manageAIProcedure->subset = 'aiapp';
$config->group->package->manageAIProcedure->privs  = array();
$config->group->package->manageAIProcedure->privs['aiprocedure-browse']    = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 10, 'depend' => array(), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-create']    = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 15, 'depend' => array('aiprocedure-browse'), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-edit']      = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 20, 'depend' => array('aiprocedure-browse'), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-design']    = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 25, 'depend' => array('aiprocedure-browse'), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-view']      = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 26, 'depend' => array('aiprocedure-browse'), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-publish']   = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 30, 'depend' => array('aiprocedure-browse'), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-unpublish'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 35, 'depend' => array('aiprocedure-browse'), 'recommend' => array());
$config->group->package->manageAIProcedure->privs['aiprocedure-delete']    = array('edition' => 'biz,max,ipd', 'vision' => 'rnd', 'order' => 40, 'depend' => array('aiprocedure-browse'), 'recommend' => array());