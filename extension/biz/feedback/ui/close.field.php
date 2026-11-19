<?php
namespace zin;

global $lang;

$fields = defineFieldList('feedback.close');

/* ClosedReason field. */
$fields->field('closedReason')
    ->width('1/3')
    ->required(true)
    ->control('picker')
    ->items($lang->feedback->closedReasonList)
    ->value(data('closedReason'));

/* RepeatFeedback field. */
$fields->field('repeatFeedback')
    ->width('1/3')
    ->required(true)
    ->className('repeatFeedbackBox')
    ->hidden(true)
    ->control('picker')
    ->items(data('feedbacks'));

/* Comment field. */
$fields->field('comment')
    ->label($lang->comment)
    ->width('full')
    ->control('editor');