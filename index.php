<?php
define('allowAccess', true);
include_once("config.php");
try{
	$database = database::getInstance();
	$dbc = $database->getConnection();
	$users = new users($dbc); 
	
	include_once(ABSPATH."/includes/templates/login-form.php");
	
	
} catch ( databaseConnection $e){
	if(file_exists(ABSPATH."/includes/templates/database.html")){
		include_once(ABSPATH."/includes/templates/database.html");
	}else{
		echo 'Database Connection Issue';
	}
}