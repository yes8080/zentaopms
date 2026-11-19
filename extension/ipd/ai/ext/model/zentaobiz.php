<?php
public function editMiniProgram(string $appID): bool
{
    return $this->loadExtension('zentaobiz')->editMiniProgram($appID);
}

public function createZtAppJson(string $appID): string
{
    return $this->loadExtension('zentaobiz')->createZtAppJson($appID);
}

public function createZtAppZip(string $file): string
{
    return $this->loadExtension('zentaobiz')->createZtAppZip($file);
}

public function deleteMiniProgram(string $appID, string $deleted = '1'): bool|string
{
    return $this->loadExtension('zentaobiz')->deleteMiniProgram($appID, $deleted);
}

public function createKnowledge(object $knowledge, bool $skipUpdateExternal = false): int|bool
{
    return $this->loadExtension('zentaobiz')->createKnowledge($knowledge, $skipUpdateExternal);
}

public function updateExternalKnowledge(object $knowledge, ?object $knowledgeLib = null): bool
{
    return $this->loadExtension('zentaobiz')->updateExternalKnowledge($knowledge, $knowledgeLib);
}

public function updateKnowledge(int $id, object $knowledge): bool
{
    return $this->loadExtension('zentaobiz')->updateKnowledge($id, $knowledge);
}

public function getKnowledgeItemByID(int $id): object|false
{
    return $this->loadExtension('zentaobiz')->getKnowledgeItemByID($id);
}

public function updateKnowledgeItem(int $id, object $data, bool|string $skipUpdateExternal = false): bool
{
    return $this->loadExtension('zentaobiz')->updateKnowledgeItem($id, $data, $skipUpdateExternal);
}

public function updateKnowledgeItemFromSource(object $knowledge, bool|string $skipUpdateExternal = 'no'): object|false
{
    return $this->loadExtension('zentaobiz')->updateKnowledgeItemFromSource($knowledge, $skipUpdateExternal);
}

public function getKnowledgeObjectByID(string $objectType, int $objectID): object|false
{
    return $this->loadExtension('zentaobiz')->getKnowledgeObjectByID($objectType, $objectID);
}

public function deleteKnowledgeItem(int $id): bool
{
    return $this->loadExtension('zentaobiz')->deleteKnowledgeItem($id);
}

public function checkKnowledgeLibPriv(object|bool|null $knowledgeLib): bool
{
    return $this->loadExtension('zentaobiz')->checkKnowledgeLibPriv($knowledgeLib);
}

public function getKnowledgeLibs(string $type = 'my', string $category = '', string $published = '', string $orderBy = 'id_desc', ?object $pager = null, string $keyword = ''): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeLibs($type, $category, $published, $orderBy, $pager, $keyword);
}

public function getKnowledgeLibByID(int $id): object|false
{
    return $this->loadExtension('zentaobiz')->getKnowledgeLibByID($id);
}

public function getKnowledgeLibsByIDs(array $ids): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeLibsByIDs($ids);
}

public function getKnowledgeLibStats(int $libID): object
{
    return $this->loadExtension('zentaobiz')->getKnowledgeLibStats($libID);
}

public function getTextFileItems(int $libID): array
{
    return $this->loadExtension('zentaobiz')->getTextFileItems($libID);
}

public function publishKnowledgeLib(int $id): bool
{
    return $this->loadExtension('zentaobiz')->publishKnowledgeLib($id);
}

public function unpublishKnowledgeLib(int $id): bool
{
    return $this->loadExtension('zentaobiz')->unpublishKnowledgeLib($id);
}

public function deleteKnowledgeLib(int $id): bool
{
    return $this->loadExtension('zentaobiz')->deleteKnowledgeLib($id);
}

public function buildKnowledgeLibSearchForm(string $type, int $queryID, string $actionURL): void
{
    $this->loadExtension('zentaobiz')->buildKnowledgeLibSearchForm($type, $queryID, $actionURL);
}

public function getKnowledgeLibsBySearch(string $type, int $queryID, string $orderBy, ?object $pager = null): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeLibsBySearch($type, $queryID, $orderBy, $pager);
}

public function browseKnowledgeLib(string $type, string $category, string $published, string $orderBy, int $param, int $recTotal = 0, int $recPerPage = 20, int $pageID = 1): object
{
    return $this->loadExtension('zentaobiz')->browseKnowledgeLib($type, $category, $published, $orderBy, $param, $recTotal, $recPerPage, $pageID);
}

public function createKnowledgeLib(object $knowledgeLib, string $actionType = 'created'): int|bool
{
    return $this->loadExtension('zentaobiz')->createKnowledgeLib($knowledgeLib, $actionType);
}

