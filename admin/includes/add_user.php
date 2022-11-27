<?php


if(isset($_POST["create_user"])){

    $user_first_name = escape($_POST["user_first_name"]);
    $user_last_name  = escape($_POST["user_last_name"]);
    $user_role       = escape($_POST["user_role"]);
    $user_username   = escape($_POST["user_username"]);
    $user_email      = escape($_POST["user_email"]);
    $user_password   = escape($_POST["user_password"]);

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array("cost" => 12));

    $query = "INSERT INTO users( 
            user_first_name, 
            user_last_name, 
            user_role, 
            user_username, 
            user_email, 
            user_password) 
        VALUES(
            '{$user_first_name}', 
            '{$user_last_name}',  
            '{$user_role}', 
            '{$user_username}', 
            '{$user_email}', 
            '{$user_password}') ";

    $create_user_query = mysqli_query($connection, $query);

    confirmQuery($create_user_query);


echo "User Created" . " " . "<a href='users.php'>View Users</a>";

}


?>



<form action="" method="post" enctype="multipart/form-data">    
     
        <div class="form-group">
            <label for="title">First Name</label>
            <input type="text" class="form-control" name="user_first_name">
        </div>

        <div class="form-group">
            <label for="title">Last Name</label>
            <input type="text" class="form-control" name="user_last_name">
        </div>
     
        <select name="user_role" id="">
        <option value="subscriber">Select Option</option>
        <option value="admin">Admin</option>
        <option value="subscriber">Subscriber</option>

        </select>


        <div class="form-group">
            <label for="post_status">Username</label>
            <input type="text" class="form-control" name="user_username">
        </div>

    
     
    <!-- <div class="form-group">
         <label for="post_image">Post Image</label>
         <input type="file" name="image">
     </div> -->
   
     <div class="form-group">
         <label for="post_tags">Email</label>
         <input type="text" class="form-control" name="user_email">
     </div>

     <div class="form-group">
         <label for="post_tags">Password</label>
         <input type="password" class="form-control" name="user_password">
     </div>
      

     
     <div class="form-group">
     <input type="submit" class="btn btn-primary" name="create_user" value="Create User">
     </div>
     
     
</form>

