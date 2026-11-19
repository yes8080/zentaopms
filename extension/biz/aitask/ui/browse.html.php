<?php
namespace zin;

$currentUrl = $this->inlink('browse', "teammate=$teammate&browseType=$browseType&involved={involved}&orderBy={$orderBy}&param=0");
$isInModal  = isInModal();
if($isInModal) div(setClass('modal-title mb-5'), $lang->aitask->list);

$this->app->loadLang('ai');
jsVar('modules', $lang->ai->prompts->modules);
jsVar('moduleNameMap', $config->ai->moduleNameMap ?? array());
jsVar('isInModal', $isInModal);
jsVar('currentUrl', $currentUrl);
jsVar('statusList', $lang->aitask->statusList);

$queryMenuLink = createLink('aitask', 'browse', "teammate={$teammate}&browseType=bysearch&involved=$involved&orderBy={$orderBy}&param={queryID}");
if(!$objectType) featureBar
(
    set::current($browseType),
    set::linkParams("teammate={$teammate}&browseType={key}&involved=$involved&orderBy={$orderBy}&param=0"),
    set::queryMenuLinkCallback(array(fn($key) => str_replace('{queryID}', (string)$key, $queryMenuLink))),
    set::isModal($isInModal),
    set::modalTarget('#aitasks_table'),
    checkbox
    (
        set::rootClass('ml-2 mr-4'),
        set::name('involved'),
        set::text($lang->aitask->mine),
        set::checked($involved ? 'checked' : ''),
        on::change()->call('window.toggleInvolved', jsRaw('this'))
    ),
    li
    (
        searchToggle
        (
            set::simple($isInModal),
            set::module('aitask'),
            set::open($browseType == 'bysearch'),
            $isInModal ? array(
                set::target('#aiTaskSearchForm'),
                set::onSearch(jsRaw('function(){$(this.element).closest(".modal").find("#featureBar .nav-item>.active").removeClass("active").find(".label").hide()}'))
            ) : null,
        )
    )
);

if(!$isInModal)
{
    sidebar
    (
        teammateMenu
        (
            set::showDisplay(false),
            set::modules($teammates),
            set::activeKey($teammate),
            set::link(inlink('browse', "teammate=%s&browseType=$browseType")),
            set::closeLink(inlink('browse'))
        )
    );
}
else
{
    div(setID('aiTaskSearchForm'));
}

$cols = $config->aitask->dtable->browse;
if($objectType) unset($cols['objectType']);
$aiTasks = initTableData($aiTasks, $cols, $this->aitask);
dtable
(
    setID('aitasks'),
    set::cols($cols),
    set::data($aiTasks),
    set::userMap($users),
    set::onRenderCell(jsRaw('window.onRenderCell')),
    set::sortLink(createLink('aitask', 'browse', "teammate=$teammate&browseType=$browseType&involved=$involved&orderBy={name}_{sortType}&param=$param&recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=$pager->pageID&objectType=$objectType&objectID=$objectID")),
    set::footPager(usePager()),
    set::emptyTip($lang->aitask->noTask),
);
