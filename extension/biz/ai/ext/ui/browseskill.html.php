<?php
namespace zin;

$this->app->loadLang('ai');

jsVar('confirmDisable', $lang->ai->skills->confirmDisable);
jsVar('confirmStop', isset($lang->ai->skills->confirmStop) ? $lang->ai->skills->confirmStop : $lang->ai->skills->confirmDisable);
jsVar('confirmRemove', $lang->ai->skills->confirmRemove);

$viewType = $this->cookie->aiSkillsViewType ? $this->cookie->aiSkillsViewType : 'card';
$currentMethod = $type == 'private' ? 'myskill' : 'browseskill';
jsVar('currentMethod', $currentMethod);
$emptyList = $type == 'private' ? $lang->ai->skills->myEmptyList : $lang->ai->skills->squareEmptyList;
$createMethod = $type == 'private' ? 'createMySkill' : 'createSquareSkill';
$createPriv   = $type == 'private' ? 'createMySkill' : 'createSquareSkill';

featureBar
(
    set::method($currentMethod),
    set::current($status),
    set::linkParams("status={key}&category={$category}"),
    set::linkMethod($currentMethod),
    set::itemLink(array('QUERY' => createLink('ai', $currentMethod, "status=bysearch&category={$category}&queryID={key}"))),
    li(searchToggle(set::module($currentMethod), set::open($status == 'bysearch')))
);

sidebar
(
    moduleMenu
    (
        set::showDisplay(false),
        set::modules($moduleTree),
        set::activeKey($category ? $category : ''),
        set::closeLink(createLink('ai', $currentMethod)),
        $type != 'private' && hasPriv('ai', 'editSkillCategory') ? to::footer
        (
            btn
            (
                setClass('m-4 mt-0'),
                set::icon('cog-outline'),
                set::url(createLink('ai', 'editSkillCategory')),
                set::type('primary-pale'),
                $lang->ai->skills->maintenanceCategory
            )
        ) : null
    )
);

toolbar
(
    item(set(array('type' => 'btnGroup', 'items' => array(
        array('icon' => 'format-list-bulleted', 'class' => 'btn-icon switchButton' . ($viewType == 'list' ? ' text-primary' : ''), 'data-type' => 'list', 'hint' => $lang->ai->prompts->viewTypeList['list']),
        array('icon' => 'cards-view', 'class' => 'btn-icon switchButton' . ($viewType == 'card' ? ' text-primary' : ''), 'data-type' => 'card', 'hint' => $lang->ai->prompts->viewTypeList['card'])
    )))),
    hasPriv('ai', $createPriv) ? btn(setClass('btn primary create-skill-btn'), set::icon('plus'), set::url(createLink('ai', $createMethod)), $lang->ai->skills->create, set('data-toggle', 'modal')) : null
);

foreach($skills as $skill)
{
    $skill->actionItems = $this->ai->getSkillActions($skill, $type);
}

if($viewType == 'card')     include 'skillcard.html.php';
elseif($viewType == 'list') include 'skilllist.html.php';
