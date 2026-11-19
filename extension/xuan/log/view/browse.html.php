<?php
include '../../common/view/header.html.php';
include '../../common/view/datepicker.html.php'
?>
<div class='row'>
  <div class='col-md-12'>
    <div class='clearfix'>
      <div class='panel'>
        <div class='panel-heading'>
          <form method='post' class='form-search header-form' action=''>
            <div class='header-left'>
              <input type='hidden' name='objectType' id='objectTypeInput' value='<?php echo $objectType; ?>'>
              <div class='type-tabs'>
                <?php foreach($lang->log->typeArray as $typeKey => $typeLabel): ?>
                  <?php
                    $count = 0;
                    if(isset($typeCounts) && is_array($typeCounts) && isset($typeCounts[$typeKey])) {
                      $count = (int)$typeCounts[$typeKey];
                    } elseif($typeKey == $objectType && isset($pager)) {
                      $count = (int)$pager->recTotal;
                    }
                  ?>
                  <button type='button' class='type-tab<?php echo $typeKey == $objectType ? ' active' : '';?>' data-value='<?php echo $typeKey; ?>'>
                    <?php echo $typeLabel; ?>
                    <?php if($typeKey === $objectType): ?>
                    <span class='type-count'><?php echo $count; ?></span>
                    <?php endif; ?>
                  </button>
                <?php endforeach; ?>
              </div>
            </div>
            <div class='header-right'>
              <?php echo html::input('search', $search, "class='form-control search-query' placeholder='{$lang->user->inputAccount}'"); ?>
              <input id="date" name="date" type="text" class="form-control form-date" placeholder="<?php echo $lang->log->datePlaceholder; ?>" readonly="readonly" value="<?php echo $date; ?>">
              <span class="btn-group">
                <?php echo html::submitButton($lang->user->searchUser, "btn btn-primary"); ?>
                <?php echo html::a(inlink('browse'), $lang->log->reset, "class='btn'"); ?>
              </span>
            </div>
          </form>
        </div>
        <?php if(empty($records)): ?>
        <div class='empty-state'>
          <div class='empty-message'><?php echo $lang->pager->noRecord; ?></div>
        </div>
        <?php else: ?>
        <table class='table table-hover table-striped table-bordered tablesorter table-fixed'>
          <thead>
            <tr>
              <?php $vars = "orderBy=%s&objectType={$objectType}&search={$search}&date={$date}&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}&pageID={$pager->pageID}"; ?>
              <th>ID</th>
              <th><?php echo $lang->log->objectType; ?></th>
              <th><?php echo $lang->log->objectId; ?></th>
              <th><?php echo $lang->log->actor; ?></th>
              <th><?php echo $lang->log->action; ?></th>
              <th><?php echo $lang->log->result; ?></th>
              <th><?php echo $lang->log->ip; ?></th>
              <th><?php commonModel::printOrderLink('date', $orderBy, $vars, $lang->log->date); ?></th>
              <th><?php echo $lang->log->comment; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $index = 0; ?>
            <?php foreach($records as $record) : ?>
              <tr>
                <td><?php echo ++$index + ($pager->pageID - 1) * intval($pager->recPerPage); ?></td>
                <td><?php echo $lang->log->typeArray[$record->objectType]; ?></td>
                <td><?php echo $record->objectID; ?></td>
                <td><?php echo $userPairs[$record->actor]; ?></td>
                <td><?php echo isset($lang->log->actionName[$record->action]) ? $lang->log->actionName[$record->action] : $record->action; ?></td>
                <td><?php echo $lang->log->resultName[$record->result]; ?></td>
                <td><?php echo $record->ip; ?></td>
                <td><?php echo $record->date; ?></td>
                <td>
                  <?php
                    echo empty($record->comment)
                      ? '--'
                      : "<a class='show-comment' data-toggle='modal' data-target='#comment-modal' data-comment='" . htmlspecialchars($record->comment, ENT_QUOTES, 'UTF-8') . "'>{$lang->log->view}</a>"
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class='table-footer'><?php $pager->show(); ?></div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="comment-modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
        <h4 class="modal-title"><?php echo $lang->log->comment; ?></h4>
      </div>
      <div class="modal-body" style="word-break: break-word;">
      </div>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.html.php'; ?>

<script>
$(function(){
  $('.type-tab').on('click', function(e){
    e.preventDefault();
    var value = $(this).data('value');
    var $form = $(this).closest('form');
    $('#objectTypeInput').val(value);
    $(this).addClass('active').siblings('.type-tab').removeClass('active');
    
    // 使用原型链的 submit 方法，避免被表单元素覆盖
    HTMLFormElement.prototype.submit.call($form[0]);
  });
  
  // 确保 date 选择也能触发提交
  $('#date').on('change', function(){
    var form = $(this).closest('form')[0];
    HTMLFormElement.prototype.submit.call(form);
  });
});
</script>
