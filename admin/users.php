<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>


<?php 

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 5;

$items_total_count = User::count_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM users ";
$sql .= "ORDER BY id ";
$sql .= "LIMIT {$items_per_page} "; 
$sql .= "OFFSET {$paginate->offset()}";

$users = User::find_by_query($sql);









// $users = User::find_all();


 ?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            
            <?php include("includes/top_nav.php"); ?>



            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->

            <?php include("includes/side_nav.php"); ?>

            
            <!-- /.navbar-collapse -->
        </nav>





        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">


                        <h1 class="page-header">
                            Users
                        </h1>

                        <p class="bg-success">
                            <?php echo $message; ?>
                        </p>

                        <a href="add_user.php" class="btn btn-primary">Add User</a>
                        
                        <div class="col-md-12">
                            
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($users as $user): ?>

                                    <tr>
                                        <td><?php echo $user->id; ?></td>
                                        <td><img class="admin-user-thumbnail user_image" src="<?php echo $user->image_path_and_placeholder(); ?>"></td>
                                        
                                        <td><?php echo $user->username; ?>
                                             <div class="action_links">

                                                <a class="delete_link" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a> ---
                                                <a href="edit_user.php?id=<?php echo $user->id; ?>">View Profile</a>

                                            </div>
                                        </td>



                                        <td><?php echo $user->first_name; ?></td>
                                        <td><?php echo $user->last_name; ?></td>
                                    </tr>

                                    <?php endforeach ?>

                                </tbody>

                            </table> <!-- End of Table -->

                        </div>


                        <div class="row">
                
                <ul class="pager">

                    <?php 

                    if ($paginate->page_total() > 1) {
                        
                            if ($paginate->has_next()) {
                                
                                echo "<li class='next'><a href='users.php?page={$paginate->next()}'>Next</a></li>"; 
                            }


                            for ($i=1; $i <= $paginate->page_total() ; $i++) { 
                                
                                if ($i == $paginate->current_page) {
                                    
                                    echo "<li class='active'><a href='users.php?page={$i}'>{$i}</a></li>";
                                } else {

                                    echo "<li><a href='users.php?page={$i}'>{$i}</a></li>";

                                }
                            }



                        
                            if ($paginate->has_previous()) {
                                
                                echo "<li class='previous'><a href='users.php?page={$paginate->previous()}'>Previous</a></li>"; 
                            }
                    }

                     ?>




                    
                    
                </ul>

            </div>



                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>