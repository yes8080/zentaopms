window.changeTimerModule = function(module)
{
    const operations = {};
    /* Request allowed operations by rebuilding from page: use all and filter via data attributes if provided. */
    const $operation = $('[name=operation]').zui('picker');
    if(!$operation) return;

    $.get($.createLink('ai', 'ajaxGetTimerOperations', 'module=' + encodeURIComponent(module || '')), function(resp)
    {
        let items = [];
        try
        {
            const data = typeof resp === 'string' ? JSON.parse(resp) : resp;
            const list = (data && data.data) ? data.data : data;
            items = Object.keys(list || {}).map(key => ({text: list[key], value: key}));
            items.unshift({text: '', value: ''});
        }
        catch(e)
        {
            items = [{text: '', value: ''}];
        }
        $operation.render({items});
        $operation.$.setValue('');
        window.changeTimerOperation('');
    });
};

window.changeTimerOperation = function(operation)
{
    const showNotify = operation === notifyOperation;
    $('.notify-fields').toggleClass('hidden', !showNotify);
};

window.changeTimerCycleType = function(e)
{
    const type = e && e.target ? e.target.value : $('[name=cycleType]:checked').val();
    $('.cycle-type-detail').addClass('hidden');
    $('.cycle-type-detail.type-' + type).removeClass('hidden');
};
