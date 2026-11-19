<?php
/**
 * The comment view file of feedback module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian <tianshujie@chandao.com>
 * @package     feedback
 * @link        https://www.zentao.net
 */
namespace zin;

$fields = useFields('feedback.comment');

modalHeader();

formPanel
(
    set::submitBtnText(data('title')),
    set::fields($fields),
    on::change('[name=faq]', 'faqChange')
);
