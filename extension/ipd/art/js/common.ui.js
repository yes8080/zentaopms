window.setWhiteList = function()
{
    const acl = $("input[name='acl']:checked").val();
    acl != 'open' ? $('#whitelist').closest('.form-group').removeClass('hidden') : $('#whitelist').closest('.form-group').addClass('hidden');
}
