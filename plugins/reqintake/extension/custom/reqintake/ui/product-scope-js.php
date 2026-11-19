<?php
namespace zin;

context::js(<<<'JS'
const reqintakeOptions = (select, choices, selected) => {
    select.replaceChildren(...Object.entries(choices).map(([id, label]) => new Option(label, id)));
    if (Object.hasOwn(choices, selected)) select.value = selected;
};
const reqintakeScope = (form, scope, selected, restore = true) => {
    const {modules, branches, plans} = scope;
    const extra = form.querySelector('[data-reqintake-extra]');
    const rows = extra.querySelector('[data-reqintake-branches]');
    const branch = form.elements.branch;
    const moduleSelect = form.elements.module;
    const update = (id) => reqintakeOptions(moduleSelect, modules[branch.value] || {0: ''}, id);
    const additional = restore ? JSON.parse(extra.dataset.initial) : {};
    const refresh = () => {
        const previous = Object.fromEntries([...rows.querySelectorAll('select')].map(select => [select.dataset.branch, select.value]));
        rows.replaceChildren();
        const choices = Object.entries(branches).filter(([id]) => id !== branch.value);
        for (const [id, name] of choices) {
            const label = document.createElement('label');
            label.className = 'block';
            label.append(name);
            const select = document.createElement('select');
            select.className = 'form-control';
            select.name = 'branchModules[' + id + ']';
            select.dataset.branch = id;
            select.add(new Option(extra.dataset.unused, '-1'));
            const options = modules[id] || {0: ''};
            for (const [module, label] of Object.entries(options)) select.add(new Option(label || '—', module));
            const choice = previous[id] ?? additional[id];
            if (choice !== undefined && Object.hasOwn(options, choice)) select.value = choice;
            label.append(select);
            rows.append(label);
        }
        extra.hidden = choices.length === 0;
    };
    const plan = form.elements.plan;
    const updatePlan = id => {
        const options = {...(plans[branch.value] || {0: ''})};
        if (id !== '0' && !Object.hasOwn(options, id)) options[id] = '#' + id;
        reqintakeOptions(plan, options, id);
    };
    branch.onchange = () => {
        updatePlan('0');
        update('0');
        refresh();
    };
    updatePlan(restore ? plan.dataset.initial : '0');
    if (selected !== undefined) update(selected);
    refresh();
};
JS);
