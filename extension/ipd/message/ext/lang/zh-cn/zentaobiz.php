<?php
global $config;
$lang->message->label->totask               = '转任务';
$lang->message->label->tostory              = "转{$lang->SRCommon}";
$lang->message->label->totodo               = '转待办';
$lang->message->label->tobug                = '转Bug';
$lang->message->label->toticket             = '转工单';
$lang->message->label->asked                = '追问';
$lang->message->label->replied              = '回复';
$lang->message->label->reviewed             = '审批';
$lang->message->label->processed            = '已处理';
$lang->message->label->deploypublished      = '上线';
$lang->message->label->recall               = '撤回';
$lang->message->label->processedbyticket    = '由工单处理';
$lang->message->label->processedbystory     = "由{$lang->SRCommon}处理";
$lang->message->label->processedbytask      = '由任务处理';
$lang->message->label->processedbybug       = '由Bug处理';
$lang->message->label->processedbytodo      = '由待办处理';
$lang->message->label->processedbydemand    = '由需求池需求处理';
if($config->enableER) $lang->message->label->processedbyepic      = "由{$lang->ERCommon}处理";
if($config->URAndSR)  $lang->message->label->processedbyuserstory = "由{$lang->URCommon}处理";

if($config->enableER) $lang->message->label->toepic      = "转{$lang->ERCommon}";
if($config->URAndSR)  $lang->message->label->touserstory = "转{$lang->URCommon}";

$lang->message->noticeText->approvalsubmit = '{actor} 提交了{objectType}《{objectTitle}》的评审，请您及时审批。';
$lang->message->noticeText->approvalcancel = '{actor} 撤回了{objectType}《{objectTitle}》的评审。';
$lang->message->noticeText->approvalreview = '您提交的{objectType}《{objectTitle}》已由 {actor} 处理，结果为：{reviewResult}。{reviewComment}';
$lang->message->noticeText->forwarded      = '{actor} 将{objectType}《{objectTitle}》转交给了您，请及时处理。';
$lang->message->noticeText->reverted       = '{actor} 将{objectType}《{objectTitle}》回退，请您修改后重新提交。';

$lang->message->noticeText->extend['approvalsubmit']['cc']    = '{actor} 提交了{objectType}《{objectTitle}》的评审，您已被抄送。';
$lang->message->noticeText->extend['approvalsubmit']['other'] = '{actor} 提交了{objectType}《{objectTitle}》的评审。';
$lang->message->noticeText->extend['approvalcancel']['cc']    = '{actor} 撤回了{objectType}《{objectTitle}》的评审，您已被抄送。';
$lang->message->noticeText->extend['approvalcancel']['other'] = '{actor} 撤回了{objectType}《{objectTitle}》的评审。';
$lang->message->noticeText->extend['approvalreview']['cc']    = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 处理，结果为：{reviewResult}。{reviewComment}您已被抄送。';
$lang->message->noticeText->extend['approvalreview']['other'] = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 处理，结果为：{reviewResult}。{reviewComment}';
$lang->message->noticeText->extend['forwarded']['cc']         = '{actor} 将{objectType}《{objectTitle}》转交给{assignedTo}处理，您已被抄送。';
$lang->message->noticeText->extend['forwarded']['other']      = '{actor} 将{objectType}《{objectTitle}》转交给{assignedTo}处理。';
$lang->message->noticeText->extend['reverted']['cc']          = '{actor} 将{objectType}《{objectTitle}》回退，您已被抄送。';
$lang->message->noticeText->extend['reverted']['other']       = '{actor} 将{objectType}《{objectTitle}》回退。';

$lang->message->noticeTitle->approvalsubmit = '{objectType}提交评审';
$lang->message->noticeTitle->approvalcancel = '{objectType}撤回评审';
$lang->message->noticeTitle->approvalreview = '{objectType}评审结果通知';
$lang->message->noticeTitle->forwarded      = '{objectType}已转交';
$lang->message->noticeTitle->reverted       = '{objectType}已回退';
