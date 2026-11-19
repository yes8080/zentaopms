<?php
class feedback extends control
{
    public function index()
    {
        return $this->browse();
    }

    public function browse(string $browseType = 'unclosed', int $productID = 0, string $orderBy = 'id_desc', int $recTotal = 0, int $recPerPage = 20, int $pageID = 1, string $keyword = '')
    {
        if($this->viewType === 'html' && $_POST)
        {
            $searchText = mb_substr(trim($this->input('keyword')), 0, 100);
            return $this->locate($this->createLink('feedback', 'browse', array(
                'browseType' => $this->input('browseType', 'unclosed'), 'productID' => (int)$this->input('productID'),
                'orderBy' => 'id_desc', 'recTotal' => 0, 'recPerPage' => $recPerPage, 'pageID' => 1,
                'keyword' => $searchText === '' ? '' : helper::safe64Encode($searchText),
            )));
        }
        $keyword = $keyword === '' ? '' : (string)helper::safe64Decode($keyword);
        return $this->admin($browseType, $productID, $orderBy, $recTotal, $recPerPage, $pageID, $keyword);
    }

    public function admin(string $browseType = 'unclosed', int $productID = 0, string $orderBy = 'id_desc', int $recTotal = 0, int $recPerPage = 20, int $pageID = 1, string $keyword = '')
    {
        $this->app->loadClass('pager', true);
        $pager = new pager(0, min(100, max(1, $recPerPage)), max(1, $pageID));

        $this->view->title = $this->lang->feedback->browse;
        $this->view->feedbacks = $this->feedback->getList($browseType, $productID, $keyword, $orderBy, $pager);
        $this->view->products = $this->feedback->getGrantProducts();
        $this->view->users = $this->feedback->getFeedbackPairs('');
        $this->view->pager = $pager;
        $this->view->browseType = $browseType;
        $this->view->productID = $productID;
        $this->view->keyword = $keyword;
        $this->view->orderBy = $orderBy;
        $this->display('feedback', 'browse');
    }

    public function view(int $feedbackID)
    {
        return $this->adminView($feedbackID);
    }

    public function adminView(int $feedbackID)
    {
        $feedback = $this->feedback->getByID($feedbackID);
        if(!$feedback) return $this->failure($this->lang->feedback->notFound, 404);

        $this->view->title = $feedback->title;
        $this->view->feedback = $feedback;
        $this->view->repeat = $feedback->repeatFeedback ? $this->feedback->getByID((int)$feedback->repeatFeedback) : false;
        $this->view->product = zget($this->feedback->getGrantProducts(), $feedback->product, '');
        $this->view->modulePath = $feedback->module ? $this->loadModel('tree')->getParents($feedback->module) : array();
        $this->view->actions = $this->loadModel('action')->getList('feedback', $feedbackID);
        $this->view->users = $this->feedback->getFeedbackPairs('');
        $this->view->conversionTypes = $this->feedback->getConversionTypes($feedback);
        $this->view->assignees = $this->feedback->getEligibleAssignees((int)$feedback->product);
        $this->display('feedback', 'view');
    }

    public function create(int $productID = 0)
    {
        return $this->editForm(null, $productID);
    }

    public function edit(int $feedbackID, string $from = '')
    {
        $feedback = $this->feedback->getByID($feedbackID);
        if(!$feedback) return $this->failure($this->lang->feedback->notFound, 404);
        if(!common::hasPriv('feedback', 'edit') || !$this->feedback->canOperate($feedback, 'edit')) return $this->failure($this->lang->feedback->invalidAction, 403);
        return $this->editForm($feedback, (int)$feedback->product);
    }

    private function editForm(?object $feedback, int $productID)
    {
        $products = $this->feedback->getGrantProducts();
        $input = array();
        foreach(array('title', 'product', 'module', 'type', 'pri', 'desc', 'public', 'feedbackBy', 'notifyEmail') as $field)
        {
            $input[$field] = $this->input($field, (string)($feedback->$field ?? ''));
        }

        if($this->getFormData)
        {
            $this->formData = $input;
            return;
        }

        if($_POST)
        {
            try
            {
                $id = $this->feedback->saveFeedback($input, $feedback);
                return $this->success($id);
            }
            catch(InvalidArgumentException|RuntimeException $error)
            {
                if($this->viewType !== 'html') return $this->failure($error->getMessage());
                $this->view->error = $error->getMessage();
                $feedback = (object)$input;
                $productID = (int)$input['product'];
            }
        }

        if(!$productID) $productID = (int)array_key_first($products);
        $moduleOptions = $this->feedback->getModuleOptions(array_keys($products));
        $modules = $moduleOptions[$productID] ?? array();
        $this->view->moduleOptions = $moduleOptions;
        $this->view->title = $this->lang->feedback->{$this->methodName === 'edit' ? 'edit' : 'create'};
        $this->view->feedback = $feedback;
        $this->view->products = $products;
        $this->view->modules = $modules;
        $this->view->productID = $productID;
        $this->display('feedback', 'create');
    }

