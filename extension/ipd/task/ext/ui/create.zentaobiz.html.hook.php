<?php
namespace zin;

query('formGridPanel')->each(function($node)
{
    $fields = $node->prop('fields');

    $fields->defaultOrders = array_merge($fields->defaultOrders, array('keywords,mailto,docs,files'));
    $fields->ordersForFull = array_merge($fields->ordersForFull, array('desc,docs,files,keywords,mailto'));

    $node->setProp('fields', $fields);
});