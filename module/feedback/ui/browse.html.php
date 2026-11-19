<?php
namespace zin;

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$link = static fn($method, $params = '') => helper::createLink('feedback', $method, $params);
$browseLink = static fn($filter, $page) => $link('browse', http_build_query(array(
    'browseType' => $filter, 'productID' => $productID, 'orderBy' => $orderBy,
    'recTotal' => 0, 'recPerPage' => $pager->recPerPage, 'pageID' => $page, 'keyword' => $keyword === '' ? '' : helper::safe64Encode($keyword),
)));
ob_start();
?>
<main class="panel">
  <div class="panel-heading flex justify-between items-center">
    <h2 class="panel-title"><?= $escape($feedbackLang->browse) ?></h2>
    <?php if(\common::hasPriv('feedback', 'create')): ?>
      <a class="btn primary" href="<?= $escape($link('create', "productID=$productID")) ?>"><?= $escape($feedbackLang->create) ?></a>
    <?php endif; ?>
  </div>
  <div class="panel-body">
    <nav class="flex gap-2 flex-wrap" aria-label="<?= $escape($feedbackLang->status) ?>">
      <?php foreach($feedbackLang->filters as $filter => $label): ?>
        <a class="btn <?= $filter === $browseType ? 'secondary' : 'ghost' ?>" href="<?= $escape($browseLink($filter, 1)) ?>"><?= $escape($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <form method="post" action="<?= $escape($link('browse')) ?>" class="flex gap-2 flex-wrap my-4">
      <input class="form-control w-56" name="keyword" value="<?= $escape($keyword) ?>" placeholder="<?= $escape($feedbackLang->search) ?>" aria-label="<?= $escape($feedbackLang->search) ?>">
      <select class="form-control w-48" name="productID" aria-label="<?= $escape($feedbackLang->product) ?>">
        <option value="0"><?= $escape($feedbackLang->allProducts) ?></option>
        <?php foreach($products as $id => $name): ?>
          <option value="<?= (int)$id ?>" <?= $id == $productID ? 'selected' : '' ?>><?= $escape($name) ?></option>
        <?php endforeach; ?>
      </select>
      <select class="form-control w-48" name="browseType" aria-label="<?= $escape($feedbackLang->status) ?>">
        <?php foreach($feedbackLang->filters + $feedbackLang->statusList as $filter => $label): ?>
          <option value="<?= $escape($filter) ?>" <?= $filter === $browseType ? 'selected' : '' ?>><?= $escape($label) ?></option>
        <?php endforeach; ?>
      </select>
      <button class="btn" type="submit"><?= $escape($lang->searchAB ?? 'Search') ?></button>
    </form>
    <?php if(!$feedbacks): ?>
      <p class="text-muted py-6"><?= $escape($feedbackLang->empty) ?></p>
    <?php else: ?>
      <div class="overflow-auto">
        <table class="table table-hover">
          <thead><tr><th>ID</th>
          <?php foreach(array('title', 'product', 'status', 'pri', 'openedBy', 'assignedTo') as $column): ?>
            <th><?= $escape($feedbackLang->$column) ?></th>
          <?php endforeach; ?>
          </tr></thead>
          <tbody>
          <?php foreach($feedbacks as $item): ?>
            <tr>
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
