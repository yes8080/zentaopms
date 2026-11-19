<?php
/**
 * The finish view file of ticket module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang<wangyuting@easycorp.ltd>
 * @package     ticket
 * @link        https://www.zentao.net
 */
namespace zin;

$fields = useFields('ticket.finish');

jsVar('consumed', $ticket->consumed);
modalHeader();

formPanel
(
    set::fields($fields)
);

history();