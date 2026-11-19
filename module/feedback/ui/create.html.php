<?php
namespace zin;

require __DIR__ . '/layout.php';

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
jsVar('feedbackModuleOptions', $moduleOptions);
disableGlobalRender();
$modulePicker = picker(set::id('feedbackModule'), set::name('module'), set::tree(true), set::items($modules),
    set::value(empty($feedback->module) ? '' : (string)$feedback->module), set::placeholder($feedbackLang->noModule),
    set::attrs(array('aria-labelledby' => 'feedbackModuleLabel')))->render();
$descriptionEditor = editor(set::name('desc'), set::value($descriptionHtml), set::mentions(false))->render();
enableGlobalRender();
ob_start();
?>
<main class="panel feedback-editor">
  <div class="panel-heading"><h2 class="panel-title"><?= $escape($title) ?></h2></div>
  <div class="panel-body">
    <?php if(!empty($error)): ?><p class="alert danger" role="alert"><?= $escape($error) ?></p><?php endif; ?>
    <?php if(!$products): ?><p class="alert warning" role="status"><?= $escape($feedbackLang->noProducts) ?></p><?php endif; ?>
    <form method="post" action="<?= $escape($formAction) ?>" class="feedback-form" enctype="multipart/form-data">
      <label class="feedback-field"><?= $escape($feedbackLang->title) ?>
        <input class="form-control" name="title" required maxlength="255" value="<?= $escape($feedback->title ?? '') ?>">
      </label>
      <div class="feedback-fields">
        <label class="feedback-field"><?= $escape($feedbackLang->product) ?>
          <select class="form-control" name="product" id="feedbackProduct" required>
            <option value=""></option>
            <?php foreach($products as $id => $name): ?>
              <option value="<?= (int)$id ?>" <?= $id == $productID ? 'selected' : '' ?>><?= $escape($name) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <div class="feedback-field">
          <span id="feedbackModuleLabel"><?= $escape($feedbackLang->module) ?></span>
          <?= $modulePicker ?>
        </div>
        <label class="feedback-field"><?= $escape($feedbackLang->type) ?>
          <select class="form-control" name="type">
            <?php foreach($feedbackLang->typeList as $key => $label): ?>
              <option value="<?= $escape($key) ?>" <?= $key === ($feedback->type ?? 'advice') ? 'selected' : '' ?>><?= $escape($label) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label class="feedback-field"><?= $escape($feedbackLang->pri) ?>
          <select class="form-control" name="pri">
            <?php foreach(range(1, 4) as $priority): ?>
              <option value="<?= $priority ?>" <?= $priority == ($feedback->pri ?? 2) ? 'selected' : '' ?>>P<?= $priority ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      </div>
      <div class="feedback-field">
        <span><?= $escape($feedbackLang->desc) ?></span>
        <?= $descriptionEditor ?>
      </div>
      <div class="feedback-fields">
        <label class="feedback-field"><?= $escape($feedbackLang->feedbackBy) ?><input class="form-control" name="feedbackBy" maxlength="100" value="<?= $escape($feedback->feedbackBy ?? '') ?>"></label>
        <label class="feedback-field"><?= $escape($feedbackLang->notifyEmail) ?><input class="form-control" type="email" name="notifyEmail" maxlength="100" value="<?= $escape($feedback->notifyEmail ?? '') ?>"></label>
      </div>
      <div class="feedback-fields">
        <?php foreach(array('source', 'keywords') as $field): ?>
          <label class="feedback-field"><?= $escape($feedbackLang->$field) ?>
            <input class="form-control" name="<?= $escape($field) ?>" maxlength="255" value="<?= $escape($feedback->$field ?? '') ?>">
          </label>
        <?php endforeach; ?>
      </div>
      <div class="feedback-options">
        <label><input type="hidden" name="public" value="0"><input type="checkbox" name="public" value="1" <?= !empty($feedback->public) ? 'checked' : '' ?>> <?= $escape($feedbackLang->public) ?></label>
        <label><input type="hidden" name="notify" value="0"><input type="checkbox" name="notify" value="1" <?= !empty($feedback->notify) ? 'checked' : '' ?>> <?= $escape($feedbackLang->notify) ?></label>
      </div>
      <?php if(\common::hasPriv('feedback', 'upload')): ?>
        <label class="feedback-field"><?= $escape($feedbackLang->attachments) ?>
          <input class="form-control" type="file" name="files">
        </label>
      <?php endif; ?>
      <div class="feedback-actions">
        <button class="btn primary" type="submit" <?= !$products ? 'disabled' : '' ?>><?= $escape($lang->save) ?></button>
        <a class="btn" href="<?= $escape(helper::createLink('feedback', 'browse', 'browseType=all')) ?>"><?= $escape($feedbackLang->back) ?></a>
      </div>
    </form>
  </div>
</main>
<?php html(ob_get_clean());
