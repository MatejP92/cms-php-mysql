<div class="col-md-4">

    <?php

        if(ifItIsMethod("post")){


            if(isset($_POST["login"])){
                
                if(isset($_POST["username"]) && isset($_POST["password"])){

                    login_user(($_POST["username"]), $_POST["password"]);
                    
                } else {
                    redirect("/cms/index");
                }

            }

            
        }
    ?>





    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>

        <form action="search.php" method="post">

            <div class=" input-group">
                <input name="search" type="text" class="form-control">
                <span class="input-group-btn">
                    <button name="submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.input-group -->
    </div>





    <!-- LOGIN -->
    <div class="well">

        <?php if(isset($_SESSION["user_role"])): ?>

            <h4>Logged in as <?php echo $_SESSION["username"] ?></h4>
            <a href="/cms/includes/logout.php" class="btn btn-primary">Log Out</a>
            
        <?php else: ?>

            <h4>Login</h4>

            <form method="post">

                <div class=" form-group">
                    <input name="username" type="text" class="form-control" placeholder="Enter Username">
                </div>
                <div class=" input-group">
                    <input name="password" type="password" class="form-control" placeholder="Enter Password">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary" name="login">Login</button>
                    </span>
                </div>
                <div class=" form-group">
                    <a href="/cms/forgot_password.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>
                </div>
            </form>
            <!-- /.input-group -->

        <?php endif; ?>


        
        <!-- /.input-group -->
    </div>


    <!-- Blog Categories Well -->

    <?php

    $query = "SELECT * FROM categories"; // če še dodaš LIMIT <številka> lahko omejiš koliko kategorij se bo prikazalo

    $select_categories_sidebar = mysqli_query($connection, $query);

    ?>


    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">
                    <?php

                    while ($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                        $cat_title = $row["cat_title"];
                        $cat_id = $row["cat_id"];
                        echo "<li><a href='category.php?category=$cat_id'>{$cat_title}</a></li>";
                    }

                    ?>

                </ul>
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    </div>


    <!-- Side Widget Well -->
    <?php include "widget.php"; ?>

</div>
