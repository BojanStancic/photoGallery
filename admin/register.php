<?php include("includes/header.php"); ?>






<?php 




    // if (!empty($_FILES['user_image'])){
    //     $user_image = $_FILES['user_image'];
    //     echo $user_image['name'];
    //     var_dump($user_image);
    // }

  // if (isset($_FILES['user_image'])) {
  //    $msg = $_FILES['user_image'];
  // }

// if (is_uploaded_file($_FILES['user_image']['tmp_name'])) {
//        echo "File ". $_FILES['user_image']['name'] ." uploaded successfully.\n";
//    echo "Displaying contents\n";
//    // readfile($_FILES['user_image']['tmp_name']);
// }


// if (file_exists($_FILES['user_image'])) {
//     echo "The file $filename exists";
// } else {
//     echo "The file $filename does not exist";
// }





$user = new User();


    if (isset($_POST['create'])) {


        if ($user) {
            
            $user->username = $_POST['username'];
            $user->first_name = $_POST['first_name'];
            $user->last_name = $_POST['last_name'];
            $user->password = $_POST['password'];
            $user->user_image = $_FILES['user_image'];


            $user->set_file($_FILES['user_image']);


            $user->upload_photo();
            $session->message("The user {$user->username} has been created");
            $user->save();
            redirect('index.php');
            // if ($session->is_register()) {
            //     redirect('index.php');
            // } else {
            //     echo "xxx";
            // }
            
        }



//         if ($user) {
            
//             $user->title = $_POST['title'];
//             $user->caption = $_POST['caption'];
//             $user->alternate_text = $_POST['alternate_text'];
//             $user->description = $_POST['description'];

//             $user->save();
       
        
//     }



}

// var_dump($user->user_image);




// $users = user::find_all();


?>
    <body id="register_body">
        <div class="register_page-wrapper" id="register_form">

            <div class="container-fluid" >

                <!-- Page Heading -->
                <div class="row" >
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Register
                            <small>New User</small>
                        </h1>

                         <p class="bg-success">
                            <?php echo $message; ?>
                        </p>    
                        
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="col-md-6 col-md-offset-3 ">
                               
                               
                                <div class="button-wrap">
                                    
                                    <label class ="new-button" id="register_btn">Choose Image </label>   
                                    <input  type="file"  name="user_image" id="image_upload">
                                    <span class="image_name" ></span>
                                </div>
                                

                                
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" name="username" class="form-control" required>

                                </div>
                                
                                <div class="form-group">

                                    <label for="first name">First Name</label>
                                    <input type="text" name="first_name" class="form-control" required>

                                </div>
                                
                                <div class="form-group">

                                    <label for="last name">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" required>

                                </div>
                                
                                <div class="form-group">

                                    <label class="password">Password</label>
                                    <input type="text" name="password" class="form-control" required>

                                </div>
                                
                                <div class="form-group">

                                    
                                    <input type="submit" name="create" class="btn btn-primary pull-right" id="register_btn">

                                </div>
                                

                            </div>
                        </form>







                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
    </body>

<?php include("includes/footer.php"); ?>