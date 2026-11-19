<?php
namespace zin;

global $lang;

$fields = defineFieldList('issue.close');

$fields->field('closedDate')->width('1/3')->control('datePicker')->value(date('Y-m-d'));
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
