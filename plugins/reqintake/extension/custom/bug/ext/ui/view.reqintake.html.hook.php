<?php
namespace zin;

$item = data('bug');
if(!$item) return;
$targetType = 'bug';
require dirname(__DIR__, 3) . '/reqintake/ui/backlinks.php';
