$(function()
{
    new zui.Tooltip('#typeHover', {title: typeTip, trigger: 'hover', placement: 'right', type: 'white', animation: false, 'className': 'text-gray border border-light programTip'});
});

window.changeType = function()
{
    const type = $('input[name=type]:checked').val();
    $('.childParams').toggleClass('hidden', type == 'parent');
}
