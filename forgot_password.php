<?php   use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;  ?>

<?php //require './vendor/phpmailer/phpmailer/src/Exceptions.php'; ?>
<?php require './vendor/phpmailer/phpmailer/src/PHPMailer.php'; ?>
<?php //require './vendor/phpmailer/phpmailer/src/SMTP.php'; ?>
<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
<?php require './vendor/autoload.php'; ?> 
<?php require './classes/config.php'; ?>


<?php

    if(!ifItIsMethod("get") && !isset($_GET["forgot"])){
        redirect("/cms/index");
    }


    if(ifItIsMethod("post")){

        if(isset($_POST["email"])){

            $email = $_POST["email"];

            // we create a unique token for emails to put into database
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));

            if(email_exists($email)){
                
                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE user_email = ?")){

                    mysqli_stmt_bind_param($stmt , "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);


                    /***************************
                     
                        CONFIGURING PHPMailer

                    ***************************/

                    $mail = new PHPMailer();

                    $mail->isSMTP();                                          //Send using SMTP
                    $mail->Host       = config::SMTP_HOST;                    //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
                    $mail->Username   = config::SMTP_USERNAME;                //SMTP username
                    $mail->Password   = config::SMTP_PASSWORD;                //SMTP password
                    $mail->SMTPSecure = "tls";          //Enable implicit TLS encryption
                    $mail->Port       = config::SMTP_PORT;                    //TCP port to connect to;
                    $mail->isHTML(true);
                    $mail->CharSet = "UTF-8";

                    $mail->setFrom("matej.pal@help.com", "Matej");
                    $mail->addAddress($email);

                    $mail->Subject = "Reset Password";
                    $mail->Body = "<p>Please click here to reset your password!

                    <a href='http://localhost/cms/reset.php?email=" . $email ."&token=" . $token . "'>RESET PASSWORD</a>
                    </p>";
                    

                
                        
                    if($mail->send()){
                        $email_sent = true;
                    } else {
                        echo "mail sending unsuccessful";
                        echo 'Mailer error: ' . $mail->ErrorInfo;
                    }
                    
                } 
                
            }

        }
        
    }

?>



<!-- Navigation -->

<?php  include "includes/navigation.php"; ?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                            <?php if(!isset($email_sent)): ?>

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Forgot Password?</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">


                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                            <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                </form>

                            </div><!-- Body-->

                            <?php else: ?>

                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset link sent, check your inbox.</h2>
                            
                            <?php endif; ?>

                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

