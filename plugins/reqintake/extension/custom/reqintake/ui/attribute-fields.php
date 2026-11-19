<?php foreach($attributeOptions as $field => $options): ?>
    <label class="block mb-2"><?= $escape($labels->fields[$field]) ?>
        <select class="form-control" name="<?= $field ?>">
            <?php foreach($options as $key => $label): ?>
                <?php if($label === '') continue; ?>
                <option value="<?= $escape($key) ?>" <?= (string)$key === $values[$field] ? 'selected' : '' ?>><?= $escape($label) ?></option>
            <?php endforeach; ?>
        </select>
    </label>
<?php endforeach; ?>
<label class="block mb-2"><?= $escape($labels->fields['acceptance']) ?>
    <textarea class="form-control" name="acceptance"><?= $escape($values['acceptance']) ?></textarea>
</label>
