<?php
protected function updateTwins(array $storyIdList, int $mainStoryID): void
{
    $this->loadExtension('relation')->updateTwins($storyIdList, $mainStoryID);
}
