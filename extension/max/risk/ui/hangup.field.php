<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('risk.hangup');

$fields->field('assignedTo')->control('picker')->items(data('users'))->value(data('risk.assignedTo'));
$fields->field('hangupBy')->control('picker')->items(data('users'))->value($app->user->account);
$fields->field('hangupDate')->control('datePicker')->value(helper::today());
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
