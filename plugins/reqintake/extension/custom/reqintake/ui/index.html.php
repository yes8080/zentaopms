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
$scopeItems = array();
foreach($labels->scopes as $key => $label)
{
    $scopeItems[] = array('text' => $label, 'active' => $key === $scope,
        'url' => \helper::createLink('reqintake', 'index', "scope=$key&filterProduct=$filterProduct&$baseParams"));
}
$showDraft = $inputRich && isset($formError);
$selectedProduct = $fields['product'] !== '' ? $fields['product'] : (string)$filterProduct;
$hasFilters = $filterID || $filterOwner !== '' || $filterStatus !== '' || $updatedFrom !== '' || $updatedTo !== '';
ob_start();
?>
<section id="reqintake-create-surface" class="panel reqintake-create-surface" <?= $showDraft ? '' : 'hidden' ?>>
    <div class="panel-heading">
        <h2 class="panel-title text-lg"><?= $escape($labels->createFeedback) ?></h2>
        <button class="btn ghost" type="button" data-reqintake-back><?= $escape($lang->goback) ?></button>
    </div>
    <?php if($showDraft): ?><p class="reqintake-form-error" role="alert"><?= $escape($formError) ?></p><?php endif; ?>
    <form id="reqintake-receive" method="post" enctype="multipart/form-data">
        <input type="hidden" name="bodyFormat" value="rich">
        <input type="hidden" name="openDetail" value="1">
        <p class="reqintake-form-error" role="alert" data-reqintake-upload-error data-failed="<?= $escape($labels->submitRetry) ?>" hidden></p>
        <input type="hidden" name="operation" value="<?= $escape($operation) ?>">
        <input type="hidden" name="token" value="<?= $escape($token) ?>">
        <?php $values = $fields; ?>
        <div class="reqintake-form-grid reqintake-form-scope">
            <label class="block mb-2"><?= $escape($labels->fields['product']) ?>
                <select class="form-control" name="product" required>
                    <option value=""></option>
                    <?php foreach($products as $id => $name): ?>
                        <option value="<?= (int)$id ?>" <?= (string)$id === $selectedProduct ? 'selected' : '' ?>><?= $escape($name) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <?php $attributeGroup = 'scope'; require __DIR__ . '/attribute-fields.php'; ?>
            <output class="reqintake-form-wide reqintake-owner-preview" aria-live="polite"
                data-url="<?= $escape(\helper::createLink('reqintake', 'index', 'scope=all&filterProduct=0&previewProduct=987654321')) ?>"
                data-owner="<?= $escape($labels->ownerAccount) ?>"
                data-pending="<?= $escape($labels->ownerPending) ?>"
                data-unavailable="<?= $escape($labels->ownerPreviewUnavailable) ?>"></output>
        </div>
        <label class="block mb-2"><?= $escape($labels->fields['title']) ?>
            <input class="form-control" name="title" value="<?= $escape($fields['title']) ?>" maxlength="255" required>
        </label>
        <div class="reqintake-form-grid reqintake-form-basic">
            <?php $attributeGroup = 'basic'; require __DIR__ . '/attribute-fields.php'; ?>
        </div>
        <label class="block mb-2"><?= $escape($labels->fields['description']) ?>
            <?= $renderEditor('description', $fields['description'], $rich) ?>
        </label>
        <?php $attributeGroup = 'content'; require __DIR__ . '/attribute-fields.php'; ?>
        <label class="block mb-2"><?= $escape($labels->attachmentLimit) ?>
            <input type="file" name="attachment">
        </label>
        <details class="reqintake-extra-fields" <?= $showDraft ? 'open' : '' ?>>
            <summary><?= $escape($labels->supplementaryFields) ?></summary>
            <div class="reqintake-form-grid">
                <?php foreach(array('customer' => 255, 'channel' => 64) as $name => $limit): ?>
                    <label class="block mb-2"><?= $escape($labels->fields[$name]) ?>
                        <input class="form-control" name="<?= $name ?>" value="<?= $escape($fields[$name]) ?>" maxlength="<?= $limit ?>">
                    </label>
                <?php endforeach; ?>
                <?php $attributeGroup = 'extra'; require __DIR__ . '/attribute-fields.php'; ?>
            </div>
        </details>
        <?php if(isset($formError) && isset($_FILES['attachment']) && ($_FILES['attachment']['error'] ?? null) !== UPLOAD_ERR_NO_FILE): ?>
            <p><?= $escape($labels->reselectAttachment) ?></p>
        <?php endif; ?>
        <div class="reqintake-create-actions">
            <button class="btn primary" type="submit"><?= $escape($labels->submit) ?></button>
            <button class="btn ghost" type="button" data-reqintake-back><?= $escape($lang->cancel) ?></button>
        </div>
    </form>
