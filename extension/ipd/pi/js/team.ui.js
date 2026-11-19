window.getCol = function(col)
{
    if(col.type == 'story')
    {
        return $.extend({content: function(info)
        {
            let workhour = 0;
            for(let i in info.items)
            {
                let item = info.items[i];
                if(item.estimate != undefined) workhour += parseFloat(item.estimate);
            }

            let extendHtml =
            `
              <div class='relative'>
                <div class='flex px-2 workhour'>
                  <div class='cell py-2 px-1 flex-1 row'>
                    <div class='flex-1 center'>${workloadLabel}</div>
                    <div class='flex-1 center'>${workhour}${hourUnit}</div>
                  </div>
                  <div class='cell py-2 px-1 flex-1 row'>
                    <div class='flex-1 center'>${capacityLabel}</div>
                    <div class='flex-1 capacity center border' data-column='${col.id}'>${col.capacity}${hourUnit}</div>
                  </div>
                </div>
            `;

            return {html: extendHtml};
        }}, col);
    }

    return $.extend({attrs: {id : col.id}}, col);  // 风险和目标列
}

window.getLane = function(lane)
{
    if(teamID > 0) lane.minHeight = window.innerHeight - 235;
}

window.getLaneActions = function(lane)
{
    if(!privs.canEditLane) return false;

    const items = [];
    items.push({text: editLane,   icon: 'edit',  url: $.createLink('pi', 'editLane', 'id=' + lane.id), 'data-toggle': 'modal'});
    return [{
        type: 'dropdown',
        icon: 'ellipsis-v',
        caret: false,
        items: items
    }];
}

window.getColActions = function(col)
{
    if(col.type == 'story')
    {
        if(!privs.canCreateStory && !privs.canLinkStory) return false;

        let $group  = $(`.kanban[z-key=group${col.group}]`);
        let laneID  = 0;
        if($group.length) laneID = $group.find('.kanban-lane.is-first').attr('z-lane');

        return [{
            type: 'dropdown',
            icon: 'expand-alt text-primary',
            caret: false,
            items: [
                privs.canCreateStory ? {text: createStory, url: $.createLink('story', 'create', 'product=' + product + '&branch=0&moduleID=0&storyID=0&objectID=0&bugID=0&planID=0&todoID=0&extra=piID=' + piID + ',laneID=' + laneID + ',columnID=' + col.id + '&storyType=story'), 'data-toggle': 'modal', 'data-size' : 'lg'} : null,
                privs.canCreateRequirement ? {text: createRequirement, url: $.createLink('story', 'create', 'product=' + product + '&branch=0&moduleID=0&storyID=0&objectID=0&bugID=0&planID=0&todoID=0&extra=piID=' + piID + ',laneID=' + laneID + ',columnID=' + col.id + '&storyType=requirement'), 'data-toggle': 'modal', 'data-size' : 'lg'} : null,
                privs.canCreateEpic ? {text: createEpic, url: $.createLink('story', 'create', 'product=' + product + '&branch=0&moduleID=0&storyID=0&objectID=0&bugID=0&planID=0&todoID=0&extra=piID=' + piID + ',laneID=' + laneID + ',columnID=' + col.id + '&storyType=epic'), 'data-toggle': 'modal', 'data-size' : 'lg'} : null,
                privs.canLinkStory   ? {text: linkStory, url: $.createLink('pi', 'linkStory', 'piID=' + piID + '&columnID=' + col.id), 'data-toggle': 'modal', 'data-size' : 'lg'} : null,
                (privs.canCreateStory || privs.canCreateRequirement || privs.canCreateEpic || privs.canLinkStory) ? {type: 'divider'} : null,
                privs.canCreateCard ? {text: createCard, url: $.createLink('pi', 'createCard', `piID=${piID}&columnID=${col.id}&from=team`), 'data-toggle': 'modal'} : null,
            ],
        }];
    }
    else if(col.type == 'risk')
    {
        if(!privs.canCreateRisk) return false;

        return [{
            type: 'dropdown',
            icon: 'expand-alt text-primary',
            caret: false,
            items: [
                privs.canCreateRisk ? {text: riskLang.create, icon: 'plus', url: $.createLink('risk', 'create', `projectID=${piID}&from=pi&colID=${col.id}`), 'data-toggle': 'modal', 'data-size': 'lg'} : null,
            ],
        }];
    }
    else if(col.type == 'objective')
    {
        if(!privs.canCreateObjective) return false;

        return [{
            icon: 'expand-alt text-primary',
            url : $.createLink('pi', 'createMilestone', 'piID=' + piID + '&columnID=' + col.id + '&from=team'),
            'data-toggle': 'modal',
            'data-size': 'sm'
        }];
    }
}

