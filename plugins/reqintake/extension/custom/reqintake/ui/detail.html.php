<?php
namespace zin;

$labels = $lang->reqintake;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$renderEditor = require __DIR__ . '/rich-editor.php';
$revisionVersion = (int)($revisions[0]->version ?? 1);
$rich = isset($richVersions[$revisionVersion]);
ob_start();
?>
<article class="reqintake-detail-content">
    <?php if($submitted): ?><p class="alert success" role="status"><?= $escape(sprintf($labels->saved, (int)$item->id)) ?></p><?php endif; ?>
    <?php if(isset($formError)): ?><p class="alert danger" role="alert"><?= $escape($formError) ?></p><?php endif; ?>
    <dl class="reqintake-spec">
        <dt class="detail-section-title text-md py-1 font-bold"><?= $escape($labels->fields['description']) ?></dt>
        <dd class="article whitespace-pre-wrap"><?= $item->description === '' ? $escape($lang->noDesc) : ($rich ? $item->description : $escape($item->description)) ?></dd>
        <dt class="detail-section-title text-md py-1 font-bold"><?= $escape($labels->fields['acceptance']) ?></dt>
        <dd class="article whitespace-pre-wrap"><?= $attributes['acceptance'] === '' ? $escape($lang->noDesc) : ($rich ? $attributes['acceptance'] : $escape($attributes['acceptance'])) ?></dd>
    </dl>
    <?php if($canRevise): ?>
        <details id="reqintake-edit" <?= isset($revisionInput) ? 'open' : '' ?> class="reqintake-form-panel">
            <summary><?= $escape($labels->editFeedback) ?></summary>
            <form method="post" class="reqintake-form">
                <input type="hidden" name="intent" value="revise">
                <input type="hidden" name="bodyFormat" value="rich">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= $revisionInputVersion ?? (int)$item->version ?>">
                <div class="reqintake-edit-fields">
                <?php foreach(array('title' => 255, 'customer' => 255, 'channel' => 64) as $field => $limit): ?>
                    <label class="block"><?= $escape($labels->fields[$field]) ?>
                        <input class="form-control" name="<?= $field ?>" value="<?= $escape($revisionInput[$field] ?? $item->$field) ?>" maxlength="<?= $limit ?>" <?= $field === 'title' ? 'required' : '' ?>>
                    </label>
                <?php endforeach; ?>
                </div>
                <label class="block"><?= $escape($labels->fields['description']) ?>
                    <?= $renderEditor('description', $revisionInput['description'] ?? $item->description, $revisionInputRich ?? $rich) ?>
                </label>
                <div class="reqintake-edit-fields">
                <?php
                $values = ($revisionInput ?? array()) + $attributes;
                if(isset($revisionInputRich)) $rich = $revisionInputRich;
                require __DIR__ . '/attribute-fields.php';
                $rich = isset($richVersions[$revisionVersion]);
                ?>
                </div>
                <button class="btn primary" type="submit"><?= $escape($labels->editFeedback) ?></button>
            </form>
        </details>
    <?php endif; ?>
    <?php if($stateHistory): ?>
        <?php
        $actions = array();
        foreach(array_reverse($stateHistory) as $index => $entry)
        {
            $text = $entry->createdDate . ' · ' . $entry->actor . ' · ' . ($labels->actions[$entry->action] ?? $entry->action);
            if(isset($labels->closeOutcomes[$entry->outcome])) $text .= ' · ' . $labels->closeOutcomes[$entry->outcome];
            if($entry->reason !== '') $text .= ' · ' . $entry->reason;
            $actions[] = array('id' => $index + 1, 'action' => $entry->action, 'hasRendered' => true, 'content' => $escape($text));
        }
        disableGlobalRender();
        try
        {
            echo history(set::objectType('reqintake'), set::objectID((int)$item->id), set::actions($actions),
                set::title($labels->history), set::commentBtn(''))->render();
        }
        finally
        {
            enableGlobalRender();
        }
        ?>
    <?php endif; ?>
    <?php if($revisions): ?>
        <details>
            <summary><?= $escape($labels->revisionHistory) ?></summary>
            <?php foreach(array_merge($revisions, array($original)) as $revision): ?>
                <p><?= $escape($revision->title) ?> <?= $escape($revision->actor ?? $original->openedBy) ?> <?= $escape($revision->createdDate ?? '') ?></p>
                <p><?= $escape($revision->customer) ?> · <?= $escape($revision->channel) ?></p>
                <?php if($revision !== $original && isset($revisionDiffs[(int)$revision->version])): ?>
                    <div class="reqintake-revision-changes"><?= $revisionDiffs[(int)$revision->version] ?></div>
                <?php endif; ?>
                <p class="whitespace-pre-wrap"><?= isset($richVersions[(int)($revision === $original ? 1 : $revision->version)]) ? $revision->description : $escape($revision->description) ?></p>
            <?php endforeach; ?>
        </details>
    <?php endif; ?>
    <?php if($duplicateOriginal): ?>
        <p><?= $escape($labels->duplicateOf) ?>
            <a href="<?= $escape(\helper::createLink('reqintake', 'detail', 'id=' . (int)$duplicateOriginal->id)) ?>">#<?= (int)$duplicateOriginal->id ?></a>
        </p>
    <?php endif; ?>
    <?php if($canRevise): ?>
        <details>
            <summary><?= $escape($labels->closeDuplicate) ?></summary>
            <form method="post" class="reqintake-form">
                <input type="hidden" name="intent" value="duplicate">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                <label class="block"><?= $escape($labels->duplicateOf) ?>
                    <input class="form-control" type="number" name="original" min="1" required>
                </label>
                <label class="block"><?= $escape($labels->duplicateReason) ?>
                    <textarea class="form-control" name="reason" maxlength="500" required></textarea>
                </label>
                <button class="btn" type="submit"><?= $escape($labels->closeDuplicate) ?></button>
            </form>
        </details>
    <?php endif; ?>
    <?php require __DIR__ . '/handling.php'; ?>
    <section class="detail-section">
    <h3 class="detail-section-title text-md py-1 font-bold"><?= $escape($labels->attachments) ?></h3>
    <?php if($attachments): ?>
        <ul>
            <?php foreach($attachments as $file): ?>
                <li>
                    <a href="<?= $escape(\helper::createLink('reqintake', 'detail', "id={$item->id}&attachmentID={$file->id}")) ?>"><?= $escape($file->name) ?></a>
                    <?php if($canRevise): ?>
                        <form method="post" class="inline">
                            <input type="hidden" name="intent" value="attachment">
                            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                            <button class="btn" type="submit" name="removeAttachment" value="<?= (int)$file->id ?>"><?= $escape($labels->removeAttachment) ?></button>
                        </form>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if($canRevise): ?>
        <details>
        <summary><?= $escape($labels->uploadAttachment) ?></summary>
        <form method="post" enctype="multipart/form-data" class="reqintake-inline-form">
            <input type="hidden" name="intent" value="attachment">
            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
            <label><?= $escape($labels->attachmentLimit) ?> <input type="file" name="attachment" required></label>
            <button class="btn" type="submit"><?= $escape($labels->uploadAttachment) ?></button>
        </form>
        </details>
    <?php endif; ?>
    </section>
    <section class="detail-section">
    <h3 class="detail-section-title text-md py-1 font-bold"><?= $escape($labels->followupHistory) ?></h3>
    <?php if($followups): ?>
        <ul>
            <?php foreach($followups as $entry): ?>
                <li>
                    <span><?= $escape($entry->actor) ?> · <?= $escape($entry->createdDate) ?></span>
                    <?php if($entry->nextAssignee !== ''): ?>
                        <span><?= $escape(sprintf($labels->transferred, $entry->previousAssignee, $entry->nextAssignee)) ?></span>
                    <?php endif; ?>
                    <p class="whitespace-pre-wrap"><?= $escape($entry->message) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php if($canRevise): ?>
        <?php foreach(array('followup', 'transfer') as $intent): ?>
            <details>
                <summary><?= $escape($labels->$intent) ?></summary>
                <form method="post" class="reqintake-form">
                    <input type="hidden" name="intent" value="<?= $intent ?>">
                    <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                    <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                    <?php if($intent === 'transfer'): ?>
                        <label class="block"><?= $escape($labels->transferAssignee) ?>
                            <input class="form-control" name="assignee" maxlength="30" required>
                        </label>
                    <?php endif; ?>
                    <label class="block"><?= $escape($labels->followupMessage) ?>
                        <textarea class="form-control" name="message" maxlength="500" required></textarea>
                    </label>
                    <button class="btn" type="submit"><?= $escape($labels->$intent) ?></button>
                </form>
            </details>
        <?php endforeach; ?>
    <?php endif; ?>
    </section>
    <section class="detail-section">
    <h3 class="detail-section-title text-md py-1 font-bold"><?= $escape($labels->linkedStories) ?></h3>
    <ul>
        <?php foreach($linkedStories as $story): ?>
            <li>
                <span><?= $escape($labels->storyTypes[$story->targetType]) ?></span>
                <?php if($story->id):
                    $module = $story->targetType;
                    $parameter = match($module) {'bug' => 'bugID', 'task' => 'taskID', default => 'storyID'};
                    $targetLang = in_array($module, array('bug', 'task'), true) ? $lang->$module : $lang->story;
                    $reasons = $module === 'bug' ? $targetLang->resolutionList : ($targetLang->reasonList ?? array());
                ?>
                    <a href="<?= $escape(\helper::createLink($story->targetType, 'view', $parameter . '=' . (int)$story->id)) ?>"><?= $escape($story->title) ?></a>
                    <span><?= $escape($targetLang->statusList[$story->status] ?? $story->status) ?></span>
                    <?php if($story->branchStages): ?>
                        <ul>
                            <?php foreach($story->branchStages as $branch => $stage): ?>
                                <li><?= $escape($scopeOptions['branches'][$branch] ?? '#' . $branch) ?> · <?= $escape($stage === '' ? $labels->branchStageUnknown : ($lang->story->stageList[$stage] ?? $stage)) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <span><?= $escape($lang->story->stageList[$story->stage] ?? $story->stage) ?></span>
                    <?php endif; ?>
                    <?php if($story->closedReason): ?>
                        <span><?= $escape($reasons[$story->closedReason] ?? $story->closedReason) ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <span><?= $escape($labels->storyUnavailable) ?></span>
                <?php endif; ?>
                <?php if($story->reviewReason !== ''): ?>
                    <span><?= $escape($labels->reviewTarget[$story->reviewReason]) ?></span>
                <?php endif; ?>
                <?php if($story->checkedDate): ?><span><?= $escape(sprintf($labels->checkedDate, $story->checkedDate)) ?></span><?php endif; ?>
                <?php if(isset($labels->linkMethods[$story->method])): ?><span><?= $escape($labels->linkMethods[$story->method]) ?></span><?php endif; ?>
                <?php if($story->scope !== ''): ?><span><?= $escape($story->scope) ?></span><?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if($conversionLinks || $taskExecutions || $canLink): ?>
    <details id="reqintake-linked-work">
        <summary><?= $escape($labels->manageLinkedWork) ?></summary>
    <div class="toolbar gap-2 flex-wrap">
    <?php foreach($conversionLinks as $type => $url): ?>
        <a class="btn" href="<?= $escape($url) ?>"><?= $escape(sprintf($labels->createTarget, $labels->storyTypes[$type])) ?></a>
    <?php endforeach; ?>
    </div>
    <?php if($taskExecutions): ?>
        <form method="post" class="reqintake-form">
            <input type="hidden" name="intent" value="taskCreate">
            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
            <label><?= $escape($labels->taskExecution) ?>
                <select name="execution" required>
                    <option value=""></option>
                    <?php foreach($taskExecutions as $id => $name): ?><option value="<?= (int)$id ?>"><?= $escape($name) ?></option><?php endforeach; ?>
                </select>
            </label>
            <button class="btn" type="submit"><?= $escape(sprintf($labels->createTarget, $labels->storyTypes['task'])) ?></button>
        </form>
    <?php endif; ?>
    <?php if($canLink): ?>
        <form method="post" class="reqintake-form">
            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
            <label><?= $escape($labels->storyType) ?>
                <select name="storyType" class="form-control">
                    <?php foreach($storyTypes as $type): ?><option value="<?= $escape($type) ?>"><?= $escape($labels->storyTypes[$type]) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label><?= $escape($labels->storyID) ?> <input class="form-control" name="storyID" type="number" min="1" required></label>
            <label><?= $escape($labels->linkScope) ?> <input class="form-control" name="linkScope" maxlength="500"></label>
            <button type="submit" class="btn"><?= $escape($labels->linkStory) ?></button>
        </form>
    <?php endif; ?>
    </details>
    <?php endif; ?>
    </section>
    <?php if($canTransition): ?>
        <details id="reqintake-workflow" class="reqintake-form-panel">
            <summary><?= $escape($labels->actionsLabel) ?></summary>
            <form method="post" class="reqintake-form">
                <input type="hidden" name="intent" value="transition">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                <label><?= $escape($labels->transitionReason) ?> <input class="form-control" name="reason" maxlength="500"></label>
                <?php if($item->status !== 'closed') require __DIR__ . '/closure-fields.php'; ?>
                <?php foreach(match($item->status) {'pending' => ['start', 'accept', 'close'], 'tracking' => ['close'], 'closed' => ['reopen'], default => []} as $action): ?>
                    <button type="submit" class="btn" name="action" value="<?= $escape($action) ?>"><?= $escape($labels->actions[$action]) ?></button>
                <?php endforeach; ?>
            </form>
        </details>
    <?php endif; ?>
