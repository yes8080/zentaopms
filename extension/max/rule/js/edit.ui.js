window.changeType = function(e) {
    const type = e.target.value;

    if(type == 'group')
    {
        $('.workflowGroupBox').removeClass('hidden');
    }
    else
    {
        $('.workflowGroupBox').addClass('hidden');
    }
}
