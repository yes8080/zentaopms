<?php
$lang->art->browse   = 'Project Group List';
$lang->art->create   = 'Create Project Group';
$lang->art->createPI = 'Create Plan';
$lang->art->view     = 'View Project Group';
$lang->art->close    = 'Disband Project Group';
$lang->art->activate = 'Activate Project Group';
$lang->art->edit     = 'Edit Project Group';
$lang->art->delete   = 'Delete Project Group';

$lang->art->name        = 'Project Group Name';
$lang->art->product     = 'Product';
$lang->art->RTE         = 'Manager';
$lang->art->manager     = 'Manager';
$lang->art->PO          = 'Product Owner';
$lang->art->architect   = 'Architect';
$lang->art->status      = 'Status';
$lang->art->createdBy   = 'Created By';
$lang->art->createdDate = 'Created Date';
$lang->art->actions     = 'Actions';
$lang->art->team        = 'Team';
$lang->art->teamInfo    = 'Team Info';
$lang->art->piInfo      = 'Plan Info';
$lang->art->desc        = 'Description';
$lang->art->acl         = 'Access Control';
$lang->art->whitelist   = 'White List';

$lang->art->basicInfo = 'Basic Info';
$lang->art->deleted   = 'Deleted';

$lang->art->statusList['normal'] = 'Normal';
$lang->art->statusList['closed'] = 'Disband';

$lang->art->featureBar['browse']['all']    = 'All';
$lang->art->featureBar['browse']['normal'] = $lang->art->statusList['normal'];
$lang->art->featureBar['browse']['closed'] = $lang->art->statusList['closed'];

$lang->art->notice = new stdclass();
$lang->art->notice->noPrivilege         = 'No privilege.';
$lang->art->notice->confirmDelete       = 'Do you want to delete this Project Group?';
$lang->art->notice->hasPI               = 'There are Plan under this Project Group, cannot delete it.';
$lang->art->notice->cannotRemoveTeam    = 'There are un-closed Plan under this team, cannot remove it.';
$lang->art->notice->cannotRemoveProduct = 'There are un-closed Plan under this product, please remove the Plan first.';
$lang->art->notice->cannotCloseART      = 'There are un-closed Plan under this Project Group, please close the Plan first.';
$lang->art->notice->confirmDisband      = 'Are you sure you want to disband Project Group "%s"?';

$lang->art->aclList['open']    = 'Open (accessible with Project Group view permissions)';
$lang->art->aclList['private'] = 'Private (Creator, Manager, Business Manager, PO, System Architect, Team Member and Whitelist can access)';

$lang->art->aclAbbrList['open']    = 'Open';
$lang->art->aclAbbrList['private'] = 'Private';
