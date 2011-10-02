<div class="content">
  <div class="page-header">
    <h1>Timesheet <small>Track the time of the tasks you accomplish throughout the day</small></h1>
  </div>
  <div class="row">
    <div class="span14">
      <h2><?=date('l, d M', strtotime($date))?></h2>
    </div>
    <div class="span2">
      <a href="<?=BASE_PATH?>/timesheet/index/<?=date('Y-m-d', strtotime($date." -1 day"))?>" class="btn">&lt;</a>
      <a href="<?=BASE_PATH?>/timesheet/index/<?=date('Y-m-d', strtotime($date." +1 day"))?>" class="btn">&gt;</a>
    </div>
  </div>
  
  <div class="row">
    <div class="span16">
      <table class="zebra-striped">
        <tbody>
          <?php foreach ($timesheet as $ts): ?>
            <tr>
              <td width="80%"><?=nl2br($ts->task)?></td>
              <?php if ($ts->timer_on): ?>
                <td width="5%" class="hours started" rel="<?=$ts->id?>" data-countdown="<?=$ts->countdown?>"><?=$ts->hours?></td>
              <?php else: ?>
                <td width="5%" class="hours stoped" rel="<?=$ts->id?>" data-countdown="<?=$ts->countdown?>"><?=$ts->hours?></td>
              <?php endif ?>              
              <td width="15%">
                <?php if ($ts->timer_on): ?>
                  <a href="#" class="btn small start_timer" rel="<?=$ts->id?>" style="display:none;"><img src="<?=BASE_PATH?>/img/clock_play.png"></a>
                  <a href="#" class="btn small stop_timer" rel="<?=$ts->id?>"><img src="<?=BASE_PATH?>/img/clock_stop.png"></a>
                  <a href="#" class="btn small disabled edit" rel="<?=$ts->id?>"><img src="<?=BASE_PATH?>/img/edit.png"></a>
                  <a href="#" class="btn small disabled delete" rel="<?=$ts->id?>"><img src="<?=BASE_PATH?>/img/delete.png"></a>
                <?php else: ?>
                  <a href="#" class="btn small start_timer" rel="<?=$ts->id?>"><img src="<?=BASE_PATH?>/img/clock_play.png"></a>
                  <a href="#" class="btn small stop_timer" rel="<?=$ts->id?>" style="display:none;"><img src="<?=BASE_PATH?>/img/clock_stop.png"></a>
                  <a href="#" class="btn small edit" rel="<?=$ts->id?>"><img src="<?=BASE_PATH?>/img/edit.png"></a>
                  <a href="#" class="btn small delete" rel="<?=$ts->id?>"><img src="<?=BASE_PATH?>/img/delete.png"></a>
                <?php endif ?>
              </td>
            </tr>
          <?php endforeach ?>
          <tr>
            <td width="80%">
              <button class="btn primary" id="add_timesheet">New Entry</button>
            </td>
            <td width="5%" style="text-align:center;"><strong>00:00:00</strong></td>
            <td width="15%">&nbsp;</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div id="modal_container" class="modal hide fade"></div>

<?=HTML::includeJs('jquery.countdown.pack')?>
<script type="text/javascript" charset="utf-8">
  $(function() {
    $('.hours.stoped').each(function(el) {
      var since = new Date($(this).attr('data-countdown'));
      $(this).countdown({since: since, compact: true, format: 'HMS'}).countdown('pause');
    });
    
    $('.hours.started').each(function(el) {
      var since = new Date($(this).attr('data-countdown'));
      $(this).countdown({since: since, compact: true, format: 'HMS'});
    });
    
    $('.delete').click(function() {
      if (confirm('Are you sure?')) {
        $.post('<?=BASE_PATH?>/timesheet/delete/'+$(this).attr('rel'), function(data) {
          if (data === '1') {
            window.location.reload();
          } else {
            alert('There was an error when trying to delete this record');
          };
        })
      };
      return false;
    });
    
    $('#new_entry_form').submit(function() {
      $(this).ajaxSubmit({
        beforeSubmit: function() {
          $('#new_entry_form_container').block();
        },
        success: function(responseText, statusText, xhr, $form) {
          alert(responseText);
          $('#new_entry_form_container').unblock().modal('hide');
        }
      });
      return false;
    });
    
    $('#add_timesheet').click(function() {
      $.get('<?=BASE_PATH?>/timesheet/_add_timesheet/<?=$date?>', function(data) {
        $('#modal_container').html(data).modal({backdrop: 'static', keyboard: true, show: true});
      });
      return false;
    });
    
    $('.edit').click(function() {
      var id = $(this).attr('rel');
      $.get('<?=BASE_PATH?>/timesheet/_edit_timesheet/'+id, function(data) {
        $('#modal_container').html(data).modal({backdrop: 'static', keyboard: true, show: true});
      });
      return false;
    });
    
    $('.start_timer').live('click', function() {
      var id = $(this).attr('rel');
      $.post('<?=BASE_PATH?>/timesheet/start_timer/'+id, function(data) {
        $('a.edit[rel='+id+']').addClass('disabled');
        $('a.delete[rel='+id+']').addClass('disabled');
        $('a.start_timer[rel='+id+']').hide();
        $('a.stop_timer[rel='+id+']').show();
        $('td.hours[rel='+id+']').countdown('resume').removeClass('stoped').addClass('started');
      });
      return false;
    });
    
    $('.stop_timer').live('click', function() {
      var id = $(this).attr('rel');
      $.post('<?=BASE_PATH?>/timesheet/stop_timer/'+id, function(data) {
        $('a.edit[rel='+id+']').removeClass('disabled');
        $('a.delete[rel='+id+']').removeClass('disabled');
        $('a.start_timer[rel='+id+']').show();
        $('a.stop_timer[rel='+id+']').hide();
        $('td.hours[rel='+id+']').countdown('pause').removeClass('started').addClass('stoped');
      });
      return false;
    });
  });
</script>