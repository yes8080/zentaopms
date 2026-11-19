window.changeART = function()
{
    const art = $(this).val();
    const url = $.createLink('pi', 'edit', 'piID=' + piID + 'artID=' + art);
    loadPartial(url, '#teamRow,#productRow');
}

window.changeAcl = function()
{
    const acl = $(this).val();
    $('[name^=whitelist]').closest('.form-row').toggleClass('hidden', acl != 'private');
}

window.changeProduct = function()
{
    if(!oldProduct) return;

    const product = $('#product').zui('picker').$.state.value;
    const removed = oldProduct.split(',').filter(x => !product.split(',').includes(x)).join(',');

    if(removed && hasLinkedProducts.includes(removed))
    {
        zui.Modal.alert(cannotRemoveProduct);
        $('#product').zui('picker').$.changeState({value: oldProduct})

        return false;
    }

    oldProduct = product;
}

window.changeTeam = function()
{
    if(!oldTeam) return;

    const team = $('#team').zui('picker').$.state.value;
    const removed = oldTeam.split(',').filter(x => !team.split(',').includes(x)).join(',');

    if(removed && hasLinkedTeams.includes(removed))
    {
        zui.Modal.alert(cannotRemoveTeam);
        $('#team').zui('picker').$.changeState({value: oldTeam})

        return false;
    }
    else if(removed && linkedExecutionTeams.includes(removed))
    {
        zui.Modal.confirm({message: confirmRemoveTeam, onResult: function(result)
        {
            if(!result)
            {
                $('#team').zui('picker').$.changeState({value: oldTeam});
                return false;
            }
            else
            {
                oldTeam = team;
            }
        }});
    }
    else
    {
        oldTeam = team;
    }
}
