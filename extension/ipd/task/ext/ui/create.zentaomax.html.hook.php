<?php
namespace zin;

query('formGridPanel')->each(function($node)
{
    $fields = $node->prop('fields');

    if(data('execution.type') == 'stage')
    {
        $features = data('features');

        $fields->orders('type,testStoryBox', 'type,testStoryBox,parent,assignedToBox', 'desc,deliverable,module,storyBox,design,keywords,mailto,files');
        $fields->fullModeOrders('type,module,storyBox,testStoryBox,parent,assignedToBox,name', 'design,desc,deliverable,files,mailto,keywords');
        if(empty($features['story'])) $fields->fullModeOrders('type,module,storyBox,testStoryBox,design,assignedToBox', 'desc,deliverable,files,mailto,keywords', 'design,name,assignedToBox');
    }

    $fields->autoLoad('type', 'deliverable');

    $fields->defaultOrders = array_merge($fields->defaultOrders, array('desc,deliverable'));
    $fields->ordersForFull = array_merge($fields->ordersForFull, array('desc,deliverable'));

    $node->setProp('fields', $fields);
});
