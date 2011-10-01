<form action="<?=BASE_PATH?>/clock/save" method="POST" class="form-stacked" id="new_entry_form">
<div class="modal-header">
  <a href="#" class="close">&times;</a>
  <h3>Add</h3>
</div>
<div class="modal-body">
  <fieldset>
    <div class="clearfix">
      <label for="hours">Hour</label>
      <div class="input-append">
        <input class="span2" id="clock_time" name="clock_time" size="16" type="text" value="<?=date('H:i')?>">
        <label class="add-on"> <!-- active on hover-->
          <img src="<?=BASE_PATH?>/img/clock.png">
        </label>
        <span class="help-inline">
          This is the time asdfs
        </span>
      </div>
    </div><!-- /clearfix -->
    <div class="clearfix">
      <label for="task_date">Date</label>
      <div class="input-append">
        <input class="span2" id="clock_date" name="clock_date" size="16" type="text" value="<?=$date?>">
        <label class="add-on"> <!-- active on hover-->
          <a href="#"><img src="<?=BASE_PATH?>/img/calendar.png"></a>
        </label>
        <span class="help-inline">
          Leave blank if you want to start a timer.
        </span>
      </div>
    </div><!-- /clearfix -->
  </fieldset>  
</div>
<div class="modal-footer">
  <button class="btn primary btn_action" id="save_clock">Save</button>
  <button class="btn secondary btn_action" id="cancel_clock">Cancel</button>
  <span class="label" id="saving_clock" style="display: none; float:right; padding: 5px 14px 6px;">Saving... </span>
</div>
</form>

<script type="text/javascript" charset="utf-8">
  $(function() {
    $('#save_clock').click(function() {
      $('#new_entry_form').ajaxSubmit({
        beforeSubmit: function() {
          $('.btn_action').addClass('disabled').attr('disabled', 'disabled');
          $('#saving_clock').show();
        },
        success: function(responseText, statusText, xhr, $form) {
          //$('#modal_container').modal('hide').html('');
          window.location.reload();
        }
      });
      return false;
    });
    
    $('#cancel_clock').click(function() {
      $('#modal_container').modal('hide').html('');
      return false;
    });
  });
</script>