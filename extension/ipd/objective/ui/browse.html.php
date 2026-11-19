<?php
/**
 * The browse view file of objective module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     objective
 * @link        https://www.zentao.net
 */
namespace zin;

dropmenu(set::tab('pi'), set::objectID($piID));

featureBar(set::linkParams("piID={$piID}&browseType={key}"));

toolbar(hasPriv('objective', 'create') ? item(set(array('text' => $lang->objective->parent->create, 'url' => $this->createLink('objective', 'create', "piID={$piID}"), 'data-toggle' => 'modal', 'class' => 'btn primary', 'icon' => 'plus'))) : null);

$config->objective->dtable->fieldList['team']['map'] = $teams;

$objectiveList = initTableData($objectiveList, $config->objective->dtable->fieldList, $this->objective);

dtable
(
    set::rowKey('key'),
    set::cols(array_values($config->objective->dtable->fieldList)),
    set::data(array_values($objectiveList)),
    set::orderBy($orderBy),
    set::sortLink(createLink('objective', 'browse', "id=$piID&browseType={$browseType}&orderBy={name}_{sortType}")),
    set::fixedLeftWidth('0.44'),
    set::footPager(usePager())
);

render();
