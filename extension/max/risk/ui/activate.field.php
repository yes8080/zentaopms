<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('risk.activate');

$fields->field('assignedTo')->control('picker')->items(data('users'))->value($app->user->account);
$fields->field('activateDate')->control('datePicker')->value(helper::today());
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
