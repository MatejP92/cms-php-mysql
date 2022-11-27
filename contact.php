<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>

<!-- THIS ENABLES WHEN YOU HAVE WEB HOSTING AND mail() IS ENABLED -->
<?php
// // the message
// $msg = "First line of text\nSecond line of text";

// // use wordwrap() if lines are longer than 70 characters
// $msg = wordwrap($msg,70);

// // send email
// mail("jax.stryker2@gmail.com","My subject",$msg);


// if(isset($_POST["submit"])){


//     $to      = "jax.stryker@gmail.com";
//     $subject = wordwrap(escape($_POST["subject"]), 70);
//     $body    = escape($_POST["body"]);
//     $header  = escape($_POST["email"]);

//     mail($to,$subject,$body,$header);

// }

// sendmail.ini gmail auth password: yyrlnweprruaggup

if(isset($_POST["submit"])){
    
    $to_email = "jax.stryker2@gmail.com";
    $subject  = wordwrap(escape($_POST["subject"]), 70);
    $body     = escape($_POST["body"]);
    $headers  = escape($_POST['email']);
    
    if (mail($to_email, $subject, $body, $headers)) {
        echo "<h3 class='text-center alert alert-success'>Email successfully sent</h3>";
    } else {
        echo "Email sending failed...";
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
                <h1>Contact</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your Email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                        </div>
                         <div class="form-group">
                        <textarea class="form-control" name="body" id="body" cols="40" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
