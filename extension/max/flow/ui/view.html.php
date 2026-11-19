<?php
/**
 * The view view file of flow module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@chandao.com>
 * @package     flow
 * @link        https://www.zentao.net
 */
namespace zin;
include 'header.html.php';

jsVar('moduleName', $flow->module);
jsVar('viewMode', $currentMode);

$obj = $this;
$showFields = function($fields, $childFields, $relations, $data, $position = 'info') use ($childDatas, $obj)
{
    global $lang;

    $html     = '';
    $children = array();
    foreach($fields as $field)
    {
        if(empty($field->show)) continue;
        if(isset($childFields[$field->field]))
        {
            $children[$field->field] = $field->name;
            continue;
        }

        if($field->position != $position) continue;

        if($field->control == 'file')
        {
            $filesName = "{$field->field}files";
            if(!empty($data->{$filesName})) $html .= '<p><strong>' . $field->name . $lang->colon . '</strong>' . $this->flow->getFieldValue($field, $data) . '</p>';
        }
        else
        {
            $attr     = '';
            $relation = zget($relations, $field->field, '');
            if($relation && strpos(",$relation->actions,", ',many2one,') === false && strpos(",$relation->actions,", ',many2many,') === false)
            {
                $prevDataID = isset($data->{$field->field}) ? $data->{$field->field} : 0;
                if($prevDataID) $attr = "class='prevField' data-prev='{$relation->prev}' data-next='{$relation->next}' data-action='view' data-dataid='$prevDataID'";
            }

            if($field->control == 'textarea') $attr .= " class='article'";
            $html .= "<p $attr><strong>{$field->name}</strong>";
            if($field->control == 'textarea') $html .= '<br/>';

            $fieldValue = '';
            if(!empty($data->{$field->field}))
            {
                if(is_array($data->{$field->field}))
                {
                    foreach($data->{$field->field} as $value) $fieldValue .= $obj->flow->processFieldValue($field, $relation, $value) . ' ';
                }
                else
                {
                    $fieldValue = $obj->flow->processFieldValue($field, $relation, $data->{$field->field});
                }
            }
            else
            {
                if(isset($data->{$field->field}) && $data->{$field->field} === '0') $fieldValue = '0';
            }
            if($fieldValue !== '') $html .= $field->control == 'textarea' ? $fieldValue : ' ' . $lang->colon . ' ' . $fieldValue;
            $html .= '</p>';
        }
    }

    foreach($children as $child => $childName)
    {
        if(empty($childDatas[$child])) continue;
        $html .= "<div class='panel panel-block mt-2'>
            <div class='panel-heading'><strong>{$childName}</strong></div>
            <table class='table table-hover condensed table-fixed'>
            <thead><tr>";
        foreach($childFields[$child] as $childField)
        {
            if(!$childField->show) continue;
            $childWidth = ($childField->width && $childField->width != 'auto' ? $childField->width . 'px' : 'auto');
            $html      .= "<th class='text-left' style='width:{$childWidth}'>{$childField->name}</th>";
        }
        $html .= "</tr></thead><tbody>";
        foreach($childDatas[$child] as $childData)
        {
            $html .= "<tr>";
            foreach($childFields[$child] as $childField)
            {
                if(!$childField->show) continue;
                if(strpos(',date,datetime,', ",$childField->control,") !== false)
                {
                    $childValue = formatTime($childData->{$childField->field});
                }
                else
                {
                    if(is_array($childData->{$childField->field}))
                    {
                        $childValues = array();
                        foreach($childData->{$childField->field} as $value)
                        {
                            if(!empty($value)) $childValues[] = zget($childField->options, $value);
                        }
                        $childValue = implode(',', $childValues);
                    }
                    else
                    {
                        $childValue = zget($childField->options, $childData->{$childField->field});
                    }
                }

                $strippedValue = is_string($childValue) ? strip_tags($childValue) : '';
                $html .= "<td title='{$strippedValue}'>{$childValue}</td>";
            }
            $html .= "</tr>";
        }
        $html .= "</tbody></table></div>";
    }
    return $html;
};

