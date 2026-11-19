<?php
/**
 * The edit file of ticket module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jun Sun<sunjun@easycorp.ltd>
 * @package     ticket
 * @link        https://www.zentao.net
 */
namespace zin;

global $lang, $config, $app;

$fields = defineFieldList('ticket.edit');

$disableStartedBy  = data('ticket.status') == 'wait';
$disableResolvedBy = data('ticket.status') == 'wait' || data('ticket.status') == 'doing';

/* ====== Closures ====== */

$buildTitle = function()
{
    return inputGroup
    (
        formHidden('id', data('ticket.id')),
        input(set::name('title'), set::value(data('ticket.title')))
    );
};

$buildFiles = function()
{
    return fileSelector(data('ticket.createFiles') ? set::defaultFiles(array_values(data('ticket.createFiles'))) : null);
};

$buildSource = function()
{
    global $lang;
    if(!empty(data('feedback')))
    {
        return a
        (
            set::href(createLink('feedback', 'adminView', 'feedbackID=' . data('feedback.id'))),
            data('feedback.id') . ' ' . data('feedback.title')
        );
    }
    return span($lang->noData);
};

/* ====== Main column fields (position = info) ====== */

$fields->field('title')
    ->position('info')
    ->width('full')
    ->required(true)
    ->control($buildTitle);

$fields->field('desc')
    ->position('info')
    ->width('full')
    ->control('editor')
    ->value(data('ticket.desc'));

$fields->field('resolution')
    ->hidden(empty(data('ticket.resolution')))
    ->position('info')
    ->width('full')
    ->control('editor')
    ->value(data('ticket.resolution'));

$fields->field('files')
    ->position('info')
    ->width('full')
    ->control($buildFiles);

/* ====== Sidebar: legendBasicInfo ====== */

$fields->field('product')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->required(true)
    ->control('picker')
    ->items(data('products'))
    ->value(data('ticket.product'))
    ->data(array('on' => 'change', 'call' => 'changeProduct'));

$fields->field('module')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->required(true)
    ->control('picker')
    ->items(data('modules'))
    ->value(data('ticket.module'));

$fields->field('openedBuild')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control(array('control' => 'picker', 'multiple' => true))
    ->items(data('builds'))
    ->value(data('ticket.openedBuild'));

$fields->field('type')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('picker')
    ->items($lang->ticket->typeList)
    ->value(data('ticket.type'));

$fields->field('source')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control($buildSource);

$fields->field('status')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('picker')
    ->items($lang->ticket->statusList)
    ->value(data('ticket.status'))
    ->disabled(true);

$fields->field('pri')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('priPicker')
    ->items($lang->ticket->priList)
    ->value(data('ticket.pri'));

$fields->field('assignedTo')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('picker')
    ->items(data('users'))
    ->value(data('ticket.assignedTo'));

$fields->field('keywords')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('input')
    ->value(data('ticket.keywords'));

$fields->field('mailto')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('mailto')
    ->items(data('users'))
    ->value(data('ticket.mailto'));

$fields->field('estimate')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('input')
    ->value(data('ticket.estimate'));

$fields->field('deadline')
    ->position('basic')
    ->group($lang->ticket->legendBasicInfo)
    ->control('datePicker')
    ->value(data('ticket.deadline'));

/* ====== Sidebar: legendLife ====== */

$fields->field('openedBy')
    ->label($lang->ticket->createdBy)
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('picker')
    ->disabled(true)
    ->items(data('users'))
    ->value(data('ticket.openedBy'));

$fields->field('startedBy')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('picker')
    ->disabled($disableStartedBy)
    ->items(data('users'))
    ->value(data('ticket.startedBy'));

$fields->field('startedDate')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('datetimePicker')
    ->disabled($disableStartedBy)
    ->value(data('ticket.startedDate'));

$fields->field('resolvedBy')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('picker')
    ->disabled($disableResolvedBy)
    ->items(data('users'))
    ->value(data('ticket.resolvedBy'));

$fields->field('resolvedDate')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('datetimePicker')
    ->disabled($disableResolvedBy)
    ->value(data('ticket.resolvedDate'));

$fields->field('closedBy')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('picker')
    ->disabled(true)
    ->items(data('users'))
    ->value(data('ticket.closedBy'));

$fields->field('closedDate')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('datetimePicker')
    ->disabled(true)
    ->value(data('ticket.closedDate'));

$fields->field('closedReason')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('input')
    ->disabled(true)
    ->value(data('ticket.closedReason'));

$fields->field('activatedBy')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('picker')
    ->disabled(true)
    ->items(data('users'))
    ->value(data('ticket.activatedBy'));

$fields->field('activatedCount')
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('input')
    ->disabled(true)
    ->value(data('ticket.activatedCount'));

$fields->field('editedBy')
    ->label($lang->ticket->lastEditedBy)
    ->position('basic')
    ->group($lang->ticket->legendLife)
    ->control('picker')
    ->disabled(true)
    ->items(data('users'))
    ->value(data('ticket.editedBy'));

/* ====== Sidebar: contacts (rendered via to::side in html.php) ====== */
