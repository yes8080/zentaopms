<?php
namespace zin;

global $app;

$fields = fieldList('task.create');

$docs    = array();
$docList = $app->control->loadModel('doc')->getMySpaceDocs('all', 'bykeyword');
foreach($docList as $doc) $docs[] = array('text' => $doc->title, 'value' => $doc->id);

$fields->field('docs')->width('full')->control(array('control' => 'picker', 'multiple' => true, 'maxItemsCount' => 50, 'menu' => array('checkbox' => true), 'toolbar' => true))->items($docs)->foldable();

/* 与前台创建页默认模式字段顺序保持一致：关键词、抄送给、相关文档、附件。 */
$fields->sort('desc,keywords,mailto,docs,files');