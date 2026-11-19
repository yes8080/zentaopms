<?php
namespace zin;
global $lang;

$fields = defineFieldList('opportunity.edit');

$fields->field('name')
    ->position('info')
    ->control('input')
    ->required(true)
    ->value(data('opportunity.name'));

$fields->field('desc')
    ->position('info')
    ->control('editor')
    ->value(data('opportunity.desc'));

$fields->field('prevention')
    ->position('info')
    ->control('editor')
    ->value(data('opportunity.prevention'));

$fields->field('resolution')
    ->position('info')
    ->control('editor')
    ->value(data('opportunity.resolution'));

$fields->field('source')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('picker')
    ->items($lang->opportunity->sourceList)
    ->value(data('opportunity.source'));

$fields->field('type')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('picker')
    ->items($lang->opportunity->typeList)
    ->value(data('opportunity.type'));

$fields->field('strategy')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('picker')
    ->items($lang->opportunity->strategyList)
    ->value(data('opportunity.strategy'));

$fields->field('status')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('picker')
    ->items($lang->opportunity->statusList)
    ->value(data('opportunity.status'));

$fields->field('execution')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->hidden(empty($project->multiple))
    ->control('picker')
    ->items(data('executions'))
    ->value(data('opportunity.execution'));

$fields->field('impact')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control(array('control' => 'picker', 'required' => true))
    ->items($lang->opportunity->impactList)
    ->value(data('opportunity.impact'));

$fields->field('chance')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control(array('control' => 'picker', 'required' => true))
    ->items($lang->opportunity->chanceList)
    ->value(data('opportunity.chance'));

$fields->field('ratio')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->readonly(true)
    ->control('input')
    ->value(data('opportunity.ratio'));

$fields->field('pri')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->readonly(true)
    ->control('priPicker')
    ->items($lang->opportunity->priList)
    ->value(data('opportunity.pri'));

$fields->field('identifiedDate')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('datePicker')
    ->value(data('opportunity.identifiedDate'));

$fields->field('plannedClosedDate')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('datePicker')
    ->value(data('opportunity.plannedClosedDate'));

$fields->field('actualClosedDate')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('datePicker')
    ->value(data('opportunity.actualClosedDate'));

$fields->field('assignedTo')
    ->position('basic')
    ->group($lang->opportunity->legendBasicInfo)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.assignedTo'));

$fields->field('lastCheckedBy')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.lastCheckedBy'));

$fields->field('lastCheckedDate')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('datePicker')
    ->value(data('opportunity.lastCheckedDate'));

$fields->field('hangupedBy')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.hangupedBy'));

$fields->field('hangupedDate')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('datePicker')
    ->value(data('opportunity.hangupedDate'));

$fields->field('canceledBy')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.canceledBy'));

$fields->field('cancelReason')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items($lang->opportunity->cancelReasonList)
    ->value(data('opportunity.cancelReason'));

$fields->field('canceledDate')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('datePicker')
    ->value(data('opportunity.canceledDate'));

$fields->field('closedBy')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.closedBy'));

$fields->field('closedDate')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('datePicker')
    ->value(data('opportunity.closedDate'));

$fields->field('activatedBy')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.activatedBy'));

$fields->field('activatedDate')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('datePicker')
    ->value(data('opportunity.activatedDate'));

$fields->field('resolvedBy')
    ->position('basic')
    ->group($lang->opportunity->legendLifeTime)
    ->control('picker')
    ->items(data('members'))
    ->value(data('opportunity.resolvedBy'));
