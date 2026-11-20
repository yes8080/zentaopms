<?php
/**
 * The model file of provider module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yang Li <liyang@chandao.com>
 * @package     provider
 * @link        https://www.zentao.net
 */
class providerModel extends model
{
    /** Return a database envelope. Jenkins v1 remains compatible with existing encrypted records. */
    public static function encryptToken(object $provider, string $plain): string
    {
        if($plain === '') return '';
        $jenkins = $provider->type === 'Jenkins';
        $key = commonModel::integrationKey($jenkins ? 'zentao-jenkins-provider-v1' : 'zentao-provider-token-v2');
        if($key === '') throw new RuntimeException('Missing integration key.');

        $aad = $jenkins ? $provider->url : $provider->type . "\0" . $provider->url;
        $iv  = random_bytes(12);
        $cipher = openssl_encrypt($plain, 'aes-256-gcm', $key, OPENSSL_RAW_DATA, $iv, $tag, $aad);
        if($cipher === false) throw new RuntimeException('Provider encryption failed.');
        return ($jenkins ? 'gcm1:' : 'gcm2:') . base64_encode($iv . $tag . $cipher);
    }

    /** Return the verified credential, or an empty string for missing, legacy or damaged data. */
    public static function decryptToken(object $provider): string
    {
        $jenkins = $provider->type === 'Jenkins';
        if(!str_starts_with((string)$provider->token, $jenkins ? 'gcm1:' : 'gcm2:')) return '';
        $key = commonModel::integrationKey($jenkins ? 'zentao-jenkins-provider-v1' : 'zentao-provider-token-v2');
        $raw = base64_decode(substr($provider->token, 5), true);
        if($key === '' || $raw === false || strlen($raw) <= 28) return '';
        $aad = $jenkins ? $provider->url : $provider->type . "\0" . $provider->url;
        $plain = openssl_decrypt(substr($raw, 28), 'aes-256-gcm', $key, OPENSSL_RAW_DATA, substr($raw, 0, 12), substr($raw, 12, 16), $aad);
        return $plain === false ? '' : $plain;
    }

    private function sealFormToken(object $provider): bool
    {
        $plain = (string)($provider->token ?? '');
        if($provider->type === 'Jenkins') $plain = (string)base64_decode($plain, true);
        try
        {
            $provider->token = self::encryptToken($provider, $plain);
            /* Older installations have a shorter column and may run MySQL without strict mode. */
            if(strlen($provider->token) > 255)
            {
                $limit = $this->dbh->query("SELECT CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ops_provider' AND COLUMN_NAME = 'token'")->fetchColumn();
                if(strlen($provider->token) > (int)$limit)
                {
                    dao::$errors['token'] = $this->lang->provider->credentialTooLong;
                    return false;
                }
            }
            return true;
        }
        catch(RuntimeException $e)
        {
            dao::$errors['token'] = $this->lang->provider->integrationKeyRequired;
            return false;
        }
    }

    /**
     * 创建一个服务。
     * Create a provider.
     *
     * @param  object $formData
     * @access public
     * @return int
     */
    public function create(object $formData): int|false
    {
        if(!$this->sealFormToken($formData)) return false;
        $this->dao->insert(TABLE_PROVIDER)->data($formData)
            ->batchCheck($this->config->provider->create->requiredFields, 'notempty')
            ->autoCheck()
            ->exec();
        if(dao::isError()) return false;

        return $this->dao->lastInsertID();
    }

    /**
     * 更新一个服务。
     * Update a provider.
     *
     * @param  int $id
     * @param  object $formData
     * @access public
     * @return bool
     */
    public function update(int $id, object $formData): bool
    {
        $old = $this->fetchByID($id);
        if(!$old) return false;
        $formData->type = $old->type;
        if(!$this->sealFormToken($formData)) return false;
        $this->dao->update(TABLE_PROVIDER)->data($formData)
            ->autoCheck()
            ->batchCheck($this->config->provider->edit->requiredFields, 'notempty')
            ->where('id')->eq($id)
            ->exec();

        return !dao::isError();
    }

    /**
     * 获取服务列表。
     * Get provider list.
     *
     * @param  string $orderBy
     * @param  ?object $pager
     * @access public
     * @return array
     */
    public function getList(string $orderBy = 'id_desc', ?object $pager = null): array
    {
        return $this->dao->select('id,type,name,url,createdBy,createdDate,editedBy,editedDate,deleted')->from(TABLE_PROVIDER)
            ->where('deleted')->eq(0)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
    }

