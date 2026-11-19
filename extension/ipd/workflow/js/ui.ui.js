function convertFormDesignerField(field, index, flowModule)
{
    let length = field.dataLength;
    if(field.control === 'decimal' || field.control === 'formula') length = [field.integerDigits || 10, field.decimalDigits || 2].join(',');
    if(!length && (field.dataType === 'varchar' || field.dataType === 'text')) length = 255;
    let expression = field.expression;
    if(expression && typeof expression === 'string') expression = JSON.parse(expression);
    if(Array.isArray(expression)) expression = expression.map(item =>
    {
        if(item.type === 'target' && !item.module) return {...item, module: field.module || field._data?.module || flowModule};
        return item;
    });
    return {
        ...field._data,
        ...(field.id ? {id: field.id} : {}),
        show         : '1',
        field        : field.name,
        name         : field.label,
        control      : field.control,
        readonly     : field.readonly ? 1 : 0,
        defaultValue : field.defaultValue,
        options      : field.datasource === 'custom' ? field.customOptions : field.datasource,
        placeholder  : field.placeholder,
        type         : field.dataType,
        width        : field.width,
        sql          : field.sql || '',
        position     : field.position || 'info',
        group        : field.group || '',
        length       : length ?? 255,
        foldable     : field.foldable   ? 1 : 0,
        wrapBefore   : field.wrapBefore ? 1 : 0,
        wrapAfter    : field.wrapAfter  ? 1 : 0,
        integerDigits: field.integerDigits || 10,
        decimalDigits: field.decimalDigits || 2,
        layoutRules  : field.layoutRules,
        buildin      : field.buildin,
        expression   : expression ? JSON.stringify(expression) : '',
        order        : index + 1,
    };
}

window.getFormDesigner = function()
{
    const formDesigner = $('#formDesigner').zui('formDesigner');
    if(!formDesigner || !formDesigner.$) return null;

    return formDesigner.$;
};

window.getFields = function()
{
    const formDesigner = getFormDesigner();
    if(!formDesigner) return [];

    const fields = formDesigner.fields;
    return fields.map((field, index) => convertFormDesignerField(field, index, formDesigner.props.flowModule));
};

window.saveFields = async function()
{
    const formDesigner = getFormDesigner();
    if(!formDesigner) return true;
    const errors = formDesigner.errors;
    if(errors && Object.keys(errors).length)
    {
        zui.Messager.fail(formDesigner.props.tips.saveFailed);
        return;
    }

    const flowModule = formDesigner.props.flowModule;
    const action = formDesigner.props.flowAction;
    const groupID = formDesigner.props.groupID;
    const url = $.createLink('workflow', 'ui', 'module=' + flowModule + '&action=' + action + '&groupID=' + groupID);
    const fields = getFields();
    fields.forEach((x, index) =>
    {
        delete x.ditto;
        x.order = index + 1;
        if(Array.isArray(x.layoutRules)) x.layoutRules = x.layoutRules.join(',');
    });
    let result = true;
    await $.ajaxSubmit({
        url:  url,
        load: false,
        data: {fields: JSON.stringify(fields)},
        onFail: (result) =>
        {
            if(result.field && typeof result.message === 'object') formDesigner.setFieldErrors(result.field, result.message);
            result = false;
        },
        onSuccess: (result) =>
        {
            if(result && typeof result === 'object' && result.fields)
            {
                const oldFields  = formDesigner.fields;
                const fieldMap = oldFields.reduce((acc, field) =>
                {
                    acc[field.name] = field;
                    return acc;
                }, {});
                const changedFields = [];
                Object.entries(result.fields).forEach(([name, id]) =>
                {
                    const oldField = fieldMap[name];
                    if(oldField && oldField.id !== id)
                    {
                        oldField.id = id;
                        changedFields.push(oldField);
                    }
                });
                if(changedFields.length) formDesigner.updateFields(changedFields);
            }
            formDesigner.fieldsChanged = false;
        }
    });
    return result;
};

window.beforePageLoad = async function(options)
{
    const formDesigner = getFormDesigner();
    if(!formDesigner || !formDesigner.fieldsChanged) return;

    const currentUrlInfo = $.parseLink($.apps.getAppUrl());
    const nextUrlInfo    = $.parseLink(options.url);
    if([currentUrlInfo.moduleName, currentUrlInfo.methodName, Array.isArray(currentUrlInfo.vars[0]) ? currentUrlInfo.vars[0][1] : '', Array.isArray(currentUrlInfo.vars[1]) ? currentUrlInfo.vars[1][1] : ''].join() === [nextUrlInfo.moduleName, nextUrlInfo.methodName, Array.isArray(nextUrlInfo.vars[0]) ? nextUrlInfo.vars[0][1] : '', Array.isArray(nextUrlInfo.vars[1]) ? nextUrlInfo.vars[1][1] : ''].join()) return;

    const confirmedSave = await zui.Modal.confirm({content: formDesigner.props.leavePageTip, actions: [{key: 'confirm', text: formDesigner.props.yesText}, {key: 'cancel', text: formDesigner.props.noText}]});
    if(!confirmedSave) return;

    const saveResult = await saveFields();
    if(!saveResult) return false;
};

window.setFormDesignerOptions = function(_, options)
{
    const processFieldDataSource = (field) =>
    {
        if(!Array.isArray(field.datasource)) return;
        field.datasource = field.datasource.reduce((record, val, index) =>
        {
            record[index] = val;
            return record;
        }, {});
    };
    if(options && Array.isArray(options.innerFields))   options.innerFields.forEach(processFieldDataSource);
    if(options && Array.isArray(options.defaultFields)) options.defaultFields.forEach(processFieldDataSource);
    return options;
};

$(document).on('click', '#confirmRestoreBtn', function()
{
    const formDesigner = getFormDesigner();
    if(!formDesigner) return false;

    const flowModule = formDesigner.props.flowModule;
    const action     = formDesigner.props.flowAction;
    const groupID    = formDesigner.props.groupID;

    window.location.href = $.createLink('workflow', 'ajaxRestoreDefault', 'module=' + flowModule + '&action=' + action + '&groupID=' + groupID);
});
