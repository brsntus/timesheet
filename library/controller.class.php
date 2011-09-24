<?php
class Controller {	
	private $_controller;
	private $_action;
	private $_variables = array();
	
  /**
   * public ${before|after}_filter = array(
   *   array(
   *     'method' => 'funcao_only',
   *     'only' => array('metodo1', 'metodo2')
   *   ),
   *   array(
   *     'method' => 'funcao_except',
   *     'except' => array('metodo3')
   *   ),
   *   array(
   *     'method' => 'funcao_all'
   *   )
   * );
   * 
   * PRIORITY:
   * 1 - all (if it doesn't have "except" or "only")
   * 2 - only
   * 3 - except
   */	
	public $before_filter = array();
	public $after_filter = array();
  
  function __construct($controller, $action) {    
		$this->_controller = ucfirst($controller);
		$this->_action = $action;
	}

	function set($name, $value) {
		$this->_variables[$name] = $value;
	}
	
	function render($_view = 'default', $_header = true) {
	  ob_start();
	  if ($_view == 'default') {
	    $_view = strtolower($this->_controller) . DS . $this->_action;
	  }
	  
	  extract($this->_variables);
	  
	  if ($_header == true) {
	    if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php')) {
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'header.php');
			} elseif (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . 'header.php')) {
				include (ROOT . DS . 'application' . DS . 'views' . DS . 'header.php');
			}
	  }
 
	  if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $_view . '.php')) {
	    include (ROOT . DS . 'application' . DS . 'views' . DS . $_view . '.php');
	  }
	  
	  if ($_header == true) {
	    if (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php')) {
				include (ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . 'footer.php');
			} elseif (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . 'footer.php')) {
				include (ROOT . DS . 'application' . DS . 'views' . DS . 'footer.php');
			}
	  }
	  
	  return ob_get_clean();
	}
}
?>
