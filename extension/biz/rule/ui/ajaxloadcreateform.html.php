<?php
/**
 * The ajaxloadcreateform file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('noticeLang', $lang->rule->notice);
jsVar('errorLang', $lang->rule->error);
if($objectType == 'project')
{
    $subAclItems = array();
    foreach($lang->project->subAclList as $value => $text)
    {
        $subAclItems[] = array('text' => $text, 'value' => $value);
    }

    $aclItems = array();
    foreach($lang->project->aclList as $value => $text)
    {
        $aclItems[] = array('text' => $text, 'value' => $value);
    }

    jsVar('subProjectAclList', json_encode($subAclItems));
    jsVar('projectAclList', json_encode($aclItems));
}

$fieldPairs = array();
foreach($fields as $field)
{
    $fieldPairs[$field->field] = $field->name;
}

$fieldItems = array();
foreach($sourceFields as $field => $name)
{
    if(!$field) continue;
    $fieldItems[] = array('text' => $name, 'key' => "{{{$fromObjectType}.{$field}}}", 'icon' => 'copy');
}

h4($lang->rule->requiredFields, setClass('ml-6 mt-4'));
foreach($requiredFields as $requiredField)
{
    if(!isset($fields[$requiredField])) continue;

    $field   = $fields[$requiredField];
    $control = $this->flow->buildFormControl($field);
    formRow
    (
        setClass('required'),
        !empty($field->hidden) ? set::hidden(true) : null,
        formGroup
        (
            $field->field == 'product'   ? on::change('loadProductRelation') : null,
            $field->field == 'project'   ? on::change('loadProjectRelation') : null,
            $field->field == 'execution' ? on::change('loadExecutionRelation') : null,
            $field->field == 'model'     ? on::change('loadWorkflowGroup') : null,
            $field->field == 'begin'     ? on::change('checkBeginAndEnd') : null,
            $field->field == 'end'       ? on::change('checkBeginAndEnd') : null,
            set::label($field->name),
            set('data-name', $field->field),
            set::required(true),
            control
            (
                set::name($field->field),
                set::type($control['control']),
                set::multiple(!empty($field->multiple)),
                $field->field == 'product' && isset($field->value) && strpos($field->value, 'current') === false ? set::afterRender(jsRaw("loadProductBranch($field->value, $branchID)")) : null,
                isset($field->value) ? set::value($field->value) : null,
                isset($field->options) ? set::items($field->options) : null
            ),
        ),
        in_array($control['control'],array('input','textarea')) ? dropdown
        (
            btn
            (
                icon('copy'),
                set::hint($lang->rule->copyField),
                setClass('copy-field-btn')
            ),
            set::items($fieldItems),
            set::caret(false),
            set::flip(true),
            set::placement('left-start'),
            set::strategy('absolute'),
            set::hasIcons(true),
            set::menuClass("copy-fields-menu $field->field"),
            set::menu(array
            (
                'header' => $lang->rule->objectList[$fromObjectType] . $lang->rule->field,
                'onClickItem' => jsRaw("copyField")
            )),
            set::trigger('click')
        ) : null
    );

    unset($fieldPairs[$requiredField]);
    unset($fields[$requiredField]);
}

h4($lang->rule->otherFields, setClass('ml-6'));
formRow
(
    formGroup
    (
        set::label($lang->rule->field),
        picker
        (
            on::change('changeFields'),
            set::name('fields'),
            set::value($selectedFields),
            set::items($fieldPairs),
            set::multiple(true)
        )
    ),
    formHidden('requiredFields', implode(',', $requiredFields))
);

foreach($fields as $field)
{
    $control  = $this->flow->buildFormControl($field);
    $hidden   = strpos($selectedFields, $field->field) === false;
    if($control['control'] == 'radioList') $control['control'] = 'picker';

    formRow
    (
        $hidden ? setClass('hidden') : null,
        formGroup
        (
            $field->field == 'module' && $objectType == 'task' ? on::change('loadModuleStories') : null,
            $field->field == 'parent' && $objectType == 'project' ? on::change('loadSubAclList') : null,
            $field->field == 'project'   ? on::change('loadProjectRelation') : null,
            $field->field == 'execution' ? on::change('loadExecutionRelation') : null,
            set::name($field->field),
            set::label($field->name),
            set::control($control),
            set::multiple(!empty($field->multiple)),
            isset($field->value) ? set::value($field->value) : null,
            isset($field->options) ? set::items(array_filter($field->options)) : null
        ),
        in_array($control['control'], array('input', 'textarea', 'editor')) && !in_array($field->field, array('estimate', 'budget')) ? dropdown
        (
            btn
            (
                icon('copy'),
                set::hint($lang->rule->copyField),
                setClass("copy-field-btn {$control['control']}")
            ),
            set::items($fieldItems),
            set::caret(false),
            set::flip(true),
            set::placement('left-start'),
            set::strategy('absolute'),
            set::hasIcons(true),
            set::menuClass("copy-fields-menu $field->field"),
            set::menu(array
            (
                'header' => $lang->rule->objectList[$fromObjectType] . $lang->rule->field,
                'onClickItem' => jsRaw("copyField")
            )),
            set::trigger('click')
        ) : null
    );
}
