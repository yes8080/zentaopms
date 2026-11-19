<?php
/**
 * The control file of execution module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Yangyang Shi <shiyangyang@cnezsoft.com>
 * @package     execution
 * @version     $Id$
 * @link        http://www.zentao.net
 */
public function mergeRelations(array $relations = array()): array
{
    return $this->loadExtension('gantt')->mergeRelations($relations);
}

public function getRelationTasks(array $taskList, int $projectID, int $executionID, array $appendTasks = array()): array
{
    return $this->loadExtension('gantt')->getRelationTasks($taskList, $projectID, $executionID, $appendTasks);
}

public function getDisabledTasks(array $taskRelations, int $taskID, string $taskType): array
{
    return $this->loadExtension('gantt')->getDisabledTasks($taskRelations, $taskID, $taskType);
}

public function checkRelation(array $relations = array(), int $projectID = 0, array $tasks = array()): bool
{
    return $this->loadExtension('gantt')->checkRelation($relations, $projectID, $tasks);
}

public function createRelationOfTasks(int $projectID, int $executionID): bool
{
    return $this->loadExtension('gantt')->createRelationOfTasks($projectID, $executionID);
}

public function updateRelationOfTask(int $relationID, int $projectID): bool
{
    return $this->loadExtension('gantt')->updateRelationOfTask($relationID, $projectID);
}

public function editRelationOfTasks(int $projectID): bool
{
    return $this->loadExtension('gantt')->editRelationOfTasks($projectID);
}

public function getRelationsOfTasks(int $projectID, int $executionID, ?object $pager = null): array
{
    return $this->loadExtension('gantt')->getRelationsOfTasks($projectID, $executionID, $pager);
}

public function getDataForGantt(int $executionID, string $type, string $orderBy, int $productID = 0, bool $bysearch = false, int $queryID = 0, string $versionID = '0'): array
{
    return $this->loadExtension('gantt')->getDataForGantt($executionID, $type, $orderBy, $productID, $bysearch, $queryID, $versionID);
}

public function deleteRelation(int $relationID): bool
{
    return $this->loadExtension('gantt')->deleteRelation($relationID);
}

public function parseOrderBy(string $orderBy): array
{
    return $this->loadExtension('gantt')->parseOrderBy($orderBy);
}

public function buildKanbanOrderBy(string $field, string $currentOrder, string $currentDirect): array
{
    return $this->loadExtension('gantt')->buildKanbanOrderBy($field, $currentOrder, $currentDirect);
}

public function checkTaskRelation(array $relations, int $projectID): array
{
    return $this->loadExtension('gantt')->checkTaskRelation($relations, $projectID);
}

public function getHolidays(object $project, string $begin = '', string $end = ''): array
{
    return $this->loadExtension('gantt')->getHolidays($project, $begin, $end);
}
