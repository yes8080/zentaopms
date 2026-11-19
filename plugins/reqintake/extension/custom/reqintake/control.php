<?php
class reqintake extends control
{
    public function index()
    {
        if(empty($this->app->user->admin))
        {
            http_response_code(403);
            return;
        }

        if(empty($this->session->reqintakeFormKey)) $this->session->set('reqintakeFormKey', bin2hex(random_bytes(32)));
        $key = $this->session->reqintakeFormKey;
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
        $this->view->feedback = $model->recent();
        $this->view->history = $model->historyForRecent($this->view->feedback);
        $this->display();
    }

    public function detail(int $id = 0)
    {
        if(empty($this->app->user->admin))
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
