<?php
/**
 * 构建调研任务搜索表单。
 * Build task search form.
 *
 * @param  int    $queryID
 * @param  string $actionURL
 * @param  string $module
 * @param  bool   $cacheSearchFunc 是否缓存构造搜索参数的方法。默认缓存可以提高性能，构造搜索表单时再加载真实值。
 * @access public
 * @return array
 */
public function buildTaskSearchForm(int $queryID, string $actionURL, string $module, bool $cacheSearchFunc = true): array
{
    if($cacheSearchFunc)
    {
        $this->cacheSearchFunc($module, __METHOD__, func_get_args());
        $this->loadModel('execution');
        return $this->config->execution->search;
    }
    return $this->loadExtension('ipd')->buildTaskSearchForm($queryID, $actionURL, $module, $cacheSearchFunc);
}

/**
 * 构建用户需求搜索表单。
 * Build Requirement search form.
 *
 * @param  int    $queryID
 * @param  string $actionURL
 * @access public
 * @return void
 */
public function buildRequirementSearchForm(int $queryID, string $actionURL): void
{
    $this->loadExtension('ipd')->buildRequirementSearchForm($queryID, $actionURL);
    parent::buildRequirementSearchForm($queryID, $actionURL);
}

/**
 * 构建需求池需求搜索表单
 * Build demand search form.
 *
 * @param  int    $queryID
 * @param  string $actionURL
 * @access public
 * @return void
 */
public function buildDemandSearchForm(int $queryID, string $actionURL): void
{
    $this->loadExtension('ipd')->buildDemandSearchForm($queryID, $actionURL);
}

/**
 * 根据查询条件搜索需求池需求
 * Get demands by search.
 *
 * @param  string $account
 * @param  int    $queryID
 * @param  string $orderBy
 * @param  object $pager
 * @access public
 * @return array
 */
public function getDemandsBySearch(string $account, int $queryID = 0, string $orderBy = 'id_desc', ?object $pager = null): array
{
    return $this->loadExtension('ipd')->getDemandsBySearch($account, $queryID, $orderBy, $pager);
}

/**
 * 获取由我指派的对象。
 * Get assigned by me objects.
 *
 * @param  string $account
 * @param  int    $pager
 * @param  string $orderBy
 * @access public
 * @return array
 */
public function getDemandAssignedByMe(string $account, ?object $pager = null, string $orderBy = 'id_desc'): array
{
    return $this->loadExtension('ipd')->getDemandAssignedByMe($account, $pager, $orderBy);
}
