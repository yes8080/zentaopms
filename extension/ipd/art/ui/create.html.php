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

formPanel
(
    set::title($lang->art->create),
    on::change("[name=acl]", 'setWhiteList'),
    formRow
    (
        formGroup(set::width('1/2'), set::label($lang->art->name), set::required(true), input(set::name('name'))),
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->product),
            set::required(true),
            picker(set::multiple(true), set::name('product'), set::items($products))
        )
    ),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->RTE),
            set::required(true),
            picker(set::name('RTE'), set::items($users))
        ),
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->manager),
            picker(set::name('manager'), set::items($users), set::multiple(true))
        )
    ),
    formRow
    (
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->PO),
            picker(set::name('PO'), set::items($users), set::multiple(true))
        ),
        formGroup
        (
            set::width('1/2'),
            set::label($lang->art->architect),
            picker(set::name('architect'), set::items($users), set::multiple(true))
        )
    ),
    formRow
    (
        setID('teamBox'),
        formGroup
        (
            set::label($lang->art->team),
            inputGroup
            (
                picker(set::id('team'), set::name('team'), set::items($teams), set::multiple(true)),
                empty($teams) ? span
                (
                    set('class', 'input-group-btn'),
                    btn
                    (
                        setID('createTeam'),
                        set('data-toggle', 'modal'),
                        set::url(createLink('team', 'create', 'from=art')),
                        $lang->team->create . $lang->team->common
                    ),
                ) : null,
                empty($teams) ? span
                (
                    set('class', 'input-group-btn'),
                    btn
                    (
                        setID('refreshTeam'),
                        on::click('refreshTeam'),
                        set::title($lang->refresh . $lang->team->common),
                        icon('refresh')
                    )
                ) : null
            )
        )
    ),
    formGroup
    (
        set::label($lang->art->desc),
        editor(set::name('desc'), set::rows(3))
    ),
    formGroup
    (
        set::id('aclList'),
        set::name('acl'),
        set::label($lang->art->acl),
        set::control('radioList'),
        set::items($lang->art->aclList),
        set::value('open')
    ),
    formGroup
    (
        setClass('hidden'),
        set::label($lang->art->whitelist),
        picker
        (
            set::id('whitelist'),
            set::name('whitelist'),
            set::items($users),
            set::multiple(true)
        )
    )
);
