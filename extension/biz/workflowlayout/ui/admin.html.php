<?php
namespace zin;

modalHeader(set::title($title . ' - ' . $action->name));

$items = array();
foreach($uiPairs as $id => $label)
{
    $active = $id == $ui ? 'active' : '';
    $items[] = li
    (
        setClass('nav-item'),
        a
        (
            setClass($active),
            set::href(inlink('admin', "module={$action->module}&action={$action->action}&mode=edit&ui={$id}")),
            $label,
            set(array('data-load' => 'modal', 'data-size' => 'lg'))
        )
    );
}

$featureBar = featureBar($items);

$toolbar = null;
if(!isset($emptyCustomFields))
{
    $canAddUI = common::hasPriv('workflowlayout', 'addUI');
    if($action->type == 'batch') $canAddUI = false;
    if(!in_array($action->method, array('edit', 'operate', 'view'))) $canAddUI = false;
    if($canAddUI)
    {
        $toolbar = toolbar(
            btn
            (
                set::type('primary'),
                set::btnType('button'),
                set::url(inlink('addUI', "module={$action->module}&action={$action->action}")),
                icon('plus'),
                $lang->workflowlayout->addUI,
                set(array('data-load' => 'modal', 'data-size' => 'md'))
            )
        );
    }
}

div(set::id('mainMenu'), $featureBar, $toolbar);

$module      = $action->module;
$actionParam = $action->action;
$saveURL     = createLink('workflowlayout', 'admin', "module={$module}&action={$actionParam}&mode=edit&ui={$ui}");

jsVar('saveURL', $saveURL);
jsVar('create', $lang->create);

$actionMethod = $action->method;
if($action->module == 'product' && in_array($action->method, array('requirement', 'epic'))) $actionMethod = 'browse';
if($action->module == 'caselib' && $action->action == 'editCase') $actionMethod = 'edit';

$layoutScene    = in_array($actionMethod, array('browse', 'view')) ? $actionMethod : 'form';
$disabledFields = in_array($actionMethod, $config->workflowaction->defaultActions) ? zget($config->workflowlayout->disabledFields, $actionMethod, '') : $config->workflowlayout->disabledFields['custom'];
$disabledSub    = $config->workflowlayout->disabledFields['subTables'];

$uiMode = 'form-horz';
switch($action->action)
{
    case 'browse': $uiMode = 'browse';     break;
    case 'view':   $uiMode = 'view';       break;
    case 'edit':   $uiMode = 'detailform'; break;
    case 'create':
    case 'copy':   $uiMode = 'form';       break;
}
if($action->type == 'batch') $uiMode = $action->batchMode == 'different' ? 'batchform' : 'form-horz';
if(empty($action->buildin) && $uiMode == 'form-horz') $uiMode = 'form';
if($flow->module == 'feedback' && in_array($action->action, array('create', 'edit'))) $uiMode = 'form-horz';
if(!$flow->buildin || (in_array($flow->module, array('risk', 'issue')) && $action->action == 'edit')) $uiMode = 'form';

$requiredFields = zget($config->workflowlayout->default->required, $action->action, array());
if($flow->approval == 'enabled') $requiredFields = array_merge($requiredFields, zget($config->workflowlayout->approval->required, $action->action, array()));

$summaryPickerItems = array();
foreach($lang->workflowlayout->summaryList as $summaryKey => $summaryLabel)
{
    if(!$summaryKey) continue;
    $summaryPickerItems[] = array('text' => (string) $summaryLabel, 'value' => (string) $summaryKey);
}

$getDefaultOptions = function ($field): array
{
    $items  = array();
    if(!empty($field->options))
    {
        foreach($field->options as $k => $label)
        {
            if(!$k) continue;
            $items[] = array('text' => (string) $label, 'value' => (string) $k);
        }
    }
    return $items;
};

