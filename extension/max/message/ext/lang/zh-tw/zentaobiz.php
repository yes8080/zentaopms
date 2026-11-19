<?php
global $config;
$lang->message->label->totask               = '轉任務';
$lang->message->label->tostory              = "轉{$lang->SRCommon}";
$lang->message->label->totodo               = '轉待辦';
$lang->message->label->tobug                = '轉Bug';
$lang->message->label->toticket             = '轉工單';
$lang->message->label->asked                = '追問';
$lang->message->label->replied              = '回覆';
$lang->message->label->reviewed             = '審批';
$lang->message->label->processed            = '已處理';
$lang->message->label->deploypublished      = '上線';
$lang->message->label->recall               = '撤回';
$lang->message->label->processedbyticket    = '由工單處理';
$lang->message->label->processedbystory     = "由{$lang->SRCommon}處理";
$lang->message->label->processedbytask      = '由任務處理';
$lang->message->label->processedbybug       = '由Bug處理';
$lang->message->label->processedbytodo      = '由待辦處理';
$lang->message->label->processedbydemand    = '由需求池需求處理';
if($config->enableER) $lang->message->label->processedbyepic      = "由{$lang->ERCommon}處理";
if($config->URAndSR)  $lang->message->label->processedbyuserstory = "由{$lang->URCommon}處理";

if($config->enableER) $lang->message->label->toepic      = "轉{$lang->ERCommon}";
if($config->URAndSR)  $lang->message->label->touserstory = "轉{$lang->URCommon}";

$lang->message->noticeText->approvalsubmit = '{actor} 提交了{objectType}《{objectTitle}》的評審，請您及時審批。';
$lang->message->noticeText->approvalcancel = '{actor} 撤回了{objectType}《{objectTitle}》的評審。';
$lang->message->noticeText->approvalreview = '您提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。{reviewComment}';
$lang->message->noticeText->forwarded      = '{actor} 將{objectType}《{objectTitle}》轉交給了您，請及時處理。';
$lang->message->noticeText->reverted       = '{actor} 將{objectType}《{objectTitle}》回退，請您修改後重新提交。';

$lang->message->noticeText->extend['approvalsubmit']['cc']    = '{actor} 提交了{objectType}《{objectTitle}》的評審，您已被抄送。';
$lang->message->noticeText->extend['approvalsubmit']['other'] = '{actor} 提交了{objectType}《{objectTitle}》的評審。';
$lang->message->noticeText->extend['approvalcancel']['cc']    = '{actor} 撤回了{objectType}《{objectTitle}》的評審，您已被抄送。';
$lang->message->noticeText->extend['approvalcancel']['other'] = '{actor} 撤回了{objectType}《{objectTitle}》的評審。';
$lang->message->noticeText->extend['approvalreview']['cc']    = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。{reviewComment}您已被抄送。';
$lang->message->noticeText->extend['approvalreview']['other'] = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。{reviewComment}';
$lang->message->noticeText->extend['forwarded']['cc']         = '{actor} 將{objectType}《{objectTitle}》轉交給{assignedTo}處理，您已被抄送。';
$lang->message->noticeText->extend['forwarded']['other']      = '{actor} 將{objectType}《{objectTitle}》轉交給{assignedTo}處理。';
$lang->message->noticeText->extend['reverted']['cc']          = '{actor} 將{objectType}《{objectTitle}》回退，您已被抄送。';
$lang->message->noticeText->extend['reverted']['other']       = '{actor} 將{objectType}《{objectTitle}》回退。';

$lang->message->noticeTitle->approvalsubmit = '{objectType}提交評審';
$lang->message->noticeTitle->approvalcancel = '{objectType}撤回評審';
$lang->message->noticeTitle->approvalreview = '{objectType}評審結果通知';
$lang->message->noticeTitle->forwarded      = '{objectType}已轉交';
$lang->message->noticeTitle->reverted       = '{objectType}已回退';
