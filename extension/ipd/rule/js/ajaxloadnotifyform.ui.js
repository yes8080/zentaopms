window.copyField = function(e)
{
    const btn     = e.relativeTarget.target;
    const field   = $(btn).closest('.form-row').find('.form-group').attr('data-name');
    const varName = e.key;

    if($(btn).hasClass('editor'))
    {
        $('zen-editor[name="' + field + '"]')[0].getHTML().then((content) => {
            content += varName;
            $('zen-editor[name="' + field + '"]')[0].setHTML(content);
        })
    }
    else
    {
        let value = $(`[name^="${field}"]`).val();
        value += varName;
        $(`[name^="${field}"]`).val(value);
    }
}
