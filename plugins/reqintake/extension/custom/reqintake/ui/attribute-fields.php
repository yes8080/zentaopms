<?php $attributeGroup = $attributeGroup ?? 'all'; ?>
<?php foreach($attributeOptions as $field => $options): ?>
    <?php if($attributeGroup !== 'all' && $attributeGroup !== (in_array($field, array('category', 'priority'), true) ? 'basic' : 'extra')) continue; ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <select class="form-control" name="<?= $field ?>">
            <?php if($field === 'suggestedGrade' && !isset($options[$values[$field]])) $options[$values[$field]] = $values[$field]; ?>
            <?php foreach($options as $key => $label): ?>
                <?php if($label === '' && !in_array($field, array('source', 'suggestedGrade'), true)) continue; ?>
                <option value="<?= $escape($key) ?>" <?= (string)$key === $values[$field] ? 'selected' : '' ?>><?= $escape($label) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
<?php endforeach; ?>
<?php if(in_array($attributeGroup, array('all', 'scope'), true)): ?>
<?php foreach(array('branch' => $scopeOptions['branches'] ?? array(0 => ''), 'module' => $scopeOptions['modules'][$values['branch']] ?? array(0 => ''), 'plan' => $scopeOptions['plans'][$values['branch']] ?? array(0 => '')) as $field => $options): ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <select class="form-control" name="<?= $field ?>" data-initial="<?= $escape($values[$field]) ?>">
            <?php if(!isset($options[$values[$field]])) $options[$values[$field]] = '#' . $values[$field]; ?>
            <?php foreach($options as $key => $label): ?>
                <option value="<?= $escape($key) ?>" <?= (string)$key === $values[$field] ? 'selected' : '' ?>><?= $escape($label) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
<?php endforeach; ?>
<fieldset data-reqintake-extra data-unused="<?= $escape($labels->branchNotSelected) ?>"
    data-initial="<?= $escape(json_encode((object)$values['branchModules'], JSON_THROW_ON_ERROR)) ?>" hidden>
    <legend><?= $escape($labels->additionalBranches) ?></legend>
    <div data-reqintake-branches></div>
</fieldset>
<?php endif; ?>
<?php foreach(array('sourceNote' => 255, 'keywords' => 255, 'estimate' => 11, 'customerVersion' => 100, 'suggestedParent' => 10) as $field => $limit): ?>
    <?php if($attributeGroup !== 'all' && $attributeGroup !== ($field === 'estimate' ? 'basic' : 'extra')) continue; ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <input class="form-control" name="<?= $field ?>" value="<?= $escape($values[$field]) ?>" maxlength="<?= $limit ?>" <?= $field === 'estimate' ? 'inputmode="decimal"' : ($field === 'suggestedParent' ? 'inputmode="numeric"' : '') ?>>
    </label>
<?php endforeach; ?>
<?php if(in_array($attributeGroup, array('all', 'content'), true)): ?>
<label class="block mb-2"><?= $escape($labels->fields['acceptance']) ?>
    <?= $renderEditor('acceptance', $values['acceptance'], $rich) ?>
</label>
<?php endif; ?>
<?php if(in_array($attributeGroup, array('all', 'extra'), true)): ?>
<?php foreach(array('mailto', 'suggestedReviewers') as $field): ?>
    <?php
    $selectedAccounts = array_filter(explode(',', $values[$field]), static fn($account) => $account !== '');
    $pickerAccounts = $mailtoOptions + array_combine($selectedAccounts, $selectedAccounts);
    $items = array();
    foreach($pickerAccounts as $account => $label) $items[] = array('value' => (string)$account, 'text' => $label);
    ?>
    <div class="mb-2">
        <span><?= $escape($labels->fields[$field]) ?></span>
        <input type="hidden" name="<?= $field ?>Present" value="1">
        <?php
        \zin\disableGlobalRender();
        try
        {
            echo \zin\mailto(\zin\set::name($field . '[]'), \zin\set::items($items), \zin\set::value($values[$field]),
                \zin\set::multiple(100), \zin\set::contactList(false))->render();
        }
        finally
        {
            \zin\enableGlobalRender();
        }
        ?>
    </div>
<?php endforeach; ?>
<?php endif; ?>
