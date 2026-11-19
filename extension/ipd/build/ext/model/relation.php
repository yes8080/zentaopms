<?php
public function linkStory(int $buildID, array $storyIdList): bool
{
    return $this->loadExtension('relation')->linkStory($buildID, $storyIdList);
}

public function unlinkStory(int $buildID, int $storyID): bool
{
    return $this->loadExtension('relation')->unlinkStory($buildID, $storyID);
}

public function batchUnlinkStory(int $buildID, array $storyIDList): bool
{
    return $this->loadExtension('relation')->batchUnlinkStory($buildID, $storyIDList);
}
