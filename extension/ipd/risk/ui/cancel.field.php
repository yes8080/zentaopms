<?php
namespace zin;

global $app, $lang;

$fields = defineFieldList('risk.cancel');

$fields->field('cancelBy')->control('picker')->items(data('users'))->value($app->user->account);
$fields->field('cancelDate')->control('datePicker')->value(helper::today());
$fields->field('cancelReason')->control('picker')->items($lang->risk->cancelReasonList)->value('');
$fields->field('comment')->label($lang->comment)->width('full')->control('editor');
