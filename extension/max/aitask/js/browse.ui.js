window.onRenderCell = function(result, {row, col})
{
    if(col.name == 'name')
    {
        const name = row.data.name || '';
        if(result[0] && result[0].props) result[0].props.title = name;
    }

    if(col.name == 'objectType')
    {
        let objectType = row.data.objectType;
        const objectID  = row.data.objectID;
        if(!objectType)
        {
            result[0] = {html: '<span class="text-gray">-</span>'};
            return result;
        }

        if(objectType == 'plan') objectType = 'productplan';

        const moduleKey = moduleNameMap[objectType] || objectType;
        const moduleName = modules[moduleKey] || objectType;

        if(!objectID)
        {
            result[0] = {html: `<span class="text-gray">${moduleName}</span>`};
            return result;
        }

        const linkModule = moduleKey == 'case' ? 'testcase' : moduleKey;
        const link = $.createLink(linkModule, 'view', `id=${objectID}`);

        let props = '';
        if(!['product', 'project', 'productplan'].includes(objectType)) props = "data-toggle='modal' data-size='lg'";
        result[0] = {html: `<a href="${link}" class="text-gray" ${props}>${moduleName}#${objectID}</a>`};
    }

    if(col.name == 'status')
    {
        const status = row.data.status;
        result[0] = {html: `<span class='status-${status}'>` + statusList[status] + "</span>"};
    }

    if(col.name == 'type') result[0] = {html: `<div title=${row.data.type}>${row.data.type}</div>`};

    return result;
};

window.toggleInvolved = function(event)
{
    const involved = $(event).is(':checked') ? 1 : 0;
    $.cookie.set('involved', involved, {expires:config.cookieLife, path:config.webRoot});
    const url = currentUrl.replace(/{involved}/, involved);
    isInModal ? loadModal(url) : loadPage(url);
};
