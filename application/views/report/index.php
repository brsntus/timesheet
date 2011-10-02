<div class="content">
  <div class="page-header">
    <h1>Report <small>Supporting text or tagline</small></h1>
  </div>
  <div class="row">
    <div class="span10">
      <h2>From <input class="small" type="text" id="filter_start" value="<?=$report['start']?>"> to <input class="small" type="text" id="filter_end" value="<?=$report['end']?>"></h2>
    </div>

    <div class="span6">
      <button class="btn change_filter">Change filter</button>
      <button class="btn export_report">Export report</button>
      <button class="btn send_email" disabled="disabled">Send via email</button>
    </div>
  </div>
  
  <div class="row">
    <div class="span16">      
      <?php echo $this->render('report/table', false); ?>
      <span class="label notice">Weekend</span>
      <span class="label success">Holiday</span>
      <span class="label warning">Missed Work</span>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
  $(function() {
    $('.change_filter').click(function() {
      var start = $('#filter_start').val();
      var end = $('#filter_end').val();
      window.location.href = '<?=BASE_PATH?>/report/index/'+start+'/'+end;
      return false;
    });
    
    $('.export_report').click(function() {
      var start = $('#filter_start').val();
      var end = $('#filter_end').val();
      window.location.href = '<?=BASE_PATH?>/report/export/'+start+'/'+end;
      return false;
    });
  });
</script>