window.changeBatchActivity = function(e)
{
    const $row     = $(e.target).closest('tr');
    const activity = e.target.value || 0;
    const url      = $.createLink('deliverable', 'ajaxGetActivityOptional', `activity=${activity}`);

    $.get(url, function(data)
    {
        if(data == '1')
        {
            $row.find('input[name^="trimmable"]').attr('disabled', 'disabled').filter('[value="1"]').prop('checked', true);
            $row.find('input[name^="trimRule"]').removeAttr('disabled');
        }
        else if(data == '0')
        {
            $row.find('input[name^="trimmable"]').attr('disabled', 'disabled');
            $row.find('input[name^="trimmable"][value="0"]').prop('checked', true);
            $row.find('input[name^="trimRule"]').val('').attr('disabled', 'disabled');
        }
    });
};

function setBatchTrimRuleState($row, trimmable)
{
    if(trimmable == '1')
    {
        $row.find('input[name^="trimRule"]').removeAttr('disabled');
    }
    else
    {
        $row.find('input[name^="trimRule"]').val('').attr('disabled', 'disabled');
    }
}

window.changeBatchTrimmable = function(e)
{
    const $row = $(e.target).closest('tr');
    setBatchTrimRuleState($row, e.target.value);
};

window.renderDeliverableBatchRow = function($row, _index, row)
{
    setBatchTrimRuleState($row, row.trimmable);
    if(optionalActivities.includes(+row.activity))
    {
        $row.find('input[name^="trimmable"]').attr('disabled', 'disabled').filter('[value="1"]').prop('checked', true);
        $row.find('input[name^="trimRule"]').removeAttr('disabled');
    }
};
