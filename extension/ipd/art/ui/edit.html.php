<?php
/**
 * The create view file of art module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sun Guangming <sunguangming@easycorp.ltd>
 * @package     art
 * @link        https://www.zentao.net
 */
namespace zin;

jsVar('+oldTeam', $art->team);
jsVar('+oldProduct', $art->product);
jsVar('oldStatus', $art->status);
jsVar('hasNoClosedPI',  $hasNoClosedPI);
jsVar('hasLinkedTeams', $hasLinkedTeams);
jsVar('hasLinkedProducts', $hasLinkedProducts);
jsVar('cannotRemoveTeam', $lang->art->notice->cannotRemoveTeam);
jsVar('cannotRemoveProduct', $lang->art->notice->cannotRemoveProduct);
jsVar('cannotCloseART', $lang->art->notice->cannotCloseART);

formPanel
(
    set::title($lang->art->edit), on::change('#team', 'changeTeam'), on::change('#product', 'changeProduct'), on::change('#status', 'changeStatus'), on::change("[name=acl]", 'setWhiteList'),
    formRow
    (
        formGroup(set::label($lang->art->name), set::required(true), input(set::name('name'), set::value($art->name))),
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->product),
            set::required(true),
            picker
            (
                set::multiple(true),
                set::id('product'),
                set::name('product'),
                set::items($products),
                set::value($art->product)
            )
        )
    ),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->RTE),
            set::required(true),
            picker(set::name('RTE'), set::items($users), set::value($art->RTE))
        ),
        formGroup
        (
            set::label($lang->art->manager),
            set::width('1/2'),
            picker
            (
                set::name('manager'),
                set::items($users),
                set::multiple(true),
                set::value($art->manager)
            )
        )
    ),
    formRow
    (
        formGroup
        (
            set::label($lang->art->PO),
            set::width('1/2'),
            picker
            (
                set::name('PO'),
                set::items($users),
                set::multiple(true),
                set::value($art->PO)
            )
        ),
        formGroup
        (
            set::label($lang->art->architect),
            set::width('1/2'),
            picker
            (
                set::name('architect'),
                set::items($users),
                set::multiple(true),
                set::value($art->architect)
            )
        )
    ),
    formGroup
    (
        set::label($lang->art->team),
        picker
        (
            set::id('team'),
            set::name('team'),
            set::items($teams),
            set::multiple(true),
            set::value($art->team)
        )
    ),
    formGroup
    (
        set::width('1/2'),
        set::label($lang->art->status),
        picker
        (
            set::id('status'),
            set::name('status'),
            set::items($lang->art->statusList),
            set::required(true),
            set::value($art->status)
        )
    ),
    formGroup
    (
        set::label($lang->art->desc),
        editor
        (
            set::name('desc'),
            html($art->desc)
        )
    ),
    formGroup
    (
        set::id('aclList'),
        set::name('acl'),
        set::label($lang->art->acl),
        set::control('radioList'),
        set::items($lang->art->aclList),
        set::value($art->acl)
    ),
    formGroup
    (
        $art->acl == 'open' ? setClass('hidden') : null,
        set::label($lang->art->whitelist),
        picker
        (
            set::id('whitelist'),
            set::name('whitelist'),
            set::items($users),
            set::multiple(true),
            set::value($art->whitelist)
        )
    )
);
