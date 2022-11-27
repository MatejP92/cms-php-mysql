<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/cms/">CMS HOME</a> <!-- when we created .htaccess file and put RewriteRule, we can now delete the .php in href, and it wont show in url -->
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                <?php

                $query = "SELECT * FROM categories ";

                $select_all_categories_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_all_categories_query)) {
                    $cat_title = $row["cat_title"];
                    $cat_id    = $row["cat_id"];

                    // here we set the navigation bar to show, which page is active (on which page are you)

                    $category_class = "";
                    $registration_class = "";
                    $contact_class = "";
                    $login_class = "";

                    $pageName = basename($_SERVER["PHP_SELF"]);
                    // PHP_SELF pomeni trenutna stran, na kateri si. če si na index.php bo PHP_SELF index.php, če si na category.php bo PHP_SELF category.php ...

                    $registration = "registration.php";
                    $contact = "contact.php";
                    $login = "login.php";

                    if(isset($_GET["category"]) && $_GET["category"] == $cat_id){
                        $category_class = "active";
                    } elseif ($pageName == $registration) {
                        $registration_class = "active";
                    }elseif ($pageName == $contact) {
                        $contact_class = "active";
                    }elseif ($pageName == $login) {
                        $login_class = "active";
                    }

                    echo "<li class='$category_class'><a href='/cms/category/$cat_id'>{$cat_title}</a></li>";
                }
                ?>

                <li class="<?php echo $contact_class ?>">
                    <a href="/cms/contact">Contact</a>
                </li>


                <?php if(isLoggedIn()): ?>

                    <li>
                        <a href="/cms/admin/">Admin</a>
                    </li>
                    <li>
                        <a href="/cms/includes/logout.php">Log Out</a>
                    </li>

                    <?php else: ?>   

                    <li class="<?php echo $login_class ?>">
                        <a href="/cms/login">Login</a>
                    </li>
                    <li class="<?php echo $registration_class ?>">
                        <a href="/cms/registration">Register</a>
                    </li>

                <?php endif; ?>   
                

                
                

                <?php

                if(isset($_SESSION["user_role"])){

                    if(isset($_GET["p_id"])){
                        $the_post_id = escape($_GET["p_id"]);

                        echo "<li><a href='/cms/admin/posts.php?source=edit_post&p_id=$the_post_id'>Edit Post</a></li>";

                    }

                }

                ?>
                

            </ul>

        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>
