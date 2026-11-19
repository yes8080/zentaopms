<?php
namespace zin;

global $lang;

$fields = defineFieldList('ticket.start');

$fields->field('assignedTo')
    ->label($lang->ticket->assignedTo)
    ->width('1/2')
    ->control('picker')
    ->items(data('users'))
    ->value(data('assignedTo'));

$fields->field('comment')
    ->label($lang->comment)
    ->width('full')
    ->control('editor');
