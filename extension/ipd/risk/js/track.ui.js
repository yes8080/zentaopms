window.changeRisk = function(event)
{
    const currentValue = $(event.target).val();
    if(currentValue == '') return true;

    const $form = $(event.target).closest('form');
    if(currentValue == '0')
    {
        $form.find('.track').closest('.form-row').addClass('hidden');
        $form.find('.not-track').closest('.form-row').removeClass('hidden');
    }
    else
    {
        $form.find('.not-track').closest('.form-row').addClass('hidden');
        $form.find('.track').closest('.form-row').removeClass('hidden');
    }
}

$(function()
{
    $('.track').closest('.form-row').addClass('hidden');
});
