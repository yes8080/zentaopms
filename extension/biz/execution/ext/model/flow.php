<?php
/**
 * Get kanban setting.
 *
 * @access public
 * @return object
 */
public function getKanbanSetting(): object
{
    return $this->loadExtension('flow')->getKanbanSetting();
}

/**
 * Get kanban columns.
 *
 * @param  object $kanbanSetting
 * @access public
 * @return array
 */
public function getKanbanColumns(object $kanbanSetting): array
{
    return $this->loadExtension('flow')->getKanbanColumns($kanbanSetting);
}

/**
 * Get status map of kanban.
 *
 * @param  object $kanbanSetting
 * @access public
 * @return string
 */
public function getKanbanStatusMap($kanbanSetting)
{
    return $this->loadExtension('flow')->getKanbanStatusMap($kanbanSetting);
}

/**
 * Get status list of kanban.
 *
 * @param  object $kanbanSetting
 * @access public
 * @return string
 */
public function getKanbanStatusList(object $kanbanSetting): array
{
    return $this->loadExtension('flow')->getKanbanStatusList($kanbanSetting);
}

/**
 * Get color list of kanban.
 *
 * @param  object $kanbanSetting
 * @access public
 * @return array
 */
public function getKanbanColorList(object $kanbanSetting): array
{
    return $this->loadExtension('flow')->getKanbanColorList($kanbanSetting);
}

/**
 * Get kanban group data.
 *
 * @param  array  $tasks
 * @param  array  $bugs
 * @access public
 * @return array
 */
public function getKanbanGroupData(array $stories, array $tasks = [], array $bugs = [], string $type = 'story'): array
{
    return $this->loadExtension('flow')->getKanbanGroupData($stories, $tasks, $bugs, $type);
}

public function getProjectLink($module, $method, $extra)
{
    return $this->loadExtension('flow')->getProjectLink($module, $method, $extra);
}
