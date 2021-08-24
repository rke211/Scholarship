<?php
if ( !defined( 'allowAccess' ) )exit( 'No direct script access allowed' );

include_once( __DIR__ . "/../config.php" );



class database

{

  private $_connection;

  private static $_instance; //The single instance
	
  private $_host = DB_HOST;

  private $_username = DB_USER;

  private $_password = DB_PASSWORD;

  private $_database = DB_NAME;

  /*

  Get an instance of the Database

  @return Instance

  */

  /*

  Get an instance of the Database

  @return Instance

  */

  public static function getInstance() {

    if ( !self::$_instance ) { // If no instance then make one

      self::$_instance = new self();

    }

    return self::$_instance;

  }

  // Constructor

  private function __construct() {
	  $config =parse_ini_file(__DIR__ . "/../config.ini");
	  $this->_host = $config['db_host'];
	  $this->_databse = $config['db'];
	  $this->_username = $config['db_username'];
	  $this->_password = $config['db_password'];

    try {

      $this->_connection = new PDO( "mysql:host=$this->_host;dbname=" . $this->_database, $this->_username, $this->_password );
      $this->_connection->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
      trigger_error( "Connection failed: " . $e->getMessage(), E_USER_ERROR );
    }


  }

  // Magic method clone is empty to prevent duplication of connection

  private function __clone() {}

  // Get mysqli connection

  public function getConnection() {

    return $this->_connection;

  }

}