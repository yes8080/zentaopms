<?php
/**
 * The control file of client module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Gang Liu <liugang@cnezsoft.com>
 * @package     client
 * @version     $Id$
 * @link        https://xuanim.com
 */
class client extends control
{
    /**
     * Index page.
     *
     * @access public
     * @return void
     */
    public function index()
    {
        $blocks = $this->loadModel('block')->getBlockList('xxb');

        /* Init block when vist index first. */
        if(empty($blocks))
        {
            if($this->loadModel('block')->initBlock('xxb')) die(js::reload());
        }

        foreach($blocks as $key => $block)
        {
            $block->params = json_decode($block->params);
            if(empty($block->params)) $block->params = new stdclass();

            $sign = $this->config->requestType == 'PATH_INFO' ? '?' : '&';
            $block->blockLink = $this->createLink('block', 'print' . $block->block . 'block', "index={$block->id}");
        }

        $this->view->title          = $this->lang->client->common;
        $this->view->blocks         = $blocks;
        $this->view->currentVersion = $this->client->getCurrentVersion();
        $this->view->versionApiUrl  = sprintf($this->config->client->upgradeApi, '');
        $this->display();
    }

    /**
     * Browse client list.
     *
     * @access public
     * @return void
     */
    public function browse()
    {
        $this->view->title   = $this->lang->client->pageTitle;
        $this->view->clients = $this->client->getList();
        $this->display();
    }

