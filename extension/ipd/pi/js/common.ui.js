window.addLine = function()
{
    const index = getMaxIndex() + 1;
    const current = $(this).closest('.input-group').data('index');
    let newLine = $(this).closest('.form-batch-control').clone();
    newLine.find('[name^=execution]').attr('name', 'execution[' + index + ']').attr('id', 'execution[' + index + ']').val('');
    newLine.find('[name^=plan]').attr('name', 'plan[' + index + ']').attr('id', 'plan[' + index + ']').val('');
    newLine.find('#beginPicker' + current).empty().attr('id', 'beginPicker' + index);
    newLine.find('#endPicker' + current).empty().attr('id', 'endPicker' + index);
    newLine.find('.input-group').attr('data-index', index);
    $(this).closest('.form-batch-control').after(newLine);

    let options = $('[name^=begin]').zui('datepicker').options;
    options.defaultValue = '';
    options.name = `begin[${index}]`;
    new zui.DatePicker(`#beginPicker${index}`, options);
    options.name = `end[${index}]`;
    new zui.DatePicker(`#endPicker${index}`, options);

    checkLine();
}

window.removeLine = function(e)
{
    if(config.currentMethod == 'edit')
    {
        checkRemove(this);
    }
    else
    {
        $(e.target).closest('.form-batch-control').remove();
        checkLine();
    }

}

window.checkRemove = function(obj)
{
    piexecution = $(obj).closest('.input-group').find('[name^=plan]').val();
    if(!piexecution) return true;

    if(hasLinkedExecutions.includes(piexecution))
    {
        zui.Modal.alert(cannotRemoveExecution);
        return false;
    }
    else if(linkedExecutionPlans.includes(piexecution))
    {
        zui.Modal.confirm({message: confirmRemoveExecution, onResult: function(result)
        {
            if(result)
            {
                $(obj).closest('.form-batch-control').remove();
                checkLine();
            }
        }});
    }
    else
    {
        $(obj).closest('.form-batch-control').remove();
        checkLine();
    }
}

window.checkLine = function()
{
    $('.removeLine').css('visibility', $('#plansBox .input-group').length == 1 ? 'hidden' : 'visible');
}

window.getMaxIndex = function()
{
    let index = 0;
    $('.form-batch-control').each(function()
    {
        if($(this).find('.input-group').data('index') >= index) index = $(this).find('.input-group').data('index');
    })
    return index;
}

window.updateKanban = function(key, kanbanData, piID)
{
    if(typeof piID != 'undefined' && typeof loadBacklog == 'function') loadBacklog(piID);
    $('.kanban-list').zui('kanbanlist').$.getKanban(key).update(kanbanData);
}

window.deleteLane = function(key, laneID)
{
    $('.kanban-list').zui('kanbanlist').$.getKanban(key).deleteLane(laneID);
}

window.changeCardSize = function(event)
{
    cardsize = $('#cardsize').text();
    $('.card-list').removeClass('cardsize-' + cardsize);

    if($(event.target).closest('.btn').hasClass('minus'))
    {
        cardsize--;
    }
    else
    {
        cardsize++;
    }

    if(cardsize < 1) cardsize = 1;
    if(cardsize > 4) cardsize = 4;

    $('#cardsize').text(cardsize);
    $('.btn.minus').toggleClass('disabled', cardsize == 1);
    $('.btn.plus').toggleClass('disabled', cardsize == 4);

    changeKanbanCardSize();
}

window.changeKanbanCardSize = function()
{
    cardsize = $('#cardsize').text();

    const $kanbanlist = $('.kanban-list');
    $kanbanlist.zui('kanbanlist').render({kanbanProps: {itemCountPerRow: cardsize}});
    $('.card-list').addClass('cardsize-' + cardsize);

    const key      = $kanbanlist.data('type') == 'plan' ? 'planCardSize' : 'teamCardSize';
    const kanbanID = $kanbanlist.data('id');
    $.cookie.set(key, '{"' + kanbanID + '":' + cardsize + '}', {expires:config.cookieLife, path:config.webRoot});
}

