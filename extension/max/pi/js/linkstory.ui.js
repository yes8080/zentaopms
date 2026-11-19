$(document).off('click', '.batch-btn').on('click', '.batch-btn', function()
{
    const type   = $(this).data('type');
    const dtable = zui.DTable.query($('#linkStoryList'));
    const checkedList = dtable.$.getChecks();
    if(!checkedList.length) return;

    const form = new FormData();
    checkedList.forEach((id) => form.append(type + 'IdList[]', id));

    $.ajaxSubmit({url: $(this).data('url'), data: form});
});

window.renderStoryCell = function(result, info)
{
    if(info.col.name == 'title' && result)
    {
        const story = info.row.data;
        const gradeMap = gradeGroups[story.type] || {};

        let html = '';
        gradeLabel = gradeMap[story.grade] || '';
        if(gradeLabel) html += `<span class='label gray-pale rounded-xl clip'>${gradeLabel.name}</span> `;
        if(html) result.unshift({html});
    }

    return result;
};
