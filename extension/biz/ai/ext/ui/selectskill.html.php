<?php

namespace zin;

jsVar('skills', array_values($skills));
jsVar('categories', $categories);
jsVar('callback', $callback);
jsVar('selectedID', $selectedID);
jsVar('current', $current);
jsVar('allCategory', $lang->ai->skills->statusList['']);
jsVar('useLabel', $lang->ai->skills->use);
jsVar('emptyList', $lang->ai->skills->emptyList);
jsVar('categoryExpandLabel', $lang->expand);
jsVar('categoryCollapseLabel', $lang->collapse);

div
(
    setClass('select-skill-modal'),
    h4(setClass('modal-title text-lg font-bold'), $title),
    div
    (
        setClass('search-box'),
        icon('search'),
        input
        (
            set::type('text'),
            setID('skill-search'),
            set::placeholder($lang->ai->skills->searchPlaceholder)
        )
    ),
    div
    (
        setID('skill-category-filter'),
        setClass('category-filter is-collapsed'),
        div(setID('skill-category-tabs'), setClass('category-tabs')),
        button
        (
            setID('skill-category-toggle'),
            setClass('category-toggle hidden'),
            set::type('button'),
            set('aria-expanded', 'false'),
            span(setClass('toggle-text')),
            icon('angle-down')
        )
    ),
    div(setID('skill-list'), setClass('skill-list'))
);
