<?php
namespace zin;

global $lang;

$fields = fieldList('bug.create');

$fields->field('injection')
    ->foldable()
    ->control('picker')
    ->items($lang->bug->injectionList)
    ->moveAfter('task');

$fields->field('identify')
     ->foldable()
     ->control('picker')
     ->items($lang->bug->identifyList)
    ->moveAfter('injection');
