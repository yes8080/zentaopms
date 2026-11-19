window.refreshGantt = function(link)
{
    $.getJSON(link, function(response)
    {
        const data = JSON.parse(response.data);
        gantt._clear_data();
        gantt.parse(data.plans);
        initGanttSplitState();
    });
}

window.setMinBuffering = function(event)
{
    const checked = $(event.target).prop('checked');
    $('.scheduleBox input[name=minBuffering]').prop('disabled', !checked);
    if(!checked) $('.scheduleBox input[name=minBuffering]').val('');
}

window.createTmpGanttVersion = function(callback)
{
    const ganttData = {data:[], links:[]};
    ganttData.links = gantt.getLinks();
    gantt.eachTask(function(task)
    {
        const data = {};
        for(let key in task)
        {
            if(key.indexOf('$') == 0) continue;

            data[key] = task[key];
            if(key == 'start_date' || key == 'end_date')
            {
                const date = task[key];
                data[key] = date.getDate().toString().padStart(2, '0') + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getFullYear();
            }
        }
        ganttData.data.push(data);
    });

    const form = new FormData();
    form.append('data', JSON.stringify(ganttData));
    $.ajaxSubmit({
        url: $.createLink('programplan', 'ajaxCreateTmpGanttVersion', `projectID=${projectID}&productID=${productID}&type=${type}`),
        data: form,
        onSuccess: callback,
        onFail: function(error)
        {
            if(error?.message) zui.Modal.alert(error.message);
        }
    });
}

window.setManualSchedule = function(event)
{
    const checked = $(event.target).prop('checked');
    $('.globalScheduleBox').prop('disabled', checked);

    if(checked) createTmpGanttVersion();
}

window.setGlobalSchedule = function(event)
{
    const checked = $(event.target).prop('checked');
    $('.manualScheduleBox').prop('disabled', checked);

    if(!checked) return true;
    const minBuffering = $('.scheduleBox input[name=minBuffering]').val();
    $.getJSON($.createLink('project', 'ajaxAutoScheduleForTask', `projectID=${projectID}&productID=${productID}&minBuffering=${minBuffering}`), function(response)
    {
        if(typeof response.data !== 'undefined')
        {
            zui.Modal.confirm(response.message).then(result =>
            {
                if(result)
                {
                    createTmpGanttVersion(function()
                    {
                        const form = new FormData();
                        form.append('data', JSON.stringify(response.data));
                        $.ajaxSubmit({url: $.createLink('project', 'ajaxSaveTaskSchedule'), data: form});
                    });
                }
            });
        }
        else if(response.result == 'success')
        {
            zui.Messager.show({message: response.message, type: 'success', close: true});
        }
        else
        {
            zui.Modal.alert(response.message);
        }

        $('.manualScheduleBox').prop('disabled', false);
        $(event.target).prop('checked', false);
        $('.scheduleBox menu').removeClass('show');
    })
}
