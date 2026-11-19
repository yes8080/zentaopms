<?php
public function create(object $report)
{
    return $this->loadExtension('zentaomax')->create($report);
}

public function getList(int $projectID = 0, string $browseType = 'all', string|int $moduleID = '', string $orderBy = 'id_desc', int $limit = 0)
{
    return $this->loadExtension('zentaomax')->getList($projectID, $browseType, $moduleID, $orderBy, $limit);
}

public function getBeginAndEnd(string $period = '')
{
    return $this->loadExtension('zentaomax')->getBeginAndEnd($period);
}

public function isClickable(object $report, string $action)
{
    return $this->loadExtension('zentaomax')->isClickable($report, $action);
}

public function buildSearchForm(int $queryID, string $actionURL)
{
    return $this->loadExtension('zentaomax')->buildSearchForm($queryID, $actionURL);
}

public function getBySearch(int $projectID = 0, int $queryID = 0, string $orderBy = 'id_desc')
{
    return $this->loadExtension('zentaomax')->getBySearch($projectID, $queryID, $orderBy);
}

public function getTemplateContent(int $templateID, int $reportID = 0)
{
    return $this->loadExtension('zentaomax')->getTemplateContent($templateID, $reportID);
}

public function deleteReport(int $reportID)
{
    return $this->loadExtension('zentaomax')->deleteReport($reportID);
}

public function buildSummaryTable(int $projectID, string $end = '')
{
    return $this->loadExtension('zentaomax')->buildSummaryTable($projectID, $end);
}

public function buildWorkloadTable(int $projectID)
{
    return $this->loadExtension('zentaomax')->buildWorkloadTable($projectID);
}

public function getModuleTree(int $projectID, string $browseType)
{
    return $this->loadExtension('zentaomax')->getModuleTree($projectID, $browseType);
}

public function addCategory(object $moduleData)
{
    return $this->loadExtension('zentaomax')->addCategory($moduleData);
}

public function updateCategory(int $moduleID, object $moduleData)
{
    return $this->loadExtension('zentaomax')->updateCategory($moduleID, $moduleData);
}
public function deleteCategory(int $moduleID)
{
    return $this->loadExtension('zentaomax')->deleteCategory($moduleID);
}

public function getModulePairs(int $projectID, string $mode = '')
{
    return $this->loadExtension('zentaomax')->getModulePairs($projectID, $mode);
}

public function copyDocBlock(int $reportID, object $reportContent, int $projectID): object
{
    return $this->loadExtension('zentaomax')->copyDocBlock($reportID, $reportContent, $projectID);
}
