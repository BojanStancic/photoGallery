<?php require_once("includes/header.php"); ?> 

<?php 

if($session->is_signed_in()) {

	redirect("index.php");
}

if(isset($_POST['login'])) {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	// Method to check database user

	$user_found = User::verify_user($username, $password);





	if($user_found) {
		$session->login($user_found);
		redirect("index.php");
	} else {

		$the_message = "Your password or username are incorrect";
	}





} else {

	$the_message = "";
	$username = "";
	$password = "";
}

if (isset($_POST['register'])){
	redirect("register.php");

}


 ?>
<body id="login_body">
 
<div class="col-md-4 col-md-offset-3"  id="login_form">

<h4 class="bg-danger"><?php echo $the_message; ?></h4>
	
<form id="login-id" action="" method="post">

	<h3>Login</h3>
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" placeholder="&#xf007; Username" style="font-family:Arial, FontAwesome">

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>" placeholder="&#xf13e; Password" style="font-family:Arial, FontAwesome">
	
</div>


<div class="form-group">
<input type="submit" name="login" value="Login" class="btn btn-primary " id="login_btn"><p class="not_register">You don`t have account?</p >

<input type="submit" name="register" value="Register" class="btn btn-primary pull-right" id="login_btn">

</div>


</form>


</div>

</body>