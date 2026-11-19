<?php
public function getDocumentList()
{
    return $document = $this->dao->select("t1.id, CONCAT_WS(' / ', t2.name, t1.name) as name")->from(TABLE_ZOUTPUT)->alias('t1')
        ->leftJoin(TABLE_ACTIVITY)->alias('t2')->on('t1.activity = t2.id')
        ->where('t1.deleted')->eq(0)
        ->fetchPairs('id', 'name');
}

public function getPlans(int $executionID = 0, int $productID = 0, string $orderBy = 'id_asc'): array
{
    $plans        = $this->getStage($executionID, $productID, 'all', $orderBy);
    $documentList = $this->getDocumentList();

    $parents = array();
    foreach($plans as $planID => $plan)
    {
        $document = '';
        if(!empty($plan->output))
        {
            $output = explode(',', $plan->output);
            foreach($output as $title) if(isset($documentList[$title])) $document .= $documentList[$title];
        }

        $plan->output = empty($plan->output) ? '' : $document;

        $plan->grade == 1 ? $parents[$planID] = $plan : $children[$plan->parent][] = $plan;
    }

    foreach($parents as $planID => $plan) $parents[$planID]->children = isset($children[$planID]) ? $children[$planID] : array();

    return $parents;
}

/**
 * Get the stage set to milestone.
 *
 * @param  int    $projectID
 * @access public
 * @return array
 */
public function getMilestones(int $projectID = 0)
{
    $milestones = $this->dao->select('id, path')->from(TABLE_PROJECT)
        ->where('project')->eq($projectID)
        ->andWhere('type')->eq('stage')
        ->andWhere('milestone')->eq(1)
        ->andWhere('deleted')->eq(0)
        ->orderBy('begin_desc,path')
        ->fetchPairs();

    return $this->formatMilestones($milestones, $projectID);
}

/**
 * 根据product获取里程碑。
 * Get milestone by product.
 *
 * @param  int    $productID
 * @param  int    $projectID
 * @access public
 * @return array
 */
public function getMilestoneByProduct(int $productID, int $projectID): array
{
    $milestones = $this->dao->select('t1.id, t1.path')->from(TABLE_PROJECT)->alias('t1')
        ->leftJoin(TABLE_PROJECTPRODUCT)->alias('t2')->on('t1.id=t2.project')
        ->where('t2.product')->eq($productID)
        ->andWhere('t1.project')->eq($projectID)
        ->andWhere('t1.milestone')->eq(1)
        ->andWhere('t1.type')->eq('stage')
        ->andWhere('t1.deleted')->eq(0)
        ->orderBy('t1.begin asc,path')
        ->fetchPairs();

    return $this->formatMilestones($milestones, $projectID);
}

/**
 * Format milestones use '/'.
 *
 * @param  array   $milestones
 * @param  int     $projectID
 * @access private
 * @return array
 */
private function formatMilestones(array $milestones, int $projectID)
{
    $parentStageList = $this->dao->select('parent')->from(TABLE_PROJECT)
        ->where('project')->eq($projectID)
        ->andWhere('deleted')->eq(0)
        ->andWhere('parent')->gt(0)
        ->fetchPairs();

    $allStages = $this->dao->select('id,name')->from(TABLE_EXECUTION)
        ->where('project')->eq($projectID)
        ->andWhere('type')->notin('program,project')
        ->fetchPairs();

    foreach($milestones as $id => $path)
    {
        if(isset($parentStageList[$id]))
        {
            unset($milestones[$id]);    // 过滤父阶段。
            continue;
        }

        $paths = explode(',', trim($path, ','));
        $stageName = '';
        foreach($paths as $stage)
        {
            if(isset($allStages[$stage])) $stageName .= '/' . $allStages[$stage];
        }
        $milestones[$id] = trim($stageName, '/');
    }

    return $milestones;
}
