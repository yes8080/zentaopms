<?php
namespace zin;

global $lang;

$fields = defineFieldList('feedback.edit');

/* Product field. */
$fields->field('product')
    ->width('1/2')
    ->control('picker')
    ->required(true)
    ->items(data('products'))
    ->value((!empty(data('productID')) ? data('productID') : data('feedback.product')));

/* Module field. */
$fields->field('module')
    ->width('1/2')
    ->control('picker')
    ->required(true)
    ->items(data('modules'))
    ->value(data('feedback.module'));

/* Type field. */
$fields->field('type')
    ->width('1/2')
    ->control('picker')
    ->items($lang->feedback->typeList)
    ->value(data('feedback.type'));

/* Title field. */
$fields->field('title')
    ->required(true)
    ->width('full')
    ->control('inputGroup')
    ->itemBegin('title')
        ->control('input')
        ->value(data('feedback.title'))
    ->itemEnd()
    ->itemBegin('public')
        ->control('checkbox')
        ->text($lang->feedback->public)
        ->value(1)
        ->rootClass('btn')
        ->checked((bool)data('feedback.public'))
    ->itemEnd()
    ->item($lang->feedback->pri)
    ->itemBegin('pri')
        ->control('priPicker')
        ->width('120px')
        ->items($lang->feedback->priList)
        ->value(data('feedback.pri'))
    ->itemEnd();

/* Desc field. */
$fields->field('desc')
    ->width('full')
    ->control(array('control' => 'editor'))
    ->value(data('feedback.desc'));

/* FeedbackBy field. */
$fields->field('feedbackBy')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback.feedbackBy'));

/* Source field. */
$fields->field('source')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback.source'));

/* NotifyEmail field. */
$fields->field('notifyEmail')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback.notifyEmail'));

/* Mailto field. */
$fields->field('mailto')
    ->width('1/2')
    ->control('mailto')
    ->items(data('users'))
    ->value(data('feedback.mailto'))
    ->multiple(true);

/* Keywords field. */
$fields->field('keywords')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback.keywords'));

/* Files field. */
$feedbackFiles = data('feedback.files');
$files = !empty($feedbackFiles) ? array_values($feedbackFiles) : array();

$fields->field('files')
    ->width('full')
    ->control('fileSelector', array('defaultFiles' => $files));

/* Notify field. */
$fields->field('notify')
    ->width('1/2')
    ->control('checkbox', array('text' => $lang->feedback->mailNotify, 'checked' => (bool)data('feedback.notify')))
    ->value(1);