    public function convert(int $feedbackID)
    {
        $feedback = $this->feedback->getByID($feedbackID);
        if(!$feedback) return $this->failure($this->lang->feedback->notFound, 404);
        if(!$_POST) return $this->failure($this->lang->feedback->invalidAction, 405);
        if(!common::hasPriv('feedback', 'convert')) return $this->failure($this->lang->feedback->invalidAction, 403);
        try
        {
            $this->feedback->convert($feedback, $this->input('target'));
            return $this->success($feedbackID);
        }
        catch(InvalidArgumentException|RuntimeException $error)
        {
            return $this->failure($error->getMessage());
        }
    }

    public function assignTo(int $feedbackID) { return $this->change($feedbackID, 'assignTo', 'assignedTo'); }
    public function review(int $feedbackID)   { return $this->change($feedbackID, 'review', 'reviewResult'); }
    public function close(int $feedbackID)    { return $this->change($feedbackID, 'close', 'closedReason'); }
    public function activate(int $feedbackID) { return $this->change($feedbackID, 'activate'); }
    public function comment(int $feedbackID)  { return $this->change($feedbackID, 'comment'); }
    public function reply(int $feedbackID)    { return $this->change($feedbackID, 'reply'); }
    public function ask(int $feedbackID)      { return $this->change($feedbackID, 'ask'); }
    public function delete(int $feedbackID, string $confirm = '') { return $this->change($feedbackID, 'delete', '', $confirm === 'yes'); }

    private function change(int $id, string $operation, string $field = '', bool $apiDelete = false)
    {
        $feedback = $this->feedback->getByID($id);
        if(!$feedback) return $this->failure($this->lang->feedback->notFound, 404);
        if(!common::hasPriv('feedback', $operation) || !$this->feedback->canOperate($feedback, $operation)) return $this->failure($this->lang->feedback->invalidAction, 403);

        if($_POST || ($apiDelete && $this->app->apiVersion && ($_SERVER['REQUEST_METHOD'] ?? '') === 'DELETE'))
        {
            try
            {
                $this->feedback->operate($feedback, $operation, $this->input($field), $this->input('comment'), (int)$this->input('repeatFeedback'));
                return $this->success($id, $operation === 'delete');
            }
            catch(InvalidArgumentException|RuntimeException $error)
            {
                return $this->failure($error->getMessage());
            }
        }

        if($operation === 'assignTo' && $this->viewType !== 'html')
        {
            echo json_encode(array('status' => 'success', 'data' => array('users' => $this->feedback->getEligibleAssignees((int)$feedback->product))));
            return;
        }
        return $this->failure($this->lang->feedback->invalidAction, 405);
    }

    private function input(string $field, string $default = ''): string
    {
        return is_scalar($_POST[$field] ?? null) ? (string)$_POST[$field] : $default;
    }

    private function success(int $id, bool $deleted = false)
    {
        if($this->viewType === 'html') return $this->locate($deleted ? $this->createLink('feedback', 'browse') : $this->createLink('feedback', 'view', "feedbackID=$id"));
        if(($this->app->apiVersion ?? '') === 'v2')
        {
            return $this->send(array('result' => 'success', 'id' => $id, 'message' => $this->lang->saveSuccess));
        }
        echo json_encode(array('result' => 'success', 'id' => $id));
    }

    private function failure(string $message, int $code = 400)
    {
        if($this->viewType !== 'html')
        {
            echo json_encode(array('result' => 'fail', 'status' => 'fail', 'code' => $code, 'message' => $message));
            return;
        }

        http_response_code($code);
        $this->view->title = $this->lang->feedback->common;
        $this->view->error = $message;
        $this->display('feedback', 'error');
    }
}
