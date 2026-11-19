<?php
/**
 * The ajaxloaddeleteform file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('fromObjectType', $fromObjectType);
h4($lang->rule->selectObject, setClass('ml-6'));
formRow
(
    formGroup
    (
        set::label($lang->rule->relation),
        set::width('1/2'),
        set::required(true),
        picker
        (
            on::change('changeRelation'),
            set::name('relation'),
            set::value($relation),
            set::items($relations)
        )
    )
);

formRow
(
    formGroup
    (
        set::label($lang->rule->objectType),
        set::width('1/2'),
        set::required(true),
        picker
        (
            $module ? set::items($modules) : null,
            set::value($module),
            set::name('module')
        )
    )
);
