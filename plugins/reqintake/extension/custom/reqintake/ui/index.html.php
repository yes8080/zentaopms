<?php
namespace zin;

$labels = $lang->reqintake;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$renderEditor = require __DIR__ . '/rich-editor.php';
$rich = $inputRich;
$filterParams = "&filterOwner=" . rawurlencode($filterOwner) . "&filterStatus=" . rawurlencode($filterStatus)
    . "&updatedFrom=" . str_replace('-', '', $updatedFrom) . "&updatedTo=" . str_replace('-', '', $updatedTo) . '&filterID=' . $filterID;
$filters = "&beforeUpdate=$filterParams";
$baseParams = "previewProduct=0&beforeID=0&sort=$sort$filters";
$columns = array(
    'product' => $labels->listColumns[2], 'owner' => $labels->listColumns[3], 'status' => $labels->listColumns[4],
    'next' => $labels->handlingNext, 'customer' => $labels->fields['customer'], 'updated' => $labels->updatedDate
);
ob_start();
?>
<section class="panel p-4">
    <h2><?= $escape($labels->common) ?></h2>
    <?php if(isset($formError)): ?><p role="alert"><?= $escape($formError) ?></p><?php endif; ?>
    <?php if(isset($savedID)): ?><p role="status"><?= $escape(sprintf($labels->saved, $savedID)) ?></p><?php endif; ?>
    <form id="reqintake-receive" method="post" enctype="multipart/form-data">
        <input type="hidden" name="bodyFormat" value="rich">
        <input type="hidden" name="openDetail" value="1">
        <p role="alert" data-reqintake-upload-error data-failed="<?= $escape($labels->submitRetry) ?>" hidden></p>
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
        <output class="block mb-2" aria-live="polite"
            data-url="<?= $escape(\helper::createLink('reqintake', 'index', 'scope=all&filterProduct=0&previewProduct=987654321')) ?>"
            data-owner="<?= $escape($labels->ownerAccount) ?>"
            data-pending="<?= $escape($labels->ownerPending) ?>"
            data-unavailable="<?= $escape($labels->ownerPreviewUnavailable) ?>"></output>
        <?php foreach(array('title' => 255, 'customer' => 255, 'channel' => 64) as $name => $limit): ?>
            <label class="block mb-2"><?= $escape($labels->fields[$name]) ?>
                <input class="form-control" name="<?= $name ?>" value="<?= $escape($fields[$name]) ?>" maxlength="<?= $limit ?>" <?= $name === 'title' ? 'required' : '' ?>>
            </label>
        <?php endforeach; ?>
        <label class="block mb-2"><?= $escape($labels->fields['description']) ?>
            <?= $renderEditor('description', $fields['description'], $rich) ?>
        </label>
        <?php $values = $fields; require __DIR__ . '/attribute-fields.php'; ?>
        <label class="block mb-2"><?= $escape($labels->attachmentLimit) ?>
            <input type="file" name="attachment">
        </label>
        <?php if(isset($formError) && isset($_FILES['attachment']) && ($_FILES['attachment']['error'] ?? null) !== UPLOAD_ERR_NO_FILE): ?>
            <p><?= $escape($labels->reselectAttachment) ?></p>
        <?php endif; ?>
        <button class="btn primary" type="submit"><?= $escape($labels->submit) ?></button>
    </form>
    <?php if($isAdmin): ?>
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
    <?php endif; ?>
    <hr>
    <h3><?= $escape($labels->recent) ?></h3>
    <nav class="mb-2">
        <?php foreach($labels->scopes as $key => $label): ?>
            <a class="btn" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$key&filterProduct=$filterProduct&$baseParams")) ?>" <?= $key === $scope ? 'aria-current="page"' : '' ?>><?= $escape($label) ?></a>
        <?php endforeach; ?>
    </nav>
    <nav class="mb-2" aria-label="<?= $escape($labels->fields['product']) ?>">
        <?php foreach(array(0 => $labels->allProducts) + $products as $productID => $productName): ?>
            <a class="btn" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$scope&filterProduct=" . (int)$productID . "&$baseParams")) ?>" <?= (int)$productID === $filterProduct ? 'aria-current="page"' : '' ?>><?= $escape($productName) ?></a>
        <?php endforeach; ?>
    </nav>
    <form method="post" class="mb-2">
        <input type="hidden" name="intent" value="filter">
        <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
        <input type="hidden" name="token" value="<?= $escape($token) ?>">
        <label><?= $escape($labels->feedbackID) ?>
            <input type="number" name="filterID" min="1" max="4294967295" value="<?= $filterID ?: '' ?>">
        </label>
        <label><?= $escape($labels->listColumns[3]) ?>
            <select name="filterOwner">
                <?php foreach(array('' => $labels->anyFilter) + $mailtoOptions as $account => $name): ?>
                    <option value="<?= $escape($account) ?>" <?= (string)$account === $filterOwner ? 'selected' : '' ?>><?= $escape($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label><?= $escape($labels->listColumns[4]) ?>
            <select name="filterStatus">
                <?php foreach(array('' => $labels->anyFilter) + $labels->states as $status => $name): ?>
                    <option value="<?= $escape($status) ?>" <?= $status === $filterStatus ? 'selected' : '' ?>><?= $escape($name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <label><?= $escape($labels->updatedFrom) ?> <input type="date" name="updatedFrom" value="<?= $escape($updatedFrom) ?>"></label>
        <label><?= $escape($labels->updatedTo) ?> <input type="date" name="updatedTo" value="<?= $escape($updatedTo) ?>"></label>
        <button class="btn" type="submit"><?= $escape($labels->filterFeedback) ?></button>
    </form>
    <?php if(!$feedback): ?>
        <p><?= $escape($labels->emptyList) ?></p>
    <?php else: ?>
        <?php if(isset($batchCount)): ?><p role="status"><?= $escape(sprintf($labels->batchSuccess, $batchCount)) ?></p><?php endif; ?>
        <?php if($batchTypes): ?>
            <form method="post" id="reqintake-batch-link" class="mb-2">
                <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
                <input type="hidden" name="token" value="<?= $escape($token) ?>">
                <label><?= $escape($labels->storyType) ?>
                    <select name="storyType">
                        <?php foreach($batchTypes as $type): ?><option value="<?= $escape($type) ?>"><?= $escape($labels->storyTypes[$type]) ?></option><?php endforeach; ?>
                    </select>
                </label>
                <label><?= $escape($labels->storyID) ?> <input name="storyID" type="number" min="1" required></label>
                <label><?= $escape($labels->batchScope) ?> <input name="linkScope" maxlength="500"></label>
                <button class="btn" type="submit" name="intent" value="batchLink"><?= $escape($labels->batchLink) ?></button>
                <?php if($canBatchCreate): ?>
                    <button class="btn" type="submit" name="intent" value="batchCreate" formnovalidate><?= $escape($labels->batchCreate) ?></button>
                <?php endif; ?>
            </form>
        <?php endif; ?>
        <div class="mb-2">
            <nav aria-label="<?= $escape($labels->sortFeedback) ?>">
                <?php foreach(array('id' => $labels->sortRecent, 'updated' => $labels->updatedDate) as $key => $label): ?>
                    <a class="btn" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$scope&filterProduct=$filterProduct&previewProduct=0&beforeID=0&sort=$key$filters")) ?>" <?= $sort === $key ? 'aria-current="page"' : '' ?>><?= $escape($label) ?></a>
                <?php endforeach; ?>
            </nav>
            <details id="reqintake-column-settings" data-account="<?= $escape($currentAccount) ?>">
                <summary><?= $escape($labels->visibleColumns) ?></summary>
                <?php foreach($columns as $key => $label): ?>
                    <label><input type="checkbox" value="<?= $key ?>" checked> <?= $escape($label) ?></label>
                <?php endforeach; ?>
            </details>
        </div>
        <table class="table" id="reqintake-results">
            <thead><tr>
                <?php if($batchTypes): ?><th scope="col"><?= $escape($labels->batchSelect) ?></th><?php endif; ?>
                <th scope="col"><?= $escape($labels->listColumns[0]) ?></th>
                <th scope="col"><?= $escape($labels->listColumns[1]) ?></th>
                <?php foreach($columns as $key => $label): ?>
                    <th scope="col" data-column="<?= $key ?>"><?= $escape($label) ?></th>
                <?php endforeach; ?>
                <th scope="col"><?= $escape($labels->actionsLabel) ?></th>
            </tr></thead>
            <tbody>
                <?php foreach($feedback as $item): ?>
                    <tr>
                        <?php if($batchTypes): ?><td>
                            <?php if($item->status !== 'closed' && ($isAdmin || ($item->assignedTo === $currentAccount && !$item->assignmentPending))): ?>
                                <input form="reqintake-batch-link" type="checkbox" name="sources[]" value="<?= (int)$item->id ?>:<?= (int)$item->version ?>" aria-label="<?= $escape($labels->batchSelect . ' #' . $item->id) ?>">
                                <input form="reqintake-batch-link" name="sourceScopes[<?= (int)$item->id ?>]" maxlength="500"
                                    placeholder="<?= $escape($labels->sourceScope) ?>" aria-label="<?= $escape($labels->sourceScope . ' #' . $item->id) ?>">
                            <?php endif; ?>
                        </td><?php endif; ?>
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
                        <td data-column="product"><?= $escape($item->productName) ?></td>
                        <td data-column="owner"><?= $escape($item->assignedTo) ?><?php if($item->assignmentPending): ?> (<?= $escape($labels->ownerPending) ?>)<?php endif; ?></td>
                        <td data-column="status"><?= $escape($labels->states[$item->status] ?? $item->status) ?></td>
                        <td data-column="next"><?= $escape($item->nextStep) ?></td>
                        <td data-column="customer"><?= $escape($item->customer) ?></td>
                        <td data-column="updated"><time datetime="<?= $escape(str_replace(' ', 'T', $item->updatedDate)) ?>"><?= $escape($item->updatedDate) ?></time></td>
                        <td>
                            <?php if($isAdmin || ($item->assignedTo === $currentAccount && !$item->assignmentPending)): ?>
                            <form method="post">
                                <input type="hidden" name="intent" value="transition">
                                <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
                                <input type="hidden" name="token" value="<?= $escape($token) ?>">
                                <input type="hidden" name="feedbackID" value="<?= (int)$item->id ?>">
                                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                                <label><?= $escape($labels->transitionReason) ?>
                                    <input name="reason" class="form-control" maxlength="500">
                                </label>
                                <?php if($item->status !== 'closed') require __DIR__ . '/closure-fields.php'; ?>
                                <?php foreach(match($item->status) {'pending' => ['start', 'accept', 'close'], 'tracking' => ['close'], 'closed' => ['reopen'], default => []} as $action): ?>
                                    <button class="btn" type="submit" name="action" value="<?= $escape($action) ?>"><?= $escape($labels->actions[$action]) ?></button>
                                <?php endforeach; ?>
                            </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <?php if($beforeID || $nextBefore): ?>
        <nav class="mt-2" aria-label="<?= $escape($labels->pagination) ?>">
            <?php if($beforeID): ?>
                <a class="btn" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$scope&filterProduct=$filterProduct&$baseParams")) ?>"><?= $escape($labels->firstPage) ?></a>
            <?php endif; ?>
            <?php if($nextBefore): ?>
                <a class="btn" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$scope&filterProduct=$filterProduct&previewProduct=0&beforeID=$nextBefore&sort=$sort&beforeUpdate=" . rawurlencode($nextUpdate) . $filterParams)) ?>"><?= $escape($labels->nextPage) ?></a>
            <?php endif; ?>
        </nav>
    <?php endif; ?>
</section>
<?php
html(ob_get_clean());

require __DIR__ . '/product-scope-js.php';
context::js(<<<'JS'
const receiveForm = document.querySelector('#reqintake-receive');
if (receiveForm) {
    const product = receiveForm.elements.product;
    const preview = receiveForm.querySelector('output');
    const branch = receiveForm.elements.branch;
    const submitError = receiveForm.querySelector('[data-reqintake-upload-error]');
    const submitButton = receiveForm.querySelector('button[type=submit]');
    receiveForm.addEventListener('submit', async event => {
        if (!receiveForm.elements.attachment.files.length) return;
        event.preventDefault();
        if (submitButton.disabled) return;

        submitButton.disabled = true;
        submitError.hidden = true;
        try {
            // Give the editor's submit listeners a chance to sync their input fields.
            await Promise.resolve();
            const data = new FormData(receiveForm);
            data.set('receiveAjax', '1');
            const response = await fetch(receiveForm.action, {
                method: 'POST', body: data, headers: {'X-Requested-With': 'XMLHttpRequest'}
            });
            const result = await response.json();
            if (response.ok && result.location) return window.location.assign(result.location);
            if (response.ok && result.reload) return window.location.assign(receiveForm.action);
            submitError.textContent = result.error || submitError.dataset.failed;
            submitError.hidden = false;
        } catch {
            submitError.textContent = submitError.dataset.failed;
            submitError.hidden = false;
        } finally {
            submitButton.disabled = false;
        }
    });
    let sequence = 0;
    const updatePreview = async () => {
        const requestNumber = ++sequence;
        preview.textContent = '';
        const initial = requestNumber === 1;
        const selectedBranch = initial ? branch.dataset.initial : '0';
        const selectedModule = initial ? receiveForm.elements.module.dataset.initial : '0';
        const extra = receiveForm.querySelector('[data-reqintake-extra]');
        extra.hidden = true;
        extra.querySelector('[data-reqintake-branches]').replaceChildren();
        branch.onchange = null;
        reqintakeOptions(branch, {0: ''}, '0');
        reqintakeOptions(receiveForm.elements.module, {0: ''}, '0');
        reqintakeOptions(receiveForm.elements.plan, {0: ''}, '0');
        if (!product.value) return;

        try {
            const response = await fetch(preview.dataset.url.replace('987654321', product.value), {cache: 'no-store', headers: {'X-Requested-With': 'XMLHttpRequest'}});
            if (!response.ok) throw new Error('Assignment preview failed');
            const data = await response.json();
            if (requestNumber !== sequence) return;
            reqintakeOptions(branch, data.branches, selectedBranch);
            reqintakeScope(receiveForm, data, selectedModule, initial);
            const label = data.pending ? preview.dataset.pending : preview.dataset.owner;
            preview.textContent = label + ' · ' + data.name;
        } catch {
            if (requestNumber === sequence) preview.textContent = preview.dataset.unavailable;
        }
    };
    product.addEventListener('change', updatePreview);
    updatePreview();
}
JS);

context::js(<<<'JS'
const columnSettings = document.querySelector('#reqintake-column-settings');
if (columnSettings) {
    const key = 'reqintake.columns.' + columnSettings.dataset.account;
    const toggles = [...columnSettings.querySelectorAll('input')];
    const table = document.querySelector('#reqintake-results');
    let hidden = [];
    try { hidden = JSON.parse(localStorage.getItem(key) || '[]'); } catch {}
    if (!Array.isArray(hidden)) hidden = [];
    const apply = () => {
        for (const toggle of toggles) {
            table.querySelectorAll('[data-column="' + toggle.value + '"]').forEach(cell => {
                cell.hidden = !toggle.checked;
            });
        }
    };
    for (const toggle of toggles) toggle.checked = !hidden.includes(toggle.value);
    columnSettings.addEventListener('change', () => {
        apply();
        try { localStorage.setItem(key, JSON.stringify(toggles.filter(toggle => !toggle.checked).map(toggle => toggle.value))); } catch {}
    });
    apply();
}
JS);
