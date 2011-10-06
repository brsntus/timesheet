<?php
class ACL {
  public static function check_permissions($controller, $action) {
    global $__ACL;
    if (isset($__ACL[Session::get('type')][$controller])) {
      $acl = $__ACL[Session::get('type')][$controller];
      if ($acl === true || (is_array($acl) && in_array($action, $acl))) {
        return true;
      }
      
    }

    return false;
  }
}
?>