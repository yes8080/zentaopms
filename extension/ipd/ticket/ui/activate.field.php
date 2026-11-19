<?php
namespace zin;

global $lang;

$fields = defineFieldList('ticket.activate');

$fields->field('assignedTo')
    ->label($lang->ticket->assignedTo)
    ->width('full')
    ->control('picker')
    ->items(data('users'))
    ->value(data('assignedTo'));

$fields->field('comment')
    ->label($lang->comment)
    ->width('full')
    ->control('editor');
