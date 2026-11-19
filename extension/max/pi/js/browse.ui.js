window.renderCell = function(result, info)
{
    const data = info.row.data;
    if(data.type == 'art' && info.col.name == 'name')
    {
        const html = `<span class='label gray-pale rounded-xl clip'>${ARTText}</span> `;
        if(result[0].hasOwnProperty('props') && result[0].props.hasOwnProperty('href')) result[0].props.href = $.createLink('art', 'view', `id=${data.rawID}`);
        result.push({html});
    }

    return result;
}
