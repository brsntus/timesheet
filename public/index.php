<?php	
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));

$url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : null;

define('APPLICATION_ENV', getenv('APPLICATION_ENV'));

require_once(ROOT . DS . 'config' . DS . 'config.php');
require_once(ROOT . DS . 'config' . DS . APPLICATION_ENV . '.php');
require_once(ROOT . DS . 'config' . DS . 'js.php');
require_once(ROOT . DS . 'config' . DS . 'css.php');
require_once(ROOT . DS . 'library' . DS . 'vendor' . DS . 'FirePHP.class.php');
require_once(ROOT . DS . 'library' . DS . 'vendor' . DS . 'adodb5' . DS . 'adodb.inc.php');
require_once(ROOT . DS . 'library' . DS . 'vendor' . DS . 'adodb5' . DS . 'adodb-firephp.inc.php');
require_once(ROOT . DS . 'library' . DS . 'shared.php');
?>