<?php
namespace zin;

$labels = $lang->reqintake;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
ob_start();
?>
<section class="panel p-4">
    <a href="<?= $escape(\helper::createLink('reqintake', 'index')) ?>"><?= $escape($labels->common) ?></a>
    <h2>#<?= (int)$item->id ?> <?= $escape($item->title) ?></h2>
    <dl>
        <dt><?= $escape($labels->fields['product']) ?></dt>
        <dd><?= $escape($item->productName) ?></dd>
        <dt><?= $escape($labels->submitter) ?></dt>
        <dd><?= $escape($item->openedBy) ?></dd>
        <dt><?= $escape($labels->listColumns[3]) ?></dt>
        <dd><?= $escape($item->assignedTo) ?><?php if($item->assignmentPending): ?> (<?= $escape($labels->ownerPending) ?>)<?php endif; ?></dd>
        <dt><?= $escape($labels->listColumns[4]) ?></dt>
        <dd><?= $escape($labels->states[$item->status] ?? $item->status) ?></dd>
        <?php foreach(array('customer', 'channel', 'description') as $field): ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd style="white-space: pre-wrap"><?= $escape($item->$field) ?></dd>
        <?php endforeach; ?>
    </dl>
    <?php if($canRevise): ?>
        <details>
            <summary><?= $escape($labels->editFeedback) ?></summary>
            <form method="post">
                <input type="hidden" name="intent" value="revise">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                <?php foreach(array('title' => 255, 'customer' => 255, 'channel' => 64) as $field => $limit): ?>
                    <label class="block"><?= $escape($labels->fields[$field]) ?>
                        <input name="<?= $field ?>" value="<?= $escape($item->$field) ?>" maxlength="<?= $limit ?>" <?= $field === 'title' ? 'required' : '' ?>>
                    </label>
                <?php endforeach; ?>
                <label class="block"><?= $escape($labels->fields['description']) ?>
                    <textarea name="description" required><?= $escape($item->description) ?></textarea>
                </label>
                <button class="btn" type="submit"><?= $escape($labels->editFeedback) ?></button>
            </form>
        </details>
    <?php endif; ?>
    <?php if($revisions): ?>
        <details>
            <summary><?= $escape($labels->revisionHistory) ?></summary>
            <?php foreach(array_merge($revisions, array($original)) as $revision): ?>
                <p><?= $escape($revision->title) ?> <?= $escape($revision->actor ?? $original->openedBy) ?> <?= $escape($revision->createdDate ?? '') ?></p>
                <p><?= $escape($revision->customer) ?> · <?= $escape($revision->channel) ?></p>
                <p class="whitespace-pre-wrap"><?= $escape($revision->description) ?></p>
            <?php endforeach; ?>
        </details>
    <?php endif; ?>
    <h3><?= $escape($labels->linkedStories) ?></h3>
    <?php if(isset($formError)): ?><p role="alert"><?= $escape($formError) ?></p><?php endif; ?>
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
                    <span><?= $escape($lang->story->stageList[$story->stage] ?? $story->stage) ?></span>
                    <?php if($story->closedReason): ?>
                        <span><?= $escape($reasons[$story->closedReason] ?? $story->closedReason) ?></span>
                    <?php endif; ?>
                <?php else: ?>
                    <span><?= $escape($labels->storyUnavailable) ?></span>
                <?php endif; ?>
                <?php if($story->checkedDate): ?><span><?= $escape(sprintf($labels->checkedDate, $story->checkedDate)) ?></span><?php endif; ?>
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
</section>
<?php
html(ob_get_clean());
