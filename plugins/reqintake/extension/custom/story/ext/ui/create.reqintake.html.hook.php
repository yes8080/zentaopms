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
    if(str_starts_with($token, 'batch.'))
    {
        $batch = $model->batchConversion($token, data('type'));
        $app->loadLang('reqintake');
        $caption = htmlspecialchars(sprintf($app->lang->reqintake->batchCreateSummary, implode(', #', array_keys($batch['sources'])), $batch['scope']), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        query('formGridPanel')->before(div(setClass('panel p-3 mb-2'), html($caption)));
        return;
    }
    $feedback = $model->conversionSource($token, data('type'));
}
catch(\DomainException $error)
{
    return;
}
if((int)$feedback->product !== (int)data('product.id')) return;
[$title, $description, $acceptance, $attributes] = $model->conversionContent($feedback);
$mailto = implode(',', array_intersect(explode(',', $attributes['mailto']), array_keys($model->mailtoOptions())));
query('formGridPanel')->each(function($node) use($title, $description, $attributes, $acceptance, $mailto)
{
    $fields = $node->prop('fields');
    $fields->field('title')->value($title);
    $fields->field('category')->value($attributes['category']);
    $fields->field('pri')->value($attributes['priority']);
    $fields->field('spec')->value($description);
    $fields->field('verify')->value($acceptance);
    foreach(array('source', 'keywords', 'estimate') as $field)
    {
        if($attributes[$field] !== '') $fields->field($field)->value($attributes[$field]);
    }
    if($mailto !== '') $fields->field('mailto')->value($mailto);
    $node->setProp('fields', $fields);
});