$rows       = array();
$checkedIds = array();
if($flow->buildin && in_array($flow->module, $config->workflow->uiFlow))
{
    $moduleName = $flow->module;
    $methodName = $action->action;
    if(!empty($config->workflow->multiLayout[$moduleName][$methodName])) list($moduleName, $methodName) = explode('|', $config->workflow->multiLayout[$moduleName][$methodName]);

    if($action->type == 'batch' && $action->batchMode == 'different')
    {
        $actionCode    = $action->action == 'showimport' ? 'showimport' : "batch" . ucfirst(substr($action->action, 5));
        $formConfig    = $config->{$flow->module}->form;
        $buildinFields = isset($formConfig->{$actionCode}) ? $formConfig->{$actionCode} : (isset($formConfig->{strtolower($actionCode)}) ? $formConfig->{strtolower($actionCode)} : array());

        foreach($buildinFields as $name => $buildInField)
        {
            if($action->type == 'batch' && $action->batchMode == 'different' && isset($buildInField['layout']) && empty($buildInField['layout'])) unset($buildinFields[$name]);
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
}

if($flow->buildin && in_array($flow->module, $config->workflow->uiFlow) && empty($actionFields))
{
    $positionList = array('info' => $this->lang->workflowlayout->positionList['view']['info'] . "(" . $this->lang->workflowlayout->positionList['edit']['info'] . ")");
    $orderFields  = array_flip(array_keys($buildinFields));

    foreach($buildinFields as $name => $buildInField)
    {
        $buildInField = $action->type == 'batch' && $action->batchMode == 'different' ? $buildInField : $buildInField->toArray();
        if(!empty($buildInField['skipCustomUI']))
        {
            unset($buildinFields[$name]);
            continue;
        }

        $field = empty($fields[$name]) ? new \stdClass() : $fields[$name];

        if(in_array($name, zget($config->workflow->layoutFields, $flow->module, array())))
        {
            $field->field        = $name;
            $field->role         = 'buildin';
            $field->buildin      = '1';
            $field->type         = 'varchar';
            $field->length       = 30;
            $field->module       = $flow->module;
            $field->group        = $flow->group;
            $field->expression   = '';
            $field->canExport    = '0';
            $field->canSearch    = '0';
            $field->isValue      = '0';
            $field->position     = '';
            $field->readonly     = '0';
            $field->mobileShow   = '0';
            $field->summary      = '';
            $field->defaultValue = '';
            $field->rules        = '';
            $field->layoutRules  = '';
            $field->id           = 0;
            $field->name         = !empty($buildInField['label']) ? $buildInField['label'] : zget($lang->{$flow->module}, $name, $name);
        }

        if(empty($field->field)) continue;

        $field->order = isset($field->order) && !empty($actionFields) ? $field->order : $orderFields[$name];
        $field->show  = '1';

        $control = !empty($buildInField['control']) && is_string($buildInField['control']) ? $buildInField['control'] : 'input';
        if($control === 'remotepicker' || $control === 'select') $control = 'select';
        $field->control = $control;
        if(empty($field->width))    $field->width    = null;
        if(empty($field->position)) $field->position = null;

        $buildInProps = ['width' => 'width', 'readonly' => 'readonly', 'label' => 'name', 'placeholder' => 'placeholder', 'items' => 'optionsData', 'foldable' => 'foldable', 'wrapBefore' => 'wrapBefore', 'wrapAfter' => 'wrapAfter', 'position' => 'position', 'group' => 'block'];
        foreach($buildInProps as $prop => $fieldProp)
        {
            if((!isset($field->$fieldProp) || is_null($field->$fieldProp)))
            {
                if($prop == 'width')
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

        $row = clone $field;
        $row->id                = $field->field;
        $row->parent            = 0;
        $row->rowKind           = 'main';
        $row->ditto             = zget($field, 'ditto',    '0');
        $row->width             = $action->layout == 'side' ? 12 : zget($field, 'width', 6);
        $row->readonly          = zget($field, 'readonly', '0');
        $row->position          = zget($field, 'position', '');
        $row->summary           = zget($field, 'summary',  '');
        $row->defaultValue      = zget($field, 'defaultValue', '');
        $row->defaultValueItems = $getDefaultOptions($field);
        $row->buildin           = !empty($field->buildin) ? "<i class='icon-check text-success'></i>" : "<i class='icon-close text-danger'></i>";
        $row->skipFormExtras    = $layoutScene == 'form' && is_numeric($row->id);
        $row->summaryEligible   = $layoutScene == 'browse' && in_array($field->type, $config->workflowfield->numberTypes) && strpos(",{$config->workflowlayout->noTotalFields},", ",{$field->field},") === false;
        $row->summaryItems       = $row->summaryEligible ? $summaryPickerItems : array();
        $row->summaryPickerValue = '';
        if($row->summaryEligible && $field->summary)
        {
            $row->summaryPickerValue = strpos((string) $field->summary, ',') !== false ? explode(',', (string) $field->summary) : $field->summary;
        }

        if(!empty($field->block))
        {
            $row->position = $field->block;
            $positionList[$field->block] = $field->block;
        }

        $row->checkRequired = in_array($row->id, $requiredFields);
        if((!empty($field->show) && $field->show == '1') || $row->checkRequired) $checkedIds[] = $row->id;

        $rows[$field->field] = $row;
    }
}

jsVar('buildinFields', !empty($buildinFields) ? array_keys($buildinFields) : array());

foreach($fields as $key => $field)
{
    if(!empty($rows[$key])) continue;
    if(($action->type != 'batch' || $action->batchMode != 'different') && !in_array($field->module, $config->workflow->uiFlow) && strpos(",{$disabledFields},", ",{$key},") !== false) continue;
    if($action->method == 'batchcreate' && $key == 'id') continue;
    if($key == 'actions') $field->role = 'default';
    if(strpos($key, 'prev_') === 0) continue;

    $isSubHeader = !empty($subTables[$key]);

    if(empty($field->name) && in_array($key, zget($config->workflow->layoutFields, $flow->module, array()))) $field->name = zget($lang->{$flow->module}, $key, zget($lang, $key, $key));

    $row = clone $field;
    $row->id                = $key;
    $row->parent            = 0;
    $row->rowKind           = $isSubHeader ? 'subHeader' : 'main';
    $row->ditto             = zget($field, 'ditto', '0');
    $row->readonly          = zget($field, 'readonly', '0');
    $row->position          = !empty($field->position) ? $field->position : zget($defaultPositions, $field->field, '');
    $row->summary           = zget($field, 'summary', '');
    $row->defaultValue      = zget($field, 'defaultValue', '');
    $row->width             = zget($field, 'width', 6);
    $row->defaultValueItems = $getDefaultOptions($field);
    $row->buildin           = !empty($field->buildin) ? "<i class='icon-check text-success'></i>" : "<i class='icon-close text-danger'></i>";
    $row->skipFormExtras    = $isSubHeader || ($layoutScene == 'form' && is_numeric($key));
    $row->summaryEligible   = $layoutScene == 'browse'
        && !$isSubHeader
        && $flow->buildin == '0'
        && in_array($field->type, $config->workflowfield->numberTypes)
        && strpos(",{$config->workflowlayout->noTotalFields},", ",{$field->field},") === false;

    $row->summaryItems       = $row->summaryEligible ? $summaryPickerItems : array();
    $row->summaryPickerValue = '';
    if($row->summaryEligible && $field->summary)
    {
        $row->summaryPickerValue = strpos((string) $field->summary, ',') !== false ? explode(',', (string) $field->summary) : $field->summary;
    }

    if(!empty($field->block)) $row->position = $field->block;

    $row->checkRequired = in_array($key, $requiredFields);
    if((!empty($field->show) && $field->show == '1' && !$isSubHeader) || $row->checkRequired) $checkedIds[] = $key;

    $rows[] = $row;

    if($isSubHeader && $action->method != 'browse' && $action->type == 'single')
    {
        foreach($subTables[$key] as $childKey => $childField)
        {
            if(strpos(",{$disabledSub},", ",{$childKey},") !== false) continue;

            $subRow                     = clone $childField;
            $subId                      = $key . '::' . $childKey;
            $subRow->id                 = $subId;
            $subRow->parent             = $key;
            $subRow->rowKind            = 'subField';
            $subRow->ditto              = zget($childField, 'ditto', '0');
            $subRow->readonly           = zget($childField, 'readonly', '0');
            $subRow->position           = zget($childField, 'position', '');
            $subRow->summary            = zget($childField, 'summary', '');
            $subRow->defaultValue       = zget($childField, 'defaultValue', '');
            $subRow->defaultValueItems  = $getDefaultOptions($childField);
            $subRow->buildin            = !empty($childField->buildin) ? "<i class='icon-check text-success'></i>" : "<i class='icon-close text-danger'></i>";
            $subRow->skipFormExtras     = is_numeric($childKey);
            $subRow->summaryEligible    = false;
            $subRow->summaryItems       = array();
            $subRow->summaryPickerValue = '';

            if(!empty($childField->show) && $childField->show == '1') $checkedIds[] = $subId;

            $rows[] = $subRow;
        }
    }
}

if($action->method != 'browse' && $action->type == 'single' && !empty($prevModules))
{
    foreach($prevModules as $prevModule => $prevFields)
    {
        $headerRow          = new stdClass();
        $headerRow->id      = 'prev_' . $prevModule;
        $headerRow->parent  = 0;
        $headerRow->rowKind = 'subHeader';
        $headerRow->name    = $lang->workflowrelation->prev . $lang->hyphen . zget($flowPairs, $prevModule);
        $rows[] = $headerRow;

        foreach($prevFields as $childKey => $childField)
        {
            if(strpos(",{$disabledSub},", ",{$childKey},") !== false) continue;

            $subRow                     = clone $childField;
            $subId                      = 'prev_' . $prevModule . '::' . $childKey;
            $subRow->id                 = $subId;
            $subRow->parent             = 'prev_' . $prevModule;
            $subRow->rowKind            = 'subField';
            $subRow->prevLayoutShowOnly = true;

            if(!empty($childField->show) && $childField->show == '1') $checkedIds[] = $subId;

            $rows[] = $subRow;
        }
    }
}

$bindFields = zget($config->workflow->bindFields, $flow->module, array());
$bindFields = zget($bindFields, $action->action, array());
jsVar('bindLockedFields', $bindFields);
if($bindFields)
{
    $rowIds = array();
    foreach($rows as $row) $rowIds[$row->id] = true;
    foreach($bindFields as $bindField) if(isset($rowIds[$bindField])) $checkedIds[] = $bindField;
}

$pinnedRows = array();
$normalRows = array();
foreach($rows as $row)
{
    $row->wrap  = !empty($row->wrapBefore) ? ',wrapBefore' : '';
    $row->wrap .= !empty($row->wrapAfter)  ? ',wrapAfter'  : '';
    if($row->rowKind == 'main' && !empty($row->checkRequired))
    {
        $pinnedRows[] = $row;
        continue;
    }
    $normalRows[] = $row;
}

if($pinnedRows)
{
    $insertAt = count($normalRows);
    foreach($normalRows as $index => $row)
    {
        if($row->rowKind == 'subHeader')
        {
            $insertAt = $index;
            break;
        }
    }
    array_splice($normalRows, $insertAt, 0, $pinnedRows);
    $rows = $normalRows;
}

$checkedList = implode(',', array_unique($checkedIds));

$dtable    = $config->workflowlayout->dtable;
$fieldList = $dtable->fieldList;
if($layoutScene === 'browse' || $layoutScene === 'view')
{
    $sceneColKeys = $dtable->sceneCols[$layoutScene];
}
else
{
    $sceneColKeys[] = 'id';
    $sceneColKeys[] = 'name';

    if($action->type != 'batch' || $action->batchMode != 'different') $sceneColKeys[] = 'width';

    $sceneColKeys[] = 'layoutRules';
    $sceneColKeys[] = 'defaultValue';

    if($action->layout == 'side')        $sceneColKeys[] = 'position';
    if($action->layout == 'side')        $sceneColKeys[] = 'addBlock';
    if($action->method == 'batchcreate') $sceneColKeys[] = 'ditto';
    if(in_array($action->module, array('requirement', 'story', 'epic', 'task', 'bug')) && in_array($action->action, array('create', 'copy'))) $sceneColKeys[] = 'foldable';
    if($uiMode == 'form' && (in_array($action->module, $config->workflow->uiFlow) || empty($action->buildin))) $sceneColKeys[] = 'wrap';

    $sceneColKeys[] = 'readonly';
    $sceneColKeys[] = 'buildin';
    if($action->type != 'single' || in_array($actionMethod, $config->workflowaction->readonlyActions))
    {
        $sceneColKeys = array_values(array_filter($sceneColKeys, function ($colKey)
        {
            return $colKey !== 'readonly';
        }));
    }
}

$cols = array();
foreach($sceneColKeys as $colKey)
{
    if(!isset($fieldList[$colKey])) continue;
    $cols[$colKey] = $fieldList[$colKey];
}

if(isset($cols['layoutRules'])) $cols['layoutRules']['controlItems'] = $rules;
if(isset($cols['position']))
{
    if(in_array($action->module, array('productplan', 'build', 'release'))) unset($positionList['info']);
    if($action->module == 'caselib' && $action->action == 'view') unset($positionList['basic']);
    $cols['position']['controlItems'] = $positionList;
    if($layoutScene == 'browse') $cols['position']['title'] = $lang->workflowlayout->alignment;
}
if(isset($cols['defaultValue'])) $cols['defaultValue']['control'] = jsRaw('window.getDefaultValueControl');

dtable
(
    setID('workflowlayout-admin'),
    set::userMap(array()),
    set::cols($cols),
    set::data(array_values($rows)),
    set::fixedLeftWidth('0.33'),
    set::controlMap(jsRaw('window.readonlyControlMap')),
    set::plugins(array('form', 'sortable')),
    set::sortHandler('.move-field'),
    set::canSortTo(jsRaw('window.canSortTo')),
    set::checkable(true),
    set::checkOnClickRow($action->layout != 'side'),
    set::canRowCheckable(jsRaw('window.workflowlayoutCanRowCheckable')),
    set::onRenderCell(jsRaw('window.renderFieldCell')),
    set::canRowCheckable(jsRaw('window.canRowCheckable')),
    set::checkInfo(jsRaw("function(){return '{$lang->workflowlayout->tips->checkInfo}';}")),
    set::checkedRows($checkedIds)
);

$footerNodes = array(btn(set::type('primary'), set::btnType('button'), set::id('workflowlayoutSaveBtn'), $lang->save));

$canSetLinkage = hasPriv('workflowlinkage', 'browse') && $this->loadModel('workflowaction')->isClickable($action, 'browseLinkage');
if($action->type == 'batch') $canSetLinkage = false;
if(!in_array($action->method, array('edit', 'operate', 'create'))) $canSetLinkage = false;

$linkageURL = $canSetLinkage ? createLink('workflowlinkage', 'browse', "actionID={$action->id}&ui={$ui}") : '';
if($canSetLinkage) $footerNodes[] = a(setClass('btn'), set::href($linkageURL), $lang->workflowaction->linkage, set(array('data-load' => 'modal', 'data-size' => 'md')));
if(hasPriv('workflowlayout', 'block') && $action->method == 'view' && $flow->role == 'custom') $footerNodes[] = a(setClass('btn'), set::href(createLink('workflowlayout', 'block', "module=$action->module")), $lang->workflowlayout->block, set(array('data-load' => 'modal', 'data-size' => 'md')));
if($ui && hasPriv('workflowlayout', 'editUI')) $footerNodes[] = a(setClass('btn'), set::href(inlink('editUI', "ui={$ui}")), $lang->workflowlayout->editUI, set(array('data-load' => 'modal', 'data-size' => 'md')));
if($ui && hasPriv('workflowlayout', 'deleteUI')) $footerNodes[] = a(setClass('btn'), set::href(inlink('deleteUI', "ui={$ui}")), $lang->workflowlayout->deleteUI, setData(array('confirm' => $lang->confirmDelete)), set(array('className' => 'ajax-submit')));

div(setClass('modal-footer flex justify-center gap-2 items-center'), $footerNodes);
