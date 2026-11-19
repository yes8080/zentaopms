let nodes = '';
window.objectType  = ruleObjectType;
window.action      = ruleAction;
window.clickSubmit = function()
{
    nodes = $('[name=nodes]').val();
    nodes = JSON.parse(nodes);

    if(!nodes[0].data)
    {
        zui.Modal.alert(errorLang['noPreActions']);
        return false;
    }

    let hasCondition = false;
    let hasAction    = false;
    for(index in nodes[1]['data'])
    {
        let condition = nodes[1]['data'][index]['condition'];
        let actions   = nodes[1]['data'][index]['actions'];

        if(Object.keys(condition.data).length > 0) hasCondition = true;
        if(Object.keys(actions.data[0].data).length > 0 || actions.data[0]?.method == 'delete') hasAction = true;
    }

    if(!hasCondition || !hasAction)
    {
        zui.Modal.alert(errorLang['noCompleteRule']);
        return false;
    }

    if(!checkConsistency(nodes))
    {
        zui.Modal.alert(errorLang['notConsistency']);
        return false;
    }
}

window.genID = function()
{
    return Math.random().toString(36).substr(2);
}

window.clickConditionNode = function(event)
{
    var $pa = $(event.target).closest('.editor-node').parent().closest('.editor-node');
    var id  = $pa.data('id');
    getNode(id, function(index, father, index2, grandpa)
    {
        if(index == 'default') return;

        var selectedFather = father.branches;
        var node  = selectedFather[index];
        node.type = 'conditions';

        $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update', 'node': JSON.stringify(node)}, function(data)
        {
            $('#modal').html($(data).find('#modal').html()).zuiInit();
            zui.Modal.open({id: 'modal'});
        });
    });
}

window.clickNode = function(event)
{
    const $pa  = $(event.target).closest('.editor-node');
    const id   = $pa.data('id');
    const size = id == 'when' ? 'sm' : '';

    if((!window.objectType || !window.action) && id != 'when')
    {
        zui.Modal.alert(errorLang.noPreActions);
        return; // 没有设置对象类型和动作时，不能编辑条件和执行动作
    }

    getNode(id, function(index, father, index2, grandpa)
    {
        $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update', 'nodeID': id}, function(data)
        {
            $('#editor').html($(data).find('#editor').html()).zuiInit();
            $('#modal').html($(data).find('#modal').html()).zuiInit();
            zui.Modal.open({id: 'modal', size: size});

            if(id.indexOf('action_') == 0)
            {
                let currentNode = $('[name=currentNode]').val();
                currentNode = JSON.parse(currentNode);

                if(currentNode?.method == 'create')
                {
                    let options = {method: 'post', data: {fields: JSON.stringify(currentNode.data)}};
                    loadObjectForm({target: {value: currentNode.module}}, options);
                }
                else if(currentNode?.method == 'edit')
                {
                    let options = {method: 'post', data: {relation: currentNode.relation, module: currentNode.module, fields: JSON.stringify(currentNode.data)}};
                    loadObjectEditForm(options);
                }
                else if(currentNode?.method == 'delete')
                {
                    let options = {method: 'post', data: {relation: currentNode.relation, module: currentNode.module, fields: JSON.stringify(currentNode.data)}};
                    loadObjectDeleteForm(options);
                }
                else if(currentNode?.method == 'notify')
                {
                    let options = {method: 'post', data: {fields: JSON.stringify(currentNode.data)}};
                    loadObjectNotifyForm(options);
                }
            }
        });
    });
}

window.getNode = function(nodeID, callback)
{
    nodes = $('[name=nodes]').val();
    nodes = JSON.parse(nodes);
    return findFromNodes(nodeID, nodes, callback);
}

window.findFromNodes = function(nodeID, nodes, callback, parentIndex)
{
    for(let index in nodes)
    {
        let node = nodes[index];
        let matchNode = [];
        if(node.id == nodeID)
        {
            callback(index, nodes, parentIndex);
            return [index];
        }

        if(typeof(node) == 'array' || typeof(node) == 'object')
        {
             matchNode = findFromNodes(nodeID, node, callback, index);
             if(matchNode.length > 0) return matchNode;
        }

        if(typeof(node.data) == 'array' || typeof(node.data) == 'object')
        {
             matchNode = findFromNodes(nodeID, node.data, callback, index);
             if(matchNode.length > 0) return matchNode;
        }
    }

   return [];
}

