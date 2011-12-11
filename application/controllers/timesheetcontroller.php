<?php
class TimesheetController extends AppController {
  function index($date = false) {
    $date = $date ? $date : date('Y-m-d');
    $timesheet = new Timesheet();
    $ts = $timesheet->get_timesheet($date);
    $this->set('timesheet', $ts);
    $this->set('date', $date);
    echo $this->render();
  }
  
  function _add_timesheet($date = false) {
    $this->set('date', $date ? $date : date('Y-m-d'));
    echo $this->render('default', false);
  }
  
  function _edit_timesheet($id) {
    $timesheet = new Timesheet();
    $timesheet = $timesheet->get_time($id);
    $this->set('timesheet', $timesheet);
    echo $this->render('default', false);
  }
  
  function save($id = false) {
    $data = array_merge($_POST, array('user_id' => Session::get('id')));
    $timesheet = new Timesheet();
    echo (int) $timesheet->save($data, $id);
  }
  
  function delete($id) {
    $timesheet = new Timesheet();
    echo (int) $timesheet->delete($id);
  }
  
  function start_timer($id) {
    $timesheet = new Timesheet();
    echo (int) $timesheet->start_timer($id);
  }
  
  function stop_timer($id) {
    $timesheet = new Timesheet();
    echo $timesheet->stop_timer($id);
  }
}
?>