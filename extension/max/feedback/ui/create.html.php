<?php
/**
 * The create view file of feedback module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     feedback
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('productID', $productID);

if(!isInModal()) dropmenu(set::text($productID == 'all' ? $lang->product->allProduct : ''), set::tab('product'));

$fields = useFields('feedback.create');

formPanel
(
    setID('feedbackCreateForm'),
    set::title($lang->feedback->create),
    set::fields($fields),
    !empty($feedback) ? set::data($feedback) : null,
    on::change('[name=product]', 'changeProduct')
);