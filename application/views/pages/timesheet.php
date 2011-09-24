<div class="content">
  <div class="page-header">
    <h1>Timesheet <small>Supporting text or tagline</small></h1>
  </div>
  <div class="row">
    <div class="span12">
      <h2><?=date('l, d M')?></h2>
    </div>
    <div class="span4">
      <div class="clearfix">
        <div class="input-append">
          <input class="span2" id="appendedInput" name="appendedInput" size="16" type="text" value="<?=date('d/m/Y')?>">
          <label class="add-on"> <!-- active on hover-->
            <a href="#"><img src="<?=BASE_PATH?>/img/calendar.png"></a>
          </label>
        </div>
      </div>
      <button class="btn">&lt;</button>
      <button class="btn">&gt;</button>
    </div>
  </div>
  
  <div class="row">
    <div class="span16">
      <div class="alert-message block-message warning" id="confirm_delete" style="display:none;">
        <p><strong>Are you sure you want to delete this task?</strong></p>
        <div class="alert-actions">
          <button class="btn small danger">Delete</button> <button class="btn small secondary">Cancel</button>
        </div>
      </div>
      
      <table class="zebra-striped">
        <tbody>
          <tr>
            <td width="80%">Reunião com Daniel, Danillo e Klênio</td>
            <td width="5%">00:15</td>
            <td width="15%">
              <a href="#" class="btn small"><img src="<?=BASE_PATH?>/img/clock_play.png"></a>
              <a href="#" class="btn small"><img src="<?=BASE_PATH?>/img/edit.png"></a>
              <a href="#" class="btn small delete"><img src="<?=BASE_PATH?>/img/delete.png"></a>
            </td>
          </tr>
          <tr>
            <td>Reunião com Daniel, Danillo e Klênio</td>
            <td>00:15</td>
            <td>
              <a href="#" class="btn small"><img src="<?=BASE_PATH?>/img/clock_stop.png"></a>
              <a href="#" class="btn small disabled"><img src="<?=BASE_PATH?>/img/edit.png"></a>
              <a href="#" class="btn small disabled"><img src="<?=BASE_PATH?>/img/delete.png"></a>
            </td>
          </tr>
          <tr>
            <td>
              <button data-controls-modal="modal-from-dom" data-backdrop="static" data-keyboard="true" class="btn primary">New Entry</button>
            </td>
            <td><strong>00:30</strong></td>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="modal-from-dom" class="modal hide fade">
  <div class="modal-header">
    <a href="#" class="close">&times;</a>
    <h3>New Entry</h3>
  </div>
  <div class="modal-body">
    <form action="" class="form-stacked">
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
        <div class="clearfix">
          <label for="date">Date</label>
          <div class="input-append">
            <input class="span2" id="date" name="date" size="16" type="text" value="<?=date('d/m/Y')?>">
            <label class="add-on"> <!-- active on hover-->
              <a href="#"><img src="<?=BASE_PATH?>/img/calendar.png"></a>
            </label>
            <span class="help-inline">
              Leave blank if you want to start a timer.
            </span>
          </div>
        </div><!-- /clearfix -->
      </fieldset>
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn secondary">Cancel</button>
    <button class="btn primary">Save</button>    
  </div>
</div>

<script type="text/javascript" charset="utf-8">
  $(function() {
    $('.delete').click(function() {
      $('#confirm_delete').show();
      return false;
    });
  })
</script>