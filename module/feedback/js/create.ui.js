$(document).on('change', '#feedbackProduct', function()
{
    const module = document.querySelector('#feedbackModule');
    if(!module) return;

    module.replaceChildren(new Option('', '0'));
    const options = feedbackModuleOptions[this.value] || {};
    for(const [id, name] of Object.entries(options)) module.add(new Option(name, id));
});
