<?php
class reqintake extends control
{
    public function index(string $scope = 'all', int $filterProduct = 0)
    {
        if(!$this->loadModel('reqintake')->canAccess('index'))
        {
            http_response_code(403);
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
                elseif($intent === 'batchLink')
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
                    $model->linkTargets($sources, (int)$this->formValue('storyID'), $this->formValue('linkScope'), $type);
                    $this->view->batchCount = count($sources);
                }
                elseif($intent === 'transition')
                {
                    $model->transition((int)$this->formValue('feedbackID'), (int)$this->formValue('version'), $this->formValue('action'), $this->formValue('reason'));
                }
                else
                {
                    $id = $model->receive((int)$fields['product'], $operation, $fields['title'], $fields['description'], $fields['customer'], $fields['channel']);
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
        $this->view->fields = $fields;
        $this->view->products = $this->loadModel('product')->getPairs();
        $model = $this->loadModel('reqintake');
        $this->view->isAdmin = !empty($this->app->user->admin);
        $this->view->currentAccount = $this->app->user->account;
        $this->view->scope = in_array($scope, array('all', 'mine', 'assigned'), true) ? $scope : 'all';
        $this->view->filterProduct = max(0, $filterProduct);
        $this->view->batchTypes = array_intersect($model->visibleTargetTypes(), array('story', 'requirement', 'epic'));
        if(!$model->canAccess('detail')) $this->view->batchTypes = array();
        $this->view->feedback = $model->recent($this->view->scope, $this->view->filterProduct);
        $this->view->history = $model->historyForRecent($this->view->feedback);
        $this->display();
    }

    public function detail(int $id = 0)
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
                if($this->formValue('intent') === 'revise')
                {
                    $fields = array();
                    foreach(array('title', 'description', 'customer', 'channel') as $field) $fields[$field] = $this->formValue($field);
                    $model->revise($feedback, (int)$this->formValue('version'), $fields);
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

        $this->view->original = $feedback;
        $this->view->revisions = $model->revisions($feedback);
        if($this->view->revisions)
        {
            $latest = reset($this->view->revisions);
            $feedback = clone $feedback;
            foreach(array('title', 'description', 'customer', 'channel') as $field) $feedback->$field = $latest->$field;
        }
        $this->view->canRevise = $feedback->status !== 'closed' && $model->canHandle($feedback);
        $this->view->linkToken = $token;
        $this->view->storyTypes = $model->visibleTargetTypes();
        $this->view->canLink = $feedback->status !== 'closed' && $model->canHandle($feedback) && $this->view->storyTypes;
        foreach(array('story', 'bug', 'task') as $module) $this->app->loadLang($module);
        $this->view->linkedStories = $model->linkedTargets($feedback);
        $this->view->title = $feedback->title;
        $this->view->item = $feedback;
        $this->display();
    }

    private function formValue(string $name): string
    {
        $value = $this->post->$name;
        return is_string($value) ? $value : '';
    }
}
