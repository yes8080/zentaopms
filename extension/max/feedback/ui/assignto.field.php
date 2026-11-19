<?php
namespace zin;

global $lang;

$fields = defineFieldList('feedback.assignTo');

/* AssignedTo field. */
$fields->field('assignedTo')
    ->width('1/3')
    ->control('picker')
    ->label($lang->feedback->assignedTo)
    ->items(data('users'))
    ->value(data('feedback.assignedTo'));

/* Mailto field. */
$fields->field('mailto')
    ->label($lang->bug->mailto)
    ->control('mailto')
    ->items(data('users'))
    ->width('full')
    ->value(data('feedback.mailto'));

/* Comment field. */
$fields->field('comment')
    ->label($lang->comment)
    ->width('full')
    ->control('editor');