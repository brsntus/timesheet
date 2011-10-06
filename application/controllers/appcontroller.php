<?php
class AppController extends Controller {
  public $before_filter = array(
    array('method' => '_check_login')
  );
    
  function _check_login() {
    if (!Helper::is_logged_in()) {
      if (!Helper::check_cookie()) {
        Helper::redirect('/401');
      }
    }

    if (!ACL::check_permissions(strtolower($this->_controller), $this->_action)) {
      Helper::redirect('/401');
    }
  }
}
?>