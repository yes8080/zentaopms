<?php
namespace zin;

jsVar('submittedLang', $lang->project->submitted);
jsVar('notSubmitLang', $lang->project->notSubmit);
jsVar('deliverableCheckList', $deliverableCheckList);

foreach($categories as $key => $category) $categories[$key]['required'] = (int)$category['required'];

formPanel
(
    set::layout('grid'),
    set::actions(array('submit')),
    formGroup
    (
        set::label($this->lang->project->deliverableList['close'] . ($execution->status == 'closed' ? '' : $this->lang->execution->whenClosedTips)),
        set::width('full'),
        set::strong(true),
        deliverable
        (
            set::formName('deliverable'),
            set::items($deliverables),
            set::categories($categories),
            set::projectID($execution->project),
            set::createDocUrl($createDocUrl),
            set::uploadDocUrl($uploadDocUrl),
            set::createLinkDocUrl($createLinkDocUrl),
            set::onRenderItem(jsRaw('handleRenderDeliverableItem'))
        )
    )
);

if(!empty($actions))
{
    history
    (
        setClass('panel panel-form size-lg is-lite'),
        set::commentBtn(''),
        set::editCommentUrl('')
    );
}
