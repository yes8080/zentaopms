<?php
namespace zin;

global $app;
$product = data('product');
if(!$product || $product->deleted) return;

$model = $app->control->loadModel('reqintake');
if(!$model->canAccess('index') || !$model->canReadProduct((int)$product->id)) return;

$app->loadLang('reqintake');
[$account, $pending] = $model->resolveAssignee((int)$product->id);
$user = $pending ? null : $app->control->loadModel('user')->getById($account);
$labels = $app->lang->reqintake;
$name = $pending ? $labels->ownerPending : ($user->realname ?? $account);
$caption = htmlspecialchars($name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

query('.memberBox')->append(div(
    setClass('mt-3 px-3 pb-3'),
    span(setClass('text-gray mr-2'), $labels->ownerAccount),
    span(set('data-reqintake-owner', $pending ? 'pending' : 'configured'), html($caption))
));
