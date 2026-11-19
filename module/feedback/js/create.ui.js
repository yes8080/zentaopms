$(document).on('change', '#feedbackProduct', function()
{
    const module = zui.Picker.query('#feedbackModule');
    if(!module) return;

    module.render({items: feedbackModuleOptions[this.value] || []});
    module.$.setValue('');
});
