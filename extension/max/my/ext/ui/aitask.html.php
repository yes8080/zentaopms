<?php
namespace zin;

include $app->getModuleRoot() . 'my/ui/header.html.php';

$this->app->loadLang('ai');
jsVar('modules', $lang->ai->prompts->modules);
jsVar('moduleNameMap', $config->ai->moduleNameMap ?? array());
jsVar('statusList', $lang->aitask->statusList);

featureBar
(
    set::current($type),
    set::linkParams("mode=aitask&type={key}&param=&orderBy={$orderBy}"),
    li(searchToggle(set::module($app->rawMethod . 'AITask'), set::open($type == 'bysearch')))
);

$cols  = $config->aitask->dtable->browse;
$tasks = initTableData($tasks, $cols, $this->aitask);
$data  = array_values($tasks);

dtable
(
    set::data($data),
    set::cols($cols),
    set::userMap($users),
    set::onRenderCell(jsRaw('window.onRenderCell')),
    set::orderBy($orderBy),
    set::sortLink(createLink('my', $app->rawMethod, "mode={$mode}&type={$type}&param={$param}&orderBy={name}_{sortType}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}")),
    set::footPager(usePager()),
    set::emptyTip($lang->aitask->noTask)
);
