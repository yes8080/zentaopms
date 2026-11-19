<?php
class reqintake extends control
{
    public function index(string $scope = 'all', int $filterProduct = 0, int $previewProduct = 0, int $beforeID = 0, string $sort = 'id', string $beforeUpdate = '')
    {
        if(!$this->loadModel('reqintake')->canAccess('index'))
        {
            http_response_code(403);
            return;
        }

        if($previewProduct > 0 && $_SERVER['REQUEST_METHOD'] === 'GET')
        {
            try
            {
                [$account, $pending] = $this->reqintake->resolveAssignee($previewProduct);
                $owner = $this->loadModel('user')->getById($account);
                header('Content-Type: application/json; charset=utf-8');
                header('Cache-Control: no-store');
                echo json_encode(array('name' => $owner->realname ?? $account, 'pending' => (bool)$pending) + $this->reqintake->productScopeOptions($previewProduct));
            }
            catch(DomainException $error)
            {
                http_response_code(404);
            }
            return;
        }

        $key = $this->session->reqintakeFormKey;
        if(!$key)
        {
            $key = bin2hex(random_bytes(32));
            $this->session->set('reqintakeFormKey', $key);
        }
        $operation = bin2hex(random_bytes(16));
        $fields = array('product' => '', 'title' => '', 'description' => '', 'customer' => '', 'channel' => '');

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            foreach($fields as $name => $default) $fields[$name] = $this->formValue($name);
            $operation = $this->formValue('operation');
            $token = $this->formValue('token');
            if(!preg_match('/\A[a-f0-9]{32}\z/', $operation) || !hash_equals(hash_hmac('sha256', $operation, $key), $token))
            {
                http_response_code(403);
                return;
            }

            $intent = $this->formValue('intent');
            try
            {
                $model = $this->loadModel('reqintake');
                if($intent === 'owner')
                {
                    $model->setOwner((int)$fields['product'], trim($this->formValue('owner')));
                    $this->view->ownerSaved = true;
                }
                elseif(in_array($intent, array('batchLink', 'batchCreate'), true))
                {
                    $type = $this->formValue('storyType');
                    if(!in_array($type, array('story', 'requirement', 'epic'), true)) throw new DomainException('linkTarget');
                    $sources = array();
                    $submitted = $this->post->sources;
                    if(!is_array($submitted) || count($submitted) > 50) throw new DomainException('batchSelection');
                    foreach($submitted as $source)
                    {
                        if(!is_string($source) || !preg_match('/\A([1-9][0-9]{0,9}):([1-9][0-9]{0,9})\z/', $source, $parts)) throw new DomainException('batchSelection');
                        $sources[(int)$parts[1]] = (int)$parts[2];
                    }
                    if($intent === 'batchCreate')
                    {
                        $url = $model->prepareBatchConversion($operation, $sources, $type, trim($this->formValue('linkScope')));
                        header('Location: ' . $url, true, 303);
                        return;
                    }
                    $model->linkTargets($sources, (int)$this->formValue('storyID'), $this->formValue('linkScope'), $type);
                    $this->view->batchCount = count($sources);
                }
                elseif($intent === 'transition')
                {
                    $model->transition((int)$this->formValue('feedbackID'), (int)$this->formValue('version'), $this->formValue('action'), $this->formValue('reason'));
                }
                else
                {
                    $id = $model->receive((int)$fields['product'], $operation, $fields['title'], $fields['description'], $fields['customer'], $fields['channel'], $this->attributeInputs(), $this->formValue('bodyFormat') === 'rich');
                    $this->view->savedID = $id;
                }
                $operation = bin2hex(random_bytes(16));
                $fields = array_fill_keys(array_keys($fields), '');
            }
            catch(InvalidArgumentException | DomainException $error)
            {
                $this->view->formError = $this->lang->reqintake->errors[$error->getMessage()] ?? $this->lang->reqintake->invalid;
            }
        }