window.getItemActions = function(item)
{
    if(['story', 'requirement', 'epic'].includes(item.cardType))
    {
        if(!privs.canUnlinkStory) return false;

        return [{
            type: 'dropdown',
            icon: 'ellipsis-v text-primary',
            caret: false,
            items: [{text: unlinkStory, icon: 'unlink', url: $.createLink('pi', 'unlinkStory', 'piID=' + piID + '&columnID=' + item.col + '&laneID=' + item.lane + '&storyID=' + item.cardID), 'data-confirm': confirmUnlink, innerClass: 'ajax-submit'}],
        }];
    }
    else if(item.cardType == 'risk')
    {
        return [{
            type  : 'dropdown',
            icon  : 'ellipsis-v text-primary',
            caret : false,
            items : buildRiskActions(item)
        }];
    }
    else if(item.cardType == 'objective')
    {
        if(!privs.canEditObjective && !privs.canDeleteObjective) return false;

        return [{
            type: 'dropdown',
            icon: 'ellipsis-v text-primary',
            caret: false,
            items: [
                privs.canEditObjective   ? {text: editObjective,   icon: 'edit',  url: $.createLink('pi', 'editMilestone',   'cardID=' + item.name + '&laneID=' + item.lane), 'data-toggle': 'modal', 'data-size': 'sm'} : false,
                privs.canDeleteObjective ? {text: deleteObjective, icon: 'trash', url: $.createLink('pi', 'deleteMilestone', 'cardID=' + item.name + '&laneID=' + item.lane + '&colID=' + item.col), 'data-confirm': confirmDelete, innerClass: 'ajax-submit'} : false
            ],
        }];
    }
    else if(item.cardType == 'common')
    {
        return [{
            type: 'dropdown',
            icon: 'ellipsis-v text-primary',
            caret: false,
            items: buildCardActions(item)
        }];
    }
}

