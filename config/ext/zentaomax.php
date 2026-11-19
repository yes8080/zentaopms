<?php
$config->maxVersion = '8.7';

$config->objectTables['art']                    = TABLE_ART;
$config->objectTables['auditcl']                = TABLE_AUDITCL;
$config->objectTables['review']                 = TABLE_REVIEW;
$config->objectTables['budget']                 = TABLE_BUDGET;
$config->objectTables['risk']                   = TABLE_RISK;
$config->objectTables['issue']                  = TABLE_ISSUE;
$config->objectTables['design']                 = TABLE_DESIGN;
$config->objectTables['opportunity']            = TABLE_OPPORTUNITY;
$config->objectTables['teamgroup']              = TABLE_TEAMGROUP;
$config->objectTables['trainplan']              = TABLE_TRAINPLAN;
$config->objectTables['gapanalysis']            = TABLE_GAPANALYSIS;
$config->objectTables['reviewissue']            = TABLE_REVIEWISSUE;
$config->objectTables['researchplan']           = TABLE_RESEARCHPLAN;
$config->objectTables['researchreport']         = TABLE_RESEARCHREPORT;
$config->objectTables['meeting']                = TABLE_MEETING;
$config->objectTables['meetingroom']            = TABLE_MEETINGROOM;
$config->objectTables['assetlib']               = TABLE_ASSETLIB;
$config->objectTables['auditplan']              = TABLE_AUDITPLAN;
$config->objectTables['auditresult']            = TABLE_AUDITRESULT;
$config->objectTables['nc']                     = TABLE_NC;
$config->objectTables['pssp']                   = TABLE_PROJECT;
$config->objectTables['reviewcl']               = TABLE_REVIEWCL;
$config->objectTables['cmcl']                   = TABLE_CMCL;
$config->objectTables['process']                = TABLE_PROCESS;
$config->objectTables['activity']               = TABLE_ACTIVITY;
$config->objectTables['zoutput']                = TABLE_ZOUTPUT;
$config->objectTables['basicmeas']              = TABLE_BASICMEAS;
$config->objectTables['measurement']            = TABLE_BASICMEAS;
$config->objectTables['sqlview']                = TABLE_SQLVIEW;
$config->objectTables['approvalnode']           = TABLE_APPROVALNODE;
$config->objectTables['rule']                   = TABLE_RULE;
$config->objectTables['baseline']               = TABLE_OBJECT;
$config->objectTables['reporttemplate']         = TABLE_DOC;
$config->objectTables['reporttemplatecategory'] = TABLE_MODULE;
$config->objectTables['weekly']                 = TABLE_DOC;
$config->objectTables['reportcategory']         = TABLE_MODULE;
$config->objectTables['projectdeliverable']     = TABLE_PROJECTDELIVERABLE;
$config->objectTables['teamgroup']              = TABLE_TEAMGROUP;
$config->objectTables['pi']                     = TABLE_PI;
$config->objectTables['piexecution']            = TABLE_PIEXECUTION;
$config->objectTables['pistory']                = TABLE_PISTORY;
$config->objectTables['picard']                 = TABLE_KANBANCARD;
$config->objectTables['objective']              = TABLE_OBJECTIVE;
$config->objectTables['piteam']                 = TABLE_PI;
$config->objectTables['piplan']                 = TABLE_PI;

$config->projectModules = 'story,product,bug,task,project,flow,repo,productplan,release,testcase,testtask,testreport,testsuite,deploy,doc';

$filter->assetlib = new stdclass();
$filter->assetlib->story = new stdclass();
$filter->assetlib->story->cookie['storyViewType'] = 'code';

$filter->project->burn = new stdclass();
$filter->project->burn->cookie['burnBy'] = 'code';

if(!isset($filter->project->default)) $filter->project->default = new stdclass();
$filter->project->default->cookie['copyData'] = 'reg::any';

$filter->product->burn = new stdclass();
$filter->product->burn->cookie['leftProjects'] = 'code';

$filter->pi = new stdclass();
$filter->pi->plan = new stdclass();
$filter->pi->team = new stdclass();
$filter->pi->plan->cookie['planCardSize'] = 'reg::any';
$filter->pi->team->cookie['teamCardSize'] = 'reg::any';

$config->excludeFlows = array();

$config->hourPointCommonList['zh-cn'][2] = '功能点';
$config->hourPointCommonList['zh-tw'][2] = '功能點';
$config->hourPointCommonList['en'][2]    = 'function point';
$config->hourPointCommonList['de'][2]    = 'function point';
$config->hourPointCommonList['fr'][2]    = 'function point';

