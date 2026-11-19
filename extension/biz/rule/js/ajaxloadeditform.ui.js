$(function()
{
    $('.picker-box').last().on('inited', function(){updateItems();});
});

window.changeRelation = function(e)
{
    const relation = e.target.value;
    const url      = $.createLink('rule', 'ajaxGetModuleByRelation', `fromObjectType=${fromObjectType}&relation=${relation}`);

    if(relation)
    {
        $.getJSON(url, function(data) {
            $('[name="module"]').zui('picker').render({items: data});
            $('[name="module"]').zui('picker').$.setValue('');
        });
    }
    else
    {
        $('[name="module"]').zui('picker').render({items: []});
        $('[name="module"]').zui('picker').$.setValue('');
    }
}

window.changeModule = function(e)
{
    const module = e.target.value;
    if(module)
    {
        const url = $.createLink('rule', 'ajaxGetFieldsByModule', `fromObjectType=${fromObjectType}&module=${module}`);
        $.getJSON(url, function(data) {
            $('.field-group').each(function() {
                $(this).find('[name^="field"]').zui('picker').render({items: data});
            });
        });
    }
    else
    {
        $('.field-group').each(function() {
            $(this).find('[name^="field"]').zui('picker').render({items: []});
            $(this).find('[name^="field"]').zui('picker').$.setValue('');
            $(this).find('.input-group').find('.valueBox').html(`<input type='text' class='form-control' name='values[]' required>`);
        });
    }
}

window.changeField = function(e)
{
    updateItems();

    const field  = e.target.value;
    const module = $(e.target).closest('.newFormBody').find('[name="module"]').val();
    const url    = $.createLink('approvalflow', 'ajaxGetFieldControl', `field=${field}&module=${module}`);
    const $row   = $(e.target).closest('.field-group');

    $.getJSON(url, function(data)
    {
        $row.find('.input-group').find('.valueBox').remove();
        $row.find('.input-group').append(`<div class='valueBox form-group-wrapper'></div>`);

        const valueBox = $row.find('.valueBox');
        const options  = data.options;
        const control  = data.control;
        const name     = 'values[]';

        if(control == 'picker')
        {
            new zui.Picker(valueBox, {
                items: options,
                name: name,
                required: true
            });
        }
        else if(control == 'datePicker')
        {
            new zui.DatePicker(valueBox, {name: name});
        }
        else if(control == 'datetimePicker')
        {
            new zui.DatetimePicker(valueBox, {name: name});
        }
        else
        {
            valueBox.append(`<input type='text' class='form-control' name='${name}' required>`);
            if(!['estimate', 'budget'].includes(field))
            {
                valueBox.append(`<button class="btn copy-field-btn" type="button" id="dropdownToggle${field}"><i class="icon icon-copy"></i></button>`);
                new zui.Dropdown(`#dropdownToggle${field}`, {
                    placement: 'left-start',
                    menu: {
                        className: 'copy-fields-menu',
                        header: dropHeader,
                        items: JSON.parse(fieldItems),
                        onClickItem: copyField
                    }
                });
            }
        }
    });
}

window.addRow = function(e)
{
    const index        = $('.field-group').length + 1;
    const $row         = $(e.target).closest('.field-group').clone();
    const chosenFields = [];

    let options = zui.Picker.query("[name^='fields']").options;
    options = JSON.parse(JSON.stringify(options));

    $("[name^='fields']").each(function()
    {
        chosenFields.push($(this).val());
    })

    /* Disable chosen products. */
    options.items.forEach(function(item)
    {
        if(chosenFields.includes(item.value)) item.disabled = true;
    });

    $row.find('.input-group > :first-child').remove();
    $row.find('.input-group').find('.valueBox').html(`<input type='text' class='form-control' name='values[]' required>`);

    $row.find('.input-group').prepend(`<div id='fields${index}' class='form-group-wrapper picker-box' data-call="changeField(event)" data-on="change"></div>`, false);
    $row.find('.btn-delete').removeClass('invisible');

    $row.find('input').val('');
    $('.newFormBody').append($row);

    options.name         = `fields[]`;
    options.defaultValue = '';
    new zui.Picker(`#fields${index}`, options);
}

window.removeRow = function(e)
{
    if($('.field-group').length == 1) return;
    $(e.target).closest('.field-group').remove();
}

window.copyField = function(e)
{
    const btn     = e.relativeTarget.target;
    const varName = e.key;

    let value = $(btn).closest('.valueBox').find('[name^="values"]').val();
    value += varName;

    $(btn).closest('.valueBox').find('[name^="values"]').val(value);
}

window.updateItems = function()
{
    let chosenFields = [];
    $("[name^='fields']").each(function()
    {
        const field = $(this).val();
        if(field && chosenFields.indexOf(field) == -1) chosenFields.push(field);
    });

    let allItems = zui.Picker.query("[name^='fields']")?.options?.items;
    if(typeof allItems == 'undefined') return;

    let fieldItems = [];
    for(i = 0; i < allItems.length; i++)
    {
        allItems[i].disabled = false;
        if(chosenFields.includes(allItems[i].value)) allItems[i].disabled = true;
        fieldItems[allItems[i].value] = Object.assign({},allItems[i]);
        fieldItems[allItems[i].value].i = i;
    }

    $("[name^='fields']").each(function()
    {
        const $field = $(this).zui('picker');
        const field  = $(this).val();
        let currentFieldItems = JSON.parse(JSON.stringify(allItems));
        if(field) currentFieldItems[fieldItems[field].i].disabled = false;
        $field.render({items: currentFieldItems});
    });
}
