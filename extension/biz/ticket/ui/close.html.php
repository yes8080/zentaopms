<?php
/**
 * The close view file of ticket module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Mengyi Liu
 * @package     ticket
 * @link        https://www.zentao.net
 */
namespace zin;

$fields = useFields('ticket.close');

modalHeader();
formPanel
(
    setID('ticketCloseForm'),
    set::fields($fields),
    on::change('[name=closedReason]')->do('const $form = $(target).closest("form"); $form.find(".repeatBox").closest(".form-row").toggleClass("hidden", target.value !== "repeat"); $form.find(".resolvedBox").closest(".form-row").toggleClass("hidden", target.value !== "commented");')
);

history();
render();
