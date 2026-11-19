$(document).ready(function()
{
    initSelectSkillModal();
});

let currentCategory = '';
let categoryExpanded = false;

function initSelectSkillModal()
{
    renderCategoryTabs();
    renderSkillList();

    $('#skill-search').on('input', function()
    {
        renderSkillList($(this).val().trim());
    });

    $('#skill-category-toggle').on('click', function()
    {
        categoryExpanded = !categoryExpanded;
        updateCategoryToggle();
    });

    $(window).off('resize.selectSkillCategory').on('resize.selectSkillCategory', function()
    {
        updateCategoryToggle();
    });
}

function renderCategoryTabs()
{
    const tabs = [{id: '', name: allCategory}];

    Object.keys(categories || {}).forEach(id => {
        tabs.push({id: String(id), name: categories[id]});
    });

    const html = tabs.map(tab => {
        const active = currentCategory == tab.id ? ' active' : '';
        return `<button type="button" class="category-tab${active}" data-category="${tab.id}">${tab.name}</button>`;
    }).join('');

    $('#skill-category-tabs').html(html).off('click', '.category-tab').on('click', '.category-tab', function()
    {
        currentCategory = $(this).data('category');
        renderCategoryTabs();
        renderSkillList($('#skill-search').val().trim());
    });

    if(window.requestAnimationFrame) window.requestAnimationFrame(updateCategoryToggle);
    setTimeout(updateCategoryToggle, 100);
}

function updateCategoryToggle()
{
    const $filter = $('#skill-category-filter');
    const $tabs   = $('#skill-category-tabs');
    const $toggle = $('#skill-category-toggle');

    if(!$filter.length || !$tabs.length || !$toggle.length) return;

    const collapsedHeight = getCategoryCollapsedHeight($tabs);
    const tabsElement     = $tabs[0];

    $filter.css('--category-tabs-collapsed-height', `${collapsedHeight}px`);
    $filter.removeClass('is-collapsed').addClass('is-expanded');
    $toggle.addClass('hidden');

    const shouldToggle = tabsElement.scrollHeight > collapsedHeight + 1;
    const isExpanded   = shouldToggle && categoryExpanded;

    $filter.toggleClass('is-expanded', isExpanded);
    $filter.toggleClass('is-collapsed', !isExpanded);
    $toggle.toggleClass('hidden', !shouldToggle);
    $toggle.attr('aria-expanded', isExpanded ? 'true' : 'false');
    $toggle.find('.toggle-text').text(isExpanded ? categoryCollapseLabel : categoryExpandLabel);
}

function getCategoryCollapsedHeight($tabs)
{
    const $firstTab = $tabs.children('.category-tab').first();
    if(!$firstTab.length) return 30;

    return $firstTab.outerHeight();
}

function renderSkillList(keyword = '')
{
    const keywordLower = keyword.toLowerCase();
    const selectedIds  = (selectedID || []).map(id => parseInt(id)).filter(Boolean);
    const currentId    = current ? parseInt(current) : 0;

    const filtered = (skills || []).filter(skill => {
        const skillId = parseInt(skill.id);
        if(selectedIds.includes(skillId) && skillId !== currentId) return false;
        if(currentCategory && String(skill.category) !== String(currentCategory)) return false;
        if(!keywordLower) return true;

        const name = (skill.name || '').toLowerCase();
        const desc = (skill.desc || '').toLowerCase();
        return name.includes(keywordLower) || desc.includes(keywordLower);
    });

    if(!filtered.length)
    {
        $('#skill-list').html(`<div class="skill-empty">${emptyList}</div>`);
        return;
    }

    const html = filtered.map(skill => {
        const categoryLabel = skill.categoryLabel || '';

        return `
            <div class="skill-card" data-id="${skill.id}">

                <div class="skill-card-body">
                    <div class="skill-card-name">${skill.name}</div>
                    <div class="skill-card-desc" title="${skill.desc || ''}">${skill.desc || ''}</div>
                </div>
                <div class="skill-card-side">
                    <span class="skill-card-category label secondary-pale">${categoryLabel}</span>
                    <button type="button" class="btn primary-outline size-sm" data-action="use" data-id="${skill.id}">${useLabel}</button>
                </div>
            </div>
        `;
    }).join('');

    $('#skill-list').html(html).off('click', '[data-action="use"]').on('click', '[data-action="use"]', function()
    {
        const skillId = parseInt($(this).data('id'));
        const skill   = (skills || []).find(item => parseInt(item.id) === skillId);
        if(!skill || !callback || typeof window[callback] !== 'function') return;

        window[callback](skill);
        zui.Modal.hide();
    });
}
