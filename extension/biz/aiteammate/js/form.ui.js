function fillAITaskHiddenFields()
{
    const formSchema = sessionStorage.getItem('aiFormSchema');
    if(formSchema) $('input[name="formSchema"]').val(formSchema);

    const formPageUrl = sessionStorage.getItem('aiFormPageUrl');
    if(formPageUrl) $('input[name="formPageUrl"]').val(formPageUrl);
}

$(document).ready(function() {
    initData();
    fillAITaskHiddenFields();
    knowledgeLibItemActions();
    avatarInputAutoSubmit();

    $(document).on('submit', 'form', function()
    {
        fillAITaskHiddenFields();
    });
});

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

/* 数据初始化 */
function initData() {
    KnowledgeLibManager.setLibs(knowledgeLibs || []);
}

/* 渲染字段列表占位符 */
function renderKnowledgeLibsPlaceholder()
{
    return `
        <div class="field-empty bg-gray-50" id="add-knowledge-lib">
            <div class="action text-primary-400">
                <i class="icon icon-plus"></i>
                <span>${knowledgeLibAdd}</span>
            </div>
            <div class="tips text-gray-400">${knowledgeLibAddTip}</div>
        </div>
    `;
}

/* 渲染字段项 */
function renderKnowledgeLibItem(lib)
{
    const available = lib.published === '1' && lib.deleted === '0';

    let badge = '';
    if(lib.published === '0') badge = `<span class="badge badge-danger">${unpublished}</span>`;
    if(lib.deleted === '1') badge = `<span class="badge badge-danger">${deleted}</span>`;

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
    const ids  = libs.map(lib => lib.id).join(',');

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
    $('input[name="klibs"]').val(ids);
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

/* 检查和上传头像 */
function avatarInputAutoSubmit()
{
    $(document).on('change', '#teammateAvatarForm input[type=file]', function()
    {
        const fileInput = $(this)[0];
        const file      = fileInput.files[0];
        if(!file) return;

        const maxSize = 1024 * 1024; // 1MB
        if(file.size > maxSize)
        {
            zui.Messager.fail(errorUploadSize);

            const newInput = fileInput.cloneNode(true);
            fileInput.parentNode.replaceChild(newInput, fileInput);
            return false;
        }

        $('#teammateAvatarForm button[type=submit]').trigger('click');
    });
}

/* 上传头像 */
window.uploadAvatar = function()
{
    $('#teammateAvatarForm input[type=file]').trigger('click');
};

/* 更新头像预览 */
window.updateAvatarPreview = function(path)
{
    const avatarBox = $('.avatar-box');

    avatarBox.find('img').attr('src', path);
    $('input[name="avatar"]').val(path);

    if(path && path !== '')
    {
        avatarBox.removeClass('empty');
    }
    else
    {
        avatarBox.addClass('empty');
    }

    $('#teammateAvatarForm input[type=file]').val('');
};

/* 复制提词 */
window.copyPrompt = function(prompt)
{
    if(!prompt) return;

    navigator.clipboard.writeText(prompt);
    zui.Messager.success(copySuccess);
};
