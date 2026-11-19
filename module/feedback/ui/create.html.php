<?php
namespace zin;

require __DIR__ . '/layout.php';

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
jsVar('feedbackModuleOptions', $moduleOptions);
ob_start();
?>
<main class="panel feedback-editor">
  <div class="panel-heading"><h2 class="panel-title"><?= $escape($title) ?></h2></div>
  <div class="panel-body">
    <?php if(!empty($error)): ?><p class="alert danger" role="alert"><?= $escape($error) ?></p><?php endif; ?>
    <?php if(!$products): ?><p class="alert warning" role="status"><?= $escape($feedbackLang->noProducts) ?></p><?php endif; ?>
    <form method="post" class="feedback-form">
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
        <label class="feedback-field"><?= $escape($feedbackLang->module) ?>
          <select class="form-control" name="module" id="feedbackModule">
            <option value="0"></option>
            <?php foreach($modules as $id => $name): if(!$id) continue; ?>
              <option value="<?= (int)$id ?>" <?= $id == ($feedback->module ?? 0) ? 'selected' : '' ?>><?= $escape($name) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
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
      <label class="feedback-field"><?= $escape($feedbackLang->desc) ?>
        <textarea class="form-control" rows="6" name="desc"><?= $escape($feedback->desc ?? '') ?></textarea>
      </label>
      <div class="feedback-fields">
        <label class="feedback-field"><?= $escape($feedbackLang->feedbackBy) ?><input class="form-control" name="feedbackBy" maxlength="100" value="<?= $escape($feedback->feedbackBy ?? '') ?>"></label>
        <label class="feedback-field"><?= $escape($feedbackLang->notifyEmail) ?><input class="form-control" type="email" name="notifyEmail" maxlength="100" value="<?= $escape($feedback->notifyEmail ?? '') ?>"></label>
      </div>
      <div class="feedback-options">
        <label><input type="hidden" name="public" value="0"><input type="checkbox" name="public" value="1" <?= !empty($feedback->public) ? 'checked' : '' ?>> <?= $escape($feedbackLang->public) ?></label>
        <label><input type="hidden" name="notify" value="0"><input type="checkbox" name="notify" value="1" <?= !empty($feedback->notify) ? 'checked' : '' ?>> <?= $escape($feedbackLang->notify) ?></label>
      </div>
      <div class="feedback-actions">
        <button class="btn primary" type="submit" <?= !$products ? 'disabled' : '' ?>><?= $escape($lang->save) ?></button>
        <a class="btn" href="<?= $escape(helper::createLink('feedback', 'browse')) ?>"><?= $escape($feedbackLang->back) ?></a>
      </div>
    </form>
  </div>
</main>
<?php html(ob_get_clean());
