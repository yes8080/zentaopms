<?php
namespace zin;

jsVar('knowledgeLibs', array_values($knowledgeLibs));
jsVar('knowledgeLibAdd', $lang->ai->miniPrograms->knowledgeLibAdd);
jsVar('knowledgeLibAddTip', $lang->aiteammate->klibsAddTip);
jsVar('confirmDelete', $lang->ai->knowledgeLibs->confirmDelete);
jsVar('teammateID', $id);
jsVar('copySuccess', $lang->aiteammate->copySuccess);
jsVar('errorUploadSize', $lang->aiteammate->errorUploadSize);
jsVar('unpublished', $lang->ai->knowledgeLibs->unpublished);
jsVar('deleted', $lang->ai->knowledgeLibs->deleted);

/* 形象卡片 */
$avatarCard = function($role)
{
    return div(
        setClass('avatar-card'),
        img(
            set::src($this->app->config->webRoot . $role['avatar'])
        ),
        div(
            setClass('avatar-info'),
            h5(
                setClass('avatar-name text-primary'),
                $role['name']
            ),
            p(
                setClass('avatar-role'),
                $role['role']
            )
        ),
        icon(
            setClass('text-primary-400'),
            set::size(20),
            set::onClick("window.copyPrompt(`{$role['prompt']}`)"),
            'copy'
        )
    );
};

formPanel(
    setClass('teammate-form'),
    set::layout('normal'),
    to::heading(
        div(
            setClass('font-bold text-lg'),
            $title
        )
    ),
    div(
        setClass('px-10 flex col gap-4'),
        div(
            setClass('flex items-center gap-4'),
            formGroup(
                setClass('flex-1'),
                set::label($lang->aiteammate->name),
                set::name('name'),
                set::required(true),
                set::value($teammate->name)
            ),
            formGroup(
                setClass('flex-1'),
                set::label($lang->aiteammate->role),
                set::control('picker'),
                set::name('role'),
                set::required(true),
                set::items($lang->user->roleList),
                set::value($teammate->role)
            )
        ),
        div(
            setClass('flex items-center gap-4'),
            formGroup(
                setClass('flex-1'),
                set::label($lang->aiteammate->agents),
                set::control('picker'),
                set::name('agents'),
                set::multiple(true),
                set::required(true),
                set::items($agentsList),
                set::value($teammate->agents)
            ),
            formGroup(
                setClass('flex-1'),
                set::label($lang->aiteammate->llm),
                set::required(true),
                zui::AIModelPicker
                (
                    set::name('llm'),
                    set::required(true),
                    set::value($teammate->llm)
                )
            )
        ),
        formGroup(
            set::label($lang->aiteammate->desc),
            set::control(array('type' => 'textarea', 'rows' => 4)),
            set::name('desc'),
            set::placeholder($lang->aiteammate->descPlaceholder),
            set::value($teammate->desc)
        ),
        formGroup(
            set::label($lang->aiteammate->klibs),
            ol(
                setID('knowledge-libs'),
                setClass('field-list')
            ),
        ),
        formGroup(
            set::label($lang->aiteammate->avatar),
            div(
                setClass('avatar-section'),
                div(
                    setClass('avatar-box' . ($teammate->avatar ? '' : ' empty')),
                    img(
                        set::src($teammate->avatar)
                    ),
                    div(
                        setClass('avatar-empty bg-gray-50'),
                        on::click('window.uploadAvatar'),
                        div(
                            setClass('action text-primary-400'),
                            icon('image'),
                            span($lang->aiteammate->uploadAvatar)
                        ),
                        div(
                            setClass('tips text-gray-400'),
                            $lang->aiteammate->avatarTips
                        )
                    )
                ),
                div(
                    setClass('avatar-list'),
                    p($lang->aiteammate->promptTips),
                    div(
                        setClass('avatar-cards'),
                        array_map($avatarCard, $defaultRoles)
                    )
                )
            )
        ),
        input(
            set::type('hidden'),
            set::name('klibs'),
            set::value($teammate->klibs)
        ),
        input(
            set::type('hidden'),
            set::name('avatar'),
            set::value($teammate->avatar)
        )
    ),
    set::actions(
        array(
            array('text' => $lang->save, 'class' => 'btn primary', 'btnType' => 'submit'),
            array('text' => $lang->cancel, 'class' => 'btn open-url', 'url' => helper::createLink('aiteammate', 'browse', 'disabled=all'))
        )
    )
);

formbase(
    setID('teammateAvatarForm'),
    setClass('hidden'),
    set::url(createLink('aiteammate', 'uploadAvatar')),
    upload()
);
