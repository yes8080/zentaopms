<?php
public function create(string $objectType, int $objectID, string $actionType, string|bool $comment = '', string|int|float $extra = '', string $actor = '', bool $autoDelete = true): int|bool
{
    $result = parent::create($objectType, $objectID, $actionType, $comment, $extra, $actor, $autoDelete);
    if(!$result || $objectID < 1 || !empty($this->app->upgrading) || !empty($this->app->installing)) return $result;

    $types = match(strtolower($objectType))
    {
        'story', 'requirement', 'epic' => array('story', 'requirement', 'epic'),
        'bug' => array('bug'),
        'task' => array('task'),
        default => array(),
    };
    if(!$types) return $result;

    static $queued = array();
    $key = $types[0] . ':' . $objectID;
    if(isset($queued[$key])) return $result;
    $queued[$key] = true;

    /* Read committed native data after the action and the enclosing save have completed. */
    $database = $this->dbh;
    $prefix = $this->config->db->prefix;
    $file = $this->app->getBasePath() . 'extension/custom/reqintake/progress.php';
    register_shutdown_function(static function() use ($database, $prefix, $file, $types, $objectID)
    {
        if($database->inTransaction() || !is_file($file)) return;
        try
        {
            require_once $file;
            \ReqIntake\reconcileProgress($database, $prefix, $types, $objectID);
        }
        catch(Throwable $error)
        {
            error_log('Request Intake progress reconciliation failed: ' . $error->getMessage());
        }
    });
    return $result;
}
