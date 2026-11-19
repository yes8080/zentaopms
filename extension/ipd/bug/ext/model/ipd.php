<?php
/**
 * 获取执行的 bug。
 * Get bugs of a execution.
 *
 * @param  int          $executionID
 * @param  int          $productID
 * @param  int|string   $branchID
 * @param  string|array $builds
 * @param  string       $type
 * @param  int          $param
 * @param  string       $orderBy
 * @param  string       $excludeBugs
 * @param  object       $pager
 * @access public
 * @return array
 */
public function getExecutionBugs(int $executionID, int $productID = 0, string|int $branchID = 'all', string|array $builds = '0', string $type = '', int $param = 0, string $orderBy = 'id_desc', string $excludeBugs = '', ?object $pager = null): array
{
    $bugs = parent::getExecutionBugs($executionID, $productID, $branchID, $builds, $type, $param, $orderBy, $excludeBugs, $pager);

    /* 追加是否需要确认撤销/移除操作的信息到数据列表中。*/
    /* Build confirmeObject. */
    return $this->loadModel('story')->getAffectObject($bugs, 'bug');
}
