<?php
/**
 * The enable view file of team module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     team
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader();

formPanel(formGroup(set::width('1/2'), set::label($lang->team->parent), picker(set::name('parent'), set::items($parents), set::value($team->parent)), ($parent && $parent->status == 'disband') ? set::tip($lang->team->parentDisbanded) : null, set::tipClass('form-tip')), formGroup
(
    set::label($lang->comment),
    editor(set::name('comment'), set::rows('5'))
));
hr();
history();
