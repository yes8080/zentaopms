<?php
/**
 * The ajaxloadnotifyform file of rule module of ZenTaoPMS.
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
    $fieldItems[] = array('text' => $name, 'key' => "{{{$objectType}.{$field}}}", 'icon' => 'copy');
}

$app->loadLang('product');
$app->loadLang('project');
$app->loadLang('execution');
$app->loadLang('stakeholder');

$users["{{deptManager}}"] = $lang->rule->deptManager;

$users["{{product.PO}}"]       = $lang->productCommon . '/' . $lang->product->PO;
$users["{{product.QD}}"]       = $lang->productCommon . '/' . $lang->product->QD;
$users["{{product.RD}}"]       = $lang->productCommon . '/' . $lang->product->RD;
$users["{{product.feedback}}"] = $lang->productCommon . '/' . $lang->product->FM;
$users["{{product.ticket}}"]   = $lang->productCommon . '/' . $lang->product->TM;
$users["{{product.reviewer}}"] = $lang->productCommon . '/' . $lang->product->reviewer;

$users["{{project.PO}}"]          = $lang->projectCommon . '/' . $lang->project->PO;
$users["{{project.stakeholder}}"] = $lang->projectCommon . '/' . $lang->stakeholder->common;

$users["{{execution.PO}}"] = $lang->executionCommon . '/' . $lang->execution->PO;
$users["{{execution.PM}}"] = $lang->executionCommon . '/' . $lang->execution->execPM;
$users["{{execution.QD}}"] = $lang->executionCommon . '/' . $lang->execution->QD;
$users["{{execution.RD}}"] = $lang->executionCommon . '/' . $lang->execution->RD;

formRow
(
    formGroup
    (
        set::name('subject'),
        set::label($lang->rule->notifyList->subject),
        isset($fields->subject) ? set::value($fields->subject) : null,
        dropdown
        (
            btn(icon('copy'), set::hint($lang->rule->copyField), setClass('copy-field-btn')),
            set::items($fieldItems),
            set::caret(false),
            set::flip(true),
            set::placement('left-start'),
            set::strategy('absolute'),
            set::hasIcons(true),
            set::menuClass("copy-fields-menu subject"),
            set::menu(array
            (
                'header' => $lang->rule->objectList[$objectType] . $lang->rule->field,
                'onClickItem' => jsRaw("copyField")
            )),
            set::trigger('click')
        )
    )
);
formRow
(
    formGroup
    (
        set::name('content'),
        set::label($lang->rule->notifyList->content),
        set::control('editor'),
        isset($fields->content) ? set::value($fields->content) : null,
        dropdown
        (
            btn(icon('copy'), set::hint($lang->rule->copyField), setClass('copy-field-btn editor')),
            set::items($fieldItems),
            set::caret(false),
            set::flip(true),
            set::placement('left-start'),
            set::strategy('absolute'),
            set::hasIcons(true),
            set::menuClass("copy-fields-menu content"),
            set::menu(array
            (
                'header' => $lang->rule->objectList[$objectType] . $lang->rule->field,
                'onClickItem' => jsRaw("copyField")
            )),
            set::trigger('click')
        )
    )
);
formRow
(
    formGroup
    (
        set::label($lang->rule->notifyList->toList),
        picker
        (
            set::name('toList'),
            set::items($users),
            set::multiple(true),
            isset($fields->toList) ? set::value($fields->toList) : null
        )
    )
);
formRow
(
    formGroup
    (
        set::label($lang->rule->notifyList->route),
        checkList
        (
            set::name('route'),
            set::inline(true),
            set::value(array_keys($lang->message->typeList)),
            set::items($lang->message->typeList),
            isset($fields->route) ? set::value($fields->route) : null
        )
    )
);
