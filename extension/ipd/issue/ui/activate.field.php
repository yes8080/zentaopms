<?php
namespace zin;

$fields = defineFieldList('issue.activate');

$fields->field('assignedTo')->control('picker')->items(data('users'));
$fields->field('activateDate')->control('datetimePicker')->value(helper::now());
