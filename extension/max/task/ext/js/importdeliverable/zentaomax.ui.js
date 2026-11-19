window.clickSubmit = function()
{
    const dtable = zui.DTable.query();
    const checkedList = dtable.$.getChecks();
    if(!checkedList.length) return false;

    const form      = new FormData();
    let checkedInfo = '';
    checkedList.forEach((id) =>
    {
        if(importedList[id]) checkedInfo += '[' + deliverables[id] + '] ';
        form.append('deliverableIdList[]', id);
    });

    if(checkedInfo)
    {
        confirmMessage = repeatImport.replace('%s', checkedInfo);
        zui.Modal.confirm({message: confirmMessage, icon:'icon-exclamation-sign', iconClass: 'warning-pale rounded-full icon-2x'}).then((confirmed) =>
        {
            if(confirmed) postAndLoadPage($.createLink('task', 'batchCreate', 'execution=' + executionID), form);
        })
    }
    else
    {
        postAndLoadPage($.createLink('task', 'batchCreate', 'execution=' + executionID), form);
    }
    return false;
}
