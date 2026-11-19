<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('risk.track');

$fields->field('isChange')
    ->control(array('control' => 'radioList', 'inline' => true, 'data-on' => 'change', 'data-call' => 'changeRisk', 'data-params' => 'event'))
    ->items($lang->risk->isChangeList)
    ->value(0);

$fields->field('name')->className('track')->width('full')->control('input')->required(true)->value(data('risk.name'));
$fields->field('category')->className('track')->control('picker')->items($lang->risk->categoryList)->value(data('risk.category'));
$fields->field('strategy')->className('track')->control('picker')->items($lang->risk->strategyList)->value(data('risk.strategy'));
$fields->field('impact')->className('track')->control('picker')->items($lang->risk->impactList)->required()->value(data('risk.impact'));
$fields->field('probability')->className('track')->control('picker')->items($lang->risk->probabilityList)->required()->value(data('risk.probability'));
$fields->field('rate')->className('track')->control('input')->readonly(true) ->value(data('risk.rate'));
$fields->field('pri')->className('track')->control('priPicker')->items($lang->risk->priList)->required()->readonly(true)->value(data('risk.pri'));
$fields->field('trackedBy')->className('track')->control('picker')->items(data('users'))->value($app->user->account);
$fields->field('trackedDate')->className('track')->control('datePicker')->value(data('risk.trackedDate') ?: helper::today());
$fields->field('prevention')->className('track')->width('full')->control('editor')->value(data('risk.prevention'));
$fields->field('resolution')->className('track')->width('full')->control('editor')->value(data('risk.resolution'));
$fields->field('comment')->className('not-track')->label($lang->comment)->width('full')->control('editor');
