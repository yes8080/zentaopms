<?php
/**
 * The ajaxloadeditform file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

$fieldItems = array();
foreach($sourceFields as $field => $name)
{
    if(!$field) continue;
    $fieldItems[] = array('text' => $name, 'key' => "{{{$fromObjectType}.{$field}}}", 'icon' => 'copy');
}

jsVar('dropHeader', $lang->rule->objectList[$fromObjectType] . $lang->rule->field);
jsVar('fromObjectType', $fromObjectType);
jsVar('fieldItems', json_encode($fieldItems));
h4($lang->rule->selectObject, setClass('ml-6'));
formRow
(
    formGroup
    (
        set::label($lang->rule->relation),
        set::width('1/2'),
        set::required(true),
        picker
        (
            on::change('changeRelation'),
            set::name('relation'),
            set::value($relation),
            set::items($relations)
        )
    )
);

formRow
(
    formGroup
    (
        set::label($lang->rule->objectType),
        set::width('1/2'),
        set::required(true),
        picker
        (
            on::change('changeModule'),
            $module ? set::items($modules) : null,
            set::value($module),
            set::name('module')
        )
    )
);

h4($lang->rule->editField, setClass('ml-6'));

if($module)
{
    if(!empty($fields))
    {
        $i = 0;
        foreach($fields as $field => $value)
        {
            $i ++;
            $currentField = $fieldList[$field];
            $control      = $this->flow->buildFormControl($currentField);

            if(in_array($control['control'], array('radioList', 'checkList')))
            {
                $control['control'] = 'picker';
            }
            elseif($control['control'] == 'editor')
            {
                $control['control'] = 'input';
            }


            $invisible = $i > 1 ? '' : 'invisible';
            formRow
            (
                setClass('field-group'),
                formGroup
                (
                    set::label($lang->rule->field),
                    inputGroup
                    (
                        picker
                        (
                            set::name('fields[]'),
                            set::items($fieldPairs),
                            set::value($field),
                            on::change('changeField')
                        ),
                        $lang->rule->modify,
                        div
                        (
                            setClass('valueBox form-group-wrapper'),
                            control
                            (
                                set::type($control['control']),
                                set::name('values[]'),
                                isset($currentField->options) ? set::items($currentField->options) : null,
                                set::value($value)
                            ),
                            in_array($control['control'], array('input','textarea')) && !in_array($field, array('budget', 'estimate')) ? dropdown
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
                                set::menuClass("copy-fields-menu"),
                                set::menu(array
                                (
                                    'header' => $lang->rule->objectList[$fromObjectType] . $lang->rule->field,
                                    'onClickItem' => jsRaw("copyField")
                                )),
                                set::trigger('click')
                            ) : null
                        )
                    ),
                    btnGroup
                    (
                        setClass('ml-2'),
                        btn
                        (
                            bind::click('addRow(event)'),
                            setClass('btn btn-link text-gray btn-add'),
                            icon('plus')
                        ),
                        btn
                        (
                            bind::click('removeRow(event)'),
                            setClass("btn btn-link text-gray btn-delete $invisible"),
                            icon('trash')
                        )
                    )
                )
            );
        }
    }
    else
    {
        formRow
        (
            setClass('field-group'),
            formGroup
            (
                set::label($lang->rule->field),
                inputGroup
                (
                    picker
                    (
                        set::name('fields[]'),
                        set::items($fieldPairs),
                        on::change('changeField')
                    ),
                    $lang->rule->modify,
                    div
                    (
                        setClass('valueBox form-group-wrapper'),
                        control
                        (
                            set::type('input'),
                            set::name('values[]')
                        )
                    )
                ),
                btnGroup
                (
                    setClass('ml-2'),
                    btn
                    (
                        bind::click('addRow(event)'),
                        setClass('btn btn-link text-gray btn-add'),
                        icon('plus')
                    ),
                    btn
                    (
                        bind::click('removeRow(event)'),
                        setClass("btn btn-link text-gray btn-delete invisible"),
                        icon('trash')
                    )
                )
            )
        );
    }
}
else
{
    formRow
    (
        setClass('field-group'),
        formGroup
        (
            set::label($lang->rule->field),
            inputGroup
            (
                picker
                (
                    set::name('fields[]'),
                    on::change('changeField')
                ),
                $lang->rule->modify,
                div
                (
                    setClass('valueBox form-group-wrapper'),
                    input
                    (
                        set::name('values[]')
                    )
                )
            ),
            btnGroup
            (
                setClass('ml-2'),
                btn
                (
                    bind::click('addRow(event)'),
                    setClass('btn btn-link text-gray btn-add'),
                    icon('plus')
                ),
                btn
                (
                    bind::click('removeRow(event)'),
                    setClass('btn btn-link text-gray btn-delete invisible'),
                    icon('trash')
                )
            )
        )
    );
}
