<?php
namespace zin;

global $lang, $app;

$fields = defineFieldList('ticket.finish');

$buildHasConsumed = function() use ($lang)
{
    $ticket = data('ticket');
    if(empty($ticket)) return null;
    return inputControl
    (
        input
        (
            set::disabled(true),
            set::value($ticket->consumed)
        ),
        to::suffix($lang->workingHour),
        set::suffixWidth(20)
    );
};

$buildCurrentConsumed = function() use ($lang)
{
    return inputControl
    (
        input
        (
            set::name('currentConsumed'),
            set::value('0'),
            setData(array('on' => 'change', 'call' => 'updateConsumed'))
        ),
        to::suffix($lang->ticket->hour),
        set::suffixWidth(20)
    );
};

$buildConsumed = function() use ($lang)
{
    $ticket = data('ticket');
    return inputControl
    (
        input
        (
            set::disabled(true),
            set::name('consumed'),
            set::value($ticket->consumed)
        ),
        to::suffix($lang->ticket->hour),
        set::suffixWidth(20)
    );
};

$fields->field('hasConsumed')
    ->width('1/2')
    ->label($lang->ticket->hasConsumed)
    ->control($buildHasConsumed);

$fields->field('currentConsumed')
    ->width('1/2')
    ->label($lang->ticket->currentConsumed)
    ->control($buildCurrentConsumed);

$fields->field('consumed')
    ->width('1/2')
    ->label($lang->ticket->consumed)
    ->control($buildConsumed);

$fields->field('resolvedBy')
    ->width('1/2')
    ->label($lang->ticket->resolvedBy)
    ->control('picker')
    ->items(data('users'))
    ->value($app->user->account);

$fields->field('resolvedDate')
    ->width('1/2')
    ->label($lang->ticket->resolvedDate)
    ->required(true)
    ->control('datetimePicker')
    ->value(helper::now());

$fields->field('files')
    ->width('full')
    ->label($lang->files)
    ->control('fileSelector');

$fields->field('resolution')
    ->width('full')
    ->label($lang->ticket->resolution)
    ->required(true)
    ->control('editor');

$fields->field('comment')
    ->width('full')
    ->label($lang->comment)
    ->control('editor');
