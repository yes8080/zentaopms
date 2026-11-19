<?php
/**
 * The browse view file of faq module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2026 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming <sunguangming@zentao.net>
 * @package     faq
 * @link        https://www.zentao.net
 */
namespace zin;

$canCreate = common::hasPriv('faq', 'create');
$canEdit   = common::hasPriv('faq', 'edit');
$canDelete = common::hasPriv('faq', 'delete');

$createLink = helper::createLink('faq', 'create', "productID={$currentProduct}&moduleID={$currentModule}");

/* 是否是反馈用户查看 FAQ。Whether the current user is a feedback user. */
$isFeedbackView = isset($_COOKIE['feedbackView']) || !empty($_SESSION['user']->feedback);

jsVar('faqHidden', $lang->faq->hidden);
jsVar('faqShow', $lang->faq->show);

dropmenu(set::text(empty($productID) ? $lang->product->allProduct : ''), set::tab('feedback'));

/* 把产品/模块树转换成侧边栏需要的扁平菜单。Build the flat module menu for the sidebar. */
$menuItems     = array();
$appendModules = function(array $modules, int $productID) use (&$appendModules, &$menuItems)
{
    foreach($modules as $module)
    {
        if(!is_object($module)) continue;

        $menuItem = new stdclass();
        $menuItem->id     = $module->id;
        $menuItem->parent = empty($module->parent) ? "product-{$productID}" : $module->parent;
        $menuItem->name   = $module->name;
        $menuItem->url    = helper::createLink('faq', 'browse', "productID={$productID}&moduleID={$module->id}");
        $menuItems[]      = $menuItem;

        if(!empty($module->children)) $appendModules((array)$module->children, $productID);
    }
};

foreach($moduleTree as $treeProductID => $modules)
{
    if(!isset($products[$treeProductID])) continue;

    $productItem = new stdclass();
    $productItem->id     = "product-{$treeProductID}";
    $productItem->parent = 0;
    $productItem->name   = $products[$treeProductID];
    $productItem->url    = helper::createLink('faq', 'browse', "productID={$treeProductID}");
    $menuItems[] = $productItem;

    $appendModules((array)$modules, (int)$treeProductID);
}

$settingLink = (common::hasPriv('tree', 'browse') && $currentProduct) ? helper::createLink('tree', 'browse', "rootID={$currentProduct}&view=story&currentModuleID=0&branch=0") : '';

sidebar
(
    moduleMenu
    (
        set::modules($menuItems),
        set::activeKey($currentModule ? $currentModule : $currentProduct),
        set::settingLink($settingLink),
        set::showDisplay(false),
        set::closeLink('')
    )
);

featureBar();
toolbar
(
    $canCreate ? btn
    (
        setClass('btn primary'),
        set::icon('plus'),
        set::url($createLink),
        $lang->faq->create
    ) : null
);

if(empty($faqs))
{
    div
    (
        setClass('dtable'),
        div
        (
            setClass('dtable-empty-tip'),
            div
            (
                setClass('row gap-4 items-center'),
                div(setClass('text-gray'), $lang->faq->noFaq),
                ($canCreate && !$isFeedbackView) ? btn
                (
                    setClass('btn primary-pale'),
                    set::icon('plus'),
                    set::url($createLink),
                    $lang->faq->create
                ) : null
            )
        )
    );
}
else
{
    $tocItems = array();
    $faqItems = array();
    foreach($faqs as $id => $faq)
    {
        $tocItems[] = li(a(set::href("#faq{$id}"), $faq->question));

        $actions = array();
        if($canEdit)   $actions[] = a(set::href(helper::createLink('faq', 'edit', "faqID={$faq->id}")), $lang->edit);
        if($canDelete) $actions[] = a
        (
            set::href(helper::createLink('faq', 'delete', "faqID={$faq->id}")),
            setClass('ajax-submit'),
            set('data-confirm', $lang->faq->confirmDelete),
            $lang->delete
        );

        $faqItems[] = div
        (
            setClass('faq-item'),
            div
            (
                setClass('faq-question flex items-center gap-2'),
                h::strong(setID("faq{$id}"), setClass('faq-question-text'), $faq->question),
                empty($actions) ? null : span(setClass('faq-actions gap-2'), $actions)
            ),
            div(setClass('faq-answer'), html($faq->answer)),
            divider()
        );
    }

    panel
    (
        set::title($lang->faq->faqList),
        div
        (
            setClass('mb-2'),
            span(setClass('text-muted'), '['),
            a
            (
                setID('toggleToc'),
                set::href('javascript:;'),
                on::click('toggleFaqToc()'),
                span(setID('toggleTocText'), $lang->faq->hidden)
            ),
            span(setClass('text-muted'), ']')
        ),
        ol
        (
            setID('faqToc'),
            setClass('mb-3'),
            $tocItems
        ),
        div
        (
            setClass('faq-list'),
            $faqItems
        )
    );
}