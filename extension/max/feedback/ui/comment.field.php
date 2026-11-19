<?php
namespace zin;

global $lang;

$fields = defineFieldList('feedback.comment');

/* 工作流加载字段*/
$type  = data('type');
$title = data('title');
if(empty($type))
{
    $designAction = in_array(zget($_GET, 'action', ''), array('comment', 'reply', 'ask')) ? zget($_GET, 'action', '') : '';
    $type  = $designAction ? $designAction . 'ed' : 'commented';
    $title = $designAction ? $lang->feedback->$designAction : $lang->feedback->comment;
}

/* FAQ field. */
$fields->field('faq')
    ->width('1/2')
    ->label($lang->feedback->faq)
    ->hidden($type != 'replied')
    ->control('picker')
    ->items(data('faqs'));

/* Comment editor. */
$fields->field('comment')
    ->label($title)
    ->required(true)
    ->width('full')
    ->control('editor');

/* Files field. */
$fields->field('files')
    ->label($lang->feedback->files)
    ->width('full')
    ->hidden($type != 'asked')
    ->control('fileSelector');