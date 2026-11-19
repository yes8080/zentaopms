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
<?php foreach(array('sourceNote' => 255, 'keywords' => 255, 'estimate' => 11) as $field => $limit): ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <input class="form-control" name="<?= $field ?>" value="<?= $escape($values[$field]) ?>" maxlength="<?= $limit ?>" <?= $field === 'estimate' ? 'inputmode="decimal"' : '' ?>>
    </label>
<?php endforeach; ?>
<label class="block mb-2"><?= $escape($labels->fields['acceptance']) ?>
    <?= $renderEditor('acceptance', $values['acceptance'], $rich) ?>
</label>
