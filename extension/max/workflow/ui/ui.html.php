<?php
/**
 * The ui view file of workflow module of ZenTaoPMS.
 * @copyright   Copyright 2026 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Hao Sun <sunhao@chandao.com>
 * @package     workflow
 * @link        https://www.zentao.net
 */
namespace zin;

include 'ui.header.html.php';

$isBuildIn      = !empty($currentAction->buildin) && $currentAction->extensionType == 'extend';
$pageItems      = [];
$otherPageItems = [];
foreach($actions as $action)
{
    $item = [];
    $item['url']  = inlink('ui', "module={$flow->module}&action={$action->action}&groupID={$groupID}");
    $item['text'] = $action->name;
    $item['type'] = $action->action == $currentAction->action ? 'secondary' : 'default';

    if($action->action == 'create')     $pageItems['create'] = $item;
    elseif($action->action == 'edit')   $pageItems['edit']   = $item;
    elseif($action->action == 'browse') $pageItems['browse'] = $item;
    else $otherPageItems[] = $item;
}

switch($currentAction->action)
{
    case 'browse':
        $uiMode = 'browse';
        break;
    case 'view':
        $uiMode = 'view';
        break;
    case 'edit':
        $uiMode = 'detailform';
        break;
    case 'create':
        $uiMode = 'form';
        break;
    case 'copy':
        $uiMode = 'form';
        break;
    default:
        $uiMode = 'form-horz';
        break;
}

if($currentAction->type == 'batch') $uiMode = $currentAction->batchMode == 'different' ? 'batchform' : 'form-horz';
if(empty($currentAction->buildin) && $uiMode == 'form-horz') $uiMode = 'form';
if($flow->module == 'feedback' && ($currentAction->action == 'create' || $currentAction->action == 'edit')) $uiMode = 'form-horz';
if(!$flow->buildin || in_array($flow->module, array('risk', 'issue')) && $currentAction->action == 'edit') $uiMode = 'form';

$innerFields        = [];
$customFields       = [];
$showFields         = [];
$buildInDataSources = [];
$buildinFields      = [];

unset($lang->workflowfield->controlTypeList['label']);
foreach($lang->workflowfield->controlTypeList as $key => $name)
{
    if($uiMode === 'batchform' && $key === 'file') continue;
    $customFields[] = ['name' => $key, 'label' => $name];
}

$processField = function($field) use (&$innerFields, &$showFields, $uiMode, $isBuildIn, $flow)
{
    $internal = false;
    if(!$isBuildIn) $internal = false;
    elseif(isset($field->internal)) $internal = !empty($field->internal);
    elseif(isset($field->role) && $field->role == 'buildin')  $field->buildin = true;

    $control = $field->control === 'fileSelector' ? 'file' : $field->control;
    if($control === 'editor') $control = 'richtext';

    $item = [];
    $item['id']           = $field->id ?? 0;
    $item['name']         = $field->field;
    $item['type']         = $field->role == 'buildin' ? 'inner' : 'custom';
    $item['label']        = $field->name;
    $item['control']      = $control;
    $item['internal']     = $internal;
    $item['readonly']     = $field->readonly  == '1';
    $item['defaultValue'] = $field->defaultValue;
    $item['items']        = $field->optionsData;
    $item['required']     = !empty($field->required) ? $field->required : 0;
    $item['placeholder']  = isset($field->placeholder) ? $field->placeholder : '';
    $item['dataType']     = $field->type;
    $item['width']        = (empty($field->width) || $field->width == 'auto') ? 6 : $field->width;
    $item['sql']          = isset($field->sql) ? $field->sql : '';
    $item['dataLength']   = $field->length;
    $item['datasource']   = !empty($field->options) ? $field->options : 0;
    $item['layoutRules']  = empty($field->layoutRules) ? '' : strval($field->layoutRules);
    $item['order']        = !empty($field->order)    ? $field->order : 0;
    $item['position']     = !empty($field->position) ? $field->position : 'info';
    $item['group']        = !empty($field->block)    ? $field->block : '';
    $item['buildin']      = $field->buildin;
    $item['foldable']     = !empty($field->foldable)   ? $field->foldable   : 0;
    $item['wrapBefore']   = !empty($field->wrapBefore) ? $field->wrapBefore : 0;
    $item['wrapAfter']    = !empty($field->wrapAfter)  ? $field->wrapAfter  : 0;
    $item['expression']   = !empty($field->expression) ? $field->expression : '';
    $item['_data']        = $field;

    /* The designer uses module-free local references; saving restores the module. */
    if($control === 'formula' && $item['expression'] !== '')
    {
        $expression = json_decode($item['expression']);
        if(is_array($expression))
        {
            foreach($expression as $token)
            {
                if(!is_object($token) || ($token->type ?? '') !== 'target' || ($token->module ?? '') !== $flow->module || property_exists($token, 'function')) continue;
                unset($token->module);
            }
            $item['expression'] = json_encode($expression);
        }
    }

    if(!$isBuildIn && ($internal || $field->buildin)) $item['customAction'] = true;
    if($isBuildIn && !$internal && $field->buildin)   $item['customAction'] = true;

    if($uiMode == 'detailform') $item['width'] = 12;
    if($uiMode == 'batchform')  $item['width'] = 0;

    if($field->show != '0') $showFields[$field->field]  = $item;
    else                    $innerFields[$field->field] = $item;
};

