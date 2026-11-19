// 切换页面显示模式
$(document)
    .off('click', '.switchButton')
    .on('click', '.switchButton', function () {
        const viewType = $(this).attr('data-type');
        $.cookie.set('aiSkillsViewType', viewType, { expires: config.cookieLife, path: config.webRoot });
        loadCurrentPage();
    });

function changeSkillStatus(action, id)
{
    const disableMethod = typeof currentMethod !== 'undefined' && currentMethod === 'myskill' ? 'disableSkill' : 'disableSquareSkill';
    const methods = {release: 'releaseSkill', publish: 'publishSkill', disable: disableMethod, add: 'addSkill', remove: 'removeSkill'};
    const method  = methods[action];
    if(!method) return;

    let params = `skillID=${id}`;
    const url = $.createLink('ai', method, params);

    $.post(url, function(response) {
        if(response.result === 'success') {
            zui.Messager.show({content: response.message, type: 'success'});
            loadCurrentPage();
        } else {
            zui.Messager.show({content: response.message, type: 'danger'});
        }
    }, 'json');
}

$(document)
    .off('click', '.skill-action-btn')
    .on('click', '.skill-action-btn', function(event) {
        event.preventDefault();
        event.stopPropagation();
        if($(this).hasClass('disabled')) return;

        const action = $(this).data('action');
        const id     = $(this).data('id');
        if(action === 'releaseToSquare') return loadModal($.createLink('ai', 'releaseSkillToSquare', `skillID=${id}`), null, {size: 'sm'});
        if(action === 'remove') {
            return zui.Modal.confirm(confirmRemove).then(function(result) {
                if(result) changeSkillStatus(action, id);
            });
        }
        if(action !== 'disable') return changeSkillStatus(action, id);

        const message = typeof currentMethod !== 'undefined' && currentMethod === 'myskill' ? confirmStop : confirmDisable;
        zui.Modal.confirm(message).then(function(result) {
            if(result) changeSkillStatus(action, id);
        });
    });
