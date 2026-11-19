window.changeMethod = function(e) {
    const type = e.target.value;

    if(type == 'closed')
    {
        $('[name^="notifyUsers"]').zui('picker').render({disabled: true});
    }
    else
    {
        $('[name^="notifyUsers"]').zui('picker').render({disabled: false});
    }
}
