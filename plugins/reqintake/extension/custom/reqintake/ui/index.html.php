<?php
namespace zin;

$labels = $lang->reqintake;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
ob_start();
?>
<section class="panel p-4">
    <h2><?= $escape($labels->common) ?></h2>
    <?php if(isset($formError)): ?><p role="alert"><?= $escape($formError) ?></p><?php endif; ?>
    <?php if(isset($savedID)): ?><p role="status"><?= $escape(sprintf($labels->saved, $savedID)) ?></p><?php endif; ?>
    <form method="post">
        <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
        <input type="hidden" name="token" value="<?= $escape($token) ?>">
        <label class="block mb-2"><?= $escape($labels->fields['product']) ?>
            <select class="form-control" name="product" required>
                <option value=""></option>
                <?php foreach($products as $id => $name): ?>
                    <option value="<?= (int)$id ?>" <?= (string)$id === $fields['product'] ? 'selected' : '' ?>><?= $escape($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <?php foreach(array('title' => 255, 'customer' => 255, 'channel' => 64) as $name => $limit): ?>
            <label class="block mb-2"><?= $escape($labels->fields[$name]) ?>
                <input class="form-control" name="<?= $name ?>" value="<?= $escape($fields[$name]) ?>" maxlength="<?= $limit ?>" <?= $name === 'title' ? 'required' : '' ?>>
            </label>
        <?php endforeach; ?>
        <label class="block mb-2"><?= $escape($labels->fields['description']) ?>
            <textarea class="form-control" name="description" required><?= $escape($fields['description']) ?></textarea>
        </label>
        <button class="btn primary" type="submit"><?= $escape($labels->submit) ?></button>
    </form>
    <hr>
    <?php if(isset($ownerSaved)): ?><p role="status"><?= $escape($labels->ownerSaved) ?></p><?php endif; ?>
    <form method="post">
        <input type="hidden" name="intent" value="owner">
        <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
        <input type="hidden" name="token" value="<?= $escape($token) ?>">
        <label class="block mb-2"><?= $escape($labels->fields['product']) ?>
            <select class="form-control" name="product" required>
                <option value=""></option>
                <?php foreach($products as $id => $name): ?>
                    <option value="<?= (int)$id ?>"><?= $escape($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label class="block mb-2"><?= $escape($labels->ownerAccount) ?>
            <input class="form-control" name="owner" maxlength="30">
        </label>
        <button class="btn" type="submit"><?= $escape($labels->saveOwner) ?></button>
    </form>
    <hr>
    <h3><?= $escape($labels->recent) ?></h3>
    <nav class="mb-2">
        <?php foreach($labels->scopes as $key => $label): ?>
            <a class="btn" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$key")) ?>" <?= $key === $scope ? 'aria-current="page"' : '' ?>><?= $escape($label) ?></a>
        <?php endforeach; ?>
    </nav>
    <?php if(!$feedback): ?>
        <p><?= $escape($labels->emptyList) ?></p>
    <?php else: ?>
        <table class="table">
            <thead><tr>
                <?php foreach($labels->listColumns as $column): ?><th scope="col"><?= $escape($column) ?></th><?php endforeach; ?>
                <th scope="col"><?= $escape($labels->actionsLabel) ?></th>
            </tr></thead>
            <tbody>
                <?php foreach($feedback as $item): ?>
                    <tr>
                        <td>#<?= (int)$item->id ?></td>
                        <td>
                            <a href="<?= $escape(\helper::createLink('reqintake', 'detail', "id=" . (int)$item->id)) ?>"><?= $escape($item->title) ?></a>
                            <?php if(!empty($history[$item->id])): ?>
                                <details>
                                    <summary><?= $escape($labels->history) ?></summary>
                                    <ul>
                                        <?php foreach($history[$item->id] as $entry): ?>
                                            <li>
                                                <time><?= $escape($entry->createdDate) ?></time>
                                                <?= $escape($entry->actor) ?>
                                                <?= $escape($labels->actions[$entry->action] ?? $entry->action) ?>
                                                <?php if($entry->reason !== ''): ?>: <?= $escape($entry->reason) ?><?php endif; ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </details>
                            <?php endif; ?>
                        </td>
                        <td><?= $escape($item->productName) ?></td>
                        <td><?= $escape($item->assignedTo) ?><?php if($item->assignmentPending): ?> (<?= $escape($labels->ownerPending) ?>)<?php endif; ?></td>
                        <td><?= $escape($labels->states[$item->status] ?? $item->status) ?></td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="intent" value="transition">
                                <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
                                <input type="hidden" name="token" value="<?= $escape($token) ?>">
                                <input type="hidden" name="feedbackID" value="<?= (int)$item->id ?>">
                                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                                <label><?= $escape($labels->transitionReason) ?>
                                    <input name="reason" class="form-control" maxlength="500">
                                </label>
                                <?php foreach(match($item->status) {'pending' => ['start', 'close'], 'tracking' => ['close'], 'closed' => ['reopen'], default => []} as $action): ?>
                                    <button class="btn" type="submit" name="action" value="<?= $escape($action) ?>"><?= $escape($labels->actions[$action]) ?></button>
                                <?php endforeach; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>
<?php
html(ob_get_clean());
