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

    public function recent(string $scope = 'all', int $product = 0, int $beforeID = 0, string $sort = 'id', string $beforeUpdate = '', string $owner = '', string $status = '', string $updatedFrom = '', string $updatedTo = '', int $feedbackID = 0): array
    {
        if(!$this->canAccess('index')) throw new DomainException('product');

        $query = $this->dao->select('f.id,f.title,f.customer,f.updatedDate,f.assignedTo,f.assignmentPending,f.status,f.version,p.name AS productName')
            ->from($this->config->db->prefix . 'reqintakeFeedback')->alias('f')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->where('p.deleted')->eq('0');
        if(empty($this->app->user->admin)) $query->andWhere('f.product')->in($this->visibleProducts() ?: array(0));
        if($product > 0) $query->andWhere('f.product')->eq($product);
        if($feedbackID > 0) $query->andWhere('f.id')->eq($feedbackID);
        if($owner !== '') $query->andWhere('f.assignedTo')->eq($owner);
        if($status !== '') $query->andWhere('f.status')->eq($status);
        if($updatedFrom !== '') $query->andWhere('f.updatedDate')->ge($updatedFrom . ' 00:00:00');
        if($updatedTo !== '') $query->andWhere('f.updatedDate')->le($updatedTo . ' 23:59:59');
        if($beforeID > 0)
        {
            if($sort === 'updated' && preg_match('/\A[0-9]{14}\z/', $beforeUpdate))
            {
                $beforeUpdate = substr($beforeUpdate, 0, 4) . '-' . substr($beforeUpdate, 4, 2) . '-' . substr($beforeUpdate, 6, 2)
                    . ' ' . substr($beforeUpdate, 8, 2) . ':' . substr($beforeUpdate, 10, 2) . ':' . substr($beforeUpdate, 12, 2);
                $query->andWhere('f.updatedDate', true)->lt($beforeUpdate)
                    ->orWhere('f.updatedDate')->eq($beforeUpdate)->andWhere('f.id')->lt($beforeID)->markRight();
            }
            elseif($sort === 'id') $query->andWhere('f.id')->lt($beforeID);
        }
        if($scope === 'pendingOwner') $query->andWhere('f.assignmentPending')->eq(1);
        $account = $this->app->user->account;
        if($scope === 'mine') $query->andWhere('f.openedBy')->eq($account);
        if($scope === 'assigned') $query->andWhere('f.assignedTo')->eq($account)->andWhere('f.status')->ne('closed');
        $rows = $query->orderBy($sort === 'updated' ? 'f.updatedDate_desc,f.id_desc' : 'f.id_desc')->limit(51)->fetchAll();
        if(!$rows) return $rows;

        $ids = array_map(static fn($item) => (int)$item->id, $rows);
        $changes = $this->dao->select('feedback,title,customer')->from($this->config->db->prefix . 'reqintakeRevision')
            ->where('feedback')->in($ids)->orderBy('version_desc')->fetchAll();
        $latestChanges = array();
        foreach($changes as $change) $latestChanges[(int)$change->feedback] ??= $change;
        $plans = $this->dao->select('feedback,summary')->from($this->config->db->prefix . 'reqintakeHandling')
            ->where('feedback')->in($ids)->andWhere('kind')->eq('plan')->orderBy('version_desc')->fetchAll();
        $next = array();
        foreach($plans as $plan) $next[(int)$plan->feedback] ??= $plan->summary;
        foreach($rows as $row)
        {
            $change = $latestChanges[(int)$row->id] ?? null;
            if($change)
            {
                $row->title = $change->title;
                $row->customer = $change->customer;
            }
            $row->nextStep = $next[(int)$row->id] ?? '';
        }
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

    public function attachments(int $feedback): array
    {
        $table = $this->config->db->prefix . 'reqintakeAttachment';
        return $this->dao->select('id,name')->from($table)
            ->where('feedback')->eq($feedback)->andWhere('removed')->eq(0)->orderBy('id_asc')->fetchAll();
    }

    public function attachment(int $feedback, int $id): object|false
    {
        if(!$this->findFeedback($feedback)) return false;

        $table = $this->config->db->prefix . 'reqintakeAttachment';
        $read = $this->dbh->prepare("SELECT name,data FROM `$table` WHERE feedback = ? AND id = ? AND removed = 0");
        $read->execute([$feedback, $id]);
        return $read->fetch(PDO::FETCH_OBJ);
    }

    private function readAttachment(?array $upload): array
    {
        if(($upload['error'] ?? null) !== UPLOAD_ERR_OK || !is_string($upload['tmp_name'] ?? null)
            || !is_uploaded_file($upload['tmp_name'])) throw new InvalidArgumentException('attachment');
        $size = filesize($upload['tmp_name']);
        if(!$size || $size > 5 * 1024 * 1024) throw new InvalidArgumentException('attachment');
        $name = basename(str_replace(chr(92), '/', (string)$upload['name']));
        if($name === '' || mb_strlen($name) > 255 || preg_match('/[[:cntrl:]]/', $name)) throw new InvalidArgumentException('attachment');
        $data = file_get_contents($upload['tmp_name']);
        if($data === false || strlen($data) !== $size) throw new InvalidArgumentException('attachment');
        return array($name, $data);
    }

    private function insertAttachment(int $id, string $name, string $data): void
    {
        $table = $this->config->db->prefix . 'reqintakeAttachment';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,name,data) VALUES (?,?,?)");
        $insert->execute([$id, $name, $data]);
    }

    public function changeAttachment(object $feedback, int $version, ?array $upload, int $remove = 0): void
    {
        if(!$this->canHandle($feedback)) throw new DomainException('handler');
        if(!$remove) [$name, $data] = $this->readAttachment($upload);

        $prefix = $this->config->db->prefix;
        $this->dbh->beginTransaction();
        try
        {
            $update = $this->dbh->prepare("UPDATE `{$prefix}reqintakeFeedback` SET version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status <> 'closed'");
            $update->execute([helper::now(), $feedback->id, $version]);
            if($update->rowCount() !== 1) throw new DomainException('staleFeedback');

            if($remove)
            {
                $update = $this->dbh->prepare("UPDATE `{$prefix}reqintakeAttachment` SET removed = 1 WHERE id = ? AND feedback = ? AND removed = 0");
                $update->execute([$remove, $feedback->id]);
                if($update->rowCount() !== 1) throw new DomainException('attachment');
            }
            else
            {
                $this->insertAttachment((int)$feedback->id, $name, $data);
            }
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function richTextVersions(int $id): array
    {
        return $this->dao->select('version')->from($this->config->db->prefix . 'reqintakeRichText')
            ->where('feedback')->eq($id)->fetchPairs('version', 'version');
    }

    private function saveRichTextVersion(int $id, int $version): void
    {
        $table = $this->config->db->prefix . 'reqintakeRichText';
        $this->dbh->prepare("INSERT INTO `$table` (feedback,version) VALUES (?,?)")->execute([$id, $version]);
    }

    public function cleanRichText(string $text): string
    {
        static $purifier;
        if($purifier === null)
        {
            $this->app->loadClass('purifier', true);
            $config = HTMLPurifier_Config::createDefault();
            $config->set('Cache.DefinitionImpl', null);
            $config->set('HTML.Allowed', 'p,br,strong,b,em,i,u,s,ul,ol,li,blockquote,pre,code,h1,h2,h3,h4,hr,img[src|alt]');
            $config->set('URI.AllowedSchemes', array('data' => true));
            $purifier = new HTMLPurifier($config);
        }
        if(strlen($text) > 4 * 1024 * 1024) throw new InvalidArgumentException('richTextSize');

        /* Purifier validates and canonicalizes data images. Discard relative image sources too. */
        return preg_replace_callback('~<img(?= )[^>]*>~i', static function($match)
        {
            return preg_match('~ src="data:image/(?:png|jpeg|gif);base64,[A-Za-z0-9+/=]+"~', $match[0]) ? $match[0] : '';
        }, $purifier->purify($text)) ?? '';
    }

    public function attributeOptions(): array
    {
        $this->app->loadLang('story');
        return array('category' => $this->lang->story->categoryList, 'priority' => $this->lang->story->priList, 'source' => $this->lang->story->sourceList);
    }

    public function mailtoOptions(): array
    {
        return array_filter($this->loadModel('user')->getPairs('pdfirst|noclosed|nodeleted'), static fn($account) => $account !== '', ARRAY_FILTER_USE_KEY);
    }

    public function gradeSuggestions(): array
    {
        $options = array('' => '');
        $story = $this->loadModel('story');
        foreach(array('story', 'requirement', 'epic') as $type)
        {
            if($this->config->{$type}->gradeRule === 'stepwise') continue;
            foreach($story->getGradePairs($type) as $id => $label)
                $options["$type:$id"] = $this->lang->reqintake->storyTypes[$type] . ' · ' . $label;
        }
        return $options;
    }

    public function attributeDefaults(): array
    {
        return array('category' => 'feature', 'priority' => '3', 'acceptance' => '',
            'source' => '', 'sourceNote' => '', 'keywords' => '', 'estimate' => '', 'branch' => '0', 'module' => '0', 'plan' => '0', 'mailto' => '', 'customerVersion' => '', 'suggestedGrade' => '', 'suggestedParent' => '', 'suggestedReviewers' => '', 'branchModules' => array());
    }

    private function attributeTables(): array
    {
        return array('reqintakeAttributes' => 'category,priority,acceptance', 'reqintakeDemandFields' => 'source,sourceNote,keywords,estimate', 'reqintakeProductScope' => 'branch,module', 'reqintakePlan' => 'plan', 'reqintakeMailto' => 'mailto', 'reqintakeCustomerVersion' => 'customerVersion', 'reqintakeGrade' => 'suggestedGrade', 'reqintakeParent' => 'suggestedParent', 'reqintakeReviewers' => 'suggestedReviewers');
    }

    public function attributes(int $id, ?int $version = null): array
    {
        $defaults = $this->attributeDefaults();
        $prefix = $this->config->db->prefix;
        foreach($this->attributeTables() as $table => $fields)
        {
            $query = $this->dao->select($fields)->from($prefix . $table)->where('feedback')->eq($id);
            if($version !== null) $query->andWhere('version')->le($version);
            $row = $query->orderBy('version_desc')->limit(1)->fetch();
            if($row) $defaults = array_replace($defaults, array_map('strval', (array)$row));
        }
        $query = $this->dao->select('branchModules')->from($prefix . 'reqintakeBranchScope')->where('feedback')->eq($id);
        if($version !== null) $query->andWhere('version')->le($version);
        $row = $query->orderBy('version_desc')->limit(1)->fetch();
        if($row) $defaults['branchModules'] = json_decode($row->branchModules, true, flags: JSON_THROW_ON_ERROR);
        return $defaults;
    }

    public function productScopeOptions(int $product): array
    {
        if(!$this->canReadProduct($product)) throw new DomainException('product');
        $this->app->loadLang('branch');
        $branches = array(0 => $this->lang->branch->main);
        $record = $this->loadModel('product')->getByID($product);
        if($record->type !== 'normal') $branches += $this->loadModel('branch')->getPairs($product, 'noempty');
        $modules = $this->loadModel('tree')->getOptionMenu($product, 'story', 0, array_keys($branches));
        foreach($modules as $branch => $pairs) $modules[$branch] = array(0 => '') + $pairs;
        $plans = array();
        foreach(array_keys($branches) as $branch) $plans[$branch] = $this->planOptions($product, (string)$branch);
        return array('branches' => $branches, 'modules' => $modules, 'plans' => $plans, 'hasBranches' => $record->type !== 'normal');
    }

    public function planOptions(int $product, string $branch, bool $forConversion = false): array
    {
        if(!$this->canReadProduct($product) || !ctype_digit($branch)) return array(0 => '');
        $filter = $forConversion ? 'unexpired|noclosed' : '';
        return array(0 => '') + $this->loadModel('productplan')->getPairs($product, $branch, $filter, true);
    }

    private function validatedAttributes(int $product, array $fields, array $previous = array()): array
    {
        $options = $this->attributeOptions();
        if(!array_key_exists($fields['category'], $options['category'])
            || $fields['priority'] === '0' || !array_key_exists($fields['priority'], $options['priority'])
            || strlen($fields['acceptance']) > 16777215) throw new InvalidArgumentException('attributes');
        if(!array_key_exists($fields['source'], $options['source'])
            || mb_strlen($fields['sourceNote']) > 255 || mb_strlen($fields['keywords']) > 255
            || ($fields['estimate'] !== '' && !preg_match('/\A[0-9]{1,8}(?:\.[0-9]{1,2})?\z/', $fields['estimate'])))
            throw new InvalidArgumentException('demandFields');

        $extra = $fields['branchModules'];
        if(!is_array($extra) || count($extra) > 100) throw new InvalidArgumentException('productScope');
        ksort($extra, SORT_NUMERIC);
        $fields['branchModules'] = $extra;
        if(($fields['branch'] !== ($previous['branch'] ?? '0')) || ($fields['module'] !== ($previous['module'] ?? '0')) || $extra !== ($previous['branchModules'] ?? array()))
        {
            $scope = $this->productScopeOptions($product);
            if(!array_key_exists($fields['branch'], $scope['branches'])
                || !array_key_exists($fields['module'], $scope['modules'][$fields['branch']] ?? array()))
                throw new InvalidArgumentException('productScope');
            foreach($extra as $branch => $module)
            {
                if((string)$branch === $fields['branch'] || !is_string($module)
                    || !array_key_exists($branch, $scope['branches'])
                    || !array_key_exists($module, $scope['modules'][$branch] ?? array()))
                    throw new InvalidArgumentException('productScope');
            }
        }

        $plan = $fields['plan'];
        if($plan !== '0' && ($plan !== ($previous['plan'] ?? '0') || $fields['branch'] !== ($previous['branch'] ?? '0'))
            && !isset($this->planOptions($product, $fields['branch'])[$plan]))
            throw new InvalidArgumentException('plan');

        if($fields['mailto'] !== ($previous['mailto'] ?? '') && $fields['mailto'] !== '')
        {
            $added = array_diff(explode(',', $fields['mailto']), explode(',', $previous['mailto'] ?? ''));
            if(array_diff($added, array_keys($this->mailtoOptions()))) throw new InvalidArgumentException('mailto');
        }

        $fields['customerVersion'] = trim($fields['customerVersion']);
        if(mb_strlen($fields['customerVersion']) > 100) throw new InvalidArgumentException('customerVersion');

        if($fields['suggestedGrade'] !== ($previous['suggestedGrade'] ?? '') && !isset($this->gradeSuggestions()[$fields['suggestedGrade']]))
            throw new InvalidArgumentException('suggestedGrade');

        $parentID = $fields['suggestedParent'];
        if($parentID !== '' && $parentID !== ($previous['suggestedParent'] ?? ''))
        {
            if(!preg_match('/\A[1-9][0-9]{0,9}\z/', $parentID)) throw new InvalidArgumentException('suggestedParent');
            $parent = $this->dao->select('type')->from(TABLE_STORY)->where('id')->eq((int)$parentID)
                ->andWhere('product')->eq($product)->andWhere('deleted')->eq('0')->fetch();
            if(!$parent || !in_array($parent->type, array('story', 'requirement', 'epic'), true)
                || !common::hasPriv($parent->type, 'view')) throw new InvalidArgumentException('suggestedParent');
            $story = $this->loadModel('story');
            $eligible = false;
            foreach(array('story', 'requirement', 'epic') as $type)
            {
                if(!isset($story->getParentStoryPairs($product, '', $type)[$parentID])) continue;
                $eligible = true;
                break;
            }
            if(!$eligible) throw new InvalidArgumentException('suggestedParent');
        }

        if($fields['suggestedReviewers'] !== ($previous['suggestedReviewers'] ?? '') && $fields['suggestedReviewers'] !== '')
        {
            $added = array_diff(explode(',', $fields['suggestedReviewers']), explode(',', $previous['suggestedReviewers'] ?? ''));
            $reviewers = $this->loadModel('story')->getProductReviewers($product);
            if(array_diff($added, array_keys($reviewers))) throw new InvalidArgumentException('suggestedReviewers');
        }

        $validated = array_replace($this->attributeDefaults(), $fields);
        $validated['priority'] = (string)$validated['priority'];
        return $validated;
    }

    private function saveAttributes(int $id, int $version, array $fields): void
    {
        $table = $this->config->db->prefix . 'reqintakeAttributes';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,category,priority,acceptance) VALUES (?,?,?,?,?)");
        $insert->execute([$id, $version, $fields['category'], $fields['priority'], $fields['acceptance']]);

        $table = $this->config->db->prefix . 'reqintakeDemandFields';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,source,sourceNote,keywords,estimate) VALUES (?,?,?,?,?,?)");
        $insert->execute([$id, $version, $fields['source'], $fields['sourceNote'], $fields['keywords'], $fields['estimate']]);

        $table = $this->config->db->prefix . 'reqintakeProductScope';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,branch,module) VALUES (?,?,?,?)");
        $insert->execute([$id, $version, $fields['branch'], $fields['module']]);

        $table = $this->config->db->prefix . 'reqintakePlan';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,plan) VALUES (?,?,?)");
        $insert->execute([$id, $version, $fields['plan']]);

        $table = $this->config->db->prefix . 'reqintakeMailto';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,mailto) VALUES (?,?,?)");
        $insert->execute([$id, $version, $fields['mailto']]);

        $table = $this->config->db->prefix . 'reqintakeCustomerVersion';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,customerVersion) VALUES (?,?,?)");
        $insert->execute([$id, $version, $fields['customerVersion']]);

        $table = $this->config->db->prefix . 'reqintakeGrade';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,suggestedGrade) VALUES (?,?,?)");
        $insert->execute([$id, $version, $fields['suggestedGrade']]);

        $table = $this->config->db->prefix . 'reqintakeParent';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,suggestedParent) VALUES (?,?,?)");
        $insert->execute([$id, $version, $fields['suggestedParent']]);

        $table = $this->config->db->prefix . 'reqintakeReviewers';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,suggestedReviewers) VALUES (?,?,?)");
        $insert->execute([$id, $version, $fields['suggestedReviewers']]);

        $table = $this->config->db->prefix . 'reqintakeBranchScope';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,branchModules) VALUES (?,?,?)");
        $insert->execute([$id, $version, json_encode($fields['branchModules'], JSON_THROW_ON_ERROR)]);
    }

    public function revisions(object $feedback): array
    {
        if(!$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();

        return $this->dao->select('version,title,description,customer,channel,actor,createdDate')
            ->from($this->config->db->prefix . 'reqintakeRevision')->where('feedback')->eq((int)$feedback->id)
            ->orderBy('version_desc')->fetchAll();
    }

    public function revise(object $feedback, int $version, array $fields, bool $rich = false): void
    {
        if(!$this->canHandle($feedback)) throw new DomainException('handler');

        if($rich)
        {
            $fields['description'] = $this->cleanRichText($fields['description']);
            $fields['acceptance'] = $this->cleanRichText($fields['acceptance'] ?? '');
        }
        $title = trim($fields['title']);
        if($title === '' || mb_strlen($title) > 255) throw new InvalidArgumentException('title');
        if((trim($rich ? html_entity_decode(strip_tags($fields['description'])) : $fields['description']) === '' && (!$rich || !str_contains($fields['description'], '<img '))) || strlen($fields['description']) > 16777215) throw new InvalidArgumentException('description');
        if(mb_strlen($fields['customer']) > 255 || mb_strlen($fields['channel']) > 64) throw new InvalidArgumentException('source');

        $previous = $this->attributes((int)$feedback->id);
        $attributes = $this->validatedAttributes((int)$feedback->product, array_intersect_key($fields, $previous) + $previous, $previous);

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
            $this->saveAttributes((int)$feedback->id, $version + 1, $attributes);
            if($rich) $this->saveRichTextVersion((int)$feedback->id, $version + 1);
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    public function revisionDiffs(object $feedback, array $revisions, array $richVersions): array
    {
        if(!$revisions || !$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();

        $prefix = $this->config->db->prefix;
        $rowsByVersion = array();
        foreach($this->attributeTables() + array('reqintakeBranchScope' => 'branchModules') as $table => $fields)
        {
            $rows = $this->dao->select("version,$fields")->from($prefix . $table)->where('feedback')->eq($feedback->id)->fetchAll();
            foreach($rows as $row)
            {
                $version = (int)$row->version;
                unset($row->version);
                $rowsByVersion[$version] = ($rowsByVersion[$version] ?? array()) + array_map('strval', (array)$row);
            }
        }

        $attributes = $this->attributeDefaults();
        $attributes['branchModules'] = '[]';
        $previous = array();
        $previousWasRich = false;
        $diffs = array();
        $this->app->loadLang('action');
        foreach($this->lang->reqintake->fields as $name => $label) $this->lang->reqintake->$name ??= $label;
        $this->lang->reqintake->branchModules = $this->lang->reqintake->additionalBranches;
        $action = $this->loadModel('action');
        $escape = static fn($text) => htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        foreach(array_merge(array($feedback), array_reverse($revisions)) as $revision)
        {
            $version = $revision === $feedback ? 1 : (int)$revision->version;
            $rich = isset($richVersions[$version]);
            $attributes = array_replace($attributes, $rowsByVersion[$version] ?? array());
            $current = array_intersect_key((array)$revision, array_flip(array('title', 'description', 'customer', 'channel'))) + $attributes;
            $changes = array();
            foreach($current as $field => $value)
            {
                if(!isset($previous[$field]) || $previous[$field] === $value) continue;
                $before = $previous[$field];
                $diff = '';
                if(in_array($field, array('description', 'acceptance'), true))
                {
                    /* Compare the text without embedding the image data in the history. */
                    if($previousWasRich) $before = html_entity_decode(strip_tags($before), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    if($rich) $value = html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    if($before === $value) $diff = $this->lang->reqintake->richRevisionChanged;
                }
                $changes[] = (object)array('field' => $field, 'old' => $escape($before), 'new' => $escape($value), 'diff' => $diff);
            }
            if($changes) $diffs[$version] = $action->renderChanges('reqintake', (int)$feedback->id, $changes);
            $previous = $current;
            $previousWasRich = $rich;
        }
        return $diffs;
    }

    public function handling(object $feedback): array
    {
        if(!$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();
        return $this->dao->select('kind,actor,summary,details,channel,createdDate')
            ->from($this->config->db->prefix . 'reqintakeHandling')
            ->where('feedback')->eq((int)$feedback->id)->orderBy('version_desc')->fetchAll();
    }

    public function recordHandling(object $feedback, int $version, string $kind, string $summary, string $details, string $channel, ?string $closeReason = null, bool $verified = false): void
    {
        if(!$this->canHandle($feedback)) throw new DomainException('handler');

        $summary = trim($summary);
        $details = trim($details);
        $channel = trim($channel);
        if(!in_array($kind, array('plan', 'reply'), true)
            || mb_strlen($summary) > 500 || mb_strlen($details) > 2000 || mb_strlen($channel) > 64
            || ($kind === 'reply' && ($summary === '' || $details === '' || $channel === '')))
            throw new InvalidArgumentException('handlingFields');

        if($closeReason !== null)
        {
            if($kind !== 'reply') throw new InvalidArgumentException('handlingFields');
            $this->transition((int)$feedback->id, $version, 'close', $closeReason, outcome: 'confirmed', verified: $verified,
                reply: array($summary, $details, $channel));
            return;
        }

        $prefix = $this->config->db->prefix;
        $now = helper::now();
        $this->dbh->beginTransaction();
        try
        {
            $update = $this->dbh->prepare("UPDATE `{$prefix}reqintakeFeedback` SET version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status <> 'closed'");
            $update->execute([$now, $feedback->id, $version]);
            if($update->rowCount() !== 1) throw new DomainException('staleFeedback');

            $this->insertHandling((int)$feedback->id, $version + 1, $kind, $summary, $details, $kind === 'reply' ? $channel : '', $now);
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    private function insertHandling(int $id, int $version, string $kind, string $summary, string $details, string $channel, string $date): void
    {
        $table = $this->config->db->prefix . 'reqintakeHandling';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (feedback,version,kind,actor,summary,details,channel,createdDate) VALUES (?,?,?,?,?,?,?,?)");
        $insert->execute([$id, $version, $kind, $this->app->user->account, $summary, $details, $channel, $date]);
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
            $target = $this->dao->select("t.id,t.name AS title,t.status,'' AS stage,t.closedReason,t.execution")
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
            $target = $this->dao->select('id,title,status,stage,closedReason,branch')->from(TABLE_STORY)
                ->where('id')->eq($id)->andWhere('product')->eq($product)->andWhere('type')->eq($type)->andWhere('deleted')->eq('0')->fetch();
        }

        if($target && !empty($target->execution) && !$this->loadModel('execution')->checkPriv((int)$target->execution)) return false;
        return $target ?: false;
    }

    public function linkedTargets(object $feedback, array $branches): array
    {
        $types = $this->visibleTargetTypes();
        if(!$types || !$this->canAccess('detail') || !$this->canReadProduct((int)$feedback->product)) return array();

        $prefix = $this->config->db->prefix;
        $links = $this->dao->select('l.target,l.targetType,l.scope,l.createdDate,p.checkedDate,m.method')
            ->from($prefix . 'reqintakeLink')->alias('l')
            ->leftJoin($prefix . 'reqintakeProgress')->alias('p')->on('p.feedback = l.feedback AND p.targetType = l.targetType AND p.target = l.target')
            ->leftJoin($prefix . 'reqintakeLinkMethod')->alias('m')->on('m.feedback = l.feedback AND m.targetType = l.targetType AND m.target = l.target')
            ->where('l.feedback')->eq((int)$feedback->id)->andWhere('l.targetType')->in($types)->orderBy('l.target_desc')->fetchAll();
        foreach($links as $link)
        {
            $target = $this->targetForProduct($link->targetType, (int)$link->target, (int)$feedback->product);
            $link->id = $target ? $target->id : null;
            $link->title = $target ? $target->title : '';
            $link->status = $target ? $target->status : '';
            $link->stage = $target ? $target->stage : '';
            $link->closedReason = $target ? $target->closedReason : '';
            $link->reviewReason = '';
            if($target)
            {
                if($target->status === 'cancel' || in_array($target->closedReason, array('cancel', 'willnotdo', 'wontfix'), true))
                {
                    $link->reviewReason = 'canceled';
                }
                elseif(in_array($target->status, array('active', 'doing', 'wait'), true))
                {
                    $actionType = isset($target->branch) ? 'story' : $link->targetType;
                    $activated = $this->dao->select('id')->from(TABLE_ACTION)->where('objectType')->eq($actionType)
                        ->andWhere('objectID')->eq($target->id)->andWhere('action')->eq('activated')
                        ->andWhere('date')->ge($link->createdDate)->limit(1)->fetch();
                    if($activated) $link->reviewReason = 'reopened';
                }
            }
            $link->branchStages = array();
            if($target && isset($target->branch) && $branches)
            {
                $stages = $this->dao->select('branch,stage')->from(TABLE_STORYSTAGE)->where('story')->eq($target->id)
                    ->andWhere('branch')->in($branches)->fetchPairs();
                foreach($branches as $branch)
                {
                    /* ZenTao stores a single-branch demand's stage directly on the demand. */
                    $singleBranch = (int)$target->branch > 0 && (int)$target->branch === $branch;
                    $link->branchStages[$branch] = $stages[$branch] ?? ($singleBranch ? $target->stage : '');
                }
            }
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

    public function conversionContent(object $feedback): array
    {
        $revision = $this->revisions($feedback)[0] ?? $feedback;
        $rich = isset($this->richTextVersions((int)$feedback->id)[(int)($revision === $feedback ? 1 : $revision->version)]);
        $format = static fn(string $value): string => $rich
            ? strip_tags($value, '<p><br><strong><b><em><i><u><s><ul><ol><li><blockquote><pre><code><h1><h2><h3><h4><hr>')
            : nl2br(htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'));
        $attributes = $this->attributes((int)$feedback->id);
        return array($revision->title, $format($revision->description), $format($attributes['acceptance']), $attributes);
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

    private function recordConversion(string $operation, string $type, int $product, array $sources, int $execution = 0): void
    {
        $table = $this->config->db->prefix . 'reqintakeConversionDetails';
        $insert = $this->dbh->prepare("INSERT INTO `$table` (operation,targetType,product,execution,sources,actor,createdDate) VALUES (?,?,?,?,?,?,?)");
        $insert->execute([$operation, $type, $product, $execution, json_encode((object)$sources, JSON_THROW_ON_ERROR), $this->app->user->account, helper::now()]);
    }

    public function convertToTask(string $token, int $execution, callable $create): int|false
    {
        $feedback = $this->conversionSource($token, 'task');
        if(!isset($this->taskExecutions((int)$feedback->product)[$execution])) throw new DomainException('linkTarget');

        /* Native task creation commits the transaction opened by task::create. The reservation
           becomes durable in that same commit, even if the native call never returns an ID. */
        $sources = array((int)$feedback->id => $feedback->version);
        $operation = hash('sha256', "task:$feedback->id:$feedback->version");
        $table = $this->config->db->prefix . 'reqintakeConversion';
        $reserve = $this->dbh->prepare("INSERT IGNORE INTO `$table` (operation) VALUES (?)");
        $reserve->execute([$operation]);
        if($reserve->rowCount() === 1)
        {
            $product = $this->conversionProduct($sources, 'task', true);
            $this->recordConversion($operation, 'task', $product, $sources, $execution);
            $id = $create();
            if(!$id) return false;

            /* Save the exact ID before attempting linkage so a retry can finish the same task. */
            $save = $this->dbh->prepare("UPDATE `$table` SET target = ? WHERE operation = ?");
            $save->execute([$id, $operation]);
        }
        else
        {
            $lock = $this->dbh->prepare("SELECT target FROM `$table` WHERE operation = ? FOR SHARE");
            $lock->execute([$operation]);
            $recorded = $lock->fetchColumn();
            $lock->closeCursor();
            if(!(int)$recorded) throw new DomainException('taskConversionUncertain');
            $id = (int)$recorded;
            unset($_POST['fileList']);
        }

        $target = $this->targetForProduct('task', $id, (int)$feedback->product);
        if(!$target || (int)$target->execution !== $execution) throw new DomainException('linkTarget');
        $this->linkTargets($sources, $id, '', 'task', created: true);
        if($this->dbh->inTransaction()) $this->dbh->commit();
        return $id;
    }

    public function prepareBatchConversion(string $id, array $sources, string $type, array $scopes): string
    {
        if(in_array($type, array('bug', 'task'), true)) throw new DomainException('linkTarget');
        if(!$sources) throw new DomainException('batchSelection');
        foreach($scopes as $scope) if(mb_strlen($scope) > 500) throw new InvalidArgumentException('linkScope');
        $product = $this->conversionProduct($sources, $type, true);
        ksort($sources, SORT_NUMERIC);
        ksort($scopes, SORT_NUMERIC);
        $operation = hash_hmac('sha256', json_encode(array($id, $this->app->user->account, $type, $sources, $scopes), JSON_THROW_ON_ERROR), $this->session->reqintakeFormKey);
        $operations = (array)$this->session->reqintakeBatchConversions;
        $operations[$operation] = array('sources' => $sources, 'scope' => $scopes, 'type' => $type, 'account' => $this->app->user->account);
        $this->session->set('reqintakeBatchConversions', array_slice($operations, -32, null, true));
        $token = 'batch.' . $operation;
        return helper::createLink($type, 'create', "productID=$product&branch=&moduleID=0&storyID=0&objectID=0&bugID=0&planID=0&todoID=0&extra=riOperation=$token&storyType=$type");
    }

    public function batchConversion(string $token, string $type): array
    {
        $operation = substr($token, 6);
        $batch = $this->session->reqintakeBatchConversions[$operation] ?? null;
        if(!$batch || $batch['type'] !== $type || $batch['account'] !== $this->app->user->account) throw new DomainException('batchSelection');
        $batch['product'] = $this->conversionProduct($batch['sources'], $type);
        return $batch;
    }

    public function commonBatchFields(array $sources): array
    {
        $rows = $this->dao->select('feedback,category,priority')->from($this->config->db->prefix . 'reqintakeAttributes')
            ->where('feedback')->in(array_keys($sources))->orderBy('version_desc')->fetchAll();
        $latest = array();
        foreach($rows as $row) $latest[$row->feedback] ??= $row;

        $common = array();
        $defaults = $this->attributeDefaults();
        $options = $this->attributeOptions();
        foreach(array('category', 'priority') as $field)
        {
            $values = array_unique(array_map(static fn($id) => (string)($latest[$id]->$field ?? $defaults[$field]), array_keys($sources)));
            if(count($values) === 1 && isset($options[$field][$values[0]])) $common[$field] = $values[0];
        }
        return $common;
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
        $legacyOperation = substr($token, strrpos($token, '.') + 1);
        $operation = $legacyOperation;
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
            $operation = hash('sha256', "$type:$feedback->id:$feedback->version");
        }
        $product = $this->conversionProduct($sources, $type);
        if($product !== $targetProduct) throw new DomainException('linkTarget');

        $table = $this->config->db->prefix . 'reqintakeConversion';
        $this->dbh->beginTransaction();
        try
        {
            $insert = $this->dbh->prepare("INSERT INTO `$table` (operation) VALUES (?) ON DUPLICATE KEY UPDATE operation = operation");
            $insert->execute([$operation]);
            $read = $this->dbh->prepare("SELECT target FROM `$table` WHERE operation = ? FOR UPDATE");
            $read->execute([$operation]);
            $id = (int)$read->fetchColumn();
            $read->closeCursor();
            if(!$id && $legacyOperation !== $operation)
            {
                $legacy = $this->dbh->prepare("SELECT target FROM `$table` WHERE operation = ?");
                $legacy->execute([$legacyOperation]);
                $id = (int)$legacy->fetchColumn();
                $legacy->closeCursor();
                if($id)
                {
                    $update = $this->dbh->prepare("UPDATE `$table` SET target = ? WHERE operation = ?");
                    $update->execute([$id, $operation]);
                }
            }
            if($id)
            {
                if(!$this->targetForProduct($type, $id, $product)) throw new DomainException('linkTarget');
                unset($_POST["fileList"]);
                $this->dbh->commit();
                return $id;
            }

            $this->conversionProduct($sources, $type, true);
            $this->recordConversion($operation, $type, $product, $sources);

            $id = $create();
            if(!$id || dao::isError())
            {
                $this->dbh->rollBack();
                return false;
            }

            $this->linkTargets($sources, $id, $scope, $type, created: true);
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

    public function linkTargets(array $sources, int $targetID, string|array $scope, string $type, bool $created = false): void
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

        $scopes = is_array($scope) ? $scope : array_fill_keys(array_keys($sources), trim($scope));
        foreach($sources as $feedbackID => $version)
        {
            if(!isset($scopes[$feedbackID]) || mb_strlen($scopes[$feedbackID]) > 500) throw new InvalidArgumentException('linkScope');
        }
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

                $query = $this->dbh->prepare("SELECT scope FROM `{$prefix}reqintakeLink` WHERE feedback = ? AND targetType = ? AND target = ? FOR UPDATE");
                $query->execute([$feedbackID, $type, $targetID]);
                $existing = $query->fetchColumn();
                if($existing !== false)
                {
                    if($existing !== $scopes[$feedbackID]) throw new DomainException('linkScope');
                    continue;
                }

                $now = helper::now();
                $query = $this->dbh->prepare("UPDATE `{$prefix}reqintakeFeedback` SET status = 'tracking', version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status IN ('pending','tracking')");
                $query->execute([$now, $feedbackID, $version]);
                if($query->rowCount() !== 1) throw new DomainException('staleFeedback');

                $query = $this->dbh->prepare("INSERT INTO `{$prefix}reqintakeLink` (feedback,targetType,target,scope,createdBy,createdDate) VALUES (?,?,?,?,?,?)");
                $query->execute([$feedbackID, $type, $targetID, $scopes[$feedbackID], $this->app->user->account, $now]);

                $query = $this->dbh->prepare("INSERT INTO `{$prefix}reqintakeLinkMethod` (feedback,targetType,target,method) VALUES (?,?,?,?)");
                $query->execute([$feedbackID, $type, $targetID, $created ? 'created' : 'linked']);
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
        $query = $this->dao->select('h.feedback,h.actor,h.action,h.reason,h.createdDate,c.outcome')
            ->from($this->config->db->prefix . 'reqintakeHistory')->alias('h')
            ->innerJoin($this->config->db->prefix . 'reqintakeFeedback')->alias('f')->on('h.feedback = f.id')
            ->innerJoin(TABLE_PRODUCT)->alias('p')->on('p.id = f.product')
            ->leftJoin($this->config->db->prefix . 'reqintakeClosure')->alias('c')->on('c.feedback = h.feedback AND c.version = h.version')
            ->where('p.deleted')->eq('0')->andWhere('h.feedback')->in($ids);
        if(empty($this->app->user->admin)) $query->andWhere('f.product')->in($this->visibleProducts() ?: array(0));
        $history = $query->orderBy('h.feedback,h.version_desc')->fetchAll();

        $grouped = array();
        foreach($history as $entry) $grouped[$entry->feedback][] = $entry;
        return $grouped;
    }

    public function duplicateOriginal(object $feedback): object|false
    {
        $row = $this->dao->select('original')->from($this->config->db->prefix . 'reqintakeDuplicate')
            ->where('feedback')->eq((int)$feedback->id)->orderBy('version_desc')->limit(1)->fetch();
        return $row ? $this->findFeedback((int)$row->original) : false;
    }

    public function transition(int $id, int $version, string $action, string $reason, int $original = 0, string $outcome = '', bool $verified = false, ?array $reply = null): void
    {
        if(!$this->canAccess('index')) throw new DomainException('product');

        $table = $this->config->db->prefix . 'reqintakeFeedback';
        $feedback = $this->dao->select('product,status,assignedTo,assignmentPending')->from($table)->where('id')->eq($id)->fetch();
        if(!$feedback || !$this->canReadProduct((int)$feedback->product)) throw new DomainException('product');

        if(empty($this->app->user->admin) && ($feedback->assignedTo !== $this->app->user->account || $feedback->assignmentPending)) throw new DomainException('handler');

        $next = match($action)
        {
            'start', 'accept' => $feedback->status === 'pending' ? 'tracking' : null,
            'close'  => in_array($feedback->status, array('pending', 'tracking'), true) ? 'closed' : null,
            'reopen' => $feedback->status === 'closed' ? 'tracking' : null,
            default  => null,
        };
        if($next === null) throw new DomainException('staleFeedback');

        $reason = trim($reason);
        if(($action !== 'start' && $reason === '') || mb_strlen($reason) > 500) throw new DomainException('transitionReason');

        if($original)
        {
            $target = $this->findFeedback($original);
            if($action !== 'close' || !$target || $original === $id || (int)$target->product !== (int)$feedback->product)
                throw new DomainException('duplicateTarget');
        }

        if($action === 'close')
        {
            $outcome = $original ? 'duplicate' : ($outcome ?: 'other');
            if(!in_array($outcome, array('confirmed', 'withdrawn', 'declined', 'other', 'duplicate'), true)
                || ($outcome === 'duplicate' && !$original)) throw new InvalidArgumentException('closeOutcome');
            if($outcome === 'confirmed' && !$verified) throw new InvalidArgumentException('closeVerification');
        }

        $history = $this->config->db->prefix . 'reqintakeHistory';
        $now = helper::now();
        $this->dbh->beginTransaction();
        try
        {
            if($original) $this->recordDuplicate((int)$feedback->product, $id, $version + 1, $original);

            $query = $this->dbh->prepare("UPDATE `$table` SET status = ?, version = version + 1, updatedDate = ? WHERE id = ? AND version = ? AND status = ?");
            $query->execute([$next, $now, $id, $version, $feedback->status]);
            if($query->rowCount() !== 1) throw new DomainException('staleFeedback');

            $query = $this->dbh->prepare("INSERT INTO `$history` (feedback, version, actor, action, reason, createdDate) VALUES (?, ?, ?, ?, ?, ?)");
            $query->execute([$id, $version + 1, $this->app->user->account, $action, $reason, $now]);
            if($action === 'close')
            {
                $closure = $this->config->db->prefix . 'reqintakeClosure';
                $query = $this->dbh->prepare("INSERT INTO `$closure` (feedback,version,outcome) VALUES (?,?,?)");
                $query->execute([$id, $version + 1, $outcome]);
                if($reply !== null) $this->insertHandling($id, $version + 1, 'reply', $reply[0], $reply[1], $reply[2], $now);
            }
            $this->dbh->commit();
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }

    private function recordDuplicate(int $product, int $feedback, int $version, int $original): void
    {
        /* Serialize duplicate changes in the product so simultaneous links cannot form a cycle. */
        $productTable = TABLE_PRODUCT;
        $lock = $this->dbh->prepare("SELECT id FROM $productTable WHERE id = ? AND deleted = '0' FOR UPDATE");
        $lock->execute([$product]);
        if(!$lock->fetchColumn()) throw new DomainException('duplicateTarget');
        $lock->closeCursor();

        $table = $this->config->db->prefix . 'reqintakeDuplicate';
        $read = $this->dbh->prepare("SELECT original FROM `$table` WHERE feedback = ? ORDER BY version DESC LIMIT 1 FOR UPDATE");
        $seen = array($feedback => true);
        for($id = $original; $id; )
        {
            if(isset($seen[$id])) throw new DomainException('duplicateTarget');
            $seen[$id] = true;
            $read->execute([$id]);
            $id = (int)$read->fetchColumn();
            $read->closeCursor();
        }

        $this->dbh->prepare("INSERT INTO `$table` (feedback,version,original) VALUES (?,?,?)")->execute([$feedback, $version, $original]);
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

    public function receive(int $product, string $operation, string $title, string $description, string $customer = '', string $channel = '', array $attributes = array(), bool $rich = false, ?array $upload = null): int
    {
        $account = $this->app->user->account ?? '';
        if(!$this->canAccess('index') || !$this->canReadProduct($product)) throw new DomainException('product');

        $title = trim($title);
        if(!preg_match('/\A[a-f0-9]{32}\z/', $operation)) throw new InvalidArgumentException('operation');
        if($title === '' || mb_strlen($title) > 255) throw new InvalidArgumentException('title');
        if($rich)
        {
            $description = $this->cleanRichText($description);
            $attributes['acceptance'] = $this->cleanRichText($attributes['acceptance'] ?? '');
        }
        if((trim($rich ? html_entity_decode(strip_tags($description)) : $description) === '' && (!$rich || !str_contains($description, '<img '))) || strlen($description) > 16777215) throw new InvalidArgumentException('description');
        if(mb_strlen($customer) > 255 || mb_strlen($channel) > 64) throw new InvalidArgumentException('source');

        $attributes = $this->validatedAttributes($product, $attributes + $this->attributeDefaults());
        $attachment = $upload && ($upload['error'] ?? null) !== UPLOAD_ERR_NO_FILE ? $this->readAttachment($upload) : null;
        $fingerprint = $attachment ? hash('sha256', implode(chr(0), $attachment)) : '';
        $attachmentTable = $this->config->db->prefix . 'reqintakeInitialAttachment';
        [$assignee, $pending] = $this->resolveAssignee($product);
        $table = $this->config->db->prefix . 'reqintakeFeedback';
        $now = helper::now();

        $this->dbh->beginTransaction();
        try
        {
            /* The unique submission key handles simultaneous retries in the database. */
            $query = $this->dbh->prepare("INSERT INTO `$table`
                (operation, product, title, description, customer, channel, openedBy, assignedTo, assignmentPending, openedDate, updatedDate)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ON DUPLICATE KEY UPDATE id = id");
            $query->execute([$operation, $product, $title, $description, $customer, $channel, $account, $assignee, $pending, $now, $now]);

            $created = $query->rowCount() === 1;
            $saved = $this->dao->select('*')->from($table)
                ->where('openedBy')->eq($account)->andWhere('operation')->eq($operation)->fetch();
            if(!$saved || (int)$saved->product !== $product || $saved->title !== $title
                || $saved->description !== $description || $saved->customer !== $customer || $saved->channel !== $channel)
            {
                throw new DomainException('submissionConflict');
            }

            $id = (int)$saved->id;
            if($created)
            {
                $this->saveAttributes($id, 1, $attributes);
                if($rich) $this->saveRichTextVersion($id, 1);
                if($attachment)
                {
                    $this->insertAttachment($id, ...$attachment);
                    $this->dbh->prepare("INSERT INTO `$attachmentTable` (feedback,fingerprint) VALUES (?,?)")->execute([$id, $fingerprint]);
                }
            }
            if(!$created)
            {
                $original = $this->dao->select('fingerprint')->from($attachmentTable)->where('feedback')->eq($id)->fetch();
                if(($original->fingerprint ?? '') !== $fingerprint) throw new DomainException('submissionConflict');
            }
            if((bool)isset($this->richTextVersions($id)[1]) !== $rich) throw new DomainException('submissionConflict');
            if($this->attributes($id, 1) !== $attributes) throw new DomainException('submissionConflict');
            $this->dbh->commit();
            return $id;
        }
        catch(Throwable $error)
        {
            if($this->dbh->inTransaction()) $this->dbh->rollBack();
            throw $error;
        }
    }
}
