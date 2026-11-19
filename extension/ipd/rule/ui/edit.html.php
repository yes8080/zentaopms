<?php
/**
 * The edit file of rule module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
namespace zin;

modalHeader();

foreach($lang->rule->typeList as $key => $value)
{
    $lang->rule->typeList[$key] = $value . $lang->rule->typeNoticeList[$key];
}

$hidden = $rule->type == 'global' ? 'hidden' : '';
formPanel
(
    on::change('[name=type]', 'changeType'),
    formGroup
    (
        set::label($lang->rule->name),
        set::required(true),
        input
        (
            set::name('name'),
            set::value($rule->name)
        )
    ),
    formGroup
    (
        set::label($lang->rule->type),
        radioList
        (
            set::inline(true),
            set::name('type'),
            set::items($lang->rule->typeList),
            set::value($rule->type)
        )
    ),
    formGroup
    (
        set::label($lang->rule->workflowGroup),
        setClass("workflowGroupBox $hidden"),
        set::required(true),
        picker
        (
            set::name('workflowGroup'),
            set::items($workflowGroups),
            set::value($rule->workflowGroup),
            set::multiple(true)
        )
    ),
    formGroup
    (
        set::label($lang->rule->method),
        radioList
        (
            set::inline(true),
            set::name('method'),
            set::items($lang->rule->methodList),
            set::value($rule->method)
        )
    ),
    formGroup
    (
        set::label($lang->comment),
        editor
        (
            set::name('comment')
        )
    )
);
