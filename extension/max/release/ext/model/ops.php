<?php
public function getPairsByProduct($productID, $branch = 0)
{
    return $this->loadExtension('ops')->getPairsByProduct($productID, $branch);
}

public function linkStory(int $releaseID, array $stories): bool
{
    return $this->loadExtension('ops')->linkStory($releaseID, $stories);
}

public function unlinkStory(int $releaseID, int $storyID): bool
{
    return $this->loadExtension('ops')->unlinkStory($releaseID, $storyID);
}

public function batchUnlinkStory(int $releaseID, array $storyIdList): bool
{
    return $this->loadExtension('ops')->batchUnlinkStory($releaseID, $storyIdList);
}
