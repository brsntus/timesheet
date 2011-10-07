<div class="content">
  <div class="page-header">
    <h1>Clock In/Out</h1>
  </div>
  <div class="row">
    <div class="span14">
      <h2>Week <?=date('W (Y)', strtotime($week))?> <small>Click the cells to edit</small></h2>
    </div>

    <div class="span2">
      <a href="<?=BASE_PATH?>/clock/index/<?=date('Y-W', strtotime($week." -1 week"))?>" class="btn">&lt;</a>
      <a href="<?=BASE_PATH?>/clock/index/<?=date('Y-W', strtotime($week." +1 week"))?>" class="btn">&gt;</a>
    </div>
  </div>

  <div class="row">
    <div class="span16">      
      <table class="zebra-striped">
        <thead>
          <tr>
            <?php foreach (Helper::days_of_the_week($week) as $day): ?>
              <th style="text-align:center;"><?=$day?></th>
            <?php endforeach ?>
          </tr>
        </thead>
        <tbody>          
          <?php
          $days_of_the_week = Helper::days_of_the_week($week, 'Y-m-d');

          $total_hours = array();
          foreach ($days_of_the_week as $d) {
            if (array_key_exists($d, $clocks)) {
              $cur = $clocks[$d];
              $qtd = count($cur);
              $tot = 0;
              for ($i=0; $i < $qtd; $i+=2) {
                $a = strtotime('1970-01-01 '.$cur[$i]->clock_time);
                if (array_key_exists($i+1, $cur)) {
                  $b = strtotime('1970-01-01 '.$cur[$i+1]->clock_time);
                  $tot += $b-$a;
                }
              }
              $total_hours[$d] = Helper::seconds_to_hours($tot);
            } else {
              $total_hours[$d] = '-';
            }
          }          

          $bigger = 0;

          foreach ($clocks as $key => $value) {
            $cont = count($value);
            if ($cont > $bigger) {
              $bigger = $cont;
            }
          }
          $rows = array();
          foreach ($clocks as $date => $clock) {
            for ($i=0; $i < $bigger; $i++) { 
              $rows[$date][$i] = array_key_exists($i, $clock) ? $clock[$i] : false;
            }
          }
          ?>

          <?php for ($i = 0; $i < $bigger; $i++) { ?>
            <tr>
              <?php foreach ($days_of_the_week as $dotw): ?>
                <?php if (array_key_exists($dotw, $rows) && $rows[$dotw][$i]): ?>
                  <td style="text-align:center;" class="edit_clock" rel="<?=$rows[$dotw][$i]->id?>"><?=$rows[$dotw][$i]->clock_time?></td>
                <?php else: ?>
                  <td style="text-align:center;" class="add_clock" rel="<?=$dotw?>">-</td>
                <?php endif ?>                
              <?php endforeach ?>
            </tr>
          <?php } ?>

          <tr>
            <?php foreach ($days_of_the_week as $dotw): ?>
              <?php if ($total_hours[$dotw] == '-'): ?>
                <td style="text-align:center;"><strong>-</strong></td>
              <?php else: ?>
                <?php
                $h = intval(substr($total_hours[$dotw], 0, 2));
                $m = intval(substr($total_hours[$dotw], 3, 2));
                $hm = ($h*60+$m)/60;
                $class = 'blue';
                if ($hm > Session::get('hours_per_day')) {
                  $class = 'green';
                } else if ($hm < Session::get('hours_per_day')) {
                  $class = 'red';
                } else if ($hm == Session::get('hours_per_day')) {
                  $class = 'blue';
                }
                ?>
                <td style="text-align:center;" class="<?=$class?>"><strong><?=$total_hours[$dotw]?></strong></td>
              <?php endif ?>              
            <?php endforeach ?>
          </tr>
        </tbody>
      </table>
      <button class="btn primary add_clock" rel="<?=date('Y-m-d')?>">Clock In/Out</button>
    </div>
  </div>
</div>

<div id="modal_container" class="modal hide fade"></div>

<script type="text/javascript" charset="utf-8">
  $(function() {
    $('.edit_clock').live('click', function() {
      var dat = $(this).attr('rel');
      $.get('<?=BASE_PATH?>/clock/_edit_clock/'+dat, function(data) {
        $('#modal_container').html(data).modal({backdrop: 'static', keyboard: true, show: true});
      });
      return false;
    });
    
    $('.add_clock').live('click', function() {
      var dat = $(this).attr('rel');
      $.get('<?=BASE_PATH?>/clock/_add_clock/'+dat, function(data) {
        $('#modal_container').html(data).modal({backdrop: 'static', keyboard: true, show: true});
      });
      return false;
    });
  });
</script>