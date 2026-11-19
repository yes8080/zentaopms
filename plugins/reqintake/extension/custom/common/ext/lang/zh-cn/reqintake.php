<?php
if(!isset($lang->reqintake)) $lang->reqintake = new stdclass();
$lang->reqintake->common = '需求池';
$lang->navGroup->reqintake = 'reqintake';
$lang->navIcons['reqintake'] = $lang->navIcons['product'];
$lang->mainNav->reqintake = "{$lang->navIcons['reqintake']} 需求池|reqintake|index|";
$order = 16;
while(isset($lang->mainNav->menuOrder[$order])) $order++;
$lang->mainNav->menuOrder[$order] = 'reqintake';
