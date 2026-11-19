/* 自定义单元格渲染函数 */
window.onRenderCell = function(result, {row, col})
{
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
        if(!['product', 'productplan'].includes(moduleKey))
        {
            props = "data-toggle='modal' data-size='lg'";
        }

        result[0] = {
            html: `<a href="${link}" class="text-gray" ${props}>${moduleName}#${objectID}</a>`
        };
    }

    if(col.name == 'status')
    {
        const status = row.data.status;
        result[0] = {html: `<span class='status-${status}'>` + statusList[status] + "</span>"};
    }

    return result;
};
