<?php
/**
 * The view view file of art module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     art
 * @link        https://www.zentao.net
 */
namespace zin;

$productList = array();
$managers    = array();
$POList      = array();
$architects  = array();
$whitelist   = array();
if($art->product)
{
    foreach(explode(',', $art->product) as $product) $productList[] = \zget($products, $product, '');
    $productList = implode(',', array_filter($productList));
}

if($art->manager)
{
    foreach(explode(',', $art->manager) as $manager) $managers[] = \zget($users, $manager);
    $managers = implode(',', array_filter($managers));
}

if($art->PO)
{
    foreach(explode(',', $art->PO) as $PO) $POList[] = \zget($users, $PO);
    $POList = implode(',', array_filter($POList));
}

if($art->architect)
{
    foreach(explode(',', $art->architect) as $architect) $architects[] = \zget($users, $architect);
    $architects = implode(',', array_filter($architects));
}

if($art->whitelist)
{
    foreach(explode(',', $art->whitelist) as $white) $whitelist[] = \zget($users, $white);
    $whitelist = implode(',', array_filter($whitelist));
}

$teamCards = array();
if($teams)
{
    foreach($teams as $team)
    {
        $teamCards[] = cell
        (
            set::width('33%'),
            set::className('card overflow-hidden'),
            div
            (
                set::className('border mr-4 mb-4 flex'),
                cell
                (
                    set::className('p-4'),
                    userAvatar(!empty($team->logo) ? set::avatar($team->logo) : set::account($team->name), set::size(40))
                ),
                cell
                (
                    set::className('py-4 pr-2 overflow-hidden'),
                    div(set::className('clip'), span(set::className('text-lg text-black font-bold'), set::title($team->name), $team->name)),
                    div(span(substr($team->createdDate, 0, 10) . ' ' . $lang->team->create))
                )
            )
        );
    }
}

detailHeader
(
    set::backUrl(createLink('art', 'browse')),
    to::title
    (
        entityLabel(set(array('entityID' => $art->id, 'level' => 1)), $art->name),
        $art->deleted ? span(set::className('label danger'), $lang->art->deleted) : null
    )
);

$actionList = $this->loadModel('common')->buildOperateMenu($art);
detailBody
(
    sectionList
    (
        section
        (
            set::title($lang->art->desc),
            set::content($art->desc),
            set::useHtml(true)
        ),
        section
        (
            set::title($lang->art->teamInfo),
            div(set::className('flex flex-wrap'), $teamCards)
        ),
    ),
    history(set::commentUrl(createLink('action', 'comment', array('objectType' => 'art', 'objectID' => $art->id)))),
    floatToolbar(set::object($art), isAjaxRequest('modal') ? null : to::prefix(backBtn(set::url(createLink('art', 'browse')), set::back('art-browse'), set::icon('back'), set::className('ghost text-white'), $lang->goback)), set::main($actionList['mainActions']), set::suffix($actionList['suffixActions'])),
    detailSide
    (
        tabs
        (
            tabPane
            (
                set::key('legendBasicInfo'),
                set::title($lang->art->basicInfo),
                set::active(true),
                tableData
                (
                    item(set::name($lang->art->status), $lang->art->statusList[$art->status]),
                    item(set::name($lang->art->product), html($productList)),
                    item(set::name($lang->art->RTE), zget($users, $art->RTE)),
                    item(set::name($lang->art->manager), $managers),
                    item(set::name($lang->art->PO), $POList),
                    item(set::name($lang->art->architect), $architects),
                    item(set::name($lang->art->createdBy), zget($users, $art->createdBy)),
                    item(set::name($lang->art->createdDate), $art->createdDate),
                    item(set::name($lang->art->acl), zget($lang->art->aclAbbrList, $art->acl)),
                    item(set::name($lang->art->whitelist), $whitelist)
                )
            )
        )
    )
);
