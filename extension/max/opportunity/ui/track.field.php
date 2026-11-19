<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('opportunity.track');

$fields->field('isChange')
    ->control(array('control' => 'radioList', 'inline' => true, 'data-on' => 'change', 'data-call' => 'changeRisk', 'data-params' => 'event'))
    ->items($lang->opportunity->isChangeList)
    ->value(0);

$fields->field('name')->className('track')->width('full')->control('input')->required(true)->value(data('opportunity.name'));
$fields->field('type')->className('track')->control('picker')->items($lang->opportunity->typeList)->value(data('opportunity.type'));
$fields->field('strategy')->className('track')->control('picker')->items($lang->opportunity->strategyList)->value(data('opportunity.strategy'));
$fields->field('impact')->className('track')->control('picker')->items($lang->opportunity->impactList)->required()->value(data('opportunity.impact'));
$fields->field('chance')->className('track')->control('picker')->items($lang->opportunity->chanceList)->required()->value(data('opportunity.chance'));
$fields->field('ratio')->className('track')->control('input')->readonly(true) ->value(data('opportunity.ratio'));
$fields->field('pri')->className('track')->control('priPicker')->items($lang->opportunity->priList)->required()->readonly(true)->value(data('opportunity.pri'));
$fields->field('lastCheckedBy')->className('track')->control('picker')->items(data('members'))->value($app->user->account);
$fields->field('lastCheckedDate')->className('track')->control('datePicker')->value(data('opportunity.lastCheckedDate') ?: helper::today());
$fields->field('desc')->className('track')->width('full')->control('editor')->value(data('opportunity.desc'));
$fields->field('prevention')->className('track')->width('full')->control('editor')->value(data('opportunity.prevention'));
$fields->field('resolution')->className('track')->width('full')->control('editor')->value(data('opportunity.resolution'));
$fields->field('comment')->className('not-track')->label($lang->comment)->width('full')->control('editor');
