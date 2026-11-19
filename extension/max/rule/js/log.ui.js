window.renderLogCell = function(result, info)
{
    if(info.col.name == 'status' && result)
    {
        result[0] = {html: `<span class='status-${info.row.data.status}'>` + info.row.data.statusLabel + "</span>"};
    }

    return result
}

window.changeDate = function(date)
{
    const begin = $('[name=begin]').val();
    const end   = $('[name=end]').val();
    const url   = $.createLink('rule', 'log', `ruleID=${ruleID}&orderBy=${orderBy}`);

    const options = {method: 'post', data: {'begin': begin, 'end': end}};

    loadTarget(url, '.log-modal-body', options);
}
