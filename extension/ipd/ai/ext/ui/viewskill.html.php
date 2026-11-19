<?php
namespace zin;

$getBasicInfoItems = function($skill) use($users, $lang, $categories)
{
    $items = array();
    $statusList = $skill->type == 'private' ? $lang->ai->skills->myStatusList : $lang->ai->skills->squareStatusList;
    $statusText = zget($statusList, $skill->status, '');
    if($skill->type == 'private' && !empty($skill->fromID) && isset($skill->sourceStatus) && $skill->sourceStatus == 'draft') $statusText = $lang->ai->skills->offline;
    $items[$lang->ai->skills->status]      = array('control' => 'status', 'class' => "status-skill", 'status'  => $skill->status, 'text' => $statusText);
    $items[$lang->ai->skills->category]    = zget($categories, $skill->category, '');
    $items[$lang->ai->skills->source]      = !empty($skill->fromID) ? $lang->ai->skills->square : '';
    $items[$lang->ai->skills->createdDate] = $skill->createdDate;
    $items[$lang->ai->skills->createdBy]   = zget($users, $skill->createdBy);
    $items[$lang->ai->skills->editedDate]  = $skill->editedDate;
    $items[$lang->ai->skills->editedBy]    = zget($users, $skill->editedBy);

    return $items;
};

$sections = array();
$sections[] = setting()
    ->title($lang->ai->skills->desc)
    ->control('html')
    ->content(empty($skill->desc) ? $lang->noDesc : $skill->desc);

/* 展示技能附件。*/
if(!empty($skill->fileTree))
{
    $getSkillFileType = function(string $path): string
    {
        if($path == 'SKILL.md') return 'markdown';

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if(in_array($ext, array('md', 'markdown'))) return 'markdown';

        return 'text';
    };

    $skillFiles = array();
    $fileIndex  = 0;
    $renderSkillFileTree = function(array $nodes) use(&$renderSkillFileTree, &$skillFiles, &$fileIndex, $skill, $getSkillFileType)
    {
        $items = array();
        foreach($nodes as $node)
        {
            if($node['type'] === 'dir')
            {
                $items[] = li(
                    setClass('skill-file-dir expanded'),
                    div(
                        setClass('skill-file-dir-header'),
                        icon(
                            setClass('skill-file-toggle'),
                            set::name('minus'),
                            on::click()->stop()->call('toggleSkillFileDir', jsRaw('event'))
                        ),
                        icon(set::name('folder-o')),
                        span($node['name'])
                    ),
                    $renderSkillFileTree($node['children'])
                );
                continue;
            }

            $path         = $node['path'];
            $url          = createLink('ai', 'ajaxViewSkill', "id={$skill->id}&path=" . helper::safe64Encode($path));
            $currentIndex = $fileIndex;

            $skillFiles[] = array(
                'name'        => $path,
                'type'        => $getSkillFileType($path),
                'extension'   => pathinfo($path, PATHINFO_EXTENSION),
                'size'        => 0,
                'url'         => $url,
                'downloadUrl' => $url,
                'previewUrl'  => $url,
            );

            $items[] = li(
                setClass('skill-file-item'),
                on::click()->call('previewSkillFile', $currentIndex),
                icon(set::name('file-text')),
                span($node['name'])
            );
            $fileIndex++;
        }

        return ul(setClass('skill-file-tree'), $items);
    };

    $sections[] = setting()
        ->title($lang->ai->skills->skillFiles)
        ->control('html')
        ->content(wg(div(setClass('skill-file-tree-wrapper'), $renderSkillFileTree($skill->fileTree)))
    );

    jsVar('skillFiles', $skillFiles);
}

$tabs[] = setting()
    ->group('basic')
    ->title($lang->ai->skills->labelBasic)
    ->control('datalist')
    ->labelWidth(80)
    ->items($getBasicInfoItems($skill));

