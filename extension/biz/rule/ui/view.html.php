<?php
/**
 * The view file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

$operateList = $this->loadModel('common')->buildOperateMenu($rule);
$actions     = isset($operateList['mainActions']) ? $operateList['mainActions'] : array();
if(!empty($operateList['suffixActions'])) $actions = array_merge($actions, array(array('type' => 'divider')), $operateList['suffixActions']);

$basicInfoItems = array();
$basicInfoItems[$lang->rule->createdBy]      = array('control' => 'text', 'text' => zget($users, $rule->createdBy));
$basicInfoItems[$lang->rule->createdDate]    = array('control' => 'text', 'text' => $rule->createdDate);
$basicInfoItems[$lang->rule->lastEditedBy]   = array('control' => 'text', 'text' => zget($users, $rule->lastEditedBy));
$basicInfoItems[$lang->rule->lastEditedDate] = array('control' => 'text', 'text' => $rule->lastEditedDate);
$basicInfoItems[$lang->rule->lastRunTime]    = array('control' => 'text', 'text' => $rule->lastRunTime);

$basicInfo = datalist
(
    set::className('rule-basic-info'),
    set::labelWidth(80),
    set::items($basicInfoItems)
);

$tabs = array();
$tabs[] = setting()
    ->group('basic')
    ->class('rule-basic-info')
    ->title($lang->rule->basicInfo)
    ->children(wg($basicInfo));

$sections = array();
$sections[] = setting()
    ->title($lang->rule->method)
    ->control('html')
    ->content(zget($lang->rule->methodList, $rule->method));

$sections[] = setting()
    ->title($lang->rule->type)
    ->control('html')
    ->content(zget($lang->rule->typeList, $rule->type));

if($rule->type == 'group')
{
    $groupList = '';
    $groups    = explode(',', $rule->workflowGroup);
    foreach($groups as $groupID)
    {
        if(!$groupID) continue;
        $groupList .= zget($workflowGroups, $groupID) . ' ';
    }

    $sections[] = setting()
        ->title($lang->rule->workflowGroup)
        ->control('html')
        ->content($groupList);
}

$sections[] = setting()
    ->title($lang->rule->status)
    ->control('html')
    ->content(zget($lang->rule->statusList, $rule->status));

$sections[] = setting()
    ->title($lang->rule->lastRunResult)
    ->control('html')
    ->content(zget($lang->rule->resultList, $rule->lastRunResult));

detail
(
    set::sections($sections),
    set::tabs($tabs),
    set::actions(array_values($actions))
);
