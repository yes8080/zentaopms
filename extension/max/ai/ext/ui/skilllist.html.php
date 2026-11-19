<?php
namespace zin;

$viewMethod = $type == 'private' ? 'viewMySkill' : 'viewSquareSkill';

$cols = array();
$cols['name']        = array('name' => 'name', 'title' => $lang->ai->skills->name, 'width' => 180, 'link' => array('module' => 'ai', 'method' => $viewMethod, 'params' => 'id={id}'), 'hint' => true);
$cols['category']    = array('name' => 'categoryLabel', 'title' => $lang->ai->skills->category, 'width' => 120);
if($type == 'private') $cols['source'] = array('name' => 'sourceLabel', 'title' => $lang->ai->skills->source, 'width' => 120);
$cols['desc']        = array('name' => 'desc', 'title' => $lang->ai->skills->desc, 'minWidth' => 260, 'hint' => true);
$cols['status']      = array('name' => 'statusLabel', 'title' => $lang->ai->skills->status, 'width' => 100);
$cols['createdBy']   = array('name' => 'createdBy', 'title' => $lang->ai->skills->createdBy, 'type' => 'user', 'width' => 120);
$cols['createdDate'] = array('name' => 'createdDate', 'title' => $lang->ai->skills->createdDate, 'width' => 160);
$cols['editedBy']    = array('name' => 'editedBy', 'title' => $lang->ai->skills->editedBy, 'type' => 'user', 'width' => 120);
$cols['editedDate']  = array('name' => 'editedDate', 'title' => $lang->ai->skills->editedDate, 'width' => 160);
$cols['actions']     = array('name' => 'actions', 'title' => $lang->actions, 'type' => 'html', 'width' => 130, 'fixed' => 'right');

foreach($skills as $skill)
{
    $skill->actions = '';
    foreach($skill->actionItems as $action)
    {
        $text           = $action['text'];
        $icon           = $action['icon'];
        $escapedText    = htmlspecialchars($text, ENT_QUOTES);
        $disabledClass  = empty($action['disabled']) ? '' : ' disabled';
        $className      = $action['modal'] ? '' : ' skill-action-btn';
        $url            = $action['url'];
        $actionSkillID  = $action['action'] == 'add' ? helper::safe64Encode((string)$skill->id) : $skill->id;
        $attrs          = $action['modal'] ? " data-toggle='modal'" : " data-id='{$actionSkillID}' data-action='{$action['action']}'";
        $skill->actions .= "<a href='{$url}' class='btn ghost toolbar-item square size-sm text-primary{$className}{$disabledClass}' title='{$escapedText}' aria-label='{$escapedText}'{$attrs}><i class='icon icon-{$icon}'></i></a>";
    }
}

dtable
(
    set::cols($cols),
    set::data($skills),
    set::checkable(false),
    !empty($pager) ? set::footPager(usePager()) : null,
    set::userMap($users),
    set::emptyTip($emptyList)
);
