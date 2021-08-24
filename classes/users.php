<?php 
if ( !defined( 'allowAccess' ) )exit( 'No direct script access allowed' );
include_once( __DIR__ . "/../config.php" );

class users {
	
	private $_database; 
	
	public function __construct(){ 
		$database = database::getInstance();
		$this->_database = $database->getConnection();
	}
	public function __destruct(){
		$this->_database=NULL; 
	}
	
	
	
	
}