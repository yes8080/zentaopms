<?php
namespace zin;

global $app;

$fields = defineFieldList('issue.create', 'issue');

$teamMembers = data('teamMembers') ?: array();
$owner       = data('owner')       ?: array();

$fields->field('execution')->value(data('executionID') ? data('executionID') : 0);
$fields->field('pri')->value(3);
$fields->field('owner')->items(data('from') == 'stakeholder' ? array_merge($teamMembers, $owners) : $teamMembers)->value($owner ? $owner : $app->user->account);
