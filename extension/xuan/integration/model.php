<?php
/**
 * The model file of integration module of XXB.
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
class integrationModel extends model
{
    /**
     * Fetch hosting/discovery urls from Collabora.
     *
     * @param  string $collaboraPath
     * @access public
     * @return array
     */
    public function getCollaboraDiscovery($collaboraPath = '')
    {
        if(empty($collaboraPath) and !empty($this->config->integration->office->collaboraPath)) $collaboraPath = $this->config->integration->office->collaboraPath;
        if(empty($collaboraPath) and isset($this->config->file->collaboraPath))                 $collaboraPath = $this->config->file->collaboraPath;
        if(empty($collaboraPath)) return array();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($collaboraPath, '/') . '/hosting/discovery');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $discovery = curl_exec($ch);
        curl_close($ch);

        preg_match_all('|<action(.+)/>|', $discovery, $results);

        $files = array();
        foreach($results[1] as $key => $action)
        {
            preg_match_all('|ext="([^"]*)"|', $action, $output);
            if($output[1]) $extension = $output[1][0];
            if(empty($extension)) continue;

            preg_match_all('|name="([^"]*)"|', $action, $output);
            if($output[1]) $name = $output[1][0];

            preg_match_all('|urlsrc="([^"]*)"|', $action, $output);
            if($output[1]) $urlsrc = $output[1][0];

            $files[$extension]['action'] = $name;
            $files[$extension]['urlsrc'] = $urlsrc;
        }

        return $files;
    }

    /**
     * Fetch hosting/discovery urls from Only Office.
     * Only Office uses WOPI protocol and provides discovery XML at /hosting/discovery endpoint.
     *
     * @param  string $onlyOfficePath
     * @param  bool   $needEdit       If true, prefer 'convert' or 'edit' actions over 'view'
     * @access public
     * @return array
     */
    public function getOnlyOfficeDiscovery($onlyOfficePath = '', $needEdit = false)
    {
        if(empty($onlyOfficePath) and !empty($this->config->integration->office->onlyOfficePath)) $onlyOfficePath = $this->config->integration->office->onlyOfficePath;
        if(empty($onlyOfficePath)) return array();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($onlyOfficePath, '/') . '/hosting/discovery');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $discovery = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if($httpCode != 200 || empty($discovery)) return array();

        // Parse WOPI discovery XML to extract supported file types and URLs
        preg_match_all('|<action([^>]+)/>|', $discovery, $results);

        // Preferred actions in order of priority
        // When editing is needed, prioritize: edit > convert > editnew > view
        // 'convert' action allows editing legacy formats (doc, xls, ppt) by converting to modern formats
        // The conversion workflow requires PutRelativeFile support in xxd server
        // For read-only: prefer embedview over view so OnlyOffice embed app is used; the main app (view)
        // shows a popup "Error code: -103" (ERR_CONNECTION_ABORTED) on transient network errors, while
        // embed does not display that popup.
        $preferredActions = $needEdit
            ? array('edit', 'convert', 'editnew', 'view', 'embedview', 'mobileView')
            : array('embedview', 'view', 'mobileView');

        $files = array();
        $allActions = array(); // Store all actions for each extension

        // First pass: collect all actions for each extension
        foreach($results[1] as $key => $action)
        {
            $extension = '';
            $name = '';
            $urlsrc = '';
            $targetext = '';

            preg_match('|ext="([^"]*)"|', $action, $output);
            if(!empty($output[1])) $extension = $output[1];
            if(empty($extension)) continue;

            preg_match('|name="([^"]*)"|', $action, $output);
            if(!empty($output[1])) $name = $output[1];

            preg_match('|targetext="([^"]*)"|', $action, $output);
            if(!empty($output[1])) $targetext = $output[1];

            preg_match('|urlsrc="([^"]*)"|', $action, $output);
            if(!empty($output[1])) $urlsrc = $output[1];

            if(!empty($urlsrc))
            {
                // Decode HTML entities first (XML attributes encode < > &)
                $urlsrc = html_entity_decode($urlsrc, ENT_QUOTES | ENT_XML1, 'UTF-8');

                // Remove WOPI placeholder tokens like <placeholder=VALUE&> from URL
                // These placeholders are optional parameters in WOPI discovery XML
                $urlsrc = preg_replace('/<[^<>]+&>/', '', $urlsrc);

                // Clean up any remaining artifacts (double ? or &, trailing ? or &)
                $urlsrc = preg_replace('/\?&/', '?', $urlsrc);
                $urlsrc = preg_replace('/&&+/', '&', $urlsrc);
                $urlsrc = rtrim($urlsrc, '?&');

                if(!isset($allActions[$extension])) $allActions[$extension] = array();
                $allActions[$extension][] = array('name' => $name, 'urlsrc' => $urlsrc, 'targetext' => $targetext);
            }
        }

        // Second pass: select the best action for each extension based on priority
        foreach($allActions as $extension => $actions)
        {
            $selectedAction = null;
            $selectedPriority = false;

            foreach($actions as $action)
            {
                $priority = array_search($action['name'], $preferredActions);
                if($priority === false) $priority = 999; // Low priority for unknown actions

                if($selectedPriority === false || $priority < $selectedPriority)
                {
                    $selectedAction = $action;
                    $selectedPriority = $priority;
                }
            }

            if($selectedAction)
            {
                $files[$extension]['action'] = $selectedAction['name'];
                $files[$extension]['urlsrc'] = $selectedAction['urlsrc'];
                if(!empty($selectedAction['targetext']))
                {
                    $files[$extension]['targetext'] = $selectedAction['targetext'];
                }
            }
        }

        return $files;
    }

    /**
     * Get identifiers for WOPI API on XXD.
     *
     * @param  object $file
     * @param  string $serverName
     * @param  bool   $enableWrite
     * @param  string $messageID
     * @param  string $sessionID
     * @param  string $userDisplayName
     * @param  int    $userID
     * @param  string $hostEditUrl      URL for editing the file (used by OnlyOffice for redirect after conversion)
     * @access public
     * @return array
     */
    public function getOfficeIdentifiers($file, $serverName, $enableWrite = false, $messageID = '', $sessionID = '', $userDisplayName = '', $userID = 0, $hostEditUrl = '')
    {
        $fileName  = "$file->title.$file->extension";
        $fileTime  = isset($file->addedDate) ? strtotime($file->addedDate) : strtotime($file->createdDate);
        $fileOwner = $file->createdBy;

        if($enableWrite && !empty($messageID))
        {
            $enableWrite = false;
            $message = $this->loadModel('im')->messageGetList('', array($messageID));
            if(!empty($message)) $message = current($message);
            $chat = $this->im->chatGetByGid($message->cgid, false, false);
            if($chat->archiveDate == null && $message->contentType == 'file')
            {
                $content = json_decode($message->content);
                if($content->id == $file->id && isset($content->editable) && $content->editable) $enableWrite = true;
            }
        }

        $fileMode = $enableWrite ? 'rw' : 'ro';

        $fileSession = md5($sessionID.$fileName);

        // FileIdentifier: 0=>fileName, 1=>fileTime, 2=>fileID, 3=>fileOwner, 4=>serverName, 5=>fileMode, 6=>hostEditUrl
        $fileIdentifier = array($fileName, $fileTime, $file->id, $fileOwner, $serverName, $fileMode, $hostEditUrl);
        $userIdentifier = array($fileSession, $userDisplayName, $userID);

        $identifiers = array('file' => $fileIdentifier, 'user' => $userIdentifier);
        return (object)array_map(function($params)
        {
            foreach($params as $key => $param) $params[$key] = str_replace(array('/', '+'), array('_', '-'), base64_encode($param));
            $params = implode(',', $params);
            return str_replace(array('/', '+'), array('_', '-'), base64_encode($params));
        }, $identifiers);
    }
}