window.deleteNode = function(event)
{
    var id = $(event.target).closest('.editor-node').data('id');
    getNode(id, function(index, father, parentIndex)
    {
        if(id.indexOf('action_') == 0)
        {
            if(father.length == 1) return;
            father.splice(index, 1)

            $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update'}, function(data)
            {
                $('#editor').html($(data).find('#editor').html()).zuiInit();
            });
        }
        else if(id.indexOf('condition_') == 0)
        {
            if(nodes[1]['data'].length == 1) return;

            zui.Modal.confirm(noticeLang['delCondition']).then((res) => {
                if(res)
                {
                    nodes[1]['data'].splice(parentIndex, 1);
                    $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update'}, function(data)
                    {
                        $('#editor').html($(data).find('#editor').html()).zuiInit();
                    });
                }
            });
        }
    })
};

window.addCondition = function(event)
{
    const id = $(event.target).closest('.editor-node').data('id');
    getNode(id, function()
    {
        defaultCondition['condition']['id'] = 'condition_' + genID();
        nodes[1]['data'].push(defaultCondition);

        $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update'}, function(data)
        {
            $('#editor').html($(data).find('#editor').html()).zuiInit();
        });
    });
}

window.addAction = function(event)
{
    const id = $(event.target).closest('.editor-node').data('id');
    getNode(id, function(index, father)
    {
        if(id.indexOf('condition_') == 0)
        {
            father['actions']['data'].unshift(defaultAction);
        }
        else if(id.indexOf('action_') == 0)
        {
            let sliceIndex = parseInt(index) + 1;
            father.splice(sliceIndex, 0, defaultAction);
        }

        $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update'}, function(data)
        {
            $('#editor').html($(data).find('#editor').html()).zuiInit();
        });
    });
}

window.savewhen = function(event)
{
    const $form      = $(event.target).closest('form');
    const objectType = $form.find('[name=objectType]').val();
    const action     = $form.find('[name=action]').val();

    let message = [];
    if(objectType == '') message.push(errorLang['emptyObjectType']);
    if(action     == '') message.push(errorLang['emptyAction']);
    if(message.length > 0)
    {
        zui.Modal.alert({message: message.join('\n')});
        return;
    }

    $.post(link, {'nodes': $('[name=nodes]').val(), 'objectType': objectType, 'action': action, 'type': 'savewhen'}, function(data)
    {
        $('body').data('zui.Modal').hide();
        $('#editor').html($(data).find('#editor').html()).zuiInit();

        /* Show warning when change objectType or action. */
        if(ruleObjectType == objectType) return;

        window.objectType = objectType;
        window.action     = action;

        $('.editor-node .editor-node-container').each(function()
        {
            let $this = $(this);
            let $node = $this.closest('.editor-node');
            $node.removeClass('wait');
            if($node.hasClass('when')) return;

            $node.addClass('wait').addClass('has-error');
        });
    });
}

window.savecondition = function(event)
{
    const id       = $(event.target).closest('button').data('id');
    const formData = new FormData($(event.target).closest('form').eq(0)[0]);
    getNode(id, function(index1, father, index2)
    {
        var conditions = {};
        for(var d of formData)
        {
            if(d[0] == 'noCondition')
            {
                conditions[1] = {};
                conditions[1]['noCondition'] = true;
                break;
            }

            var index = parseInt(d[0].match(/\d+/)[0]);
            var type  = d[0].match(/[a-zA-Z]+/)[0];

            if(index == 1 && type == 'conditionLogical') continue;

            conditions[index] = conditions[index] || {};
            conditions[index][type] = d[1];
        }

        var message = checkConditions(conditions);
        if(message)
        {
            zui.Modal.alert({content:message, close: false});
            return;
        }

        father.condition.data           = conditions;
        father.condition.fromObjectType = objectType;

        $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update'}, function(data)
        {
            $('body').data('zui.Modal').hide();
            $('#editor').html($(data).find('#editor').html()).zuiInit();
        });
    })
}

