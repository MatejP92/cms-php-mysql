<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){   // If the request method has been set on the server, and if the request method is equal to post, then we have a post submission

    $username   = trim(escape($_POST["username"]));     // trim removes the whitespaces
    $email      = trim(escape($_POST["email"]));
    $password   = trim(escape($_POST["password"]));


    // ERROR HANDLERS
    $error = [
        "username" => "",
        "email"=> "",
        "password" => ""
    ];

    if(strlen($username) < 4){
        $error["username"] = "Username needs to be longer";
    }
    if($username == ""){
        $error["username"] = "Username cannot be empty";
    }
    if(username_exists($username)){
        $error["username"] = "Username already exists";
    }

    if($email == ""){
        $error["email"] = "Email cannot be empty";
    }
    if(email_exists($email)){
        $error["email"] = "Email already exists, <a href='index.php'>Please login</a>";
    }
    
    if(strlen($password) < 4){
        $error["password"] = "Password needs to be longer";
    }
    if($password == ""){
        $error["password"] = "Password cannot be empty";
    }


    foreach($error as $key => $value){

        if(empty($value)){ // with this if statement we unset the error values and keys if we dont get any during registration process
            unset($error[$key]);
        }
    }
    // if the errors are really empty, we used the unset function above, then register user
    if(empty($error)){
        register_user($username, $email, $password);
        login_user($username, $password);
    }

}
  
?>



    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h4 class="text-center"><?php //echo $message ?></h4>                
                        <div class="form-group">
                            <label for="username" class="sr-only">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" 
                                   value="<?php echo isset($username) ? $username : "" ?>">   <!-- this is short if statement in php code. it reads if $username is set (true) echo $username, else echo "" -> empty string  -->

                            <p><?php echo isset($error["username"]) ? $error["username"] : "" ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                                   value="<?php echo isset($email) ? $email : "" ?>">
                            <p><?php echo isset($error["email"]) ? $error["email"] : "" ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error["password"]) ? $error["password"] : "" ?></p>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
