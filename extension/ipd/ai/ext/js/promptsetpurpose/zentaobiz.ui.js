$(document).ready(function()
{
    initData();
    initPromptEditor();
    initRoleChange();
    skillItemActions();
    knowledgeLibItemActions();
    actionSave();
});

/* 是否已保存 */
let isSaved = true;

/* Markdown 组件 */
let markdownComponent = null;

/* Prompt 初始值 */
const initPrompt = processPromptText(currentPrompt || '');

/* Prompt Data */
let promptData = {
  editor: null,
  text: initPrompt,
  html: '',
};

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

/* 知识库数据管理 */
const KnowledgeLibManager = {
    state: {
        libs: [],
        libsMap: {},
        action: '',
        targetId: '',
    },

    setLibs(libs)
    {
        this.state.libs = [];

        libs.forEach(lib => {
            this.state.libs.push(lib.id);
            this.state.libsMap[lib.id] = lib;
        });

        renderKnowledgeLibs();
    },

    setLibIds(libIds)
    {
        this.state.libs = libIds;

        renderKnowledgeLibs();
    },

    addLib(lib, afterId = null)
    {
        const index = afterId ? this.state.libs.indexOf(afterId) : -1;

        if(index === -1)
        {
            this.state.libs.push(lib.id);
        }
        else
        {
            this.state.libs.splice(index + 1, 0, lib.id);
        }

        this.state.libsMap[lib.id] = lib;

        renderKnowledgeLibs();
    },

    updateLib(lib, targetId)
    {
        const index = this.state.libs.indexOf(targetId);
        if(index === -1) return;

        this.state.libs[index] = lib.id;
        delete this.state.libsMap[targetId];
        this.state.libsMap[lib.id] = lib;

        renderKnowledgeLibs();
    },

    removeLib(libId)
    {
        const index = this.state.libs.indexOf(libId);
        if(index > -1)
        {
            this.state.libs.splice(index, 1);
            delete this.state.libsMap[libId];

            renderKnowledgeLibs();
        }
    },

    getLib(id)
    {
        return this.state.libsMap[id];
    },

    getLibs()
    {
        return this.state.libs.map(id => this.state.libsMap[id]);
    },

    setAction(action, targetId)
    {
      this.state.action   = action;
      this.state.targetId = targetId;
    },

    getAction()
    {
      const { action, targetId } = this.state;
      return { action, targetId };
    },
};

