<?php
$lang->team->browse       = 'Team List';
$lang->team->edit         = 'Edit Team';
$lang->team->create       = 'Create Team';
$lang->team->batchCreate  = 'Batch Create';
$lang->team->enable       = 'Activate';
$lang->team->disband      = 'Disband';
$lang->team->view         = 'Team View';
$lang->team->delete       = 'Delete';
$lang->team->addMember    = 'Add Member';
$lang->team->removeMember = 'Remove Member';

$lang->team->id            = 'ID';
$lang->team->type          = 'Type';
$lang->team->logo          = 'Logo';
$lang->team->name          = 'Team Name';
$lang->team->manager       = 'Manager';
$lang->team->parent        = 'Parent';
$lang->team->status        = 'Status';
$lang->team->slogan        = 'Slogan';
$lang->team->declaration   = 'Declaration';
$lang->team->number        = 'Members';
$lang->team->createdBy     = 'CreatedBy';
$lang->team->createdDate   = 'CreatedDate';
$lang->team->member        = 'Member';
$lang->team->members       = 'Member';
$lang->team->joinAB        = 'Join';
$lang->team->deleted       = 'Deleted';
$lang->team->disbandedDate = 'Disbanded Date';

$lang->team->createAction  = 'Create Team';
$lang->team->editAction    = 'Edit Team';
$lang->team->enableAction  = 'Activate Team';
$lang->team->disbandAction = 'Disband Team';
$lang->team->deleteAction  = 'Delete Team';

$lang->team->tips = new stdclass();
$lang->team->tips->type        = 'Display summary information of sub teams in the parent team, and maintain team members in sub teams.';
$lang->team->tips->disbandTeam = "%s member's team %s has been disbanded. After activation, the corresponding member's team will be cleared.";

$lang->team->typeList = array();
$lang->team->typeList['parent'] = 'Parent';
$lang->team->typeList['child']  = 'Child';

$lang->team->statusList = array();
$lang->team->statusList['enable']  = 'Normal';
$lang->team->statusList['disband'] = $lang->team->disband;

$lang->team->featureBar['browse']['all']     = 'All';
$lang->team->featureBar['browse']['enable']  = 'Normal';
$lang->team->featureBar['browse']['disband'] = $lang->team->disband;

$lang->team->parentDisbanded        = 'The original team has been disbanded or deleted.';
$lang->team->parentHasLinkedProject = 'The sub-teams of this team are associated with unclosed projects and executions and cannot be disbanded.';
$lang->team->childHasLinkedProject  = 'The team is associated with unclosed projects and executions and cannot be disbanded.';
$lang->team->childHasLinkedPI       = 'The team is associated with unclosed Plan and cannot be disbanded.';
$lang->team->disbandParent          = 'Are you sure you want to disband team "%s"? All its sub-teams will also be disbanded.';
$lang->team->confirmDisband         = 'Are you sure you want to disband team "%s"?';
$lang->team->linkedPI               = 'This team is associated with Plan and cannot be deleted.';
$lang->team->hasConsumed            = 'This team member has filled in the hours in the associated project and execution and cannot be deleted.';
$lang->team->hasChild               = 'The team has sub-teams and cannot be deleted.';
$lang->team->confirmDelete          = 'Are you sure you want to delete team "%s"?';
$lang->team->parentTeamDeleted      = 'The parent team "%s" of this team has been deleted. Please restore the parent team first.';
$lang->team->linkedProject          = 'After removal, the projects and executions in which the member participated will be cleared.';

$lang->teamgroup = $lang->team;
