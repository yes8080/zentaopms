<?php
$lang->pssp->common       = $lang->projectCommon . '过程';
$lang->pssp->name         = '裁剪对象';
$lang->pssp->type         = '类型';
$lang->pssp->tailor       = '裁剪';
$lang->pssp->tailorNorm   = '裁剪准则';
$lang->pssp->result       = '裁剪结果';
$lang->pssp->createdBy    = '由谁裁剪';
$lang->pssp->createdDate  = '裁剪日期';
$lang->pssp->canNotTailor = '不可裁剪';

$lang->pssp->browse = '过程列表';
$lang->pssp->update = '过程裁剪';

$lang->pssp->updateSucess = '裁剪信息保存成功';
$lang->pssp->footTips     = '<div class="row items-center gap-2">说明：<i class="icon icon-check text-success"></i> 表示适用，<i class="icon icon-close text-danger"></i> 表示不适用</div>';

$lang->pssp->apiError = new stdclass();
$lang->pssp->apiError->itemsEmpty                  = 'items应当是非空数组。';
$lang->pssp->apiError->itemInvalid                 = 'items中的每一项应当是对象。';
$lang->pssp->apiError->itemTypeInvalid             = 'type的值应当是activity,deliverable。';
$lang->pssp->apiError->itemIDInvalid               = 'id应当大于0。';
$lang->pssp->apiError->itemResultInvalid           = 'result的值应当是yes,no。';
$lang->pssp->apiError->activityNotFound            = '活动%s不存在。';
$lang->pssp->apiError->deliverableNotFound         = '交付物%s不存在。';
$lang->pssp->apiError->deliverableActivityNotFound = '交付物%s所属活动不存在。';

$lang->pssp->resultList = array();
$lang->pssp->resultList['yes'] = '适用';
$lang->pssp->resultList['no']  = '不适用';

$lang->pssp->typeList = array();
$lang->pssp->typeList['process']     = '过程';
$lang->pssp->typeList['activity']    = '活动';
$lang->pssp->typeList['deliverable'] = '交付物';

$lang->pssp->featureBar['browse']['wait'] = '待裁剪';
$lang->pssp->featureBar['browse']['yes']  = '适用';
$lang->pssp->featureBar['browse']['no']   = '不适用';
