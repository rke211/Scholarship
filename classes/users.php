<?php 
if ( !defined( 'allowAccess' ) )exit( 'No direct script access allowed' );
include_once( __DIR__ . "/../config.php" );

class users {
	
	private $_database; 
	
	public function __construct($database){ 
		$this->_database = $database;
	}
	public function __destruct(){
		$this->_database=NULL; 
	}
	
	
	public function checkEmail($email){
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			try {
				$values=['email'=>$email];
				$sql = "SELECT email FROM users WHERE email = :email";
				$stmt = $this->_database->prepare($sql);
				$stmt->execute($values);

				$totalData = $stmt->rowCount();
				if($totalData>0){
					$data=['success'=>true, 'msg'=>'Email is in use'];
				}else{
					$data=['success'=>false, 'msg'=>'Email is not in use'];
				}
			} catch(PDOException $e) {
				$data=['success'=>false, 'msg'=>'Unexpected error'.$e->getMessage()];
			}
			$stmt = null; 
		}else{
			$data=['success'=>false, 'msg'=>'Invalid Email Provided'];
		}
		return $data;
	}
	/*session_destroy();
		setcookie("PHPSESSID", "", 1);
		session_start();
		session_regenerate_id(true);*/
	
	public function createUser($email,$password,$level=6){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$check = $this->checkEmail($email);
			if(!$check['success']){
				try {
					$sql = "INSERT INTO `users`(`email`, `password`, `level`) VALUES (:email,:password,:level)";
					$stmt = $this->_database->prepare($sql);
					$stmt->bindParam(':email', $email);
					$password = password_hash($password, PASSWORD_DEFAULT);
					$stmt->bindParam(':password', $password);
					$stmt->bindParam(':level', $level);
					$stmt->execute();

					$lastid = $this->_database->lastInsertId();
					if($lastid>0){
						$_SESSION['userid'] = $lastid;
						$_SESSION["password"] = $password;
						
						$data=['success'=>true, 'msg'=>'Account Created','userid'=>$lastid];
					}else{
						$data=['success'=>false, 'msg'=>'Unexpected Error','userid'=>0];
					}

				} catch(PDOException $e) {
					$data=['success'=>false, 'msg'=>'Unexpected error','userid'=>0];
					error_log("Error: '".$sql."' ".$e->getMessage()." IP:".$_SERVER['REMOTE_ADDR']);
				}
				$stmt = null; 
			}else{
				$data = $check;
			}
			
		}else{
			$data=['success'=>false, 'msg'=>'Invalid Email Provided'];
		}
		return $data;
	}
	
	
	//-------------------------------------------------------------------------------------------------	
	public function doLogin($email,$password){
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				try {
					$sql = "SELECT * FROM `users` WHERE `email` LIKE :email;";
					$stmt = $this->_database->prepare($sql);
					$stmt->bindParam(':email', $email);
					$stmt->execute();
					$totalData = $stmt->rowCount();
					if($totalData>0){
						$row = $stmt->fetch();
						if(verify_hash($password, $row['password'])){
							$data=['success'=>true, 'msg'=>'Loggedin'];
							$session = new session;
							$session->createSession("userid",$row['id']);
							$session->createSession("password",$row['password']);
							$this->saveLogin($row['id'],1);
						}else{
							$data=['success'=>false, 'msg'=>'Invalid Email or Password'];
							$this->saveLogin($row['id']);
						}
					}else{
						$data=['success'=>false, 'msg'=>'Invalid Email or Password'];
					}

				} catch(PDOException $e) {
					$data=['success'=>false, 'msg'=>'Unexpected error'];
				}
				$stmt = null; 			
		}else{
			$data=['success'=>false, 'msg'=>'Invalid Email Provided'];
		}
		return $data;
	}
}