    /**
     * Create a client.
     *
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $this->client->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title = $this->lang->client->create;
        $this->display();
    }

    /**
     * Download remote package.
     * @param string $version
     * @param string $link
     * @param string $os
     * @return string
     */
    public function download($version = '', $link = '', $os = '')
    {
        set_time_limit(0);
        $result = $this->client->downloadZipPackage($version, $link);
        if($result == false) $this->send(array('result' => 'fail', 'message' => $this->lang->client->downloadFail));
        $client = $this->client->edit($version, $result, $os);
        if($client == false) $this->send(array('result' => 'fail', 'message' => $this->lang->client->saveClientError));
        $this->send(array('result' => 'success', 'client' => $client, 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
    }

    /**
     * Edit a version.
     *
     * @param  int    $clientID
     * @access public
     * @return void
     */
    public function edit($clientID)
    {
        if($_POST)
        {
            $this->client->update($clientID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
        }

        $this->view->title  = $this->lang->client->edit;
        $this->view->client = $this->client->getByID($clientID);
        $this->display();
    }

    /**
     * View changelog of a client update
     *
     * @param  int    $clientID
     * @access public
     * @return void
     */
    public function changelog($clientID)
    {
        $client             = $this->client->getByID($clientID);
        $this->view->client = $client;
        $this->view->title  = $this->lang->client->changeLog . ' ' . $client->version;
        $this->display();
    }

    /**
     * Delete a client.
     *
     * @param  int    $clientID
     * @access public
     * @return void
     */
    public function delete($clientID)
    {
        $this->dao->delete()->from(TABLE_IM_CLIENT)->where('id')->eq($clientID)->exec();
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

        $this->send(array('result' => 'success'));
    }

    /**
     * Check upgrade.
     *
     * @access public
     * @return void
     */
    public function checkUpgrade()
    {
        $currentVersion = $this->client->getCurrentVersion();
        $apiUrl         = sprintf($this->config->client->upgradeApi, "-$currentVersion->version");
        $jsonData       = $this->client->fetchUrl($apiUrl);
        $serverVersions = json_decode($jsonData, false);

        $this->view->title          = $this->lang->client->checkUpgrade;
        $this->view->serverVersions = $serverVersions;
        $this->view->versions       = $serverVersions;
        $this->view->currentVersion = $currentVersion;
        $this->view->path           = $this->app->dataRoot;
        $this->display();
    }

    /**
     * Download xuan client.
     *
     * @access public
     * @param  string $action
     * @param  string $os
     * @return void
     */
    public function downloadClient($action = 'check', $os = '')
    {
        if($_POST)
        {
            $os = $this->post->os;
            die(js::locate($this->createLink('client', 'downloadClient', "action=getPackage&os=$os"), 'self'));
        }

        if($action == 'check')
        {
            $error     = false;
            $errorInfo = '';

            $clientDir = $this->app->wwwRoot . 'data/client/' . $this->config->xuanxuan->version . '/';
            if(!is_dir($clientDir))
            {
                $result = mkdir($clientDir, 0755, true);
                if($result == false)
                {
                    $error = true;
                    $errorInfo = sprintf($this->lang->client->errorInfo->dirNotExist, $clientDir, $clientDir);
                }
            }

            if(!is_writable($clientDir))
            {
                $error = true;
                $errorInfo = sprintf($this->lang->client->errorInfo->dirNotWritable, $clientDir, $clientDir);
            }

            $this->view->error     = $error;
            $this->view->errorInfo = $errorInfo;

            if(!$error) die(js::locate($this->createLink('client', 'downloadClient', "action=selectPackage")));
        }

        if($action == 'selectPackage')
        {
            $os = 'win64';
            $agentOS = helper::getOS();
            if(strpos($agentOS, 'Windows') !== false) $os = 'win64';
            if(strpos($agentOS, 'Linux') !== false)   $os = 'linux64';
            if(strpos($agentOS, 'Mac') !== false)     $os = 'mac';

            $this->view->os = $os;
        }

        if($action == 'getPackage')
        {
            $this->view->os      = $os;
            $this->view->account = $this->app->user->account;
        }

        if($action == 'clearTmpPackage')
        {
            $account = $this->app->user->account;
            $tmpDir  = $this->app->wwwRoot . 'data/client/' . "$account/";

            if(is_dir($tmpDir))
            {
                $zfile = $this->app->loadClass('zfile');
                $zfile->removeDir($tmpDir);
            }
        }

        if($action == 'downloadPackage')
        {
            $account   = $this->app->user->account;
            $clientDir = $this->app->wwwRoot . 'data/client/' . "$account/";

            $clientFile = $clientDir . 'xuanxuan.zip';
            $zipContent = file_get_contents($clientFile);
            if(is_dir($clientDir))
            {
                $zfile = $this->app->loadClass('zfile');
                $zfile->removeDir($clientDir);
            }

            $output = $this->fetch('file', 'sendDownHeader', array('fileName' => "xuanxuan." . $os . '.zip', 'zip', $zipContent));
        }

        $this->view->action = $action;
        $this->display();
    }

    /**
     * Upload client file (modal form, iframe from block).
     *
     * @access public
     * @return void
     */
    public function uploadClient()
    {
        $version   = $this->config->xuanxuan->version;
        $clientDir = $this->app->wwwRoot . sprintf($this->config->client->commonDirPattern, $version);
        $writable  = is_dir($clientDir) && is_writable($clientDir);

        $writableTip = '';

        /* 如果目录不存在，尝试创建目录。*/
        if(!is_dir($clientDir))
        {
            if(!@mkdir($clientDir, 0777, true))
            {
                $writable   = false;
                $writableTip = sprintf($this->lang->client->errorInfo->dirNotExist, $clientDir, $clientDir);
            }
            else
            {
                $writable = is_writable($clientDir);
            }
        }
        
        if(!$writable)
        {
            $writableTip = sprintf($this->lang->client->errorInfo->dirNotWritable, $clientDir, $clientDir);
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(!$writable) $this->send(array('result' => 'fail', 'message' => $writableTip));
            
            $os = $this->post->os;
            if(empty($os) || !isset($this->config->client->downloadList[$os]))
            {
                $this->send(array('result' => 'fail', 'message' => $this->lang->client->uploadClientInvalidOS));
            }
            
            if(empty($_FILES['file']['tmp_name']))
            {
                $this->send(array('result' => 'fail', 'message' => $this->lang->client->uploadClientFileRequired));
            }
            
            $tmpName  = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            
            if($_FILES['file']['error'] !== UPLOAD_ERR_OK)
            {
                $this->send(array('result' => 'fail', 'message' => $fileName . ': ' . $this->lang->client->uploadClientFileError));
            }
            
            $expectedFileName = sprintf($this->config->client->downloadList[$os], $version);
            $fileNamePattern  = '/^' . str_replace('%s', '(.+?)', preg_quote($this->config->client->downloadList[$os], '/')) . '$/';
            if(!preg_match($fileNamePattern, $fileName, $matches)) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->client->uploadClientFileNameError, $expectedFileName, $fileName)));

            $uploadVersion = $matches[1];
            if($uploadVersion !== $version) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->client->uploadClientFileVersionError, $version, $uploadVersion)));

            $expectedExt      = strtolower(pathinfo($expectedFileName, PATHINFO_EXTENSION));
            $uploadExt        = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            
            if($uploadExt !== $expectedExt)
            {
                $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->client->uploadClientFileExtError, $expectedExt, $uploadExt)));
            }
            
            $destPath = $clientDir . $expectedFileName;
            if(move_uploaded_file($tmpName, $destPath))
            {
                $this->send(array('result' => 'success', 'message' => $this->lang->client->uploadClientUploadSuccess, 'os' => $os, 'fileName' => $expectedFileName));
            }
            else
            {
                $this->send(array('result' => 'fail', 'message' => $this->lang->client->uploadClientUploadFail));
            }
        }

        $fileStatus = array();
        $osList = array_keys($this->config->client->downloadList);
        foreach($osList as $os)
        {
            $fileName = sprintf($this->config->client->downloadList[$os], $version);
            $filePath = $clientDir . $fileName;
            $fileStatus[$os] = array(
                'exists' => file_exists($filePath),
                'fileName' => $fileName,
                'label' => isset($this->lang->client->osList[$os]) ? $this->lang->client->osList[$os] : $os
            );
        }

        $this->view->writable    = $writable;
        $this->view->writableTip = $writableTip;
        $this->view->fileStatus  = $fileStatus;
        $this->view->version     = $version;
        $this->view->title       = $this->lang->client->uploadClient;
        $this->display();
    }

    /**
     * Ajax get client package.
     *
     * @param  string $os
     * @access public
     * @return void
     */
    public function ajaxGetClientPackage($os = '')
    {
        set_time_limit (0);
        session_write_close();

        $response = array();
        $response['result']  = 'success';
        $response['message'] = '';

        $version   = $this->config->xuanxuan->version;
        $clientDir = $this->app->wwwRoot . $this->config->client->dataRoot;
        if(!is_dir($clientDir)) mkdir($clientDir, 0755, true);

        $packageDir = $this->app->wwwRoot . sprintf($this->config->client->commonDirPattern, $version);
        if(!is_dir($packageDir)) mkdir($packageDir, 0755, true);

        $account = $this->app->user->account;
        $tmpDir = $clientDir . "/$account/";
        if(!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

        $clientName  = sprintf($this->config->client->downloadList[$os], $version);
        $packageFile = $packageDir . $clientName;
        $packageURL  = "{$this->config->client->downloadLinkPrefix}$version/$clientName";

        $clientFile = $tmpDir . $clientName;

        if(file_exists($packageFile))
        {
            if(!@copy($packageFile, $clientFile))
            {
                $response['result']  = 'fail';
                $response['message'] = sprintf($this->lang->client->errorInfo->manualOpt, $packageURL);
            }
            $this->send($response);
        }

        if(!function_exists('curl_init'))
        {
            $response['result']  = 'fail';
            $response['message'] = $this->lang->error->noCurlExt;
            $this->send($response);
        }

        $tmpPath   = $packageFile . '.downloading';
        $fp        = @fopen($tmpPath, 'wb');
        if(!$fp)
        {
            $response['result']  = 'fail';
            $response['message'] = $this->lang->client->uploadClientDownloadFail;
            $this->send($response);
        }

        $timeoutSeconds = 10;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $packageURL . '?t=' . rand());
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeoutSeconds);
        curl_setopt($ch, CURLOPT_LOW_SPEED_LIMIT, 1);
        curl_setopt($ch, CURLOPT_LOW_SPEED_TIME, $timeoutSeconds);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'XXB/ClientBaseDownloader');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $execOK = curl_exec($ch);
        $errno  = curl_errno($ch);
        $error  = curl_error($ch);
        curl_close($ch);
        fclose($fp);

        if(!$execOK || !file_exists($tmpPath) || filesize($tmpPath) <= 0)
        {
            @unlink($tmpPath);
            $response['result']  = 'fail';
            if($errno == CURLE_OPERATION_TIMEDOUT)
            {
                $response['message'] = $this->lang->client->uploadClientDownloadTimeout;
            }
            else
            {
                $response['message'] = sprintf($this->lang->client->errorInfo->manualOpt, $packageURL);
            }
            $this->send($response);
        }

        /* 下载成功：落到版本缓存，再复制给当前账户目录。 */
        if(!@rename($tmpPath, $packageFile))
        {
            @unlink($tmpPath);
            $response['result']  = 'fail';
            $response['message'] = sprintf($this->lang->client->errorInfo->manualOpt, $packageURL);
            $this->send($response);
        }

        if(!@copy($packageFile, $clientFile))
        {
            $response['result']  = 'fail';
            $response['message'] = sprintf($this->lang->client->errorInfo->manualOpt, $packageURL);
            $this->send($response);
        }

        $this->send($response);
    }

    /**
     * Ajax get client package size.
     *
     * @access public
     * @return void
     */
    public function ajaxGetPackageSize()
    {
        $account     = $this->app->user->account;
        $packageFile = $this->app->wwwRoot . 'data/client/' . $account . '/xuanxuan.zip';

        $size = 0;
        if(file_exists($packageFile))
        {
            $size = filesize($packageFile);
            $size = $size ? round($size / 1048576, 2) : 0;
        }

        $response = array();
        $response['result'] = 'success';
        $response['size'] = $size;

        $this->send($response);
    }

    /**
     * Ajax set client config to client package.
     *
     * @param  string $os
     * @access public
     * @return void
     */
    public function ajaxSetClientConfig($os = '')
    {
        $response['result'] = 'success';

        $account   = $this->app->user->account;
        $clientDir = $this->app->wwwRoot . 'data/client/' . "$account/";
        if(!is_dir($clientDir)) mkdir($clientDir, 0755, true);

        /* write login info into config file. */
        $loginInfo = new stdclass();
        $loginInfo->ui = new stdclass();
        $loginInfo->ui->defaultUser = new stdclass();
        $loginInfo->ui->defaultUser->server  = $this->config->xuanxuan->server;
        $loginInfo->ui->defaultUser->account = $this->app->user->account;
        $loginInfo = json_encode($loginInfo);

        $loginFile = $clientDir . 'config.json';
        file_put_contents($loginFile, $loginInfo);

        define('PCLZIP_TEMPORARY_DIR', $clientDir);
        $this->app->loadClass('pclzip', true);
        $clientFile = $clientDir . 'xuanxuan.zip';
        $archive    = new pclzip($clientFile);

        if($os == 'mac')
        {
            $result = $archive->add($loginFile, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, 'xuanxuan.app/Contents/Resources/build-in');
        }
        else
        {
            $result = $archive->add($loginFile, PCLZIP_OPT_REMOVE_ALL_PATH, PCLZIP_OPT_ADD_PATH, 'xuanxuan/resources/build-in');
        }

        if($result == 0)
        {
            $response['result']  = 'fail';
            $response['message'] = $archive->errorInfo(true);
            $this->send($response);
        }

        $this->send($response);
    }

    /**
     * Fetch and pack server address into client zips, and provide download links.
     *
     * @param string $os
     * @return void
     */
    public function getClientLinks($os = 'win64')
    {
        if($_POST)
        {
            $os = implode(',', $this->post->os);
            $this->client->fetchCurrentClient($os);
            $this->client->packServerConfig($os);
            $this->view->links = $this->client->getLinks($os);
            $this->view->os    = '';
            $this->display();
            die;
        }

        $this->view->hangWarning = $this->lang->client->serverMightHang;
        $this->view->links       = false;
        $this->view->os          = $os;
        $this->display();
    }
}
