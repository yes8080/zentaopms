<?php
namespace zin;

global $lang, $config;

$fields = fieldList('product.create');

$fields->field('feedback')
    ->label($lang->product->FM)
    ->control('remotepicker')
    ->value(data('fields.RD.default'))
    ->foldable();

$fields->field('ticket')
    ->label($lang->product->TM)
    ->control('remotepicker')
    ->items(data('fields.RD.options'))
    ->value(data('fields.RD.default'))
    ->foldable();

$fields->field('workflowGroup')
    ->label($lang->product->workflowGroup)
    ->control(array('control' => 'picker', 'required' => true))
    ->required(true)
    ->items(data('fields.workflowGroup.options'))
    ->value(data('fields.workflowGroup.default'));

$fields->field('type')->width(!empty($config->setCode) ? '1/2' : '1/4');
$fields->field('workflowGroup')->width(!empty($config->setCode) ? '1/2' : '1/4');

$fields->moveAfter('feedback,ticket', 'RD');
$fields->moveAfter('workflowGroup', 'name');
$fields->fullModeOrders('RD,feedback,ticket,desc');

$fields->autoLoad('workflowGroup');
$fields->loadUrl(createLink('product', 'create', "programID={program}&extra=workflowGroup={workflowGroup}"));
