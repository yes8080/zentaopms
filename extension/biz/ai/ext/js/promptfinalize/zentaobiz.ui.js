function setActionLoading(button, loading, showIcon)
{
    button.prop('disabled', loading).toggleClass('disabled is-loading', loading);
    if(loading && showIcon)
    {
        if(!button.children('.finalize-loading-icon').length) button.prepend('<i class="icon icon-spinner-indicator spin finalize-loading-icon"></i>');
    }
    else
    {
        button.children('.finalize-loading-icon').remove();
    }
}

var submitting = false;

$(document).off('submit.promptFinalize', '#mainForm').on('submit.promptFinalize', '#mainForm', function(event)
{
    if(!$(this).find('#finalize-submit, #finalize-go-test-btn').length) return;
    event.preventDefault();
    return false;
});

function postFinalize(data, button)
{
    if(submitting) return;
    submitting = true;
    setActionLoading(button, true);

    $.ajax({
        url: $.createLink('ai', 'promptFinalize', 'promptID=' + promptID),
        type: 'POST',
        data: data,
        dataType: 'json'
    })
    .done(function(response)
    {
        var message = response.msg || response.message;
        if(message) zui.Messager.show({content: message, type: response.result === 'success' ? 'success' : 'danger'});

        if(response.result === 'success' && response.locate) return openUrl(response.locate);
        submitting = false;
    })
    .fail(function(xhr, status, error)
    {
        submitting = false;
        zui.Messager.show({content: saveFailed + '：' + error, type: 'danger'});
    })
    .always(function()
    {
        if(!submitting) setActionLoading(button, false);
    });
}

$(document).off('click.promptFinalize', '#finalize-submit').on('click.promptFinalize', '#finalize-submit', function(event)
{
    event.preventDefault();
    postFinalize({publish: 1}, $(this));
    return false;
});

$(document).off('click.promptFinalize', '#finalize-go-test-btn').on('click.promptFinalize', '#finalize-go-test-btn', function(event)
{
    event.preventDefault();
    if(submitting) return false;

    var button = $(this);
    submitting = true;
    setActionLoading(button, true, true);
    getTestingLocation(promptID).always(function()
    {
        submitting = false;
        setActionLoading(button, false);
    });
    return false;
});
