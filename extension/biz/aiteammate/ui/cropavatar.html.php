<?php
namespace zin;

jsVar('imageID', $image->id);
jsVar('teammateID', $teammateID);

modalHeader(
    set::title(''),
    set::entityText($lang->user->cropAvatar),
    set::entityID('')
);

formPanel(
    set::actions(''),
    imgCutter(
        set::btnText($lang->save),
        set::tipText($lang->user->cropAvatarTip),
        set::src($image->webPath),
        set::handleBtnClick(jsRaw('saveAvatar')),
        setStyle('max-width', '540px')
    )
);
