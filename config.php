<?php
	if (!defined('allowAccess')) exit('No direct script access allowed');

	ini_set('session.cookie_httponly', 1);
	ini_set('session.cookie_secure', 1);
	session_start();

	
	define('debug',true);

	

	define( 'ABSPATH', dirname( __FILE__ ) . '/' );

	error_reporting(E_ALL);
	
	ini_set('display_errors',(debug == true ? 'On': 'Off'));



	spl_autoload_register('myAutoloader'); 
	function myAutoloader($className){
    	$path = ABSPATH.'classes/';
		if(file_exists($path.$className.'.php')) require_once $path.$className.'.php';
	}
?>