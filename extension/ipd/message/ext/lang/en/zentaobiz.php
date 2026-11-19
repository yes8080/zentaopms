<?php
global $config;
$lang->message->label->totask               = 'To Task';
$lang->message->label->tostory              = "To {$lang->SRCommon}";
$lang->message->label->totodo               = 'To To-do';
$lang->message->label->tobug                = 'To Bug';
$lang->message->label->toticket             = 'To Ticket';
$lang->message->label->asked                = 'Asked';
$lang->message->label->replied              = 'Replied';
$lang->message->label->reviewed             = 'Reviewed';
$lang->message->label->processed            = 'Processed';
$lang->message->label->deploypublished      = 'Published';
$lang->message->label->recall               = 'Recalled';
$lang->message->label->processedbyticket    = 'Processed By Ticket';
$lang->message->label->processedbystory     = "Processed By {$lang->SRCommon}";
$lang->message->label->processedbytask      = 'Processed By Task';
$lang->message->label->processedbybug       = 'Processed By Bug';
$lang->message->label->processedbytodo      = 'Processed By To-do';
$lang->message->label->processedbydemand    = 'Processed By Demand';
if($config->enableER) $lang->message->label->processedbyepic      = "Processed By {$lang->ERCommon}";
if($config->URAndSR)  $lang->message->label->processedbyuserstory = "Processed By {$lang->URCommon}";

if($config->enableER)$lang->message->label->toepic      = "To {$lang->ERCommon}";
if($config->URAndSR) $lang->message->label->touserstory = "To {$lang->URCommon}";

$lang->message->noticeText->approvalsubmit = '{actor} submitted {objectType}《{objectTitle}》for review, please approve it promptly.';
$lang->message->noticeText->approvalcancel = '{actor} withdrew {objectType}《{objectTitle}》from review.';
$lang->message->noticeText->approvalreview = 'The {objectType} 《{objectTitle}》 you submitted has been processed by {actor}, with the result being: {reviewResult}. {reviewComment}';
$lang->message->noticeText->forwarded      = '{actor} forwarded {objectType}《{objectTitle}》to you, please handle it promptly.';
$lang->message->noticeText->reverted       = '{actor} reverted {objectType}《{objectTitle}》, please revise and resubmit it.';

$lang->message->noticeText->extend['approvalsubmit']['cc']    = '{actor} submitted {objectType}《{objectTitle}》for review. You have been copied.';
$lang->message->noticeText->extend['approvalsubmit']['other'] = '{actor} submitted {objectType}《{objectTitle}》for review.';
$lang->message->noticeText->extend['approvalcancel']['cc']    = '{actor} withdrew {objectType}《{objectTitle}》from review. You have been copied.';
$lang->message->noticeText->extend['approvalcancel']['other'] = '{actor} withdrew {objectType}《{objectTitle}》from review.';
$lang->message->noticeText->extend['approvalreview']['cc']    = 'The {objectType} submitted by {submitter}, titled 《{objectTitle}》, has been processed by {actor}, with the result being: {reviewResult}. {reviewComment} You have been copied.';
$lang->message->noticeText->extend['approvalreview']['other'] = 'The {objectType} submitted by {submitter}, titled 《{objectTitle}》, has been processed by {actor}, with the result being: {reviewResult}. {reviewComment}';
$lang->message->noticeText->extend['forwarded']['cc']         = '{actor} forwarded {objectType}《{objectTitle}》to {assignedTo} for handling. You have been copied.';
$lang->message->noticeText->extend['forwarded']['other']      = '{actor} forwarded {objectType}《{objectTitle}》to {assignedTo} for handling.';
$lang->message->noticeText->extend['reverted']['cc']          = '{actor} reverted {objectType}《{objectTitle}》. You have been copied.';
$lang->message->noticeText->extend['reverted']['other']       = '{actor} reverted {objectType}《{objectTitle}》.';

$lang->message->noticeTitle->approvalsubmit = '{objectType} Submitted for Review';
$lang->message->noticeTitle->approvalcancel = '{objectType} Review Withdrawn';
$lang->message->noticeTitle->approvalreview = '{objectType} Review Result Notice';
$lang->message->noticeTitle->forwarded      = '{objectType} Forwarded';
$lang->message->noticeTitle->reverted       = '{objectType} Reverted';