$config->hourPointCommonList['zh-cn'][3] = '代码行';
$config->hourPointCommonList['zh-tw'][3] = '代码行';
$config->hourPointCommonList['en'][3]    = 'loc';
$config->hourPointCommonList['de'][3]    = 'loc';
$config->hourPointCommonList['fr'][3]    = 'loc';

if(!isset($filter->custom)) $filter->custom = new stdclass();
$filter->custom->setcmmi = new stdclass();
$filter->custom->setcmmi->cookie['systemModel'] = 'code';
$filter->custom->setscrum = new stdclass();
$filter->custom->setscrum->cookie['sytemModel'] = 'code';

$filter->risk                = new stdclass();
$filter->opportunity         = new stdclass();
$filter->product->submit     = new stdclass();
$filter->story->submit       = new stdclass();
$filter->testcase->submit    = new stdclass();
$filter->risk->export        = new stdclass();
$filter->opportunity->export = new stdclass();
$filter->default->cookie['hideMenu']                = 'equal::true';
$filter->product->submit->cookie['checkedItem']     = 'reg::checked';
$filter->story->submit->cookie['checkedItem']       = 'reg::checked';
$filter->testcase->submit->cookie['checkedItem']    = 'reg::any';
$filter->risk->export->cookie['checkedItem']        = 'reg::checked';
$filter->opportunity->export->cookie['checkedItem'] = 'reg::checked';

$filter->issue = new stdclass();
$filter->issue->export = new stdclass();
$filter->issue->export->cookie['checkedItem'] = 'reg::checked';

$filter->activity = new stdclass();
$filter->activity->create      = new stdclass();
$filter->activity->batchcreate = new stdclass();
$filter->activity->create->cookie['pagerActivityBrowse']      = 'int';
$filter->activity->batchcreate->cookie['pagerActivityBrowse'] = 'int';

$filter->my->work->cookie['pagerMyIssue']     = 'int';
$filter->my->work->cookie['pagerMyRisk']      = 'int';
$filter->my->work->cookie['pagerMyAudit']     = 'int';
$filter->my->work->cookie['pagerMyMymeeting'] = 'int';

$filter->my->contribute->cookie['pagerMyIssue'] = 'int';
$filter->my->contribute->cookie['pagerMyRisk']  = 'int';
$filter->my->contribute->cookie['pagerMyAudit'] = 'int';

$filter->weekly = new stdclass();
$filter->weekly->browse = new stdclass();
$filter->weekly->browse->cookie['weeklyModule'] = 'reg::word';
$filter->weekly->browse->cookie['preProjectID'] = 'int';

/* 登录用户可以访问的方法。The methods that can be accessed by the logged users. */
$config->logonMethods[] = 'project.copyconfirm';
$config->logonMethods[] = 'project.copyproject';
$config->logonMethods[] = 'assetlib.view';
$config->logonMethods[] = 'approval.revert';
$config->logonMethods[] = 'approval.addnode';
$config->logonMethods[] = 'approval.forward';
$config->logonMethods[] = 'review.book';
$config->logonMethods[] = 'doc.selecttemplate';
$config->logonMethods[] = 'rulequeue.run';
$config->logonMethods[] = 'baseline.view';
$config->logonMethods[] = 'weekly.index';
$config->logonMethods[] = 'weekly.addcategory';
$config->logonMethods[] = 'weekly.editcategory';
$config->logonMethods[] = 'weekly.deletecategory';
$config->logonMethods[] = 'weekly.exportweeklyreport';

