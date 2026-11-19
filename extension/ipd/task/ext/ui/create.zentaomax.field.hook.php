<?php
namespace zin;

global $app;

$groupID = data('project.workflowGroup');

$deliverables   = array();
$hasDeliverable = false;
if(!empty($groupID))
{
    $type           = data('type') ?: data('task.type');
    $deliverables   = $app->control->loadModel('deliverable')->getPairs((int)$groupID, "task_{$type}", '', (int)data('project.id'));
    $hasDeliverable = $app->control->loadModel('workflowgroup')->hasFeature((int)$groupID, 'deliverable');
}

$fields = fieldList('task.create');

if(data('execution.type') == 'stage')
{
    $features = data('features');

    $fields->field('design')
           ->foldable()
           ->control('picker')
           ->items(array());

    if(!empty($features['story']))
    {
        $fields->field('mailto')->className('lite:w-full');
        $fields->field('name')->className('full:w-full');
    }
    if(empty($features['story'])) $fields->field('name')->remove('className')->className('full:w-1/2');
}

$fields->field('deliverable')
       ->width('full')
       ->control('picker')
       ->items($deliverables)
       ->hidden(!$hasDeliverable)
       ->multiple(true);
