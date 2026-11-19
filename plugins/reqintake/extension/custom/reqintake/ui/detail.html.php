<?php
namespace zin;

$labels = $lang->reqintake;
$escape = static fn($value) => htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
ob_start();
?>
<section class="panel p-4">
    <a href="<?= $escape(\helper::createLink('reqintake', 'index')) ?>"><?= $escape($labels->common) ?></a>
    <h2>#<?= (int)$item->id ?> <?= $escape($item->title) ?></h2>
    <dl>
        <?php foreach(array('customer', 'channel', 'description') as $field): ?>
            <dt><?= $escape($labels->fields[$field]) ?></dt>
            <dd style="white-space: pre-wrap"><?= $escape($item->$field) ?></dd>
        <?php endforeach; ?>
    </dl>
</section>
<?php
html(ob_get_clean());