public function ensureExternalKnowledgeLib(object $knowledgeLib): string
{
    return $this->loadExtension('zentaobiz')->ensureExternalKnowledgeLib($knowledgeLib);
}

public function editKnowledgeLib(int $id, object $knowledgeLib): bool
{
    return $this->loadExtension('zentaobiz')->editKnowledgeLib($id, $knowledgeLib);
}

public function importFromDoc(object $knowledgeLib): int|bool
{
    return $this->loadExtension('zentaobiz')->importFromDoc($knowledgeLib);
}

public function importFromAsset(object $knowledgeLib): int|bool
{
    return $this->loadExtension('zentaobiz')->importFromAsset($knowledgeLib);
}

public function buildKnowledgeObjectData(string $objectType, $source): string
{
    return $this->loadExtension('zentaobiz')->buildKnowledgeObjectData($objectType, $source);
}

public function prepareMarkdownLangMap(string $objectType): array
{
    return $this->loadExtension('zentaobiz')->prepareMarkdownLangMap($objectType);
}

public function getKnowledgeItems(int $libID, string $type, string $objectType, string $orderBy = 'id_desc', ?object $pager = null): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeItems($libID, $type, $objectType, $orderBy, $pager);
}

public function getKnowledgeItemsByObjectType(int $libID, string $objectType, ?object $pager = null): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeItemsByObjectType($libID, $objectType, $pager);
}

public function isKnowledgeNeedSync(object $knowledge): bool
{
    return $this->loadExtension('zentaobiz')->isKnowledgeNeedSync($knowledge);
}

public function getKnowledgeByObjectIdList(int $lib, string $objectType, array $objectIdList): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeByObjectIdList($lib, $objectType, $objectIdList);
}

public function batchDeleteKnowledgeItem(array $idList): bool
{
    return $this->loadExtension('zentaobiz')->batchDeleteKnowledgeItem($idList);
}

public function getKnowledgeObjectCols(string $objectType): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeObjectCols($objectType);
}

public function prepareReleaseKnowledgeImportList(array $items): array
{
    return $this->loadExtension('zentaobiz')->prepareReleaseKnowledgeImportList($items);
}

public function checkExistKnowledgeLib(object $knowledgeLib): bool
{
    return $this->loadExtension('zentaobiz')->checkExistKnowledgeLib($knowledgeLib);
}

/** Get published knowledge libraries for API v2. */
public function getKnowledgeLibListForAPI(array $params): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeLibListForAPI($params);
}

/** Get visible knowledge items for API v2. */
public function getKnowledgeItemListForAPI(array $params): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeItemListForAPI($params);
}

/** Get saved knowledge content for API v2. */
public function getKnowledgeItemForAPI(array $params): array
{
    return $this->loadExtension('zentaobiz')->getKnowledgeItemForAPI($params);
}

/** Search knowledge titles and saved content by keywords for API v2. */
public function searchKnowledgesByKeywordForAPI(array $params): array
{
    return $this->loadExtension('zentaobiz')->searchKnowledgesByKeywordForAPI($params);
}

/** Search visible knowledge chunks for API v2. */
public function searchKnowledgeChunksForAPI(array $params): array
{
    return $this->loadExtension('zentaobiz')->searchKnowledgeChunksForAPI($params);
}

public function validateSkillZip(string $filePath): bool
{
    return $this->loadExtension('zentaobiz')->validateSkillZip($filePath);
}

public function createSkill(object $skill): int|bool
{
    return $this->loadExtension('zentaobiz')->createSkill($skill);
}

public function editSkillByApi(object $skill): bool
{
    return $this->loadExtension('zentaobiz')->editSkillByApi($skill);
}

public function getSkillByID(int $id, bool $withContent = true): object|false
{
    return $this->loadExtension('zentaobiz')->getSkillByID($id, $withContent);
}

public function getSkillsByIDs(array $ids): array
{
    return $this->loadExtension('zentaobiz')->getSkillsByIDs($ids);
}

public function getPromptSkillIDs(object $prompt): array
{
    return $this->loadExtension('zentaobiz')->getPromptSkillIDs($prompt);
}

public function getSkillFileContent(int $id, string $path): string
{
    return $this->loadExtension('zentaobiz')->getSkillFileContent($id, $path);
}

public function checkSkillEditPriv(object $skill): bool
{
    return $this->loadExtension('zentaobiz')->checkSkillEditPriv($skill);
}

public function editSkill(int $id, object $skill): bool
{
    return $this->loadExtension('zentaobiz')->editSkill($id, $skill);
}

public function deleteSkillByApi(string $skillID): bool
{
    return $this->loadExtension('zentaobiz')->deleteSkillByApi($skillID);
}

