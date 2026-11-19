<?php
namespace zin;

global $lang;

$fields = defineFieldList('feedback.create');

/* Product field. */
$fields->field('product')
    ->width('1/2')
    ->control('picker')
    ->required(true)
    ->items(data('products'))
    ->value((!empty(data('productID')) && data('productID') !== 'all') ? data('productID') : '');

/* Module field. */
$moduleManageLink = null;
if(common::hasPriv('tree', 'browse'))
{
    global $app;
    $moduleProductID = data('productID');
    if($app->user->admin || strpos(',' . $app->user->view->products . ',', ',' . $moduleProductID . ',') !== false)
    {
        $moduleManageLink = createLink('tree', 'browse', "rootID={$moduleProductID}&viewType=feedback");
    }
}

$moduleControlOptions = array('control' => 'modulePicker', 'required' => true);
if($moduleManageLink) $moduleControlOptions['manageLink'] = $moduleManageLink;

$fields->field('module')
    ->width('1/2')
    ->control($moduleControlOptions)
    ->items(data('modules'))
    ->value(data('feedback') ? data('feedback.module') : data('moduleID'));

/* Type field. */
$fields->field('type')
    ->width('1/2')
    ->control('picker')
    ->items($lang->feedback->typeList)
    ->value(data('feedback') ? data('feedback.type') : '');

/* Title field. */
$titleChecked = data('feedback') ? (bool)data('feedback.public') : true;
$titlePri     = data('feedback') ? data('feedback.pri') : 3;

$fields->field('title')
    ->required(true)
    ->width('full')
    ->control('inputGroup')
    ->itemBegin('title')
        ->control('input')
        ->value(data('feedback') ? data('feedback.title') : '')
    ->itemEnd()
    ->itemBegin('public')
        ->control('checkbox')
        ->text($lang->feedback->public)
        ->value(1)
        ->rootClass('btn')
        ->checked($titleChecked)
    ->itemEnd()
    ->item($lang->feedback->pri)
    ->itemBegin('pri')
        ->control('priPicker')
        ->width('120px')
        ->items($lang->feedback->priList)
        ->value($titlePri)
    ->itemEnd();

/* Desc field. */
$fields->field('desc')
    ->width('full')
    ->control(array('control' => 'editor', 'templateType' => 'feedback'))
    ->value(data('feedback') ? data('feedback.desc') : '');

/* FeedbackBy field. */
$fields->field('feedbackBy')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback') ? data('feedback.feedbackBy') : '');

/* Source field. */
$fields->field('source')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback') ? data('feedback.source') : '');

/* NotifyEmail field. */
$fields->field('notifyEmail')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback') ? data('feedback.notifyEmail') : '');

/* Mailto field. */
$fields->field('mailto')
    ->width('1/2')
    ->control('mailto')
    ->items(data('users'))
    ->value(data('feedback') ? data('feedback.mailto') : '')
    ->multiple(true);

/* Keywords field. */
$fields->field('keywords')
    ->width('1/2')
    ->control('input')
    ->value(data('feedback') ? data('feedback.keywords') : '');

/* Files field. */
$feedbackFiles = data('feedback.files');
$files = !empty($feedbackFiles) ? array_values($feedbackFiles) : array();

$fields->field('files')
    ->width('full')
    ->control('fileSelector', array('defaultFiles' => $files));

$fields->field('fileList')
    ->control('hidden')
    ->value(!empty($feedbackFiles) ? $feedbackFiles : array());

/* Notify field. */
$notifyChecked = data('feedback') ? (bool)data('feedback.notify') : true;

$fields->field('notify')
    ->width('1/2')
    ->control('checkbox', array('text' => $lang->feedback->mailNotify, 'checked' => $notifyChecked))
    ->value(1);
