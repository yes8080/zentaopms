<?php
/**
 * The assignTo view file of risk module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian <tianshujie@easycorp.ltd>
 * @package     risk
 * @link        https://www.zentao.net
 */
namespace zin;

$fields = useFields('risk.assignTo');

modalHeader(set::title($lang->risk->assignTo));
formPanel(set::fields($fields));
