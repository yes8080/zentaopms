<?php
class feedbackModel extends model
{
    public function getFeedbackPairs($type)
    {
        return $this->loadModel('user')->getPairs('nodeleted');
    }

    public function getByList($idList): array
    {
        if(empty($idList)) return array();
        return $this->visibleQuery()->andWhere('id')->in($idList)->fetchAll('id');
    }

    public function getByID(int $id): object|false
    {
        return $this->visibleQuery()->andWhere('id')->eq($id)->fetch() ?: false;
    }

    public function getGrantProducts(): array
    {
        $products = $this->loadModel('product')->getPairs();
        if($this->app->user->admin || !$products) return $products;

        $accounts = $this->dao->select('product,account')->from(TABLE_FEEDBACKVIEW)
            ->where('product')->in(array_keys($products))->fetchGroup('product', 'account');
        $user = $this->app->user->account;
        return array_filter($products, fn($id) => $this->product->checkPriv((int)$id)
            && (!isset($accounts[$id]) || isset($accounts[$id][$user])), ARRAY_FILTER_USE_KEY);
    }

    public function getModuleOptions(array $products): array
    {
        if(!$products) return array();
        $rows = $this->dao->select('id,root,name')->from(TABLE_MODULE)->where('root')->in($products)
            ->andWhere('type')->in('story,feedback')->andWhere('deleted')->eq(0)->orderBy('grade_asc,order_asc,id_asc')->fetchAll();
        $options = array();
        foreach($rows as $row) $options[$row->root][$row->id] = $row->name;
        return $options;
    }

    public function getList($condition = 'all', int $product = 0, string $keyword = '', string $order = 'id_desc', ?object $pager = null): array
    {
        $query = $this->visibleQuery()
            ->beginIF($product)->andWhere('product')->eq($product)->fi()
            ->beginIF($keyword !== '')->andWhere('title')->like("%$keyword%")->fi();

        if($condition === 'unclosed') $query->andWhere('status')->ne('closed');
        elseif($condition === 'mine') $query->andWhere('openedBy')->eq($this->app->user->account);
        elseif($condition === 'assigntome') $query->andWhere('assignedTo')->eq($this->app->user->account);
        elseif(isset($this->lang->feedback->statusList[$condition])) $query->andWhere('status')->eq($condition);

        if(!preg_match('/^(id|title|pri|status|openedDate|editedDate)_(asc|desc)$/iD', $order)) $order = 'id_desc';
        return $query->orderBy($order)->page($pager)->fetchAll();
    }

    private function visibleQuery(): object
    {
        $admin = $this->app->user->admin;
        $products = $admin ? array() : array_keys($this->getGrantProducts());
        $query = $this->dao->select('*')->from(TABLE_FEEDBACK)->where('deleted')->eq(0);
        if($admin) return $query;

        $account = $this->app->user->account;
        return $query->andWhere('product')->in($products ?: array(0))
            ->andWhere('public', true)->eq(1)->orWhere('openedBy')->eq($account)->orWhere('assignedTo')->eq($account)->markRight(1);
    }

