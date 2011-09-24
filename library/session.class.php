<?php
class Session {
  private static $session_state = false;
  
  private function __construct() {}
  
  public static function start() {
    if (!self::$session_state) {
      self::$session_state = session_start();
    }
    return self::$session_state;
  }
  
  public static function set($name, $value) {
    $_SESSION[$name] = $value;
  }
  
  public static function get($name) {
    if (isset($_SESSION[$name])) {
      return $_SESSION[$name];
    }
    return false;
  }
  
  public static function dump() {
    return $_SESSION;
  }
  
  public static function remove($name) {
    unset($_SESSION[$name]);
  }
  
  public static function set_flash($message) {
    self::set('__flash', $message);
  }
  
  public static function flash() {
    $flash = self::get('__flash');
    self::remove('__flash');
    return $flash ? $flash : '';
  }
  
  public function __isset($name) {
    return isset($_SESSION[$name]);
  }
  
  public function __unset($name) {
    unset($_SESSION['name']);
  }
  
  public static function destroy() {
    if (self::$session_state) {
      self::$session_state = !session_destroy();
      unset($_SESSION);
      return !self::$session_state;
    }
    
    return false;
  }
}
?>