        $this->view->title = $this->lang->reqintake->common;
        $this->view->operation = $operation;
        $this->view->token = hash_hmac('sha256', $operation, $key);
        $inputAttributes = array();
        if(isset($this->view->formError))
        {
            try { $inputAttributes = $this->attributeInputs(); }
            catch(InvalidArgumentException $error) {}
        }
        $this->view->fields = $fields + $inputAttributes + $this->reqintake->attributeDefaults();
        $this->view->attributeOptions = $this->reqintake->attributeOptions();
        $this->view->mailtoOptions = $this->reqintake->mailtoOptions();
        $this->view->inputRich = isset($this->view->formError) && $this->formValue('bodyFormat') === 'rich';
        if($this->view->inputRich)
        {
            foreach(array('description', 'acceptance') as $field)
                {
                try { $this->view->fields[$field] = $this->reqintake->cleanRichText($this->view->fields[$field]); }
                catch(InvalidArgumentException $error) { $this->view->fields[$field] = ''; }
            }
        }
        $this->view->products = $this->loadModel('product')->getPairs();
        $model = $this->loadModel('reqintake');
        $this->view->isAdmin = !empty($this->app->user->admin);
        $this->view->currentAccount = $this->app->user->account;
        $this->view->scope = in_array($scope, array_keys($this->lang->reqintake->scopes), true) ? $scope : 'all';
        $this->view->filterProduct = max(0, $filterProduct);
        $this->view->batchTypes = array_intersect($model->visibleTargetTypes(), array('story', 'requirement', 'epic'));
        if(!$model->canAccess('detail')) $this->view->batchTypes = array();
        $this->view->canBatchCreate = (bool)array_filter($this->view->batchTypes, static fn($type) => common::hasPriv($type, 'create'));
        $this->view->beforeID = max(0, $beforeID);
        $this->view->sort = $sort === 'updated' ? 'updated' : 'id';
        $feedback = $model->recent($this->view->scope, $this->view->filterProduct, $this->view->beforeID, $this->view->sort, $beforeUpdate);
        $this->view->feedback = array_slice($feedback, 0, 50);
        $this->view->nextBefore = count($feedback) > 50 ? (int)$feedback[49]->id : 0;
        $this->view->nextUpdate = $this->view->nextBefore && $this->view->sort === 'updated' ? str_replace(array('-', ':', ' '), '', $feedback[49]->updatedDate) : '';
        $this->view->history = $model->historyForRecent($this->view->feedback);
        $this->display();
    }

    public function detail(int $id = 0, int $attachmentID = 0)
    {
        if(!$this->loadModel('reqintake')->canAccess('detail'))
        {
            http_response_code(403);
            return;
        }

        $model = $this->loadModel('reqintake');
        $feedback = $model->findFeedback($id);
        if(!$feedback)
        {
            http_response_code(404);
            return;
        }

        if($attachmentID > 0 && $_SERVER['REQUEST_METHOD'] === 'GET')
        {
            $file = $model->attachment($id, $attachmentID);
            if(!$file)
            {
                http_response_code(404);
                return;
            }
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename*=UTF-8\'\'' . rawurlencode($file->name));
            header('X-Content-Type-Options: nosniff');
            header('Cache-Control: private, no-store');
            echo $file->data;
            return;
        }

        $key = $this->session->reqintakeFormKey;
        if(!$key)
        {
            $key = bin2hex(random_bytes(32));
            $this->session->set('reqintakeFormKey', $key);
        }
        $token = hash_hmac('sha256', "linkStory:$id", $key);
        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            if(!hash_equals($token, $this->formValue('token')))
            {
                http_response_code(403);
                return;
            }
            try
            {
                if($this->formValue('intent') === 'transition')
                {
                    $model->transition($id, (int)$this->formValue('version'), $this->formValue('action'), $this->formValue('reason'));
                }
                elseif($this->formValue('intent') === 'duplicate')
                {
                    $original = (int)$this->formValue('original');
                    if($original < 1) throw new DomainException('duplicateTarget');
                    $model->transition($id, (int)$this->formValue('version'), 'close', $this->formValue('reason'), $original);
                }
                elseif($this->formValue('intent') === 'handling')
                {
                    $model->recordHandling($feedback, (int)$this->formValue('version'), $this->formValue('kind'),
                        $this->formValue('summary'), $this->formValue('details'), $this->formValue('replyChannel'));
                }
                elseif($this->formValue('intent') === 'attachment')
                {
                    $upload = $_FILES['attachment'] ?? null;
                    $model->changeAttachment($feedback, (int)$this->formValue('version'), $upload, (int)$this->formValue('removeAttachment'));
                }
                elseif($this->formValue('intent') === 'taskCreate')
                {
                    $execution = (int)$this->formValue('execution');
                    if(!$model->canHandle($feedback) || $feedback->status === 'closed'
                        || (int)$feedback->version !== (int)$this->formValue('version')
                        || !isset($model->taskExecutions((int)$feedback->product)[$execution])) throw new DomainException('linkTarget');
                    $extra = 'riOperation=' . $model->conversionToken($feedback, 'task');
                    header('Location: ' . helper::createLink('task', 'create', "executionID=$execution&storyID=0&moduleID=0&taskID=0&todoID=0&cardPosition=$extra"), true, 303);
                    return;
                }
                elseif($this->formValue('intent') === 'revise')
                {
                    $fields = array();
                    foreach(array('title', 'description', 'customer', 'channel') as $field) $fields[$field] = $this->formValue($field);
                    $model->revise($feedback, (int)$this->formValue('version'), $fields + $this->attributeInputs(), $this->formValue('bodyFormat') === 'rich');
                }
                elseif(in_array($this->formValue('intent'), array('followup', 'transfer'), true))
                {
                    $assignee = $this->formValue('intent') === 'transfer' ? $this->formValue('assignee') : null;
                    $model->recordFollowup($feedback, (int)$this->formValue('version'), $this->formValue('message'), $assignee);
                }
                else
                {
                    $model->linkTarget($id, (int)$this->formValue('version'), (int)$this->formValue('storyID'), $this->formValue('linkScope'), $this->formValue('storyType') ?: 'story');
                }
                $feedback = $model->findFeedback($id);
            }
            catch(InvalidArgumentException | DomainException $error)
            {
                $this->view->formError = $this->lang->reqintake->errors[$error->getMessage()] ?? $this->lang->reqintake->invalid;
            }
        }

        $this->view->attributes = $model->attributes($id);
        $scope = $model->productScopeOptions((int)$feedback->product);
        $this->view->scopeOptions = $scope;
        $this->view->scopeLabels = array(
            'branch' => $scope['branches'], 'module' => $scope['modules'][$this->view->attributes['branch']] ?? array(),
            'plan' => $scope['plans'][$this->view->attributes['branch']] ?? array()
        );
        $this->view->attributeOptions = $model->attributeOptions();
        $this->view->mailtoOptions = $model->mailtoOptions();
        $this->view->handling = $model->handling($feedback);
        $this->view->followups = $model->followups($feedback);
        $this->view->duplicateOriginal = $model->duplicateOriginal($feedback);
        $this->view->attachments = $model->attachments($id);
        $this->view->richVersions = $model->richTextVersions($id);
        $this->view->original = $feedback;
        $this->view->revisions = $model->revisions($feedback);
        if($this->view->revisions)
        {
            $latest = reset($this->view->revisions);
            $feedback = clone $feedback;
            foreach(array('title', 'description', 'customer', 'channel') as $field) $feedback->$field = $latest->$field;
        }
        $this->view->canTransition = $model->canHandle($feedback);
        $this->view->canRevise = $feedback->status !== 'closed' && $this->view->canTransition;
        $this->view->linkToken = $token;
        $this->view->storyTypes = $model->visibleTargetTypes();
        $this->view->taskExecutions = $this->view->canRevise ? $model->taskExecutions((int)$feedback->product) : array();
        $this->view->conversionLinks = array();
        if($this->view->canRevise)
        {
            foreach(array_intersect($this->view->storyTypes, array('story', 'requirement', 'epic', 'bug')) as $type)
            {
                if(!common::hasPriv($type, 'create')) continue;
                $extra = 'riOperation=' . $model->conversionToken($feedback, $type);
                if($type === 'bug')
                {
                    $this->view->conversionLinks[$type] = helper::createLink('bug', 'create', "productID={$feedback->product}&branch=&extras=$extra");
                    continue;
                }
                $branch = isset($scope['branches'][$this->view->attributes['branch']]) ? (int)$this->view->attributes['branch'] : 0;
                $module = isset($scope['modules'][$branch][$this->view->attributes['module']]) ? (int)$this->view->attributes['module'] : 0;
                $plan = (int)$this->view->attributes['plan'];
                if($plan && !isset($model->planOptions((int)$feedback->product, (string)$branch, true)[$plan])) $plan = 0;
                $this->view->conversionLinks[$type] = helper::createLink($type, 'create', "productID={$feedback->product}&branch=$branch&moduleID=$module&storyID=0&objectID=0&bugID=0&planID=$plan&todoID=0&extra=$extra&storyType=$type");
            }
        }
        $this->view->canLink = $feedback->status !== 'closed' && $model->canHandle($feedback) && $this->view->storyTypes;
        foreach(array('story', 'bug', 'task') as $module) $this->app->loadLang($module);
        $this->view->linkedStories = $model->linkedTargets($feedback);
        $this->view->title = $feedback->title;
        $this->view->item = $feedback;
        $this->display();
    }

    private function attributeInputs(): array
    {
        $attributes = array();
        foreach(array_keys($this->reqintake->attributeDefaults()) as $field)
        {
            if(in_array($field, array('branchModules', 'mailto'), true)) continue;
            if(isset($_POST[$field])) $attributes[$field] = $this->formValue($field);
        }
        if(isset($_POST['mailtoPresent']) || isset($_POST['mailto']))
        {
            $accounts = $_POST['mailto'] ?? array();
            if(!is_array($accounts) || count($accounts) > 100) throw new InvalidArgumentException('mailto');
            foreach($accounts as $account)
            {
                if(!is_string($account) || str_contains($account, ',') || strlen($account) > 120) throw new InvalidArgumentException('mailto');
            }
            $accounts = array_unique(array_filter($accounts, static fn($account) => $account !== ''));
            sort($accounts, SORT_STRING);
            $attributes['mailto'] = implode(',', $accounts);
        }
        if(isset($_POST['branchModules']))
        {
            $modules = $_POST['branchModules'];
            if(!is_array($modules) || count($modules) > 100) throw new InvalidArgumentException('productScope');
            $attributes['branchModules'] = array();
            foreach($modules as $branch => $module)
            {
                if(!is_int($branch) || $branch < 0 || !is_string($module) || !preg_match('/\A(?:-1|0|[1-9][0-9]{0,8})\z/', $module))
                    throw new InvalidArgumentException('productScope');
                if($module !== '-1') $attributes['branchModules'][$branch] = $module;
            }
        }
        return $attributes;
    }

    private function formValue(string $name): string
    {
        $value = $this->post->$name;
        return is_string($value) ? $value : '';
    }
}
