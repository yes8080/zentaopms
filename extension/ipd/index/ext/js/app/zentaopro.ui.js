/* Fix defualt ai teammate avatar color: */
$(document).on('shown', (_, args) =>
{
    const dropdown = (args || [])[0];
    if(!dropdown || dropdown.constructor.NAME !== 'Dropdown') return;
    if(!$(dropdown.trigger).closest('.prompts').length) return;
    const $menu = $(dropdown.target);
    if(!$menu.length) return;
    if($menu.data('aiCheckedAvatar')) return;
    $menu.data('aiCheckedAvatar', true);
    $menu.find('.menu-item>a').each((_, ele) =>
    {
        const $ele = $(ele);
        const url = $ele.attr('href').toLowerCase();
        if(!url) return;
        if(!url.includes('aiteammate-assignagent-') && !url.includes('?m=aiteammate&f=assignagent&')) return;
        const link = $.parseLink(url);
        const teammateID = link.vars[0][1];
        if(!teammateID) return;
        const $avatar = $ele.find('.avatar>img');
        if(!($avatar.attr('src') || '').includes('zentaoaipro/ai-teammate-default.png')) return;
        $avatar.css('filter', `hue-rotate(${teammateID * 53 % 360}deg)`);
    });
});
