<?php
/**
 * The design file of approval module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     approval
 * @link        https://www.zentao.net
 */
namespace zin;

if(isset($conditionFields['budgetUnit']))                      unset($conditionFields['budgetUnit']);
if(isset($conditionFields['code']) && empty($config->setCode)) unset($conditionFields['code']);

$nodeType = $node ? $node->type : '';
$renderNode = function($node, $count = 1) use($rule, $actionPairs, $conditionFields, $conditionFieldList, $relationList)
{
    global $lang;

    $objectType = $rule->objectType;
    $hasError   = ($objectType && !empty($node->fromObjectType) && $objectType != $node->fromObjectType) ? 'has-error wait' : '';
    $title      = $lang->rule->titleList[$node->type];
    $status     = !empty($node->data) ? 'normal' : 'wait';
    if(!isset($node->id)) $node->id = uniqid("{$node->type}_");

    $notice = '';
    if(!empty($node->data))
    {
        switch($node->type)
        {
            case 'when':
                $notice .= $lang->rule->when . $lang->rule->objectList[$objectType] . $actionPairs[$objectType][$node->data->action] . $lang->rule->after;
                break;
            case 'condition':
                foreach($node->data as $condition)
                {
                    if(!empty($condition->noCondition))
                    {
                        $notice .= $lang->rule->notice->noCondition;
                        continue;
                    }
                    elseif(isset($conditionFields[$condition->conditionField]) && $node->fromObjectType == $objectType)
                    {
                        $conditionValue = !empty($conditionFieldList[$condition->conditionField]->options) ? zget($conditionFieldList[$condition->conditionField]->options, $condition->conditionValue, $condition->conditionValue) : $condition->conditionValue;
                        $notice .= $conditionFields[$condition->conditionField] . $lang->workflowcondition->operatorList[$condition->conditionOperator] . $conditionValue . '<br>';
                    }
                }
                break;
            case 'action':
                if($node->method == 'notify')
                {
                    $notice .= $lang->rule->actionList[$node->method];
                }
                else
                {
                    $notice .= $lang->rule->actionList[$node->method] . '：' . $lang->rule->objectList[$node->module];
                    if($node->method == 'edit' || $node->method == 'delete')
                    {
                        $notice .= '<br>' . $lang->rule->relation . '：' . $relationList[$node->relation];
                    }
                }
                break;
        }
    }

    return div
    (
        setClass("editor-node {$node->type} {$status} {$hasError}"),
        setData('id', $node->id),
        div
        (
            setClass('editor-node-container'),
            div
            (
                setClass('node-title'),
                div
                (
                    setClass('node-title-name text-ellipsis'),
                    set::title($title),
                    $title
                )
            ),
            div
            (
                setClass('node-content'),
                setData(array('on' => 'click', 'call' => 'clickNode', 'params' => 'event')),
                set::title($title),
                div
                (
                    setClass('node-detail'),
                    div
                    (
                        setClass('node-detail-item'),
                        html($notice)
                    )
                )
            ),
            $count > 1 ? icon('close', setClass('delete-btn iconfont-approval-admin'), setData(array('on' => 'click', 'call' => 'deleteNode', 'params' => 'event'))) : null
        ),
        div
        (
            div(setClass('bottom-v-line')),
            div
            (
                setClass('add-node-btn'),
                setData(array('on' => 'click', 'call' => $node->type == 'when' ? 'addCondition' : 'addAction', 'params' => 'event')),
                div
                (
                    setClass('add-btn'),
                    icon('plus', setClass('add-btn-icon iconfont-approval-admin')),
                    $node->type == 'when' ? $lang->rule->branchList['condition'] :  $lang->rule->branchList['action']
                )
            )
        )
    );
};

$renderNodes = function($nodes) use(&$renderNodes, &$renderNode, $lang)
{
    $editorNodes = array();
    foreach($nodes as $node)
    {
        if($node->type == 'conditions')
        {
            $branchesHTML = array();
            $isSingle     = !(count($node->data) > 1);
            $count        = count($node->data);
            foreach($node->data as $branch)
            {
                $branchesHTML[] = div
                (
                    setData('id', $node->type),
                    setClass("editor-node {$node->type}"),
                    $isSingle ? null : setClass('branch'),
                    div(setClass('top-line-mask')),
                    div(setClass('top-v-line')),
                    div
                    (
                        setClass('nodes'),
                        $renderNode($branch->condition, $count),
                        $renderNodes(array($branch->actions)),
                    ),
                );
            }

            $editorNodes[] = div
            (
                setClass('editor-node'),
                $isSingle ? null : setClass('route'),
                $isSingle ? null : div(setClass('top-h-line text-center'), span(setClass('text-gray-500 branch-tip'), $lang->rule->notice->multiConditions)),
                div(setClass('add-condition')),
                div(setClass('branches'), $branchesHTML)
            );
        }
        if($node->type == 'actions')
        {
            $count = count($node->data);
            foreach($node->data as $branch) $editorNodes[] = $renderNode($branch, $count);
        }
        elseif($node->type == 'when')
        {
            $editorNodes[] = $renderNode($node);
        }
    }

    return $editorNodes;
};

