<?php  
	require_once 'connection2.php';

	$GLOBALS['db'] = mysqli_connect($GLOBALS['host'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database'],$GLOBALS['port']);
	$GLOBALS['db']->query("SET NAMES 'UTF8'");




	require_once 'connection.php';	

	$GLOBALS['db'] = mysqli_connect($GLOBALS['host'],$GLOBALS['username'],$GLOBALS['password'],$GLOBALS['database'],$GLOBALS['port']);
	$GLOBALS['db']->query("SET NAMES 'UTF8'");

?>