public function updateSkillStatus(int $skillID, string $status, string $type = 'public'): bool
{
    return $this->loadExtension('zentaobiz')->updateSkillStatus($skillID, $status, $type);
}

public function publishSkill(int $skillID): bool
{
    return $this->loadExtension('zentaobiz')->publishSkill($skillID);
}

public function deleteSkill(int $skillID): bool
{
    return $this->loadExtension('zentaobiz')->deleteSkill($skillID);
}

public function deleteSquareSkill(int $skillID): bool
{
    return $this->loadExtension('zentaobiz')->deleteSquareSkill($skillID);
}

public function addSkill(string $skillID)
{
    return $this->loadExtension('zentaobiz')->addSkill($skillID);
}

public function removeSkill(int $skillID): bool
{
    return $this->loadExtension('zentaobiz')->removeSkill($skillID);
}

public function getSkillForReleaseSquare(int $skillID)
{
    return $this->loadExtension('zentaobiz')->getSkillForReleaseSquare($skillID);
}

public function checkPublicSkillName(string $name, int $excludeID = 0): bool
{
    return $this->loadExtension('zentaobiz')->checkPublicSkillName($name, $excludeID);
}

public function releaseSkillToSquare(int $skillID, string $name)
{
    return $this->loadExtension('zentaobiz')->releaseSkillToSquare($skillID, $name);
}

public function getSkillCategories(): array
{
    return $this->loadExtension('zentaobiz')->getSkillCategories();
}

public function getSkills(string $type = 'public', string $status = '', int $category = 0, ?object $pager = null): array
{
    return $this->loadExtension('zentaobiz')->getSkills($type, $status, $category, $pager);
}

public function getSkillActions(object $skill, string $type = 'public'): array
{
    return $this->loadExtension('zentaobiz')->getSkillActions($skill, $type);
}

public function getSkillsBySearch(string $type = 'public', int $queryID = 0, int $category = 0, ?object $pager = null): array
{
    return $this->loadExtension('zentaobiz')->getSkillsBySearch($type, $queryID, $category, $pager);
}

public function browseSkill(string $type = 'public', string $status = '', int $category = 0, int $queryID = 0, int $recTotal = 0, int $recPerPage = 0, int $pageID = 1): object
{
    return $this->loadExtension('zentaobiz')->browseSkill($type, $status, $category, $queryID, $recTotal, $recPerPage, $pageID);
}

public function getPromptDisplayPositionList(): array
{
    return $this->loadExtension('zentaobiz')->getPromptDisplayPositionList();
}

public function getPromptProcessObjectList(): array
{
    return $this->loadExtension('zentaobiz')->getPromptProcessObjectList();
}

public function getPromptActionPurposeListByModule(array $moduleItems = array()): array
{
    return $this->loadExtension('zentaobiz')->getPromptActionPurposeListByModule($moduleItems);
}

public function getPromptDisplayPositionMap(): array
{
    return $this->loadExtension('zentaobiz')->getPromptDisplayPositionMap();
}

public function buildNotifyRule(array $roles = array(), array $users = array(), array $methods = array()): string
{
    return $this->loadExtension('zentaobiz')->buildNotifyRule($roles, $users, $methods);
}

public function splitNotifyTargets(array $targets): array
{
    return $this->loadExtension('zentaobiz')->splitNotifyTargets($targets);
}

public function formatNotifyTargetsText(object $rule, array $users = array()): string
{
    return $this->loadExtension('zentaobiz')->formatNotifyTargetsText($rule, $users);
}

public function formatCycleConfigText(object $prompt): string
{
    return $this->loadExtension('zentaobiz')->formatCycleConfigText($prompt);
}

public function parseNotifyRule(string|null $notifyRule): object
{
    return $this->loadExtension('zentaobiz')->parseNotifyRule($notifyRule);
}

public function formatTimerToList(array $accounts): string
{
    return $this->loadExtension('zentaobiz')->formatTimerToList($accounts);
}

public function parseTimerToList(string $toList): array
{
    return $this->loadExtension('zentaobiz')->parseTimerToList($toList);
}

public function resolveTimerQueueToList(object $object, object $rule): string
{
    return $this->loadExtension('zentaobiz')->resolveTimerQueueToList($object, $rule);
}

public function getTimerQueueCounts(int $agentID): array
{
    return $this->loadExtension('zentaobiz')->getTimerQueueCounts($agentID);
}

public function enqueueTimerAgentObjects(int $agentID, array $objects, string $objectType = 'project'): int
{
    return $this->loadExtension('zentaobiz')->enqueueTimerAgentObjects($agentID, $objects, $objectType);
}

