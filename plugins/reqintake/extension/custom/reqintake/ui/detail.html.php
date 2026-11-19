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
    <h3><?= $escape($labels->linkedStories) ?></h3>
    <?php if(isset($formError)): ?><p role="alert"><?= $escape($formError) ?></p><?php endif; ?>
    <ul>
        <?php foreach($linkedStories as $story): ?>
            <li><a href="<?= $escape(\helper::createLink('story', 'view', 'storyID=' . (int)$story->id)) ?>"><?= $escape($story->title) ?></a>
                <span><?= $escape($story->scope) ?></span>
            </li>
        <?php endforeach; ?>
    </ul>
    <?php if($canLink): ?>
        <form method="post">
            <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
            <input type="hidden" name="version" value="<?= (int)$item->version ?>">
            <label><?= $escape($labels->storyID) ?> <input name="storyID" type="number" min="1" required></label>
            <label><?= $escape($labels->linkScope) ?> <input name="linkScope" maxlength="500"></label>
            <button type="submit" class="btn"><?= $escape($labels->linkStory) ?></button>
        </form>
    <?php endif; ?>
</section>
<?php
html(ob_get_clean());
