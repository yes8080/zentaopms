window.renderCell = function(result, info)
{
    if(info.col.name == 'name' && result)
    {   
        const team = info.row.data;
        if(team.type == 'parent')
        {   
            result[0].type = 'text';
        }   
    }

    return result;
}
