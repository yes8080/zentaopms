window.changeResult = function()
{
    let $value = event.target.value;
    $('#priBox').closest('.form-row').toggleClass('hidden', $value != 'pass');
    $('#closedReasonBox').closest('.form-row').toggleClass('hidden', $value != 'reject');
    $('#assignedToBox').closest('.form-row').toggleClass('hidden', $value == 'reject');
}

window.changeReason = function()
{
    $('#duplicateDemandBox').closest('.form-row').toggleClass('hidden', event.target.value != 'duplicate');
}
