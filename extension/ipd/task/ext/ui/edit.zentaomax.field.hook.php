<?php
namespace zin;

global $app;

$groupID = data('project.workflowGroup');

$deliverables   = array();
$hasDeliverable = false;
if(!empty($groupID))
{
    $type           = data('task.type');
    $deliverables   = $app->control->loadModel('deliverable')->getPairs((int)$groupID, "task_{$type}", '', (int)data('project.id'));
    $hasDeliverable = $app->control->loadModel('workflowgroup')->hasFeature((int)$groupID, 'deliverable');
}

$fields = fieldList('task.edit');

$fields->field('deliverable')
       ->position('info')
       ->width('1/2')
       ->id('deliverableBox')
       ->control('picker')
       ->items($deliverables)
       ->multiple(true)
       ->hidden(!$hasDeliverable)
       ->value(data('task.deliverable'))
       ->moveAfter('desc');
