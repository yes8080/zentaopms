<?php
$plans = array_values(array_filter($handling, static fn($entry) => $entry->kind === 'plan'));
$plan = $plans[0] ?? null;
?>
<section class="detail-section">
<h3 class="detail-section-title text-md py-1 font-bold"><?= $escape($labels->handlingPlan) ?></h3>
<?php if($plan): ?>
    <dl>
        <dt><?= $escape($labels->handlingNext) ?></dt>
        <dd><?= $escape($plan->summary) ?></dd>
        <dt><?= $escape($labels->handlingRemaining) ?></dt>
        <dd class="whitespace-pre-wrap"><?= $escape($plan->details) ?></dd>
    </dl>
<?php endif; ?>
<?php if($canRevise): ?>
    <?php foreach(array('plan', 'reply') as $kind): ?>
        <details>
            <summary><?= $escape($kind === 'plan' ? $labels->handlingEdit : $labels->handlingReply) ?></summary>
            <form method="post" class="reqintake-form">
                <input type="hidden" name="intent" value="handling">
                <input type="hidden" name="kind" value="<?= $kind ?>">
                <input type="hidden" name="token" value="<?= $escape($linkToken) ?>">
                <input type="hidden" name="version" value="<?= (int)$item->version ?>">
                <label class="block"><?= $escape($kind === 'plan' ? $labels->handlingNext : $labels->handlingRecipient) ?>
                    <input class="form-control" name="summary" maxlength="500" value="<?= $escape($kind === 'plan' ? ($plan->summary ?? '') : $item->customer) ?>" <?= $kind === 'reply' ? 'required' : '' ?>>
                </label>
                <?php if($kind === 'reply'): ?>
                    <label class="block"><?= $escape($labels->fields['channel']) ?>
                        <input class="form-control" name="replyChannel" value="<?= $escape($item->channel) ?>" maxlength="64" required>
                    </label>
                <?php endif; ?>
                <label class="block"><?= $escape($kind === 'plan' ? $labels->handlingRemaining : $labels->handlingContent) ?>
                    <textarea class="form-control" name="details" maxlength="2000" <?= $kind === 'reply' ? 'required' : '' ?>><?= $escape($kind === 'plan' ? ($plan->details ?? '') : '') ?></textarea>
                </label>
                <button class="btn" type="submit"><?= $escape($kind === 'plan' ? $labels->handlingEdit : $labels->handlingReply) ?></button>
                <?php if($kind === 'reply'): ?>
                    <fieldset class="mt-2">
                        <legend><?= $escape($labels->replyAndClose) ?></legend>
                        <label class="block"><?= $escape($labels->replyAndCloseReason) ?>
                            <input class="form-control" name="reason" maxlength="500">
                        </label>
                        <label class="block"><input type="checkbox" name="verified" value="1"> <?= $escape($labels->closeVerification) ?></label>
                        <button class="btn" type="submit" name="closeAfterReply" value="1"><?= $escape($labels->replyAndClose) ?></button>
                    </fieldset>
                <?php endif; ?>
            </form>
        </details>
    <?php endforeach; ?>
<?php endif; ?>
<?php if($handling): ?>
    <details>
        <summary><?= $escape($labels->handlingHistory) ?></summary>
        <ul>
            <?php foreach($handling as $entry): ?>
                <li>
                    <p><?= $escape($entry->kind === 'plan' ? $labels->handlingEdit : $labels->handlingReply) ?> · <?= $escape($entry->actor) ?> · <?= $escape($entry->createdDate) ?></p>
                    <p><?= $escape($entry->summary) ?> <?= $escape($entry->channel) ?></p>
                    <p class="whitespace-pre-wrap"><?= $escape($entry->details) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </details>
<?php endif; ?>
</section>
