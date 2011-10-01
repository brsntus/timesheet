<?php
class Clock extends Model {
  function get_week($week, $year) {
    $start = date('Y-m-d', strtotime("{$year}W{$week}1"));
    $end = date('Y-m-d', strtotime("{$year}W{$week}7"));
    $sql = "SELECT * FROM clock WHERE user_id = ? AND clock_date >= ? AND clock_date <= ? ORDER BY clock_date, clock_time";
    $rs = DB::read()->Execute($sql, array(Session::get('id'), $start, $end));
    $clocks = array();
    if ($rs && $rs->RecordCount()) {
      while ($row = $rs->FetchNextObject(false)) {
        $clocks[$row->clock_date][] = $row;
      }
    }
    return $clocks;
  }
  
  function get_clock($id) {
    $rs = DB::read()->Execute('SELECT * FROM clock WHERE id = ? AND user_id = ?', array($id, Session::get('id')));
    if ($rs && $rs->RecordCount()) {
      return $rs->FetchObject(false);
    }
    return false;
  }
  
  function save($data, $id = false) {
    if ($id) {
      return DB::write()->AutoExecute('clock', $data, 'UPDATE', "id = {$id}");
    } else {
      if (DB::write()->AutoExecute('clock', $data, 'INSERT')) {
        return DB::write()->Insert_ID();
      }
    }
    
    return false;
  }
  
  function delete($id) {
    if (DB::write()->Execute('DELETE FROM clock WHERE id = ? AND user_id = ?', array($id, Session::get('id')))) {
      return true;
    }
    return false;
  }
}
?>