window.saveaction = function(event)
{
    const id     = $(event.target).closest('button').data('id');
    const method = $('[name=method]:checked').val();

    if(method == 'create')
    {
        let object = $('[name=objectType]').val();
        if(object == '')
        {
            zui.Modal.alert(errorLang['emptyObjectType']);
            return false;
        }
    }
    else if(method == 'edit' || method == 'delete')
    {
        let relation = $('[name=relation]').val();
        let object   = $('[name=module]').val();
        if(!relation || !object)
        {
            zui.Modal.alert(errorLang['emptyModuleOrRelation']);
            return false;
        }
    }

    getNode(id, function(index1, father, index2)
    {
        var actions = {};
        if(method == 'create')
        {
            let object = $('[name=objectType]').val();
            actions    = getCreateForm();

            var message = checkActions(actions);
            if(message)
            {
                zui.Modal.alert(message);
                return;
            }

            nodes = updateActionData(nodes, id, actions, object, method);
        }
        else if(method == 'edit')
        {
            let relation = $('[name=relation]').val();
            let object   = $('[name=module]').val();
            actions      = getEditForm();

            var message = checkEditActions(actions);
            if(message)
            {
                zui.Modal.alert(message);
                return;
            }

            nodes = updateActionData(nodes, id, actions, object, method, relation);
        }
        else if(method == 'delete')
        {
            let object   = $('[name=module]').val();
            let relation = $('[name=relation]').val();
            nodes = updateActionData(nodes, id, {}, object, method, relation);
        }
        else if(method == 'notify')
        {
            actions = getNotifyForm();
            nodes   = updateActionData(nodes, id, actions, 'notify', 'notify');
        }

        $.post(link, {nodes: JSON.stringify(nodes), 'type': 'update'}, function(data)
        {
            $('body').data('zui.Modal').hide();
            $('#editor').html($(data).find('#editor').html()).zuiInit();
        });
    })
}

window.checkActions = function(actions)
{
    const requiredFields = $('[name=requiredFields]').val().split(',');
    for(var action in actions)
    {
        if(action == 'workflowGroup' && actions['model'] == 'kanban') continue;
        var value = actions[action];

        if(typeof value == 'undefined') continue;

        if(typeof value == 'object') value = value.filter(item => item !== '');

        if(requiredFields.includes(action) && !value)
        {
            return errorLang['requiredFieldEmpty'];
        }

        if(action == 'estimate' && (isNaN(value) || value < 0))
        {
            return errorLang['invalidEstimate'];
        }
    }

    return '';
}

window.checkEditActions = function(actions)
{
    for(var action in actions)
    {
        var value = actions[action];
        if(action == 'estimate' && (isNaN(value) || value < 0))
        {
            return errorLang['invalidEstimate'];
        }
    }

    return '';
}

window.checkConditions = function(conditions)
{
    for(var i in conditions)
    {
        var condition = conditions[i];
        if(condition?.noCondition) continue;
        if(!condition.conditionValue) return noticeLang['needValue'];
    }

    return '';
}

window.renderConditionRowData = function($row, index, row)
{
    // 第一行不显示逻辑运算符控件
    if(index == 0)
    {
        const checked = row?.noCondition ? 'checked' : '';
        $row.find('[data-name=conditionLogical]').html(`<label class="checkbox mt-1"><input type="checkbox" name='noCondition' ${checked}>${noticeLang.noCondition}</label>`);
        if(checked)
        {
            setTimeout(() => $row.find('[name=noCondition]').trigger('change'), 200);
        }
    }

    // ajax获取字段控件
    let field;
    let value;
    if(typeof row !== 'undefined')
    {
        // 条件有数据的情况
        field = row?.conditionField;
        value = row?.conditionValue;
    }
    else
    {
        // 条件无数据的情况
        field = '';
        value = '';
    }

    changeFieldControl($row, index, field, value);
}

