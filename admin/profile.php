<?php include "includes/admin_header.php" ?>

<?php 

if(isset($_SESSION["username"])) {
    $username = $_SESSION["username"];

    $query = "SELECT * FROM users WHERE user_username='{$username}'";

    $select_user_profile_query = mysqli_query($connection, $query);

    while($row=mysqli_fetch_array($select_user_profile_query)){

        $user_id         = $row["user_id"];
        $user_username   = $row["user_username"];
        $db_user_password   = $row["user_password"];
        $user_first_name = $row["user_first_name"];
        $user_last_name  = $row["user_last_name"];
        $user_email      = $row["user_email"];
        $user_image      = $row["user_image"];
    }
}

?>

<?php

if(isset($_POST["update_profile"])){

    $user_first_name    = escape($_POST["user_first_name"]);
    $user_last_name     = escape($_POST["user_last_name"]);
    $user_username      = escape($_POST["user_username"]);
    $user_email         = escape($_POST["user_email"]);
    $user_password      = escape($_POST["user_password"]);

    // $post_image = $_FILES["image"]["name"];
    // $post_image_temp = $_FILES["image"]["tmp_name"];

    // $post_date = date("d-m-y");

    // move_uploaded_file($post_image_temp, "../images/$post_image");


    if(!empty($user_password)){

        $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));

        $query = "UPDATE users SET
        user_first_name = '{$user_first_name}',
        user_last_name  = '{$user_last_name}',
        user_username   = '{$user_username}',
        user_email      = '{$user_email}',
        user_password   = '{$user_password}'
    WHERE user_username = '{$username}'";
        
    } else {
        
        $db_user_password = password_hash($db_user_password, PASSWORD_BCRYPT, array("cost" => 12));

        $query = "UPDATE users SET
        user_first_name = '{$user_first_name}',
        user_last_name  = '{$user_last_name}',
        user_username   = '{$user_username}',
        user_email      = '{$user_email}',
        user_password   = '{$db_user_password}'
    WHERE user_username = '{$username}'";
       
    }

    
     

    $update_user_query = mysqli_query($connection, $query);

    confirmQuery($update_user_query);

}


?>


<div id="wrapper">

    <?php include "includes/admin_navigation.php" ?>






    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                <h1 class="page-header">
                    Welcome to your PROFILE
                    <small><?php echo get_username() ?></small>
                </h1>
            
                <form action="" method="post" enctype="multipart/form-data">    
     
                    <div class="form-group">
                        <label for="title">First Name</label>
                        <input type="text" class="form-control" name="user_first_name" value="<?php echo $user_first_name ?>">
                    </div>

                    <div class="form-group">
                        <label for="title">Last Name</label>
                        <input type="text" class="form-control" name="user_last_name" value="<?php echo $user_last_name ?>">
                    </div>

                    <div class="form-group">
                        <label for="post_status">Username</label>
                        <input type="text" class="form-control" name="user_username" value="<?php echo $user_username ?>">
                    </div>

                
                
                    <!-- <div class="form-group">
                        <label for="post_image">Post Image</label>
                        <input type="file" name="image">
                    </div> -->

                    <div class="form-group">
                        <label for="post_tags">Email</label>
                        <input type="text" class="form-control" name="user_email" value="<?php echo $user_email ?>">
                    </div>

                    <div class="form-group">
                        <label for="post_tags">Password</label>
                        <input type="password" autocomplete="off" class="form-control" name="user_password" value="">
                    </div>
                    

                    
                    <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                    </div>
                    
                
                </form>
                        

                </div>



            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
