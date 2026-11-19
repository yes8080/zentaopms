<?php
/**
 * The control file of integration module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Wenrui LI <liwenrui@easycorp.ltd>
 * @package     integration
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php
class integration extends control
{
    /**
     * @var integrationModel
     */
    public $integration;

    /**
     * Configure office integrations, currently supports Collabora Office.
     *
     * @access public
     * @return void
     */
    public function office($type = '')
    {
        if($_POST)
        {
            $data = fixer::input('post')->get();
            if($data->officeEnabled)
            {
                if(isset($data->officeType))
                {
                    if($data->officeType == 'collaboraOffice')
                    {
                        // 验证 Collabora 地址必填
                        if(empty(trim($data->collaboraPath)))
                        {
                            $this->send(array('result' => 'fail', 'message' => $this->lang->integration->error->collaboraPathRequired));
                        }
                        // 验证 Collabora 连接
                        $collaboraDiscovery = $this->integration->getCollaboraDiscovery($data->collaboraPath);
                        if(empty($collaboraDiscovery)) $this->send(array('result' => 'fail', 'message' => $this->lang->integration->error->cannotConnectToCollabora));
                    }
                    elseif($data->officeType == 'onlyOffice')
                    {
                        // 验证 Only Office 地址必填
                        if(empty(trim($data->onlyOfficePath)))
                        {
                            $this->send(array('result' => 'fail', 'message' => $this->lang->integration->error->onlyOfficePathRequired));
                        }
                        // 验证 Only Office 连接
                        $onlyOfficeDiscovery = $this->integration->getOnlyOfficeDiscovery($data->onlyOfficePath);
                        if(empty($onlyOfficeDiscovery)) $this->send(array('result' => 'fail', 'message' => $this->lang->integration->error->cannotConnectToOnlyOffice));
                    }
                }
            }
            $this->loadModel('setting')->setItems('system.integration.office', $data);
            // $cacheKeys = array(
            //     'owner=system&module=integration&section=office&key=officeEnabled',
            //     'owner=system&module=integration&section=office&key=collaboraPath',
            // );
            // $invalidateResult = $this->loadModel('setting')->invalidateXxdConfigCache($cacheKeys);
            // if($invalidateResult !== true)
            // {
            //     $this->send(array('result' => 'fail', 'message' => $invalidateResult));
            //     return;
            // }
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('office')));
        }

        $officeConfig = isset($this->config->integration->office) ? $this->config->integration->office : new stdClass();

        $this->view->title = $this->lang->integration->office;
        $this->view->position[] = $this->lang->integration->office;
        $this->view->type = $type;
        $this->view->officeEnabled = zget($officeConfig, 'officeEnabled', '0');
        $this->view->officeType = zget($officeConfig, 'officeType', 'collaboraOffice');
        $this->view->collaboraPath = zget($officeConfig, 'collaboraPath', '');
        $this->view->onlyOfficePath = zget($officeConfig, 'onlyOfficePath', '');

        $this->display();
    }

    /**
     * Generate and redirect to office view url of file for user.
     *
     * @param  int    $fileID
     * @param  string $serverName     serverName set on XXD server
     * @param  string $protocol
     * @param  string $hostname
     * @param  string $port
     * @param  string $sessionID      user's sessionID on XXD server
     * @param  string $mode           ro | rw, rw enables editing if file is marked as editable
     * @param  int    $messageID      required if mode is set to rw
     * @param  int    $userID
     * @access public
     * @return void   redirects user to office view url
     */
    public function wopi($fileID, $serverName, $protocol, $hostname, $port, $sessionID, $mode = 'ro', $messageID = 0, $userID = 0)
    {
        $officeType = zget($this->config->integration->office, 'officeType', 'collaboraOffice');
        if($officeType == 'onlyOffice')
        {
            return $this->wopiOnlyOffice($fileID, $serverName, $protocol, $hostname, $port, $sessionID, $mode, $messageID, $userID);
        }

        return $this->wopiCollabora($fileID, $serverName, $protocol, $hostname, $port, $sessionID, $mode, $messageID, $userID);
    }

    /**
     * Generate and redirect to collaboraOffice view url of file for user.
     *
     * @param  int    $fileID
     * @param  string $serverName     serverName set on XXD server
     * @param  string $protocol
     * @param  string $hostname
     * @param  string $port
     * @param  string $sessionID      user's sessionID on XXD server
     * @param  string $mode           ro | rw, rw enables collaboraOffice editing if file is marked as editable
     * @param  int    $messageID      required if mode is set to rw
     * @param  int    $userID
     * @access private
     * @return void   redirects user to collaboraOffice view url
     */
    private function wopiCollabora($fileID, $serverName, $protocol, $hostname, $port, $sessionID, $mode = 'ro', $messageID = 0, $userID = 0)
    {
        if(method_exists($this->app, 'loadConfig'))
        {
            $this->app->loadConfig('file');
            if(!zget($this->config->integration->office, 'officeEnabled') && empty($this->config->file->collaboraPath)) die($this->lang->integration->error->officeNotEnabled);
        }
        elseif(!zget($this->config->integration->office, 'officeEnabled')) die($this->lang->integration->error->officeNotEnabled);

        $user = $this->dao->select('account,realname')->from(TABLE_USER)->where('id')->eq($userID)->fetch();
        if(!$user) die($this->lang->integration->error->userNotFoundForRequest);

        $file = $this->loadModel('file')->getByID($fileID);
        if(!$file) die($this->lang->integration->error->fileNotFoundForRequest);

        $discovery = isset($this->file->getCollaboraDiscovery) ? $this->file->getCollaboraDiscovery() : $this->integration->getCollaboraDiscovery();
        if(!$discovery) die($this->lang->integration->error->cannotConnectToCollabora);
        if(!isset($discovery[$file->extension])) die($this->lang->integration->error->filePreviewNotSupported);

        $identifiers = $this->integration->getOfficeIdentifiers($file, $serverName, $mode == 'rw', $messageID, $sessionID, $user->realname, $userID);
        if(empty($identifiers)) die($this->lang->integration->error->buildIdentifierFail);

        $serverAddress = $protocol . '://' . $hostname . ':' . $port;
        $xxdWopiUrl = $serverAddress . '/wopi/files/' . $identifiers->file;
        $collaboraUrl = $discovery[$file->extension]['urlsrc'] . 'WOPISrc=' . $xxdWopiUrl . '&access_token=' . $identifiers->user . '&lang=' . $this->app->getClientLang();

        /* Change theme with css variables */
        $cssVariables = '';
        $docTheme = $this->config->collaboraThemes[$file->extension];
        if(isset($docTheme))
        {
            foreach($docTheme as $varName => $varValue)
            {
                $cssVariables .= "--$varName=$varValue;";
            }
        }
        if(!empty($cssVariables)) $collaboraUrl .= '&css_variables=' . urlencode($cssVariables);

        header("Location: $collaboraUrl", true, 302);
    }

    /**
     * Generate and display Only Office editor page for user.
     * Only Office uses WOPI protocol and requires POST form submission.
     *
     * @param  int    $fileID
     * @param  string $serverName     serverName set on XXD server
     * @param  string $protocol
     * @param  string $hostname
     * @param  string $port
     * @param  string $sessionID      user's sessionID on XXD server
     * @param  string $mode           ro | rw, rw enables editing if file is marked as editable
     * @param  int    $messageID      required if mode is set to rw
     * @param  int    $userID
     * @access private
     * @return void   displays Only Office editor page
     */
    private function wopiOnlyOffice($fileID, $serverName, $protocol, $hostname, $port, $sessionID, $mode = 'ro', $messageID = 0, $userID = 0)
    {
        if(method_exists($this->app, 'loadConfig'))
        {
            $this->app->loadConfig('file');
        }
        if(!zget($this->config->integration->office, 'officeEnabled')) die($this->lang->integration->error->officeNotEnabled);

        $onlyOfficePath = zget($this->config->integration->office, 'onlyOfficePath', '');
        if(empty($onlyOfficePath)) die($this->lang->integration->error->cannotConnectToOnlyOffice);

        // Check if this is a request for a converted file (wopiFileId parameter)
        // ZenTao framework maps URL params to function args, extra params are NOT in $_GET
        // So we need to parse wopiFileId from REQUEST_URI directly
        $wopiFileId = '';
        if(preg_match('/wopiFileId=([^&]+)/', $_SERVER['REQUEST_URI'], $matches))
        {
            $wopiFileId = urldecode($matches[1]);
        }

        if(!empty($wopiFileId))
        {
            // This is a converted file - open it directly via WOPI
            // Pass sessionID and userID to generate a valid access token
            return $this->wopiOnlyOfficeConverted($wopiFileId, $sessionID, $userID, $protocol, $hostname, $port, $onlyOfficePath);
        }

        $user = $this->dao->select('account,realname')->from(TABLE_USER)->where('id')->eq($userID)->fetch();
        if(!$user) die($this->lang->integration->error->userNotFoundForRequest);

        $file = $this->loadModel('file')->getByID($fileID);
        if(!$file) die($this->lang->integration->error->fileNotFoundForRequest);

        // Determine if editing is needed based on mode
        $needEdit = ($mode == 'rw');

        // Get WOPI discovery from Only Office server
        // Pass needEdit parameter to prefer 'convert' or 'edit' actions when editing is needed
        $discovery = $this->integration->getOnlyOfficeDiscovery($onlyOfficePath, $needEdit);
        if(empty($discovery)) die($this->lang->integration->error->cannotConnectToOnlyOffice);
        if(!isset($discovery[$file->extension])) die($this->lang->integration->error->filePreviewNotSupported);

        // Build HostEditUrl for OnlyOffice to redirect after conversion
        // This URL opens the file in edit mode (triggers convert for binary formats)
        $hostEditUrlBase = $this->createLink('integration', 'wopi', "fileID=$fileID&serverName=$serverName&protocol=$protocol&hostname=$hostname&port=$port&sessionID=$sessionID&mode=rw&messageID=$messageID&userID=$userID");
        // Make it absolute URL
        $currentHost = $_SERVER['HTTP_HOST'];
        $currentScheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $hostEditUrl = $currentScheme . '://' . $currentHost . $hostEditUrlBase;

        $identifiers = $this->integration->getOfficeIdentifiers($file, $serverName, $mode == 'rw', $messageID, $sessionID, $user->realname, $userID, $hostEditUrl);
        if(empty($identifiers)) die($this->lang->integration->error->buildIdentifierFail);

        // Build WOPI URL for Only Office
        $serverAddress = $protocol . '://' . $hostname . ':' . $port;
        $xxdWopiUrl = $serverAddress . '/wopi/files/' . $identifiers->file;

        // Construct Only Office action URL with WOPISrc parameter
        $urlsrc = $discovery[$file->extension]['urlsrc'];

        // Append UI/data language based on client language (RFC1766, e.g. zh-cn, en-us)
        $lang = $this->app->getClientLang();
        if(!empty($lang))
        {
            $lang = str_replace('_', '-', strtolower($lang));
            $urlsrc = rtrim($urlsrc, '?&');
            $langSeparator = (strpos($urlsrc, '?') !== false) ? '&' : '?';
            $urlsrc .= $langSeparator . 'ui=' . $lang . '&rs=' . $lang;
        }

        $separator = (strpos($urlsrc, '?') !== false) ? '&' : '?';
        $actionUrl = $urlsrc . $separator . 'WOPISrc=' . urlencode($xxdWopiUrl);

        // Set access token TTL (30 minutes from now, in milliseconds)
        $accessTokenTtl = (time() + 1800) * 1000;

        // Pass variables to view for POST form submission
        $this->view->actionUrl      = $actionUrl;
        $this->view->accessToken    = $identifiers->user;
        $this->view->accessTokenTtl = $accessTokenTtl;

        // Display the Only Office host page which submits form via POST
        $this->display('integration', 'wopionlyoffice');
    }

    /**
     * Handle converted file opening via WOPI.
     * This is called when a binary file (doc, xls, ppt) has been converted to modern format.
     *
     * @param  string $wopiFileId       WOPI file identifier (base64 encoded)
     * @param  string $sessionID        Original session ID from xxd
     * @param  int    $userID           User ID
     * @param  string $protocol         http or https for xxd server
     * @param  string $hostname         xxd server hostname
     * @param  string $port             xxd server port
     * @param  string $onlyOfficePath   OnlyOffice server URL
     * @access private
     * @return void
     */
    private function wopiOnlyOfficeConverted($wopiFileId, $sessionID, $userID, $protocol, $hostname, $port, $onlyOfficePath)
    {
        // Get user info for display name
        $user = $this->dao->select('account,realname')->from(TABLE_USER)->where('id')->eq($userID)->fetch();
        $userDisplayName = $user ? $user->realname : 'User';

        // Decode the file identifier to get file name and extension
        $decoded = base64_decode(str_replace(array('_', '-'), array('/', '+'), $wopiFileId));
        $parts = explode(',', $decoded);
        $fileName = '';
        if(!empty($parts[0]))
        {
            $fileName = base64_decode(str_replace(array('_', '-'), array('/', '+'), $parts[0]));
        }

        // Get file extension
        $extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if(empty($extension)) $extension = 'docx'; // Default to docx

        // DEBUG: Show decoded values
        // die("DEBUG: fileName=$fileName, extension=$extension, wopiFileId=" . substr($wopiFileId, 0, 50) . "...");

        // Get WOPI discovery - for converted files, we always want edit action
        $discovery = $this->integration->getOnlyOfficeDiscovery($onlyOfficePath, true);
        if(empty($discovery)) die($this->lang->integration->error->cannotConnectToOnlyOffice);
        if(!isset($discovery[$extension])) die($this->lang->integration->error->filePreviewNotSupported);

        // DEBUG: Show selected action (uncomment to debug)
        // die("DEBUG: fileName=$fileName, extension=$extension, action=" . $discovery[$extension]['action'] . ", urlsrc=" . substr($discovery[$extension]['urlsrc'], 0, 80) . "...");

        // Build WOPI URL for the converted file
        $serverAddress = $protocol . '://' . $hostname . ':' . $port;
        $xxdWopiUrl = $serverAddress . '/wopi/files/' . $wopiFileId;

        // Construct Only Office action URL with WOPISrc parameter
        $urlsrc = $discovery[$extension]['urlsrc'];

        // Append UI/data language based on client language (RFC1766, e.g. zh-cn, en-us)
        $lang = $this->app->getClientLang();
        if(!empty($lang))
        {
            $lang = str_replace('_', '-', strtolower($lang));
            $urlsrc = rtrim($urlsrc, '?&');
            $langSeparator = (strpos($urlsrc, '?') !== false) ? '&' : '?';
            $urlsrc .= $langSeparator . 'ui=' . $lang . '&rs=' . $lang;
        }

        $separator = (strpos($urlsrc, '?') !== false) ? '&' : '?';
        $actionUrl = $urlsrc . $separator . 'WOPISrc=' . urlencode($xxdWopiUrl);

        // Generate a VALID access token for the converted file
        // The session hash must be: MD5(sessionID + fileName) to match xxd's validation
        $fileSession = md5($sessionID . $fileName);
        $userIdentifier = array($fileSession, $userDisplayName, $userID);
        // Encode each part in base64
        foreach($userIdentifier as $key => $param)
        {
            $userIdentifier[$key] = str_replace(array('/', '+'), array('_', '-'), base64_encode($param));
        }
        $accessToken = str_replace(array('/', '+'), array('_', '-'), base64_encode(implode(',', $userIdentifier)));

        // Set access token TTL (30 minutes from now, in milliseconds)
        $accessTokenTtl = (time() + 1800) * 1000;

        // Pass variables to view for POST form submission
        $this->view->actionUrl      = $actionUrl;
        $this->view->accessToken    = $accessToken;
        $this->view->accessTokenTtl = $accessTokenTtl;

        // Display the Only Office host page which submits form via POST
        $this->display('integration', 'wopionlyoffice');
    }
}
