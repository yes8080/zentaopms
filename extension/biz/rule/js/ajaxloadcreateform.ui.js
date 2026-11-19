window.changeFields = function(e)
{
    const fields = $(e.target).val();

    $('.newForm').find('.form-row:not(.required)').addClass('hidden');
    $('.newForm').find('[name^=fields]').closest('.form-row').removeClass('hidden');
    fields.forEach(function(field)
    {
        $(`[name^="${field}"]`).closest('.form-row').removeClass('hidden');
        if(field == 'module') loadProductModule($('[name=product]').val());
    })
}

window.loadProductRelation = function(e)
{
    if($(e.target).attr('name') != 'product') return; // 分支也会触发这个事件

    const productID = e.target.value;

    loadProductProject(productID);
    loadProductBranch(productID);
    loadProductPlans(productID);
    loadProductModule(productID);
    loadProductBuilds(productID);
    loadProductCases(productID);
    loadProductStories(productID);
}

window.loadProductBranch = function(productID, branchID)
{
    const url = $.createLink('branch', 'ajaxGetBranches', 'productID=' + productID);
    $.getJSON(url, function(data)
    {
        if(data.length > 0)
        {
            $('.newFormBody').find('[name=product]').closest('.form-group').find('.form-group-wrapper').first().css('width', '70%');
            $('.newFormBody').find('[name=product]').closest('.form-group').find('#branch').remove();
            $('.newFormBody').find('[name=product]').closest('.form-group').append('<div class="form-group-wrapper" style="width:30%" id="branch"></div>')
            new zui.Picker('#branch', {
                items: data,
                name: 'branch',
                defaultValue: branchID,
                required: true,
                onChange: function()
                {
                    const productID = $('[name=product]').val();
                    loadProductProject(productID);
                    loadProductBranch(productID);
                    loadProductPlans(productID);
                    loadProductModule(productID);
                    loadProductBuilds(productID);
                    loadProductCases(productID);
                    loadProductStories(productID);
                }
            });
        }
        else
        {
            $('.newFormBody').find('[name=product]').closest('.form-group').find('.form-group-wrapper').css('width', '100%');
            $('.newFormBody').find('[name=product]').closest('.form-group').find('#branch').remove();
        }
    })
}

window.loadProductPlans = function(productID)
{
    if($('.newFormBody').find('[name=plan]').length == 0)
    {
        return false;
    }

    const branch = $('.newFormBody').find('[name=branch]').val() || 0;
    const url    = $.createLink('product', 'ajaxGetPlans', 'productID=' + productID + '&branch=' + branch + '&params=unexpired,noclosed&skipParent=true');
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name=plan]').zui('picker').render({items: data})
    })
}

window.loadProductProject = function(productID)
{
    if($('.newFormBody').find('[name=project]').length == 0)
    {
        return false;
    }

    const url = $.createLink('product', 'ajaxGetProjects', 'productID=' + productID);
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name=project]').zui('picker').render({items: data})
        $('.newFormBody').find('[name=project]').zui('picker').$.setValue('');
    })
}

window.loadProductModule = function(productID)
{
    if($('.newFormBody').find('[name=module]').length == 0) return false;

    const branch     = $('.newFormBody').find('[name=branch]').val() || 0;
    let   objectType = $('[name=objectType]').val();

    if(objectType == 'epic' || objectType == 'requirement') objectType = 'story';
    if(objectType == 'testcase') objectType = 'case';
    const url = $.createLink('tree', 'ajaxGetOptionMenu', 'productID=' + productID + '&viewtype=' + objectType + '&branch=' + branch + '&rootModuleID=0&returnType=items&fieldID=&extra=nodeleted');
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name=module]').zui('picker').render({items: data})
    })
}

window.loadProductBuilds = function(productID)
{
    if($('.newFormBody').find('[name^=openedBuild]').length == 0)
    {
        return false;
    }

    const link = $.createLink('build', 'ajaxGetProductBuilds', 'productID=' + productID + '&varName=openedBuild&build=&branch=all&type=normal');
    $.getJSON(link, function(data)
    {
        let $buildPicker = $('[name^="openedBuild"]').zui('picker');
        $buildPicker.render({items: data});
        $buildPicker.$.setValue('');
    });
}

