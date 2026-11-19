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
        $escape = static fn($value) => htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        $labels = $app->lang->reqintake;
        $caption = $escape(sprintf($labels->batchCreateSummary, count($batch['sources']), $labels->storyTypes[$batch['type']]));
        $rows = array();
        foreach($batch['sources'] as $id => $version)
        {
            $scope = is_array($batch['scope']) ? $batch['scope'][$id] : $batch['scope'];
            $rows[] = '<li>#' . (int)$id . ' · ' . $escape($scope === '' ? $labels->wholeFeedback : $scope) . '</li>';
        }
        query('formGridPanel')->before(div(setClass('panel p-3 mb-2'), html($caption . '<ul>' . implode('', $rows) . '</ul>')));
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
    [$gradeType, $grade] = array_pad(explode(':', $attributes['suggestedGrade'], 2), 2, '');
    if($gradeType === data('type') && data('gradeRule') !== 'stepwise' && isset(data('fields.grade.options')[$grade]))
        $fields->field('grade')->value((int)$grade);
    $parent = $attributes['suggestedParent'];
    if($parent !== '' && !data('fields.parent.hidden') && isset(data('fields.parent.options')[$parent]))
        $fields->field('parent')->value((int)$parent);
    foreach(array('source', 'keywords', 'estimate') as $field)
    {
        if($attributes[$field] !== '') $fields->field($field)->value($attributes[$field]);
    }
    $reviewers = implode(',', array_intersect(explode(',', $attributes['suggestedReviewers']), array_keys(data('fields.reviewer.options') ?? array())));
    if($reviewers !== '')
    {
        foreach($fields->field('reviewer')->get('items') ?? array() as $item)
        {
            if($item instanceof field && $item->getName() === 'reviewer[]') $item->value($reviewers);
        }
    }
    if($mailto !== '') $fields->field('mailto')->value($mailto);
    $node->setProp('fields', $fields);
});
