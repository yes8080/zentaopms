<?php
/**
 * The close view file of PI module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     PI
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader();

formPanel
(
    formGroup
    (
        set::required(true),
        set::width('1/2'),
        set::label($lang->pi->closedReason),
        picker(set::required(true), set::name('closedReason'), set::items($lang->pi->closedReasonList))
    ),
    formGroup
    (
        set::label($lang->comment),
        editor(set::name('comment'))
    )
);
hr();
history();
