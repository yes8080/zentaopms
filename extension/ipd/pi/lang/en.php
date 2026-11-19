<?php
$lang->pi->browse                 = 'Plan List';
$lang->pi->create                 = 'Create Plan';
$lang->pi->edit                   = 'Edit Plan';
$lang->pi->activate               = 'Activate Plan';
$lang->pi->close                  = 'Close Plan';
$lang->pi->delete                 = 'Delete Plan';
$lang->pi->linkCard               = 'Link Card';
$lang->pi->unlinkCard             = 'Unlink Card';
$lang->pi->createStory            = "Create {$lang->SRCommon}";
$lang->pi->createRequirement      = "Create {$lang->URCommon}";
$lang->pi->createEpic             = "Create {$lang->ERCommon}";
$lang->pi->linkStory              = "Link {$lang->SRCommon}";
$lang->pi->unlinkStory            = "Unlink {$lang->SRCommon}";
$lang->pi->createMilestone        = 'Create Milestone Objective';
$lang->pi->editMilestone          = 'Edit Milestone Objective';
$lang->pi->deleteMilestone        = 'Delete Milestone Objective';
$lang->pi->createTeamCard         = 'Create Team Objective';
$lang->pi->createMilestoneAction  = 'Create Objective Card';
$lang->pi->editMilestoneAction    = 'Create Objective Card';
$lang->pi->deleteMilestoneAction  = 'Create Objective Card';
$lang->pi->createLane             = 'Create Lane';
$lang->pi->editLane               = 'Edit Lane';
$lang->pi->deleteLane             = 'Delete Lane';
$lang->pi->createCard             = 'Create Card';
$lang->pi->editCard               = 'Edit Card';
$lang->pi->finishCard             = 'Finish Card';
$lang->pi->viewCard               = 'View Card';
$lang->pi->activateCard           = 'Activate Card';
$lang->pi->deleteCard             = 'Delete Card';
$lang->pi->setCapacity            = 'Set Capacity';
$lang->pi->fullscreen             = 'Fullscreen';
$lang->pi->setKanban              = 'Set Kanban';
$lang->pi->setColumn              = 'Set Column';
$lang->pi->setLane                = 'Set Lane';
$lang->pi->moveCard               = 'Move Card';
$lang->pi->viewAllART             = 'All Group';
$lang->pi->createART              = 'Create Group';

$lang->pi->name              = 'Plan Name';
$lang->pi->teamKanban        = 'Team Kanban';
$lang->pi->planKanban        = 'Plan Kanban';
$lang->pi->ART               = 'Project Group';
$lang->pi->product           = 'Product';
$lang->pi->RTE               = 'Manager';
$lang->pi->PO                = 'Product Owner';
$lang->pi->architect         = 'Architect';
$lang->pi->status            = 'Status';
$lang->pi->team              = 'Team';
$lang->pi->desc              = 'Description';
$lang->pi->acl               = 'Access Control';
$lang->pi->plan              = 'Plan';
$lang->pi->execution         = 'Period Name';
$lang->pi->workhour          = 'Workhour';
$lang->pi->capacity          = 'Capacity';
$lang->pi->workload          = 'Workload';
$lang->pi->planDate          = 'Plan Date';
$lang->pi->begin             = 'Begin';
$lang->pi->end               = 'End';
$lang->pi->whitelist         = 'Whitelist';
$lang->pi->width             = 'Width';
$lang->pi->createdBy         = 'Created By';
$lang->pi->createdDate       = 'Created Date';
$lang->pi->closedBy          = 'Closed By';
$lang->pi->closedDate        = 'Closed Date';
$lang->pi->closedReason      = 'Closed Reason';
$lang->pi->selectTeam        = 'Select Team';
$lang->pi->selectProduct     = 'Select Product';
$lang->pi->toLane            = 'To Lane';
$lang->pi->createObjective   = 'Create Objective';
$lang->pi->editObjective     = 'Edit Objective';
$lang->pi->deleteObjective   = 'Delete Objective';
$lang->pi->deleted           = 'Deleted';
$lang->pi->features          = 'Features';
$lang->pi->newProject        = 'New Project';
$lang->pi->selectRequirement = "Select {$lang->URCommon}";
$lang->pi->storyTitle        = "Story Title";

$lang->pi->abbr = new stdclass();
$lang->pi->abbr->execution = $lang->executionCommon;
$lang->pi->abbr->unCreated = 'Uncreated';

$lang->pi->storyAppendStatusList['launched']  = 'Launched';
$lang->pi->storyAppendStatusList['completed'] = 'Completed';
$lang->pi->storyAppendStatusList['canceled']  = 'Canceled';

$lang->pi->error = new stdclass();
$lang->pi->error->duplicate            = "Duplicate period name.";
$lang->pi->error->projectNameEmpty     = "{$lang->projectCommon} name cannot be empty.";
$lang->pi->error->executionNameEmpty   = "Period name cannot be empty.";
$lang->pi->error->projectNameDuplicate = 'Duplicate project name.';
$lang->pi->error->maxColWidth          = 'Maximum lane width must be greater than the minimum lane width.';