public function claimTimerQueueBatch(int $agentID, int $limit): array
{
    return $this->loadExtension('zentaobiz')->claimTimerQueueBatch($agentID, $limit);
}

public function completeTimerQueueItem(int $queueID, string $content = '', string $toList = ''): void
{
    $this->loadExtension('zentaobiz')->completeTimerQueueItem($queueID, $content, $toList);
}

public function deleteTimerQueueByAgent(int $agentID): void
{
    $this->loadExtension('zentaobiz')->deleteTimerQueueByAgent($agentID);
}

public function getTimerQueueRows(int $agentID, string $status = ''): array
{
    return $this->loadExtension('zentaobiz')->getTimerQueueRows($agentID, $status);
}

public function hasRecentTimerLog(int $agentID, int $minutes = 30): bool
{
    return $this->loadExtension('zentaobiz')->hasRecentTimerLog($agentID, $minutes);
}

public function closeStaleTimerQueueDoing(int $agentID): int
{
    return $this->loadExtension('zentaobiz')->closeStaleTimerQueueDoing($agentID);
}

public function getTimerQueueAction(object $agent, string $today = ''): string
{
    return $this->loadExtension('zentaobiz')->getTimerQueueAction($agent, $today);
}

public function buildNotifyItemsFromQueue(array $rows): array
{
    return $this->loadExtension('zentaobiz')->buildNotifyItemsFromQueue($rows);
}

public function finishTimerAgentCycle(object $agent, array $result): array
{
    return $this->loadExtension('zentaobiz')->finishTimerAgentCycle($agent, $result);
}

public function createTimerLog(int $agentID, array $result): void
{
    $this->loadExtension('zentaobiz')->createTimerLog($agentID, $result);
}

public function validateTimerBasicInfo(object $data): bool
{
    return $this->loadExtension('zentaobiz')->validateTimerBasicInfo($data);
}

public function isTimerAgentDue(object $agent, string $today = ''): bool
{
    return $this->loadExtension('zentaobiz')->isTimerAgentDue($agent, $today);
}

public function runTimerAgents(): void
{
    $this->loadExtension('zentaobiz')->runTimerAgents();
}

public function executeTimerAgent(int $agentID): array
{
    return $this->loadExtension('zentaobiz')->executeTimerAgent($agentID);
}

public function buildTimerNotifyBuckets(array $notifyItems, object $rule): array
{
    return $this->loadExtension('zentaobiz')->buildTimerNotifyBuckets($notifyItems, $rule);
}

public function buildTimerObjectPrompt(object $agent, object $object): array
{
    return $this->loadExtension('zentaobiz')->buildTimerObjectPrompt($agent, $object);
}

public function buildTimerBatchPrompt(object $agent, array $objects): array
{
    return $this->loadExtension('zentaobiz')->buildTimerBatchPrompt($agent, $objects);
}

public function formatTimerNotifyMarkdown(array $notifyItems): string
{
    return $this->loadExtension('zentaobiz')->formatTimerNotifyMarkdown($notifyItems);
}

public function formatTimerNotifyHtml(string $markdown): string
{
    return $this->loadExtension('zentaobiz')->formatTimerNotifyHtml($markdown);
}

public function dispatchTimerNotifications(object $agent, array $notifyItems): bool
{
    return $this->loadExtension('zentaobiz')->dispatchTimerNotifications($agent, $notifyItems);
}

public function converseZAI(string $systemPrompt, string|array $messages, array $options = []): string|false
{
    return $this->loadExtension('zentaobiz')->converseZAI($systemPrompt, $messages, $options);
}

public function getTimerLogs(int $agentID, int $limit = 20): array
{
    return $this->loadExtension('zentaobiz')->getTimerLogs($agentID, $limit);
}

public function prepareCycleConfigFromPost(object $data): string
{
    return $this->loadExtension('zentaobiz')->prepareCycleConfigFromPost($data);
}

/**
 * 创建分类链接。
 * Create category link.
 *
 * @param  string $type
 * @param  object $module
 * @return object
 */
public static function createCategoryLink(string $type, object $module): object
{
    global $app;
    $methodName = $app->rawMethod;
    $rawParams  = isset($app->rawParams) ? $app->rawParams : array();
    $status     = zget($rawParams, 'status', $methodName == 'browseskill' ? 'active' : '');
    $queryID    = (int)zget($rawParams, 'queryID', 0);

    $params = "status={$status}&category={$module->id}";
    if($status == 'bysearch') $params .= "&queryID={$queryID}";

    $data = new stdclass();
    $data->id     = (string)$module->id;
    $data->parent = (string)$module->parent;
    $data->name   = $module->name;
    $data->url    = helper::createLink('ai', $methodName, $params);

    return $data;
}
