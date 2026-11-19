window.handleResultChange = function(e)
{
    var result     = $(e.target).val();
    var remarkRow  = $('#remarkRow');
    var confirmBtn = $('#confirmBtn');
    var saveBtn    = $('#saveBtn');

    if(result === 'refine')
    {
        remarkRow.removeClass('hidden');
        saveBtn.removeClass('hidden');
        confirmBtn.addClass('hidden');
    }
    else
    {
        remarkRow.addClass('hidden');
        saveBtn.addClass('hidden');
        confirmBtn.removeClass('hidden');
    }
};
