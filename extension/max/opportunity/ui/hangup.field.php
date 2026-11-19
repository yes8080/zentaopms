<?php
namespace zin;

global $lang;

$fields = defineFieldList('opportunity.hangup');

$fields->field('assignedTo')->width('1/2')->control('picker')->items(data('members'))->value(data('opportunity.assignedTo'));
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
