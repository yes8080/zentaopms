<?php
namespace zin;

global $lang;

jsVar('teammateData', $teammateData);
jsVar('teammatePromptPrefix', $this->lang->ai->teammatePromptPrefix);
jsVar('teammateKnowledgePrefix', $this->lang->ai->teammateKnowledgePrefix);
jsVar('teammateKnowledgeSuffix', $this->lang->ai->teammateKnowledgeSuffix);

featureBar(
    set::module('aiteammate'),
    set::method('browse'),
    set::current($disabled),
    set::linkParams("disabled={key}")
);

toolbar
(
    hasPriv('aitask', 'browse') ? btn
    (
        setClass('ghost'),
        $lang->aiteammate->teammateTaskList,
        set::url(createLink('aitask', 'browse', 'teammate=0&browseType=all'))
    ) : null,
    hasPriv('aiteammate', 'create') ? btn
    (
        setClass('primary'),
        $lang->aiteammate->create,
        set::url(createLink('aiteammate', 'create'))
    ) : null
);

/* 构建下拉菜单 */
$buildDropdown = function($teammate) use ($lang)
{
    $canDisable  = true;
    $disableHint = '';

    if($teammate->disabled == '0' && !empty($teammate->hasUnclosedTasks))
    {
        $canDisable  = false;
        $disableHint = $lang->aiteammate->disableHint;
    }

    if($teammate->disabled == '0')
    {
        $secondItem = null;
        if(hasPriv('aiteammate', 'disable'))
        {
            $secondItem = array(
                'text'         => $lang->aiteammate->action['disable'],
                'innerClass'   => 'ajax-submit',
                'url'          => createLink('aiteammate', 'disable', "id={$teammate->id}"),
                'data-confirm' => $lang->aiteammate->confirmDisable,
            );

            if(!$canDisable)
            {
                $secondItem['disabled'] = true;
                $secondItem['hint']     = $disableHint;
            }
        }
    }
    else
    {
        $secondItem = hasPriv('aiteammate', 'enable') ? array(
            'text'         => $lang->aiteammate->action['enable'],
            'innerClass'   => 'ajax-submit',
            'url'          => createLink('aiteammate', 'enable', "id={$teammate->id}"),
            'data-confirm' => $lang->aiteammate->confirmEnable,
        ) : null;
    }

    $hasActionPriv = hasPriv('aiteammate', 'enable') || hasPriv('aiteammate', 'disable');
    $hasActionPriv = $hasActionPriv || hasPriv('aiteammate', 'edit') || hasPriv('aiteammate', 'delete');
    if(!$hasActionPriv) return null;

    return dropdown(
        btn(
            setClass('ghost size-sm card-action-btn'),
            set::icon('ellipsis-v')
        ),
        set::items(array(
            hasPriv('aiteammate', 'edit') ? array(
                'text' => $lang->edit,
                'url'  => createLink('aiteammate', 'edit', "id={$teammate->id}")
            ) : null,
            $secondItem,
            hasPriv('aiteammate', 'delete') ? array(
                'text'         => $lang->delete,
                'innerClass'   => 'ajax-submit',
                'disabled'     => $teammate->disabled == '0',
                'url'          => createLink('aiteammate', 'delete', "id={$teammate->id}"),
                'data-confirm' => $lang->aiteammate->confirmDelete,
            ) : null
        )),
        set::placement('bottom-end'),
        set::caret(false)
    );
};

/* 构建卡片 */
$teammateCard = function($teammate) use ($lang, $buildDropdown)
{
    global $app;

    $statusBadge = $teammate->disabled ? span(
        setClass('status-badge'),
        $lang->aiteammate->disabled
    ) : null;

    $role = !empty($teammate->roleData) ? $teammate->roleData['name'] : '';

    $agents     = [];
    $agentNames = [];
    if(!empty($teammate->agentsData))
    {
        foreach($teammate->agentsData as $agent)
        {
            $agents[]     = span(setClass('primary-pale'), $agent['name']);
            $agentNames[] = $agent['name'];
        }
    }

    $avatar   = $teammate->avatar;
    $noAvatar = empty($avatar);
    if($noAvatar) $avatar = $app->config->webRoot . 'static/zentaoaipro/ai-teammate-default.png';
    $isDefault = $noAvatar || strpos($avatar, 'zentaoaipro/ai-teammate-default.png') > 0;
    if(strpos($avatar, $app->config->webRoot) !== 0) $avatar = $app->config->webRoot . $avatar;

    return div(
        setClass('teammate-card'),
        div(
            setClass('card-main'),
            avatar
            (
                set::src($avatar),
                set::text($teammate->name),
                $isDefault ? setStyle(array('filter' => 'hue-rotate(' . (($teammate->id * 53) % 360) . 'deg)')) : null,
                set::size(92),
                set::circle(false),
                set::rounded(4)
            ),
            div(
                setClass('info'),
                div(
                    setClass('heading'),
                    h3(
                        setClass('name text-primary'),
                        set::title($teammate->name),
                        span($teammate->name),
                        $statusBadge,
                    ),
                    div(
                        setClass('actions'),
                        hasPriv('aitask', 'browse') ? btn
                        (
                            setClass('ghost text-primary size-sm'),
                            set::url(createLink('aitask', 'browse', "teammate=$teammate->id&browseType=all")),
                            setData('toggle', 'modal'),
                            setData('size', 'lg'),
                            $lang->aiteammate->taskList
                        ) : null,
                        $buildDropdown($teammate)
                    )
                ),
                p(
                    setClass('role'),
                    $role
                ),
                div(
                    setClass('agents'),
                    set::title(implode('，', $agentNames)),
                    $agents
                )
            )
        ),
        div(
            setClass('desc line-clamp-2'),
            set::title($teammate->desc),
            $teammate->desc
        ),
        !$teammate->disabled ? icon(
            setClass('start-chat bg-primary text-white'),
            set::size(12),
            set::onClick("window.startChat({$teammate->id})"),
            'chat'
        ) : null
    );
};

if(empty($teammates))
{
    div(
        setClass('empty-view'),
        span($lang->aiteammate->noData),
    );
}
else
{
    div(
        setClass('page-teammate'),
        div(
            setClass('teammate-container'),
            array_map($teammateCard, $teammates)
        )
    );
}
