<?php
public function create(object $story, int $executionID = 0, int $bugID = 0, string $extra = '', int $todoID = 0): int|false
{
    $operation = $this->parseExtra($extra)['riOperation'] ?? null;
    if($operation === null) return parent::create($story, $executionID, $bugID, $extra, $todoID);

    $this->app->loadLang('reqintake');
    try
    {
        if(!is_string($operation) || $executionID || $bugID || $todoID) throw new DomainException('linkTarget');
        $create = fn() => parent::create($story, $executionID, $bugID, '', $todoID);
        return $this->loadModel('reqintake')->convertToStory($operation, $story, $create);
    }
    catch(DomainException $error)
    {
        dao::$errors['title'][] = $this->lang->reqintake->errors[$error->getMessage()] ?? $this->lang->reqintake->invalid;
        return false;
    }
}

public function createTwins(object $storyData, int $objectID, int $bugID, string $extra = '', int $todoID = 0): int|false
{
    if(!isset($this->parseExtra($extra)['riOperation'])) return parent::createTwins($storyData, $objectID, $bugID, $extra, $todoID);

    $this->app->loadLang('reqintake');
    dao::$errors['branch'][] = $this->lang->reqintake->errors['linkTarget'];
    return false;
}
