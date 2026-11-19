<?php
/**
 * The linkStory view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

set::title($lang->objective->link);
set::bodyClass('linkobjective-modal-body');

$config->objective->dtable->fieldList['id']['type']           = 'checkID';
$config->objective->dtable->fieldList['team']['map']          = $teams;
$config->objective->dtable->fieldList['name']['nestedToggle'] = false;
unset($config->objective->dtable->fieldList['actions']);

formBase
(
    set::actions(''),
    dtable(set::id('linkObjective'), set::checkable(true), set::userMap($users), set::cols($config->objective->dtable->fieldList), set::data(array_values($objectives)), set::footToolbar(array('items' => array(array
        (
            'text'      => $lang->save,
            'btnType'   => 'primary',
            'className' => 'size-sm linkObjectBtn batch-btn',
            'data-type' => 'story',
            'data-url'  => inlink('link', "id={$objective->id}"),
        ))
    )),
    set::orderBy($orderBy),
    set::sortLink(inlink('link', "id=$objective->id&orderBy={name}_{sortType}")),
    set::footPager(usePager()))
);
