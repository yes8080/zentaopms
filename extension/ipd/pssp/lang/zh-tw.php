<?php
$lang->pssp->common       = $lang->projectCommon . '過程';
$lang->pssp->name         = '裁剪對象';
$lang->pssp->type         = '類型';
$lang->pssp->tailor       = '裁剪';
$lang->pssp->tailorNorm   = '裁剪準則';
$lang->pssp->result       = '裁剪結果';
$lang->pssp->createdBy    = '由誰裁剪';
$lang->pssp->createdDate  = '裁剪日期';
$lang->pssp->canNotTailor = '不可裁剪';

$lang->pssp->browse = '過程列表';
$lang->pssp->update = '過程裁剪';

$lang->pssp->updateSucess = '裁剪信息保存成功';
$lang->pssp->footTips     = '<div class="row items-center gap-2">說明：<i class="icon icon-check text-success"></i> 表示適用，<i class="icon icon-close text-danger"></i> 表示不適用</div>';

$lang->pssp->apiError = new stdclass();
$lang->pssp->apiError->itemsEmpty                  = 'items應當是非空數組。';
$lang->pssp->apiError->itemInvalid                 = 'items中的每一項應當是對象。';
$lang->pssp->apiError->itemTypeInvalid             = 'type的值應當是activity,deliverable。';
$lang->pssp->apiError->itemIDInvalid               = 'id應當大於0。';
$lang->pssp->apiError->itemResultInvalid           = 'result的值應當是yes,no。';
$lang->pssp->apiError->activityNotFound            = '活動%s不存在。';
$lang->pssp->apiError->deliverableNotFound         = '交付物%s不存在。';
$lang->pssp->apiError->deliverableActivityNotFound = '交付物%s所屬活動不存在。';

$lang->pssp->resultList = array();
$lang->pssp->resultList['yes'] = '適用';
$lang->pssp->resultList['no']  = '不適用';

$lang->pssp->typeList = array();
$lang->pssp->typeList['process']     = '過程';
$lang->pssp->typeList['activity']    = '活動';
$lang->pssp->typeList['deliverable'] = '交付物';

$lang->pssp->featureBar['browse']['wait'] = '待裁剪';
$lang->pssp->featureBar['browse']['yes']  = '適用';
$lang->pssp->featureBar['browse']['no']   = '不適用';
