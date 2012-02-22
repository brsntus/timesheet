<table <?=isset($border) ? 'border="1"' : ''?>>
  <thead>
    <tr>
      <th>Day</th>
      <th>Tasks</th>
      <?php for ($i=0; $i < $report['clocks_columns']; $i=$i+2) { ?>
        <th>In</th>
        <th>Out</th>
      <?php } ?>
      <th>Total</th>
      <th>Extra</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($report['calendar'] as $date): ?>
      <?php
      $type = false;
      $msg = false;
      $weekday = date('l', strtotime($date));
      if ($weekday == 'Saturday' || $weekday == 'Sunday') {
        $type = '#62cffc';
        $msg = $weekday;
      }
      if (array_key_exists($date, $report['holidays'])) {
        $type = '#46a546';
        $msg = $report['holidays'][$date]->title;
      }
      ?>
      <?php if (array_key_exists($date, $report['clocks'])): ?>
        <?php if (array_key_exists($date, $report['timesheets'])): ?>
          <?php $rowspan = count($report['timesheets'][$date]); ?>
          <?php $first = true; ?>
          <?php foreach ($report['timesheets'][$date] as $timesheets): ?>          
            <?php if ($first): ?>
              <?php $first = false; ?>
              <tr>
                <td bgclor="<?=$type?>" rowspan="<?=$rowspan?>" style="vertical-align:middle;text-align:center;"><?=$timesheets->task_date?></td>
                <td bgclor="<?=$type?>"><?=$timesheets->task?></td>
                <?php for ($i=0; $i < $report['clocks_columns']; $i=$i+2) { ?>
                  <td bgclor="<?=$type?>" rowspan="<?=$rowspan?>" style="vertical-align:middle;text-align:center;"><?=@$report['clocks'][$date][$i] ? $report['clocks'][$date][$i]->clock_time : '-'?></td>
                  <td bgclor="<?=$type?>" rowspan="<?=$rowspan?>" style="vertical-align:middle;text-align:center;"><?=@$report['clocks'][$date][$i+1] ? $report['clocks'][$date][$i+1]->clock_time : '-'?></td>
                <?php } ?>
                <td bgclor="<?=$type?>" rowspan="<?=$rowspan?>" style="vertical-align:middle;text-align:center;"><?=$report['total_hours'][$date]?></td>
                <td bgclor="<?=$type?>" rowspan="<?=$rowspan?>" style="vertical-align:middle;text-align:center;"><?=$report['extra_hours'][$date]?></td>
              </tr>
            <?php else: ?>
              <tr>
                <td bgclor="<?=$type?>"><?=$timesheets->task?></td>
              </tr>
            <?php endif ?>
          <?php endforeach ?>
        <?php else: ?>
          <tr>
            <td bgcolor="<?=$type?>" align="center"><?=$date?></td>
            <td bgcolor="<?=$type?>">&nbsp;</td>
            <?php for ($i=0; $i < $report['clocks_columns']; $i=$i+2) { ?>
              <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;"><?=@$report['clocks'][$date][$i] ? $report['clocks'][$date][$i]->clock_time : '-'?></td>
              <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;"><?=@$report['clocks'][$date][$i+1] ? $report['clocks'][$date][$i+1]->clock_time : '-'?></td>
            <?php } ?>
            <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;"><?=$report['total_hours'][$date]?></td>
            <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;"><?=$report['extra_hours'][$date]?></td>
          </tr>
        <?php endif ?>
      <?php else: ?>
        <?php
        if (!($type && $msg)) {
          $type = '#f89406';
          $msg = 'Missed work';
        }
        ?>
        <tr>
          <td bgcolor="<?=$type?>" align="center" valign="middle"><?=$date?></td>
          <td bgcolor="<?=$type?>"><?=$msg?></td>
          <?php for ($i=0; $i < $report['clocks_columns']; $i=$i+2) { ?>
            <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;">-</td>
            <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;">-</td>
          <?php } ?>
          <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;"><?=@$report['total_hours'][$date] ? $report['total_hours'][$date] : '00:00:00'?></td>
          <td bgcolor="<?=$type?>" style="vertical-align:middle;text-align:center;"><?=@$report['extra_hours'][$date] ? $report['extra_hours'][$date] : '00:00:00'?></td>
        </tr>
      <?php endif ?>
    <?php endforeach ?>
  </tbody>
  <tfoot>
    <th colspan="<?=$report['clocks_columns']+3?>">Total extra hours</th>
    <th><?=$report['total_extra_hours']?></th>
  </tfoot>
</table>