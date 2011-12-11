<?php
class Report extends Model {
  function get_report($start, $end, $user_id) {
    if ($user_id) {
      $user = new User();
      $hours_per_day = $user->get_hours_per_day($user_id);
    } else {
      $user_id = Session::get('id');
      $hours_per_day = Session::get('hours_per_day');
    }

    $calendar = Helper::calendar($start, $end);
    
    $sql = "SELECT * FROM holiday WHERE holiday_date >= ? AND holiday_date <= ?  AND user_id IN (0, ?) ORDER BY holiday_date ASC";
    $rs = DB::read()->Execute($sql, array($start, $end, Session::get('id')));
    
    $holidays = array();
    if ($rs && $rs->RecordCount()) {
      while ($holiday = $rs->FetchNextObject(false)) {
        $holidays[$holiday->holiday_date] = $holiday->title;
      }
    }
    
    $sql = "SELECT * FROM clock WHERE user_id = ? AND clock_date >= ? AND clock_date <= ? ORDER BY clock_date ASC, clock_time ASC";
    $rs = DB::read()->Execute($sql, array($user_id, $start, $end));
    $clocks = array();
    if ($rs && $rs->RecordCount()) {
      while ($clock = $rs->FetchNextObject(false)) {
        $clocks[$clock->clock_date][] = $clock;
      }
    }
    
    $clocks_columns = 0;
    $total_hours = array();
    $extra_hours = array();
    $total_extra_hours = 0;
    foreach ($clocks as $clock_date => $clock) {
      $current = count($clock);
      if ($current > $clocks_columns) {
        $clocks_columns = $current;
      }
      
      $total = 0;
      for ($i=0; $i < $current; $i+=2) { 
        $a = strtotime('1970-01-01 '.$clock[$i]->clock_time);
        if (array_key_exists($i+1, $clock)) {
          $b = strtotime('1970-01-01 '.$clock[$i+1]->clock_time);
          $total += $b-$a;
        }
      }
      $total_hours[$clock_date] = $total;
    }
    
    foreach ($calendar as $date) {
      $weekday = date('l', strtotime($date));
      $extra = ($weekday == 'Saturday' || $weekday == 'Sunday' || array_key_exists($date, $holidays));
      if (array_key_exists($date, $clocks)) {
        if ($extra) {
          $total_extra_hours += $total_hours[$date];
          $extra_hours[$date] = Helper::seconds_to_hours($total_hours[$date]);
        } else {
          $total_extra_hours += $total_hours[$date] - ($hours_per_day*60*60);
          $extra_hours[$date] = Helper::seconds_to_hours($total_hours[$date] - ($hours_per_day*60*60));
        }
      } else {
        if (!$extra) {
          $total_extra_hours -= $hours_per_day*60*60;
          $extra_hours[$date] = Helper::seconds_to_hours($hours_per_day*60*60*-1);
        }
      }
    }
    $total_extra_hours = Helper::seconds_to_hours($total_extra_hours);
    
    foreach ($total_hours as $key => $value) {
      $total_hours[$key] = Helper::seconds_to_hours($value);
    }
    
    $sql = "SELECT * FROM timesheet WHERE user_id = ? AND task_date >= ? AND task_date <= ? ORDER BY task_date ASC, id ASC";
    $rs = DB::read()->Execute($sql, array($user_id, $start, $end));
    $timesheets = array();
    if ($rs && $rs->RecordCount()) {
      while ($timesheet = $rs->FetchNextObject(false)) {
        $timesheet->task = stripslashes($timesheet->task);
        $timesheets[$timesheet->task_date][] = $timesheet;
      }
    }
    
    $report = array(
      'clocks' => $clocks,
      'timesheets' => $timesheets,
      'start' => $start,
      'end' => $end,
      'clocks_columns' => $clocks_columns,
      'holidays' => $holidays,
      'total_hours' => $total_hours,
      'extra_hours' => $extra_hours,
      'total_extra_hours' => $total_extra_hours,
      'calendar' => $calendar
    );
    return $report;
  }
}
?>