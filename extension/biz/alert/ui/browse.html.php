<?php
/**
 * The browse file of alert module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

featureBar
(
    set::current($browseType),
    set::linkParams("browseType={key}&param={$param}&orderBy={$orderBy}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}"),
    li(searchToggle(set::open($browseType == 'bysearch')))
);

toolbar
(
    hasPriv('alert', 'create') ? item(set(array
    (
        'text'        => $lang->alert->create,
        'icon'        => 'plus',
        'class'       => 'primary',
        'url'         => createLink('alert', 'create'),
        'data-toggle' => 'modal'
    ))) : null
);

$cols  = $this->loadModel('datatable')->getSetting('alert');
$rules = initTableData($rules, $cols, $this->alert);

dtable
(
    set::cols($cols),
    set::data($rules),
    set::customCols(true),
    set::userMap($users),
    set::checkable(false),
    set::orderBy($orderBy),
    set::sortLink(createLink('alert', 'browse', "browseType={$browseType}&param={$param}&orderBy={name}_{sortType}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}")),
    set::footPager(usePager())
);
