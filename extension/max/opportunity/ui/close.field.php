<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('opportunity.close');

$fields->field('resolvedBy')->width('1/2')->control('picker')->required(true)->items(data('members'))->value($app->user->account);
$fields->field('actualClosedDate')->label($lang->opportunity->closedDate)->width('1/2')->control('datePicker')->value(helper::today());
$fields->field('resolution')->width('full')->control('editor')->value('');
