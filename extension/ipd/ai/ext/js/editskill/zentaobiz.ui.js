window.clickSubmit = function(e)
{
    const status = $(e.submitter).data('status');
    $('[name="status"]').val(status);
};
