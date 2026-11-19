<?php
$config->group->package->browseProject->privs['project-executionreport'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite', 'order' => 170, 'depend' => array('project-execution'), 'recommend' => array());

$config->group->package->projectTesting->privs['testcase-report'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite', 'order' => 160, 'depend' => array('project-testcase'), 'recommend' => array());
$config->group->package->projectTesting->privs['project-reportBug'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite', 'order' => 170, 'depend' => array('project-bug'), 'recommend' => array());

$config->group->package->executionTesting->privs['execution-reportBug'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite', 'order' => 160, 'depend' => array('execution-bug'), 'recommend' => array());

$config->group->package->alert = new stdclass();
$config->group->package->alert->order  = 45;
$config->group->package->alert->subset = 'featureconfig';
$config->group->package->alert->privs  = array();
$config->group->package->alert->privs['alert-browse']  = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite,or', 'order' => 1, 'depend' => array(), 'recommend' => array());
$config->group->package->alert->privs['alert-create']  = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite,or', 'order' => 5, 'depend' => array('alert-browse'), 'recommend' => array());
$config->group->package->alert->privs['alert-edit']    = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite,or', 'order' => 10, 'depend' => array('alert-browse'), 'recommend' => array());
$config->group->package->alert->privs['alert-enable']  = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite,or', 'order' => 15, 'depend' => array('alert-browse'), 'recommend' => array());
$config->group->package->alert->privs['alert-disable'] = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite,or', 'order' => 20, 'depend' => array('alert-browse'), 'recommend' => array());
$config->group->package->alert->privs['alert-delete']  = array('edition' => 'biz,max,ipd', 'vision' => 'rnd,lite,or', 'order' => 25, 'depend' => array('alert-browse'), 'recommend' => array());