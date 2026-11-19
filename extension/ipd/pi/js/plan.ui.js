window.getColActions = function(col)
{
    if(!privs.canCreateMilestone) return false;

    return [{
        type: 'dropdown',
        icon: 'expand-alt text-primary',
        caret: false,
        items: [
            privs.canCreateMilestone ? {text: piLang.createMilestone, icon: 'plus', url: $.createLink('pi', 'createMilestone', 'piID=' + piID + '&columnID=' + col.id), 'data-toggle': 'modal', 'data-size': 'sm'} : null,
            privs.canCreateMilestone ? {text: piLang.createTeamCard,  icon: 'plus', url: $.createLink('pi', 'createMilestone', 'piID=' + piID + '&columnID=' + col.id + '&from=plan&type=team'), 'data-toggle': 'modal', 'data-size': 'sm'} : null,
        ],
    }];
}

window.getItem = function(info)
{
    info.item.titleAttrs = {'className': 'line-clamp-1', 'title' : info.item.title}; // title的属性
    if(['milestone', 'common'].includes(info.item.cardType))
    {
        info.item.icon = 'flag';
        let avatar = "<span class='avatar rounded-full size-xs ml-1 " + (info.item.uavatar ? 'primary' : 'bg-lighter text-canvas') + "' title='" + info.item.assignedTo + "'>" + (info.item.uavatar ? info.item.uavatar : "<i class='icon icon-person'></i>");

        statusLabel = piLang.milestone.statusList[info.item.status];
        info.item.footer = {html: "<div class='flex items-center'><span class='text-sm'>" + info.item.end + "</span><div class='flex-1 flex justify-end'><span class='status-" + info.item.status + "'>" + statusLabel + "</span>" + avatar + "</div></div>"};
    }

    if(linkPairs.includes(info.item.id)) info.item.className = 'dependent';
}

window.getItemActions = function(item)
{
    if(item.cardType == 'milestone')
    {
        if(!privs.canEditMilestone && !privs.canDeleteMilestone) return false;

        return [{
            type: 'dropdown',
            icon: 'ellipsis-v text-primary',
            caret: false,
            items: [
                privs.canEditMilestone ?   {text: piLang.editMilestone,   icon: 'edit',  url: $.createLink('pi', 'editMilestone',   'id=' + item.name + '&laneID=' + item.lane), 'data-toggle': 'modal', 'data-size': 'sm'} : null,
                privs.canDeleteMilestone ? {text: piLang.deleteMilestone, icon: 'trash', url: $.createLink('pi', 'deleteMilestone', 'id=' + item.name + '&laneID=' + item.lane + '&columnID=' + item.col), 'data-confirm': piLang.milestone.confirmDelete, innerClass: 'ajax-submit'} : null
            ],
        }];
    }
    else if(item.cardType == 'common')
    {
        return [{
            type: 'dropdown',
            icon: 'ellipsis-v text-primary',
            caret: false,
            items: [
                privs.canEditMilestone ?   {text: piLang.editObjective,   icon: 'edit',  url: $.createLink('pi', 'editMilestone',   'id=' + item.name), 'data-toggle': 'modal', 'data-size': 'sm'} : null,
                privs.canDeleteMilestone ? {text: piLang.deleteObjective, icon: 'trash', url: $.createLink('pi', 'deleteMilestone', 'id=' + item.name + '&laneID=' + item.lane + '&columnID=' + item.col), 'data-confirm': piLang.milestone.confirmDelete, innerClass: 'ajax-submit'} : null
            ],
        }];
    }
}

window.getLaneActions = function(lane)
{
    if(!privs.canEditLane && !privs.canDeleteLane) return false;

    const items = [];
    if(privs.canEditLane)                            items.push({text: piLang.editLane,   icon: 'edit',  url: $.createLink('pi', 'editLane',   'id=' + lane.id), 'data-toggle': 'modal'});
    if(privs.canDeleteLane && lane.type == 'common') items.push({text: piLang.deleteLane, icon: 'trash', url: $.createLink('pi', 'deleteLane', 'id=' + lane.id), 'data-confirm': piLang.notice.confirmDeleteLane, innerClass: 'ajax-submit'});

    if(items.length == 0) return false;

    return [{
        type: 'dropdown',
        icon: 'ellipsis-v',
        caret: false,
        items: items
    }];
}

window.linkCard = function(info)
{
    linkPairs.push(info.from);// 动态追加连线关系
    if(!$('.card[z-key="' + info.from + '"]').hasClass('dependent')) $('.card[z-key="' + info.from + '"]').addClass('dependent');
    const url  = $.createLink('pi', 'linkCard', 'pi=' + piID + '&from=' + info.from + '&to=' + info.to);
    $.ajaxSubmit({url});

    info.deleted = false;
}

window.unlinkCard = function(info)
{
    /* 解决一个卡片被多个卡片依赖的情况，取消其中一个卡片，不会去掉颜色。*/
    let index = linkPairs.indexOf(info.from);
    if (index !== -1){
        linkPairs.splice(index, 1);
    }

    if($('.card[z-key="' + info.from + '"]').hasClass('dependent') && !linkPairs.includes(info.from)) $('.card[z-key="' + info.from + '"]').removeClass('dependent');
    const url  = $.createLink('pi', 'unlinkCard', 'pi=' + piID + '&from=' + info.from + '&to=' + info.to);
    $.ajaxSubmit({url});
}
