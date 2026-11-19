<?php
namespace zin;

$fields = fieldList('story.change');
$fields->field('docs')
    ->position('info')
    ->width('full')
    ->control(function()
    {
        return doclist(set::data(data('story')));
    })
    ->moveBefore('files');