$getBuildInControl = function(array $buildInField): string
{
    $rawControl = zget($buildInField, 'control', 'input');
    if(is_callable($rawControl) && $buildInField['name'] === 'files') return 'file';
    $control = is_array($rawControl) ? zget($rawControl, 'control', 'input') : $rawControl;
    if(!is_string($control) || empty($control)) $control = 'input';
    if($control === 'datePicker' || $control === 'timePicker' || $control === 'datetimePicker') return str_replace('Picker', '', $control);
    if(substr(strtolower($control), -6) === 'picker') return 'select';

    if($control === 'inputGroup' && is_array(zget($buildInField, 'items')))
    {
        foreach($buildInField['items'] as $item)
        {
            $itemControl = is_array($item) ? zget($item, 'control') : '';
            if(is_array($itemControl)) $itemControl = zget($itemControl, 'control', '');
            if(is_string($itemControl) && substr(strtolower($itemControl), -6) === 'picker') return 'select';
        }
    }

    return $control;
};

if($isBuildIn)
{
    $moduleName = $flow->module;
    $methodName = $currentAction->action;
    if(!empty($config->workflow->multiLayout[$moduleName][$methodName])) list($moduleName, $methodName) = explode('|', $config->workflow->multiLayout[$moduleName][$methodName]);

    if($uiMode == 'batchform')
    {
        $action        = $currentAction->action == 'showimport' ? 'showimport' : "batch" . ucfirst(substr($currentAction->action, 5));
        $formConfig    = $config->{$flow->module}->form;
        $buildinFields = isset($formConfig->{$action}) ? $formConfig->{$action} : (isset($formConfig->{strtolower($action)}) ? $formConfig->{strtolower($action)} : array());

        foreach($buildinFields as $name => $buildInField)
        {
            if($uiMode == 'batchform' && isset($buildInField['layout']) && empty($buildInField['layout'])) unset($buildinFields[$name]);
        }
    }
    else
    {
        contextBegin('workflow-ui.buildinFields');
        loadFields($moduleName, $methodName);
        $buildinModule = useFields("$moduleName.$methodName");
        contextEnd();

        $buildinFields = $buildinModule->fields;
    }

    $orderFields = array_flip(array_keys($buildinFields));
    foreach($buildinFields as $name => $buildInField)
    {
        $buildInField = $uiMode == 'batchform' ? $buildInField : $buildInField->toArray();

        /* Skip fields that do not need custom UI: */
        if(!empty($buildInField['skipCustomUI'])) continue;

        $field = empty($fields[$name]) ? new \stdClass() : $fields[$name];
        if(in_array($name, zget($config->workflow->layoutFields, $flow->module, array())))
        {
            $field->field        = $name;
            $field->role         = 'buildin';
            $field->buildin      = '1';
            $field->type         = 'varchar';
            $field->length       = 30;
            $field->module       = $flow->module;
            $field->expression   = '';
            $field->canExport    = '0';
            $field->canSearch    = '0';
            $field->isValue      = '0';
            $field->readonly     = '0';
            $field->mobileShow   = '0';
            $field->summary      = '';
            $field->defaultValue = '';
            $field->rules        = '';
            $field->layoutRules  = '';
            $field->id           = 0;
            $field->required     = 0;
            $field->name         = !empty($buildInField['label']) ? $buildInField['label'] : zget($lang->{$flow->module}, $name, $name);
        }

        if(empty($field->field)) continue;

        $field->internal = true;
        $field->order    = isset($field->order) && !empty($field->show) && !empty($actionFields) ? $field->order : $orderFields[$name];
        $field->show     = '1';

        $field->control = $getBuildInControl($buildInField);
        if(empty($field->width))    $field->width    = null;
        if(empty($field->position)) $field->position = null;

        $field->required = (!isset($buildInField['required']) || $buildInField['required'] === 'auto') ? isFieldRequired($name, null, $moduleName, $methodName) : $buildInField['required'];

        $buildInProps = ['width' => 'width', 'readonly' => 'readonly', 'label' => 'name', 'placeholder' => 'placeholder', 'items' => 'optionsData', 'foldable' => 'foldable', 'wrapBefore' => 'wrapBefore', 'wrapAfter' => 'wrapAfter', 'position' => 'position', 'group' => 'block'];
        foreach($buildInProps as $prop => $fieldProp)
        {
            if((!isset($field->$fieldProp) || is_null($field->$fieldProp)))
            {
                if($prop == 'width' && isset($buildInField[$prop]))
                {
                    if(empty($buildInField[$prop]))
                    {
                        $field->$fieldProp = 6;
                    }
                    elseif($buildInField[$prop] == 'full')
                    {
                        $field->$fieldProp = 12;
                    }
                    elseif(strpos($buildInField[$prop], '/') !== false)
                    {
                        list($num, $den) = explode('/', $buildInField[$prop]);
                        $field->$fieldProp = ($num / $den) * 12;
                    }
                }
                else
                {
                    $field->$fieldProp = isset($buildInField[$prop]) ? $buildInField[$prop] : '';
                }
            }
        }

        $processField($field);
    }
}

