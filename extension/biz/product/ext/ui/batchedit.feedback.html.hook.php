<?php
namespace zin;

global $lang;
query('formBatchPanel')->each(function($node) use ($lang)
{
    $items    = $node->prop('items');
    $newItems = array();
    foreach($items as $field => $item)
    {
        if($field == 'feedback' || $field == 'ticket') continue;

        $newItems[$field] = $item;
        if($field == 'RD')
        {
            $newItems['feedback'] = $items['feedback'];
            $newItems['ticket']   = $items['ticket'];
            $newItems['feedback']['label'] = $lang->product->FM;
            $newItems['ticket']['label']   = $lang->product->TM;
        }
    }
    $node->setProp('items', $newItems);

    $customFieldsProp = $node->prop('customFields');
    $customFieldsProp['list']['feedback'] = $lang->product->FM;
    $customFieldsProp['list']['ticket']   = $lang->product->TM;
    $node->setProp('customFields', $customFieldsProp);
});
