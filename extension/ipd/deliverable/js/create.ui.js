window.refreshActivity = function(activityID)
{
    $.getJSON($.createLink('deliverable', 'ajaxGetActivityOptions', `groupID=${groupID}&activityID=${activityID}`), function(data)
    {
        const activityPicker = zui.Picker.query("[name='activity']");
        activityPicker.render({items: data});
        activityPicker.$.setValue(activityID);
    });
}