/* 技能数据管理 */
const SkillManager = {
    state: {
        skills: [],
        skillsMap: {},
        action: '',
        targetId: '',
    },

    setSkills(skills)
    {
        this.state.skills = [];

        skills.forEach(skill => {
            this.state.skills.push(skill.id);
            this.state.skillsMap[skill.id] = skill;
        });

        renderSkills();
    },

    addSkill(skill, afterId = null)
    {
        const index = afterId ? this.state.skills.indexOf(afterId) : -1;

        if(index === -1)
        {
            this.state.skills.push(skill.id);
        }
        else
        {
            this.state.skills.splice(index + 1, 0, skill.id);
        }

        this.state.skillsMap[skill.id] = skill;

        renderSkills();
    },

    updateSkill(skill, targetId)
    {
        const index = this.state.skills.indexOf(targetId);
        if(index === -1) return;

        this.state.skills[index] = skill.id;
        delete this.state.skillsMap[targetId];
        this.state.skillsMap[skill.id] = skill;

        renderSkills();
    },

    removeSkill(skillId)
    {
        const index = this.state.skills.indexOf(skillId);
        if(index > -1)
        {
            this.state.skills.splice(index, 1);
            delete this.state.skillsMap[skillId];

            renderSkills();
        }
    },

    getSkill(id)
    {
        return this.state.skillsMap[id];
    },

    getSkills()
    {
        return this.state.skills.map(id => this.state.skillsMap[id]);
    },

    setAction(action, targetId)
    {
        this.state.action   = action;
        this.state.targetId = targetId;
    },

    getAction()
    {
        const { action, targetId } = this.state;
        return { action, targetId };
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

    SkillManager.setSkills(skills || []);
    KnowledgeLibManager.setLibs(knowledgeLibs || []);
    FieldManager.setFields(fields);
}

/* 检查内容，更新提交按钮状态 */
function checkAndUpdateSubmit()
{
    const prompt = promptData.text.trim();

    $('#btn-save').prop('disabled', prompt.length === 0);
}

/* 获取 Prompt 纯文本 */
function getPromptText()
{
    if(promptData.editor && typeof promptData.editor.getText === 'function')
    {
        return promptData.editor.getText().replace(/\n\n/g, '\n');
    }

    return promptData.text;
}

/* 构建输入提示列表 */
function buildInputSuggestions(query = '')
{
    const list = FieldManager.getFields().map(field => ({
        text: field.name,
        value: field.name,
    }));

    if(!query.query) return list;
    return list.filter(item => item.text.includes(query.query));
}

/* 处理 Prompt 文本 */
function processPromptText(text)
{
  if(!text) return '';

  return text.replace(/&lt;/g, '<').replace(/&gt;/g, '>');
}

/* 将文本转换为 HTML */
function propmtTextToHtml(text)
{
    let html         = text.replace(/</g, '&lt;').replace(/>/g, '&gt;');
    const fields     = FieldManager.getFields();
    const fieldNames = {};

    fields.forEach(field => {
        fieldNames[field.name] = field.id;
    });

    html = html.replace(/&lt;([^&]+)&gt;/g, function(match, fieldName)
    {
        if(!fieldNames[fieldName]) return match;

        return `<span class="mention-label" data-type="mention" data-id="${fieldName}&gt;" data-label="${fieldName}&gt;" data-mention-suggestion-char="&lt;">&lt;${fieldName}&gt;</span>`;
    });

    const list = html.split('\n');

    return list.map((line) => `<p>${line}</p>`).join('');
}

/* 初始化 Prompt Editor */
function initPromptEditor()
{
    /* 是否为初始化 */
    let isInit = true;

    promptData.html = propmtTextToHtml(initPrompt);

    promptData.editor = new zui.TEditor('#prompt-editor', {
        content: promptData.html,
        mode: 'plain',
        contentType: 'html',
        suggestions: {
            '<': query => buildInputSuggestions(query),
        },
        onChange: function(content)
        {
            promptData.text = getPromptText();
            promptData.html = promptData.editor.getHtml();

            /* 跳过初始化导致的改动 */
            if(isInit) isInit = false;
            else isSaved = false;

            checkAndUpdateSubmit();
        },
    });
}

/* 监听角色变化 */
function initRoleChange()
{
    $('textarea[name="role"]').on('input', function()
    {
        isSaved = false;
    });
}

/* 渲染技能列表占位符 */
function renderSkillsPlaceholder()
{
    return `
        <div class="field-empty" id="add-skill">
            <div class="action text-primary">
                <i class="icon icon-plus"></i>
                <span>${skillAdd}</span>
            </div>
            <div class="tips">${skillAddTip}</div>
        </div>
    `;
}

/* 渲染技能项 */
function renderSkillItem(skill)
{
    const available = skill.status === 'active';

    let badge = '';
    if(!available) badge = `<span class="badge badge-danger">${skillUnpublished}</span>`;

    return `
        <li class="field-item" data-id="${skill.id}">
            <div class="rect">
              <span class="text-ellipsis" title="${skill.name}">${skill.name}</span>
              ${badge}
            </div>
            <button class="btn size-sm square" data-action="add">
                <i class="icon icon-plus"></i>
            </button>
            <button class="btn size-sm square ${available ? '' : 'disabled'}" data-action="edit" ${available ? '' : 'disabled'}>
                <i class="icon icon-edit"></i>
            </button>
            <button class="btn size-sm square" data-action="delete">
                <i class="icon icon-trash"></i>
            </button>
        </li>
    `;
}

/* 渲染技能列表 */
function renderSkills()
{
    const skillList = $('#mounted-skills');
    skillList.empty();

    const mountedSkills = SkillManager.getSkills();

    let html = '';
    if(mountedSkills.length === 0)
    {
        html = renderSkillsPlaceholder();
    }
    else
    {
        mountedSkills.forEach(skill => {
            html += renderSkillItem(skill);
        });
    }

    skillList.html(html);
}

/* 技能列表操作 */
function skillItemActions()
{
    $('#mounted-skills')
        .on('click', 'button', function(event)
        {
            event.preventDefault();

            const action  = $(this).data('action');
            const skillId = $(this).closest('.field-item').data('id');

            switch(action)
            {
                case 'add':
                    openSkillModal('add', skillId);
                    break;
                case 'edit':
                    openSkillModal('edit', skillId);
                    break;
                case 'delete':
                    confirmToDeleteSkill(skillId);
                    break;
                default:
            }
        })
        .on('click', '#add-skill', function(event)
        {
            event.preventDefault();

            openSkillModal('add', null);
        });
}

/* 打开技能 Modal */
function openSkillModal(action, skillId)
{
    SkillManager.setAction(action, skillId);

    const selectedID = SkillManager.getSkills().map(skill => skill.id).join(',');

    zui.Modal.open({
        id: 'selectSkillModal',
        url: $.createLink('ai', 'selectSkill', `callback=skillOnSelect&selectedID=${selectedID}${action === 'edit' ? '&current=' + skillId : ''}`),
        size: 'sm',
    });
}

/* 技能选中回调 */
window.skillOnSelect = function(skill)
{
    const { action, targetId } = SkillManager.getAction();

    if(action === 'add')
    {
        SkillManager.addSkill(skill, targetId);
    }
    else if(action === 'edit')
    {
        SkillManager.updateSkill(skill, targetId);
    }
};

/* 确认并删除技能 */
function confirmToDeleteSkill(skillId)
{
    zui.Modal.confirm(confirmDelete)
        .then(confirmed => {
            if(confirmed) SkillManager.removeSkill(skillId);
        });
}

/* 渲染字段列表占位符 */
function renderKnowledgeLibsPlaceholder()
{
    return `
        <div class="field-empty" id="add-knowledge-lib">
            <div class="action text-primary">
                <i class="icon icon-plus"></i>
                <span>${knowledgeLibAdd}</span>
            </div>
            <div class="tips">${knowledgeLibAddTip}</div>
        </div>
    `;
}

/* 渲染字段项 */
function renderKnowledgeLibItem(lib)
{
    const available = lib.published && !lib.deleted;

    let badge = '';
    if(!lib.published) badge = `<span class="badge badge-danger">${unpublished}</span>`;
    if(+lib.deleted) badge = `<span class="badge badge-danger">${deleted}</span>`;

    return `
        <li class="field-item" data-id="${lib.id}">
            <div class="rect">
              <span class="text-ellipsis" title="${lib.name}">${lib.name}</span>
              ${badge}
            </div>
            <button class="btn size-sm square" data-action="add">
                <i class="icon icon-plus"></i>
            </button>
            <button class="btn size-sm square ${available ? '' : 'disabled'}" data-action="edit" ${available ? '' : 'disabled'}>
                <i class="icon icon-edit"></i>
            </button>
            <button class="btn size-sm square" data-action="delete">
                <i class="icon icon-trash"></i>
            </button>
        </li>
    `;
}

/* 渲染知识库列表 */
function renderKnowledgeLibs()
{
    const libList = $('#knowledge-libs');
    libList.empty();

    const libs = KnowledgeLibManager.getLibs();
    const ids = libs.map(lib => lib.id).join(',');
    $('input[name="knowledgeLib"]').val(ids);

    let html = '';
    if(libs.length === 0)
    {
        html = renderKnowledgeLibsPlaceholder();
    }
    else
    {
        libs.forEach(lib => {
            html += renderKnowledgeLibItem(lib);
        });
    }

    libList.html(html);
}

/* 知识库列表操作 */
function knowledgeLibItemActions()
{
    $('#knowledge-libs')
        .on('click', 'button', function(event)
        {
            event.preventDefault();

            const action = $(this).data('action');
            const libId  = $(this).closest('.field-item').data('id');

            switch(action)
            {
                case 'add':
                    openKnowledgeLibModal('add', libId);
                    break;
                case 'edit':
                    openKnowledgeLibModal('edit', libId);
                    break;
                case 'delete':
                    confirmToDeleteKnowledgeLib(libId);
                    break;
                default:
            }
        })
        .on('click', '#add-knowledge-lib', function(event)
        {
            event.preventDefault();

            openKnowledgeLibModal('add', null);
        });
}

/* 打开知识库 Modal */
function openKnowledgeLibModal(action, libId)
{
    KnowledgeLibManager.setAction(action, libId);

    const selectedID = KnowledgeLibManager.getLibs().map(lib => lib.id).join(',');

    zui.Modal.open({
        id: 'selectKnowledgeLibModal',
        url: $.createLink('ai', 'selectKnowledgeLib', `selectedID=${selectedID}&callback=knowledgeLibOnSelect&multiple=0&showSelected=1${action === 'edit' ? '&current=' + libId : ''}`),
        size: 'sm',
    });
}

/* 知识库选中回调 */
window.knowledgeLibOnSelect = function(libs)
{
    const { action, targetId } = KnowledgeLibManager.getAction();

    if(action === 'add')
    {
        KnowledgeLibManager.addLib(libs[0], targetId);
    }
    else if(action === 'edit')
    {
        KnowledgeLibManager.updateLib(libs[0], targetId);
    }
};

/* 确认并删除知识库 */
function confirmToDeleteKnowledgeLib(libId)
{
    zui.Modal.confirm(confirmDelete)
        .then(confirmed => {
            if(confirmed) KnowledgeLibManager.removeLib(libId);
        });
}

/* 发送页面数据 */
function postData(data)
{
    $.ajax({
        url: $.createLink('ai', 'promptSetPurpose', `promptID=${promptID}`),
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
                isSaved = true;
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
                content: saveFailed + '：' + error,
                type: 'danger',
            });
        });
}

/* 保存页面数据 */
function saveData()
{
    const prompt       = getPromptText().trim();
    const knowledgeLib = KnowledgeLibManager.getLibs().map(lib => lib.id).join(',');
    const skillValue   = SkillManager.getSkills().map(skill => skill.id).join(',');
    const role         = $('textarea[name="role"]').val().trim();

    if(!prompt)
    {
        zui.Messager.show({
            content: promptPlaceholder,
            type: 'danger',
        });
        return;
    }

    postData({
        purpose: prompt,
        knowledgeLib,
        skill: skillValue,
        role,
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