window.changeMethod = function(e)
{
    const method = e.target.value;
    const $form  = $(e.target).closest('.form');
    $form.find('.newFormBody').empty();

    const $objectType = $form.find('[name="objectType"]');
    $objectType.closest('.form-group').toggleClass('hidden', method != 'create');
    if($objectType.val()) $objectType.zui('picker').$.setValue('', true);

    if(method == 'notify')
    {
        let nodes      = JSON.parse($('[name=nodes]').val());
        let objectType = nodes[0].data.objectType;
        loadTarget($.createLink('rule', 'ajaxLoadNotifyForm', `fromObjectType=${objectType}`), '.newFormBody');
    }
    else if(method == 'edit')
    {
        loadObjectEditForm();
    }
    else if(method == 'delete')
    {
        loadObjectDeleteForm();
    }
}

window.changeFieldControl = function($row, index, field, value)
{
    const url = $.createLink('approvalflow', 'ajaxGetFieldControl', `field=${field}&module=${objectType}`);
    $.get(url, function(data)
    {
        data = JSON.parse(data);

        $row.find('[data-name=conditionValue]').html(`<div class='controlBox'></div>`);

        const controlBox = $row.find('.controlBox');
        const options    = data.options;
        const control    = data.control;
        const name       = `conditionValue[${index + 1}]`;

        if(control == 'picker')
        {
            new zui.Picker(controlBox, {
                items: options,
                defaultValue: value,
                name: name,
                required: true
            });
        }
        else if(control == 'datePicker')
        {
            const datePicker = new zui.DatePicker(controlBox, {name: name});
            setTimeout(() => datePicker.$.setValue(value), 50);
        }
        else if(control == 'datetimePicker')
        {
            const datetimePicker = new zui.DatetimePicker(controlBox, {name: name});
            setTimeout(() => datetimePicker.$.setValue(value), 50);
        }
        else
        {
            controlBox.html(`<input type='text' class='form-control' name='${name}' value='${value}' required>`);
        }
    });
}

window.changeConditionField = function(event)
{
    const $row = $(event.target).closest('tr');
    const index = $row.data('index');
    const field = $(event.target).val();

    changeFieldControl($row, index, field, '');
}

window.changeObjectType = function(e)
{
    const actionObject = JSON.parse(actionGroup);
    const objectType   = e.target.value;
    const actions      = actionObject[objectType];

    let $actionPicker = $(e.target).closest('.form').find('[name=action]').zui('picker')
    $actionPicker.render({items: actions});
    $actionPicker.$.setValue('');
}

$(document).on('change', '[name=noCondition]', function(e)
{
    const noCondition = $(e.target).prop('checked');
    const table       = $(e.target).closest('table');

    /* 无条件触发时，禁用所有条件控件 */
    if(noCondition)
    {
        table.find('input').not(e.target).prop('disabled', true);
        table.find('[name^="conditionField"]').each(function()
        {
            $(this).zui('picker').render({disabled: true});
        });

        table.find('[name^="conditionOperator"]').each(function()
        {
            $(this).zui('picker').render({disabled: true});
        });

        table.find('[name^="conditionValue"]').each(function()
        {
            if($(this).zui('picker')) $(this).zui('picker').render({disabled: true});
        });

        if(table.find('[name^="conditionLogical"]').length > 0)
        {
            table.find('[name^="conditionLogical"]').each(function()
            {
                $(this).zui('picker').render({disabled: true});
            });
        }
        table.find('.form-batch-btn').prop('disabled', true);
    }
    else
    {
        table.find('input').prop('disabled', false);
        table.find('.form-batch-btn').prop('disabled', false);
        table.find('[name^="conditionField"]').each(function()
        {
            $(this).zui('picker').render({disabled: false});
        });

        table.find('[name^="conditionOperator"]').each(function()
        {
            $(this).zui('picker').render({disabled: false});
        });

        table.find('[name^="conditionValue"]').each(function()
        {
            if($(this).zui('picker')) $(this).zui('picker').render({disabled: false});
        });

        if(table.find('[name^="conditionLogical"]').length > 0)
        {
            table.find('[name^="conditionLogical"]').each(function()
            {
                $(this).zui('picker').render({disabled: false});
            });
        }
        table.find('.form-batch-btn').prop('disabled', false);
    }
});

