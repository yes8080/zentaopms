<?php
namespace zin;

$fromForm = !empty($this->view->fromForm);

$agentOptions = array_column($agents, 'name', 'id');
$agentNames   = implode(', ', $agentOptions);
$hasAgents    = !empty($agentOptions);

$fnBuildAgents = function() use ($agentOptions, $teammate, $objectType, $objectID, $pageInfo, $from, $fromForm)
{
    $agentList = [];
    foreach($agentOptions as $id => $agent)
    {
        $link = inlink('assignaitask', "teammateID={$teammate->id}&agentID=$id&objectType=$objectType&objectID=$objectID&pageInfo=$pageInfo&from=" . ($fromForm ? '_&fromForm=1' : $from));
        $agentList[] = btn
        (
            setClass('rounded-full primary-outline'),
            setStyle(['height' => '25px']),
            set::url($link),
            setData('dismiss', 'modal'),
            setData('toggle', 'modal'),
            setData('size', 'sm'),
            $agent
        );
    }

    return $agentList;
};

$avatar   = $teammate->avatar;
$noAvatar = empty($avatar);
if($noAvatar) $avatar = $app->config->webRoot . 'static/zentaoaipro/ai-teammate-default.png';
if(strpos($avatar, $app->config->webRoot) !== 0) $avatar = $app->config->webRoot . $avatar;
formPanel
(
    set::title($lang->aiteammate->assignedTo),
    set::actions([]),
    div
    (
        setClass('flex gap-4'),
        avatar
        (
            $noAvatar ? setStyle(array('filter' => 'hue-rotate(' . (($teammate->id * 53) % 360) . 'deg)')) : setStyle(['min-width' => '32px']),
            set::src($avatar),
            set::text($teammate->name),
            set::size('32'),
        ),
        div
        (
            div
            (
                setClass('bg-primary-50 text-fore px-4 py-1.5 mb-4'),
                setStyle(['border-radius' => '10px', 'border-top-left-radius' => '0']),
                $hasAgents ? str_replace(['%name', '%agent'], [$teammate->name, $agentNames], $lang->aiteammate->tips->selectAgent) : $lang->notFound
            ),
            $hasAgents ? div(setClass('flex flex-wrap gap-3'), $fnBuildAgents()) : div(setClass('text-gray'), $lang->notFound)
        )
    )
);
