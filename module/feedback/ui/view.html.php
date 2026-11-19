<?php
namespace zin;

require __DIR__ . '/layout.php';

$feedbackLang = $lang->feedback;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
$link = static fn($method) => helper::createLink('feedback', $method, "feedbackID=$feedback->id");
$canOperate = static fn($operation) => \common::hasPriv('feedback', $operation) && $app->control->feedback->canOperate($feedback, $operation);
$fields = array(
    'product' => $product,
    'status' => zget($feedbackLang->statusList, $feedback->status, $feedback->status),
    'type' => zget($feedbackLang->typeList, $feedback->type, $feedback->type),
    'pri' => 'P' . $feedback->pri,
    'openedBy' => zget($users, $feedback->openedBy, $feedback->openedBy),
    'assignedTo' => $feedback->assignedTo ? zget($users, $feedback->assignedTo, $feedback->assignedTo) : $feedbackLang->unassigned,
);
$operations = array(
    'assignTo' => array('assignedTo', array('' => $feedbackLang->unassigned) + $assignees),
    'review' => array('reviewResult', $feedbackLang->reviewResultList),
    'reply' => array('', array()), 'ask' => array('', array()), 'comment' => array('', array()),
    'convert' => array('target', $conversionTypes),
    'close' => array('closedReason', $feedbackLang->closedReasonList),
    'activate' => array('', array()), 'delete' => array('', array()),
);
ob_start();
?>
<main class="panel mx-auto" style="max-width: 70rem">
  <div class="panel-heading flex justify-between items-center">
    <h2 class="panel-title">#<?= (int)$feedback->id ?> <?= $escape($feedback->title) ?></h2>
    <div class="flex gap-2">
      <?php if($canOperate('edit')): ?><a class="btn" href="<?= $escape($link('edit')) ?>"><?= $escape($feedbackLang->edit) ?></a><?php endif; ?>
      <a class="btn" href="<?= $escape(helper::createLink('feedback', 'browse')) ?>"><?= $escape($feedbackLang->back) ?></a>
    </div>
  </div>
  <div class="panel-body">
    <dl class="feedback-summary">
      <?php foreach($fields as $field => $value): ?>
        <div><dt class="text-muted"><?= $escape($feedbackLang->$field) ?></dt><dd><?= $escape($value) ?></dd></div>
      <?php endforeach; ?>
    </dl>
    <?php if($repeat): ?>
      <p class="mt-4">
        <?= $escape($feedbackLang->repeatFeedback) ?>
        <a href="<?= $escape(helper::createLink('feedback', 'view', "feedbackID=$repeat->id")) ?>">#<?= (int)$repeat->id ?> <?= $escape($repeat->title) ?></a>
      </p>
    <?php endif; ?>
    <?php if($feedback->result && isset($feedbackLang->conversionTypes[$feedback->solution])): ?>
      <p class="mt-4">
        <?= $escape($feedbackLang->result) ?>
        <?php if($feedback->solution !== 'ticket' && \common::hasPriv($feedback->solution, 'view')): ?>
          <a href="<?= $escape(helper::createLink($feedback->solution, 'view', array((int)$feedback->result))) ?>"><?= $escape($feedbackLang->conversionTypes[$feedback->solution]) ?> #<?= (int)$feedback->result ?></a>
        <?php else: ?>
          <?= $escape($feedbackLang->conversionTypes[$feedback->solution]) ?> #<?= (int)$feedback->result ?>
        <?php endif; ?>
      </p>
    <?php endif; ?>
    <section class="mt-6">
      <h3><?= $escape($feedbackLang->desc) ?></h3>
      <p class="whitespace-pre-wrap"><?= $escape($feedback->desc) ?></p>
    </section>
    <?php if($ticket): ?>
      <section class="border rounded p-4 mt-6">
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
      <section class="border rounded p-4 mt-6">
        <h3><?= $escape($feedbackLang->attachments) ?></h3>
        <?php if(\common::hasPriv('feedback', 'download')): ?>
          <ul class="my-2">
            <?php foreach($attachments as $attachment): ?>
              <li><a href="<?= $escape(helper::createLink('feedback', 'download', array('fileID' => $attachment->id))) ?>"><?= $escape($attachment->title) ?></a></li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
        <?php if(\common::hasPriv('feedback', 'upload') && $app->control->feedback->canOperate($feedback, 'edit')): ?>
          <form method="post" enctype="multipart/form-data" action="<?= $escape($link('upload')) ?>" class="flex gap-2 items-center">
            <input type="file" name="files" required aria-label="<?= $escape($feedbackLang->attachments) ?>">
            <button class="btn" type="submit"><?= $escape($feedbackLang->upload) ?></button>
          </form>
        <?php endif; ?>
      </section>
    <?php endif; ?>
    <section class="mt-6">
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
              <label><?= $escape($feedbackLang->repeatFeedback) ?>
                <input class="form-control" type="number" min="1" name="repeatFeedback">
              </label>
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
    </section>
    <section class="mt-6">
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
</main>
<?php html(ob_get_clean());
