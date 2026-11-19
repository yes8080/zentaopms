<?php
namespace zin;

$labels = $lang->reqintake;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$renderEditor = require __DIR__ . '/rich-editor.php';
$revisionVersion = (int)($revisions[0]->version ?? 1);
$rich = isset($richVersions[$revisionVersion]);
ob_start();
?>
<section class="reqintake-detail">
    <a href="<?= $escape(\helper::createLink('reqintake', 'index')) ?>"><?= $escape($labels->common) ?></a>
    <h2>#<?= (int)$item->id ?> <?= $escape($item->title) ?></h2>
    <div class="reqintake-detail-grid">
    <article class="reqintake-detail-content panel p-4">
    <dl>
        <dt><?= $escape($labels->fields['description']) ?></dt>
        <dd class="whitespace-pre-wrap"><?= $rich ? $item->description : $escape($item->description) ?></dd>
        <dt><?= $escape($labels->fields['acceptance']) ?></dt>
        <dd class="whitespace-pre-wrap"><?= $rich ? $attributes['acceptance'] : $escape($attributes['acceptance']) ?></dd>
    </dl>
    <?php if($canRevise): ?>
        <details id="reqintake-edit" <?= isset($revisionInput) ? 'open' : '' ?>>
            <summary><?= $escape($labels->editFeedback) ?></summary>
            <form method="post">
                <input type="hidden" name="intent" value="revise">
                <input type="hidden" name="bodyFormat" value="rich">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= $revisionInputVersion ?? (int)$item->version ?>">
                <?php foreach(array('title' => 255, 'customer' => 255, 'channel' => 64) as $field => $limit): ?>
                    <label class="block"><?= $escape($labels->fields[$field]) ?>
                        <input name="<?= $field ?>" value="<?= $escape($revisionInput[$field] ?? $item->$field) ?>" maxlength="<?= $limit ?>" <?= $field === 'title' ? 'required' : '' ?>>
                    </label>
                <?php endforeach; ?>
                <label class="block"><?= $escape($labels->fields['description']) ?>
                    <?= $renderEditor('description', $revisionInput['description'] ?? $item->description, $revisionInputRich ?? $rich) ?>
                </label>
                <?php
                $values = ($revisionInput ?? array()) + $attributes;
                if(isset($revisionInputRich)) $rich = $revisionInputRich;
                require __DIR__ . '/attribute-fields.php';
                $rich = isset($richVersions[$revisionVersion]);
                ?>
                <button class="btn" type="submit"><?= $escape($labels->editFeedback) ?></button>
            </form>
        </details>
    <?php endif; ?>
    <?php if($stateHistory): ?>
        <?php
        $actions = array();
        foreach(array_reverse($stateHistory) as $index => $entry)
        {
            $text = $entry->createdDate . ' · ' . $entry->actor . ' · ' . ($labels->actions[$entry->action] ?? $entry->action);
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
            <form method="post">
                <input type="hidden" name="intent" value="duplicate">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                <label class="block"><?= $escape($labels->duplicateOf) ?>
                    <input type="number" name="original" min="1" required>
                </label>
                <label class="block"><?= $escape($labels->duplicateReason) ?>
                    <textarea name="reason" maxlength="500" required></textarea>
                </label>
                <button class="btn" type="submit"><?= $escape($labels->closeDuplicate) ?></button>
            </form>
        </details>
    <?php endif; ?>
    <?php require __DIR__ . '/handling.php'; ?>
    <h3><?= $escape($labels->attachments) ?></h3>
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
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="intent" value="attachment">
            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
            <label><?= $escape($labels->attachmentLimit) ?> <input type="file" name="attachment" required></label>
            <button class="btn" type="submit"><?= $escape($labels->uploadAttachment) ?></button>
        </form>
    <?php endif; ?>
    <h3><?= $escape($labels->followupHistory) ?></h3>
    <?php if(isset($formError)): ?><p role="alert"><?= $escape($formError) ?></p><?php endif; ?>
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
                <form method="post">
                    <input type="hidden" name="intent" value="<?= $intent ?>">
                    <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                    <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                    <?php if($intent === 'transfer'): ?>
                        <label class="block"><?= $escape($labels->transferAssignee) ?>
                            <input name="assignee" maxlength="30" required>
                        </label>
                    <?php endif; ?>
                    <label class="block"><?= $escape($labels->followupMessage) ?>
                        <textarea name="message" maxlength="500" required></textarea>
                    </label>
                    <button class="btn" type="submit"><?= $escape($labels->$intent) ?></button>
                </form>
            </details>
        <?php endforeach; ?>
    <?php endif; ?>
    <h3><?= $escape($labels->linkedStories) ?></h3>
    <?php foreach($conversionLinks as $type => $url): ?>
        <a class="btn" href="<?= $escape($url) ?>"><?= $escape(sprintf($labels->createTarget, $labels->storyTypes[$type])) ?></a>
    <?php endforeach; ?>
    <?php if($taskExecutions): ?>
        <form method="post">
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
                <?php if($story->checkedDate): ?><span><?= $escape(sprintf($labels->checkedDate, $story->checkedDate)) ?></span><?php endif; ?>
                <?php if(isset($labels->linkMethods[$story->method])): ?><span><?= $escape($labels->linkMethods[$story->method]) ?></span><?php endif; ?>
                <?php if($story->scope !== ''): ?><span><?= $escape($story->scope) ?></span><?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if($canLink): ?>
        <form method="post">
            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
            <label><?= $escape($labels->storyType) ?>
                <select name="storyType">
                    <?php foreach($storyTypes as $type): ?><option value="<?= $escape($type) ?>"><?= $escape($labels->storyTypes[$type]) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label><?= $escape($labels->storyID) ?> <input name="storyID" type="number" min="1" required></label>
            <label><?= $escape($labels->linkScope) ?> <input name="linkScope" maxlength="500"></label>
            <button type="submit" class="btn"><?= $escape($labels->linkStory) ?></button>
        </form>
    <?php endif; ?>
    <?php if($canTransition): ?>
        <details id="reqintake-workflow">
            <summary><?= $escape($labels->actionsLabel) ?></summary>
            <form method="post">
                <input type="hidden" name="intent" value="transition">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                <label><?= $escape($labels->transitionReason) ?> <input name="reason" maxlength="500"></label>
                <?php foreach(match($item->status) {'pending' => ['start', 'close'], 'tracking' => ['close'], 'closed' => ['reopen'], default => []} as $action): ?>
                    <button type="submit" class="btn" name="action" value="<?= $escape($action) ?>"><?= $escape($labels->actions[$action]) ?></button>
                <?php endforeach; ?>
            </form>
        </details>
    <?php endif; ?>
    </article>
    <aside class="panel p-4 reqintake-detail-info">
    <h3><?= $escape($labels->basicInfo) ?></h3>
    <dl>
        <dt><?= $escape($labels->fields['product']) ?></dt>
        <dd><?= $escape($item->productName) ?></dd>
        <dt><?= $escape($labels->submitter) ?></dt>
        <dd><?= $escape($item->openedBy) ?></dd>
        <dt><?= $escape($labels->listColumns[3]) ?></dt>
        <dd><?= $escape($item->assignedTo) ?><?php if($item->assignmentPending): ?> (<?= $escape($labels->ownerPending) ?>)<?php endif; ?></dd>
        <dt><?= $escape($labels->listColumns[4]) ?></dt>
        <dd><?= $escape($labels->states[$item->status] ?? $item->status) ?></dd>
        <?php foreach(array('customer', 'channel') as $field): ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd style="white-space: pre-wrap"><?= $escape($item->$field) ?></dd>
        <?php endforeach; ?>
        <?php foreach($attributes as $field => $value): ?>
            <?php if(in_array($field, array('acceptance', 'branchModules', 'mailto'), true)) continue; ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd style="white-space: pre-wrap"><?= $escape($scopeLabels[$field][$value] ?? $attributeOptions[$field][$value] ?? $value) ?></dd>
        <?php endforeach; ?>
        <?php if($attributes['mailto'] !== ''): ?>
            <dt><?= $escape($labels->fields['mailto']) ?></dt>
            <dd><?= $escape(implode('、', array_map(static fn($account) => $mailtoOptions[$account] ?? $account, explode(',', $attributes['mailto'])))) ?></dd>
        <?php endif; ?>
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
    </div>
    <?php if($canTransition): ?>
        <nav class="reqintake-detail-toolbar" aria-label="<?= $escape($labels->actionsLabel) ?>">
            <?php if($canRevise): ?>
                <button class="btn ghost" type="button" data-reqintake-open="reqintake-edit"><?= $escape($labels->editFeedback) ?></button>
            <?php endif; ?>
            <button class="btn ghost" type="button" data-reqintake-open="reqintake-workflow"><?= $escape($labels->actionsLabel) ?></button>
        </nav>
    <?php endif; ?>
</section>
<?php
html(ob_get_clean());
require __DIR__ . '/product-scope-js.php';
context::js('document.querySelectorAll("form:has(input[name=intent][value=revise])").forEach(form => reqintakeScope(form, ' .
    json_encode($scopeOptions, JSON_HEX_TAG | JSON_HEX_AMP | JSON_INVALID_UTF8_SUBSTITUTE) . ', form.elements.module.dataset.initial));');

context::css(<<<'CSS'
.reqintake-detail {padding-bottom: 4rem;}
.reqintake-detail-grid {display: grid; grid-template-columns: minmax(0, 1fr) minmax(16rem, 27%); gap: 1rem; align-items: start;}
.reqintake-detail-content {grid-area: 1 / 1;}
.reqintake-detail-info {grid-area: 1 / 2;}
.reqintake-detail dd {margin-bottom: .5rem; overflow-wrap: anywhere;}
.reqintake-detail-toolbar {position: fixed; bottom: 1rem; left: 50%; transform: translateX(-50%); background: #303642; color: white; border-radius: .25rem; padding: .25rem; z-index: 10;}
.reqintake-detail-toolbar .btn {color: inherit;}
@media (max-width: 800px) {
    .reqintake-detail-grid {grid-template-columns: minmax(0, 1fr);}
    .reqintake-detail-info {grid-area: 2 / 1;}
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
