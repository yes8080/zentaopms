<?php
namespace zin;

global $lang;

$fields = defineFieldList('opportunity.cancel');

$fields->field('cancelReason')->width('1/2')->control('picker')->items($lang->opportunity->cancelReasonList);
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