    public function saveFeedback(array $input, ?object $old = null): int
    {
        $lang = $this->lang->feedback;
        $title = trim($input['title'] ?? '');
        $product = (int)($input['product'] ?? 0);
        $module = (int)($input['module'] ?? 0);
        $type = ($input['type'] ?? '') ?: 'advice';
        $priority = (int)(($input['pri'] ?? '') ?: 2);
        if($title === '' || mb_strlen($title) > 255 || !array_key_exists($product, $this->getGrantProducts())
            || !isset($lang->typeList[$type]) || $priority < 1 || $priority > 4)
        {
            throw new InvalidArgumentException($lang->invalidFields);
        }

        if($module)
        {
            $validModule = $this->dao->select('id')->from(TABLE_MODULE)->where('id')->eq($module)
                ->andWhere('root')->eq($product)->andWhere('type')->in('story,feedback')->andWhere('deleted')->eq(0)->fetch();
            if(!$validModule) throw new InvalidArgumentException($lang->invalidFields);
        }

        $email = trim($input['notifyEmail'] ?? '');
        if((!empty($input['notify']) || $email !== '') && (strlen($email) > 100 || !filter_var($email, FILTER_VALIDATE_EMAIL)))
        {
            throw new InvalidArgumentException($lang->invalidFields);
        }

        $data = array(
            'title' => $title, 'product' => $product, 'module' => $module, 'type' => $type, 'pri' => $priority,
            'desc' => fixer::stripDataTags($input['desc'] ?? ''), 'public' => (int)!empty($input['public']),
            'notifyEmail' => $email, 'notify' => (int)!empty($input['notify']), 'feedbackBy' => mb_substr(trim($input['feedbackBy'] ?? ''), 0, 100),
        );

        if($old)
        {
            if($old->status === 'clarify') $data['status'] = 'noreview';
            $this->record($old, $data, 'edited');
            return (int)$old->id;
        }

        $data += array('status' => 'noreview', 'openedBy' => $this->app->user->account, 'openedDate' => helper::now());
        $ownsTransaction = !$this->dbh->inTransaction();
        if($ownsTransaction) $this->dbh->beginTransaction();
        try
        {
            $this->dao->insert(TABLE_FEEDBACK)->data($data)->exec();
            if(dao::isError()) throw new RuntimeException($lang->saveFailed);
            $id = (int)$this->dao->lastInsertID();
            $this->logAction($id, 'opened');
            if($ownsTransaction) $this->dbh->commit();
            return $id;
        }
        catch(Throwable $error)
        {
            if($ownsTransaction) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function canOperate(object $feedback, string $operation): bool
    {
        $user = $this->app->user;
        $owner = $feedback->openedBy === $user->account;
        $handler = $user->admin || $feedback->assignedTo === $user->account;
        $status = $feedback->status;

        return match($operation) {
            'edit', 'delete' => ($owner || $handler) && ($status !== 'closed' || $operation === 'delete'),
            'assignTo' => ($owner || $handler) && $status !== 'closed',
            'review' => $handler && $status === 'noreview',
            'convert' => $handler && !$feedback->result && in_array($status, array('wait', 'commenting', 'asked', 'replied'), true),
            'reply' => $handler && in_array($status, array('wait', 'commenting', 'asked'), true),
            'ask' => $owner && $status === 'replied',
            'close' => ($owner || $handler) && $status !== 'closed',
            'activate' => ($owner || $handler) && $status === 'closed',
            'comment' => $status !== 'closed',
            default => false,
        };
    }

    public function operate(object $feedback, string $operation, string $value, string $comment, int $repeatID = 0): void
    {
        $lang = $this->lang->feedback;
        if(!$this->canOperate($feedback, $operation)) throw new InvalidArgumentException($lang->invalidAction);

        $account = $this->app->user->account;
        $now = helper::now();
        $extra = '';
        $data = array();
        switch($operation)
        {
            case 'assignTo':
                $user = $this->dao->select('account')->from(TABLE_USER)->where('account')->eq($value)->andWhere('deleted')->eq(0)->fetch();
                if($value !== '' && (!$user || !isset($this->getEligibleAssignees((int)$feedback->product)[$value])))
                    throw new InvalidArgumentException($lang->invalidFields);
                $data = array('assignedTo' => $value, 'prevAssignedTo' => $feedback->assignedTo, 'assignedDate' => $now);
                $action = 'assigned';
                $extra = $value;
                break;
            case 'review':
                if(!in_array($value, array('pass', 'clarify'), true)) throw new InvalidArgumentException($lang->invalidFields);
                $data = array('status' => $value === 'pass' ? 'wait' : 'clarify', 'reviewedBy' => $account, 'reviewedDate' => $now);
                $action = 'reviewed';
                $extra = $value;
                break;
            case 'close':
                $value = $value ?: 'commented';
                if(!isset($lang->closedReasonList[$value])) throw new InvalidArgumentException($lang->invalidFields);
                if($value === 'repeat')
                {
                    $repeat = $repeatID && $repeatID != $feedback->id ? $this->getByID($repeatID) : false;
                    if(!$repeat || $repeat->product != $feedback->product) throw new InvalidArgumentException($lang->invalidRepeat);
                }
                $data = array(
                    'status' => 'closed', 'prevStatus' => $feedback->status, 'closedBy' => $account, 'closedDate' => $now,
                    'closedReason' => $value, 'repeatFeedback' => $value === 'repeat' ? $repeatID : 0,
                );
                $action = 'closed';
                $extra = $value;
                break;
            case 'activate':
                $status = $feedback->prevStatus;
                if($status === 'closed' || !isset($lang->statusList[$status])) $status = 'wait';
                $data = array('status' => $status, 'activatedBy' => $account, 'activatedDate' => $now, 'closedBy' => '', 'closedDate' => null, 'closedReason' => '', 'repeatFeedback' => 0);
                $action = 'activated';
                break;
            case 'delete':
                $data = array('deleted' => 1);
                $action = 'deleted';
                break;
            case 'reply':
            case 'ask':
            case 'comment':
                if(trim(strip_tags($comment)) === '') throw new InvalidArgumentException($lang->commentRequired);
                if($operation === 'reply') $data = array('status' => 'replied', 'processedBy' => $account, 'processedDate' => $now);
                if($operation === 'ask') $data = array('status' => 'asked');
                $action = array('reply' => 'replied', 'ask' => 'asked', 'comment' => 'commented')[$operation];
                break;
        }
        $this->record($feedback, $data, $action, $comment, $extra);
        if(!$this->dbh->inTransaction() && in_array($operation, array('assignTo', 'review', 'reply', 'close', 'activate'), true))
            $this->notifyFeedback($feedback, $data['status'] ?? $feedback->status);
    }

    public function getEligibleAssignees(int $product): array
    {
        $accounts = $this->loadModel('user')->getPairs('nodeleted');
        $allowed = $this->dao->select('account')->from(TABLE_USERVIEW)->where('FIND_IN_SET(' . $product . ', products)')->fetchPairs('account', 'account');
        $granted = $this->dao->select('account')->from(TABLE_FEEDBACKVIEW)->where('product')->eq($product)->fetchPairs('account', 'account');
        if($granted) $allowed = array_intersect_key($allowed, $granted);
        foreach(explode(',', trim($this->app->company->admins ?? '', ',')) as $admin) $allowed[$admin] = $admin;
        return array_intersect_key($accounts, $allowed);
    }

    public function getConversionTypes(object $feedback): array
    {
        if(!$this->canOperate($feedback, 'convert')) return array();
        return array_filter($this->lang->feedback->conversionTypes, fn($module) => $module === 'ticket' ? common::hasPriv('feedback', 'ticket') : common::hasPriv($module, 'create'), ARRAY_FILTER_USE_KEY);
    }

    public function convert(object $feedback, string $type): void
    {
        if(!isset($this->getConversionTypes($feedback)[$type])) throw new InvalidArgumentException($this->lang->feedback->invalidAction);

        $this->record($feedback, function() use ($feedback, $type)
        {
            $user = $this->app->user->account;
            $now = helper::now();
            $desc = nl2br(htmlspecialchars(strip_tags($feedback->desc ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
            $title = html_entity_decode($feedback->title, ENT_QUOTES, 'UTF-8');
            $id = match($type) {
                'bug' => $this->loadModel('bug')->create((object)array(
                    'product' => $feedback->product, 'title' => $title, 'steps' => $desc, 'type' => 'codeerror',
                    'openedBuild' => 'trunk', 'openedBy' => $user, 'openedDate' => $now, 'status' => 'active',
                    'pri' => $feedback->pri, 'severity' => 3,
                )),
                'story' => $this->loadModel('story')->create((object)array(
                    'product' => $feedback->product, 'title' => $title, 'spec' => $desc, 'verify' => '', 'type' => 'story',
                    'openedBy' => $user, 'openedDate' => $now, 'status' => 'draft', 'stage' => 'wait', 'version' => 1,
                    'pri' => $feedback->pri, 'estimate' => 0,
                ), 0, 0, "fromType=feedback,fromID={$feedback->id}"),
                'ticket' => $this->createTicket($feedback, $title, $desc, $user, $now),
                'todo' => $this->loadModel('todo')->create((object)array(
                    'name' => $title, 'desc' => $desc, 'type' => 'custom', 'account' => $user, 'assignedTo' => $user,
                    'date' => date('Y-m-d'), 'begin' => 0, 'end' => 0, 'status' => 'wait', 'pri' => $feedback->pri,
                )),
            };
            if(!$id || dao::isError()) throw new RuntimeException($this->lang->feedback->saveFailed);

            if($type === 'todo') $this->loadModel('action')->create('todo', $id, 'opened');
            return array('solution' => $type, 'result' => $id, 'status' => 'replied', 'processedBy' => $user, 'processedDate' => $now);
        }, 'converted', '', $type);
        $this->notifyFeedback($feedback, 'replied');
    }

    public function attachFile(object $feedback): void
    {
        $model = $this->loadModel('file');
        $upload = $model->getUpload();
        if(count($upload) !== 1 || !isset($upload[0]['extension'])) throw new InvalidArgumentException($this->lang->feedback->uploadError);
        $file = $upload[0];
        $file['pathname'] = date('Ym/') . bin2hex(random_bytes(16)) . '.' . $file['extension'];
        $path = $model->savePath . $model->getSaveName($file['pathname']);
        try
        {
            $this->record($feedback, function() use ($model, $file, $feedback)
            {
                $saved = $model->saveAFile($file, 'feedback', (int)$feedback->id);
                if(!$saved || !$saved->id || dao::isError()) throw new RuntimeException($this->lang->feedback->uploadError);
                return array();
            }, 'addedfile', '', $file['title']);
        }
        catch(Throwable $error)
        {
            if(is_file($path)) unlink($path);
            throw $error;
        }
    }

    private function createTicket(object $feedback, string $title, string $description, string $account, string $date): int
    {
        $this->dao->insert(TABLE_TICKET)->data(array(
            'product' => $feedback->product, 'module' => $feedback->module, 'title' => $title,
            'desc' => $description, 'feedback' => $feedback->id, 'type' => 'issue', 'pri' => $feedback->pri,
            'status' => 'wait', 'openedBy' => $account, 'openedDate' => $date,
            'assignedTo' => $feedback->assignedTo, 'assignedDate' => $feedback->assignedTo ? $date : null,
        ))->exec();
        if(dao::isError()) throw new RuntimeException($this->lang->feedback->saveFailed);
        return (int)$this->dao->lastInsertID();
    }

    public function getTicket(object $feedback): object|false
    {
        if($feedback->solution !== 'ticket' || !$feedback->result) return false;
        return $this->dao->select('*')->from(TABLE_TICKET)->where('id')->eq($feedback->result)
            ->andWhere('feedback')->eq($feedback->id)->andWhere('deleted')->eq(0)->fetch() ?: false;
    }

    public function changeTicket(object $feedback, object $ticket, string $status): void
    {
        $next = array('wait' => 'doing', 'doing' => 'done', 'done' => 'closed');
        if(($next[$ticket->status] ?? '') !== $status) throw new InvalidArgumentException($this->lang->feedback->invalidAction);
        $account = $this->app->user->account;
        $date = helper::now();
        $fields = array('doing' => 'started', 'done' => 'finished', 'closed' => 'closed');
        $field = $fields[$status];
        $updated = $this->dao->update(TABLE_TICKET)->data(array(
            'status' => $status, $field . 'By' => $account, $field . 'Date' => $date, 'editedBy' => $account, 'editedDate' => $date,
        ))->where('id')->eq($ticket->id)->andWhere('status')->eq($ticket->status)->andWhere('deleted')->eq(0)->exec();
        if(!$updated || dao::isError()) throw new RuntimeException($this->lang->feedback->saveFailed);
    }

    public function notifyFeedback(object $feedback, string $status): void
    {
        if(!$feedback->notify || !filter_var($feedback->notifyEmail, FILTER_VALIDATE_EMAIL)) return;

        try
        {
            $mail = $this->loadModel('mail');
            if(empty($this->config->mail->turnon)) return;
            $text = sprintf($this->lang->feedback->noticeBody, $feedback->id, zget($this->lang->feedback->statusList, $status, $status));
            $recipient = (object)array('email' => $feedback->notifyEmail, 'realname' => '');
            $mail->send('feedback-contact', $this->lang->feedback->noticeSubject, htmlspecialchars($text, ENT_QUOTES, 'UTF-8'), '', true, array('feedback-contact' => $recipient), true, false);
        }
        catch(Throwable $error)
        {
            $this->app->saveError(E_USER_WARNING, 'Feedback mail delivery failed for #' . (int)$feedback->id, __FILE__, __LINE__);
        }
    }

    public function batchOperate(array $feedbacks, string $operation, string|array $value): void
    {
        if(!$feedbacks || !in_array($operation, array('review', 'assignTo', 'close', 'edit'), true))
            throw new InvalidArgumentException($this->lang->feedback->invalidAction);
        ksort($feedbacks);
        $this->dbh->beginTransaction();
        try
        {
            foreach($feedbacks as $feedback)
            {
                if($operation === 'edit')
                {
                    if(!$value || !$this->canOperate($feedback, 'edit')) throw new InvalidArgumentException($this->lang->feedback->invalidAction);
                    $this->saveFeedback($value + (array)$feedback, $feedback);
                }
                else
                {
                    $this->operate($feedback, $operation, $value, '');
                }
            }
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            $this->dbh->rollBack();
            throw $error;
        }
        if($operation === 'edit') return;
        foreach($feedbacks as $feedback)
        {
            $current = $this->getByID((int)$feedback->id);
            if($current) $this->notifyFeedback($current, $current->status);
        }
    }

    public function importRows(array $rows): void
    {
        $this->dbh->beginTransaction();
        try
        {
            foreach($rows as $line => $row)
            {
                try
                {
                    $this->saveFeedback($row);
                }
                catch(InvalidArgumentException|RuntimeException $error)
                {
                    throw new InvalidArgumentException(sprintf($this->lang->feedback->importRowError, $line) . ' ' . $error->getMessage(), 0, $error);
                }
            }
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            $this->dbh->rollBack();
            throw $error;
        }
    }

    private function record(object $feedback, array|Closure $data, string $action, string $comment = '', string $extra = ''): void
    {
        $ownsTransaction = !$this->dbh->inTransaction();
        if($ownsTransaction) $this->dbh->beginTransaction();
        try
        {
            $locked = $this->dbh->query('SELECT id FROM ' . TABLE_FEEDBACK . ' WHERE id = ' . (int)$feedback->id . ' FOR UPDATE')->fetch();
            $current = $locked ? $this->getByID((int)$feedback->id) : false;
            if(!$current || $current != $feedback) throw new RuntimeException($this->lang->feedback->saveFailed);

            if($data instanceof Closure) $data = $data();
            $data += array('editedBy' => $this->app->user->account, 'editedDate' => helper::now());
            $this->dao->update(TABLE_FEEDBACK)->data($data)->where('id')->eq($feedback->id)->exec();
            if(dao::isError()) throw new RuntimeException($this->lang->feedback->saveFailed);
            $this->logAction((int)$feedback->id, $action, $comment, $extra);
            if($ownsTransaction) $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($ownsTransaction) $this->dbh->rollBack();
            throw $error;
        }
    }

    private function logAction(int $id, string $action, string $comment = '', string $extra = ''): void
    {
        if(!$this->loadModel('action')->create('feedback', $id, $action, $comment, $extra) || dao::isError())
            throw new RuntimeException($this->lang->feedback->saveFailed);
    }
}
