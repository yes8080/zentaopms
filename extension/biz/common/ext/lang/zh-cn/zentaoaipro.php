<?php
$lang->aiteammate = new stdclass();
$lang->aiteammate->common = '数字员工';

$lang->aitask = new stdclass();
$lang->aitask->common = '数字员工任务';

$lang->aiprocedure = new stdclass();
$lang->aiprocedure->common = '工序';

if(isset($lang->my->menu->work))
{
    $lang->my->menu->work['subMenu']->aitask = array('link' => "{$lang->aitask->common}|my|work|mode=aitask&type=done", 'alias' => 'aitask');
    $lang->my->menu->work['menuOrder'][6] = 'aitask';
}

if(isset($lang->my->menu->contribute))
{
    $lang->my->menu->contribute['subMenu']->aitask = array('link' => "{$lang->aitask->common}|my|contribute|mode=aitask&type=assignedtome", 'alias' => 'aitask');
    $lang->my->menu->contribute['menuOrder'][6] = 'aitask';
}

$lang->aiapp->menu->teammate = array('link' => "{$lang->aiteammate->common}|aiteammate|browse|disabled=all", 'alias' => 'browse,create,edit,enable,disable,delete,uploadavatar,cropavatar', 'subModule' => 'aiteammate,aitask');
$lang->aiapp->menuOrder[7] = 'teammate';

$lang->aiapp->menu->workbench = array('link' => "{$lang->aiprocedure->common}|aiprocedure|browse", 'alias' => 'browse,create,edit,design,publish,unpublish,delete', 'subModule' => 'aiprocedure');
$lang->aiapp->menuOrder[12] = 'workbench';
$lang->navGroup->aiprocedure = 'aiapp';