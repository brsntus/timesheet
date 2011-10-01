<?php
class ClockController extends AppController {  
  function index($week_year = false) {
    $week_year = $week_year ? $week_year : date('Y-W');
    list($year, $week) = explode('-', $week_year);
    $clock = new Clock();
    $clocks = $clock->get_week($week, $year);
    $this->set('clocks', $clocks);
    $this->set('week', date('Y-m-d', strtotime("{$year}W{$week}1")));
    echo $this->render();
  }
  
  function _add_clock($date = false) {
    $this->set('date', $date ? $date : date('Y-m-d'));
    echo $this->render('default', false);
  }
  
  function _edit_clock($id) {
    $clock = new Clock();
    $clock = $clock->get_clock($id);
    $this->set('clock', $clock);
    echo $this->render('default', false);
  }
  
  function save($id = false) {
    $data = array_merge($_POST, array('user_id' => Session::get('id')));
    $clock = new Clock();
    echo (int) $clock->save($data, $id);
  }
  
  function delete($id) {
    $clock = new Clock();
    echo (int) $clock->delete($id);
  }
}
?>