<?php
namespace zin;

$canEditContent = str_contains(',draft,changing,', "," . data('story.status') . ",");

$fields = fieldList('story.edit');
$fields->field('docs')
    ->position('info')
    ->width('full')
    ->control(function() use($canEditContent)
    {
        return doclist(set::data(data('story')), set::mode($canEditContent ? 'edit' : 'view'));
    })
    ->moveBefore('files');
