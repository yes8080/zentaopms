<?php
/**
 * 获取报告列表。
 * Get report list.
 *
 * @param  int    $objectID
 * @param  string $objectType
 * @param  int    $extra
 * @param  string $browseType
 * @param  int    $queryId
 * @param  string $orderBy
 * @param  object $pager
 * @access public
 * @return array
 */
public function getList(int $objectID, string $objectType, int $extra = 0, string $browseType = '', int $queryID = 0, string $orderBy = 'id_desc', ?object $pager = null): array
{
    if(common::isTutorialMode()) return $this->loadModel('tutorial')->getTestReports();

    $reportQuery = '';
    if($browseType == 'bysearch') $reportQuery = $this->testreportTao->processSearchQuery($queryID);
    $reports = $this->dao->select('*')->from(TABLE_TESTREPORT)->fetchAll('id', false);

    $testReportProducts = $this->dao->select('id,product,project,task,execution')->from(TABLE_TESTTASKPRODUCT)
        ->where('1=1')
        ->beginIF($objectType == 'execution')->andWhere('execution')->eq($objectID)->fi()
        ->beginIF($objectType == 'project')->andWhere('project')->eq($objectID)->fi()
        ->beginIF($objectType == 'product')->andWhere('product')->eq($objectID)->fi()
        ->fetchAll();

    $testReportList = array();
    foreach($reports as $report)
    {
        if($objectType == 'execution' && $report->execution == $objectID)
        {
            $testReportList[$report->id] = $report;
        }
        elseif($objectType == 'project' && $report->project == $objectID)
        {
            $testReportList[$report->id] = $report;
        }
        elseif($objectType == 'product' && $extra && $report->objectID == $extra && $report->objectType == 'testtask')
        {
            $testReportList[$report->id] = $report;
        }
        elseif($objectType == 'product' && !$extra && $report->product == $objectID)
        {
            $testReportList[$report->id] = $report;
        }
        else
        {
            foreach($testReportProducts as $testReportProduct)
            {
                if(strpos(",{$report->tasks},", ",$testReportProduct->task,") !== false)
                {
                    $testReportList[$report->id] = $report;
                    break;
                }
            }
        }
    }

    $reports = $this->dao->select('*')->from(TABLE_TESTREPORT)
        ->where('deleted')->eq(0)
        ->andWhere('id')->in(array_keys($testReportList))
        ->beginIF($browseType == 'bysearch')->andWhere($reportQuery)->fi()
        ->orderBy($orderBy)
        ->page($pager)
        ->fetchAll('id', false);

    return $this->appendProductGroup($reports);
}

/**
 * 获取测试报告键对。
 * Get pairs.
 *
 * @param  int    $productID
 * @param  int    $appendID
 * @access public
 * @return array
 */
public function getPairs(int $productID = 0, int $appendID = 0): array
{
    $testReports = $this->dao->select('id,title,product,tasks')->from(TABLE_TESTREPORT)
        ->where('deleted')->eq(0)
        ->orderBy('id_desc')
        ->fetchAll('id');

    $testReportProducts = $this->dao->select('id,product,task')->from(TABLE_TESTTASKPRODUCT)->where('product')->eq($productID)->fetchAll();

    $testReportList = array();
    foreach($testReports as $testReport)
    {
        if($testReport->product == $productID)
        {
            $testReportList[$testReport->id] = $testReport->title;
        }
        else
        {
            foreach($testReportProducts as $testReportProduct)
            {
                if(strpos(",{$testReport->tasks},", ",$testReportProduct->task," !== false))
                {
                    $testReportList[$testReport->id] = $testReport->title;
                    break;
                }
            }
        }
    }


    if(!empty($testReports[$appendID])) $testReportList[$appendID] = $testReports[$appendID]->title;

    return $testReportList;
}

/**
 * 追加测试单产品分组数据。
 * Append product group.
 *
 * @param  array  $reports
 * @access public
 * @return array
 */
public function appendProductGroup(array $reports): array
{
    $taskBuilds = $this->dao->select('t1.task, t2.*, t4.multiple, t3.name as `executionName`, t4.name as `projectName`, t5.name as `productName`')->from(TABLE_TESTTASKPRODUCT)->alias('t1')
        ->leftJoin(TABLE_BUILD)->alias('t2')->on('t1.build = t2.id')
        ->leftJoin(TABLE_EXECUTION)->alias('t3')->on('t1.execution = t3.id')
        ->leftJoin(TABLE_PROJECT)->alias('t4')->on('t1.project = t4.id')
        ->leftJoin(TABLE_PRODUCT)->alias('t5')->on('t1.product = t5.id')
        ->fetchGroup('task', 'id');

    foreach($reports as $reportID => $report)
    {
        foreach(explode(',', $report->tasks) as $taskID)
        {
            if(empty($taskBuilds[$taskID])) continue;
            $builds = $taskBuilds[$taskID];
            $executions = array();
            foreach($builds as $build)
            {
                if(!$build->multiple) continue;
                if($build->projectName && $build->executionName)
                {
                    $executions[$build->execution] = $build->projectName . '/' . $build->executionName;
                }
                elseif(!$build->executionName)
                {
                    $executions[$build->project] = $build->projectName;
                }
            }
            $reports[$reportID]->execution = implode(',', $executions);
        }
    }

    return $reports;
}
