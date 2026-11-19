<?php
namespace zin;

require __DIR__ . '/layout.php';

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$link = static fn($method) => helper::createLink('feedback', $method, "feedbackID=$feedback->id");
$canOperate = static fn($operation) => \common::hasPriv('feedback', $operation) && $app->control->feedback->canOperate($feedback, $operation);
$accountNames = static function($accounts) use ($users)
{
    $accounts = array_filter(array_map('trim', explode(',', $accounts)));
    return implode(', ', array_map(static fn($account) => zget($users, $account, $account), $accounts));
};
$fields = array(
    $feedbackLang->detailInfo => array(
        'product' => $product,
        'module' => implode(' / ', array_column($modulePath, 'name')),
        'status' => zget($feedbackLang->statusList, $feedback->status, $feedback->status),
        'type' => zget($feedbackLang->typeList, $feedback->type, $feedback->type),
        'pri' => 'P' . $feedback->pri,
        'assignedTo' => $accountNames($feedback->assignedTo) ?: $feedbackLang->unassigned,
        'visibility' => $feedback->public ? $feedbackLang->productVisibility : $feedbackLang->restrictedVisibility,
        'keywords' => $feedback->keywords,
    ),
    $feedbackLang->contactInfo => array(
        'feedbackBy' => $feedback->feedbackBy,
        'source' => $feedback->source,
        'notifyEmail' => $feedback->notifyEmail,
        'notify' => $feedback->notify ? $feedbackLang->enabled : $feedbackLang->disabled,
        'mailto' => $accountNames($feedback->mailto),
    ),
);
$events = array();
foreach(array('opened' => 'openedBy', 'assigned' => 'assignedTo', 'reviewed' => 'reviewedBy', 'processed' => 'processedBy', 'edited' => 'editedBy', 'closed' => 'closedBy', 'activated' => 'activatedBy') as $event => $actor)
{
    $date = $feedback->{$event . 'Date'};
    if(!$date || str_starts_with($date, '0000-00-00')) continue;
    $events[$event . 'Event'] = implode(' · ', array_filter(array($accountNames($feedback->$actor), $date)));
}
if($feedback->closedReason) $events['closedReason'] = zget($feedbackLang->closedReasonList, $feedback->closedReason, $feedback->closedReason);
$fields[$feedbackLang->lifecycle] = $events;
$operations = array(
    'assignTo' => array('assignedTo', array('' => $feedbackLang->unassigned) + $assignees),
    'review' => array('reviewResult', $feedbackLang->reviewResultList),
    'reply' => array('', array()), 'ask' => array('', array()), 'comment' => array('', array()),
    'convert' => array('target', $conversionTypes),
    'close' => array('closedReason', $feedbackLang->closedReasonList),
    'activate' => array('', array()), 'delete' => array('', array()),
);
$repeatPicker = '';
if($canOperate('close'))
{
    $model = $app->control->feedback;
    disableGlobalRender();
    $repeatPicker = picker(set::name('repeatFeedback'), set::items($model->getRepeatOptions($feedback)),
        set::search(true), set::placeholder($feedbackLang->selectRepeatFeedback),
        set::attrs(array('aria-labelledby' => 'feedbackRepeatLabel')))->render();
    enableGlobalRender();
}
ob_start();
?>
<main class="feedback-detail">
  <div class="panel feedback-detail-header">
    <h2 class="panel-title"><span class="text-muted">#<?= (int)$feedback->id ?></span> <?= $escape($feedback->title) ?></h2>
    <div class="feedback-actions">
      <?php if($canOperate('edit')): ?><a class="btn" href="<?= $escape($link('edit')) ?>"><?= $escape($feedbackLang->edit) ?></a><?php endif; ?>
      <a class="btn" href="<?= $escape(helper::createLink('feedback', 'browse', 'browseType=all')) ?>"><?= $escape($feedbackLang->back) ?></a>
    </div>
  </div>
  <?php if($justSaved): ?><p class="feedback-saved" role="status"><?= $escape($lang->saveSuccess) ?></p><?php endif; ?>
  <div class="feedback-detail-grid">
  <div class="feedback-detail-main">
    <section class="panel feedback-card">
      <h3><?= $escape($feedbackLang->desc) ?></h3>
      <div class="article-content feedback-description"><?= $descriptionHtml === '' ? '—' : $descriptionHtml ?></div>
    </section>
    <?php if($repeat): ?>
      <p class="mt-4">
        <?= $escape($feedbackLang->repeatFeedback) ?>
        <a href="<?= $escape(helper::createLink('feedback', 'view', "feedbackID=$repeat->id")) ?>">#<?= (int)$repeat->id ?> <?= $escape($repeat->title) ?></a>
      </p>
    <?php endif; ?>
    <?php if($feedback->result && isset($feedbackLang->conversionTypes[$feedback->solution])): ?>
      <p class="mt-4">
        <?= $escape($feedbackLang->result) ?>
        <?php $resultLabel = $feedbackLang->conversionTypes[$feedback->solution] . ' #' . (int)$feedback->result; ?>
        <?php if(!empty($conversionProgress['url'])): ?>
          <a href="<?= $escape($conversionProgress['url']) ?>"><?= $escape($resultLabel) ?></a>
        <?php else: ?>
          <?= $escape($resultLabel) ?>
        <?php endif; ?>
        <?php if($conversionProgress): ?>
          <span class="label secondary"><?= $escape($conversionProgress['status']) ?></span>
        <?php endif; ?>
      </p>
    <?php endif; ?>
    <?php if($ticket): ?>
      <section class="panel feedback-card">
        <h3>#<?= (int)$ticket->id ?> <?= $escape($ticket->title) ?></h3>
        <p><?= $escape(zget($feedbackLang->ticketStatuses, $ticket->status, $ticket->status)) ?></p>
        <?php
          $next = array('wait' => 'doing', 'doing' => 'done', 'done' => 'closed')[$ticket->status] ?? '';
          $mayUpdateTicket = $app->user->admin || $ticket->assignedTo === $app->user->account;
        ?>
        <?php if($next && $mayUpdateTicket): ?>
          <form method="post" action="<?= $escape($link('ticket')) ?>">
            <button class="btn" type="submit" name="status" value="<?= $escape($next) ?>"><?= $escape($feedbackLang->ticketStatuses[$next]) ?></button>
          </form>
        <?php endif; ?>
      </section>
    <?php endif; ?>
    <?php if($attachments || (\common::hasPriv('feedback', 'upload') && $app->control->feedback->canOperate($feedback, 'edit'))): ?>
      <section class="panel feedback-card">
        <h3><?= $escape($feedbackLang->attachments) ?></h3>
        <?php if(\common::hasPriv('feedback', 'download')): ?>
          <ul class="my-2">
            <?php foreach($attachments as $attachment): ?>
              <li><a download="<?= $escape($attachment->title) ?>" href="<?= $escape(helper::createLink('feedback', 'download', array('fileID' => $attachment->id))) ?>"><?= $escape($attachment->title) ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <?php if(\common::hasPriv('feedback', 'upload') && $app->control->feedback->canOperate($feedback, 'edit')): ?>
          <form method="post" enctype="multipart/form-data" action="<?= $escape($link('upload')) ?>" class="feedback-actions feedback-upload">
            <input type="file" name="files" required aria-label="<?= $escape($feedbackLang->attachments) ?>">
            <button class="btn" type="submit"><?= $escape($feedbackLang->upload) ?></button>
          </form>
        <?php endif; ?>
      </section>
    <?php endif; ?>
    <section class="panel feedback-card">
      <h3><?= $escape($feedbackLang->operations) ?></h3>
      <div class="feedback-command-grid">
      <?php foreach($operations as $operation => [$field, $options]): if(!$canOperate($operation) || ($operation === 'convert' && !$conversionTypes)) continue; ?>
        <details class="border rounded p-3 mb-2">
          <summary><?= $escape($feedbackLang->$operation) ?></summary>
          <form method="post" action="<?= $escape($link($operation)) ?>" class="feedback-operation">
            <input type="hidden" name="submitAction" value="1">
            <?php if($field): ?>
              <select class="form-control" name="<?= $escape($field) ?>" aria-label="<?= $escape($feedbackLang->$operation) ?>">
                <?php foreach($options as $key => $label): ?>
                  <option value="<?= $escape($key) ?>" <?= $operation === 'assignTo' && $key === $feedback->assignedTo ? 'selected' : '' ?>><?= $escape($label) ?></option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>
            <?php if($operation === 'close'): ?>
              <div class="feedback-field feedback-repeat-field">
                <span id="feedbackRepeatLabel"><?= $escape($feedbackLang->repeatFeedback) ?></span>
                <?= $repeatPicker ?>
              </div>
            <?php endif; ?>
            <?php if($operation === 'delete'): ?>
              <p><?= $escape($feedbackLang->deleteConfirm) ?></p>
            <?php elseif(!in_array($operation, array('activate', 'convert'), true)): ?>
              <textarea class="form-control" name="comment" aria-label="<?= $escape($feedbackLang->comment) ?>" placeholder="<?= $escape($feedbackLang->comment) ?>" <?= in_array($operation, array('comment', 'reply', 'ask'), true) ? 'required' : '' ?>></textarea>
            <?php endif; ?>
            <button class="btn <?= $operation === 'delete' ? 'danger' : 'primary' ?> self-start" type="submit"><?= $escape($feedbackLang->$operation) ?></button>
          </form>
        </details>
      <?php endforeach; ?>
      </div>
    </section>
    <section class="panel feedback-card">
      <h3><?= $escape($feedbackLang->activity) ?></h3>
      <ol class="mt-2">
        <?php foreach($actions as $action): ?>
          <li class="border-t py-2">
            <strong><?= $escape(zget($users, $action->actor, $action->actor)) ?></strong>
            <?= $escape(zget($feedbackLang->actionLabels, $action->action, $action->action)) ?>
            <time class="text-muted"><?= $escape($action->date) ?></time>
            <?php if($action->comment): ?><p class="whitespace-pre-wrap"><?= $escape(strip_tags($action->comment)) ?></p><?php endif; ?>
          </li>
        <?php endforeach; ?>
      </ol>
    </section>
  </div>
  <aside class="feedback-detail-meta">
    <?php foreach($fields as $heading => $values): ?>
      <section class="panel feedback-card">
        <h3><?= $escape($heading) ?></h3>
        <dl class="feedback-summary">
          <?php foreach($values as $field => $value): ?>
            <div>
              <dt><?= $escape($feedbackLang->$field) ?></dt>
              <dd><?= $escape($value === '' ? '—' : $value) ?></dd>
            </div>
          <?php endforeach; ?>
        </dl>
      </section>
    <?php endforeach; ?>
  </aside>
  </div>
</main>
<?php html(ob_get_clean());