$buildBlock = function($blockFields) use ($obj, $childFields, $relations, $data)
{
    $html = "<table class='table borderless condensed mb-2'>";
    foreach($blockFields as $field)
    {
        if(!$field->show) continue;
        if(isset($childFields[$field->field])) continue;

        /* Display data of the prev flow. */
        $attr     = '';
        $link     = '';
        $relation = zget($relations, $field->field, '');
        if($relation && strpos(",$relation->actions,", ',many2one,') === false)
        {
            $prevDataID = isset($data->{$field->field}) ? $data->{$field->field} : 0;
            $attr       = "class='prevTR' data-prev='{$relation->prev}' data-next='{$relation->next}' data-action='view' data-dataid='$prevDataID'";

            if(hasPriv($relation->prev, 'view')) $link = createLink($relation->prev, 'view', "dataID=$prevDataID");
        }

        $html .= "<tr {$attr}><th class='w-24 text-right'>{$field->name}</th><td>";
        if($field->control == 'file')
        {
            $filesName = "{$field->field}files";
            $html     .= $obj->fetch('file', 'printFiles', array('files' => $data->{$filesName}, 'fieldset' => 'false'));
        }
        elseif(is_array($data->{$field->field}))
        {
            foreach($data->{$field->field} as $value) $html .= zget($field->options, $value) . ' ';
        }
        else
        {
            if(strpos(',date,datetime,', ",$field->control,") !== false)
            {
                $html .= formatTime($data->{$field->field});
            }
            else
            {
                $fieldValue = zget($field->options, $data->{$field->field});
                $html .= $link ? html::a($link, $fieldValue) : $fieldValue;
            }
        }
        $html .= "</td></tr>";
    }
    $html .= "</table>";
    return $html;
};

/* 初始化主栏内容。Init sections in main column. */
$sections = array();
$sections[] = setting()
    ->title($flow->name . $lang->flow->detail)
    ->control('html')
    ->content($showFields($fields, $childFields, $relations, $data));

/* 初始化侧边栏标签页。Init sidebar tabs. */
$tabs = array();
foreach($processBlocks as $blockKey => $block)
{
    if(!empty($block->tabs))
    {
        foreach($block->tabs as $tabKey => $tab)
        {
            $tabs[] = setting()
                ->group($blockKey)
                ->title($tab->name)
                ->children(wg(html($buildBlock($tab->fields))));
        }
    }
    elseif(!empty($block->fields))
    {
        $tabs[] = setting()
            ->group($blockKey)
            ->title($block->name)
            ->children(wg(html($buildBlock($block->fields))));
    }
}

$tabs[] = setting()
    ->group('related')
    ->title($lang->custom->relateObject)
    ->control('relatedObjectList')
    ->objectID($data->id)
    ->objectType("workflow_{$flow->module}")
    ->browseType('byObject');

/* 初始化底部操作栏。Init bottom actions, keep buildActionMenu HTML. */
$actions = array();
if($data->deleted != '1' && $flow)
{
    $this->loadModel('workflowaction');

    $actionRelations = $this->dao->select('next, actions')->from(TABLE_WORKFLOWRELATION)->where('prev')->eq($flow->module)->fetchPairs();
    $actionList      = $this->workflowaction->getList($flow->module, 'status_desc,order_asc', $groupID);
    foreach($actionList as $action)
    {
        $menu = $this->flow->buildActionMenu($flow->module, $action, $data, 'view', $actionRelations);
        if($menu) $actions[] = wg(html($menu));
    }

    if(!empty($config->openedApproval) && $flow->approval == 'enabled' && hasPriv('approval', 'progress') && !empty($data->approval))
    {
        $actions[] = array('type' => 'divider');
        $actions[] = wg(html(html::a(helper::createLink('approval', 'progress', "approvalID={$data->approval}"), $lang->flow->approvalProgress, '', "class='btn ghost' data-toggle='modal'")));
    }
}

div
(
    on::init()->call('loadAllPrevData'),
    detail
    (
        set::objectType($flow->module),
        set::objectID((int)$data->id),
        set::object($data),
        set::title(zget($dataPairs, $data->id)),
        set::backBtn(array('back' => "{$flow->module}-browse,my-index")),
        set::linkCreator(createLink($app->rawModule, $app->rawMethod, 'dataID={id}')),
        set::sections($sections),
        set::tabs($tabs),
        set::actions($actions)
    )
);