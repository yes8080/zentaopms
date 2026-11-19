<?php
/**
 * The create view file of ticket module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Shujie Tian <tianshujie@chandao.com>
 * @package     ticket
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('productID', $productID);
jsVar('isAdmin', $app->user->admin);
jsVar('authedProducts', empty($app->user->view->products) ? array() : explode(',', $app->user->view->products));

if(!isInModal()) dropmenu(set::text($productID == 'all' ? $lang->product->allProduct : ''), set::tab('product'));

$fields = useFields('ticket.create');

formGridPanel
(
    setID('ticketCreateForm'),
    set::title($lang->ticket->create),
    set::fields($fields),
    set::modeSwitcher(false),
    on::change('[name=product]', 'loadAll')
);
