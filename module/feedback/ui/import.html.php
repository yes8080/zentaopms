<?php
namespace zin;

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
ob_start();
?>
<main class="panel mx-auto" style="max-width: 50rem">
  <div class="panel-heading"><h2 class="panel-title"><?= $escape($feedbackLang->import) ?></h2></div>
  <div class="panel-body">
    <?php if(!empty($error)): ?><p class="alert danger" role="alert"><?= $escape($error) ?></p><?php endif; ?>
    <p><?= $escape($feedbackLang->importHelp) ?></p>
    <?php if(\common::hasPriv('feedback', 'export')): ?>
      <a class="btn my-2" href="<?= $escape(helper::createLink('feedback', 'export', 'template=1')) ?>"><?= $escape($feedbackLang->template) ?></a>
    <?php endif; ?>
    <ul class="my-2">
      <?php foreach($products as $id => $name): ?><li>#<?= (int)$id ?> <?= $escape($name) ?></li><?php endforeach; ?>
    </ul>
    <form method="post" enctype="multipart/form-data" class="flex gap-2 items-center">
      <input type="hidden" name="import" value="1">
      <input type="file" name="workbook" accept=".xlsx" required aria-label="<?= $escape($feedbackLang->import) ?>">
      <button class="btn primary" type="submit"><?= $escape($feedbackLang->import) ?></button>
      <a class="btn" href="<?= $escape(helper::createLink('feedback', 'browse')) ?>"><?= $escape($feedbackLang->back) ?></a>
    </form>
  </div>
</main>
<?php html(ob_get_clean());