</article>
<?php
$mainContent = ob_get_clean();
ob_start();
?>
<aside class="reqintake-detail-info">
    <dl>
        <dt><?= $escape($labels->fields['product']) ?></dt>
        <dd><?= $escape($item->productName) ?></dd>
        <dt><?= $escape($labels->submitter) ?></dt>
        <dd><?= $escape($item->openedBy) ?></dd>
        <dt><?= $escape($labels->listColumns[3]) ?></dt>
        <dd><?= $escape($item->assignedTo) ?><?php if($item->assignmentPending): ?> (<?= $escape($labels->ownerPending) ?>)<?php endif; ?></dd>
        <dt><?= $escape($labels->listColumns[4]) ?></dt>
        <dd><span class="status-<?= $item->status === 'tracking' ? 'doing' : ($item->status === 'closed' ? 'closed' : 'wait') ?>"><?= $escape($labels->states[$item->status] ?? $item->status) ?></span></dd>
        <?php foreach(array('customer', 'channel') as $field): ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd style="white-space: pre-wrap"><?= $escape($item->$field) ?></dd>
        <?php endforeach; ?>
        <?php foreach($attributes as $field => $value): ?>
            <?php if(in_array($field, array('acceptance', 'branchModules', 'mailto', 'suggestedReviewers'), true)) continue; ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd style="white-space: pre-wrap"><?= $escape($scopeLabels[$field][$value] ?? $attributeOptions[$field][$value] ?? $value) ?></dd>
        <?php endforeach; ?>
        <?php foreach(array('mailto', 'suggestedReviewers') as $field): ?>
            <?php if($attributes[$field] === '') continue; ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd><?= $escape(implode('、', array_map(static fn($account) => $mailtoOptions[$account] ?? $account, explode(',', $attributes[$field])))) ?></dd>
        <?php endforeach; ?>
        <?php if($attributes['branchModules']): ?>
            <dt><?= $escape($labels->additionalBranches) ?></dt>
            <dd>
                <ul>
                    <?php foreach($attributes['branchModules'] as $branch => $module): ?>
                        <li><?= $escape($scopeOptions['branches'][$branch] ?? '#' . $branch) ?> · <?= $escape($scopeOptions['modules'][$branch][$module] ?? '#' . $module) ?></li>
                    <?php endforeach; ?>
                </ul>
            </dd>
        <?php endif; ?>
    </dl>
