<?php
public function getProjectsConsumed(array $projectIdList, string $time = ''): array
{
    return $this->loadExtension('effort')->getProjectsConsumed($projectIdList, $time);
}
