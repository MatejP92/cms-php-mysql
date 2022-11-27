<?php

// admin shouldn't have power over user profile info change


if(isset($_GET["edit_user"])){
    $the_user_id = $_GET["edit_user"];

    $query = "SELECT * FROM users where user_id = $the_user_id "; 
    $select_users_query = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_users_query)) {
        $user_id          = $row["user_id"];
        $user_username    = $row["user_username"];
        $db_user_password = $row["user_password"];
        $user_first_name  = $row["user_first_name"];
        $user_last_name   = $row["user_last_name"];
        $user_email       = $row["user_email"];
        $user_image       = $row["user_image"];
        $user_role        = $row["user_role"];
    }



    if(isset($_POST["edit_user"])){

        $user_first_name    = escape($_POST["user_first_name"]);
        $user_last_name     = escape($_POST["user_last_name"]);
        $user_role          = escape($_POST["user_role"]);
        $user_username      = escape($_POST["user_username"]);
        $user_email         = escape($_POST["user_email"]);
        $user_password      = escape($_POST["user_password"]);

        // $post_date = date("d-m-y");

        if(!empty($user_password)){

            $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";   // we select only user_password so we can use an array later in $row
            $get_user_query = mysqli_query($connection, $query_password);
            confirmQuery($get_user_query);

            $row = mysqli_fetch_array($get_user_query);
            $db_user_password = $row["user_password"];

            if($db_user_password != $user_password){
                $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));   
            } else {
                $hashed_password = $db_user_password;
            }
            $query = "UPDATE users SET
                    user_username   = '{$user_username}',            
                    user_password   = '{$hashed_password}'
                    user_first_name = '{$user_first_name}',
                    user_last_name  = '{$user_last_name}',
                    user_email      = '{$user_email}',
                    user_role       = '{$user_role}',
                WHERE user_id = {$the_user_id}";
            

            $update_user_query = mysqli_query($connection, $query);

            confirmQuery($update_user_query);

            echo "User updated! " . "<a href='users.php'>View users</a>";
        } else { echo "ERROR" . mysqli_error($connection); }
    }
 
} else {

    header("Location: index.php");

}



?>



<form action="" method="post" enctype="multipart/form-data">    
     
        <div class="form-group">
            <label for="title">First Name</label>
            <input type="text" class="form-control" name="user_first_name" value="<?php echo $user_first_name ?>">
        </div>

        <div class="form-group">
            <label for="title">Last Name</label>
            <input type="text" class="form-control" name="user_last_name" value="<?php echo $user_last_name ?>">
        </div>
     
        <select name="user_role" id="">
        <option value="<?php echo $user_role ?>"><?php echo $user_role ?></option>
        <?php  
        
        if($user_role == "admin") {
            echo "<option value='subscriber'>subscriber</option>";
        } else {
            echo "<option value='admin'>admin</option>";
        }
        
        ?>
        </select>


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
         <input type="text" class="form-control" name="user_email"value="<?php echo $user_email ?>">
     </div>

     <div class="form-group">
         <label for="post_tags">Password</label>
         <input type="password" autocomplete="off" class="form-control" name="user_password">
     </div>
      

     
     <div class="form-group">
     <input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
     </div>
     
     
</form>

