/**
 * 批量新建交付物页面的活动与可裁剪联动。
 * Linkage of activity, trimmable and trim rule in batch create page.
 */

window.changeBatchActivity = function(e)
{
    const $row     = $(e.target).closest('tr');
    const activity = e.target.value || 0;
    const url      = $.createLink('deliverable', 'ajaxGetActivityOptional', `activity=${activity}`);

    $.get(url, function(data)
    {
        const $radios = $row.find('input[name^="trimmable"][type="radio"]');
        let   $hidden = $row.find('input[name^="trimmable"][type="hidden"]');

        if(data == '1')
        {
            /* 活动可裁剪：trimmable 默认为“可裁剪”且置灰，放开裁剪准则*/
            $radios.attr('disabled', 'disabled').filter('[value="1"]').prop('checked', true);
            $radios.closest('.radio-primary').addClass('disabled');
            if(!$hidden.length) $hidden = $('<input type="hidden" value="1">').attr('name', $radios.attr('name')).appendTo($radios.closest('td'));
            $hidden.removeAttr('disabled');
            $row.find('input[name^="trimRule"]').removeAttr('disabled');
        }
        else if(data == '0')
        {
            /* 活动不可裁剪：trimmable 默认为“不可裁剪”，可手动改为“可裁剪” */
            $radios.removeAttr('disabled').filter('[value="0"]').prop('checked', true);
            $radios.closest('.radio-primary').removeClass('disabled');
            $hidden.attr('disabled', 'disabled');
            $row.find('input[name^="trimRule"]').val('').attr('disabled', 'disabled');
        }
    });
};

window.changeBatchTrimmable = function(e)
{
    const $row = $(e.target).closest('tr');
    if(e.target.value == '1')
    {
        $row.find('input[name^="trimRule"]').removeAttr('disabled');
    }
    else
    {
        $row.find('input[name^="trimRule"]').val('').attr('disabled', 'disabled');
    }
};
