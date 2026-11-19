<?php
namespace zin;
global $lang;

$fields = defineFieldList('risk.create');

$fields->field('name')
    ->width('full')
    ->control('input')
    ->required();

$fields->field('source')
    ->width('1/2')
    ->control('picker')
    ->items($lang->risk->sourceList);

if(data('from') != 'pi')
{
    $fields->field('execution')
        ->control('picker')
        ->wrapAfter()
        ->items(data('executions'))
        ->hidden(!data('project.multiple'));
}

$fields->field('category')
    ->control('picker')
    ->items($lang->risk->categoryList);

$fields->field('strategy')
    ->control('picker')
    ->items($lang->risk->strategyList);

$fields->field('impact')
    ->control(array('control' => 'picker', 'required' => true))
    ->labelHint($lang->risk->impactTips)
    ->labelProps(array('title' => ''))
    ->items($lang->risk->impactList)
    ->width('1/4')
    ->required();

$fields->field('probability')
    ->control(array('control' => 'picker', 'required' => true))
    ->labelHint($lang->risk->probabilityTips)
    ->labelProps(array('title' => ''))
    ->width('1/4')
    ->items($lang->risk->probabilityList)
    ->required();

$fields->field('rate')
    ->control('input')
    ->labelHint($lang->risk->rateTips)
    ->labelProps(array('title' => ''))
    ->width('1/4')
    ->disabled(true);

$fields->field('pri')
    ->control('priPicker')
    ->labelHint($lang->risk->priTips)
    ->labelProps(array('title' => ''))
    ->items($lang->risk->priList)
    ->width('1/4')
    ->required()
    ->readonly(true);

$fields->field('identifiedDate')
    ->width('1/4')
    ->control('datePicker');

$fields->field('plannedClosedDate')
    ->width('1/4')
    ->control('datePicker');

$fields->field('assignedTo')
    ->control('picker')
    ->items(data('users'));

$fields->field('prevention')
    ->width('full')
    ->control('editor');

$fields->field('remedy')
    ->width('full')
    ->control('editor');
