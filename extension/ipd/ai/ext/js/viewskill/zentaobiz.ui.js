window.showSkillFilePreviewModal = function(files, index)
{
    const SKILL_FILE_PREVIEW_MODAL_ID = 'skillFilePreviewModal';
    zui.Modal.open({
        id: SKILL_FILE_PREVIEW_MODAL_ID,
        type: 'custom',
        size: 'lg',
        className: 'skill-file-preview-modal',
        header: false,
        custom: {
            body: {html: '<div class="skill-file-previewer"></div>'},
        },
        onShown: function()
        {
            const $container = $(`#${SKILL_FILE_PREVIEW_MODAL_ID} .skill-file-previewer`);
            if(!$container.length) return;

            new zui.FilePreviewer($container[0], {
                files: files,
                defaultIndex: index,
                officeSupported: false,
                officeInstalled: false,
                toolbar: true,
                pager: files.length > 1,
                loop: true
            });
        },
    });
};

window.toggleSkillFileDir = function(event)
{
    const $toggle = $(event.target).closest('.skill-file-toggle');
    const $dir    = $toggle.closest('.skill-file-dir');
    $dir.toggleClass('expanded collapsed');
    $toggle.toggleClass('icon-minus icon-plus');
};

window.previewSkillFile = function(index)
{
    if(index === undefined || !skillFiles || !skillFiles.length) return;

    showSkillFilePreviewModal(
        skillFiles,
        index
    );
};