    /**
     * 根据ID获取服务。
     * Get provider by id.
     *
     * @param  int    $id
     * @access public
     * @return object|false
     */
    public function getByID(int $id): object|false
    {
        $provider = $this->fetchByID($id);
        if(empty($provider)) return false;

        $plain = self::decryptToken($provider);
        if($provider->type == 'Jenkins')
        {
            list($account, $token) = array_pad(explode(':', $plain, 2), 2, '');
            $provider->account = $account;
            $provider->token   = $token;
        }
        else
        {
            $provider->account = zget($provider, 'account', '');
            $provider->token = $plain;
        }

        return $provider;
    }

    /**
     * 获取服务键值对。
     * Get provider pairs.
     *
     * @param  string $type
     * @access public
     * @return array
     */
    public function getPairs(string $type = ''): array
    {
        return $this->dao->select('*')->from(TABLE_PROVIDER)
            ->where('deleted')->eq(0)
            ->beginIF($type)->andWhere('type')->eq($type)->fi()
            ->orderBy('id_desc')
            ->fetchPairs('id', 'name');
    }

    /**
     * 根据ID获取服务接口地址。
     * Get api root by id.
     *
     * @param  object $provider
     * @access public
     * @return string|object
     */
    public function getApiRoot(object $provider): string|object
    {
        if(empty($provider->type)) return '';

        $roots = array('GitLab' => '/api/v4%s', 'Gitea' => '/api/v1%s', 'Gogs' => '/api/v1%s', 'GitHub' => '%s');
        if(!isset($roots[$provider->type]) || empty($provider->token)) return '';
        $auth = match($provider->type)
        {
            'GitLab' => 'PRIVATE-TOKEN: ',
            'GitHub' => 'Authorization: Bearer ',
            default  => 'Authorization: token ',
        };
        return (object)array('url' => rtrim($provider->url, '/') . $roots[$provider->type], 'header' => array($auth . $provider->token));
    }

    /**
     * 根据ID获取代码库。
     * Get repos by id.
     *
     * @param  int  $providerID
     * @param  bool $showMirrors
     * @access public
     * @return array
     */
    public function getReposByProviderID(int $providerID, bool $showMirrors = false): array
    {
        return $this->dao->select('*')->from(TABLE_REPO)
            ->where('`providerID`')->eq($providerID)
            ->andWhere('deleted')->eq(0)
            ->beginIF($showMirrors)->andWhere('mirror')->eq(1)->fi()
            ->fetchAll('id');
    }

    /**
     * 迁移服务信息，从 pipeline 到 ops_provider。
     * Migrate service info from pipeline to ops_provider.
     *
     * @access public
     * @return bool
     */
    public function migratePipelineProviders(): bool
    {
        $typeMap = array(
            'gitlab'     => 'GitLab',
            'gitea'      => 'Gitea',
            'gogs'       => 'Gogs',
            'subversion' => 'Subversion',
            'github'     => 'GitHub',
            'jenkins'    => 'Jenkins'
        );

        $excludeTypes = array('gitfox', 'sonarqube');
        $pipelines = $this->dao->select('*')
            ->from('`' . $this->config->db->prefix . 'pipeline`')
            ->where('deleted')->eq('0')
            ->fetchAll();

        foreach($pipelines as $pipeline)
        {
            $typeKey = strtolower(trim((string)$pipeline->type));
            if(in_array($typeKey, $excludeTypes, true)) continue;
            if(!isset($typeMap[$typeKey])) continue;

            $provider       = new stdclass();
            $provider->id   = (int)$pipeline->id;
            $provider->type = $typeMap[$typeKey];
            $provider->name = (string)$pipeline->name;
            $provider->url  = (string)$pipeline->url;

            if($provider->type == 'Jenkins')
            {
                $provider->token = base64_encode(((string)$pipeline->account) . ':' . ((string)$pipeline->token));
            }
            else
            {
                $provider->token = (string)$pipeline->token;
            }

            if(!$this->sealFormToken($provider)) return false;

            $provider->createdBy   = (string)$pipeline->createdBy;
            $provider->createdDate = empty($pipeline->createdDate) ? helper::now() : $pipeline->createdDate;
            $provider->editedBy    = (string)$pipeline->editedBy;
            $provider->editedDate  = empty($pipeline->editedDate) ? null : $pipeline->editedDate;
            $provider->deleted     = '0';

            $this->dao->insert(TABLE_PROVIDER)->data($provider)->exec();
            if(dao::isError()) return false;
        }

        return !dao::isError();
    }
}
