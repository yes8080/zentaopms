<?php
public function buildTrackCols(string $storyType): array
{
    return $this->loadExtension('ipd')->buildTrackCols($storyType);
}

public function buildTrackItems(array $allStories, array $leafNodes, string $storyType, array $demands = array()): array
{
    return $this->loadExtension('ipd')->buildTrackItems($allStories, $leafNodes, $storyType, $demands);
}

public function buildTrackLanes(array $leafNodes, string $storyType, array $demands = array()): array
{
    return $this->loadExtension('ipd')->buildTrackLanes($leafNodes, $storyType, $demands);
}
