<?php
/**
 * The browse view file of art module of ZenTaoPMS.
 * @copyright   Copyright 2009-2026 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian <tianshujie@chandao.com>
 * @package     art
 * @link        https://www.zentao.net
 */
namespace zin;
featureBar(set::current($browseType), set::linkParams('browseType={key}'));
toolbar(common::hasPriv('art', 'create') ? btn(setClass('btn primary'), set::icon('plus'), set::url(inlink('create')), $lang->art->create) : '');

$artList = initTableData($artList, $config->art->dtable->fieldList, $this->art);
foreach($artList as $id => $art)
{
    foreach($art->actions as $actionID => $action)
    {
        if($action['name'] == 'delete' && $action['disabled']) $artList[$id]->actions[$actionID]['hint'] = $this->lang->art->notice->hasPI;
    }
}

dtable
(
    set::cols(array_values($config->art->dtable->fieldList)),
    set::data(array_values($artList)),
    set::userMap($users),
    set::orderBy($orderBy),
    set::sortLink(createLink('art', 'browse', "browseType={$browseType}&orderBy={name}_{sortType}")),
    set::onRenderCell(jsRaw('window.renderCell')),
    set::footPager(usePager())
);
