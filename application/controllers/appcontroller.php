<?php
class AppController extends Controller {
  public $before_filter = array(
    array('method' => '_check_login')
  );
  
  function _check_login() {
    if (!Helper::is_logged_in()) {
      Helper::redirect('?not_logged_in');
    }
  }
}
?>