</aside>
<?php
$sideContent = ob_get_clean();
$actions = array();
if($canRevise) $actions[] = array('text' => $labels->editFeedback, 'icon' => 'edit', 'data-reqintake-open' => 'reqintake-edit');
if($conversionLinks || $taskExecutions || $canLink) $actions[] = array(
    'text' => $labels->manageLinkedWork, 'icon' => 'link', 'data-reqintake-open' => 'reqintake-linked-work'
);
if($canTransition) $actions[] = array('text' => $labels->actionsLabel, 'icon' => 'cog', 'data-reqintake-open' => 'reqintake-workflow');

detail
(
    set::objectType('reqintake'),
    set::object($item),
    set::backBtn(array('url' => \helper::createLink('reqintake', 'index'))),
    set::history(false),
    set::sections(array(array('control' => 'html', 'content' => $mainContent))),
    set::tabs(array(array('group' => 'basic', 'title' => $labels->basicInfo, 'control' => 'html', 'content' => $sideContent))),
    set::actions($actions)
);
require __DIR__ . '/product-scope-js.php';
context::js('document.querySelectorAll("form:has(input[name=intent][value=revise])").forEach(form => reqintakeScope(form, ' .
    json_encode($scopeOptions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_INVALID_UTF8_SUBSTITUTE) . ', form.elements.module.dataset.initial));');

