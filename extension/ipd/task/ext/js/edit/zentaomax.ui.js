$(document).off('change', '[name=story], [name=execution]').on('change', '[name=story], [name=execution]', function()
{
    setStoryDesign();
});

window.waitDom('[name=design]', function(){setStoryDesign();})

window.changeType = function(event)
{
    const type = $(event.target).val();
    const link = $.createLink('task', 'ajaxGetDeliverableByTaskType', 'taskID=' + taskID + '&type=' + type + '&projectID=' + projectID);
    $.getJSON(link, function(items)
    {
        let $deliverablePicker = $('[name^=deliverable]').zui('picker');
        $deliverablePicker.render({items});
        $deliverablePicker.$.setValue('');
    });
}