$renderNodeForm = function($nodeType) use($lang, $flows, $actionGroup, $rule, $conditionFields, $node)
{
    if($nodeType == 'when')
    {
        $form = formPanel
        (
            set::layout('grid'),
            set::actions(array('submit' => array('text' => $lang->save, 'class' => 'primary', 'data-on' => 'click', 'data-call' => "save$nodeType", 'data-params' => 'event'))),
            formGroup
            (
                set::label($lang->rule->objectType),
                set::width('1/2'),
                inputGroup
                (
                    $lang->rule->when,
                    picker
                    (
                        set::name('objectType'),
                        set::items($flows),
                        set::value($rule->objectType),
                        setData(array('on' => 'change', 'call' => 'changeObjectType', 'params' => 'event'))
                    )
                )
            ),
            formGroup
            (
                set::label($lang->rule->actionName),
                set::width('1/2'),
                inputGroup
                (
                    picker
                    (
                        set::name('action'),
                        set::items(zget($actionGroup, $rule->objectType, array())),
                        set::value($rule->action)
                    ),
                    $lang->rule->after
                )
            )
        );
    }
    elseif($nodeType == 'condition')
    {
        $form = formBatch
        (
            set::actions(array('submit' => array('text' => $lang->save, 'class' => 'primary', 'data-on' => 'click', 'data-call' => "save$nodeType", 'data-params' => 'event', 'data-id' => isset($node->id) ? $node->id : $node->type))),
            set::actionsWidth('64px'),
            set::mode('add'),
            set::minRows(1),
            !empty($node->data) ? set::data(array_values((array)$node->data)) : null,
            set::onRenderRow(jsRaw('renderConditionRowData')),
            formBatchItem
            (
                set::width('1/5'),
                set::name('conditionLogical'),
                set::control(array('control' => 'picker', 'required' => true)),
                set::items($lang->workflowcondition->logicalOperatorList),
                set::value('or')
            ),
            formBatchItem
            (
                set::width('1/2'),
                set::label($lang->rule->field),
                set::name('conditionField'),
                set::control(array('control' => 'picker', 'required' => true, 'data-on' => 'change', 'data-call' => 'changeConditionField', 'data-params' => 'event')),
                set::items($conditionFields)
            ),
            formBatchItem
            (
                set::width('1/6'),
                set::name('conditionOperator'),
                set::control(array('control' => 'picker', 'required' => true)),
                set::value('equal'),
                set::items($lang->workflowcondition->operatorList)
            ),
            formBatchItem
            (
                set::width('1/2'),
                set::label($lang->rule->value),
                set::name('conditionValue')
            )
        );
    }
    elseif($nodeType == 'action')
    {
        $form = formPanel
        (
            set::actions(array('submit' => array('text' => $lang->save, 'class' => 'primary', 'data-on' => 'click', 'data-call' => "save$nodeType", 'data-params' => 'event', 'data-id' => isset($node->id) ? $node->id : $node->type))),
            formGroup
            (
                set::label($lang->rule->actionName),
                radioList
                (
                    setData(array('on' => 'change', 'call' => 'changeMethod', 'params' => 'event')),
                    set::name('method'),
                    set::items($lang->rule->actionList),
                    set::inline(true),
                    set::value(isset($node->method) ? $node->method : 'create')
                )
            ),
            div
            (
                setClass('newForm'),
                formGroup
                (
                    set::hidden(isset($node->method) && $node->method != 'create'),
                    set::label($lang->rule->objectType),
                    set::width('1/2'),
                    set::required(true),
                    picker
                    (
                        set::name('objectType'),
                        set::items($flows),
                        set::value(isset($node->module) ? $node->module : ''),
                        setData(array('on' => 'change', 'call' => 'loadObjectForm', 'params' => 'event'))
                    )
                ),
                div(setClass('newFormBody flex col gap-4')),
            )
        );
    }

    return $form;
};

jsVar('ruleID', $rule->id);
jsVar('ruleObjectType', $rule->objectType);
jsVar('ruleAction', $rule->action);
jsVar('defaultCondition', $config->rule->defaultNodes[1]['data'][0]);
jsVar('defaultAction', $config->rule->defaultNodes[1]['data'][0]['actions']['data'][0]);
jsVar('errorLang', $lang->rule->error);
jsVar('noticeLang', $lang->rule->notice);
jsVar('link', inlink('design', "id={$rule->id}"));
jsVar('+actionGroup', json_encode($actionGroup));

$btnClass = isInModal() ? 'mr-4' : '';
detailHeader
(
    to::title
    (
        entityLabel
        (
            set::entityID($rule->id),
            set::level(1),
            set::text($rule->name)
        )
    ),
    to::suffix
    (
        btn
        (
            setClass("btn primary $btnClass"),
            set::icon('save'),
            setData(array('on' => 'click', 'call' => "$('#editorForm [type=submit]').trigger('click')")),
            $lang->save
        )
    )
);

div
(
    formPanel
    (
        setID('editorForm'),
        set::ajax(array('beforeSubmit' => jsRaw('clickSubmit'))),
        set::size('full'),
        set::width('auto'),
        set::actionsClass('hidden'),
        div
        (
            setID('graph'),
            div
            (
                setID('editor'),
                setClass('editor-node branch'),
                div
                (
                    setID('root'),
                    setClass('nodes')
                ),
                $renderNodes($rule->nodes),
                formHidden('type', 'save'),
                formHidden('nodes', json_encode($rule->nodes)),
                formHidden('currentNode', json_encode($node))
            )
        )
    ),
    modal
    (
        setID('modal'),
        set::title($nodeType ? $lang->rule->titleList[$nodeType] : ''),
        !empty($nodeType) ? $renderNodeForm($nodeType) : div()
    )
);
