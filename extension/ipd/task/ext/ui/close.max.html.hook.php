<?php
namespace zin;

global $app, $lang;

$hasDeliverable = $app->control->loadModel('workflowgroup')->hasFeature(data('project.workflowGroup'), 'deliverable');

if($hasDeliverable && data('task.status') == 'done')
{
    $createDocUrl     = data('createDocUrl');
    $uploadDocUrl     = data('uploadDocUrl');
    $createLinkDocUrl = data('createLinkDocUrl');
    $deliverables     = data('deliverables');
    $categories       = data('categories');

    $app->loadLang('project');
    jsVar('submittedLang',        $lang->project->submitted);
    jsVar('notSubmitLang',        $lang->project->notSubmit);
    jsVar('deliverableCheckList', data('deliverableCheckList'));

    foreach($categories as $key => $category) $categories[$key]['required'] = (int)$category['required'];

    if($deliverables)
    {
        /* 追加交付物组件。 */
        $deliverable = formGroup
        (
            set::label($lang->task->deliverable),
            deliverable
            (
                set::items($deliverables),
                set::categories($categories),
                set::projectID(data('project.id')),
                set::createDocUrl($createDocUrl),
                set::uploadDocUrl($uploadDocUrl),
                set::createLinkDocUrl($createLinkDocUrl),
                set::closeTask(true),
                set::onRenderItem(jsRaw('handleRenderDeliverableItem'))
            )
        );
        query('formPanel')->append($deliverable);
    }
}
