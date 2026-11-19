<label class="block"><?= $escape($labels->closeOutcome) ?>
    <select name="outcome" class="form-control">
        <?php foreach($labels->closeOutcomes as $outcome => $label): ?>
            <?php if($outcome === 'duplicate') continue; ?>
            <option value="<?= $escape($outcome) ?>"><?= $escape($label) ?></option>
        <?php endforeach; ?>
    </select>
</label>
<label class="block"><input type="checkbox" name="verified" value="1"> <?= $escape($labels->closeVerification) ?></label>
