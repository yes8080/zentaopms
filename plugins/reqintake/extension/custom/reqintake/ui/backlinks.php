<?php
namespace zin;

global $app, $lang;
if(!\common::hasPriv('reqintake', 'detail')) return;
$sources = $app->control->loadModel('reqintake')->sourcesForTarget($targetType, (int)$item->id);
if(!$sources) return;

$items = array();
foreach($sources as $source)
{
    $link = \helper::createLink('reqintake', 'detail', 'id=' . (int)$source->id);
    $caption = htmlspecialchars('#' . (int)$source->id . ' ' . $source->title, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    $items[] = li(a(set::href($link), html($caption)));
}
query('detail')->before(div(setClass('panel p-4 mb-2'), h3($lang->reqintake->common), ul($items)));
