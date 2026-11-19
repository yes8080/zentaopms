<?php
namespace zin;

context::js(<<<'JS'
const reqintakeOptions = (select, choices, selected) => {
    select.replaceChildren(...Object.entries(choices).map(([id, label]) => new Option(label, id)));
    if (Object.hasOwn(choices, selected)) select.value = selected;
};
const reqintakeScope = (form, modules, selected) => {
    const branch = form.elements.branch;
    const moduleSelect = form.elements.module;
    const update = (id) => reqintakeOptions(moduleSelect, modules[branch.value] || {0: ''}, id);
    branch.onchange = () => update('0');
    if (selected !== undefined) update(selected);
};
JS);
