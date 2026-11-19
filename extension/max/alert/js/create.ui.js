window.rebuildAlertTypeOptions = function(objectType)
{
    const alertItems = alertRuleItems[objectType] || {};
    const items      = Object.keys(alertItems).map(function(value)
    {
        return {text: alertItems[value], value: value};
    });

    const picker = $('[name=alertType]').zui('picker');
    picker.render({items: items});

    const keys  = Object.keys(items);
    const value = keys[0];
    if(value) picker.$.setValue(value);
};

window.rebuildNotifyUserOptions = function(objectType)
{
    const userMap = alertNotifyUsers[objectType] || {};
    const items   = Object.keys(userMap).map(function(value)
    {
        return {text: userMap[value], value: value};
    });

    const picker = $('[name^=notifyUsers]').zui('picker');

    picker.render({items: items});
    picker.$.setValue('');
};

window.toggleAlertValueUnit = function(alertType)
{
    const unit = alertType === 'sv_greater' ? '%' : unitDay;
    $('#alertValueUnit').text(unit);
};

window.toggleProjectTip = function(objectType, alertType)
{
    const $tip = $('#projectModelTipBox');
    if(objectType === 'project' && alertType === 'sv_greater') $tip.removeClass('hidden');
    else $tip.addClass('hidden');
};

window.changeObject = function(e)
{
    const objectType = $(e.target).val();
    rebuildAlertTypeOptions(objectType);
    rebuildNotifyUserOptions(objectType);
    changeAlertType({target: $('[name=alertType]')[0]});
};

window.changeAlertType = function(e)
{
    const alertType  = $(e.target).val();
    const objectType = $('[name=objectType]').val();
    toggleAlertValueUnit(alertType);
    toggleProjectTip(objectType, alertType);
};
