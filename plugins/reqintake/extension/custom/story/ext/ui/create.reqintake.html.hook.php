<?php
namespace zin;

global $app;
$extra = $app->getParams()['extra'] ?? '';
parse_str(str_replace(',', '&', $extra), $params);
$token = $params['riOperation'] ?? null;
if(!is_string($token)) return;

$model = $app->control->loadModel('reqintake');
try
{
    $feedback = $model->conversionSource($token, data('type'));
}
catch(\DomainException $error)
{
    return;
}
if((int)$feedback->product !== (int)data('product.id')) return;
$revisions = $model->revisions($feedback);
$title = $revisions ? reset($revisions)->title : $feedback->title;

query('formGridPanel')->each(function($node) use($title)
{
    $fields = $node->prop('fields');
    $fields->field('title')->value($title);
    $node->setProp('fields', $fields);
});
