<?php
namespace zin;

require __DIR__ . '/layout.php';

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$link = static fn($method, $params = '') => helper::createLink('feedback', $method, $params);
$browseLink = static fn($filter, $page) => $link('browse', http_build_query(array(
    'browseType' => $filter, 'productID' => $productID, 'orderBy' => $orderBy,
    'recTotal' => 0, 'recPerPage' => $pager->recPerPage, 'pageID' => $page, 'keyword' => $keyword === '' ? '' : helper::safe64Encode($keyword),
)));
$batchActions = array_filter(array('assignTo', 'review', 'close', 'edit'), static fn($action) => \common::hasPriv('feedback', $action));
$canBatch = $batchActions && \common::hasPriv('feedback', 'batch');
$exportLink = $link('export', http_build_query(array('template' => 0, 'productID' => $productID, 'browseType' => $browseType, 'keyword' => $keyword === '' ? '' : helper::safe64Encode($keyword))));
ob_start();
?>
<main class="panel">
  <div class="panel-heading feedback-actions feedback-browse-heading">
    <h2 class="panel-title"><?= $escape($feedbackLang->browse) ?></h2>
    <div class="feedback-actions">
    <?php if(\common::hasPriv('feedback', 'export')): ?><a class="btn" download="feedback.xlsx" href="<?= $escape($exportLink) ?>"><?= $escape($feedbackLang->export) ?></a><?php endif; ?>
    <?php if(\common::hasPriv('feedback', 'import') && \common::hasPriv('feedback', 'create')): ?><a class="btn" href="<?= $escape($link('import')) ?>"><?= $escape($feedbackLang->import) ?></a><?php endif; ?>
    <?php if(\common::hasPriv('feedback', 'create')): ?>
      <a class="btn primary" href="<?= $escape($link('create', "productID=$productID")) ?>"><?= $escape($feedbackLang->create) ?></a>
    <?php endif; ?>
    </div>
  </div>
  <div class="panel-body">
    <nav class="feedback-actions" aria-label="<?= $escape($feedbackLang->status) ?>">
      <?php foreach($feedbackLang->filters as $filter => $label): ?>
        <a class="btn <?= $filter === $browseType ? 'secondary' : 'ghost' ?>" href="<?= $escape($browseLink($filter, 1)) ?>"><?= $escape($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <form method="post" action="<?= $escape($link('browse')) ?>" class="feedback-search">
      <input class="form-control" name="keyword" value="<?= $escape($keyword) ?>" placeholder="<?= $escape($feedbackLang->search) ?>" aria-label="<?= $escape($feedbackLang->search) ?>">
      <select class="form-control" name="productID" aria-label="<?= $escape($feedbackLang->product) ?>">
        <option value="0"><?= $escape($feedbackLang->allProducts) ?></option>
        <?php foreach($products as $id => $name): ?>
          <option value="<?= (int)$id ?>" <?= $id == $productID ? 'selected' : '' ?>><?= $escape($name) ?></option>
        <?php endforeach; ?>
      </select>
      <select class="form-control" name="browseType" aria-label="<?= $escape($feedbackLang->status) ?>">
        <?php foreach($feedbackLang->filters + $feedbackLang->statusList as $filter => $label): ?>
          <option value="<?= $escape($filter) ?>" <?= $filter === $browseType ? 'selected' : '' ?>><?= $escape($label) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn" type="submit"><?= $escape($lang->searchAB ?? 'Search') ?></button>
    </form>
    <?php if(!$feedbacks): ?>
      <p class="text-muted py-6"><?= $escape($feedbackLang->empty) ?></p>
    <?php else: ?>
      <?php if($canBatch): ?><form method="post" action="<?= $escape($link('batch')) ?>"><?php endif; ?>
      <div class="feedback-table">
        <table class="table table-hover">
          <thead><tr><?php if($canBatch): ?><th></th><?php endif; ?><th>ID</th>
          <?php foreach(array('title', 'product', 'status', 'pri', 'openedBy', 'assignedTo') as $column): ?>
            <th><?= $escape($feedbackLang->$column) ?></th>
          <?php endforeach; ?>
          </tr></thead>
          <tbody>
          <?php foreach($feedbacks as $item): ?>
            <tr>
              <?php if($canBatch): ?><td><input type="checkbox" name="feedbackIDs[]" value="<?= (int)$item->id ?>" aria-label="#<?= (int)$item->id ?> <?= $escape($item->title) ?>"></td><?php endif; ?>
              <td><?= (int)$item->id ?></td>
              <td>
                <?php if(\common::hasPriv('feedback', 'view')): ?>
                  <a href="<?= $escape($link('view', "feedbackID=$item->id")) ?>"><?= $escape($item->title) ?></a>
                <?php else: ?>
                  <?= $escape($item->title) ?>
                <?php endif; ?>
              </td>
              <td><?= $escape(zget($products, $item->product, '')) ?></td>
              <td><?= $escape(zget($feedbackLang->statusList, $item->status, $item->status)) ?></td>
              <td>P<?= (int)$item->pri ?></td>
              <td><?= $escape(zget($users, $item->openedBy, $item->openedBy)) ?></td>
              <td><?= $escape($item->assignedTo ? zget($users, $item->assignedTo, $item->assignedTo) : $feedbackLang->unassigned) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php if($canBatch): ?>
        <details class="border rounded p-3 mt-2">
          <summary><?= $escape($feedbackLang->batch) ?></summary>
          <?php foreach($batchActions as $action): ?>
            <div class="flex gap-2 items-center mt-2">
              <?php if($action === 'assignTo'): ?>
                <select class="form-control w-56" name="assignedTo" aria-label="<?= $escape($feedbackLang->assignedTo) ?>">
                  <option value=""><?= $escape($feedbackLang->unassigned) ?></option>
                  <?php foreach($users as $account => $name): if($account === '') continue; ?>
                    <option value="<?= $escape($account) ?>"><?= $escape($name) ?></option>
                  <?php endforeach; ?>
                </select>
              <?php elseif($action === 'review'): ?>
                <select class="form-control w-56" name="reviewResult" aria-label="<?= $escape($feedbackLang->review) ?>">
                  <?php foreach($feedbackLang->reviewResultList as $key => $name): ?><option value="<?= $escape($key) ?>"><?= $escape($name) ?></option><?php endforeach; ?>
                </select>
              <?php elseif($action === 'edit'): ?>
                <select class="form-control w-48" name="type" aria-label="<?= $escape($feedbackLang->type) ?>">
                  <option value=""><?= $escape($feedbackLang->keepType) ?></option>
                  <?php foreach($feedbackLang->typeList as $key => $name): ?><option value="<?= $escape($key) ?>"><?= $escape($name) ?></option><?php endforeach; ?>
                </select>
                <select class="form-control w-48" name="pri" aria-label="<?= $escape($feedbackLang->pri) ?>">
                  <option value=""><?= $escape($feedbackLang->keepPriority) ?></option>
                  <?php foreach(range(1, 4) as $priority): ?><option value="<?= $priority ?>">P<?= $priority ?></option><?php endforeach; ?>
                </select>
              <?php else: ?>
                <select class="form-control w-56" name="closedReason" aria-label="<?= $escape($feedbackLang->close) ?>">
                  <?php foreach($feedbackLang->closedReasonList as $key => $name): if($key === 'repeat') continue; ?>
                    <option value="<?= $escape($key) ?>"><?= $escape($name) ?></option>
                  <?php endforeach; ?>
                </select>
              <?php endif; ?>
              <button class="btn" type="submit" name="operation" value="<?= $escape($action) ?>"><?= $escape($feedbackLang->$action) ?></button>
            </div>
          <?php endforeach; ?>
        </details>
        </form>
      <?php endif; ?>
      <nav class="flex gap-2 justify-end items-center">
        <?php if($pager->pageID > 1): ?>
          <a class="btn" href="<?= $escape($browseLink($browseType, $pager->pageID - 1)) ?>"><?= $escape($feedbackLang->previous) ?></a>
        <?php endif; ?>
        <span><?= (int)$pager->pageID ?> / <?= (int)$pager->pageTotal ?></span>
        <?php if($pager->pageID < $pager->pageTotal): ?>
          <a class="btn" href="<?= $escape($browseLink($browseType, $pager->pageID + 1)) ?>"><?= $escape($feedbackLang->next) ?></a>
        <?php endif; ?>
      </nav>
    <?php endif; ?>
  </div>
</main>
<?php html(ob_get_clean());
