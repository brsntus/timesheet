<?php
ob_start("ob_gzhandler");

Session::start();

// ROTEAMENTO DAS URLS
$queryString = array();
if (!isset($url)) {
	$controller = DEFAULT_CONTROLLER;
	$action = DEFAULT_ACTION;
} else {
  $url = trim($url, '/');
	$urlArray = explode('/', $url);
	if (isset($urlArray[0]) && $urlArray[0] != '') {
	  if (class_exists(ucfirst($urlArray[0]) . 'Controller')) {
	    $controller = array_shift($urlArray);
	    // action
	    if (count($urlArray) > 0) {
	      $action = array_shift($urlArray);
	    } else {
	      $action = DEFAULT_ACTION;
	    }

	    $queryString = $urlArray;
	  } elseif (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $urlArray[0] . '.php')) {
	    require_once(ROOT . DS . 'application' . DS . 'views' . DS . $urlArray[0] . '.php');
	    exit();
	  } else {
	    erro404();
	  }
	} else {
	  $controller = DEFAULT_CONTROLLER;
		$action = DEFAULT_ACTION;
	}
}
$controllerName = ucfirst($controller) . 'Controller';

if (class_exists($controllerName)){
  $dispatch = new $controllerName($controller, $action);
	if (method_exists($controllerName, $action)) {

	  // BEFORE FILTER
	  $before_filter = $dispatch->before_filter;
	  foreach ($before_filter as $filter) {
	    if (is_array($filter)) {
	      $method = $filter['method'];
	      $only = array_key_exists('only', $filter) ? $filter['only'] : false;
	      $except = array_key_exists('except', $filter) ? $filter['except'] : false;
	      
	      // ALL
	      if (!$only && !$except) {
	        if (method_exists($controllerName, $method)) {
	          call_user_func_array(array($dispatch, $method), $queryString);
	        }	        
	      } elseif ($only) {
	        if (in_array($action, $only)) {
	          if (method_exists($controllerName, $method)) {
  	          call_user_func_array(array($dispatch, $method), $queryString);
  	        }
	        }
	      } elseif ($except) {
	        if (!in_array($action, $except)) {
	          if (method_exists($controllerName, $method)) {
  	          call_user_func_array(array($dispatch, $method), $queryString);
  	        }
	        }
	      }
	    }
	  }

	  // ACTION
		call_user_func_array(array($dispatch, $action), $queryString);
		
		// AFTER FILTER
	  $after_filter = $dispatch->after_filter;
	  foreach ($after_filter as $filter) {
	    if (is_array($filter)) {
	      $method = $filter['method'];
	      $only = array_key_exists('only', $filter) ? $filter['only'] : false;
	      $except = array_key_exists('except', $filter) ? $filter['except'] : false;
	      
	      // ALL
	      if (!$only && !$except) {
	        if (method_exists($controllerName, $method)) {
	          call_user_func_array(array($dispatch, $method), $queryString);
	        }	        
	      } elseif ($only) {
	        if (in_array($action, $only)) {
	          if (method_exists($controllerName, $method)) {
  	          call_user_func_array(array($dispatch, $method), $queryString);
  	        }
	        }
	      } elseif ($except) {
	        if (!in_array($action, $except)) {
	          if (method_exists($controllerName, $method)) {
  	          call_user_func_array(array($dispatch, $method), $queryString);
  	        }
	        }
	      }
	    }
	  }
	} elseif (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $controller . DS . $action . '.php')) {
	  if (Helper::is_ajax()) {
	    require_once(ROOT . DS . 'application' . DS . 'views' . DS . $controller . DS . $action . '.php');
	  } else {
	    erro404();
	  }	  
	} else {
	  erro404();
 	}
} elseif (file_exists(ROOT . DS . 'application' . DS . 'views' . DS . $controller . '.php')) {
  require_once(ROOT . DS . 'application' . DS . 'views' . DS . $controller . '.php');
} else {
  erro404();
}


function perform_action($controller, $action, $params = null) {
	$controllerName = ucfirst($controller) . 'Controller';
	$dispatch = new $controllerName($controller, $action);
	return call_user_func_array(array($dispatch, $action), $params);
}

function erro404() {
  header('Location: ' . BASE_PATH . '/404?' . @$_SERVER['PATH_INFO']);
  exit();
}

function __autoload($className) {
	if (file_exists(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php')) {
		require_once(ROOT . DS . 'library' . DS . strtolower($className) . '.class.php');
	} else if (file_exists(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'application' . DS . 'controllers' . DS . strtolower($className) . '.php');
	} else if (file_exists(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php')) {
		require_once(ROOT . DS . 'application' . DS . 'models' . DS . strtolower($className) . '.php');
	}
}
?>