<?php
namespace zin;

data('aiprocedure', $procedure);

$config->aiprocedure->actionList['design']['url']['params'] = 'id={id}&from=view';
if($procedure->status == 'draft' && empty($steps))
{
    $config->aiprocedure->actionList['publish']['isClickable'] = true;
    $config->aiprocedure->actionList['publish']['disabled']    = true;
    $config->aiprocedure->actionList['publish']['hint']        = $lang->aiprocedure->publishNeedSteps;
}
$actions = $this->loadModel('common')->buildOperateMenu($procedure);

detailHeader
(
    to::title
    (
        entityLabel
        (
            set::entityID($procedure->id),
            set::level(1),
            set::text($procedure->name)
        )
    ),
    to::suffix
    (
        hasPriv('aiprocedure', 'create') ? btn
        (
            setClass('primary'),
            set::icon('plus'),
            set::url(createLink('aiprocedure', 'create')),
            setData('toggle', 'modal'),
            $lang->aiprocedure->create
        ) : null
    )
);

$lastEdited    = '';
$createdBy     = zget($users, $procedure->createdBy);
$editedBy      = zget($users, $procedure->editedBy);
$publishedBy   = zget($users, $procedure->publishedBy);
$unpublishedBy = zget($users, $procedure->unpublishedBy);
if($editedBy)
{
    $lastEdited = $editedBy;
    if(!empty($procedure->editedDate)) $lastEdited .= $lang->at . $procedure->editedDate;
}

requireWg('aiProcedureEntry');

detailBody
(
    sectionList
    (
        section
        (
            set::title($lang->aiprocedure->steps),
            aiProcedureEntry::buildSteps(array_values($steps))
        )
    ),
    history
    (
        set::objectID($procedure->id),
        set::objectType('aiprocedure')
    ),
    floatToolbar
    (
        set::object($procedure),
        to::prefix
        (
            backBtn
            (
                set::icon('back'),
                set::className('ghost text-white'),
                set::back('aiprocedure-browse'),
                $lang->aiprocedure->back
            )
        ),
        set::main(zget($actions, 'mainActions', array())),
        set::suffix(zget($actions, 'suffixActions', array()))
    ),
    detailSide
    (
        tabs
        (
            set::collapse(true),
            tabPane
            (
                set::key('basicInfo'),
                set::title($lang->aiprocedure->basicInfo),
                set::active(true),
                tableData
                (
                    item
                    (
                        set::name($lang->aiprocedure->module),
                        zget($lang->aiprocedure->moduleList, $procedure->module, $procedure->module)
                    ),
                    item
                    (
                        set::name($lang->aiprocedure->status),
                        zget($lang->aiprocedure->statusList, $procedure->status, $procedure->status)
                    ),
                    item
                    (
                        set::name($lang->aiprocedure->desc),
                        $procedure->desc
                    ),
                    item
                    (
                        set::name($lang->aiprocedure->createdBy),
                        $createdBy
                    ),
                    item
                    (
                        set::name($lang->aiprocedure->publishedBy),
                        $publishedBy
                    ),
                    item
                    (
                        set::name($lang->aiprocedure->unpublishedBy),
                        $unpublishedBy
                    ),
                    item
                    (
                        set::name($lang->aiprocedure->lastEdited),
                        $lastEdited
                    )
                )
            )
        )
    )
);