window.getItem = function(info)
{
    info.item.titleAttrs = {'className' : 'line-clamp-1', 'title' : info.item.title}; // title的属性
    if(['story', 'requirement', 'epic'].includes(info.item.cardType))
    {
        const storyType = info.item.cardType;
        if(privs.canViewStory)
        {
            info.item.titleUrl   = $.createLink(storyType, 'view', 'storyID=' + info.item.name); // title的链接
            info.item.titleAttrs = {'data-toggle' : 'modal', 'data-size': 'lg', 'className' : 'card-title line-clamp-1', 'title': info.item.title}; // title的属性
        }

        let avatar = "<span class='avatar rounded-full size-xs ml-1 " + (info.item.uavatar ? 'primary' : 'bg-lighter text-canvas') + "' title='" + info.item.assignedTo + "'>" + (info.item.uavatar ? info.item.uavatar : "<i class='icon icon-person'></i>");
        if(privs.canAssignToStory) avatar = "<a href='" + $.createLink('story', 'assignTo', 'storyID=' + info.item.name + '&kanbanGroup=default&from=&storyType=story&columnID=' + info.item.col) + "' title='" + info.item.assignedTo + "' data-toggle='modal'>" + avatar + "</a>";

        info.item.icon   = storyType == 'story' ? 'product' : 'person';
        info.item.footer = {html: "<div class='flex items-center'><span class='pri-" + info.item.pri + "'>" + info.item.pri + "</span><span class='text-sm ml-2 mr-1'>" + estimateLang + "</span><span class='text-sm'>" + parseFloat(info.item.estimate) + hourUnit +"</span><div class='flex-1 flex justify-end'><span class='stage-" + info.item.stage + "'>" + info.item.stageLabel + "</span>" + avatar + "</div></div>"};
    }
    else if(info.item.cardType == 'risk')
    {
        if(privs.canViewRisk)
        {
            info.item.titleUrl   = $.createLink('risk', 'view', 'id=' + info.item.name + '&from=pi'); // title的链接
            info.item.titleAttrs = {'data-toggle' : 'modal', 'data-size' : 'lg', 'className' : 'card-title line-clamp-1', 'title' : info.item.title}; // title的属性
        }

        info.item.content     = info.item.strategy ? {html: '<div class="flex items-center"><span class="text-sm mr-1 text-mute">' + riskLang.strategy + '</span><span class="text-sm">' + riskLang.strategyList[info.item.strategy] + '</span></div>'} : {html: '<div class="flex items-center"><span class="text-sm mr-1 text-mute">' + riskLang.strategy + '</span></div>'};
        info.item.footer      = riskLang.statusList[info.item.status];
        info.item.footer      = {html: `<div class='flex items-center'><span class='text-sm mr-1 text-mute'>${riskLang.rate}</span><span class='text-sm'>${info.item.rate}</span>` + "<div class='flex-1 flex justify-end'><span class='status-" + info.item.status + "'>" + riskLang.statusList[info.item.status] + "</span></div></div>"};
    }
    else if(info.item.cardType == 'objective')
    {
        info.item.icon = 'flag';
        let avatar = "<span class='avatar rounded-full size-xs ml-1 " + (info.item.uavatar ? 'primary' : 'bg-lighter text-canvas') + "' title='" + info.item.assignedTo + "'>" + (info.item.uavatar ? info.item.uavatar : "<i class='icon icon-person'></i>");

        info.item.footer = {html: "<div class='flex items-center'><span class='text-sm'>" + info.item.end + "</span><div class='flex-1 flex justify-end'><span class='status-" + info.item.status + "'>" + info.item.statusLabel + "</span>" + avatar + "</div></div>"};
    }
    else if(info.item.cardType == 'common')
    {
        if(privs.canViewCard)
        {
            info.item.titleUrl   = $.createLink('pi', 'viewCard', 'id=' + info.item.name);
            info.item.titleAttrs = {'data-toggle': 'modal', 'data-size': 'lg', 'className': 'card-title line-clamp-1', 'title' : info.item.title};
        }

        let avatar = "<span class='avatar rounded-full size-xs ml-1 " + (info.item.uavatar ? 'primary' : 'bg-lighter text-canvas') + "' title='" + info.item.assignedTo + "'>" + (info.item.uavatar ? info.item.uavatar : "<i class='icon icon-person'></i>");
        info.item.footer = {html: "<div class='flex items-center'><span class='pri-" + info.item.pri + "'>" + info.item.pri + "</span><span class='text-sm ml-2 mr-1'>" + estimateLang + "</span><span class='text-sm'>" + parseFloat(info.item.estimate) + hourUnit +"</span><div class='flex-1 flex justify-end'><span class='status-" + info.item.status + "'>" + info.item.statusLabel + "</span>" + avatar + "</div></div>" + '<div class="flex"><div class="circle progress mt-3" style="width:80%"><div class="progress-bar" style="width: ' + info.item.progress + '%"></div></div><div class="mt-2 ml-2">' + info.item.progress + '%' + '</div></div>'};
    }

}

/* 拼接风险卡片的操作按钮。 */
window.buildRiskActions = function(risk)
{
    let actions = [];

    if(privs.canEditRisk) actions.push({icon : 'edit', text : riskLang.edit, url : $.createLink('risk', 'edit', "riskID=" + risk.name + '&from=pi&colID=' + risk.col), 'data-toggle' : 'modal', 'data-size' : 'lg'});
    if(privs.canCloseRisk && risk.status != 'closed')    actions.push({icon : 'off',   text : riskLang.close + riskLang.common,    url : $.createLink('risk', 'close', "riskID=" + risk.name + '&colID=' + risk.col),    'data-toggle'  : 'modal', 'data-size' : 'lg'});
    if(privs.canActivateRisk && risk.status != 'active') actions.push({icon : 'magic', text : riskLang.activate + riskLang.common, url : $.createLink('risk', 'activate', "riskID=" + risk.name + '&colID=' + risk.col), 'data-toggle'  : 'modal', 'data-size' : 'lg'});
    if(privs.canDeleteRisk) actions.push({icon : 'trash', text : riskLang.delete + riskLang.common, url : $.createLink('risk', 'delete', "riskID=" + risk.name + '&laneID=' + risk.lane + '&colID=' + risk.col), 'data-confirm' : riskLang.confirmDelete, 'innerClass' : 'ajax-submit'});

    return actions;
}

