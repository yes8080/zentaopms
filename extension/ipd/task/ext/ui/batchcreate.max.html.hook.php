<?php
namespace zin;

global $app;

$hasDeliverable = $app->control->loadModel('workflowgroup')->hasFeature(data('project.workflowGroup'), 'deliverable');
if($hasDeliverable)
{
    $deliverables = $app->control->loadModel('deliverable')->getPairs(data('project.workflowGroup'), "task_devel", '', data('project.id'));
    query('formBatchPanel')->each(function($node) use($deliverables)
    {
        global $lang;
        $items = $node->prop('items');

        $batchItems = array();
        foreach($items as $item)
        {
            $batchItems[] = $item;
            if($item['name'] == 'type')
            {
                $batchItems[] = array('name' => 'deliverable',     'label' => $lang->task->deliverable, 'control' => 'picker', 'multiple' => true, 'items' => $deliverables, 'value' => '', 'width' => '160px');
                $batchItems[] = array('name' => 'fromDeliverable', 'control' => 'hidden');
            }
        }

        $node->setProp('items', $batchItems);
    });
}
