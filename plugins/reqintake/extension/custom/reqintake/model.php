<?php
class reqintakeModel extends model
{
    public function recent(string $scope = 'all'): array
    {
        if(empty($this->app->user->admin)) throw new DomainException('product');

        $query = $this->dao->select('f.id,f.title,f.assignedTo,f.assignmentPending,f.status,f.version,p.name AS productName')
            ->from($this->config->db->prefix . 'reqintakeFeedback')->alias('f')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('p.deleted')->eq('0');
        $account = $this->app->user->account;
        if($scope === 'mine') $query->andWhere('f.openedBy')->eq($account);
        if($scope === 'assigned') $query->andWhere('f.assignedTo')->eq($account)->andWhere('f.status')->ne('closed');
        return $query->orderBy('f.id_desc')->limit(50)->fetchAll();
    }

    public function findFeedback(int $id): object|false
    {
        if(empty($this->app->user->admin) || $id < 1) return false;

        $feedback = $this->dao->select('f.id,f.product,f.title,f.description,f.customer,f.channel,f.openedBy,f.assignedTo,f.status,f.assignmentPending,p.name AS productName')
            ->from($this->config->db->prefix . 'reqintakeFeedback')->alias('f')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('f.id')->eq($id)->andWhere('p.deleted')->eq('0')->fetch();
        return $feedback && $this->canReadProduct((int)$feedback->product) ? $feedback : false;
    }

    public function historyForRecent(array $recent): array
    {
        if(empty($this->app->user->admin)) throw new DomainException('product');
        if(!$recent) return array();

        $ids = array_map(static fn($item) => (int)$item->id, $recent);
        $history = $this->dao->select('h.feedback,h.actor,h.action,h.reason,h.createdDate')
            ->from($this->config->db->prefix . 'reqintakeHistory')->alias('h')
            ->innerJoin($this->config->db->prefix . 'reqintakeFeedback')->alias('f')->on('h.feedback = f.id')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('p.deleted')->eq('0')->andWhere('h.feedback')->in($ids)
            ->orderBy('h.feedback,h.version_desc')->fetchAll();

        $grouped = array();
        foreach($history as $entry) $grouped[$entry->feedback][] = $entry;
        return $grouped;
    }

    public function transition(int $id, int $version, string $action, string $reason): void
    {
        if(empty($this->app->user->admin)) throw new DomainException('product');

        $table = $this->config->db->prefix . 'reqintakeFeedback';
        $feedback = $this->dao->select('product,status')->from($table)->where('id')->eq($id)->fetch();
        if(!$feedback || !$this->canReadProduct((int)$feedback->product)) throw new DomainException('product');

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

        $owner = $this->dao->select('account')->from($this->config->db->prefix . 'reqintakeOwner')
            ->where('product')->eq($product)->fetch();
        if($owner && $this->canAssign($product, $owner->account)) return [$owner->account, 0];

        return [$this->app->user->account, 1];
    }

    public function setOwner(int $product, string $account): void
    {
        if(empty($this->app->user->admin) || !$this->canReadProduct($product)) throw new DomainException('product');

        $table = $this->config->db->prefix . 'reqintakeOwner';
        if($account === '')
        {
            $this->dao->delete()->from($table)->where('product')->eq($product)->exec();
            return;
        }

        if(!$this->canAssign($product, $account)) throw new DomainException('owner');

        $query = $this->dbh->prepare("INSERT INTO `$table` (product, account) VALUES (?, ?) ON DUPLICATE KEY UPDATE account = ?");
        $query->execute([$product, $account, $account]);
    }

    private function canAssign(int $product, string $account): bool
    {
        $user = $this->dao->select('account')->from(TABLE_USER)
            ->where('account')->eq($account)->andWhere('deleted')->eq('0')->fetch();
        if(!$user) return false;

        if(strpos($this->app->company->admins, ",{$user->account},") !== false) return true;

        $view = $this->loadModel('user')->computeUserView($user->account, true);
        return in_array((string)$product, explode(',', (string)($view->products ?? '')), true);
    }

    public function receive(int $product, string $operation, string $title, string $description, string $customer = '', string $channel = ''): int
    {
        $account = $this->app->user->account ?? '';
        if($account === '' || !$this->canReadProduct($product)) throw new DomainException('product');

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