</section>
<section id="reqintake-list-surface" class="reqintake-list-surface" <?= $showDraft ? 'hidden' : '' ?>>
    <div class="reqintake-list-toolbar">
        <?php
        disableGlobalRender();
        try
        {
            echo featureBar(set::items($scopeItems))->render();
        }
        finally
        {
            enableGlobalRender();
        }
        ?>
        <button class="btn primary" type="button" data-reqintake-create aria-controls="reqintake-create-surface">
            <i class="icon icon-plus" aria-hidden="true"></i>
            <?= $escape($labels->createFeedback) ?>
        </button>
    </div>
    <?php if(isset($formError) && !$showDraft): ?><p class="reqintake-form-error" role="alert"><?= $escape($formError) ?></p><?php endif; ?>
    <?php if(isset($savedID)): ?><p role="status"><?= $escape(sprintf($labels->saved, $savedID)) ?></p><?php endif; ?>
    <?php if(isset($ownerSaved)): ?><p role="status"><?= $escape($labels->ownerSaved) ?></p><?php endif; ?>
    <div class="panel reqintake-list-panel">
    <div class="reqintake-list-tools">
    <details class="reqintake-popover reqintake-product-filter">
        <summary class="btn ghost"><?= $escape($products[$filterProduct] ?? $labels->allProducts) ?></summary>
        <nav class="reqintake-popover-body" aria-label="<?= $escape($labels->fields['product']) ?>">
            <?php foreach(array(0 => $labels->allProducts) + $products as $productID => $productName): ?>
                <a href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$scope&filterProduct=" . (int)$productID . "&$baseParams")) ?>" <?= (int)$productID === $filterProduct ? 'aria-current="page"' : '' ?>><?= $escape($productName) ?></a>
            <?php endforeach; ?>
        </nav>
    </details>
    <?php if($isAdmin): ?>
    <details class="reqintake-popover" <?= isset($formError) && ($_POST['intent'] ?? '') === 'owner' ? 'open' : '' ?>>
    <summary class="btn ghost"><?= $escape($labels->configureOwner) ?></summary>
    <form method="post" class="reqintake-popover-body">
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
    </details>
    <?php endif; ?>
    <details class="reqintake-popover">
    <summary class="btn ghost<?= $hasFilters ? ' text-primary' : '' ?>"><?= $escape($labels->filterFeedback) ?></summary>
    <form method="post" class="reqintake-popover-body reqintake-filter-form">
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
    </details>
    <?php if($feedback): ?>
        <details id="reqintake-column-settings" class="reqintake-popover" data-account="<?= $escape($currentAccount) ?>">
            <summary class="btn ghost"><?= $escape($labels->visibleColumns) ?></summary>
            <div class="reqintake-popover-body">
                <?php foreach($columns as $key => $label): ?>
                    <label class="block"><input type="checkbox" value="<?= $key ?>" checked> <?= $escape($label) ?></label>
                <?php endforeach; ?>
            </div>
        </details>
        <nav class="reqintake-sort" aria-label="<?= $escape($labels->sortFeedback) ?>">
            <?php foreach(array('id' => $labels->sortRecent, 'updated' => $labels->updatedDate) as $key => $label): ?>
                <a class="btn ghost" href="<?= $escape(\helper::createLink('reqintake', 'index', "scope=$scope&filterProduct=$filterProduct&previewProduct=0&beforeID=0&sort=$key$filters")) ?>" <?= $sort === $key ? 'aria-current="page"' : '' ?>><?= $escape($label) ?></a>
            <?php endforeach; ?>
        </nav>
    <?php endif; ?>
    </div>
    <?php if(!$feedback): ?>
        <p class="reqintake-empty"><?= $escape($labels->emptyList) ?></p>
    <?php else: ?>
        <?php if(isset($batchCount)): ?><p role="status"><?= $escape(sprintf($labels->batchSuccess, $batchCount)) ?></p><?php endif; ?>
        <div class="reqintake-table-scroll">
        <table class="table table-hover" id="reqintake-results">
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
                                <input class="reqintake-source-scope form-control" form="reqintake-batch-link" name="sourceScopes[<?= (int)$item->id ?>]" maxlength="500"
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
                        <td data-column="status"><span class="reqintake-state" data-state="<?= $escape($item->status) ?>"><?= $escape($labels->states[$item->status] ?? $item->status) ?></span></td>
                        <td data-column="next"><?= $escape($item->nextStep) ?></td>
                        <td data-column="customer"><?= $escape($item->customer) ?></td>
                        <td data-column="updated"><time datetime="<?= $escape(str_replace(' ', 'T', $item->updatedDate)) ?>"><?= $escape($item->updatedDate) ?></time></td>
                        <td>
                            <?php if($isAdmin || ($item->assignedTo === $currentAccount && !$item->assignmentPending)): ?>
                            <details class="reqintake-row-actions" <?= isset($formError) && ($_POST['intent'] ?? '') === 'transition' && ($_POST['feedbackID'] ?? '') === (string)$item->id ? 'open' : '' ?>>
                                <summary class="btn ghost size-sm" aria-label="<?= $escape($labels->actionsLabel . ' #' . $item->id) ?>"><?= $escape($labels->actionsLabel) ?></summary>
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
                            </details>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <?php if($batchTypes): ?>
            <form method="post" id="reqintake-batch-link" class="reqintake-batch-form">
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
    </div>
