<?php
namespace zin;
$viewMethod = $type == 'private' ? 'viewMySkill' : 'viewSquareSkill';
$viewPriv   = $type == 'private' ? 'viewMySkill' : 'viewSquareSkill';
$skillCards = array();
foreach($skills as $skill)
{
    $skillTags = array();
    if(!empty($skill->categoryLabel)) $skillTags[] = $skill->categoryLabel;
    if($type == 'private' && !empty($skill->fromID)) $skillTags[] = $lang->ai->skills->square;

    $showStatusLabel = $skill->status != 'active' || ($type == 'private' && !empty($skill->fromID) && isset($skill->sourceStatus) && $skill->sourceStatus == 'draft');
    $statusLabel     = $showStatusLabel ? span(setClass('draft-tag'), $skill->statusLabel) : null;
    $displayDate     = empty($skill->displayEditedDate) ? '' : $skill->displayEditedDate;
    $displayUser     = zget($users, $skill->createdBy, $skill->createdBy);
    $items           = array();
    foreach($skill->actionItems as $action)
    {
        $item = array('text' => $action['text'], 'url' => $action['url'], 'disabled' => $action['disabled']);
        if($action['modal']) $item['data-toggle'] = 'modal';
        if(!$action['modal'])
        {
            $actionSkillID        = $action['action'] == 'add' ? helper::safe64Encode((string)$skill->id) : $skill->id;
            $item['innerClass']  = 'skill-action-btn';
            $item['data-on']     = 'click';
            $item['data-action'] = $action['action'];
            $item['data-id']     = $actionSkillID;
        }
        $items[] = $item;
    }
    $actionMenu = empty($items) ? null : dropdown
    (
        btn
        (
            setClass('ghost size-sm card-action-btn'),
            set::icon('ellipsis-v')
        ),
        set::items($items),
        set::placement('bottom-end'),
        set::caret(false)
    );

    $skillCards[] = div
    (
        setClass('prompt-card'),
        a
        (
            hasPriv('ai', $viewPriv) ? set::href(createLink('ai', $viewMethod, "id={$skill->id}")) : null,
            h3
            (
                setClass('card-title'),
                set::title($skill->name),
                span(setClass('skill-name'), $skill->name),
                $statusLabel
            ),
            empty($skillTags) ? null : div
            (
                setClass('skill-tags'),
                array_map(function($tag)
                {
                    return span(setClass('skill-tag'), set::title($tag), $tag);
                }, $skillTags)
            ),
            div(setClass('card-description'), set::title($skill->desc), $skill->desc),
            div
            (
                setClass('card-meta'),
                $displayDate ? span(setClass('created-date'), sprintf($lang->ai->skills->lastUpdate, substr($displayDate, 0, 10))) : null,
                div
                (
                    setClass('creator'),
                    set::title($displayUser),
                    avatar
                    (
                        set::size('sm'),
                        set::text($displayUser)
                    )
                )
            )
        ),
        $actionMenu
    );
}

if(empty($skills))
{
    panel
    (
        div
        (
            setClass('dtable-empty-tip'),
            div
            (
                setClass('row gap-4 items-center'),
                span
                (
                    setClass('text-gray'),
                    $emptyList
                )
            )
        )
    );
}
else
{
    div
    (
        setClass('page-prompts'),
        div(setClass('prompts-container'), $skillCards),
        !empty($pager) ? div
        (
            setClass('pager-container'),
            pager(set(usePager()))
        ) : null
    );
}