context::css(<<<'CSS'
.detail-view[data-type="reqintake"] .detail-sections {padding-bottom: 1.5rem;}
.reqintake-detail-content, .reqintake-detail-info {white-space: normal;}
.reqintake-detail-info dl {display: grid; grid-template-columns: minmax(6rem, 2fr) minmax(0, 3fr); align-items: baseline; gap: .375rem .75rem;}
.reqintake-detail-info dt {text-align: right; font-weight: 400; color: var(--color-gray-600);}
.reqintake-detail-info dd {min-width: 0; padding-left: 0; overflow-wrap: anywhere;}
.reqintake-detail-content > * + * {margin-top: 1rem;}
.reqintake-detail-content .article {overflow-wrap: anywhere;}
.reqintake-detail-content .article img {max-width: 100%; height: auto;}
.reqintake-spec dd {margin: .25rem 0 1rem; padding-left: 0;}
.reqintake-detail-content .detail-section-title {font-size: 1rem; margin: 0 0 .375rem;}
.reqintake-form-panel, .reqintake-detail-content details {border-top: 1px solid var(--color-border); padding: .75rem 0;}
.reqintake-detail-content summary {font-weight: 600; cursor: pointer;}
.reqintake-detail-content details > summary + :not(form) {margin-top: .625rem;}
.reqintake-form {margin-top: .75rem; display: grid; gap: .625rem;}
.reqintake-form > button {justify-self: start;}
.reqintake-inline-form {display: flex; flex-wrap: wrap; align-items: center; gap: .5rem; margin: .5rem 0;}
.reqintake-form :is(input:not([type="hidden"],[type="checkbox"]), select, textarea) {max-width: 100%;}
.reqintake-edit-fields {display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .5rem 1rem;}
.reqintake-edit-fields > :is(fieldset, label:has(zen-editor)) {grid-column: 1 / -1;}
@media (max-width: 800px) {
    .detail-view[data-type="reqintake"] .detail-body {flex-direction: column;}
    .detail-view[data-type="reqintake"] .detail-main, .detail-view[data-type="reqintake"] .detail-side {width: 100% !important;}
    .detail-view[data-type="reqintake"] .detail-toggle {display: none;}
    .reqintake-edit-fields {grid-template-columns: minmax(0, 1fr);}
}
CSS);
context::js(<<<'JS'
document.querySelectorAll('[data-reqintake-open]').forEach(button => {
    button.addEventListener('click', () => {
        const section = document.getElementById(button.dataset.reqintakeOpen);
        if (!section) return;
        section.open = true;
        section.scrollIntoView({block: 'center'});
        section.querySelector('summary').focus({preventScroll: true});
    });
});
JS);
