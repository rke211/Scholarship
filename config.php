<?php
	if (!defined('allowAccess')) exit('No direct script access allowed');

	ini_set('session.cookie_httponly', 1);
	ini_set('session.cookie_secure', 1);
	session_start();

	
	define('debug',true);

	

	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
?>