<?php
/* Fields */
$lang->risk->id                = 'ID';
$lang->risk->name              = 'Name';
$lang->risk->source            = 'Source';
$lang->risk->team              = 'Team';
$lang->risk->issues            = 'Link Issues';
$lang->risk->project           = $lang->projectCommon;
$lang->risk->category          = 'Type';
$lang->risk->strategy          = 'Strategy';
$lang->risk->status            = 'Status';
$lang->risk->impact            = 'Impact';
$lang->risk->probability       = 'Probability';
$lang->risk->rate              = 'Risk Index';
$lang->risk->execution         = $lang->execution->common;
$lang->risk->pri               = 'Priority';
$lang->risk->priAB             = 'P';
$lang->risk->lib               = 'Risk Library';
$lang->risk->approver          = 'Approver';
$lang->risk->prevention        = 'Solution';
$lang->risk->remedy            = 'Response';
$lang->risk->identifiedDate    = 'Identified';
$lang->risk->plannedClosedDate = 'Deadline';
$lang->risk->assignedTo        = 'Assigned to';
$lang->risk->assignedDate      = 'Assigned Date';
$lang->risk->createdBy         = 'Created by';
$lang->risk->createdDate       = 'Created Date';
$lang->risk->noAssigned        = 'Unassigned';
$lang->risk->cancelBy          = 'Canceled by';
$lang->risk->cancelDate        = 'Canceled Date';
$lang->risk->cancelReason      = 'Cancel Reason';
$lang->risk->resolvedBy        = 'Resolved by';
$lang->risk->closedBy          = 'Closed by';
$lang->risk->closedDate        = 'Closed Date';
$lang->risk->actualClosedDate  = 'Closed Date';
$lang->risk->resolution        = 'Resolution';
$lang->risk->hangupBy          = 'Suspended by';
$lang->risk->hangupDate        = 'Suspended Date';
$lang->risk->activateBy        = 'Activated by';
$lang->risk->activateDate      = 'Activated Date';
$lang->risk->isChange          = 'Any change?';
$lang->risk->trackedBy         = 'Tracked by';
$lang->risk->trackedDate       = 'Tracked Date';
$lang->risk->editedBy          = 'Edited by';
$lang->risk->editedDate        = 'Edited Date';
$lang->risk->legendBasicInfo   = 'Basic Info';
$lang->risk->legendLifeTime    = 'About Risk';
$lang->risk->legendMisc        = 'Misc.';
$lang->risk->linkedIssues      = 'Linked Issues';
$lang->risk->confirmDelete     = 'Do you want to delelte this risk?';
$lang->risk->deleted           = 'Deleted';
$lang->risk->allLib            = 'All Risk Library';
$lang->risk->batchCreateRisk   = 'Batch Create Risk';
$lang->risk->impactTips        = "1 Very low, schedule delay less than 5%, or cost overrun less than 5%\n2 Low, schedule delay less than 10%, or cost overrun less than 10%\n3 Medium, schedule delay less than 20%, or cost overrun less than 20%\n4 High, schedule delay 20%~30%, or cost overrun 20%~30%\n5 Very high, schedule delay greater than 30%, or cost overrun greater than 30%";
$lang->risk->probabilityTips   = "1 Very low, probability of risk occurrence is 0 ~ 20%\n2 Low, probability of risk occurrence is 20% ~ 40%\n3 Medium, probability of risk occurrence is 40% ~ 60%\n4 High, probability of risk occurrence is 60% ~ 80%\n5 Very high, probability of risk occurrence is 80% ~ 100%";
$lang->risk->rateTips          = "Risk Coefficient = Impact × Probability";
$lang->risk->priTips           = "Low (Score 1–5): Schedule delay of 5% and cost overrun of 5%; reassess this risk in subsequent risk identification activities\nMedium (Score 6–12): Schedule delay of 10% and cost overrun of 10%; address the risk per predefined mitigation measures\nHigh (Score 15–25): Schedule delay of 15% and cost overrun of 15%. For scores of 15 or above, the risk shall be handled with top priority to prevent adverse impacts on the project";

/* Actions */
$lang->risk->batchCreate = 'Batch Create';
$lang->risk->create      = 'Create Risk';
$lang->risk->edit        = 'Edit Risk';
$lang->risk->browse      = 'Risks List';
$lang->risk->view        = 'Details';
$lang->risk->activate    = 'Active';
$lang->risk->hangup      = 'Suspend';
$lang->risk->close       = 'Close';
$lang->risk->cancel      = 'Cancle';
$lang->risk->track       = 'Track';
$lang->risk->assignTo    = 'Assign';
$lang->risk->delete      = 'Delete';
$lang->risk->byQuery     = 'Search';
$lang->risk->effort      = 'Effort';
$lang->risk->consumed    = 'Consumed';

