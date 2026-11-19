<?php
namespace zin;

global $app;
$model = $app->control->loadModel('reqintake');
$productID = (int)data('product.id');
if(!$model->canAccess('index') || ($productID && !$model->canReadProduct($productID))) return;

$app->loadLang('reqintake');
$label = $app->lang->reqintake->ownerAccount;
$owner = $productID ? $model->configuredOwner($productID) : '';
$users = array('' => '') + $app->control->loadModel('user')->getPairs('noletter|nodeleted');
if($owner !== '' && !isset($users[$owner])) $users[$owner] = $owner;

query('formGridPanel')->each(function($node) use($label, $owner, $users)
{
    $fields = $node->prop('fields');
    $fields->field('reqintakeOwner')->label($label)->control('picker')->items($users)->value($owner);
    $fields->moveAfter('reqintakeOwner', 'PO');
    $node->setProp('fields', $fields);
});
