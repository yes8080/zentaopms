<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('opportunity.activate');

$fields->field('assignedTo')->width('1/2')->control('picker')->items(data('members'))->value($app->user->account);
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
