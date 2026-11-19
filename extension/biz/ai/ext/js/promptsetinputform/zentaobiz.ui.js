$(document).ready(function()
{
    initData();
    watchFieldTypeChange();
    fieldItemActions();
    fieldOptionActions();
    fieldOptionsChange();
    fieldModalSave();
    actionSave();
});

/* 表单数据管理 */
const FieldManager = {
    state: {
        fields: [],
        fieldsMap: {},
    },

    setFields(fields)
    {
        this.state.fields = [];

        fields.forEach(field => {
            this.state.fields.push(field.id);
            this.state.fieldsMap[field.id] = field;
        });

        renderList();
    },

    setFieldIds(fieldIds)
    {
        this.state.fields = fieldIds;

        renderList();
    },

    addField(field, afterId = null)
    {
        /* 生成 ID */
        const id = Date.now();
        field.id = id;

        const index = afterId ? this.state.fields.indexOf(afterId) : -1;

        if(index === -1)
        {
            this.state.fields.push(id);
        }
        else
        {
            this.state.fields.splice(index + 1, 0, id);
        }

        this.state.fieldsMap[id] = field;

        renderList();
    },

    updateField(field)
    {
        this.state.fieldsMap[field.id] = field;

        renderList();
    },

    removeField(fieldId)
    {
        const index = this.state.fields.indexOf(fieldId);
        if(index > -1)
        {
            this.state.fields.splice(index, 1);
            delete this.state.fieldsMap[fieldId];

            renderList();
        }
    },

    getField(id)
    {
        return this.state.fieldsMap[id];
    },

    getFields()
    {
        return this.state.fields.map(id => this.state.fieldsMap[id]);
    },
};

/* Modal 数据管理 */
const ModalManager = {
    state: {
        action: '',
        id: '',
        type: '',
        options: [],
    },

    setAction(action)
    {
        this.state.action = action;
    },

    getAction()
    {
        return this.state.action;
    },

    setId(id)
    {
        this.state.id = id;
    },

    getId()
    {
        return this.state.id;
    },

    setType(type)
    {
        this.state.type = type;

        renderOptions();
    },

    getType()
    {
        return this.state.type;
    },

    setOptions(options, render = true)
    {
        this.state.options = options;

        if(render) renderOptions();
    },

    getOptions()
    {
        return this.state.options;
    },

    setState(state)
    {
        this.state = state;

        renderOptions();
    },

    getState()
    {
        return this.state;
    },
};

/* 数据初始化 */
function initData()
{
    let fields = [];

    if(currentFields && currentFields.length > 0)
    {
        fields = currentFields.map(field => ({
            ...field,
            options: field.options ? field.options.split(',') : [],
        }));
    }

    FieldManager.setFields(fields);
}

/* 渲染列表 */
function renderList()
{
    const fields = FieldManager.getFields();

    renderFieldList(fields);
}

/* 渲染字段列表占位符 */
function renderFieldListPlaceholder()
{
    return `
        <div class="field-empty" id="add-field">
            <div class="action text-primary">
                <i class="icon icon-plus"></i>
                <span>${fieldAdd}</span>
            </div>
            <div class="tips">${fieldAddTip}</div>
        </div>
    `;
}