$lang->risk->trackAction       = 'Track Risk';
$lang->risk->assignToAction    = 'Assign Risk';
$lang->risk->cancelAction      = 'Cancel Risk';
$lang->risk->closeAction       = 'Close Risk';
$lang->risk->hangupAction      = 'Suspended Risk';
$lang->risk->activateAction    = 'Activate Risk';
$lang->risk->deleteAction      = 'Delete Risk';

$lang->risk->importFromLib    = 'Import From Library';
$lang->risk->import           = 'Import';
$lang->risk->export           = 'Export Data';
$lang->risk->exportAction     = 'Export Risk';
$lang->risk->importToLib      = 'Import To Lib';
$lang->risk->batchImportToLib = 'Batch Import To Lib';
$lang->risk->isExist          = 'This risk is already added in the Risk Lib. Please do not add it again.';

$lang->risk->pageSummary        = "Total risks: <strong>%total%</strong>, Active: <strong>%active%</strong>, Suspended: <strong>%hangup%</strong>.";
$lang->risk->checkedSummary     = "Selected: <strong>%total%</strong>, Active: <strong>%active%</strong>, Suspended: <strong>%hangup%</strong>.";
$lang->risk->pageRiskSummary    = "Total risks: <strong>%s</strong>.";
$lang->risk->checkedRiskSummary = "Selected: <strong>%s</strong>.";

$lang->risk->action = new stdclass();
$lang->risk->action->hangup            = '$date, suspended by <strong>$actor</strong>.' . "\n";
$lang->risk->action->tracked           = '$date, tracked by <strong>$actor</strong>.' . "\n";
$lang->risk->action->importfromrisklib = array('main' => '$date, imported by <strong>$actor</strong> from <strong>$extra</strong>.');;

$lang->risk->sourceList[''] = '';
$lang->risk->sourceList['business']    = 'Business';
$lang->risk->sourceList['team']        = $lang->projectCommon . 'Team';
$lang->risk->sourceList['logistic']    = $lang->projectCommon . 'Logistics';
$lang->risk->sourceList['manage']      = 'Management';
$lang->risk->sourceList['sourcing']    = 'Supplier-Procurement';
$lang->risk->sourceList['outsourcing'] = 'Supplier-Outsourcing';
$lang->risk->sourceList['customer']    = 'Customer';
$lang->risk->sourceList['others']      = 'Other';

$lang->risk->categoryList[''] = '';
$lang->risk->categoryList['technical']   = 'Technology';
$lang->risk->categoryList['manage']      = 'Management';
$lang->risk->categoryList['business']    = 'Business';
$lang->risk->categoryList['requirement'] = 'Requirement';
$lang->risk->categoryList['resource']    = 'Resource';
$lang->risk->categoryList['others']      = 'Other';

$lang->risk->impactList[1] = 1;
$lang->risk->impactList[2] = 2;
$lang->risk->impactList[3] = 3;
$lang->risk->impactList[4] = 4;
$lang->risk->impactList[5] = 5;

$lang->risk->probabilityList[1] = 1;
$lang->risk->probabilityList[2] = 2;
$lang->risk->probabilityList[3] = 3;
$lang->risk->probabilityList[4] = 4;
$lang->risk->probabilityList[5] = 5;

$lang->risk->priList[1] = 'High';
$lang->risk->priList[2] = 'Medium';
$lang->risk->priList[3] = 'Low';

$lang->risk->statusList[''] = '';
$lang->risk->statusList['active']   = 'Active';
$lang->risk->statusList['closed']   = 'Closed';
$lang->risk->statusList['hangup']   = 'Suspended';
$lang->risk->statusList['canceled'] = 'Canceled';

$lang->risk->strategyList[''] = '';
$lang->risk->strategyList['avoidance']    = 'Avoidance';
$lang->risk->strategyList['mitigation']   = 'Mitigation';
$lang->risk->strategyList['transference'] = 'Transfer';
$lang->risk->strategyList['acceptance']   = 'Acceptance';

$lang->risk->isChangeList[0] = 'No';
$lang->risk->isChangeList[1] = 'Yes';

$lang->risk->cancelReasonList[''] = '';
$lang->risk->cancelReasonList['disappeared'] = 'Dispear';
$lang->risk->cancelReasonList['mistake']     = 'Mistake';

$lang->risk->featureBar['browse']['all']      = 'All';
$lang->risk->featureBar['browse']['active']   = 'Active';
$lang->risk->featureBar['browse']['assignTo'] = 'Assigned to Me';
$lang->risk->featureBar['browse']['assignBy'] = 'Assigned by Me';
$lang->risk->featureBar['browse']['closed']   = 'Closed';
$lang->risk->featureBar['browse']['hangup']   = 'Suspended';
$lang->risk->featureBar['browse']['canceled'] = 'Canceled';
