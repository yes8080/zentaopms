<?php
namespace zin;

global $lang, $app;

$fields = defineFieldList('ticket.close');

$fields->field('closedReason')
    ->label($lang->ticket->closedReason)
    ->required(true)
    ->width('1/2')
    ->control('picker')
    ->items($lang->ticket->closedReasonList);

$fields->field('repeatTicket')
    ->label($lang->ticket->repeatTicket)
    ->required(true)
    ->width('1/2')
    ->control(array('control' => 'picker', 'required' => false))
    ->items(data('tickets'))
    ->hidden(true)
    ->set('class', 'repeatBox');

$fields->field('resolvedBy')
    ->label($lang->ticket->resolvedBy)
    ->required(true)
    ->width('1/2')
    ->control('picker')
    ->items(data('users'))
    ->value($app->user->account)
    ->hidden(true)
    ->set('class', 'resolvedBox');

$fields->field('resolvedDate')
    ->label($lang->ticket->resolvedDate)
    ->required(true)
    ->width('1/2')
    ->control('datetimePicker')
    ->hidden(true)
    ->set('class', 'resolvedBox');

$fields->field('files')
    ->label($lang->files)
    ->width('full')
    ->control('fileSelector')
    ->hidden(true)
    ->set('class', 'resolvedBox');

$fields->field('resolution')
    ->label($lang->ticket->resolution)
    ->required(true)
    ->width('full')
    ->control('editor')
    ->hidden(true)
    ->set('class', 'resolvedBox');

$fields->field('comment')
    ->label($lang->comment)
    ->width('full')
    ->control('editor');
