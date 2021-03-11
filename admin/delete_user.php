<?php include("includes/init.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>

<?php 

if (empty($_GET['id'])) {

    redirect("users.php"); // ako ne bude radilo ,staviti ovako, sa ../ -> redirect("../users.php"); 
}


$user = User::find_by_id($_GET['id']);




if ($user->delete()){
	
    $session->message("The user {$user->username} has been deleted");

    // $target_path = SITE_ROOT . DS . 'admin' . DS . 'images' . DS .	 $user->user_image; // moze i jedan i drugi nacin
    $target_path = SITE_ROOT . DS . 'admin' . DS . $user->image_path_and_placeholder();
    if($user->image_path_and_placeholder()){
		// return unlink($target_path) ? redirect("users.php") : false; // ovako je predavac uradio
		unlink($target_path);
		redirect("users.php");

	} else 	{
		redirect("users.php");
	}
    		
    
} else {

    redirect("users.php");
}




 ?>