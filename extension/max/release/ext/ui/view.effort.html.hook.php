<?php namespace zin;?>
<?php $release = data('release');?>
<?php if(!isInModal() && $release->status != 'terminate'):?>
<?php
global $app;
$effortHtml = $app->control->loadModel('effort')->createAppendLink('release', data('release.id'));
?>
<script>
$(function()
{
    $('#mainContent .detail-header .btn-group').first().prepend(<?php echo json_encode($effortHtml);?>);
})
</script>
<?php endif;?>