$actionMethod = $currentAction->method;
if($currentAction->module == 'product' && in_array($currentAction->method, array('requirement', 'epic'))) $actionMethod = 'browse';
if($currentAction->module == 'caselib' && $currentAction->action == 'editCase') $actionMethod = 'edit';
$disabledFields = in_array($actionMethod, $config->workflowaction->defaultActions) ? zget($config->workflowlayout->disabledFields, $actionMethod, '') : $config->workflowlayout->disabledFields['custom'];

$order = 1000;
foreach($fields as $field)
{
    if(($currentAction->type != 'batch' || $currentAction->batchMode != 'different') && strpos(",{$disabledFields},", ",{$field->field},") !== false) continue;
    if(($currentAction->type == 'batch' || $currentAction->method == 'showimport' || $currentAction->method == 'browse') && !$field->buildin && in_array($field->control, array('richtext', 'file'))) continue;
    if($currentAction->method == 'batchcreate' && $field->field == 'id') continue;

    if(empty($field->order)) $field->order = $order ++;
    if(isset($showFields[$field->field])) continue; // 内置的需要显示的字段都已经处理过了。
    $processField($field);
}

$bindFields = zget($config->workflow->bindFields, $flow->module, array());
foreach(zget($bindFields, $currentAction->action, array()) as $bindField)
{
    unset($innerFields[$bindField]);
    unset($showFields[$bindField]);
}

foreach($datasources as $sourceType => $name) $buildInDataSources[] = ['value' => $sourceType, 'text' => $name];

$layoutRules = [];
foreach($rules as $rule => $ruleText) $layoutRules[] = ['text' => $ruleText, 'value' => $rule];

$formulaTargets = [];
if(!$flow->parent)
{
    $subTables = $this->loadModel('workflow', 'flow')->getPairs($flow->module);
    foreach($subTables as $subModule => $tableName)
    {
        $subFields = $this->workflowfield->getNumberFields($subModule, true);
        foreach($subFields as $fieldCode => $fieldName)
        {
            foreach($lang->workflowfield->formula->functions as $function => $label)
            {
                $formulaTargets[] = [
                    'type'     => 'target',
                    'module'   => $subModule,
                    'field'    => $fieldCode,
                    'function' => $function,
                    'text'     => sprintf($label, $tableName, $fieldName)
                ];
            }
        }
    }
}

div
(
    setID('editorPages'),
    setClass('canvas shadow ring rounded p-3 border-t mb-3'),
    toolbar
    (
        setClass('flex-wrap'),
        set::gap(3),
        set::size('sm'),
        set::items(array_merge
        (
            empty($pageItems['create']) ? [] : [$pageItems['create']],
            empty($pageItems['edit']) ?   [] : [$pageItems['edit']],
            empty($pageItems['browse']) ? [] : [$pageItems['browse']],
            $otherPageItems
        ))
    )
);

if($currentAction->buildin && $currentAction->extensionType != 'extend')
{
    panel
    (
        setClass('center py-6'),
        $lang->workflow->tips->notCustomLayout,
        a(setClass('btn size-sm primary'), setData(array('toggle' => 'modal')), set::href(createLink('workflowaction', 'edit', "id={$currentAction->id}")), $lang->workflowaction->extensionTypeList['extend'])
    );
}
else
{
    div
    (
        style::height('calc(100vh - 176px)'),
        zui::formDesigner
        (
            set::_id('formDesigner'),
            set::_class('h-full'),
            setClass('h-full'),
            set::uiMode($uiMode),
            set::foldable(in_array($currentAction->module, array('requirement', 'story', 'epic', 'task', 'bug')) && in_array($currentAction->action, array('create', 'copy'))),
            set::innerFields(array_values($innerFields)),
            set::customFields($customFields),
            set::defaultFields(array_values($showFields)),
            set::formulaTargets($formulaTargets),
            set::buildInDataSources($buildInDataSources),
            set::flowModule($flow->module),
            set::flowBelong($flow->belong),
            set::flowAction($currentAction->action),
            set::tips($lang->workflowfield->tips),
            set::groupID($groupID),
            set::layoutRules($layoutRules),
            set::ruleMap($ruleMap),
            set::leavePageTip($lang->workfloweditor->leavePageTip),
            set::yesText($lang->workfloweditor->yes),
            set::noText($lang->workfloweditor->no),
            set::onFieldsChange(jsRaw('() => {const formDesigner = getFormDesigner(); if(formDesigner) formDesigner.fieldsChanged = true;}')),
            set('$options', jsRaw('window.setFormDesignerOptions'))
        )
    );
}