$viewActionName = $skill->type == 'private' ? 'viewmyskill' : 'viewsquareskill';
if($skill->type == 'private' && !empty($skill->fromID))
{
    $config->ai->actions->{$viewActionName}['mainActions']   = array();
    $config->ai->actions->{$viewActionName}['suffixActions'] = array();
}
elseif($skill->type == 'private' && $skill->createdBy == $app->user->account)
{
    $config->ai->actions->{$viewActionName}['suffixActions'] = array_diff($config->ai->actions->{$viewActionName}['suffixActions'], array('deletesquareskill'));
}
elseif($skill->type == 'public')
{
    $config->ai->actions->{$viewActionName}['suffixActions'] = array_diff($config->ai->actions->{$viewActionName}['suffixActions'], array('deleteskill'));
}
else
{
    $config->ai->actions->{$viewActionName}['mainActions']   = array();
    $config->ai->actions->{$viewActionName}['suffixActions'] = array();
}

$buildSkillOperateAction = function($action) use($skill, $lang)
{
    if($action['action'] == 'edit')
    {
        return array(
            'text'        => '',
            'hint'        => $action['text'],
            'icon'        => $action['icon'],
            'url'         => $action['url'],
            'disabled'    => !empty($action['disabled']),
            'data-toggle' => 'modal'
        );
    }

    $disableMethod  = $skill->type == 'private' ? 'disableSkill' : 'disableSquareSkill';
    $encodedSkillID = helper::safe64Encode((string)$skill->id);
    $actionUrls     = array(
        'release'         => createLink('ai', 'releaseSkill', "skillID={$skill->id}"),
        'publish'         => createLink('ai', 'publishSkill', "skillID={$skill->id}"),
        'disable'         => createLink('ai', $disableMethod, "skillID={$skill->id}"),
        'releaseToSquare' => createLink('ai', 'releaseSkillToSquare', "skillID={$skill->id}"),
        'add'             => createLink('ai', 'addSkill', "skillID={$encodedSkillID}"),
        'remove'          => createLink('ai', 'removeSkill', "skillID={$skill->id}")
    );
    if(!isset($actionUrls[$action['action']])) return null;

    $item = array('text' => $action['text'], 'icon' => $action['icon'], 'url' => $actionUrls[$action['action']], 'disabled' => !empty($action['disabled']));
    if($action['action'] == 'releaseToSquare')
    {
        $item['data-toggle'] = 'modal';
        $item['data-size']   = 'sm';
        return $item;
    }

    $item['className'] = 'ajax-submit';
    $viewMethod = $skill->type == 'private' ? 'viewMySkill' : 'viewSquareSkill';
    $item['data-load'] = $action['action'] == 'remove' ? createLink('ai', 'mySkill') : createLink('ai', $viewMethod, "id={$skill->id}");
    if($action['action'] == 'remove')  $item['data-confirm'] = $lang->ai->skills->confirmRemove;
    if($action['action'] == 'disable') $item['data-confirm'] = $skill->type == 'private' && isset($lang->ai->skills->confirmStop) ? $lang->ai->skills->confirmStop : $lang->ai->skills->confirmDisable;

    return $item;
};

$actions = $skill->deleted ? array() : $this->loadModel('common')->buildOperateMenu($skill);
if(!$skill->deleted)
{
    $skillMainActions   = array();
    $skillSuffixActions = array();
    foreach($this->ai->getSkillActions($skill, $skill->type) as $action)
    {
        $item = $buildSkillOperateAction($action);
        if(!$item) continue;

        if($action['action'] == 'edit')
        {
            $skillSuffixActions[] = $item;
        }
        else
        {
            $skillMainActions[] = $item;
        }
    }
    if(empty($actions['mainActions'])) $actions['mainActions'] = array();
    if(empty($actions['suffixActions'])) $actions['suffixActions'] = array();
    $actions['mainActions']   = array_merge($skillMainActions, $actions['mainActions']);
    $actions['suffixActions'] = array_merge($skillSuffixActions, $actions['suffixActions']);
}
$hasDivider = !empty($actions['mainActions']) && !empty($actions['suffixActions']);
if(!empty($actions)) $actions = array_merge($actions['mainActions'], $hasDivider ? array(array('type' => 'divider')) : array(), $actions['suffixActions']);

$backMethod = $skill->type == 'public' ? 'browseSkill' : 'mySkill';
$backTarget = $skill->type == 'public' ? 'ai-browseskill' : 'ai-myskill';

detail
(
    set::objectType('skill'),
    set::sections($sections),
    set::tabs($tabs),
    set::actions(array_values($actions)),
    set::backBtn(array('back' => $backTarget, 'url' => createLink('ai', $backMethod)))
);