window.loadProductCases = function(productID)
{
    if($('.newFormBody').find('[name^=case]').length == 0)
    {
        return false;
    }

    const branchID = $('.newFormBody').find('[name=branch]').val() || 0;
    const link     = $.createLink('bug', 'ajaxGetProductCases', `productID=${productID}&branch=${branchID}`);
    $.getJSON(link, function(data)
    {
        let $casePicker = $('[name^="case"]').zui('picker');
        $casePicker.render({items: data});
        $casePicker.$.setValue('');
    });
}

window.loadProductStories = function(productID)
{
    if($('.newFormBody').find('[name^=story]').length == 0)
    {
        return false;
    }

    const branchID = $('.newFormBody').find('[name=branch]').val() || 0;
    const link     = $.createLink('story', 'ajaxGetProductStories', `productID=${productID}&branch=${branchID}&moduleID=0&storyID=0&onlyOption=false&status=&limit=0&type=story`);
    $.getJSON(link, function(data)
    {
        let $storyPicker = $('[name^="story"]').zui('picker');
        $storyPicker.render({items: data});
        $storyPicker.$.setValue('');
    });
}

window.loadProjectRelation = function(e)
{
    const projectID = e.target.value;
    loadProjectExecution(projectID);
    loadProjectBuilds(projectID);
    loadProjectProducts(projectID);

    const objectType  = $('[name=objectType]').val();
    if(objectType == 'execution')
    {
        const link = $.createLink('rule', 'ajaxGetExecutionTypeList', 'projectID=' + projectID);
        $.getJSON(link, function(data){
            $('.newFormBody [name=type]').zui('picker').render({items: data});
        });
    }
}

window.loadProjectExecution = function(projectID)
{
    if($('.newFormBody').find('[name=execution]').length == 0)
    {
        return false;
    }

    const url = $.createLink('project', 'ajaxGetExecutions', 'projectID=' + projectID + '&mode=withobject');
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name=execution]').zui('picker').render({items: data.items})
        $('.newFormBody').find('[name=execution]').zui('picker').$.setValue('');
    })
}

window.loadProjectBuilds = function(projectID)
{
    if($('.newFormBody').find('[name^=openedBuild]').length == 0)
    {
        return false;
    }

    const productID = $('[name=product]').val();
    const link      = $.createLink('build', 'ajaxGetProjectBuilds', 'projectID=' + projectID + '&productID=' + productID + '&varName=openedBuild&build=&branch=all');
    $.getJSON(link, function(data)
    {
        let $buildPicker = $('[name^="openedBuild"]').zui('picker');
        $buildPicker.render({items: data});
        $buildPicker.$.setValue('');
    })
}

window.loadProjectProducts = function(projectID)
{
    if($('.newFormBody').find('[name^=products]').length == 0 || projectID == 'currentProject')
    {
        return false;
    }

    const url = $.createLink('product', 'ajaxGetProducts', 'projectID=' + projectID);
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name^=products]').zui('picker').render({items: data})
        $('.newFormBody').find('[name^=products]').zui('picker').$.setValue('');
    })
}

window.loadExecutionRelation = function(e)
{
    const objectType  = $('[name=objectType]').val();
    const executionID = e.target.value;
    loadExecutionBuilds(executionID);
    loadExecutionTasks(executionID);
    if(objectType == 'task')
    {
        loadExecutionModules(executionID);
        loadParentTasks(executionID);
        loadExecutionStories(executionID);
    }
}

window.loadExecutionBuilds = function(executionID)
{
    if($('.newFormBody').find('[name^=openedBuild]').length == 0)
    {
        return false;
    }

    const productID = $('[name=product]').val();
    const link      = $.createLink('build', 'ajaxGetExecutionBuilds', 'executionID=' + executionID + '&productID=' + productID + "&varName=openedBuild&build=&branch=all&needCreate=true");
    $.getJSON(link, function(data)
    {
        let $buildPicker = $('[name^="openedBuild"]').zui('picker');
        $buildPicker.render({items: data});
        $buildPicker.$.setValue('');
    });
}

window.loadExecutionTasks = function(executionID)
{
    if($('.newFormBody').find('[name^=task]').length == 0)
    {
        return false;
    }

    const link = $.createLink('task', 'ajaxGetExecutionTasks', 'executionID=' + executionID);
    $.getJSON(link, function(data)
    {
        let $taskPicker = $('[name^="task"]').zui('picker');
        $taskPicker.render({items: data});
        $taskPicker.$.setValue('');
    });
}

