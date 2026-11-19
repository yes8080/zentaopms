<?php
$config->group->package->taskAutoSchedule = new stdclass();
$config->group->package->taskAutoSchedule->order  = 20;
$config->group->package->taskAutoSchedule->subset = 'task';
$config->group->package->taskAutoSchedule->privs  = array();
$config->group->package->taskAutoSchedule->privs['task-autoschedule'] = array('edition' => 'max,ipd', 'vision' => 'rnd', 'order' => 1, 'depend' => array('execution-task'), 'recommend' => array());

$config->group->package->executionAutoSchedule = new stdclass();
$config->group->package->executionAutoSchedule->order  = 40;
$config->group->package->executionAutoSchedule->subset = 'executionview';
$config->group->package->executionAutoSchedule->privs  = array();
$config->group->package->executionAutoSchedule->privs['execution-taskAutoSchedule'] = array('edition' => 'max,ipd', 'vision' => 'rnd', 'order' => 1, 'depend' => array('execution-gantt'), 'recommend' => array());

$config->group->package->projectAutoSchedule = new stdclass();
$config->group->package->projectAutoSchedule->order  = 15;
$config->group->package->projectAutoSchedule->subset = 'programplan';
$config->group->package->projectAutoSchedule->privs  = array();
$config->group->package->projectAutoSchedule->privs['programplan-taskAutoSchedule'] = array('edition' => 'max,ipd', 'vision' => 'rnd', 'order' => 1, 'depend' => array('programplan-browse'), 'recommend' => array());

$config->group->subset->art = new stdclass();
$config->group->subset->art->order = 91;
$config->group->subset->art->nav   = 'safe';

$config->group->package->browseArt = new stdclass();
$config->group->package->browseArt->order  = 5;
$config->group->package->browseArt->subset = 'art';
$config->group->package->browseArt->privs  = array();
$config->group->package->browseArt->privs['art-browse'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0, 'depend' => array(), 'recommend' => array('art-edit', 'art-close', 'art-activate'));

$config->group->package->manageArt = new stdclass();
$config->group->package->manageArt->order  = 10;
$config->group->package->manageArt->subset = 'art';
$config->group->package->manageArt->privs  = array();
$config->group->package->manageArt->privs['art-create']   = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0, 'depend' => array('art-browse'), 'recommend' => array());
$config->group->package->manageArt->privs['art-edit']     = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 1, 'depend' => array('art-browse'), 'recommend' => array());
$config->group->package->manageArt->privs['art-view']     = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 2, 'depend' => array('art-browse'), 'recommend' => array('art-edit', 'art-delete', 'art-close', 'art-activate'));
$config->group->package->manageArt->privs['art-close']    = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 3, 'depend' => array('art-browse'), 'recommend' => array());
$config->group->package->manageArt->privs['art-activate'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 4, 'depend' => array('art-browse'), 'recommend' => array());
$config->group->package->manageArt->privs['art-delete']   = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 5, 'depend' => array('art-browse'), 'recommend' => array());

$config->group->subset->pi = new stdclass();
$config->group->subset->pi->order = 92;
$config->group->subset->pi->nav   = 'safe';

$config->group->package->piBrowse = new stdclass();
$config->group->package->piBrowse->order  = 5;
$config->group->package->piBrowse->subset = 'pi';
$config->group->package->piBrowse->privs  = array();
$config->group->package->piBrowse->privs['pi-browse']  = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0, 'depend' => array(), 'recommend' => array('pi-edit', 'pi-close', 'pi-activate', 'pi-delete'));
$config->group->package->piBrowse->privs['pi-team']    = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 2, 'depend' => array('pi-browse'), 'recommend' => array('pi-linkStory'));
$config->group->package->piBrowse->privs['pi-plan']    = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 3, 'depend' => array('pi-browse'), 'recommend' => array('pi-createLane', 'pi-editLane', 'pi-deleteLane', 'pi-createCard', 'pi-editCard', 'pi-viewCard', 'pi-deleteCard'));

$config->group->package->managePI = new stdclass();
$config->group->package->managePI->order  = 10;
$config->group->package->managePI->subset = 'pi';
$config->group->package->managePI->privs  = array();
$config->group->package->managePI->privs['pi-create']   = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->managePI->privs['pi-edit']     = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 1, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->managePI->privs['pi-close']    = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 2, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->managePI->privs['pi-activate'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 3, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->managePI->privs['pi-delete']   = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 4, 'depend' => array('pi-browse'), 'recommend' => array());

$config->group->package->piKanban = new stdclass();
$config->group->package->piKanban->order  = 15;
$config->group->package->piKanban->subset = 'pi';
$config->group->package->piKanban->privs  = array();
$config->group->package->piKanban->privs['pi-setKanban']       = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-moveCard']        = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 1,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-setCapacity']     = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 2,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-createLane']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 4,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-editLane']        = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 5,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-deleteLane']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 6,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-createCard']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 7,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-editCard']        = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 8,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-viewCard']        = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 9,  'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-finishCard']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 10, 'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-activateCard']    = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 11, 'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-deleteCard']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 12, 'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-linkStory']       = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 13, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-unlinkStory']     = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 14, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-linkCard']        = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 16, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-unlinkCard']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 17, 'depend' => array('pi-browse'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-createMilestone'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 18, 'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-editMilestone']   = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 19, 'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());
$config->group->package->piKanban->privs['pi-deleteMilestone'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 20, 'depend' => array('pi-browse', 'pi-plan'), 'recommend' => array());

$config->group->subset->team = new stdclass();
$config->group->subset->team->order = 93;
$config->group->subset->team->nav   = 'safe';

$config->group->package->browseTeam = new stdclass();
$config->group->package->browseTeam->order  = 5;
$config->group->package->browseTeam->subset = 'team';
$config->group->package->browseTeam->privs  = array();
$config->group->package->browseTeam->privs['team-browse'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0, 'depend' => array(), 'recommend' => array());

$config->group->package->manageTeam = new stdclass();
$config->group->package->manageTeam->order  = 10;
$config->group->package->manageTeam->subset = 'team';
$config->group->package->manageTeam->privs  = array();
$config->group->package->manageTeam->privs['team-create']       = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 0,  'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-edit']         = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 5,  'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-delete']       = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 10, 'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-view']         = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 15, 'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-enable']       = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 20, 'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-disband']      = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 25, 'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-addMember']    = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 30, 'depend' => array('team-browse'), 'recommend' => array());
$config->group->package->manageTeam->privs['team-removeMember'] = array('edition' => 'open,biz,max,ipd', 'vision' => 'rnd', 'order' => 35, 'depend' => array('team-browse'), 'recommend' => array());