$lang->pi->notice = new stdclass();
$lang->pi->notice->confirmDelete            = 'Are you sure to delete the Plan "%s"?';
$lang->pi->notice->linkedExecution          = "The Plan is linked to the {$lang->executionCommon}, cannot delete it.";
$lang->pi->notice->confirmUnlinkStory       = "Are you sure to unlink the story?";
$lang->pi->notice->confirmDeleteLane        = 'Are you sure to delete the lane?';
$lang->pi->notice->confirmDeleteCard        = 'Are you sure to delete the card?';
$lang->pi->notice->confirmRemoveTeam        = "When you remove a team, the {$lang->executionCommon} created in the {$lang->projectCommon} will be deleted simultaneously.";
$lang->pi->notice->confirmRemoveExecution   = "When you remove an time period, the {$lang->executionCommon} created in the {$lang->projectCommon} will be deleted simultaneously.";
$lang->pi->notice->confirmMoveStory         = "After moving the {$lang->SRCommon}, the use cases associated with the {$lang->SRCommon} in this {$lang->executionCommon} will be removed, and the tasks associated with the {$lang->SRCommon} will be cancelled, Please confirm.";
$lang->pi->notice->laneNotEmpty             = 'The lane cannot be empty.';
$lang->pi->notice->cannotRemoveProduct      = 'The story for this product has been associated with Plan and is not allowed to be removed.';
$lang->pi->notice->cannotRemoveTeam         = 'In Plan, the team has associated cards on the team dashboard and Plan planning board. Please remove the card first.';
$lang->pi->notice->cannotRemoveExecution    = "This planning {$lang->executionCommon} in Plan has associated cards on the team dashboard and Plan planning board. Please remove the card first.";
$lang->pi->notice->choseTeam                = 'Chosen Team';
$lang->pi->notice->choseProject             = "Chosen {$lang->projectCommon}";
$lang->pi->notice->createExecution          = "Create {$lang->executionCommon}";
$lang->pi->notice->updateProjectDate        = "The {$lang->executionCommon} start and end times become: %s ~ %s .";
$lang->pi->notice->updateProjectProducts    = "{$lang->executionCommon} are automatically associated with products: %s .";
$lang->pi->notice->allComplete              = 'All teams are set up.';
$lang->pi->notice->endNotLessThanBegin      = 'The end time cannot be less than the start time.';
$lang->pi->notice->progressError            = 'The card progress can only be a number from 0 to 100.';

$lang->pi->statusList = array();
$lang->pi->statusList['normal'] = 'Normal';
$lang->pi->statusList['closed'] = 'Closed';

$lang->pi->aclList = array();
$lang->pi->aclList['extends'] = 'Inherit Project Group access rights ( If you can access the Project Group you belong to, you can access it)';
$lang->pi->aclList['private'] = 'Private (Only the relevant person in charge of Project Group and the creator and team members of Plan can access)';

$lang->pi->featureBar['browse']['all']    = 'All';
$lang->pi->featureBar['browse']['normal'] = $lang->pi->statusList['normal'];
$lang->pi->featureBar['browse']['closed'] = $lang->pi->statusList['closed'];

$lang->pi->closedReasonList = array();
$lang->pi->closedReasonList['complete'] = 'Completed';
$lang->pi->closedReasonList['cancel']   = 'Cancelled';

$lang->pi->appendColumnList = array();
$lang->pi->appendColumnList['risk']      = 'Risk';
$lang->pi->appendColumnList['objective'] = 'Objective';

$lang->pi->childColumnList['promise']['yes'] = 'Committed goal';
$lang->pi->childColumnList['promise']['no']  = 'Uncommitted goal';

$lang->pi->lane = new stdclass();
$lang->pi->lane->common = 'Lane';
$lang->pi->lane->name   = 'Lane Name';
$lang->pi->lane->color  = 'Lane Color';

$lang->pi->cardStatusList['wait']   = 'wait';
$lang->pi->cardStatusList['doing']  = 'doing';
$lang->pi->cardStatusList['done']   = 'done';
$lang->pi->cardStatusList['closed'] = 'closed';

$lang->pi->milestone = new stdclass();
$lang->pi->milestone->common     = 'Milestone Objective';
$lang->pi->milestone->name       = 'Objective Name';
$lang->pi->milestone->lane       = 'Objective Lane';
$lang->pi->milestone->end        = 'End';
$lang->pi->milestone->assignedTo = 'Manager';
$lang->pi->milestone->status     = 'Status';

$lang->pi->milestone->confirmDelete = 'Are you sure to delete the objective?';

$lang->pi->milestone->statusList['normal'] = 'Normal';
$lang->pi->milestone->statusList['done']   = 'Done';
$lang->pi->milestone->statusList['delay']  = 'Delay';

$lang->pi->columnWidth = array();
$lang->pi->columnWidth['0'] = 'Fixed column width';
$lang->pi->columnWidth['1'] = 'Adaptive column width';

$lang->pi->laneHeight = array();
$lang->pi->laneHeight['0'] = 'Fixed lane height';
$lang->pi->laneHeight['1'] = 'Adaptive lane height';

$lang->picard = new stdclass();
$lang->picard->statusList = $lang->pi->cardStatusList;
