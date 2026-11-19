window.changeRelation = function(e)
{
    const relation = e.target.value;
    const url      = $.createLink('rule', 'ajaxGetModuleByRelation', `fromObjectType=${fromObjectType}&relation=${relation}`);

    if(relation)
    {
        $.getJSON(url, function(data) {
            $('[name="module"]').zui('picker').render({items: data});
            $('[name="module"]').zui('picker').$.setValue('');
        });
    }
    else
    {
        $('[name="module"]').zui('picker').render({items: []});
        $('[name="module"]').zui('picker').$.setValue('');
    }
}
