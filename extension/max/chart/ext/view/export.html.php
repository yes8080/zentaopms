<?php if($mode == 'preview') include $app->getModuleRoot() . 'common/view/header.html.php';?>
<?php js::set('emptyLang', $emptyLang);?>
<?php js::set('errorNoChart', $lang->report->errorNoChart);?>
<?php js::set('errorExportChart', $lang->report->errorExportChart);?>
<?php js::set('mode', $mode);?>
<style>
.modal-title-name {font-weight: 700;}
#main {min-width: 580px;}
</style>
<?php if($mode == 'preview'):?>
<div class='modal-title-name'><?php echo $lang->export;?></div>
<?php endif;?>
<form method='post' action='<?php echo $this->createLink('chart', 'export')?>' style="margin:15px 20px;" id='exportForm'>
  <table class='table table-form' style='padding:30px'>
    <tr>
      <th class='w-100px'><?php echo $lang->setFileName;?></th>
      <td class='required'><input type="text" name="fileName" id="fileName" class="form-control"></td>
      <td>
        <?php
        echo html::select('fileType',   array('docx' => 'docx'), '', 'class="form-control"');
        ?>
      </td>
      <td><?php echo html::submitButton($lang->save, '', 'btn btn-primary upload-btn') . html::hidden('items', $chartID) . html::hidden('datas');?></td>
    </tr>
  </table>
</form>
<script>
$(function()
{
    $('#exportForm #submit').click(async function(event)
    {
        event.preventDefault();

        var $submitButton = $(this);
        var form          = this.form;
        if($('#fileName').val() == '')
        {
            bootbox.alert(emptyLang);
            return false;
        }
        if(mode == 'design')
        {
            $(":checkbox:checked[name^='charts']").each(function()
            {
                items = $('#exportForm #items').val();
                items += $(this).val() + ',';
                $('#exportForm #items').val(items);
            });
        }
        else
        {
            var moduleMenu  = parent.$('#moduleMenu menu').zui('tree');
            var checkedList = moduleMenu.$.getChecks();
            var checkedMap  = moduleMenu.$._itemMap;

            var valueList = [];
            for (var i = 0; i < checkedList.length; i++)
            {
                var key = checkedList[i];
                if(checkedMap.get(key).level == 0) continue;

                var value = checkedMap.get(key).key;
                valueList.push(value);
            }

            $('#exportForm #items').val(valueList.join(','));
        }

        $('#exportForm .export-data').remove();

        var dataBox    = "<input type='hidden' class='export-data' name='%name%' id='%id%' />";
        var echartDivs = mode == 'design' ? $('.echart-content') : parent.$('.echart-content');
        var canvasSize = echartDivs.length;
        if(canvasSize == 0)
        {
            bootbox.alert(errorNoChart);
            return false;
        }

        echartDivs.each(function(i)
        {
            var $canvas = $(this).find('canvas');
            var canvas  = $canvas[0];

            if($canvas.length > 0 && typeof(canvas.toDataURL) == 'undefined')
            {
                bootbox.alert(errorExportChart);
                return false;
            }
            var dataURL     = $canvas.length > 0 ? canvas.toDataURL("image/png") : '';
            var dataID      = $(this).data('id');
            var groupID     = $(this).data('group');
            var chartID     = groupID + '_' + dataID;
            var thisDataBox = dataBox.replace('%name%', chartID);
            thisDataBox = thisDataBox.replace('%id%', chartID);
            $('#exportForm #submit').after(thisDataBox);
            if($canvas.length > 0) $('#exportForm #' + chartID).val(dataURL);
        });

        $submitButton.prop('disabled', true).addClass('disabled');
        try
        {
            var response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                credentials: 'same-origin',
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            });
            if(!response.ok) throw new Error(response.statusText || response.status);

            var contentType        = response.headers.get('content-type') || '';
            var contentDisposition = response.headers.get('content-disposition') || '';
            if(!contentDisposition && contentType.indexOf('application/octet-stream') < 0)
            {
                var errorHTML = await response.text();
                var errorText = new DOMParser().parseFromString(errorHTML, 'text/html').body.innerText.trim();
                throw new Error(errorText || errorExportChart);
            }

            var blob = await response.blob();
            var url  = URL.createObjectURL(blob);
            var link = document.createElement('a');
            link.href     = url;
            link.download = $('#fileName').val() + '.' + $('#fileType').val();
            document.body.appendChild(link);
            link.click();
            link.remove();
            setTimeout(function(){URL.revokeObjectURL(url);}, 1000);

            mode == 'design' ? $('.close').click() : parent.$('.close')[0].click();
        }
        catch(error)
        {
            bootbox.alert(error.message || errorExportChart);
        }
        finally
        {
            $submitButton.prop('disabled', false).removeClass('disabled');
        }
    });
})

</script>
<?php if($mode == 'preview') include $app->getModuleRoot() . 'common/view/footer.html.php';?>
