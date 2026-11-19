<?php
namespace zin;
$backUrl = $from == 'browse' ? createLink('aiprocedure', 'browse') : createLink('aiprocedure', 'view', "id={$procedure->id}");

panel
(
    zui::aiProcedureDesigner
    (
        set::height('calc(100vh - 96px)'),
        set::goBack(jsRaw("() => {goBack('aiprocedure', '{$backUrl}')}")),
        set::id((int)$procedure->id),
        set::name($procedure->name),
        set::published($procedure->status === 'active'),
        set::labels($lang->aiprocedure->appLabels),
    )
);
