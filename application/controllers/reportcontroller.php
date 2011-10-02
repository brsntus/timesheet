<?php
class ReportController extends AppController {
  function load_report($start, $end) {
    $year = date('Y');
    $month = date('m');
    $start = $start ? $start : date("Y-m-d", strtotime($year.'-'.$month.'-01 00:00:00'));
    $end = $end ? $end : date("Y-m-d", strtotime('-1 second', strtotime('+1 month', strtotime($year.'-'.$month.'-01 00:00:00'))));
    $report = new Report();
    return $report->get_report($start, $end);
  }
  function index($start = false, $end = false) {
    $report = $this->load_report($start, $end);
    $this->set('report', $report);
    echo $this->render();
  }
  
  function export($start, $end) {
    $report = $this->load_report($start, $end);
    $this->set('report', $report);
    $this->set('border', true);
    
    $filename = strtolower(str_replace(' ', '_', Session::get('name')))."_-_{$start}_{$end}.xls";
    header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    header ("Content-type: application/x-msexcel");
    header ("Content-Disposition: attachment; filename=\"{$filename}\"");
    header ("Content-Description: Timesheet");
    echo $this->render('report/table', false);
  }
}
?>