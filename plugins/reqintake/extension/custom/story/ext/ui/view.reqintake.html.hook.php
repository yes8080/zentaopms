<?php
namespace zin;

$item = data('story');
if(!$item) return;
$targetType = $item->type;
require dirname(__DIR__, 3) . '/reqintake/ui/backlinks.php';
