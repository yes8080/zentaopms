<?php
public function getList(string $objectType, array|int $objectID): array
{
    return $this->loadExtension('feedback')->getList($objectType, $objectID);
}

public function getRelatedFields(string $objectType, int $objectID, string $actionType = '', string $extra = ''): array
{
    return $this->loadExtension('feedback')->getRelatedFields($objectType, $objectID, $actionType, $extra);
}

public function printAction(object $action, string|array $desc = '')
{
    return $this->loadExtension('feedback')->printAction($action, $desc);
}
