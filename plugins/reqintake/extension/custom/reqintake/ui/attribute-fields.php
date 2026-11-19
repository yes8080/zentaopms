<?php foreach($attributeOptions as $field => $options): ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <select class="form-control" name="<?= $field ?>">
            <?php foreach($options as $key => $label): ?>
                <?php if($label === '' && $field !== 'source') continue; ?>
                <option value="<?= $escape($key) ?>" <?= (string)$key === $values[$field] ? 'selected' : '' ?>><?= $escape($label) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
<?php endforeach; ?>
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
<?php foreach(array('sourceNote' => 255, 'keywords' => 255, 'estimate' => 11) as $field => $limit): ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <input class="form-control" name="<?= $field ?>" value="<?= $escape($values[$field]) ?>" maxlength="<?= $limit ?>" <?= $field === 'estimate' ? 'inputmode="decimal"' : '' ?>>
    </label>
<?php endforeach; ?>
<label class="block mb-2"><?= $escape($labels->fields['acceptance']) ?>
    <?= $renderEditor('acceptance', $values['acceptance'], $rich) ?>
</label>
