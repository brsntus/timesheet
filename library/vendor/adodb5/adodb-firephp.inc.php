<?php

/**
 * @author     Dipl.-Ing. (FH) André Fiedler < kontakt at visualdrugs dot net >
 * @link       http://github.com/SunboX/adodb-lite-firephp-plugin/tree
 * @copyright  2009 André Fiedler.
 * @license    MIT License
 * @version    1.0
 */

if(!defined('ADODB_ERROR_HANDLER_TYPE')) define('ADODB_ERROR_HANDLER_TYPE', E_USER_ERROR); 
define('ADODB_ERROR_HANDLER', 'adodb_firephp_exception');
define('ADODB_OUTP', 'adodb_firephp_logging');

/**
* FirePHP Error Handler.
*
* @param $dbms		the RDBMS you are connecting to
* @param $fn		the name of the calling function (in uppercase)
* @param $errno		the native error number from the database
* @param $errmsg	the native error msg from the database
* @param $p1		$fn specific parameter - see below
* @param $P2		$fn specific parameter - see below
*/
function adodb_firephp_exception($dbms, $fn, $errno, $errmsg, $p1, $p2, $thisConnection)
{
	if(!class_exists('FirePHP')) die('You have to include FirePHP first!');
	
	$firephp = FirePHP::getInstance(true);
	
	$s = '';
	
	switch($fn)
	{
		case 'EXECUTE':
			$s = "$dbms error: [$errno: $errmsg] in $fn(\"$p1\")\n";
			break;

		case 'PCONNECT':
		case 'CONNECT':
			$user = $thisConnection->username;
			$s = "$dbms error: [$errno: $errmsg] in $fn($p1, '$user', '****', $p2)\n";
			break;

		default:
			$s = "$dbms error: [$errno: $errmsg] in $fn($p1, $p2)\n";
			break;
	}

	$firephp->error($s);
}

/**
* FirePHP Log Handler.
*
* @param $debug_output	the logging string from AdoDB as html
* @param $newline		force newline
*/
function adodb_firephp_logging($debug_output, $newline)
{	
	if(!class_exists('FirePHP')) die('You have to include FirePHP first!');
	
	$firephp = FirePHP::getInstance(true);
	
	$log = array();
	foreach(explode("\n", htmlspecialchars_decode(strip_tags($debug_output))) as $line) 
	{
		$line = trim($line);
		if($line != '') $log[] = array($line);
	}
	
	$title = array_shift($log);
	$firephp->table($title[0], $log);
}

?>