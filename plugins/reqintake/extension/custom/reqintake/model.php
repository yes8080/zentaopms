<?php
class reqintakeModel extends model
{
    public function canAccess(string $method): bool
    {
        return !empty($this->app->user->account) && common::hasPriv('reqintake', $method);
    }

    private function visibleProducts(): array
    {
        return array_values(array_filter(array_map('intval', explode(',', (string)($this->app->user->view->products ?? '')))));
    }

    public function recent(string $scope = 'all', int $product = 0): array
    {
        if(!$this->canAccess('index')) throw new DomainException('product');

        $query = $this->dao->select('f.id,f.title,f.assignedTo,f.assignmentPending,f.status,f.version,p.name AS productName')
            ->from($this->config->db->prefix . 'reqintakeFeedback')->alias('f')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('p.deleted')->eq('0');
        if(empty($this->app->user->admin)) $query->andWhere('f.product')->in($this->visibleProducts() ?: array(0));
        if($product > 0) $query->andWhere('f.product')->eq($product);
        $account = $this->app->user->account;
        if($scope === 'mine') $query->andWhere('f.openedBy')->eq($account);
        if($scope === 'assigned') $query->andWhere('f.assignedTo')->eq($account)->andWhere('f.status')->ne('closed');
        $rows = $query->orderBy('f.id_desc')->limit(50)->fetchAll();
        if(!$rows) return $rows;

        $ids = array_map(static fn($item) => (int)$item->id, $rows);
        $changes = $this->dao->select('feedback,title')->from($this->config->db->prefix . 'reqintakeRevision')
            ->where('feedback')->in($ids)->orderBy('version_desc')->fetchAll();
        $titles = array();
        foreach($changes as $change) $titles[(int)$change->feedback] ??= $change->title;
        foreach($rows as $row) $row->title = $titles[(int)$row->id] ?? $row->title;
        return $rows;
    }

    public function findFeedback(int $id): object|false
    {
        if(!$this->canAccess('detail') || $id < 1) return false;

        $feedback = $this->dao->select('f.id,f.product,f.title,f.description,f.customer,f.channel,f.openedBy,f.assignedTo,f.status,f.assignmentPending,f.version,p.name AS productName')
            ->from($this->config->db->prefix . 'reqintakeFeedback')->alias('f')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('f.id')->eq($id)->andWhere('p.deleted')->eq('0')->fetch();
        return $feedback && $this->canReadProduct((int)$feedback->product) ? $feedback : false;
    }

