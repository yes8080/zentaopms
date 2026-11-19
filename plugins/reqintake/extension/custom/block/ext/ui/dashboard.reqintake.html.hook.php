<?php
namespace zin;

global $app;
if(data('dashboard') !== 'my') return;

$model = $app->control->loadModel('reqintake');
if(!$model->canAccess('index') || !$model->canAccess('detail')) return;

$app->loadLang('reqintake');
$labels = $app->lang->reqintake;
$feedback = array_slice($model->recent('assigned'), 0, 5);
if(!$feedback) return;

$items = array();
foreach($feedback as $item)
{
    $caption = htmlspecialchars('#' . (int)$item->id . ' ' . $item->title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $link = \helper::createLink('reqintake', 'detail', 'id=' . (int)$item->id);
    $items[] = li(a(set::href($link), html($caption)));
}

query('dashboard')->before(panel(
    set::title($labels->workbench),
    setClass('mb-4'),
    ul($items),
    a(set::href(\helper::createLink('reqintake', 'index', 'scope=assigned')), $labels->scopes['assigned'])
));
