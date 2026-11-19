<?php
$storyID   = $this->loadExtension('feedback')->create($story, $executionID, $bugID, $extra, $todoID);
$extraList = $this->parseExtra($extra);
if(!empty($extraList['piID'])) $this->loadModel('pi')->linkKanbanObjects($extraList['piID'], $extraList['laneID'], $extraList['columnID'], 'story', array($storyID));

return $storyID;
