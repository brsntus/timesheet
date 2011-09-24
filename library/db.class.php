<?php
class DB {
  private static $read_instance = null;
  private static $write_instance = null;
  private static $unique_instance = null;
  
  private function __construct() {}
  
  public static function get_unique_instance() {
    if (!self::$unique_instance) {
      self::$unique_instance = NewADOConnection(WRITE_DSN);
      self::$unique_instance->debug = DB_WRITE_DEBUG;
    }
    return self::$unique_instance;
  }
  
  public static function read() {
    if (DB_MASTER_SLAVE) {
      if (!self::$read_instance) {
        self::$read_instance = NewADOConnection(READ_DSN);
        self::$read_instance->debug = DB_READ_DEBUG;
      }
      return self::$read_instance;
    }
    
    return self::get_unique_instance();
  }
  
  public static function write() {
    if (DB_MASTER_SLAVE) {
      if (!self::$write_instance) {
        self::$write_instance = NewADOConnection(WRITE_DSN);
        self::$write_instance->debug = DB_WRITE_DEBUG;
      }
      return self::$write_instance;
    }
    
    return self::get_unique_instance();    
  }
  
  public static function debug($debug = false) {
    self::read()->debug = self::write()->debug = $debug;
  }
}
?>