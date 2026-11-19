<?php
namespace zin;

$item = data('task');
if(!$item) return;
$targetType = 'task';
require dirname(__DIR__, 3) . '/reqintake/ui/backlinks.php';