    public function revisions(object $feedback): array
    {
        if(!$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();

        return $this->dao->select('version,title,description,customer,channel,actor,createdDate')
            ->from($this->config->db->prefix . 'reqintakeRevision')->where('feedback')->eq((int)$feedback->id)
            ->orderBy('version_desc')->fetchAll();
    }

    public function revise(object $feedback, int $version, array $fields): void
    {
        if(!$this->canHandle($feedback)) throw new DomainException('handler');

        $title = trim($fields['title']);
        if($title === '' || mb_strlen($title) > 255) throw new InvalidArgumentException('title');
        if(trim($fields['description']) === '' || strlen($fields['description']) > 16777215) throw new InvalidArgumentException('description');
        if(mb_strlen($fields['customer']) > 255 || mb_strlen($fields['channel']) > 64) throw new InvalidArgumentException('source');

        $prefix = $this->config->db->prefix;
        $now = helper::now();
        $this->dbh->beginTransaction();
        try
        {
            $update = $this->dbh->prepare("UPDATE `{$prefix}reqintakeFeedback` SET version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status <> 'closed'");
            $update->execute([$now, $feedback->id, $version]);
            if($update->rowCount() !== 1) throw new DomainException('staleFeedback');

            $insert = $this->dbh->prepare("INSERT INTO `{$prefix}reqintakeRevision` (feedback,version,title,description,customer,channel,actor,createdDate) VALUES (?,?,?,?,?,?,?,?)");
            $insert->execute([$feedback->id, $version + 1, $title, $fields['description'], $fields['customer'], $fields['channel'], $this->app->user->account, $now]);
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function followups(object $feedback): array
    {
        if(!$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();

        return $this->dao->select('actor,previousAssignee,nextAssignee,message,createdDate')
            ->from($this->config->db->prefix . 'reqintakeFollowup')->where('feedback')->eq((int)$feedback->id)
            ->orderBy('version_desc')->fetchAll();
    }

    public function recordFollowup(object $feedback, int $version, string $message, ?string $assignee): void
    {
        if(!$this->canHandle($feedback)) throw new DomainException('handler');
        if((int)$feedback->version !== $version || $feedback->status === 'closed') throw new DomainException('staleFeedback');
        $message = trim($message);
        if($message === '' || mb_strlen($message) > 500) throw new InvalidArgumentException('followupMessage');

        $previousAssignee = '';
        if($assignee !== null)
        {
            $assignee = trim($assignee);
            if($assignee === '' || mb_strlen($assignee) > 30 || !$this->canAssign((int)$feedback->product, $assignee))
                throw new DomainException('owner');

            if(!$feedback->assignmentPending && strcasecmp($assignee, $feedback->assignedTo) === 0)
                throw new DomainException('sameAssignee');

            $previousAssignee = $feedback->assignedTo;
        }

        $prefix = $this->config->db->prefix;
        $now = helper::now();
        $this->dbh->beginTransaction();
        try
        {
            $update = $this->dbh->prepare("UPDATE `{$prefix}reqintakeFeedback` SET assignedTo = ?, assignmentPending = ?, version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status <> 'closed'");
            $update->execute([$assignee ?? $feedback->assignedTo, $assignee === null ? $feedback->assignmentPending : 0, $now, $feedback->id, $version]);
            if($update->rowCount() !== 1) throw new DomainException('staleFeedback');

            $insert = $this->dbh->prepare("INSERT INTO `{$prefix}reqintakeFollowup` (feedback,version,actor,previousAssignee,nextAssignee,message,createdDate) VALUES (?,?,?,?,?,?,?)");
            $insert->execute([$feedback->id, $version + 1, $this->app->user->account, $previousAssignee, $assignee ?? '', $message, $now]);
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function canHandle(object $feedback): bool
    {
        return $this->canAccess('index') && $this->canReadProduct((int)$feedback->product)
            && (!empty($this->app->user->admin) || (!$feedback->assignmentPending && $feedback->assignedTo === $this->app->user->account));
    }

    public function visibleTargetTypes(): array
    {
        return array_values(array_filter(array('story', 'requirement', 'epic', 'bug', 'task'), static fn($type) => common::hasPriv($type, 'view')));
    }

    private function targetForProduct(string $type, int $id, int $product): object|false
    {
        if($type === 'task')
        {
            $target = $this->dao->select("t.id,t.name AS title,t.status,'' AS stage,'' AS closedReason,t.execution")
                ->from(TABLE_TASK)->alias('t')
                ->innerJoin(TABLE_PROJECTPRODUCT)->alias('p')->on('p.project = t.execution')
                ->innerJoin(TABLE_EXECUTION)->alias('e')->on("e.id = t.execution AND e.deleted = '0'")
                ->where('t.id')->eq($id)->andWhere('t.deleted')->eq('0')->andWhere('p.product')->eq($product)->fetch();
        }
        elseif($type === 'bug')
        {
            $target = $this->dao->select("id,title,status,'' AS stage,resolution AS closedReason,execution")->from(TABLE_BUG)
                ->where('id')->eq($id)->andWhere('product')->eq($product)->andWhere('deleted')->eq('0')->fetch();
        }
        else
        {
            $target = $this->dao->select('id,title,status,stage,closedReason')->from(TABLE_STORY)
                ->where('id')->eq($id)->andWhere('product')->eq($product)->andWhere('type')->eq($type)->andWhere('deleted')->eq('0')->fetch();
        }

        if($target && !empty($target->execution) && !$this->loadModel('execution')->checkPriv((int)$target->execution)) return false;
        return $target ?: false;
    }

    public function linkedTargets(object $feedback): array
    {
        $types = $this->visibleTargetTypes();
        if(!$types || !$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();

        $prefix = $this->config->db->prefix;
        $links = $this->dao->select('l.target,l.targetType,l.scope,p.checkedDate')
            ->from($prefix . 'reqintakeLink')->alias('l')
            ->leftJoin($prefix . 'reqintakeProgress')->alias('p')->on('p.feedback = l.feedback AND p.targetType = l.targetType AND p.target = l.target')
            ->where('l.feedback')->eq((int)$feedback->id)->andWhere('l.targetType')->in($types)->orderBy('l.target_desc')->fetchAll();
        foreach($links as $link)
        {
            $target = $this->targetForProduct($link->targetType, (int)$link->target, (int)$feedback->product);
            $link->id = $target ? $target->id : null;
            $link->title = $target ? $target->title : '';
            $link->status = $target ? $target->status : '';
            $link->stage = $target ? $target->stage : '';
            $link->closedReason = $target ? $target->closedReason : '';
        }
        return $links;
    }

    public function sourcesForTarget(string $type, int $targetID): array
    {
        if(!$this->canAccess('detail') || !in_array($type, $this->visibleTargetTypes(), true)) return array();

        $query = $this->dao->select('f.id,f.product,f.title')->from($this->config->db->prefix . 'reqintakeLink')->alias('l')
            ->innerJoin($this->config->db->prefix . 'reqintakeFeedback')->alias('f')->on('f.id = l.feedback')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('l.targetType')->eq($type)->andWhere('l.target')->eq($targetID)->andWhere('p.deleted')->eq('0');
        if(empty($this->app->user->admin)) $query->andWhere('f.product')->in($this->visibleProducts() ?: array(0));

        $available = array();
        $sources = array();
        foreach($query->orderBy('f.id_desc')->fetchAll() as $feedback)
        {
            $product = (int)$feedback->product;
            $available[$product] ??= (bool)$this->targetForProduct($type, $targetID, $product);
            if($available[$product]) $sources[] = $feedback;
        }
        return $sources;
    }

    public function linkTarget(int $feedbackID, int $version, int $targetID, string $scope, string $type = 'story'): void
    {
        $this->linkTargets(array($feedbackID => $version), $targetID, $scope, $type);
    }

    public function conversionToken(object $feedback, string $type): string
    {
        $operation = "$feedback->id.$feedback->version";
        $account = $this->app->user->account;
        return $operation . '.' . hash_hmac('sha256', "$account:$type:$operation", (string)$this->session->reqintakeFormKey);
    }

    public function conversionSource(string $token, string $type): object
    {
        if(!in_array($type, array('story', 'requirement', 'epic', 'bug', 'task'), true)
            || !common::hasPriv($type, 'create') || !common::hasPriv($type, 'view')
            || !$this->session->reqintakeFormKey
            || !preg_match('/\A([1-9][0-9]{0,9})\.([1-9][0-9]{0,9})\.([a-f0-9]{64})\z/', $token, $parts))
            throw new DomainException('linkTarget');

        $feedback = $this->findFeedback((int)$parts[1]);
        if(!$feedback || !$this->canHandle($feedback)) throw new DomainException('handler');
        $feedback->version = (int)$parts[2];
        if(!hash_equals($this->conversionToken($feedback, $type), $token)) throw new DomainException('linkTarget');
        return $feedback;
    }

    public function taskExecutions(int $product): array
    {
        if(!common::hasPriv('task', 'create') || !common::hasPriv('task', 'view') || !$this->canReadProduct($product)) return array();

        $executions = $this->dao->select('DISTINCT e.id,e.name')->from(TABLE_PROJECTPRODUCT)->alias('p')
            ->innerJoin(TABLE_EXECUTION)->alias('e')->on('p.project = e.id')
            ->where('p.product')->eq($product)->andWhere('e.deleted')->eq('0')
            ->andWhere('e.type')->in(array('sprint', 'stage', 'kanban'))->orderBy('e.id_desc')->fetchPairs();
        $model = $this->loadModel('execution');
        $limited = !empty($this->app->user->admin) ? array() : explode(',', (string)$model->getLimitedExecution());
        return array_filter($executions, static fn($id) => $model->checkPriv((int)$id) && !in_array((string)$id, $limited, true), ARRAY_FILTER_USE_KEY);
    }

    public function convertToTask(string $token, int $execution, callable $create): int|false
    {
        $feedback = $this->conversionSource($token, 'task');
        if(!isset($this->taskExecutions((int)$feedback->product)[$execution])) throw new DomainException('linkTarget');

        /* Native task creation commits the transaction opened by task::create. The reservation
           becomes durable in that same commit, even if the native call never returns an ID. */
        $operation = hash('sha256', "task:$feedback->id:$feedback->version");
        $table = $this->config->db->prefix . 'reqintakeConversion';
        $lock = $this->dbh->prepare("SELECT target FROM `$table` WHERE operation = ? FOR UPDATE");
        $lock->execute([$operation]);
        $recorded = $lock->fetchColumn();
        $lock->closeCursor();
        if($recorded === false)
        {
            $this->conversionProduct(array((int)$feedback->id => $feedback->version), 'task', true);
            $reserve = $this->dbh->prepare("INSERT INTO `$table` (operation) VALUES (?)");
            $reserve->execute([$operation]);
            $id = $create();
            if(!$id) return false;

            /* Save the exact ID before attempting linkage so a retry can finish the same task. */
            $save = $this->dbh->prepare("UPDATE `$table` SET target = ? WHERE operation = ?");
            $save->execute([$id, $operation]);
        }
        else
        {
            if(!(int)$recorded) throw new DomainException('taskConversionUncertain');
            $id = (int)$recorded;
            unset($_POST['fileList']);
        }

        $target = $this->targetForProduct('task', $id, (int)$feedback->product);
        if(!$target || (int)$target->execution !== $execution) throw new DomainException('linkTarget');
        $this->linkTarget((int)$feedback->id, $feedback->version, $id, '', 'task');
        if($this->dbh->inTransaction()) $this->dbh->commit();
        return $id;
    }

    public function prepareBatchConversion(string $id, array $sources, string $type, string $scope): string
    {
        if(in_array($type, array('bug', 'task'), true)) throw new DomainException('linkTarget');
        if(!$sources || mb_strlen($scope) > 500) throw new DomainException('batchSelection');
        $product = $this->conversionProduct($sources, $type, true);
        ksort($sources, SORT_NUMERIC);
        $operation = hash_hmac('sha256', json_encode(array($id, $this->app->user->account, $type, $sources, $scope), JSON_THROW_ON_ERROR), $this->session->reqintakeFormKey);
        $operations = (array)$this->session->reqintakeBatchConversions;
        $operations[$operation] = array('sources' => $sources, 'scope' => $scope, 'type' => $type, 'account' => $this->app->user->account);
        $this->session->set('reqintakeBatchConversions', array_slice($operations, -32, null, true));
        $token = 'batch.' . $operation;
        return helper::createLink($type, 'create', "productID=$product&branch=&moduleID=0&storyID=0&objectID=0&bugID=0&planID=0&todoID=0&extra=riOperation=$token&storyType=$type");
    }

    public function batchConversion(string $token, string $type): array
    {
        $operation = substr($token, 6);
        $batch = $this->session->reqintakeBatchConversions[$operation] ?? null;
        if(!$batch || $batch['type'] !== $type || $batch['account'] !== $this->app->user->account) throw new DomainException('batchSelection');
        $this->conversionProduct($batch['sources'], $type);
        return $batch;
    }

    private function conversionProduct(array $sources, string $type, bool $checkVersion = false): int
    {
        if(!in_array($type, array('story', 'requirement', 'epic', 'bug', 'task'), true)
            || !common::hasPriv($type, 'create') || !common::hasPriv($type, 'view')) throw new DomainException('linkTarget');

        $product = null;
        foreach($sources as $id => $version)
        {
            $feedback = $this->findFeedback($id);
            if(!$feedback || !$this->canHandle($feedback)) throw new DomainException('handler');
            $product ??= (int)$feedback->product;
            if((int)$feedback->product !== $product) throw new DomainException('batchProduct');
            if($checkVersion && ($feedback->status === 'closed' || (int)$feedback->version !== $version))
                throw new DomainException('staleFeedback');
        }
        return $product;
    }

    public function convertToNative(string $token, string $type, int $targetProduct, callable $create): int|false
    {
        if(str_starts_with($token, 'batch.'))
        {
            $batch = $this->batchConversion($token, $type);
            $sources = $batch['sources'];
            $scope = $batch['scope'];
        }
        else
        {
            $feedback = $this->conversionSource($token, $type);
            $sources = array((int)$feedback->id => $feedback->version);
            $scope = '';
        }
        $product = $this->conversionProduct($sources, $type);
        if($product !== $targetProduct) throw new DomainException('linkTarget');

        $table = $this->config->db->prefix . 'reqintakeConversion';
        $operation = substr($token, strrpos($token, '.') + 1);
        $this->dbh->beginTransaction();
        try
        {
            $insert = $this->dbh->prepare("INSERT INTO `$table` (operation) VALUES (?) ON DUPLICATE KEY UPDATE operation = operation");
            $insert->execute([$operation]);
            $read = $this->dbh->prepare("SELECT target FROM `$table` WHERE operation = ? FOR UPDATE");
            $read->execute([$operation]);
            $id = (int)$read->fetchColumn();
            $read->closeCursor();
            if($id)
            {
                if(!$this->targetForProduct($type, $id, $product)) throw new DomainException('linkTarget');
                unset($_POST["fileList"]);
                $this->dbh->commit();
                return $id;
            }

            $this->conversionProduct($sources, $type, true);

            $id = $create();
            if(!$id || dao::isError())
            {
                $this->dbh->rollBack();
                return false;
            }

            $this->linkTargets($sources, $id, $scope, $type);
            $update = $this->dbh->prepare("UPDATE `$table` SET target = ? WHERE operation = ?");
            $update->execute([$id, $operation]);
            $this->dbh->commit();
            return $id;
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function linkTargets(array $sources, int $targetID, string $scope, string $type): void
    {
        if(!$sources || count($sources) > 50) throw new DomainException('batchSelection');
        if(!in_array($type, $this->visibleTargetTypes(), true)) throw new DomainException('handler');

        $product = null;
        foreach($sources as $feedbackID => $version)
        {
            $feedback = $this->findFeedback($feedbackID);
            if(!$feedback || !$this->canHandle($feedback)) throw new DomainException('handler');
            $product ??= (int)$feedback->product;
            if($product !== (int)$feedback->product) throw new DomainException('batchProduct');
        }

        $scope = trim($scope);
        if(mb_strlen($scope) > 500) throw new InvalidArgumentException('linkScope');
        if(!$this->targetForProduct($type, $targetID, $product)) throw new DomainException('linkTarget');

        ksort($sources, SORT_NUMERIC);
        $prefix = $this->config->db->prefix;
        $ownsTransaction = !$this->dbh->inTransaction();
        if($ownsTransaction) $this->dbh->beginTransaction();
        try
        {
            foreach($sources as $feedbackID => $version)
            {
                $lock = $this->dbh->prepare("SELECT id FROM `{$prefix}reqintakeFeedback` WHERE id = ? FOR UPDATE");
                $lock->execute([$feedbackID]);
                if(!$lock->fetchColumn()) throw new DomainException('staleFeedback');
                $lock->closeCursor();

                $query = $this->dbh->prepare("SELECT scope FROM `{$prefix}reqintakeLink` WHERE feedback = ? AND targetType = ? AND target = ?");
                $query->execute([$feedbackID, $type, $targetID]);
                $existing = $query->fetchColumn();
                if($existing !== false)
                {
                    if($existing !== $scope) throw new DomainException('linkScope');
                    continue;
                }

                $now = helper::now();
                $query = $this->dbh->prepare("UPDATE `{$prefix}reqintakeFeedback` SET status = 'tracking', version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status IN ('pending','tracking')");
                $query->execute([$now, $feedbackID, $version]);
                if($query->rowCount() !== 1) throw new DomainException('staleFeedback');

                $query = $this->dbh->prepare("INSERT INTO `{$prefix}reqintakeLink` (feedback,targetType,target,scope,createdBy,createdDate) VALUES (?,?,?,?,?,?)");
                $query->execute([$feedbackID, $type, $targetID, $scope, $this->app->user->account, $now]);
            }
            if($ownsTransaction) $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($ownsTransaction && $this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function historyForRecent(array $recent): array
    {
        if(!$this->canAccess('index')) throw new DomainException('product');
        if(!$recent) return array();

        $ids = array_map(static fn($item) => (int)$item->id, $recent);
        $query = $this->dao->select('h.feedback,h.actor,h.action,h.reason,h.createdDate')
            ->from($this->config->db->prefix . 'reqintakeHistory')->alias('h')
            ->innerJoin($this->config->db->prefix . 'reqintakeFeedback')->alias('f')->on('h.feedback = f.id')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('p.deleted')->eq('0')->andWhere('h.feedback')->in($ids);
        if(empty($this->app->user->admin)) $query->andWhere('f.product')->in($this->visibleProducts() ?: array(0));
        $history = $query->orderBy('h.feedback,h.version_desc')->fetchAll();

        $grouped = array();
        foreach($history as $entry) $grouped[$entry->feedback][] = $entry;
        return $grouped;
    }

    public function transition(int $id, int $version, string $action, string $reason): void
    {
        if(!$this->canAccess('index')) throw new DomainException('product');

        $table = $this->config->db->prefix . 'reqintakeFeedback';
        $feedback = $this->dao->select('product,status,assignedTo,assignmentPending')->from($table)->where('id')->eq($id)->fetch();
        if(!$feedback || !$this->canReadProduct((int)$feedback->product)) throw new DomainException('product');

        if(empty($this->app->user->admin) && ($feedback->assignedTo !== $this->app->user->account || $feedback->assignmentPending)) throw new DomainException('handler');

        $next = match($action)
        {
            'start'  => $feedback->status === 'pending' ? 'tracking' : null,
            'close'  => in_array($feedback->status, array('pending', 'tracking'), true) ? 'closed' : null,
            'reopen' => $feedback->status === 'closed' ? 'tracking' : null,
            default  => null,
        };
        if($next === null) throw new DomainException('staleFeedback');

        $reason = trim($reason);
        if(($action !== 'start' && $reason === '') || mb_strlen($reason) > 500) throw new DomainException('transitionReason');

        $history = $this->config->db->prefix . 'reqintakeHistory';
        $now = helper::now();
        $this->dbh->beginTransaction();
        try
        {
            $query = $this->dbh->prepare("UPDATE `$table` SET status = ?, version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status = ?");
            $query->execute([$next, $now, $id, $version, $feedback->status]);
            if($query->rowCount() !== 1) throw new DomainException('staleFeedback');

            $query = $this->dbh->prepare("INSERT INTO `$history` (feedback, version, actor, action, reason, createdDate) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([$id, $version + 1, $this->app->user->account, $action, $reason, $now]);
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function canReadProduct(int $product): bool
    {
        if(!$this->loadModel('product')->checkPriv($product)) return false;

        return (bool)$this->dao->select('id')->from(TABLE_PRODUCT)
            ->where('id')->eq($product)->andWhere('deleted')->eq('0')->fetch();
    }

    /**
     * Re-read the product's configured owner when a new submission is saved.
     */
    public function resolveAssignee(int $product): array
    {
        if(!$this->canReadProduct($product)) throw new DomainException('product');

        $account = $this->configuredOwner($product);
        if($account !== '' && $this->canAssign($product, $account)) return [$account, 0];

        return [$this->app->user->account, 1];
    }

    public function configuredOwner(int $product): string
    {
        if(!$this->canAccess('index') || !$this->canReadProduct($product)) return '';
        $owner = $this->dao->select('account')->from($this->config->db->prefix . 'reqintakeOwner')
            ->where('product')->eq($product)->fetch();
        return $owner->account ?? '';
    }

    public function setOwner(int $product, string $account, string $productMethod = ''): void
    {
        $canMaintain = empty($productMethod)
            ? !empty($this->app->user->admin)
            : $this->canAccess('index') && in_array($productMethod, array('create', 'edit'), true)
                && common::hasPriv('product', $productMethod);
        if(!$canMaintain || !$this->canReadProduct($product)) throw new DomainException('product');

        $table = $this->config->db->prefix . 'reqintakeOwner';
        if($account === '')
        {
            $this->dao->delete()->from($table)->where('product')->eq($product)->exec();
            return;
        }

        if(mb_strlen($account) > 30 || !$this->canAssign($product, $account)) throw new DomainException('owner');

        $query = $this->dbh->prepare("INSERT INTO `$table` (product, account) VALUES (?, ?) ON DUPLICATE KEY UPDATE account = ?");
        $query->execute([$product, $account, $account]);
    }

    private function canAssign(int $product, string $account): bool
    {
        $user = $this->dao->select('account')->from(TABLE_USER)
            ->where('account')->eq($account)->andWhere('deleted')->eq('0')->fetch();
        if(!$user || $user->account !== $account) return false;

        if(strpos($this->app->company->admins, ",{$user->account},") !== false) return true;

        $users = $this->loadModel('user');
        $authorization = $users->authorize($user->account);
        if(empty($authorization['rights']['reqintake']['index']) || empty($authorization['rights']['reqintake']['detail'])) return false;

        /* ZenTao stores only restricted products in the computed user view. */
        $isOpen = $this->dao->select('id')->from(TABLE_PRODUCT)
            ->where('id')->eq($product)->andWhere('deleted')->eq('0')->andWhere('acl')->eq('open')->fetch();
        if($isOpen) return true;

        $view = $users->computeUserView($user->account, true);
        return in_array((string)$product, explode(',', (string)($view->products ?? '')), true);
    }

    public function receive(int $product, string $operation, string $title, string $description, string $customer = '', string $channel = ''): int
    {
        $account = $this->app->user->account ?? '';
        if(!$this->canAccess('index') || !$this->canReadProduct($product)) throw new DomainException('product');

        $title = trim($title);
        if(!preg_match('/\A[a-f0-9]{32}\z/', $operation)) throw new InvalidArgumentException('operation');
        if($title === '' || mb_strlen($title) > 255) throw new InvalidArgumentException('title');
        if(trim($description) === '' || strlen($description) > 16777215) throw new InvalidArgumentException('description');
        if(mb_strlen($customer) > 255 || mb_strlen($channel) > 64) throw new InvalidArgumentException('source');

        [$assignee, $pending] = $this->resolveAssignee($product);
        $table = $this->config->db->prefix . 'reqintakeFeedback';
        $now = helper::now();

        /* The unique submission key handles simultaneous retries in the database. */
        $query = $this->dbh->prepare("INSERT INTO `$table`
            (operation, product, title, description, customer, channel, openedBy, assignedTo, assignmentPending, openedDate, updatedDate)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE id = id");
        $query->execute([$operation, $product, $title, $description, $customer, $channel, $account, $assignee, $pending, $now, $now]);

        $saved = $this->dao->select('*')->from($table)
            ->where('openedBy')->eq($account)->andWhere('operation')->eq($operation)->fetch();
        if(!$saved || (int)$saved->product !== $product || $saved->title !== $title
            || $saved->description !== $description || $saved->customer !== $customer || $saved->channel !== $channel)
        {
            throw new DomainException('submissionConflict');
        }

        return (int)$saved->id;
    }
}
