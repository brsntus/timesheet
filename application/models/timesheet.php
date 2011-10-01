<?php
class Timesheet extends Model {
  function get_timesheet($date = false) {
    $date = $date ? $date : date('Y-m-d');
    $sql = "SELECT * FROM timesheet WHERE user_id = ? AND task_date = ? ORDER BY id ASC";
    $rs = DB::read()->Execute($sql, array(Session::get('id'), $date));
    $timesheet = array();
    if ($rs && $rs->RecordCount()) {
      while ($row = $rs->FetchNextObject(false)) {
        if ($row->timer_on) {
          $start = strtotime($row->timer_started_at);
          $hours = Helper::hours_to_seconds($row->hours);
          $row->countdown = date(DATE_W3C, $start - $hours);
        } else {
          $start = time();
          $hours = Helper::hours_to_seconds($row->hours);
          $row->countdown = date(DATE_W3C, $start - $hours);
        }
        
        $timesheet[] = $row;
      }
    }
    return $timesheet;
  }
  
  function add($data) {
    if (empty($data['hours'])) {
      $data['hours'] = '00:00';
      $data['timer_on'] = 1;
      $data['timer_started_at'] = date('Y-m-d H:i:s');
    }
    $id = DB::write()->AutoExecute('timesheet', $data, 'INSERT');
    echo $id ? $id : 0;
  }
  
  function save($data, $id = false) {
    if (empty($data['hours'])) {
      $data['hours'] = '00:00';
      $data['timer_on'] = 1;
      $data['timer_started_at'] = date('Y-m-d H:i:s');
    }
    
    if ($id) {
      return DB::write()->AutoExecute('timesheet', $data, 'UPDATE', "id = {$id}");
    } else {
      if (DB::write()->AutoExecute('timesheet', $data, 'INSERT')) {
        return DB::write()->Insert_ID();
      }
    }
    
    return false;
  }
  
  function delete($id) {
    if (DB::write()->Execute('DELETE FROM timesheet WHERE id = ? AND user_id = ?', array($id, Session::get('id')))) {
      return true;
    }
    return false;
  }
  
  function start_timer($id) {
    $data = array(
      'timer_on' => 1,
      'timer_started_at' => date('Y-m-d H:i:s')
    );
    if (DB::write()->AutoExecute('timesheet', $data, 'UPDATE', "id = {$id}")) {
      return true;
    }
    return false;
  }
  
  function stop_timer($id) {
    $sql = "SELECT hours, timer_started_at FROM timesheet WHERE id = ?";
    $rs = DB::read()->Execute($sql, array($id));
    if ($rs && $rs->RecordCount()) {
      $end = strtotime(date('Y-m-d H:i:s'));
      $start = strtotime($rs->Fields('timer_started_at'));
      $hours = Helper::hours_to_seconds($rs->Fields('hours'));
      $hours = Helper::seconds_to_hours($hours + ($end-$start));
      $data = array(
        'timer_on' => 0,
        'timer_started_at' => NULL,
        'hours' => $hours
      );
      if (DB::write()->AutoExecute('timesheet', $data, 'UPDATE', "id = {$id}")) {
        return $hours;
      }
    }
    return 0;
  }
  
  function get_time($id) {
    $rs = DB::read()->Execute('SELECT * FROM timesheet WHERE id = ? AND user_id = ?', array($id, Session::get('id')));
    if ($rs && $rs->RecordCount()) {
      return $rs->FetchObject(false);
    }
    return false;
  }
}
?>