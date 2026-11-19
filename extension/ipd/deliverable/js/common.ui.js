const DELIVERABLE_CHECK_CONFIGS = {'taskClose': '#taskCloseConfig', 'executionClose': '#executionCloseConfig', 'projectClose': '#projectCloseConfig'};

function setCheckConfigState($config, checked)
{
    $config.toggleClass('hidden', !checked);
    $config.find('input,select').removeClass('not-submit-disabled-value').prop('disabled', !checked);
    $config.find('input:disabled,select:disabled').addClass('not-submit-disabled-value');
    $config.find('.picker-box').each(function(){ $(this).zui('picker')?.render({disabled: !checked}); });
}

window.toggleCheckConfig = function(e)
{
    setCheckConfigState($(DELIVERABLE_CHECK_CONFIGS[e.target.name]), e.target.checked);
};

window.changeModule = function(e)
{
    const isDesign   = !!designModule && String(e.target.value) === String(designModule);
    const $taskClose = $('[name="taskClose"]');

    $('.deliverable-list').closest('.form-group').toggleClass('hidden', isDesign);
    $taskClose.closest('.checkbox-primary').toggleClass('hidden', isDesign);
    if(isDesign && $taskClose.length)
    {
        $taskClose.prop('checked', false);
        window.toggleCheckConfig({target: $taskClose[0]});
    }
}

$(function()
{
    Object.keys(DELIVERABLE_CHECK_CONFIGS).forEach(name => setCheckConfigState($(DELIVERABLE_CHECK_CONFIGS[name]), $('[name="' + name + '"]').prop('checked')));

    const $form = $('.check-step').closest('form');
    if($form.length) $form[0].addEventListener('submit', function()
    {
        Object.entries(DELIVERABLE_CHECK_CONFIGS).forEach(([name, selector]) =>
        {
            const $checkbox = $('[name="' + name + '"]');
            if($checkbox.length && !$checkbox.prop('checked')) setCheckConfigState($(selector), false);
        });
    }, true);
});

window.changeActivity = function(e)
{
    $('input[name="trimmable"][type="radio"]').removeAttr('disabled');

    const activity = e.target.value || 0;
    const url      = $.createLink('deliverable', 'ajaxGetActivityOptional', `activity=${activity}`);

    $.get(url, function(data)
    {
        if(data == '1')
        {
            $('#trimmable').removeAttr('disabled');
            $('input[name="trimmable"][type="radio"]').attr('disabled', 'disabled');
            $('input[name="trimmable"][value="1"]').prop('checked', true);
            $('[type=radio][name=trimmable]').closest('.radio-primary').addClass('disabled');
            $('[type=radio][name=trimmable]').closest('.check-list').addClass('disabled');

            $('input[name=trimRule]').removeAttr('disabled');
        }
        else if(data == '0')
        {
            $('#trimmable').attr('disabled', 'disabled');
            $('input[name="trimmable"][value="0"]').prop('checked', true);
            $('[type=radio][name=trimmable]').closest('.radio-primary').removeClass('disabled');
            $('[type=radio][name=trimmable]').closest('.check-list').removeClass('disabled');

            $('input[name=trimRule]').val('').attr('disabled', 'disabled');
        }
    });
}

window.changeTrimmable = function(e)
{
    const trimmable = e.target.value;
    if(trimmable == '1')
    {
        $('input[name=trimRule]').removeAttr('disabled');
    }
    else
    {
        $('input[name=trimRule]').val('').attr('disabled', 'disabled');
    }
}
