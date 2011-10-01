<form action="<?=BASE_PATH?>/timesheet/save" method="POST" class="form-stacked" id="new_entry_form">
<div class="modal-header">
  <a href="#" class="close">&times;</a>
  <h3>New Entry</h3>
</div>
<div class="modal-body">
  
    <fieldset>
      <div class="clearfix">
        <label for="task">Task</label>
        <div class="input">
          <textarea class="span8" id="task" name="task" rows="3"></textarea>
          <span class="help-block">
            Describe the task.
          </span>
        </div>
      </div><!-- /clearfix -->
      <div class="clearfix">
        <label for="hours">Hours</label>
        <div class="input-append">
          <input class="span2" id="hours" name="hours" size="16" type="text" value="">
          <label class="add-on"> <!-- active on hover-->
            <img src="<?=BASE_PATH?>/img/clock.png">
          </label>
          <span class="help-inline">
            Leave blank if you want to start a timer.
          </span>
        </div>
      </div><!-- /clearfix -->
      <input name="task_date" type="hidden" value="<?=$date?>">
    </fieldset>
  
</div>
<div class="modal-footer">
  <button class="btn primary btn_action" id="save_timesheet">Save</button>
  <button class="btn secondary btn_action" id="cancel_timesheet">Cancel</button>
  <span class="label" id="saving_timesheet" style="display: none; float:right; padding: 5px 14px 6px;">Saving... </span>
</div>
</form>

<script type="text/javascript" charset="utf-8">
  $(function() {
    $('#save_timesheet').click(function() {
      $('#new_entry_form').ajaxSubmit({
        beforeSubmit: function() {
          $('.btn_action').addClass('disabled').attr('disabled', 'disabled');
          $('#saving_timesheet').show();
        },
        success: function(responseText, statusText, xhr, $form) {
          window.location.reload();
        }
      });
      return false;
    });
    
    $('#cancel_timesheet').click(function() {
      $('#modal_container').modal('hide').html('');
      return false;
    });
  });
</script>