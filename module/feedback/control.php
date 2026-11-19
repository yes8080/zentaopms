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
            $filter = $this->input('browseType', 'unclosed');
            $filters = $this->lang->feedback->filters + $this->lang->feedback->statusList;
            if(!isset($filters[$filter])) $filter = 'unclosed';
            return $this->locate($this->createLink('feedback', 'browse', array(
                'browseType' => $filter, 'productID' => (int)$this->input('productID'),
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
        $this->view->justSaved = $this->viewType === 'html' && (int)$this->session->feedbackSavedID === $feedbackID;
        if($this->view->justSaved) $this->session->set('feedbackSavedID', 0);
        $this->view->repeat = $feedback->repeatFeedback ? $this->feedback->getByID((int)$feedback->repeatFeedback) : false;
        $this->view->product = zget($this->feedback->getGrantProducts(), $feedback->product, '');
        $this->view->modulePath = $feedback->module ? $this->loadModel('tree')->getParents($feedback->module) : array();
        $this->view->attachments = array_map(static fn($file) => (object)array(
            'id' => $file->id, 'title' => $file->title, 'size' => $file->size,
        ), $this->loadModel('file')->getByObject('feedback', $feedbackID));
        $this->view->feedback->files = array_values($this->view->attachments);
        $this->view->descriptionHtml = $this->app->loadClass('purifier')->purify((string)$feedback->desc);
        $this->view->conversionProgress = $this->feedback->getConversionProgress($feedback);
        $this->view->ticket = common::hasPriv('feedback', 'ticket') ? $this->feedback->getTicket($feedback) : false;
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
        $action = $feedback
            ? $this->createLink('feedback', 'edit', array('feedbackID' => (int)$feedback->id))
            : $this->createLink('feedback', 'create', array('productID' => $productID));
        $input = array();
        foreach(array('title', 'product', 'module', 'type', 'pri', 'desc', 'public', 'feedbackBy', 'notifyEmail', 'notify', 'source', 'keywords') as $field)
        {
            $input[$field] = $this->input($field, (string)($feedback->$field ?? ''));
        }

        if($this->getFormData)
        {
            $this->formData = $input;
            return;
        }

        if($_POST || ($_SERVER['REQUEST_METHOD'] ?? '') === 'POST')
        {
            try
            {
                if(!$_POST) throw new InvalidArgumentException($this->lang->feedback->invalidFields);
                $withAttachment = isset($_FILES['files']) && ($_FILES['files']['error'] ?? null) !== UPLOAD_ERR_NO_FILE;
                if($withAttachment && (!common::hasPriv('feedback', 'upload') || !$this->hasValidUpload()))
                    throw new InvalidArgumentException($this->lang->feedback->uploadError);
                $id = $this->feedback->saveFeedback($input, $feedback, $withAttachment);
                if($this->viewType === 'html') $this->session->set('feedbackSavedID', $id);
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
        $this->view->formAction = $action;
        $this->view->moduleOptions = $moduleOptions;
        $this->view->title = $this->lang->feedback->{$this->methodName === 'edit' ? 'edit' : 'create'};
        $this->view->feedback = $feedback;
        $this->view->descriptionHtml = $this->app->loadClass('purifier')->purify((string)($feedback->desc ?? ''));
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
            $target = $this->input('target');
            $this->feedback->convert($feedback, $target);
            if(($this->app->apiVersion ?? '') === 'v2' && $target === 'ticket')
            {
                $current = $this->feedback->getByID($feedbackID);
                return $this->send(array('result' => 'success', 'id' => (int)$current->result, 'feedbackID' => $feedbackID, 'message' => $this->lang->saveSuccess));
            }
            return $this->success($feedbackID);
        }
        catch(InvalidArgumentException|RuntimeException $error)
        {
            return $this->failure($error->getMessage());
        }
    }

    public function upload(int $feedbackID)
    {
        $feedback = $this->feedback->getByID($feedbackID);
        if(!$feedback) return $this->failure($this->lang->feedback->notFound, 404);
        if(!$this->feedback->canOperate($feedback, 'edit')) return $this->failure($this->lang->feedback->invalidAction, 403);
        if(($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') return $this->failure($this->lang->feedback->invalidAction, 405);

        if(!$this->hasValidUpload()) return $this->failure($this->lang->feedback->uploadError);

        try
        {
            $this->feedback->attachFile($feedback);
            return $this->success($feedbackID);
        }
        catch(InvalidArgumentException|RuntimeException $error)
        {
            return $this->failure($error->getMessage());
        }
    }

    private function hasValidUpload(): bool
    {
        $upload = $_FILES['files'] ?? array();
        return ($upload['error'] ?? null) === UPLOAD_ERR_OK && is_string($upload['tmp_name'] ?? null)
            && is_uploaded_file($upload['tmp_name']) && $upload['size'] > 0 && $upload['size'] <= 10 * 1024 * 1024;
    }

    public function download(int $fileID)
    {
        $model = $this->loadModel('file');
        $file = $model->getById($fileID);
        if(!$file || $file->objectType !== 'feedback' || $file->deleted || !$model->checkPriv($file))
            return $this->failure($this->lang->feedback->notFound, 404);
        $root = realpath($model->savePath);
        $path = realpath($file->realPath);
        if(!$root || !$path || !str_starts_with($path, $root . DIRECTORY_SEPARATOR) || !is_file($path) || filesize($path) > 10 * 1024 * 1024)
            return $this->failure($this->lang->feedback->notFound, 404);

        $contents = file_get_contents($path);
        if($contents === false) return $this->failure($this->lang->feedback->notFound, 404);
        header('X-Content-Type-Options: nosniff');
        $model->sendDownHeader($file->title, $file->extension, $contents);
    }

    public function ticket(int $feedbackID)
    {
        $feedback = $this->feedback->getByID($feedbackID);
        $ticket = $feedback ? $this->feedback->getTicket($feedback) : false;
        if(!$ticket) return $this->failure($this->lang->feedback->notFound, 404);
        if(!$_POST) return $this->locate($this->createLink('feedback', 'view', "feedbackID=$feedbackID"));
        if(!$this->app->user->admin && $ticket->assignedTo !== $this->app->user->account)
            return $this->failure($this->lang->feedback->invalidAction, 403);

        try
        {
            $this->feedback->changeTicket($feedback, $ticket, $this->input('status'));
            return $this->success($feedbackID);
        }
        catch(InvalidArgumentException|RuntimeException $error)
        {
            return $this->failure($error->getMessage());
        }
    }

    public function batch()
    {
        $ids = $_POST['feedbackIDs'] ?? array();
        $operation = $this->input('operation');
        if(!is_array($ids) || !$ids || count($ids) > 100 || !in_array($operation, array('assignTo', 'review', 'close', 'edit'), true))
            return $this->failure($this->lang->feedback->invalidAction);
        if(!common::hasPriv('feedback', $operation)) return $this->failure($this->lang->feedback->invalidAction, 403);

        foreach($ids as $id)
        {
            if(!is_scalar($id) || !ctype_digit((string)$id) || (int)$id < 1) return $this->failure($this->lang->feedback->invalidFields);
        }
        $ids = array_unique(array_map('intval', $ids));
        $items = $this->feedback->getByList($ids);
        if(count($items) !== count($ids)) return $this->failure($this->lang->feedback->notFound, 404);

        $fields = array('assignTo' => 'assignedTo', 'review' => 'reviewResult', 'close' => 'closedReason');
        $value = $operation === 'edit'
            ? array_filter(array('pri' => $this->input('pri'), 'type' => $this->input('type')), static fn($item) => $item !== '')
            : $this->input($fields[$operation]);
        try
        {
            $this->feedback->batchOperate($items, $operation, $value);
            return $this->locate($this->createLink('feedback', 'browse'));
        }
        catch(InvalidArgumentException|RuntimeException $error)
        {
            return $this->failure($error->getMessage());
        }
    }

    public function export(int $template = 0, int $productID = 0, string $browseType = 'all', string $keyword = '')
    {
        $this->app->loadClass('pager', true);
        $fields = $this->spreadsheetFields();
        $pager = new pager(0, 5000, 1);
        $rows = $template ? array() : $this->feedback->getList($browseType, $productID, (string)helper::safe64Decode($keyword), 'id_asc', $pager);
        if(!$template && $pager->recTotal > 5000) return $this->failure($this->lang->feedback->exportLimit);
        $excel = $this->app->loadClass('phpexcel');
        $sheet = $excel->getActiveSheet();
        $columns = $template ? $fields : array_merge(array('id', 'status'), $fields);
        $sheet->fromArray($columns);
        foreach(array_values($rows) as $index => $row)
        {
            foreach($columns as $column => $name)
            {
                $sheet->setCellValueExplicitByColumnAndRow($column + 1, $index + 2, (string)$row->$name, 's');
            }
        }

        $filename = $template ? 'feedback-template.xlsx' : 'feedback.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=$filename");
        $excel->createWriter()->save('php://output');
    }

    public function import()
    {
        if(!common::hasPriv('feedback', 'create')) return $this->failure($this->lang->feedback->invalidAction, 403);
        if($_POST)
        {
            try
            {
                $this->feedback->importRows($this->readSpreadsheet($_FILES['workbook'] ?? array()));
                return $this->locate($this->createLink('feedback', 'browse', 'browseType=all'));
            }
            catch(InvalidArgumentException|RuntimeException $error)
            {
                $this->view->error = $error->getMessage();
            }
        }

        $this->view->title = $this->lang->feedback->import;
        $this->view->products = $this->feedback->getGrantProducts();
        $this->display('feedback', 'import');
    }

    private function spreadsheetFields(bool $legacy = false): array
    {
        $fields = array('product', 'title', 'desc', 'module', 'type', 'pri', 'public', 'feedbackBy', 'notifyEmail', 'notify');
        return $legacy ? $fields : array_merge($fields, array('source', 'keywords'));
    }

    private function readSpreadsheet(array $upload): array
    {
        $error = $this->lang->feedback->workbookError;
        $path = $upload['tmp_name'] ?? '';
        if(($upload['error'] ?? null) !== UPLOAD_ERR_OK || !is_string($path) || !is_uploaded_file($path)
            || $upload['size'] > 2 * 1024 * 1024) throw new InvalidArgumentException($error);

        $archive = new ZipArchive();
        if($archive->open($path) !== true) throw new InvalidArgumentException($error);
        try
        {
            $expandedSize = 0;
            for($index = 0; $index < $archive->numFiles; $index++)
            {
                $entry = $archive->statIndex($index);
                if(!$entry || ($expandedSize += $entry['size']) > 16 * 1024 * 1024) throw new InvalidArgumentException($error);
            }
        }
        finally
        {
            $archive->close();
        }

        $excel = $this->app->loadClass('phpexcel');
        try
        {
            $reader = $excel->createReader();
            $sheets = $reader->listWorksheetInfo($path);
            if(count($sheets) !== 1 || $sheets[0]['totalRows'] > 201 || $sheets[0]['totalColumns'] > count($this->spreadsheetFields()) + 2)
                throw new InvalidArgumentException($error);
            $sheet = $reader->setReadDataOnly(true)->load($path)->getActiveSheet();
        }
        catch(Exception $exception)
        {
            throw new InvalidArgumentException($error, 0, $exception);
        }

        $rows = $sheet->toArray('', false);
        $fields = array_shift($rows);
        $exportPrefix = array('id', 'status');
        $dataFields = array_slice($fields, 0, 2) === $exportPrefix ? array_slice($fields, 2) : $fields;
        if($dataFields !== $this->spreadsheetFields() && $dataFields !== $this->spreadsheetFields(true))
            throw new InvalidArgumentException($error);

        $result = array();
        foreach($rows as $index => $row)
        {
            $row = array_combine($fields, $row);
            unset($row['id'], $row['status']);
            $row = array_map(static fn($value) => is_scalar($value) ? (string)$value : '', $row);
            if(count(array_filter($row, static fn($value) => $value !== ''))) $result[$index + 2] = $row;
        }
        if(!$result) throw new InvalidArgumentException($error);
        return $result;
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
