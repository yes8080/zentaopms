<?php
/**
 * The zen file of backup module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@easycorp.ltd>
 * @package     backup
 * @link        https://www.zentao.net
 */
class backupZen extends backup
{
    /**
     * 获取备份文件列表
     * Get backup files list.
     *
     * @access protected
     * @return array
     */
    protected function getBackupList(): array
    {
        $backupList = array();
        foreach($this->backup->getBackupEntries() as $fileName => $file)
        {
            if(!str_ends_with($fileName, '.sql') && !str_ends_with($fileName, '.sql.php')) continue;
            $backupFile = new stdclass();
            $backupFile->time = filemtime($file);
            $backupFile->name = substr($fileName, 0, strpos($fileName, '.'));
            $backupFile->files[$file] = $this->backup->getBackupSummary($file);

            $fileBackup = $this->backup->getBackupFile($backupFile->name, 'file');
            if($fileBackup) $backupFile->files[$fileBackup] = $this->backup->getBackupSummary($fileBackup);

            $codeBackup = $this->backup->getBackupFile($backupFile->name, 'code');
            if($codeBackup) $backupFile->files[$codeBackup] = $this->backup->getBackupSummary($codeBackup);

            $backupList[$backupFile->name] = $backupFile;
        }
        krsort($backupList);

        return $backupList;
    }

    /**
     * 备份SQL文件
     * backupSQL
     *
     * @param  string    $fileName
     * @param  string    $reload
     * @access protected
     * @return array
     */
    protected function backupSQL(string $fileName, string $reload = 'no'): array
    {
        $nosafe = str_contains($this->config->backup->setting, 'nosafe');
        $path   = $this->backup->getBackupEntry($fileName, $nosafe ? 'sql' : 'sql.php');
        if(!$path || file_exists($path) || !($handle = fopen($path, 'xb'))) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noWritable, $this->backupPath));
        fclose($handle);
        $result = $this->backup->backSQL($path);
        if(!$result->result || (!$nosafe && !$this->backup->addFileHeader($path)))
        {
            unlink($path);
            return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noWritable, $this->backupPath));
        }
        return array('result' => 'success');
    }

    /**
     * 备份附件
     * Backup appendix file.
     *
     * @param  string    $fileName
     * @param  string    $reload
     * @access protected
     * @return array
     */
    protected function backupFile(string $fileName, string $reload = 'no'): array
    {
        if(str_contains($this->config->backup->setting, 'nofile')) return array('result' => 'success');

        $path = $this->backup->getBackupEntry($fileName, 'file');
        if(!$path || file_exists($path) || !mkdir($path, 0700)) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noWritable, $this->backupPath));
        $result = $this->backup->backFile($path);
        if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->backupFile, $result->error));
        return array('result' => 'success');
    }

    /**
     * 备份代码
     * Backup code
     *
     * @param  string    $fileName
     * @param  string    $reload
     * @access protected
     * @return array
     */
    protected function backupCode(string $fileName, string $reload = 'no'): array
    {
        if(str_contains($this->config->backup->setting, 'nofile')) return array('result' => 'success');

        $path = $this->backup->getBackupEntry($fileName, 'code');
        if(!$path || file_exists($path) || !mkdir($path, 0700)) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->noWritable, $this->backupPath));
        $result = $this->backup->backCode($path);
        if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->backupCode, $result->error));
        return array('result' => 'success');
    }

    /**
     * 删除过期文件。
     * Remove expired backup files.
     *
     * @access protected
     * @return void
     */
    protected function removeExpiredFiles()
    {
        $backupFiles = $this->backup->getBackupEntries();
        if(empty($backupFiles)) return;

        $time  = time();
        $zfile = $this->app->loadClass('zfile');
        foreach($backupFiles as $file)
        {
            /* Only delete backup file. */
            $fileName = basename($file);
            if(!preg_match('/\A[0-9]{14}[A-Za-z0-9_-]*\.(sql(?:\.php)?|file|code)\z/', $fileName)) continue;
            if(is_dir($file) && !$this->backup->isSafeBackupTree($file)) continue;

            /* Remove before holdDays file. */
            if($time - filemtime($file) > $this->config->backup->holdDays * 24 * 3600)
            {
                $rmFunc = is_file($file) ? 'removeFile' : 'removeDir';
                $zfile->{$rmFunc}($file);
                if($rmFunc == 'removeDir') $this->backup->processSummary($file, 0, 0, array(), 0, 'delete');
            }
        }
    }

    /**
     * 还原SQL
     * Restore SQL
     *
     * @param  string    $fileName
     * @access protected
     * @return array
     */
    protected function restoreSQL(string $fileName): array
    {
        $backupFile = $this->backup->getBackupFile($fileName, 'sql');
        if(!$backupFile || !is_readable($backupFile)) return array('result' => 'fail', 'message' => $this->lang->backup->notice->unknownVersion);

        $result = $this->backup->restoreSQL($backupFile);

        if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreSQL, $result->error));
        return array('result' => 'success');
    }

    /**
     * 还原附件
     * Restore File.
     *
     * @param  string    $fileName
     * @access protected
     * @return array
     */
    protected function restoreFile(string $fileName): array
    {
        $backupFile = $this->backup->getBackupFile($fileName, 'file');
        if(empty($backupFile)) return array('result' => 'success');

        $result = $this->backup->restoreFile($backupFile);

        if(!$result->result) return array('result' => 'fail', 'message' => sprintf($this->lang->backup->error->restoreFile, $result->error));
        return array('result' => 'success');
    }

    /**
     * 设置保留天数。
     * Set hold days.
     *
     * @param  object $data
     * @access public
     * @return bool
     */
    public function setHoldDays(object $data)
    {
        if(empty($data->holdDays))
        {
            dao::$errors['holdDays'] = sprintf($this->lang->error->notempty, $this->lang->backup->change);
            return false;
        }

        if(!preg_match("/^-?\d+$/", (string)$data->holdDays) || $data->holdDays <= 0)
        {
            dao::$errors['holdDays'] = sprintf($this->lang->backup->error->int, $this->lang->backup->change);
            return false;
        }

        $this->loadModel('setting')->setItem('system.backup.holdDays', $data->holdDays);
        return !dao::isError();
    }
}
