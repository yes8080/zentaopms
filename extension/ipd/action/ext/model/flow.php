<?php
/**
 * __construct
 *
 * @access public
 * @return void
 */
public function __construct($appName = '')
{
    parent::__construct($appName);
    if($this->app->isServing() || (defined('RUN_MODE') and RUN_MODE == 'api')) $this->loadExtension('flow')->loadCustomLang();
}

/**
 * Get deleted objects.
 *
 * @param  string $type    all|hidden
 * @param  string $orderBy
 * @param  object $pager
 * @access public
 * @return array
 */
public function getTrashes(string $objectType, string $type, string $orderBy, ?object $pager = null): array
{
    return $this->loadExtension('flow')->getTrashes($objectType, $type, $orderBy, $pager);
}

/**
 * Transform the actions for display.
 *
 * @param  int    $actions
 * @access public
 * @return void
 */
public function transformActions(array $actions): array
{
    return $this->loadExtension('flow')->transformActions($actions);
}
