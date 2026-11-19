window.changeType = function(event)
{
    const type = $(event.target).val();
    const link = $.createLink('task', 'ajaxGetDeliverableByTaskType', 'taskID=0&type=' + type + '&projectID=' + projectID);
    $.getJSON(link, function(items)
    {
        let $deliverablePicker = $(event.target).closest('.form-batch-row').find('[name^=deliverable]').zui('picker');
        $deliverablePicker.render({items});
        $deliverablePicker.$.setValue('');
    });
}
