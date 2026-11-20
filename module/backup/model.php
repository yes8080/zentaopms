<?php
/**
 * The model file of backup module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     backup
 * @version     $Id$
 * @link        https://www.zentao.net
 */
class backupModel extends model
{
    /**
     * Backup SQL.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function backSQL(string $backupFile): object
    {
        $zdb = $this->app->loadClass('zdb');
        return $zdb->dump($backupFile);
    }

    /**
     * Backup file.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function backFile(string $backupFile): object
    {
        $zfile  = $this->app->loadClass('zfile');

        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        if(!is_dir($backupFile)) mkdir($backupFile, 0777, true);

        $tmpLogFile = $this->getTmpLogFile($backupFile);
        $dataDir    = $this->app->getAppRoot() . 'www/data/';
        $count      = $zfile->getCount($dataDir, array('course'));
        $log = fopen($tmpLogFile, 'xb');
        if(!$log) return (object)array('result' => false, 'error' => $tmpLogFile);
        fwrite($log, json_encode(array('allCount' => $count)));
        fclose($log);

        $result = $zfile->copyDir($dataDir, $backupFile, $logLevel = false, $tmpLogFile, array('course'));
        $this->processSummary($backupFile, $result['count'], $result['size'], $result['errorFiles'], $count);
        unlink($tmpLogFile);

        return $return;
    }

    /**
     * Backup code.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function backCode(string $backupFile): object
    {
        $zfile  = $this->app->loadClass('zfile');
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        $tmpLogFile  = $this->getTmpLogFile($backupFile);
        $appRoot     = $this->app->getAppRoot();
        $fileList    = glob($appRoot . '*');
        $wwwFileList = glob($appRoot . 'www/*');

        $tmpFile  = array_search($appRoot . 'tmp', $fileList);
        $wwwFile  = array_search($appRoot . 'www', $fileList);
        $dataFile = array_search($appRoot . 'www/data', $wwwFileList);
        unset($fileList[$tmpFile]);
        unset($fileList[$wwwFile]);
        unset($wwwFileList[$dataFile]);

        $fileList = array_merge($fileList, $wwwFileList);

        if(!is_dir($backupFile)) mkdir($backupFile, 0777, true);

        $allCount = 0;
        foreach($fileList as $codeFile) $allCount += $zfile->getCount($codeFile);
        $log = fopen($tmpLogFile, 'xb');
        if(!$log) return (object)array('result' => false, 'error' => $tmpLogFile);
        fwrite($log, json_encode(array('allCount' => $allCount)));
        fclose($log);

        $copiedCount = 0;
        $copiedSize  = 0;
        $errorFiles  = array();
        foreach($fileList as $codeFile)
        {
            $file = trim(str_replace($appRoot, '', $codeFile), DS);
            if(is_dir($codeFile))
            {
                if(!is_dir($backupFile . DS . $file)) mkdir($backupFile . DS . $file, 0777, true);
                $result = $zfile->copyDir($codeFile, $backupFile . DS . $file, $logLevel = false, $tmpLogFile);
                $copiedCount += $result['count'];
                $copiedSize  += $result['size'];
                $errorFiles  += $result['errorFiles'];
            }
            else
            {
                $dirName = dirname($file);
                if(!is_dir($backupFile . DS . $dirName)) mkdir($backupFile . DS . $dirName, 0777, true);
                if($zfile->copyFile($codeFile, $backupFile . DS . $file))
                {
                    $copiedCount += 1;
                    $copiedSize  += filesize($codeFile);
                }
                else
                {
                    $errorFiles[] = $codeFile;
                }
            }
        }

        $this->processSummary($backupFile, $copiedCount, $copiedSize, $errorFiles, $allCount);
        unlink($tmpLogFile);

        return $return;
    }

    /**
     * Restore SQL.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function restoreSQL(string $backupFile): object
    {
        $zdb       = $this->app->loadClass('zdb');
        $allTables = $zdb->getAllTables();
        foreach($allTables as $tableName => $tableType)
        {
            try
            {
                $this->dbh->exec("DROP $tableType IF EXISTS `$tableName`");
            }
            catch(PDOException $e){}
        }

        $this->dao->clearCache();

        return $zdb->import($backupFile);
    }

    /**
     * Restore File.
     *
     * @param  string    $backupFile
     * @access public
     * @return object
     */
    public function restoreFile(string $backupFile): object
    {
        $return = new stdclass();
        $return->result = true;
        $return->error  = '';

        if(is_dir($backupFile))
        {
            $zfile = $this->app->loadClass('zfile');
            $zfile->copyDir($backupFile, $this->app->getAppRoot() . 'www/data/', $showDetails = false);
        }

        return $return;
    }

    public function addFileHeader(string $fileName): bool
    {
        return $this->rewriteFileHeader($fileName, $fileName, true);
    }

    public function removeFileHeader(string $fileName, ?string $output = null): bool
    {
        return $this->rewriteFileHeader($fileName, $output ?? $fileName, false);
    }

