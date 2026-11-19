<?php

namespace zin;

include './promptnav.html.php';

$defaultCategory = $activeDataSource ?? 'product';

jsVar('dataSource', $dataSource);
jsVar('moduleList', $lang->ai->moduleList);
jsVar('activeDataSource', $defaultCategory);
jsVar('selectedSources', $prompt->source ? explode(',', trim($prompt->source, ',')) : array());

function getModuleLang($lang, $moduleKey)
{
    if(isset($lang->ai->moduleList[$moduleKey])) return $lang->ai->moduleList[$moduleKey];
    return array('common' => $moduleKey);
}

function buildCategoryList($lang, $selectedCategory, $dataSource) {
    $categories = [];
    foreach($dataSource as $category => $fields) $categories[$category] = $lang->ai->moduleList[$category]['common'];

    $categoryKeys   = array_keys($categories);
    $categoryValues = array_values($categories);

    return ul(
        setClass('category-list'),
        array_map(function($key, $label, $index) use ($selectedCategory) {
            $isActive = $key === $selectedCategory ? ' active' : '';
            return li(
                setClass('category-item' . $isActive),
                setData('category', $key),
                $label,
            );
        }, $categoryKeys, $categoryValues, array_keys($categoryKeys))
    );
}

/* 构建字段列表 */
function buildFieldList($lang, $dataSource, $selectedCategory, $selectedFields = array()) {
    $categoryDataSources = $dataSource[$selectedCategory] ?? array();

    $objViews = array();
    foreach ($categoryDataSources as $sourceKey => $fields) {
        $groupSelected = true;
        $hasSelectedField = false;
        foreach ($fields as $field) {
            $fieldKey = $sourceKey . '.' . $field;
            if (in_array($fieldKey, $selectedFields)) {
                $hasSelectedField = true;
            } else {
                $groupSelected = false;
            }
        }

        if (!$hasSelectedField) {
            $groupSelected = false;
        }

        $objView = div(
            setClass('category-group'),
            div(
                setClass('category-group-header'),
                checkbox(
                    set::primary(true),
                    set::rootClass('group-item'),
                    set::typeClass('checkbox'),
                    setData('prop', $sourceKey),
                    set::checked($groupSelected),
                    set::text(getModuleLang($lang, $sourceKey)['common'] ?? $sourceKey)
                )
            ),
            div(
                setClass('category-group-body check-list-inline'),
                array_map(function($field) use ($sourceKey, $selectedCategory, $lang, $selectedFields) {
                    $fieldKey = $sourceKey . '.' . $field;
                    $isSelected = in_array($fieldKey, $selectedFields);

                    return checkbox(
                        set::primary(true),
                        set::rootClass('group-item'),
                        set::typeClass('checkbox'),
                        setData('prop', $fieldKey),
                        set::checked($isSelected),
                        set::text(getModuleLang($lang, $sourceKey)[$field] ?? $field)
                    );
                }, $fields)
            )
        );

        $objViews[] = $objView;
    }

    return div(
        setClass('category-groups'),
        setData('object-group', $selectedCategory),
        $objViews
    );
}

/* 构建已选数据标题 */
function buildSelectedTitle($lang, $selectedCategory, $count = 0) {
    $categoryName = $lang->ai->moduleList[$selectedCategory]['common'];

    $format = $lang->ai->prompts->selectedFormat;
    $initialText = str_replace(array('{0}', '{1}'), array($categoryName, $count), $format);

    return h4(
        setID('selected-title-text'),
        setClass('text-md selected-title-text'),
        setData('group', $selectedCategory),
        setData('format', $format),
        $initialText
    );
}

/* 构建已选择列表 */
function buildSelectedList($lang, $config, $selectedCategory, $selectedFields = array()) {
    if (empty($selectedFields)) {
        return div(
            setID('selected-data-sorter'),
            setClass('selected-data-sorter'),
            setData('group', $selectedCategory),
            ol(setClass('list-group'))
        );
    }

    $listItems = array();
    foreach ($selectedFields as $index => $field) {
        if(empty($field)) continue;
        list($source, $fieldName) = explode('.', $field);
        $sourceLang = getModuleLang($lang, $source);
        $fieldLang  = $sourceLang[$fieldName] ?? $fieldName;

        $listItems[] = li(
            setClass('list-group-item'),
            setData('prop', $field),
            setData('order', $index),
            icon(
                set::name('move'),
                setClass('text-gray drag-icon')
            ),
            span(
                $sourceLang['common'] . ' / ' . $fieldLang
            ),
            icon(
                set::name('close'),
                setClass('text-gray remove-icon')
            )
        );
    }

    return div(
        setID('selected-data-sorter'),
        setClass('selected-data-sorter'),
        setData('group', $selectedCategory),
        ol(
            setClass('list-group'),
            $listItems
        )
    );
}

div(
    setClass('prompt-select-source'),
    formPanel
    (
        set::id('mainForm'),
        set::actions(
            array(
                array('text' => $lang->ai->nextStep, 'class' => 'btn primary', 'id' => 'select-data-source-submit', 'btnType' => 'submit', 'name' => 'jumpToNext', 'value' => '1')
            )
        ),
        div(
            setClass('data-selector-container'),
            div(
                setClass('data-sources-panel'),
                div(
                    setClass('data-categories-section'),
                    div(
                        setClass('section-header'),
                        h4(
                            setClass('text-md text-center'),
                            $lang->ai->prompts->selectDataSource,
                        ),
                    ),
                    div(
                        setClass('section-content'),
                        buildCategoryList($lang, $defaultCategory, $dataSource)
                    )
                ),
                div(
                    setClass('data-properties-section'),
                    div(
                        setClass('section-header'),
                        h4(
                            setClass('text-md'),
                            $lang->ai->prompts->selectData,
                        ),
                        small(
                            setClass('text-gray'),
                            $lang->ai->prompts->selectDataTip,
                        ),
                    ),
                    div(
                        setClass('section-content'),
                        buildFieldList($lang, $dataSource, $defaultCategory, $prompt->source ? explode(',', trim($prompt->source, ',')) : array())
                    )
                )
            ),
            div(
                setClass('data-selected-panel'),
                div(
                    setClass('section-header'),
                    buildSelectedTitle($lang, $defaultCategory, $prompt->source ? count(explode(',', trim($prompt->source, ','))) : 0),
                ),
                div(
                    setClass('section-content'),
                    buildSelectedList($lang, $config, $defaultCategory, $prompt->source ? explode(',', trim($prompt->source, ',')) : array()),
                )
            )
        ),
        input(
            set::name('datasource'),
            set::type('hidden'),
            set::value($prompt->source ?? '')
        ),
        input(
            set::name('datagroup'),
            set::type('hidden'),
            set::value($activeDataSource ?? '')
        ),
        on::init()->call('initPromptSelectDataSourceForm')
    )
);