/* 渲染表单项 */
function renderFormField(field)
{
    let fieldHtml = '';

    switch(field.type)
    {
        case 'text':
            fieldHtml = `
                <input type="text"
                    class="form-control"
                    name="${field.name}"
                    placeholder="${field.placeholder || fieldPlaceholder}"
                    ${field.required === '1' ? 'required' : ''}>
            `;
            break;
        case 'textarea':
            fieldHtml = `
                <textarea
                    class="form-control"
                    name="${field.name}"
                    placeholder="${field.placeholder || fieldPlaceholder}"
                    rows="3"
                    ${field.required === '1' ? 'required' : ''}></textarea>
            `;
            break;
        case 'radio':
        case 'checkbox':
            if(field.options && field.options.length > 0)
            {
                const options = {
                    items: field.options.map(item => ({
                        text: item,
                        value: item,
                    })),
                    name: field.name,
                    limitValueInList: false,
                    multiple: field.type === 'checkbox',
                    required: field.required === '1',
                };

                const pickerOptions  = JSON.stringify(options).replace(/"/g, '&quot;');
                const dataAttributes = [
                    `zui-create="picker"`,
                    `zui-create-picker="${pickerOptions}"`,
                ].join(' ');

                fieldHtml = `
                    <div
                        class="input-group-control"
                        ${dataAttributes}>
                    </div>
                `;
            }
            break;
        default:
            return '';
    }

    return fieldHtml;
}

/* 转义 HTML。 */
function escapeHtml(value)
{
    return $('<div>').text(value || '').html();
}

/* 渲染字段项 */
function renderFieldItem(field)
{
    const fieldName = escapeHtml(field.name);

    return `
        <li class="field-item" data-id="${field.id}">
            <div class="name text-ellipsis" title="${fieldName}">${fieldName}<span class="asterisk">${field.required === 1 ? '*' : ''}</span></div>
            ${renderFormField(field)}
            <i class="icon icon-move"></i>
            <button class="btn size-sm square" data-action="add">
                <i class="icon icon-plus"></i>
            </button>
            <button class="btn size-sm square" data-action="edit">
                <i class="icon icon-edit"></i>
            </button>
            <button class="btn size-sm square" data-action="delete">
                <i class="icon icon-trash"></i>
            </button>
        </li>
    `;
}

/* 渲染字段列表 */
function renderFieldList(fields)
{
    const fieldList = $('#field-list');
    fieldList.empty();

    let html = '';
    if(fields.length === 0)
    {
        html = renderFieldListPlaceholder();
    }
    else
    {
        fields.forEach(field => {
            html += renderFieldItem(field);
        });
    }

    fieldList.html(html);

    /* 初始化拖动排序 */
    fieldListSortable();
}

/* 字段列表拖动排序 */
function fieldListSortable()
{
    if($('#field-list').data('sortable-initialized')) return;

    new zui.Sortable('#field-list', {
        handle: '.icon-move',
        animation: 150,
        ghostClass: 'bg-primary-pale',
        onSort: function(event)
        {
            const newOrder = [];
            $('#field-list .field-item').each(function()
            {
                const fieldId = $(this).data('id');
                newOrder.push(fieldId);
            });

            FieldManager.setFieldIds(newOrder);
        }
    });

    $('#field-list').data('sortable-initialized', true);
}

/* 渲染选项 */
function renderOption(option, index)
{
    const disabledAttr = index === 0 ? 'disabled' : '';

    return `
        <div class="input-group" data-index="${index}">
            <span class="input-group-addon">${fieldOption}${index + 1}</span>
            <div class="input-control">
                <input class="form-control" type="text" placeholder="${pleaseInput}" value="${option}" />
            </div>
            <button type="button" data-action="add" class="btn square input-group-addon">
                <i class="icon icon-plus"></i>
            </button>
            <button type="button" data-action="delete" class="btn square input-group-addon" ${disabledAttr}>
                <i class="icon icon-minus"></i>
            </button>
        </div>
    `;
}

/* 渲染选项列表 */
function renderOptions()
{
    const type    = ModalManager.getType();
    const options = ModalManager.getOptions() || [];

    if(!['radio', 'checkbox'].includes(type))
    {
        $('#field-placeholder').removeClass('hidden');
        $('#field-options').addClass('hidden');

        return;
    }

    const optionsList = $('#field-options');
    optionsList.empty();

    let html = '';
    options.forEach((option, index) => {
        html += renderOption(option, index);
    });

    optionsList.html(html);

    $('#field-placeholder').addClass('hidden');
    $('#field-options').removeClass('hidden');
}

/* 监听字段类型变化 */
function watchFieldTypeChange()
{
    $('#field-modal select[name="field-type"]').on('change', function()
    {
        const type = $(this).val();

        if(['radio', 'checkbox'].includes(type))
        {
            let options = ModalManager.getOptions();
            if(!options || options.length === 0) options = ['', '', ''];

            ModalManager.setOptions(options, false);
        }

        ModalManager.setType(type);
    });
}

/* 打开 Modal（添加/编辑字段） */
function openModal(action, fieldId)
{
    $('#field-modal .modal-header span').text(action === 'add' ? fieldAdd : fieldEdit);

    const field = FieldManager.getField(fieldId);
    const type = action === 'add' ? 'text' : field.type;
    let options = action === 'add' ? ['', '', ''] : field.options;
    if(['radio', 'checkbox'].includes(type) && (!options || options.length === 0)) options = ['', '', ''];

    ModalManager.setState({
        action,
        id: fieldId,
        type,
        options,
    });

    $('#field-modal input[name="field-name"]').val(action === 'add' ? '' : field.name);
    $('#field-modal select[name="field-type"]').val(type);
    $('#field-modal input[name="field-placeholder"]').val(action === 'add' ? '' : field.placeholder);
    $('#field-modal input[name="field-required"]').val(action === 'add' ? '1' : String(field.required));

    zui.Modal.open({
        id: 'field-modal',
    });
}

/* 确认并删除字段 */
function confirmToDeleteField(fieldId)
{
    zui.Modal.confirm(deleteTip).then(confirmed => {
        if(confirmed) FieldManager.removeField(fieldId);
    });
}

/* 字段列表操作 */
function fieldItemActions()
{
    $('#field-list')
        .on('click', 'button', function(event)
        {
            event.preventDefault();

            const action  = $(this).data('action');
            const fieldId = $(this).closest('.field-item').data('id');

            switch(action)
            {
                case 'add':
                    openModal('add', fieldId);
                    break;
                case 'edit':
                    openModal('edit', fieldId);
                    break;
                case 'delete':
                    confirmToDeleteField(fieldId);
                    break;
                default:
            }
        })
        .on('click', '#add-field', function(event)
        {
            event.preventDefault();

            openModal('add', null);
        });
}

/* 字段选项操作 */
function fieldOptionActions()
{
    $('#field-options').on('click', 'button', function()
    {
        const action = $(this).data('action');
        const index = $(this).closest('.input-group').data('index');

        const options = ModalManager.getOptions();

        if(action === 'add') options.splice(parseInt(index, 10) + 1, 0, '');
        else options.splice(parseInt(index, 10), 1);

        ModalManager.setOptions(options);
    });
}

/* 字段选项变化 */
function fieldOptionsChange()
{
    $('#field-options').on('change', 'input', function()
    {
        const options = ModalManager.getOptions();
        const value   = $(this).val();
        const index   = $(this).closest('.input-group').data('index');

        options[parseInt(index, 10)] = value;

        ModalManager.setOptions(options, false);
    });
}

/* field Modal 数据验证 */
function validateFieldData(id, name, type, options)
{
    /* 1. name 不能为空 */
    if(!name.trim())
    {
        zui.Messager.show({
            content: emptyWarning.replace('%s', fieldName),
            type: 'danger',
        });

        return false;
    }

    const fields = FieldManager.getFields();

    /* 2. name 不能重复 */
    if(fields.some(field => field.id !== id && field.name === name))
    {
        zui.Messager.show({
            content: duplicatedWarning.replace('%s', fieldName),
            type: 'danger',
        });

        return false;
    }

    /* 3. options 不能为空 */
    if(['radio', 'checkbox'].includes(type) && options.length === 0)
    {
        zui.Messager.show({
            content: emptyOptionWarning,
            type: 'danger',
        });

        return false;
    }

    return true;
}

/* field Modal 保存 */
function fieldModalSave()
{
    $('#field-modal-save').on('click', function()
    {
        const fieldState = ModalManager.getState();
        const name = $('#field-modal input[name="field-name"]').val().trim();
        const placeholder = $('#field-modal input[name="field-placeholder"]').val();
        const required = parseInt($('#field-modal input[name="field-required"]:checked').val() || '1', 10);

        const type = fieldState.type;
        let options = [];
        if(['radio', 'checkbox'].includes(type)) options = fieldState.options.filter(option => option.trim());

        const id = fieldState.action === 'add' ? null : fieldState.id;
        const valid = validateFieldData(id, name, type, options);
        if(!valid) return;

        const field = {
            id,
            name,
            type,
            required,
        };
        if(['radio', 'checkbox'].includes(type)) field.options = options;
        else field.placeholder = placeholder;

        if(fieldState.action === 'add') FieldManager.addField(field, fieldState.id);
        else FieldManager.updateField(field);

        zui.Modal.hide('#field-modal');
    });
}

/* 获取字段数据 */
function getFieldsData()
{
    const fields = FieldManager.getFields();

    return fields.map(field => {
        const { name, type, required, placeholder, options } = field;
        const fieldData = {
            name,
            type,
            required: required ? '1' : '0',
            appID: promptID,
        };

        if(['text', 'textarea'].includes(type))
        {
            fieldData.placeholder = placeholder || '';
        }
        else if(['radio', 'checkbox'].includes(type))
        {
            fieldData.options = options ? options.join(',') : '';
        }

        return fieldData;
    });
}

/* 发送页面数据 */
function postData(data)
{
    $.ajax({
        url: $.createLink('ai', 'promptSetInputForm', `promptID=${promptID}`),
        type: 'POST',
        data: JSON.stringify(data),
        processData: false,
        contentType: 'application/json; charset=UTF-8',
        dataType: 'json',
    })
        .done(function(response) {
            const message = response.msg || response.message;
            if(response.result === 'success')
            {
                if(message)
                {
                    zui.Messager.show({
                        content: message,
                        type: 'success',
                    });
                }

                if(response.locate) openUrl(response.locate);
            }
            else if(message)
            {
                zui.Messager.show({
                    content: message,
                    type: 'danger',
                });
            }
        })
        .fail(function(xhr, status, error) {
            zui.Messager.show({
                content: saveFailed + ':' + error,
                type: 'danger',
            });
        });
}

/* 保存页面数据 */
function saveData()
{
    const fields = getFieldsData();

    postData({
        fields,
        jumpToNext: 1,
    });
}

/* 保存 */
function actionSave()
{
    $('#btn-save').on('click', function() {
        saveData();
    });
}
