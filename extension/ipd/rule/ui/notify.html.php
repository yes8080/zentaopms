<?php
/**
 * The notify file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader();

formPanel
(
    set::submitBtnText($lang->save),
    formGroup
    (
        set::label($lang->rule->notifyMethod),
        set::width('1/2'),
        picker
        (
            on::change('changeMethod'),
            set::required(true),
            set::name('notifyMethod'),
            set::items($lang->rule->notifyMethodList),
            set::value($rule->notifyMethod)
        )
    ),
    formGroup
    (
        set::label($lang->rule->notifyUsers),
        picker
        (
            set::name('notifyUsers'),
            set::multiple(true),
            set::items($users),
            set::disabled($rule->notifyMethod == 'closed'),
            set::value($rule->notifyUsers)
        )
    )
);
