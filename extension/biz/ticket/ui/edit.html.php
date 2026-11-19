<?php
/**
 * The edit file of ticket module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang<wangyuting@easycorp.ltd>
 * @package     ticket
 * @link        https://www.zentao.net
 */
namespace zin;

foreach($ticketSources as $ticketSource) unset($ticketSource->id);

$fields = useFields('ticket.edit');

detailForm
(
    set::object($ticket),
    set::objectType('ticket'),
    set::objectID($ticket->id),
    set::fields($fields),
    set::comment(false),
    to::side
    (
        tableData
        (
            setClass('mt-5'),
            set::title($lang->ticket->contacts),
            set::thClass('hidden'),
            set::tdClass('w-64'),
            item
            (
                formBatch
                (
                    set::actions(array()),
                    set::tagName('div'),
                    set::minRows(3),
                    set::data($ticketSources),
                    formBatchItem(set::name('customer'), set::label($lang->ticket->customer)),
                    formBatchItem(set::name('contact'), set::label($lang->ticket->contact)),
                    formBatchItem(set::name('notifyEmail'), set::label($lang->ticket->notifyEmail), set::width('100px'))
                )
            )
        )
    ),
);

render();
