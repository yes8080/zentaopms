<?php
public function create(object $task, bool $createAction = true): false|int
{
    $parameters = $this->app->getParams();
    parse_str(str_replace(array(',', ' '), array('&', ''), $parameters['cardPosition'] ?? ''), $extra);
    if(!array_key_exists('riOperation', $extra)) return parent::create($task, $createAction);

    $this->app->loadLang('reqintake');
    try
    {
        if(!is_string($extra['riOperation']) || !empty($parameters['todoID']) || !empty($parameters['bugID'])
            || !empty($extra['columnID']) || !empty($this->post->lane)) throw new DomainException('linkTarget');
        $id = $this->loadModel('reqintake')->convertToTask(
            $extra['riOperation'], (int)$task->execution, fn() => parent::create($task, $createAction)
        );
        if($id) return $id;
        if($this->dbh->inTransaction()) return false;
        throw new DomainException('taskConversionUncertain');
    }
    catch(DomainException | PDOException $error)
    {
        /* The native controller rolls back after a failed create. */
        if(!$this->dbh->inTransaction()) $this->dbh->beginTransaction();
        $key = $error instanceof DomainException ? $error->getMessage() : 'taskConversionUncertain';
        dao::$errors['name'][] = $this->lang->reqintake->errors[$key] ?? $this->lang->reqintake->invalid;
        return false;
    }
}