window.loadExecutionModules = function(executionID)
{
    if($('.newFormBody').find('[name^=module]').length == 0)
    {
        return false;
    }

    const url = $.createLink('tree', 'ajaxGetOptionMenu', 'rootID=' + executionID + '&viewtype=task&branch=0&rootModuleID=0&returnType=items');
    $.get(url, function(modules)
    {
        if(modules)
        {
            modules = JSON.parse(modules);
            const $modulePicker = $('input[name=module]').zui('picker');
            $modulePicker.render({items: modules});
            $modulePicker.$.setValue('');
        }
    });
}

window.loadParentTasks = function(executionID)
{
    if($('.newFormBody').find('[name=parent]').length == 0)
    {
        return false;
    }

    const url = $.createLink('rule', 'ajaxGetParentTasks', 'executionID=' + executionID);
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name=parent]').zui('picker').render({items: data})
    })
}

window.loadExecutionStories = function(executionID, moduleID = 0)
{
    if($('.newFormBody').find('[name=story]').length == 0 || executionID == 'currentExecution')
    {
        return false;
    }

    const url = $.createLink('task', 'ajaxGetStories', 'executionID=' + executionID + `&moduleID=${moduleID}`);
    $.getJSON(url, function(data)
    {
        $('.newFormBody').find('[name=story]').zui('picker').render({items: data})
    })
}

window.loadModuleStories = function(e)
{
    const moduleID    = e.target.value;
    const executionID = $('[name=execution]').val();

    loadExecutionStories(executionID, moduleID);
}

window.copyField = function(e)
{
    const btn     = e.relativeTarget.target;
    const field   = $(btn).closest('.form-row').find('.form-group').attr('data-name');
    const varName = e.key;

    if($(btn).hasClass('editor'))
    {
        $('zen-editor[name="' + field + '"]')[0].getHTML().then((content) => {
            content += varName;
            $('zen-editor[name="' + field + '"]')[0].setHTML(content);
        })
    }
    else
    {
        let value = $(`[name^="${field}"]`).val();
        value += varName;
        $(`[name^="${field}"]`).val(value);
    }
}

window.loadWorkflowGroup = function(e)
{
    const model      = e.target.value;
    const objectType = $('[name=objectType]').val();

    const url = $.createLink('rule', 'ajaxGetWorkflowGroups', `objectType=${objectType}&model=${model}`);
    $.getJSON(url, function(data)
    {
        $('[name=workflowGroup]').zui('picker').render({items: data});
        $('[name=workflowGroup]').zui('picker').$.setValue('');
    })

    if(model == 'kanban')
    {
        $('[name=workflowGroup]').closest('.form-row').addClass('hidden');
    }
    else
    {
        $('[name=workflowGroup]').closest('.form-row').removeClass('hidden');
    }

    if(['ipd', 'waterfall', 'waterfallplus', 'agileplus'].includes(model))
    {
        $('[name=multiple]').closest('.form-row').addClass('hidden');
        $('[name=multiple]').zui('picker').$.setValue('1');
    }
    else
    {
        $('[name=multiple]').closest('.form-row').removeClass('hidden');
        $('[name=multiple]').zui('picker').$.setValue('');
    }
}

window.checkBeginAndEnd = function(e)
{
    const begin = $('[name=begin]').val();
    const end   = $('[name=end]').val();

    if(begin && end && begin > end)
    {
        zui.Modal.alert(errorLang.beginGtEnd);
        $(`[name=end]`).zui('datePicker').$.setValue('');
    }

    const projectID = $('[name=project]').val();
    if($('[name=objectType]').val() != 'execution') return;
    if(projectID == 'currentProject' || projectID == '') return;

    $.post($.createLink('rule', 'ajaxCheckBeginAndEnd', `projectID=${$('[name=project]').val()}`), {begin: begin, end: end}, function(data)
    {
        data = JSON.parse(data);
        if(data.result == 'fail')
        {
            zui.Modal.alert(data.message);
            $(`[name=${data.field}]`).zui('datePicker').$.setValue('');
        }
    })
}

window.loadSubAclList = function(e)
{
    const program = e.target.value;

    if(program)
    {
        $('[name=acl]').zui('picker').render({items: JSON.parse(subProjectAclList)});
    }
    else
    {
        $('[name=acl]').zui('picker').render({items: JSON.parse(projectAclList)});
    }
}