/* Ajax 方法依赖的方法。The methods that Ajax methods depend on. */
$config->ajaxDependencies['activity.ajaxupdateorder']                        = 'activity.browse';
$config->ajaxDependencies['auditcl.ajaxgetactivities']                       = 'auditcl.edit';
$config->ajaxDependencies['auditplan.ajaxcreatecycleauditplan']              = '';
$config->ajaxDependencies['baseline.ajaxgetcontent']                         = 'doc.create';
$config->ajaxDependencies['baseline.ajaxgetdocs']                            = 'review.create';
$config->ajaxDependencies['baseline.ajaxgettemplates']                       = ['review.create', 'doc.create'];
$config->ajaxDependencies['cm.ajaxgetproduct']                               = ['cm.create', 'cm.edit'];
$config->ajaxDependencies['cm.ajaxgetreviews']                               = ['cm.create', 'cm.edit'];
$config->ajaxDependencies['deliverable.ajaxgetactivityoptional']             = ['deliverable.create', 'deliverable.edit'];
$config->ajaxDependencies['deliverable.ajaxgetactivityoptions']              = 'deliverable.create';
$config->ajaxDependencies['doc.ajaxgetdeliverabledocs']                      = ['deliverable.create', 'deliverable.edit'];
$config->ajaxDependencies['doc.ajaxgetdocs']                                 = 'review.create';
$config->ajaxDependencies['doc.ajaxgetlinkedproducts']                       = 'doc.buildzentaoconfig';
$config->ajaxDependencies['doc.ajaxgettemplatedocs']                         = ['deliverable.create', 'deliverable.edit'];
$config->ajaxDependencies['durationestimation.ajaxgetduration']              = 'durationestimation.create';
$config->ajaxDependencies['execution.ajaxautoschedulefortask']               = 'execution.gantt';
$config->ajaxDependencies['execution.ajaxgetattribute']                      = 'task.edit';
$config->ajaxDependencies['execution.ajaxgetprojectexecutions']              = ['meeting.create', 'meeting.edit'];
$config->ajaxDependencies['issue.ajaxgetexecutions']                         = 'issue.bugform';
$config->ajaxDependencies['issue.ajaxgetprojectissues']                      = 'risk.edit';
$config->ajaxDependencies['issue.ajaxgetresolveform']                        = 'issue.resolve';
$config->ajaxDependencies['issue.ajaxgetuserissues']                         = ['todo.create', 'todo.edit', 'todo.batchcreate'];
$config->ajaxDependencies['measurement.ajaxbuildparamform']                  = 'measurement.paramformmodal';
$config->ajaxDependencies['measurement.ajaxbuildsql']                        = 'measurement.designsql';
$config->ajaxDependencies['measurement.ajaxcheckelementneedparams']          = 'measurement.paramformmodal';
$config->ajaxDependencies['measurement.ajaxgetmoduleactions']                = 'measurement.createcollectconf';
$config->ajaxDependencies['measurement.ajaxgetparamcontrol']                 = ['measurement.design', 'measurement.setsqlparams', 'measurement.setsql'];
$config->ajaxDependencies['measurement.ajaxsetparams']                       = ['measurement.setparams', 'measurement.view'];
$config->ajaxDependencies['meeting.ajaxgetcontactusers']                     = ['meeting.create', 'meeting.edit'];
$config->ajaxDependencies['meeting.ajaxgetobjects']                          = ['meeting.create', 'meeting.edit'];
$config->ajaxDependencies['meeting.ajaxgetteammembers']                      = ['meeting.create', 'meeting.edit'];
$config->ajaxDependencies['milestone.ajaxaddmeasures']                       = ['milestone.rectifying', 'milestone.index'];
$config->ajaxDependencies['milestone.ajaxsaveestimate']                      = 'milestone.index';
$config->ajaxDependencies['my.ajaxgetproject']                               = 'my.review';
$config->ajaxDependencies['nc.ajaxgetauditplan']                             = 'nc.create';
$config->ajaxDependencies['nc.ajaxgetchecklist']                             = 'nc.create';
$config->ajaxDependencies['opportunity.ajaxgetuseropportunities']            = ['todo.create', 'todo.edit', 'todo.batchcreate'];
$config->ajaxDependencies['pi.ajaxlinkstory']                                = 'pi.team';
$config->ajaxDependencies['process.ajaxupdateorder']                         = 'process.browse';
$config->ajaxDependencies['project.ajaxautoschedulefortask']                 = 'programplan.browse';
$config->ajaxDependencies['project.ajaxcheckdataandgetlink']                 = ['project.deliverable', 'project.closuredeliverable'];
$config->ajaxDependencies['project.ajaxgenerateschedule']                    = 'programplan.browse';
$config->ajaxDependencies['project.ajaxgetprojects']                         = 'project.create';
$config->ajaxDependencies['project.ajaxgetschedule']                         = 'programplan.browse';
$config->ajaxDependencies['project.ajaxloadproject']                         = 'project.create';
$config->ajaxDependencies['project.ajaxsavetaskschedule']                    = ['execution.gantt', 'programplan.browse'];
$config->ajaxDependencies['reporttemplate.ajaxbuildzentaochartconfig']       = ['reporttemplate.ajaxzentaochart', 'reporttemplate.browse', 'weekly.docviewer'];
$config->ajaxDependencies['reporttemplate.ajaxbuildzentaolistconfig']        = ['reporttemplate.browse', 'weekly.docviewer'];
$config->ajaxDependencies['reporttemplate.ajaxbuildzentaomeasurementconfig'] = ['reporttemplate.browse', 'weekly.docviewer'];
$config->ajaxDependencies['reporttemplate.ajaxcheckdeletecategory']          = 'reporttemplate.browse';
$config->ajaxDependencies['reporttemplate.ajaxgetdata']                      = 'reporttemplate.browse';
$config->ajaxDependencies['reporttemplate.ajaxgetdoc']                       = 'reporttemplate.browse';
$config->ajaxDependencies['reporttemplate.ajaxsetbasic']                     = 'reporttemplate.browse';
$config->ajaxDependencies['reporttemplate.ajaxzentaochart']                  = ['reporttemplate.browse', 'weekly.docviewer'];
$config->ajaxDependencies['researchplan.ajaxgetplaninfo']                    = ['researchreport.create', 'researchreport.edit'];
$config->ajaxDependencies['review.ajaxcheckreviewinfo']                      = ['review.create', 'review.edit', 'my.audit'];
$config->ajaxDependencies['review.ajaxgetapproval']                          = ['review.createflow', 'review.editflow', 'project.editapproval', 'stage.setpoint'];
$config->ajaxDependencies['review.ajaxgetdeliverables']                      = 'review.create';
$config->ajaxDependencies['review.ajaxgetnodes']                             = ['review.submit', 'review.create'];
$config->ajaxDependencies['review.ajaxgetuserreviews']                       = ['todo.create', 'todo.edit', 'todo.batchcreate'];
$config->ajaxDependencies['reviewissue.ajaxgetcategory']                     = 'reviewissue.create';
$config->ajaxDependencies['reviewissue.ajaxgetcheck']                        = 'reviewissue.create';
$config->ajaxDependencies['reviewissue.ajaxgetinjection']                    = 'reviewissue.create';
$config->ajaxDependencies['reviewissue.ajaxgetreview']                       = 'reviewissue.issue';
$config->ajaxDependencies['risk.ajaxgetprojectrisks']                        = 'issue.edit';
$config->ajaxDependencies['risk.ajaxgetuserrisks']                           = ['todo.create', 'todo.edit', 'todo.batchcreate'];
$config->ajaxDependencies['story.ajaxgetdesign']                             = ['task.create', 'task.edit'];
$config->ajaxDependencies['story.ajaxgetsourcenote']                         = ['story.batchcreate', 'story.batchedit'];
$config->ajaxDependencies['task.ajaxchecktaskdate']                          = 'task.autoschedule';
$config->ajaxDependencies['task.ajaxmanualschedule']                         = 'execution.gantt';
$config->ajaxDependencies['weekly.ajaxcheckdeletecategory']                  = 'weekly.browse';
$config->ajaxDependencies['weekly.ajaxgetmeasurement']                       = ['weekly.docviewer', 'weekly.edit'];
$config->ajaxDependencies['weekly.ajaxgetreport']                            = ['weekly.docviewer', 'weekly.view'];
$config->ajaxDependencies['weekly.ajaxrefreshdata']                          = ['weekly.docviewer', 'weekly.edit'];
$config->ajaxDependencies['weekly.ajaxselecttemplate']                       = ['weekly.browse', 'weekly.ajaxselecttemplate'];
$config->ajaxDependencies['weekly.ajaxsetbasic']                             = ['weekly.docviewer', 'weekly.edit'];
$config->ajaxDependencies['weekly.ajaxsetcontent']                           = 'weekly.docviewer';
$config->ajaxDependencies['workflowgroup.ajaxgetdeliverable']                = 'workflowgroup.deliverable';

if($config->edition == 'max' || $config->edition == 'ipd')
{
    $config->featureGroup->project  = array_merge($config->featureGroup->project,  array('gapanalysis','track', 'deliverable', 'cm', 'change', 'issue', 'risk', 'opportunity', 'process', 'auditplan', 'researchplan', 'meeting', 'workestimation'));
    $config->featureGroup->assetlib = array_merge($config->featureGroup->assetlib, array('storylib', 'issuelib', 'risklib', 'opportunitylib', 'practicelib', 'componentlib'));
}

$config->excludeDropmenuList[] = 'reporttemplate-browse';
$config->excludeDropmenuList[] = 'reporttemplate-edit';
$config->excludeDropmenuList[] = 'reporttemplate-view';
