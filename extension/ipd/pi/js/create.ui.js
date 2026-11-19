window.changeART = function()
{
    const art = $(this).val();
    const url = $.createLink('pi', 'create', 'art=' + art);
    loadPartial(url, '#teamRow,#productRow');
}

window.changeAcl = function()
{
    const acl = $(this).val();
    $('[name^=whitelist]').closest('.form-row').toggleClass('hidden', acl != 'private');
}

window.computeDays = function(e)
{
    const end       = e.target.value;
    let nextWorkDay = getNextWorkDay(end);
    nextWorkDay     = nextWorkDay.toISOString().substr(0, 10);

    if($(e.target).closest('.form-batch-control').next().find('[name^=begin]').length) $(e.target).closest('.form-batch-control').next().find('[name^=begin]').zui('datePicker').$.setValue(nextWorkDay);
}

window.getNextWorkDay = function(end)
{
    let nextWorkDay = new Date(end);
    nextWorkDay.setDate(nextWorkDay.getDate() + 1);

    if(weekend == 1)
    {
        while (nextWorkDay.getDay() == restDay || (holidays.indexOf(nextWorkDay.toISOString().substr(0, 10)) != -1))
        {
            nextWorkDay.setDate(nextWorkDay.getDate() + 1);
        }
    }
    else
    {
        while (nextWorkDay.getDay() == 0 || nextWorkDay.getDay() == 6 || (holidays.indexOf(nextWorkDay.toISOString().substr(0, 10)) != -1))
        {
            nextWorkDay.setDate(nextWorkDay.getDate() + 1);
        }
    }

    return nextWorkDay;
}
