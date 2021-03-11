<?php include("includes/header.php"); ?>

<?php if(!$session->is_signed_in()) {redirect("login.php");} ?>


<?php 

$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

$items_per_page = 3;

$items_total_count = Photo::count_all();

$paginate = new Paginate($page, $items_per_page, $items_total_count);

$sql = "SELECT * FROM photos ";
$sql .= "ORDER BY id ";
$sql .= "LIMIT {$items_per_page} ";
$sql .= "OFFSET {$paginate->offset()}";





$photos = Photo::find_by_query($sql);







// $photos = User::find_by_id($_SESSION['user_id'])->photos();
 //ovako mozemo da prikazujemo slike vezane samo za korisnika koji je ulogovan trenutno(linija iznad) ,odlicna funkcija na kojoj treba jos mnogo raditi kako bi se persoalizovalo za svakog korisnika koji je ulogovan da moze da gleda samo svoje slike, pa onda ostale itd...(da bi radilo otkomentarisati linje koda iz photos.php, photo.php, upload.php, glavna funkcija je u user.php zove se photos())



// $photos = Photo::find_all();


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
                            Photos
                        </h1>

                            <p class="bg-success">
                            <?php echo $message; ?>
                        </p>

                        
                        <div class="col-md-12">
                            
                            <table class="table table-hover">

                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Id</th>
                                        <th>File Name</th>
                                        <th>Title</th>
                                        <th>Size</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php foreach ($photos as $photo): ?>

                                    <tr>
                                        <td><img class="admin-photo-thumbnail" src="<?php echo $photo->picture_path(); ?>">

                                            <div class="action_links">
                                                <a class="delete_link" href="delete_photo.php?id=<?php echo $photo->id; ?>">Delete</a>
                                                <a href="edit_photo.php?id=<?php echo $photo->id; ?>">Edit</a>
                                                <a href="../photo.php?id=<?php echo $photo->id; ?>">View</a>
                                            </div>



                                        </td>
                                        <td><?php echo $photo->id; ?></td>
                                        <td><?php echo $photo->filename; ?></td>
                                        <td><?php echo $photo->title; ?></td>
                                        <td><?php echo $photo->size; ?></td>
                                        <td><a href="comment_photo.php?id=<?php echo $photo->id; ?>">
                                            <?php

                                            $comments = Comment::find_the_comments($photo->id);

                                             echo count($comments); 

                                             ?></a></td>
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
                                
                                echo "<li class='next'><a href='photos.php?page={$paginate->next()}'>Next</a></li>"; 
                            }


                            for ($i=1; $i <= $paginate->page_total() ; $i++) { 
                                
                                if ($i == $paginate->current_page) {
                                    
                                    echo "<li class='active'><a href='photos.php?page={$i}'>{$i}</a></li>";
                                } else {

                                    echo "<li><a href='photos.php?page={$i}'>{$i}</a></li>";

                                }
                            }



                        
                            if ($paginate->has_previous()) {
                                
                                echo "<li class='previous'><a href='photos.php?page={$paginate->previous()}'>Previous</a></li>"; 
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