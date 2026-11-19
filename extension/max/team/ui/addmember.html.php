<?php
/**
 * The addMember view file of team module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming<sunguangming@easycorp.ltd>
 * @package     team
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader(set::title($lang->team->addMember));

formPanel(formGroup(set::label($lang->team->member), set::required(true), picker(set::name('members[]'), set::items($outUsers), set::multiple(true))));
