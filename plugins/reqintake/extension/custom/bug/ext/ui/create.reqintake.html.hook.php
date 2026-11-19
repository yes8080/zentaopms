<?php
namespace zin;

global $app;
$extras = $app->getParams()['extras'] ?? '';
parse_str(str_replace(',', '&', $extras), $params);
$token = $params['riOperation'] ?? null;
if(!is_string($token)) return;

$model = $app->control->loadModel('reqintake');
try
{
    $feedback = $model->conversionSource($token, 'bug');
}
catch(\DomainException $error)
{
    return;
}
if((int)$feedback->product !== (int)data('bug.productID')) return;
[$title, $description] = $model->conversionContent($feedback);

query('formGridPanel')->each(function($node) use($title, $description, $token)
{
    $fields = $node->prop('fields');
    $fields->field('title')->value($title);
    $fields->field('steps')->value($description);
    $node->setProp('fields', $fields);
    $node->setProp('loadUrl', str_replace('allUsers={allUsers}', 'allUsers={allUsers},riOperation=' . $token, $node->prop('loadUrl')));
});
