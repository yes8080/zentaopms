<?php
/**
 * The watermark view file of watermark module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel <?php echo $type == 'edit' ? 'edit-mode' : '';?>'>
  <div class='panel-heading'>
    <strong><?php echo $lang->watermark->common;?></strong>
  </div>
  <?php if($type == 'edit'):?>
  <form method="post" id="watermark-ajax-form" class="form-ajax watermark-form<?php if ($enabled == '1') echo ' watermark-enabled'; ?>">
    <div class='panel-body'>
      <div class='form-horizontal-2col'>
        <div class='form-row'>
          <div class='form-group form-group-full'>
            <label><?php echo $lang->watermark->switch; ?></label>
            <div class='watermark-field'>
              <?php echo html::radio('enabled', $lang->watermark->switchList, $enabled); ?>
            </div>
          </div>
        </div>
        <div class='form-row edit-row'>
          <div class='form-group form-group-full'>
            <label><?php echo $lang->watermark->content; ?></label>
            <div class='watermark-field'>
              <?php echo html::textarea('content', $content, 'rows="3" class="form-control" autocomplete="off"'); ?>
            </div>
          </div>
        </div>
        <div class='form-row edit-row tip-row'>
          <div class='form-group form-group-full'>
            <div class='watermark-tip'>
              <p><i class="icon icon-exclamation-sign" style="color: orange; margin-right: 4px;"></i><?php echo $lang->watermark->varTip; ?></p>
              <table class="table-bordered">
                <tbody>
                  <tr>
                    <th>displayName</th>
                    <td><?php echo $lang->watermark->displayName; ?></td>
                  </tr>
                  <tr>
                    <th>account</th>
                    <td><?php echo $lang->watermark->account; ?></td>
                  </tr>
                  <tr>
                    <th>email</th>
                    <td><?php echo $lang->watermark->email; ?></td>
                  </tr>
                  <tr>
                    <th>phone</th>
                    <td><?php echo $lang->watermark->phone; ?></td>
                  </tr>
                  <tr>
                    <th>date</th>
                    <td><?php echo $lang->watermark->date; ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class='form-row'>
          <div class='form-group form-actions'>
            <?php echo html::submitButton();?>
            <button type="button" class='btn btn-secondary btn-back' onclick="window.location.href='<?php echo $this->createLink('watermark', 'index');?>'"><?php echo $lang->goback;?></button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <?php else:?>
  <div class='read-view'>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->watermark->switch; ?></div>
      <div class='read-value'><?php echo $enabled == '1' ? $lang->on : $lang->off; ?></div>
    </div>
    <?php if($enabled == '1'): ?>
    <div class='read-row read-row-textarea'>
      <div class='read-label'><?php echo $lang->watermark->content; ?></div>
      <div class='read-value'>
        <?php echo html::textarea('content', $content, 'rows="3" class="form-control" disabled'); ?>
      </div>
    </div>
    <?php endif; ?>
    <div class='read-actions'>
      <?php echo html::linkButton('<i class="icon-edit"></i>  ' . $lang->editConfig, helper::createLink('watermark', 'index', 'type=edit'), 'btn btn-primary'); ?>
    </div>
  </div>
  <?php endif; ?>
</div>
  <?php if(($enabled == 1 && $type !== 'edit') || $type == 'edit'): ?>
  <div id="watermark-preview">
    <div class='panel-heading'>
      <strong><?= $lang->watermark->preview; ?></strong>
    </div>
    <div class="preview-content">
    <div id="preview-container">
      <img src="<?php echo $webRoot;?>theme/default/images/main/bg.svg" alt="Preview Background" class="preview-bg">
    </div>
    </div>
  </div>
  <?php endif;?>
<?php
    $jsRoot    = $webRoot . "js/";
    js::import($jsRoot  . 'watermark/index.iife.min.js');
?>
<script>
    const displayName = `<?= $displayName; ?>`;
    const account = `<?= $account; ?>`;
    const email = `<?= $email; ?>`;
    const phone = `<?= $phone; ?>`;
    let watermark = null;

    function setContentPreview(value)
    {
        const parent = document.querySelector('#preview-container');
        if(!value || !parent) return;

        const content = value.replace(/\$displayName/g, displayName)
            .replace(/\$account/g, account)
            .replace(/\$email/g, email)
            .replace(/\$phone/g, phone)
            .replace(/\$date/g, getCurrentDateFormatted())
            .split('\n')
            .filter(line => line.trim().length > 0)
            .join('\n');

        if(watermark) watermark.destroy();
        watermark = new WatermarkPlus.Watermark({
            content,
            contentType: 'multi-line-text',
            rotate: 35,
            parent: parent,
            fontSize: '20px',
            fontColor: 'rgba(0,0,0,0.15)',
            zIndex: 1,
        })
        watermark.create();
    }

    function getCurrentDateFormatted()
    {
        const today = new Date();
        const year = today.getFullYear();
        const month = ('0' + (today.getMonth() + 1)).slice(-2); // 月份是从0开始的，所以需要+1
        const day = ('0' + today.getDate()).slice(-2); // 日期

        return `${year}-${month}-${day}`;
    }

    $(() => {
        $.setAjaxForm('#watermark-ajax-form');
        
        // 编辑态：从textarea获取内容
        const $content = $('#content');
        if($content.length > 0) {
            $content.on('input', function() {
                setContentPreview($(this).val());
            });
            setContentPreview($content.val());
        } else {
            // 非编辑态：从PHP变量获取内容
            const content = `<?php echo addslashes($content ?? ''); ?>`;
            setContentPreview(content);
        }

        // 只在编辑态才需要控制显示/隐藏逻辑
        if($('input[name="enabled"]').length > 0) {
            function updateWatermarkVisibility() {
                var isEnabled = $('input[name="enabled"]:checked').val() === '1';
                $('#watermark-ajax-form').toggleClass('watermark-enabled', isEnabled);
                $('.edit-row').toggle(isEnabled);
                $('#watermark-preview').toggle(isEnabled);
            }

            $('input[name="enabled"]').on('change', function() {
                updateWatermarkVisibility();
            });
            
            // 初始化时设置一次，确保正确显示
            updateWatermarkVisibility();
        }
    });
</script>
<?php include '../../common/view/footer.html.php';?>
