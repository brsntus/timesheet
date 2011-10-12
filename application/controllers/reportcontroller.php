<?php
class ReportController extends AppController {
  function load_report($start, $end, $user) {
    $year = date('Y');
    $month = date('m');
    $start = $start ? $start : date("Y-m-d", strtotime($year.'-'.$month.'-01 00:00:00'));
    $end = $end ? $end : date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($year.'-'.$month.'-01 00:00:00'))));
    $report = new Report();
    return $report->get_report($start, $end, $user);
  }

  function index($start = false, $end = false, $user = false) {
    $report = $this->load_report($start, $end, $user);
    $this->set('report', $report);
    echo $this->render();
  }
  
  function export($start, $end, $user = false) {
    $report = $this->load_report($start, $end, $user);
    $this->set('report', $report);
    $this->set('border', true);
    
    if ($user) {
      $u = new User();
      $user_name = $u->get_name($user);
    } else {
      $user_name = Session::get('name');
    }

    $filename = strtolower(str_replace(' ', '_', $user_name))."_-_{$start}_{$end}.xls";
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$filename}\"");
    header ("Content-Description: Timesheet");
    echo $this->render('report/table', false);
  }

  function employees($start = false, $end = false, $user_id = false) {
    $year = date('Y');
    $month = date('m');
    $start = $start ? $start : date("Y-m-d", strtotime($year.'-'.$month.'-01 00:00:00'));
    $end = $end ? $end : date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($year.'-'.$month.'-01 00:00:00'))));
    $this->set('start', $start);
    $this->set('end', $end);

    $user = new User();
    $users = $user->get_users('employee');
    $this->set('users', $users);
    $this->set('user_id', $user_id);
    if ($user_id) {
      $this->set('report', $this->load_report($start, $end, $user_id));
    }
    echo $this->render();
  }

  function get_employee($start, $end, $user) {
    $report = $this->load_report($start, $end, $user);
    $this->set('report', $report);
    echo $this->render('report/table', false);
  }
}
?>