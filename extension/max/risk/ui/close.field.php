<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('risk.close');

$fields->field('resolvedBy')->control('picker')->items(data('users'))->value($app->user->account);
$fields->field('actualClosedDate')->label($lang->risk->closedDate)->control('datePicker')->value(helper::today());
$fields->field('resolution')->width('full')->control('editor');
