window.changeDeliverable = function(e)
{
    const deliverable = e.target.value;
    const url = $.createLink('project', 'createDeliverable', `projectID=${projectID}&deliverableID=${deliverable}&taskID=${taskID}`);
    loadTarget(url, '.createdeliverable-body');
}

window.changeSourceType = function(e)
{
    const sourceType = e.target.value;
    const $picker = $('[name=sourceID]').zui('picker');

    if(sourceType == 'project')
    {
        $picker.render({items: [{text: projectProcess, value: projectID}], readonly: true, search: false});
        $picker.$.setValue(projectID);
        $('[name=sourceID]').val(projectID).prop('disabled', false);
        return;
    }

    /* remote picker*/
    const url = $.createLink('project', 'ajaxGetSourceObjects', `projectID=${projectID}&deliverableID=${deliverableID}&sourceType=${sourceType}&search={search}`);
    $picker.render({items: url, readonly: false});
    $picker.$.setValue('');
    $('[name=sourceID]').val('').prop('disabled', false);
}
