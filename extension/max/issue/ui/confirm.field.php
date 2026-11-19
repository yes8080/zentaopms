<?php
namespace zin;

$fields = defineFieldList('issue.confirm');

$fields->field('title')->width('1/3')->control('static')->value(data('issue.title'));
$fields->field('desc')->width('full')->control('editor')->value(data('issue.desc'));
