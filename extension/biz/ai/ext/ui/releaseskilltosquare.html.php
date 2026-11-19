<?php

namespace zin;

formPanel
(
    set::title($lang->ai->skills->releaseToSquare),
    set::actions(array('submit' => array('text' => $lang->confirm, 'className' => 'primary', 'btnType' => 'submit'), 'cancel' => array('text' => $lang->cancel, 'data-dismiss' => 'modal'))),
    div
    (
        setClass('mb-4 text-gray'),
        $lang->ai->skills->confirmReleaseToSquare
    ),
    $nameExists ? formGroup
    (
        set::label($lang->ai->skills->name),
        set::required(true),
        input
        (
            set::name('name'),
            set::value($skill->name)
        )
    ) : input
    (
        set::type('hidden'),
        set::name('name'),
        set::value($skill->name)
    )
);
