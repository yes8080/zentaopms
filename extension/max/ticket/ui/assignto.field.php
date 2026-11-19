<?php
namespace zin;

global $lang;

$fields = defineFieldList('ticket.assignTo');

$fields->field('assignedTo')
    ->label($lang->ticket->assignedTo)
    ->width('1/2')
    ->control('picker')
    ->items(data('users'))
    ->value(data('ticket.assignedTo'));

$fields->field('left')
    ->width('1/2')
    ->required(true)
    ->control(array('control' => 'inputControl', 'suffix' => $lang->ticket->hour, 'suffixWidth' => 20))
    ->value(data('ticket.left'));

$fields->field('comment')
    ->label($lang->comment)
    ->width('full')
    ->control('editor');
