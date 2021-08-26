<?php
if(isset($_POST['btnLogin'])){
	if(isset($_POST['email']) && isset($_POST['password'])){
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = strip_tags($_POST['password']);
		$login = $user->doLogin($email, $password);
		if($login['success']){
			$feedback = '<div class="alert alert-success">'.$login['msg'].'</div>';
		}else{
			$feedback = '<div class="alert alert-danger">'.$login['msg'].'</div>';
		}
	}else{
		$feedback = '<div class="alert alert-danger">'._("Please complete all fields").'</div>';
	}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <?php include_once(ABSPATH."/includes/templates/meta/head.php"); ?>
    


    <title>Login</title>
  </head>
  <body class="vh-100 ">
	<div class="row g-0 vh-100">
	  	<div class="col-12 col-md-7 sport-background"></div>
	  	<div class="col-12 col-md-5 bg-dark d-flex align-items-center">
			<div class="p-5 w-100 text-center">
			<form method="post">
				<h2 class="text-light py-4">Sign In</h2>
				<?php echo (isset($feedback)?$feedback:''); ?>
				<div class="form-floating my-2">
				  <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
				  <label for="floatingInput">Email address</label>
				</div>
				<div class="form-floating my-2">
				  <input type="password" class="form-control" id="floatingInput" placeholder="Password">
				  <label for="floatingInput">Password</label>
				</div>
				<button class="btn btn-outline-light w-100 my-2" name="btnLogin">Login</button>
				<a href="/forgot/" class="link-light py-3">Forgot Password?</a>
			</form>
		</div>
		</div>
	 </div>
	  
	  
	  
   <?php include_once(ABSPATH."/includes/templates/meta/footer.php"); ?>
  </body>
</html>