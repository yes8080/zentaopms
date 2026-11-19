<?php
/**
 * The browse view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('ARTText', $lang->art->common);

featureBar(set::linkParams('browseType={key}'));

toolbar(hasPriv('pi', 'create') ? item(set(array('text' => $lang->pi->create, 'url' => $this->createLink('pi', 'create'), 'class' => 'btn primary', 'icon' => 'plus'))) : null);

foreach($PIList as $PI)
{
    $productNames = '';
    if($PI->product)
    {
        foreach(explode(',', $PI->product) as $product)
        {
            $productName = zget($products, $product, '');
            if($productName) $productNames .= $productName . ' ';
        }
        $PI->product = $productNames;
    }

    $managerList = '';
    if(!empty($PI->manager))
    {
        foreach(explode(',', $PI->manager) as $manager) $managerList .= zget($users, $manager) . ' ';
        $PI->manager = $managerList;
    }

    $POList = '';
    if($PI->PO)
    {
        foreach(explode(',', $PI->PO) as $PO) $POList .= zget($users, $PO) . ' ';
        $PI->PO = $POList;
    }

    $architects = '';
    if($PI->architect)
    {
        foreach(explode(',', $PI->architect) as $architect) $architects .= zget($users, $architect) . ' ';
        $PI->architect = $architects;
    }
}

$PIList = initTableData($PIList, $config->pi->dtable->fieldList, $this->pi);
foreach($PIList as $PI)
{
    if($PI->type == 'art')
    {
        $PI->actions = array();
        if(common::hasPriv('pi', 'create') and $PI->status != 'closed') $PI->actions[] = array('icon' => 'plus', 'hint' => $lang->art->createPI, 'url' => $this->createLink('pi', 'create', "id={$PI->rawID}"));
        if(common::hasPriv('art', 'edit'))  $PI->actions[] = array('icon' => 'edit', 'hint' => $lang->edit, 'url' => $this->createLink('art', 'edit', "id={$PI->rawID}"));
        if(common::hasPriv('art', 'activate') && $PI->status == 'closed') $PI->actions[] = array('icon' => 'magic', 'hint' => $lang->art->activate, 'url' => $this->createLink('art', 'activate', "id={$PI->rawID}"), 'data-toggle' => 'modal');
        if(common::hasPriv('art', 'closed') && $PI->status != 'closed')   $PI->actions[] = array('icon' => 'unlink', 'hint' => $lang->art->close, 'url' => $this->createLink('art', 'close', "id={$PI->rawID}"), 'data-toggle' => 'modal');
    }
}

dtable
(
    set::cols(array_values($config->pi->dtable->fieldList)),
    set::data(array_values($PIList)),
    set::userMap($users),
    set::orderBy($orderBy),
    set::onRenderCell(jsRaw('window.renderCell')),
    set::sortLink(createLink('pi', 'browse', "browseType={$browseType}&orderBy={name}_{sortType}")),
    set::fixedLeftWidth('0.44'),
    set::footPager(usePager())
);

render();
