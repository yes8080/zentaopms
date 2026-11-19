<?php
namespace zin;

global $lang;

$fields = defineFieldList('risk.assignTo');

$fields->field('assignedTo')->width('1/3')->control('picker')->items(data('users'))->value(data('risk.assignedTo'));
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
