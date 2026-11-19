<?php
/**
 * The upload client view of client module of xxb.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      XXB
 * @package     client
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php include '../../common/view/header.lite.html.php';?>
<style>
html,body { overflow: hidden; }
.upload-client-modal { padding: 20px; box-sizing: border-box; }
.upload-client-modal .upload-client-title { text-align: center; font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 12px; }
.upload-client-modal .upload-client-desc { font-size: 14px; color: #6B7280; line-height: 22px; margin-bottom: 20px; }
.upload-client-modal .upload-client-file-wrap { border: 1px dashed #D1D5DB; border-radius: 8px; background: #F9FAFB; padding: 24px; text-align: center; margin-bottom: 20px; cursor: pointer; transition: all 0.2s; }
.upload-client-modal .upload-client-file-wrap:hover { border-color: #1E6AEB; background: #F0F7FF; }
.upload-client-modal .upload-client-file-wrap.disabled { opacity: 0.5; cursor: not-allowed; }
.upload-client-modal .upload-client-file-label { display: block; width: 100%; height: 100%; color: #1E6AEB; cursor: pointer; font-size: 14px; margin: 0; }
.upload-client-modal .upload-client-file-label input[type="file"] { position: absolute; left: -9999px; }
.upload-client-modal .upload-client-file-list { margin-bottom: 20px; }
.upload-client-modal .upload-client-file-status-item { display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #FFFFFF; border: 1px solid #E5E7EB; border-radius: 6px; margin-bottom: 8px; font-size: 14px; }
.upload-client-modal .upload-client-file-status-item:last-child { margin-bottom: 0; }
.upload-client-modal .upload-client-file-status-name { flex: 1; color: #111827; margin-right: 12px; }
.upload-client-modal .upload-client-file-status-file { color: #6B7280; font-size: 12px; margin-right: 12px; font-family: monospace; }
.upload-client-modal .upload-client-file-status-badge { font-size: 12px; padding: 2px 8px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; text-align: center; white-space: nowrap; }
.upload-client-modal .upload-client-file-status-badge.empty { color: #9CA3AF; }
.upload-client-modal .upload-client-file-status-badge.exists { background: #D1FAE5; color: #065F46; }
.upload-client-modal .upload-client-file-status-badge.uploading { background: #DBEAFE; color: #1E40AF; }
.upload-client-modal .upload-client-file-status-badge.success { background: #D1FAE5; color: #065F46; }
.upload-client-modal .upload-client-file-status-badge.fail { background: #FEE2E2; color: #991B1B; }
.upload-client-modal .upload-client-file-status-badge i { font-size: 18px; }
.upload-client-modal .upload-client-file-status-badge.empty i { color: #991B1B; }
.upload-client-modal .upload-client-file-status-badge.exists i { color: #065F46; }
.upload-client-modal .upload-client-error { color: #E74C3C; font-size: 14px; margin-bottom: 16px; }
</style>
<div class="upload-client-modal">
  <?php if(!$writable): ?>
  <div class="upload-client-error"><?php echo $writableTip; ?></div>
  <?php else: ?>
  <div class="upload-client-desc"><?php echo $lang->client->uploadClientModalDesc; ?></div>
  <label class="upload-client-file-label">
    <div class="upload-client-file-wrap" id="fileWrap">
      + <?php echo $lang->client->selectFile; ?>
      <input type="file" name="file[]" id="fileInput" multiple />
    </div>
  </label>
  <div class="upload-client-file-list">
    <?php foreach($fileStatus as $os => $status): ?>
    <div class="upload-client-file-status-item" data-os="<?php echo $os; ?>">
      <span class="upload-client-file-status-name"><?php echo $status['label']; ?></span>
      <span class="upload-client-file-status-file"><?php echo $status['fileName']; ?></span>
      <span class="upload-client-file-status-badge <?php echo $status['exists'] ? 'exists' : 'empty'; ?>" id="status-<?php echo $os; ?>">
        <?php if($status['exists']): ?>
          <i class="icon icon-ok"></i>
          <span><?php echo $lang->client->uploadClientFileExists; ?></span>
        <?php else: ?>
          <i class="icon icon-remove"></i>
          <span><?php echo $lang->client->uploadClientFileNotExists; ?></span>
          <span></span>
        <?php endif; ?>
      </span>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="upload-client-actions" style="margin-bottom: 12px; text-align: right;">
    <button type="button" class="btn btn-primary btn-sm" id="fetchFromOfficialBtn">
      <?php echo $lang->client->uploadClientFromOfficial; ?>
    </button>
  </div>
<script>
$(function() {
    var uploadUrl     = '<?php echo inlink('uploadClient'); ?>';
    var downloadUrl   = '<?php echo inlink('ajaxGetClientPackage', 'os='); ?>';
    var fileStatusMap = <?php echo json_encode($fileStatus); ?>;
    var version       = '<?php echo $version; ?>';

    var langDownloading     = <?php echo json_encode($lang->client->uploadClientDownloading); ?>;
    var langDownloadSuccess = <?php echo json_encode($lang->client->uploadClientDownloadSuccess); ?>;
    var langDownloadFail    = <?php echo json_encode($lang->client->uploadClientDownloadFail); ?>;
    var langUnknownOS       = <?php echo json_encode($lang->client->uploadClientUnknownOS); ?>;
    var $fetchBtn           = $('#fetchFromOfficialBtn');
    
    function detectOSFromFileName(fileName) {
        var lowerName = fileName.toLowerCase();
        if (lowerName.endsWith('win64.setup.exe')) return 'win64';
        if (lowerName.endsWith('win32.setup.exe')) return 'win32';
        if (lowerName.endsWith('linux.amd64.deb')) return 'linux64';
        if (lowerName.endsWith('linux.arm64.deb')) return 'linuxarm';
        if (lowerName.endsWith('mac.m1.dmg'))      return 'mac.m1';
        if (lowerName.endsWith('mac.dmg'))         return 'mac';
        return null;
    }
    
    function updateStatus(os, className, text) {
        var $status = $('.upload-client-file-status-item[data-os=\"' + os + '\"] .upload-client-file-status-badge');
        if ($status.length) {
            var iconClass = '';
            if (className === 'exists' || className === 'success') {
                iconClass = 'icon-ok';
            } else if (className === 'uploading') {
                iconClass = 'icon-spinner icon-spin';
            } else if (className === 'fail') {
                iconClass = 'icon-remove';
            } else if (className === 'empty') {
                iconClass = 'icon-circle';
            }
            
            $status.removeClass('empty exists uploading success fail').addClass(className);
            if (text) {
                $status.html('<i class="icon ' + iconClass + '"></i><span>' + text + '</span>');
            } else {
                $status.html('<i class="icon ' + iconClass + '"></i><span></span>');
            }
        }
    }
    
    function uploadFile(file, os) {
        return new Promise(function(resolve, reject) {
            if (!os) {
                reject(langUnknownOS);
                return;
            }
            
            updateStatus(os, 'uploading', '<?php echo $lang->client->uploadClientUploading; ?>');
            
            var formData = new FormData();
            formData.append('file', file);
            formData.append('os', os);
            
            $.ajax({
                url: uploadUrl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    if (response && response.result === 'success') {
                        updateStatus(os, 'success', '<?php echo $lang->client->uploadClientUploadSuccess; ?>');
                        setTimeout(function() {
                            updateStatus(os, 'exists', '<?php echo $lang->client->uploadClientFileExists; ?>');
                        }, 2000);
                        resolve(response);
                    } else {
                        var errorMsg = (response && response.message) ? response.message : '<?php echo $lang->client->uploadClientUploadFail; ?>';
                        updateStatus(os, 'fail', errorMsg);
                        reject(errorMsg);
                    }
                },
                error: function(xhr, status, error) {
                    var errorMsg = '<?php echo $lang->client->uploadClientUploadFail; ?>';
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response && response.message) errorMsg = response.message;
                    } catch(e) {}
                    updateStatus(os, 'fail', errorMsg);
                    reject(errorMsg);
                }
            });
        });
    }

    function downloadOfficialPackage(os)
    {
        return new Promise(function(resolve, reject) {
            updateStatus(os, 'uploading', langDownloading);

            $.ajax({
                url: downloadUrl + os,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response && response.result === 'success') {
                        updateStatus(os, 'success', response.message || langDownloadSuccess);
                        setTimeout(function() {
                            updateStatus(os, 'exists', '<?php echo $lang->client->uploadClientFileExists; ?>');
                        }, 2000);
                        resolve(response);
                    } else {
                        var errorMsg = (response && response.message) ? response.message : langDownloadFail;
                        updateStatus(os, 'fail', errorMsg);
                        reject(errorMsg);
                    }
                },
                error: function(xhr, status) {
                    var errorMsg = langDownloadFail;
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response && response.message) errorMsg = response.message;
                    } catch(e) {}
                    updateStatus(os, 'fail', errorMsg);
                    reject(errorMsg);
                }
            });
        });
    }

    /* 手动触发：从官网下载缺失安装包（异步，串行避免高并发）。 */
    function autoFetchMissingPackages() {
        var osList = Object.keys(fileStatusMap || {});
        if (!osList.length) return;

        var queue = osList.filter(function(os) {
            var st = fileStatusMap[os];
            return st && !st.exists;
        });
        if (!queue.length) return;

        $fetchBtn.prop('disabled', true).addClass('disabled');

        function runNext() {
            if (!queue.length) {
                $fetchBtn.prop('disabled', false).removeClass('disabled');
                return;
            }
            var os = queue.shift();
            downloadOfficialPackage(os)
                .catch(function() {
                    /* 单个失败只更新状态，不中断后续 OS。 */
                })
                .finally(runNext);
        }

        runNext();
    }

    $('#fetchFromOfficialBtn').on('click', function() {
        autoFetchMissingPackages();
    });
    
    $('#fileInput').on('change', function() {
        var files = Array.from(this.files);
        if (files.length === 0) return;
        
        var $wrap = $('#fileWrap');
        $wrap.addClass('disabled');
        $(this).prop('disabled', true);
        
        var uploadPromises = [];
        files.forEach(function(file) {
            var os = detectOSFromFileName(file.name);
            if (os) {
                uploadPromises.push(uploadFile(file, os));
            } else {
                var msgTemplate = '<?php echo $lang->client->uploadClientCannotDetectOS; ?>';
                var msg = msgTemplate.replace('%s', file.name);
                alert(msg);
            }
        });
        
        if (uploadPromises.length === 0) {
            $wrap.removeClass('disabled');
            $(this).prop('disabled', false);
            this.value = '';
            return;
        }
        
        var successCount = 0;
        var completedCount = 0;
        uploadPromises.forEach(function(promise) {
            promise.then(function() {
                successCount++;
            }).catch(function() {
                // Error already handled in uploadFile
            }).finally(function() {
                completedCount++;
                if (completedCount === uploadPromises.length) {
                    $wrap.removeClass('disabled');
                    $wrap.find('#fileInput').prop('disabled', false);
                    $('#fileInput')[0].value = '';
                    
                    if (successCount > 0 && parent && parent.location) {
                        setTimeout(function() {
                            parent.location.reload();
                        }, 2000);
                    }
                }
            });
        });
    });
});
</script>
  <?php endif; ?>
</div>
<?php include '../../common/view/footer.modal.html.php';?>
