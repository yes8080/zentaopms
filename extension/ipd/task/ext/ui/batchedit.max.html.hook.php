<?php
namespace zin;

global $app;

if(data('project.workflowGroup'))
{
    $hasDeliverable = $app->control->loadModel('workflowgroup')->hasFeature(data('project.workflowGroup'), 'deliverable');
    query('formBatchPanel')->each(function($node) use($hasDeliverable)
    {
        global $lang;
        $items = $node->prop('items');

        $batchItems = array();
        foreach($items as $item)
        {
            $batchItems[] = $item;
            if($item['name'] == 'type')
            {
                $batchItems[] = array('name' => 'deliverable', 'label' => $lang->task->deliverable, 'hidden' => empty($hasDeliverable), 'control' => 'picker', 'multiple' => true, 'items' => array(), 'width' => '160px');
            }
        }

        $node->setProp('items', $batchItems);
    });
}
