<?php
public function send(string $objectType, int $objectID, string $actionType, int $actionID, string $actor = '', string $extra = ''): void
{
    $this->loadExtension('sms')->send($objectType, $objectID, $actionType, $actionID, $actor, $extra);
}
