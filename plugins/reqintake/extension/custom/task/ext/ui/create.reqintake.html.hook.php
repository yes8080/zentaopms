<?php
namespace zin;

global $app;
parse_str(str_replace(array(',', ' '), array('&', ''), $app->getParams()['cardPosition'] ?? ''), $extra);
$token = $extra['riOperation'] ?? null;
if(!is_string($token)) return;

$model = $app->control->loadModel('reqintake');
try
{
    $feedback = $model->conversionSource($token, 'task');
}
catch(\DomainException $error)
{
    return;
}
if(!isset($model->taskExecutions((int)$feedback->product)[(int)data('execution.id')])) return;
$revisions = $model->revisions($feedback);
$title = $revisions ? reset($revisions)->title : $feedback->title;
query('formGridPanel')->each(function($node) use($title)
{
    $fields = $node->prop('fields');
    $fields->field('name')->value($title);
    $node->setProp('fields', $fields);
});