</section>
<?php
html(ob_get_clean());

require __DIR__ . '/product-scope-js.php';
context::js(<<<'JS'
const receiveForm = document.querySelector('#reqintake-receive');
const createSurface = document.querySelector('#reqintake-create-surface');
const listSurface = document.querySelector('#reqintake-list-surface');
const createButton = listSurface?.querySelector('[data-reqintake-create]');
if (createSurface && listSurface && createButton) {
    const createHash = '#reqintake-receive';
    const showCreate = (open, focus = false) => {
        createSurface.hidden = !open;
        listSurface.hidden = open;
        if (focus) {
            const url = new URL(window.location.href);
            url.hash = open ? createHash : '';
            window.history.replaceState(window.history.state, '', url);
            window.scrollTo(0, 0);
            (open ? receiveForm.elements.product : createButton).focus({preventScroll: true});
        }
    };
    showCreate(!createSurface.hidden || window.location.hash === createHash);
    createButton.addEventListener('click', () => showCreate(true, true));
    createSurface.querySelectorAll('[data-reqintake-back]').forEach(button => {
        button.addEventListener('click', () => showCreate(false, true));
    });
}
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
            if (response.ok && result.reload) {
                const url = new URL(receiveForm.action);
                url.hash = '';
                return window.location.assign(url);
            }
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
const batchForm = document.querySelector('#reqintake-batch-link');
if (batchForm) {
    const selections = [...document.querySelectorAll('input[name="sources[]"]')];
    const buttons = batchForm.querySelectorAll('button[type=submit]');
    const updateBatch = () => {
        const hasSelection = selections.some(selection => selection.checked);
        batchForm.hidden = !hasSelection;
        for (const button of buttons) button.disabled = !hasSelection;
        for (const selection of selections) selection.nextElementSibling.hidden = !selection.checked;
    };
    for (const selection of selections) selection.addEventListener('change', updateBatch);
    updateBatch();
}

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

context::css(<<<'CSS'
#reqintake-list-surface[hidden],
#reqintake-create-surface[hidden],
.reqintake-list-surface [hidden],
.reqintake-create-surface [hidden] {display: none !important;}
.reqintake-list-toolbar,
.reqintake-list-tools,
.reqintake-batch-form,
.reqintake-create-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: .5rem;
}
.reqintake-list-toolbar {justify-content: space-between; margin-bottom: .75rem;}
.reqintake-list-toolbar #featureBar {flex: 1 1 auto; min-width: 0;}
.reqintake-list-panel {background: var(--color-canvas); overflow: visible;}
.reqintake-list-tools,
.reqintake-batch-form {padding: .625rem .75rem; border-bottom: 1px solid var(--color-border);}
.reqintake-batch-form {
    position: sticky;
    bottom: 0;
    z-index: 2;
    background: var(--color-canvas);
    border-top: 1px solid var(--color-border);
    border-bottom: 0;
}
.reqintake-sort {margin-inline-start: auto;}
.reqintake-sort [aria-current],
.reqintake-product-filter [aria-current] {color: var(--color-primary-500); font-weight: 600;}
.reqintake-popover {position: relative;}
.reqintake-popover > summary,
.reqintake-row-actions > summary {list-style: none; cursor: pointer;}
.reqintake-popover > summary::-webkit-details-marker,
.reqintake-row-actions > summary::-webkit-details-marker {display: none;}
.reqintake-popover-body {
    position: absolute;
    inset-block-start: 100%;
    inset-inline-start: 0;
    min-width: 12rem;
    max-width: min(24rem, 88vw);
    padding: .65rem;
    background: var(--color-canvas);
    border: 1px solid var(--color-border);
    border-radius: .25rem;
    box-shadow: 0 .25rem .75rem #0002;
    z-index: 5;
}
.reqintake-product-filter nav {max-height: 20rem; overflow: auto;}
.reqintake-product-filter nav a {display: block; padding: .3rem .4rem;}
.reqintake-product-filter nav a:hover {background: var(--color-surface, #f4f5f7);}
.reqintake-filter-form {display: grid; grid-template-columns: repeat(2, minmax(8rem, 1fr)); gap: .55rem; width: max-content;}
.reqintake-filter-form label > :is(input, select),
.reqintake-batch-form label > :is(input, select) {min-width: 0; width: 100%; display: block;}
.reqintake-table-scroll {overflow-x: auto;}
#reqintake-results {margin-bottom: 0; min-width: 50rem;}
#reqintake-results th {white-space: nowrap;}
#reqintake-results td {vertical-align: middle;}
#reqintake-results td[data-column='updated'] {white-space: nowrap;}
#reqintake-results td details > summary:not(.btn) {color: var(--color-fore-muted, #596579); font-size: .8125rem;}
#reqintake-results td details > ul {max-width: 25rem;}
#reqintake-results input.reqintake-source-scope {margin-top: .375rem; min-width: 8rem;}
.reqintake-state {
    display: inline-flex;
    align-items: center;
    gap: .35rem;
    white-space: nowrap;
}
.reqintake-state::before {content: ""; width: .4rem; height: .4rem; border-radius: 50%; background: currentColor;}
.reqintake-state[data-state="tracking"] {color: var(--color-primary-500);}
.reqintake-state[data-state="closed"] {color: var(--color-fore-muted, #596579);}
.reqintake-row-actions form {min-width: 11rem; padding-top: .5rem;}
.reqintake-empty {padding: 2rem; text-align: center;}
.reqintake-list-panel > nav {padding: .5rem .75rem;}
.reqintake-create-surface {background: var(--color-canvas); max-width: 72rem; margin-inline: auto;}
.reqintake-create-surface .panel-heading {display: flex; justify-content: space-between; align-items: center; gap: .5rem;}
#reqintake-receive {padding: 0 1.25rem 1.25rem;}
#reqintake-receive label > .form-control {display: block; width: 100%;}
#reqintake-receive input[required]:not([type=file]) {border-inline-start-color: var(--color-primary-500);}
.reqintake-form-grid {display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 0 .75rem;}
.reqintake-form-scope {grid-template-columns: repeat(4, minmax(0, 1fr));}
.reqintake-form-scope [data-reqintake-extra],
.reqintake-form-wide {grid-column: 1 / -1;}
.reqintake-owner-preview:not(:empty) {margin-bottom: .75rem; color: var(--color-fore-muted, #596579);}
.reqintake-extra-fields {margin: .75rem 0; padding: .5rem .65rem; border: 1px solid var(--color-border); border-radius: .25rem;}
.reqintake-extra-fields > summary {cursor: pointer;}
.reqintake-extra-fields[open] > summary {margin-bottom: .625rem;}
.reqintake-create-actions {justify-content: center; padding-top: .75rem;}
.reqintake-form-error {color: var(--color-danger-600, #ac2b3a); margin: .5rem .75rem;}
@media (max-width: 820px) {
    .reqintake-form-grid {grid-template-columns: repeat(2, minmax(0, 1fr));}
    .reqintake-sort {margin-inline-start: 0;}
}
@media (max-width: 520px) {
    .reqintake-form-grid {grid-template-columns: minmax(0, 1fr);}
    .reqintake-filter-form {grid-template-columns: minmax(0, 1fr);}
}
CSS);
