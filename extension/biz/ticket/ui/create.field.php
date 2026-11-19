<?php
namespace zin;

global $lang, $config, $app;

$fields = defineFieldList('ticket.create');

/* Product field. */
$fields->field('product')
    ->width('1/2')
    ->control('picker')
    ->required(true)
    ->items(data('products'))
    ->value(data('productID'));

/* Module field. */
$buildModuleControl = function() use ($lang, $app)
{
    $manageBtn = null;
    if(common::hasPriv('tree', 'browse'))
    {
        $isHidden = count(data('modules')) > 1 || (!$app->user->admin && strpos(',' . $app->user->view->products . ',', ',' . data('productID') . ',') === false);
        $manageBtn = span
        (
            setID('manageModule'),
            setClass('btn' . ($isHidden ? ' hidden' : '')),
            icon('treemap'),
            setData(array('toggle' => 'modal', 'size' => 'lg')),
            set('href', createLink('tree', 'browse', "rootID=" . data('productID') . "&viewType=ticket")),
            set('title', $lang->tree->manage),
        );
    }

    return inputGroup
    (
        setID('moduleBox'),
        picker(set::name('module'), set::required(true), set::items(data('modules')), set::value(data('moduleID'))),
        $manageBtn
    );
};

$fields->field('module')
    ->width('1/2')
    ->control($buildModuleControl);

/* Type field. */
$fields->field('type')
    ->width('1/2')
    ->control('picker')
    ->items($lang->ticket->typeList)
    ->value(data('defaultType'));

/* OpenedBuild field. */
$fields->field('openedBuild')
    ->width('1/2')
    ->control(array('control' => 'picker', 'multiple' => true))
    ->items(data('builds'));

/* AssignedTo field. */
$fields->field('assignedTo')
    ->width('1/2')
    ->control('picker')
    ->items(data('users'))
    ->value(data('product') ? data('product.ticket') : '');

/* Deadline field. */
$fields->field('deadline')
    ->width('1/2')
    ->control('date');

/* From field - customer/contact/notifyEmail. */
$buildFromControl = function() use ($lang, $config)
{
    $customerRequired = strpos(",{$config->ticket->create->requiredFields},", ',customer,') !== false;
    $contactRequired  = strpos(",{$config->ticket->create->requiredFields},", ',contact,') !== false;
    $emailRequired    = strpos(",{$config->ticket->create->requiredFields},", ',notifyEmail,') !== false;

    return div
    (
        setClass('customerBox w-full flex'),
        inputGroup(
        setClass('flex-1'),
        span(setClass('input-group-addon' . ($customerRequired ? ' required' : '')), $lang->ticket->customer),
        input(setClass('customerInput'), set::name('customer[0]'), set::value(data('customer'))),
        span(setClass('input-group-addon' . ($contactRequired ? ' required' : '')), $lang->ticket->contact),
        input(setClass('contactInput'), set::name('contact[0]'), set::value(data('contact'))),
        span(setClass('input-group-addon' . ($emailRequired ? ' required' : '')), $lang->ticket->notifyEmail),
        input(setClass('notifyEmailInput'), set::name('notifyEmail[0]'), set::value(data('email')))
        ),
        div
        (
            setClass('pl-2 flex self-center line-btn c-actions first-action'),
            btn
            (
                bind::click('addNewLine(event)'),
                setClass('btn btn-link text-gray addLine'),
                icon('plus')
            ),
            btn
            (
                bind::click('removeLine(event)'),
                setClass('btn btn-link text-gray removeLine hidden'),
                icon('trash')
            )
        )
    );
};

$fields->field('from')
    ->label($lang->ticket->from)
    ->width('full')
    ->control($buildFromControl);

/* Title field. */
$fields->field('title')
    ->label($lang->ticket->title)
    ->width('1/2')
    ->control('colorInput')
    ->required(true)
    ->value(data('ticketTitle'));

/* Pri field. */
$fields->field('pri')
    ->label($lang->ticket->pri)
    ->width('1/4')
    ->control('priPicker')
    ->items($lang->ticket->priList)
    ->value(data('pri'));

/* Estimate field. */
$fields->field('estimate')
    ->label($lang->ticket->estimate)
    ->width('1/4')
    ->control('input')
    ->value(data('estimate'));

/* Desc field. */
$fields->field('desc')
    ->width('full')
    ->control(array('control' => 'editor', 'templateType' => 'ticket'))
    ->value(data('desc'));

/* Mailto field. */
$fields->field('mailto')
    ->width('1/2')
    ->control('mailto')
    ->items(data('users'));

/* Keywords field. */
$fields->field('keywords')
    ->width('1/2')
    ->control('input');

/* Files field. */
$fields->field('files')
    ->width('full')
    ->control('fileSelector');
