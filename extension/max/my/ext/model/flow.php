<?php
public function getFlowPairs(): array
{
    return $this->loadExtension('flow')->getFlowPairs();
}

public function appendWorkFlowMenu(): void
{
    $this->loadExtension('flow')->appendWorkFlowMenu();
}

public function getAssignedFlowCount(string $module): int
{
    return $this->loadExtension('flow')->getAssignedFlowCount($module);
}