window.getCellSpan = function(cell)
{
    if(!['stage', 'required'].includes(cell.col.name) && cell.row.data.rowspan)
    {
        return {rowSpan: cell.row.data.rowspan};
    }
}

window.getCheckInfo = function()
{
    const checkedList = this.getChecks();
    const checkedID   = {};
    checkedList.forEach((id) =>
    {
        id = String(id).split('_')[0];
        if(checkedID[id]) return;
        checkedID[id] = true;
    });

    const checkedCount = Object.keys(checkedID).length;
    if(checkedCount) return {html: selectedItems.replace('{0}', checkedCount)};
    return {html: pageSummary};
}

window.onRenderCell = function(result, {row, col})
{
    if(result && col.name == 'actions')
    {
        if(row.data.builtin)
        {
            $.each(result[0].props.items, function(i, item)
            {
                if(!item.disabled) return;
                result[0].props.items[i].hint = builtinConfirm;
            });
        }
    }

    return result;
}

$(document).off('click', '[data-formaction]').on('click', '[data-formaction]', function()
{
    const $this = $(this);
    if($this.attr('class').indexOf('disabled') !== -1) return;

    const dtable = zui.DTable.query($('#deliverableTable'));
    const checkedList = dtable.$.getChecks();
    if(!checkedList.length) return;

    const postData   = new FormData();
    const checkedID  = {};
    const otherIDs   = [];
    checkedList.forEach((id) =>
    {
        id = String(id).split('_')[0];
        if(checkedID[id]) return;
        checkedID[id] = true;

        /* “其他”类型交付物不支持批量操作，自动从本次操作中剔除。 */
        if(deliverableCategory[id] == 'other')
        {
            otherIDs.push(id);
            return;
        }

        postData.append('deliverableIdList[]', id);
    });

    const doBatchAction = function()
    {
        if(!postData.has('deliverableIdList[]')) return;

        /* 批量设置检查环节 */
        if($this.hasClass('batch-check-btn'))
        {
            zui.Modal.open(
            {
                type: 'ajax',
                request:
                {
                    url: $.createLink('deliverable', 'batchCheck', 'groupID=' + groupID),
                    method: 'post',
                    data: postData
                }
            });
            return;
        }

        if($this.data('page') == 'batch')
        {
            postAndLoadPage($this.data('formaction'), postData);
        }
        else
        {
            $.ajaxSubmit({ "url": $this.data('formaction'), "data": postData });
        }
    };

    if(otherIDs.length)
    {
        zui.Modal.alert(otherBatchTip).then(() => { doBatchAction(); });
    }
    else
    {
        doBatchAction();
    }
});
