<?php
/**
 * The edit view file of feedback module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     feedback
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('feedbackID', $feedback->id);
jsVar('isInModal', isInModal());

$fields = useFields('feedback.edit');

formPanel
(
    setID('feedbackEditForm'),
    set::title($lang->feedback->edit),
    set::fields($fields),
    on::change('[name=product]', 'changeProduct')
);