<?php
namespace zin;

featureBar
(
    set::current($browseType),
    set::linkParams("browseType={key}&orderBy={$orderBy}")
);

toolbar
(
    hasPriv('aiprocedure', 'create') ? btn
    (
        setClass('primary'),
        set::icon('plus'),
        set::url(createLink('aiprocedure', 'create')),
        setData('toggle', 'modal'),
        $lang->aiprocedure->create
    ) : null
);

$cols       = $this->loadModel('datatable')->getSetting('aiprocedure');
$procedures = initTableData($procedures, $cols, $this->aiprocedure);

dtable
(
    setID('aiprocedures'),
    set::customCols(true),
    set::cols($cols),
    set::data($procedures),
    set::userMap($users),
    set::sortLink(createLink('aiprocedure', 'browse', "browseType={$browseType}&orderBy={name}_{sortType}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}")),
    set::footPager(usePager()),
    set::emptyTip($lang->aiprocedure->noData)
);
