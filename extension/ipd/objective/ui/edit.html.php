<?php
/**
 * The edit view file of objective module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     objective
 * @link        https://www.zentao.net
 */
namespace zin;

set::title($lang->objective->edit);
formPanel(set::submitBtnText($lang->save), formRow
(
    formGroup
    (
        set::width('1/2'),
        set::label($lang->objective->promise),
        set::required(true),
        radioList
        (
            set::name('promise'),
            set::items($lang->objective->promiseList),
            set::value($objective->promise),
            set::inline(true)
        )
    )
), formRow
(
    formGroup
    (
        set::label($lang->objective->name),
        set::name('name'),
        set::value($objective->name)
    )
), $objective->type == 'child' ? formRow
(
    formGroup
    (
        set::width('1/2'),
        set::label($lang->objective->BV),
        input
        (
            set::type('number'),
            set::min('0'),
            set::max('999999'),
            set::name('BV'),
            set::value($objective->BV)
        )
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->objective->AV),
        input
        (
            set::type('number'),
            set::min('0'),
            set::max('999999'),
            set::name('AV'),
            set::value($objective->AV)
        )
    )
) : null);

render();
