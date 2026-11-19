window.changeProduct = function(e)
{
    if(!oldProduct) return;

    const product = $('#product').zui('picker').$.state.value;
    const removed = oldProduct.split(',').filter(x => !product.split(',').includes(x)).join(',');

    if(hasLinkedProducts.includes(removed))
    {
        zui.Modal.alert(cannotRemoveProduct);
        $('#product').zui('picker').$.changeState({value: oldProduct})

        return false;
    }

    oldProduct = product;
}

window.changeTeam = function(e)
{
    if(!oldTeam) return;

    const team    = $('#team').zui('picker').$.state.value;
    const removed = oldTeam.split(',').filter(x => !team.split(',').includes(x)).join(',');

    if(hasLinkedTeams.includes(removed))
    {
        zui.Modal.alert(cannotRemoveTeam);
        $('#team').zui('picker').$.changeState({value: oldTeam})

        return false;
    }

    oldTeam = team;
}

window.changeStatus = function(e)
{
    if(oldStatus == 'closed') return;

    const status = $('#status').zui('picker').$.state.value;

    if(status == 'closed' && hasNoClosedPI)
    {
        zui.Modal.alert(cannotCloseART);
        $('#status').zui('picker').$.changeState({value: oldStatus})

        return false;
    }
}