    /** Replace a complete file atomically without exposing the original SQL while copying. */
    private function rewriteFileHeader(string $source, string $output, bool $add): bool
    {
        $root = $this->resolveBackupRoot($this->getBackupPath());
        if(!$root || dirname(realpath($source) ?: '') !== $root || is_link($source) || !is_file($source)) return false;
        if(realpath(dirname($output)) !== $root || is_link($output)) return false;

        $temp = tempnam($root, '.header-');
        if($temp === false) return false;
        $input = $writer = null;
        try
        {
            if(dirname($temp) !== $root) return false;
            $input  = fopen($source, 'rb');
            $writer = fopen($temp, 'wb');
            if(!$input || !$writer) return false;
            if($add)
            {
                $header = "<?php die();?>" . "\n";
                if(fwrite($writer, $header) !== strlen($header)) return false;
            }
            elseif(!preg_match('/^<\?php\s+(?:die|exit)\s*\(\s*\)\s*;\s*\?>\s*$/i', (string)fgets($input, 1024)))
            {
                return false;
            }
            if(stream_copy_to_stream($input, $writer) === false || !fflush($writer)) return false;
            fclose($writer);
            $writer = null;
            if($source === $output) return rename($temp, $output);
            /* Publish a second name without replacing an existing unprotected backup. */
            if(!link($temp, $output)) return false;
            return unlink($source);
        }
        finally
        {
            if(is_resource($input)) fclose($input);
            if(is_resource($writer)) fclose($writer);
            if(file_exists($temp)) unlink($temp);
        }
    }

    /**
     * Get dir size.
     *
     * @param  string    $backup
     * @access public
     * @return array
     */
    public function getBackupSummary(string $backup): array
    {
        $zfile = $this->app->loadClass('zfile');
        if(is_file($backup))
        {
            $summary = array();
            $summary['allCount'] = 1;
            $summary['count']    = 1;
            $summary['size']     = $zfile->getFileSize($backup);

            return $summary;
        }

        $summaryFile = dirname($backup) . DS . 'summary';
        if(is_link($summaryFile) || !is_file($summaryFile)) return array();

        $summary = json_decode(file_get_contents($summaryFile), true);
        return zget($summary, basename($backup), array());
    }

    /**
     * Get backup path.
     *
     * @access public
     * @return string
     */
    public function getBackupPath(): string
    {
        $backupPath = empty($this->config->backup->settingDir) ? $this->app->getTmpRoot() . 'backup' . DS : $this->config->backup->settingDir;
        return rtrim(str_replace(DS, '/', $backupPath), '/') . '/';
    }

    /**
     * Get backup file.
     *
     * @param  string  $name
     * @param  string  $type   sql|file|code
     * @access public
     * @return string|false
     */
    public function getBackupFile(string $name, string $type): string|false
    {
        if(!in_array($type, array('sql', 'file', 'code'), true)) return false;
        $suffixes = $type === 'sql' ? array('sql', 'sql.php') : array($type);
        foreach($suffixes as $suffix)
        {
            $path = $this->getBackupEntry($name, $suffix);
            if($path !== false && file_exists($path)) return $path;
        }
        return false;
    }

    /** Resolve a private directory; a configured volume may itself be mounted through a symlink. */
    public function resolveBackupRoot(string $directory): string|false
    {
        $root    = realpath($directory);
        $webRoot = realpath($this->app->getAppRoot() . 'www');
        if(!$root || !is_dir($root) || dirname($root) === $root) return false;
        if($webRoot && ($root === $webRoot || str_starts_with($root, $webRoot . DIRECTORY_SEPARATOR))) return false;
        return $root;
    }

    /** Resolve a direct child of the configured backup volume. Missing entries may be created. */
    public function getBackupEntry(string $name, string $suffix): string|false
    {
        if(!preg_match('/\A[\pL\pN_-][\pL\pN _-]*\z/u', $name) || !in_array($suffix, array('sql', 'sql.php', 'file', 'code'), true)) return false;
        $root = $this->resolveBackupRoot($this->getBackupPath());
        if(!$root) return false;
        $path = $root . DIRECTORY_SEPARATOR . $name . '.' . $suffix;
        if(is_link($path)) return false;
        if(file_exists($path) && (in_array($suffix, array('code', 'file'), true) ? !is_dir($path) : !is_file($path))) return false;
        return $path;
    }

    /** Inspect a backup directory before recursive operations. Also check destinations that restore will touch. */
    public function isSafeBackupTree(string $path, ?string $destination = null): bool
    {
        if(is_link($path) || !is_dir($path)) return false;
        if($destination !== null && (is_link($destination) || !is_dir($destination))) return false;
        try
        {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
            foreach($files as $file)
            {
                if($file->isLink() || (!$file->isFile() && !$file->isDir())) return false;
                if($destination !== null)
                {
                    $target = rtrim($destination, DIRECTORY_SEPARATOR) . substr($file->getPathname(), strlen(rtrim($path, DIRECTORY_SEPARATOR)));
                    if(is_link($target) || (file_exists($target) && ($file->isDir() ? !is_dir($target) : !is_file($target)))) return false;
                }
            }
        }
        catch(UnexpectedValueException $e)
        {
            return false;
        }
        return true;
    }

