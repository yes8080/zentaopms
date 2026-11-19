function getModuleLang(moduleKey)
{
    if(moduleList && moduleList[moduleKey]) return moduleList[moduleKey];
    return {common: moduleKey};
}

function getCategoryLabel(category)
{
    return getModuleLang(category).common || category;
}

function getModuleLabel(moduleKey)
{
    return getModuleLang(moduleKey).common || moduleKey;
}

function getFieldLabel(moduleKey, field)
{
    return getModuleLang(moduleKey)[field] || field;
}

var selectedInputFields = selectedSources ? selectedSources.filter(Boolean) : [];

function renderFieldList(category)
{
    var categoryDataSources = dataSource && dataSource[category] ? dataSource[category] : {};
    var html = '';

    Object.keys(categoryDataSources).forEach(function(sourceKey)
    {
        var fields = categoryDataSources[sourceKey];
        var groupChecked = fields.length && fields.every(function(field)
        {
            return selectedInputFields.indexOf(sourceKey + '.' + field) >= 0;
        });
        var fieldsHtml = fields.map(function(field)
        {
            var fieldKey = sourceKey + '.' + field;
            var checked  = selectedInputFields.indexOf(fieldKey) >= 0 ? ' checked' : '';
            return '<label class="checkbox field-item"><input type="checkbox" data-prop="' + fieldKey + '"' + checked + '><span>' + getFieldLabel(sourceKey, field) + '</span></label>';
        }).join('');

        html += '<div class="category-group"><div class="category-group-header"><label class="checkbox group-item"><input type="checkbox" data-prop="' + sourceKey + '"' + (groupChecked ? ' checked' : '') + '><span>' + getModuleLabel(sourceKey) + '</span></label></div><div class="category-group-body check-list-inline">' + fieldsHtml + '</div></div>';
    });

    $('.category-groups').attr('data-object-group', category).html(html);
}

function renderSelectedTitle(category)
{
    var titleElement = $('#selected-title-text');
    var format = titleElement.data('format');
    titleElement.text(format.replace('{0}', getCategoryLabel(category)).replace('{1}', selectedInputFields.length));
}

function renderSelectedList()
{
    var listItems = selectedInputFields.map(function(field)
    {
        var parts = field.split('.');
        return '<li class="list-group-item" data-prop="' + field + '"><span>' + getModuleLabel(parts[0]) + ' / ' + getFieldLabel(parts[0], parts[1]) + '</span></li>';
    }).join('');

    $('#selected-data-sorter').html('<ol class="list-group">' + listItems + '</ol>');
}

function syncSelectedSources(prop, checked)
{
    var index = selectedInputFields.indexOf(prop);

    if(checked && index < 0) selectedInputFields.push(prop);
    if(!checked && index >= 0) selectedInputFields.splice(index, 1);

    $('#datasource').val(selectedInputFields.join(','));
    renderSelectedTitle(activeDataSource);
    renderSelectedList();
}

function syncGroupSources(group, checked)
{
    var fields = dataSource[activeDataSource][group] || [];

    fields.forEach(function(field)
    {
        syncSelectedSources(group + '.' + field, checked);
    });

    $('.category-groups input[data-prop^="' + group + '."]').prop('checked', checked);
}

function syncGroupChecked(group)
{
    var fields = dataSource[activeDataSource][group] || [];
    var checked = fields.length && fields.every(function(field)
    {
        return selectedInputFields.indexOf(group + '.' + field) >= 0;
    });

    $('.category-groups input[data-prop="' + group + '"]').prop('checked', checked);
}

function bindFieldSelection()
{
    $('.category-groups').on('change', 'input[type="checkbox"]', function()
    {
        var prop = $(this).data('prop');
        if(prop.indexOf('.') === -1) return syncGroupSources(prop, $(this).prop('checked'));

        syncSelectedSources(prop, $(this).prop('checked'));
        syncGroupChecked(prop.split('.')[0]);
    });
}

window.initPromptSetInputFields = function()
{
    renderFieldList(activeDataSource);
    renderSelectedTitle(activeDataSource);
    renderSelectedList();
    bindFieldSelection();
};