window.onDrop = function(changes, dropInfo)
{
    if(!dropInfo) return false;

    item   = dropInfo['drag']['item'];
    column = this.getCol(item.col);
    // 团队规划看板跨行跨列移动需求卡片会有弹窗提示。
    if(item.cardType == 'story' && (item.lane != dropInfo['drop']['lane'] || item.col != dropInfo['drop']['col']) && config.currentMethod == 'team' && column.execution > 0)
    {
        zui.Modal.confirm(confirmMoveStory).then(result =>
        {
            if(result)
            {
                let sortList = '';
                if(dropInfo['drop']['type'] == 'item') for(let i = 0; i < dropInfo['data']['list'].length; i++) sortList += dropInfo['data']['list'][i].replace(/[^0-9]/ig, '') + ',';

                const url = $.createLink('pi', 'moveCard', 'type=' + kanbanType + '&objectID=' + (item.cardID ? item.cardID : item.name) + '&objectType=' + item.cardType + '&sourceLane=' + item.lane + '&sourceColumn=' + item.col + '&targetLane=' + dropInfo['drop']['lane'] + '&targetColumn=' + dropInfo['drop']['col'] + '&sortList=' + sortList);
                if(privs.canMoveCard) $.ajaxSubmit({url});

                this.update(changes);
            }
        });
    }
    else
    {
        let sortList = '';
        if(dropInfo['drop']['type'] == 'item' || item.cardType == 'objective') for(let i = 0; i < dropInfo['data']['list'].length; i++) sortList += dropInfo['data']['list'][i].replace(/[^0-9]/ig, '') + ',';

        item = dropInfo['drag']['item'];
        const url = $.createLink('pi', 'moveCard', 'type=' + kanbanType + '&objectID=' + (item.cardID ? item.cardID : item.name) + '&objectType=' + item.cardType + '&sourceLane=' + item.lane + '&sourceColumn=' + item.col + '&targetLane=' + dropInfo['drop']['lane'] + '&targetColumn=' + dropInfo['drop']['col'] + '&sortList=' + sortList);
        if(privs.canMoveCard) $.ajaxSubmit({url});

        return true;
    }
    return false;
};

window.canDrop = function(dragInfo, dropInfo)
{
    if(!dragInfo) return false;

    const column = this.getCol(dropInfo.col);
    const lane   = this.getLane(dropInfo.lane);
    if(!column || !lane) return false;

    if(dragInfo.hasOwnProperty('type') && dragInfo.type == 'newItem') return column.type == 'story' && lane.type == 'team';

    /* 卡片的排序目前仅支持本单元格内排序 */
    if(dropInfo.type == 'item' && (dropInfo.col != dragInfo.item.col || dropInfo.lane != dragInfo.item.lane)) return false;
    const items = this.data.items[dropInfo.lane][dropInfo.col];

    if(dragInfo['item']['cardType'] == 'story')
    {
        if(column.type == 'story' && dragInfo['item']['lane'] == lane.name)
        {
            if(dragInfo['item']['col'] == column.name) return true;

            for(let i = 0; i < items.length; i++)
            {
                if(items[i].name == dragInfo['item']['name']) return false;
            }
            return true;
        }
        return false;
    }

    if(dragInfo['item']['cardType'] == 'requirement') return column.type == 'story' && lane.type == 'team';
    if(dragInfo['item']['cardType'] == 'objective')   return (column.type == 'yes' || column.type == 'no') && lane.type == 'team' && (dropInfo.lane == dragInfo.item.lane);
    if(dragInfo['item']['cardType'] == 'risk')        return column.type == 'risk' && lane.type == 'team' && (dropInfo.lane == dragInfo.item.lane);
    if(dragInfo['item']['cardType'] == 'milestone')   return lane.type == 'milestone';
    if(dragInfo['item']['cardType'] == 'common')      return lane.type == 'common' || lane.type == 'team';

    return true;
};
