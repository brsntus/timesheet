<div class="content">
  <div class="page-header">
    <h1>Report <small>In this area you can view and export your employee's work hours</small></h1>
  </div>
  <div class="row">
    <div class="span13">
      <h2>From <input class="small" type="text" id="filter_start" value="<?=$start?>"> to <input class="small" type="text" id="filter_end" value="<?=$end?>"> <button class="btn change_filter">Change filter</button></h2>
    </div>

    <div class="span3">
      <button class="btn export_report">Export report</button>
    </div>
  </div>
  
  <br />

  <div class="row">
    <div class="span16">
      <ul class="tabs" id="users_tabs">
        <?php foreach ($users as $user): ?>
          <li<?=$user_id == $user->id ? ' class="active"' : ''?>><a href="#" class="employee" rel="<?=$user->id?>"><?=$user->name?></a></li>
        <?php endforeach ?>
      </ul>
    </div>

    <div class="clearfix"></div>
    <div class="span16">
      <div id="tab_content">
        <?php if ($user_id): ?>
          <?php echo $this->render('report/table', false); ?>
        <?php endif ?>
      </div>
      <span class="label notice">Weekend</span>
      <span class="label success">Holiday</span>
      <span class="label warning">Missed Work</span>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $('.change_filter').click(function() {
      $('.employee', 'li.active').trigger('click');
      return false;
    });

    $('.employee').click(function() {
      var start = $('#filter_start').val();
      var end = $('#filter_end').val();
      var user_id = $(this).attr('rel');
      $('#users_tabs li').removeClass('active');
      $('#users_tabs li a[rel='+user_id+']').parent('li').addClass('active');
      $('#tab_content')
        .block()
        .load('<?=BASE_PATH?>/report/get_employee/'+start+'/'+end+'/'+user_id, function() {
          $(this).unblock();
        });
      return false;
    });

    $('.export_report').click(function() {
      var user_id = $('#users_tabs li.active a').attr('rel');
      if (!user_id) {return false};
      var start = $('#filter_start').val();
      var end = $('#filter_end').val();
      window.location.href = '<?=BASE_PATH?>/report/export/'+start+'/'+end+'/'+user_id;
      return false;
    });
  });
</script>