window.buildCardActions = function(card)
{
    let actions = [];

    if(privs.canEditCard) actions.push({text: editCard, icon: 'edit', url: $.createLink('pi', 'editCard', 'id=' + card.name), 'data-toggle': 'modal'});
    if(privs.canFinishCard && card.status != 'done') actions.push({text: finishCard,   icon: 'checked', url: $.createLink('pi', 'finishCard', 'id=' + card.name), innerClass: 'ajax-submit'});
    if(privs.canActivateCard && (card.status == 'done' || card.status == 'closed')) actions.push({text: activateCard, icon: 'magic', url: $.createLink('pi', 'activateCard', 'id=' + card.name), 'data-toggle': 'modal'});
    if(privs.canDeleteCard) actions.push({text: deleteCard, icon: 'trash', url: $.createLink('pi', 'deleteCard', 'id=' + card.name + '&laneID=' + card.lane + '&columnID=' + card.col), 'data-confirm': confirmDeleteCard, innerClass: 'ajax-submit'});

    return actions;
}

// 监听产能的双击事件，双击后将内容变化输入框。
$(document).off('click', '.capacity').on('click', '.capacity', function()
{
    if(!$(this).find('[name=capacity]').length && privs.canSetCapacity)
    {
        const capacity = $(this).text().replace(hourUnit, '');
        $(this).html('<input type="number" style="width:50px;text-align:center" min="0" name="capacity" value="' + capacity + '" />');
    }
});

$(document).off('change', '[name=capacity]').on('change', '[name=capacity]', function()
{
    // 限制输入的最大长度为8位。
    if($(this).val().length > 8) $(this).val($(this).val().substr(0, 8));
    if($(this).val() < 0 || !$(this).val()) $(this).val(0);

    const url  = $.createLink('pi', 'setCapacity', 'columnID=' + $(this).closest('.capacity').data('column'));
    const form = new FormData();
    form.append('capacity', $(this).val());
    if(privs.canSetCapacity) $.ajaxSubmit({url, data:form});

    const workhour   = $(this).closest('.flex').find('.workhour').text().replace(hourUnit, '');
    const workload   = $(this).val() > 0 ? (workhour / $(this).val() * 100).toFixed(): 0;
    const extraClass = workload > 100 ? 'text-danger' : 'text-success';

    $(this).closest('.flex').find('.workload').attr('class', 'workload ' + extraClass).text(workload + '%');
    $(this).parent().html(parseFloat($(this).val()) + hourUnit);
});

$(document).off('click', '.icon-chevron-double-down,.icon-chevron-double-up').on('click', '.icon-chevron-double-down,.icon-chevron-double-up', function()
{
    $(this).closest('.requirement').find('.content').toggleClass('hidden');
    $(this).toggleClass('icon-chevron-double-down icon-chevron-double-up');
});

window.onDropNewItem = function(info)
{
    const id  = info.drag.element.id;
    const url = $.createLink('pi', 'ajaxLinkStory', 'piID=' + piID + '&laneID=' + info.drop.lane + '&columnID=' + info.drop.col + '&storyID=' + id);

    $.getJSON(url, function(data)
    {
        window[data.name].apply(null, data.params);
    });

    $(`.card-list.story-${id}`).remove();

    return true;
}

window.initedKanban = function()
{
    if($('.kanban-lane-col .kanban-col-content').length == 0) return;

    $('.kanban-lane-col .kanban-col-content').each(function()
    {
        const $this    = $(this);
        const $laneCol = $this.closest('.kanban-lane-col');
        const colIndex = $laneCol.index();
        const $kanban  = $this.closest('.kanban');
        const $col     = $kanban.find('.kanban-header-cols .kanban-header-col').eq(colIndex);
        if($col.find('.kanban-col-content') > 0) return;

        $this.addClass('w-full');
        $col.append($(this));
    });
}
