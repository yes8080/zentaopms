<?php
/**
 * The browse view file of team module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     team
 * @link        https://www.zentao.net
 */
namespace zin;

featureBar(set::linkParams('browseType={key}'));

$canCreate  = hasPriv('team', 'create');
$createLink = $this->createLink('team', 'create');
$createItem = array('text' => $lang->team->createAction, 'url' => $createLink, 'data-toggle' => 'modal');

toolbar($canCreate ? item(set($createItem + array('class' => 'btn primary', 'icon' => 'plus'))) : null);

foreach($teamList as $team)
{
    $managers = '';
    if($team->manager)
    {
        foreach(explode(',', $team->manager) as $manager)
        {
            $managers .= zget($users, $manager) . ' ';
        }
        $team->manager = $managers;
    }
    $team->number = !empty($memberCount[$team->id]) ? $memberCount[$team->id] : 0;
    if($team->type == 'parent') $team->slogan = '';
}

$teamList = initTableData($teamList, $config->team->dtable->fieldList, $this->team);

dtable
(
    set::cols(array_values($config->team->dtable->fieldList)),
    set::data(array_values($teamList)),
    set::fixedLeftWidth('0.44'),
    set::orderBy($orderBy),
    set::sortLink(createLink('team', 'browse', "browseType={$browseType}&orderBy={name}_{sortType}")),
    set::onRenderCell(jsRaw('window.renderCell')),
    set::footPager(usePager(array
    (
        'recPerPage'  => $pager->recPerPage,
        'recTotal'    => $pager->recTotal,
        'linkCreator' => helper::createLink('team', 'browse', "browseType={$browseType}&orderBy={$orderBy}&recTotal={$pager->recTotal}&recPerPage={recPerPage}&page={page}") . "#app={$app->tab}"
    ))),
);

render();
