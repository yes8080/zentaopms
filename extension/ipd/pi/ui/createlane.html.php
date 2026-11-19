<?php
/**
 * The create lane view file of pi module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     pi
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('colorList', $config->kanban->laneColorList);

modalHeader(set::title($lang->pi->createLane));

formPanel(formGroup
(
    set::required(true),
    set::label($lang->pi->lane->name),
    input(set::name('name'))
), formGroup
(
    set::required(true),
    set::label($lang->pi->lane->color),
    div(set::id('color-picker')),
    formHidden('color', '#3C4353')
));