window.loadObjectForm = function(e, options)
{
    const value = e.target.value;
    const url   = $.createLink('rule', 'ajaxLoadcreateForm', `fromObjectType=${objectType}&toObjectType=${value}`);

    if(!options) options = {};
    loadTarget(url, '.newFormBody', options);
}

window.loadObjectEditForm = function(options)
{
    const url = $.createLink('rule', 'ajaxLoadEditForm', `fromObjectType=${objectType}`);
    if(!options) options = {};
    loadTarget(url, '.newFormBody', options);
}

window.loadObjectDeleteForm = function(options)
{
    const url = $.createLink('rule', 'ajaxLoadDeleteForm', `fromObjectType=${objectType}`);
    if(!options) options = {};
    loadTarget(url, '.newFormBody', options);
}

window.loadObjectNotifyForm = function(options)
{
    const url = $.createLink('rule', 'ajaxLoadNotifyForm', `fromObjectType=${objectType}`);
    if(!options) options = {};
    loadTarget(url, '.newFormBody', options);
}

window.getCreateForm = function()
{
    const fields         = $('[name^=fields]').val();
    const requiredFields = $('[name=requiredFields]').val().split(',');
    let   actions        = {};

    for(var requiredField in requiredFields)
    {
        const field    = requiredFields[requiredField];
        const value    = $(`.newFormBody [name^=${field}]`).val();
        actions[field] = value;
    }

    for(let i in fields)
    {
        const field = fields[i];
        if (!field) continue;

        const element = $(`.newFormBody [name^=${field}]`);
        let value;

        if(element[0] && element[0].type === 'radio')
        {
            value = $(`.newFormBody [name^=${field}]:checked`).val();
        }
        else
        {
            if(typeof element.val() === 'string')
            {
                value = element.val().replace(/\\&quot;/g, '');
            }
            else
            {
                value = element.val();
            }
        }

        actions[field] = value;
    }

    if($(`.newFormBody [name=branch]`).length > 0) actions['branch'] = $(`.newFormBody [name=branch]`).val(); // 分支有可能不存在,且不在fields中

    return actions;
}

window.getEditForm = function()
{
    const actions = {};

    $('.field-group').each(function()
    {
        const field = $(this).find('[name^=fields]').val();
        const value = $(this).find('[name^=values]').val();

        if(!field) return true;

        actions[field] = value;
    });

    return actions;
}

window.getNotifyForm = function()
{
    const actions = {};

    actions.subject = $('.newFormBody [name=subject]').val();
    actions.content = $('.newFormBody [name=content]').val().replace(/\\&quot;/g, '');
    actions.toList  = $('.newFormBody [name^=toList]').val();
    actions.route   = [];
    $('.newFormBody [name^=route]:checked').each(function()
    {
        actions.route.push($(this).val());
    });

    return actions;
}

window.updateActionData = function(nodes, actionId, newData, module, method, relation = '')
{
    nodes.forEach(node =>
    {
        if(node.type === 'conditions' && Array.isArray(node.data))
        {
            node.data.forEach(conditionBlock =>
            {
                const actions = conditionBlock.actions;
                if(actions && actions.type === 'actions' && Array.isArray(actions.data))
                {
                    actions.data.forEach(action =>
                    {
                        if(action.id === actionId)
                        {
                            action.data           = newData;
                            action.module         = module;
                            action.method         = method;
                            action.fromObjectType = objectType;

                            if(relation)
                            {
                                action.relation = relation;
                            }
                            else
                            {
                                delete action.relation;
                            }

                            return nodes;
                        }
                    });
                }
            });
        }
    });

    return nodes;
}

window.checkConsistency = function(nodes)
{
    var consistency = true;
    for(let index in nodes[1]['data'])
    {
        let condition = nodes[1]['data'][index]['condition'];
        let actions   = nodes[1]['data'][index]['actions'];

        if(Object.keys(condition.data).length  == 0) continue;
        if(Object.keys(actions.data[0].data).length  == 0) continue;

        if(condition.fromObjectType != objectType) consistency = false;

        for(let key in actions.data)
        {
            if(actions.data[key].fromObjectType != objectType) consistency = false;
        }

        if(!consistency) break;
    }

    return consistency;
}