    /** Return only directly addressable backup artifacts, excluding temporary and metadata files. */
    public function getBackupEntries(): array
    {
        $files = array();
        $root  = $this->resolveBackupRoot($this->getBackupPath());
        if(!$root) return $files;
        foreach(scandir($root) ?: array() as $file)
        {
            $parts = explode('.', $file, 2);
            if(count($parts) !== 2) continue;
            $path = $this->getBackupEntry($parts[0], $parts[1]);
            if($path !== false && file_exists($path)) $files[$file] = $path;
        }
        return $files;
    }

    /**
     * Get tmp log file.
     *
     * @param  string $backupFile
     * @access public
     * @return string
     */
    public function getTmpLogFile(string $backupFile): string
    {
        return $backupFile . '.tmp.summary';
    }

    /**
     * Get backup dir progress.
     *
     * @param  string $backup
     * @access public
     * @return array
     */
    public function getBackupDirProgress(string $backup): array
    {
        $tmpLogFile = $this->getTmpLogFile($backup);
        if(!is_link($tmpLogFile) && is_file($tmpLogFile))
        {
            $log = json_decode(file_get_contents($tmpLogFile), true);
            return empty($log) ? array() : $log;
        }
        return array('allCount' => 0, 'count' => 0);
    }

    /**
     * Process filesize.
     *
     * @param  int    $fileSize
     * @access public
     * @return string
     */
    public function processFileSize(int $fileSize): string
    {
        $bit = 'KB';
        $fileSize = round($fileSize / 1024, 2);
        if($fileSize >= 1024)
        {
            $bit = 'MB';
            $fileSize = round($fileSize / 1024, 2);
        }
        if($fileSize >= 1024)
        {
            $bit = 'GB';
            $fileSize = round($fileSize / 1024, 2);
        }

        return $fileSize . $bit;
    }

    /**
     * Process backup summary.
     *
     * @param  string $file
     * @param  int    $count
     * @param  int    $size
     * @param  array  $errorFiles
     * @param  int    $allCount
     * @param  string $action  add|delete
     * @access public
     * @return bool
     */
    public function processSummary(string $file, int $count, int $size, array $errorFiles = array(), int $allCount = 0, string $action = 'add'): bool
    {
        $backupPath = dirname($file);
        $fileName   = basename($file);

        $summaryFile = $backupPath . DS . 'summary';
        if(is_link($summaryFile) || (file_exists($summaryFile) && !is_file($summaryFile))) return false;
        if(!file_exists($summaryFile) and !touch($summaryFile)) return false;

        $summary = json_decode(file_get_contents($summaryFile), true);
        if(empty($summary)) $summary = array();

        if($action == 'add')
        {
            $summary[$fileName]['allCount']   = $allCount;
            $summary[$fileName]['errorFiles'] = $errorFiles;
            $summary[$fileName]['count']      = $count;
            $summary[$fileName]['size']       = $size;
        }
        else
        {
            unset($summary[$fileName]);
        }

        if(file_put_contents($summaryFile, json_encode($summary))) return true;
        return false;
    }

    /**
     * Get disk space.
     *
     * @param  string $backupPath
     * @access public
     * @return string
     */
    public function getDiskSpace(string $backupPath): string
    {
        $nofile        = strpos($this->config->backup->setting, 'nofile') !== false;
        $diskFreeSpace = disk_free_space($backupPath);
        $backFileSize  = 0;

        if(!$nofile)
        {
            $appRoot      = $this->app->getAppRoot();
            $appRootSize  = $this->getDirSize($appRoot);
            $backFileSize = $appRootSize - $this->getDirSize($appRoot . 'tmp') - $this->getDirSize($appRoot . 'www/data/course');
        }

        $backSqlSize = $this->dao->select('sum(data_length+index_length) as size')
            ->from('information_schema.tables')
            ->where('TABLE_SCHEMA')->eq($this->config->db->name)
            ->groupBy('TABLE_SCHEMA')
            ->fetch('size');

        return $diskFreeSpace . ',' . ($backFileSize + $backSqlSize);
    }

    /**
     * Get directory size.
     *
     * @param  string $dir
     * @access public
     * @return int
     */
    public function getDirSize(string $dir): int
    {
        if(!file_exists($dir)) return 0;
        if(!is_readable($dir)) return 0;
        $totalSize = 0;
        $iterator  = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::LEAVES_ONLY, RecursiveIteratorIterator::CATCH_GET_CHILD);

        foreach($iterator as $file) $totalSize += $file->getSize();
        return $totalSize;
    }
}
