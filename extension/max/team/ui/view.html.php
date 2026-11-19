<?php
/**
 * The view view file of team module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     team
 * @link        https://www.zentao.net
 */
namespace zin;

$memberCards = array();
foreach($members as $member)
{
    $user = \zget($userList, $member->account);
    $memberCards[] = cell
    (
        set::width('25%'),
        set::className('card'),
        div
        (
            set::className('border mr-4 mb-4 flex'),
            cell
            (
                set::className('p-4'),
                userAvatar(set::user($user), set::size(40))
            ),
            cell(set::className('py-4'), div
            (
                span(set::className('text-lg text-black font-bold'), $user->realname),
                span
                (
                    set::className('text-gray ml-4'),
                    \zget($lang->user->roleList, $user->role)
                )
            ), div($member->join, span(set::className('ml-1'), $lang->team->joinAB))),
            common::hasPriv('team', 'removeMember') ? cell
            (
                set::className('flex-1 flex justify-end'),
                a(icon('trash'), set
                (
                    array
                    (
                        'class' => 'btn ghost ajax-submit remove-btn hidden',
                        'title' => $lang->team->removeMember,
                        'href' => createLink('team', 'removeMember', 'teamID=' . $team->id . '&account=' . $member->account)
                    )
                ))
            ) : null
        )
    );
}

$managers = '';
if($team->manager)
{
    foreach(explode(',', $team->manager) as $manager)
    {
        $managers .= \zget($users, $manager) . '、';
    }
    $managers = trim($managers, '、');
}

div(set::className('col'), cell
(
    set::className('bg-white p-4'),
    div
    (
        set::className('flex'),
        cell
        (
            set::className('border shadow-sm flex items-center p-2'),
            userAvatar(!empty($team->logo) ? set::avatar($team->logo) : set::account($team->name), set::size(60))
        ),
        cell
        (
            set::flex('1'),
            set::className('ml-4'),
            div(set::className('flex items-center'), span(set::className('text-xl text-black'), $team->name), !$team->deleted && $team->status == 'disband' ? span(set::className('label lighter ml-4'), $lang->team->statusList['disband']) : null, $team->deleted ? span(set::className('label danger ml-4'), $lang->team->deleted) : null, span(set::className('ml-4'), $team->status == 'disband' ? ($team->createdDate . ' ~ ' . $team->disbandedDate) : ($team->createdDate . ' '. $lang->team->create))),
            div(set::className('mt-1'), span(set::className('text-lg'), $team->slogan)),
            div
            (
                set::className('flex justify-start mt-2'),
                cell(set::className('mr-8'), span($lang->team->manager . ' : ' . $managers)),
                $team->parent > 0 ? cell(set::className('mr-8'), span($lang->team->parent . ' : ' . \zget($teams, $team->parent))) : null,
                cell(set::className('mr-8'), span($lang->team->number . ' : '. count($members)))
            )
        )
    ),
    div
    (
        set::className('mt-4'),
        html($team->declaration)
    )
), cell(set::className('bg-white px-4 py-2 mt-4'), tabs
(
    common::hasPriv('team', 'addMember') ? div
    (
        set::className('addMember'),
        a
        (
            icon(set::className('mr-1'), 'plus'),
            set
            (
                array
                (
                    'data-toggle' => 'modal',
                    'class' => 'btn secondary',
                    'href' => createLink('team', 'addMember', 'teamID=' . $team->id)
                )
            ),
            $lang->team->addMember
        )
    ) : null,
    tabPane
    (
        set::key('member'),
        set::title($lang->team->member),
        set::active(true),
        div
        (
            set::className('flex flex-wrap overflow-x-auto'),
            setStyle('max-height', '18rem'),
            $memberCards
        )
    )
)), cell(set::className('bg-white mt-4'), history(set::objectType('teamgroup'), set::objectID($team->id), set::commentUrl(createLink('action', 'comment', array('objectType' => 'teamgroup', 'objectID' => $team->id))))));

$actions = $this->loadModel('common')->buildOperateMenu($team);
center
(
    set::className('mt-4'),
    floatToolbar
    (
        set::object($team),
        isAjaxRequest('modal') ? null : to::prefix(backBtn(set::icon('back'), set::className('ghost text-white'), set::back('team-browse'), $lang->goback)),
        set::main($actions['mainActions']),
        set::suffix($actions['suffixActions'])
    )
);

render();
