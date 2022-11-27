<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>


<!-- Navigation -->
<?php include "includes/navigation.php" ?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if(isset($_GET["p_id"])){

                $the_post_id     = escape($_GET["p_id"]);
                $the_post_author = escape($_GET["author"]);

            }

            // s tem nam pokaže samo poste od post authorja

            $query = "SELECT * FROM posts WHERE post_user = '{$the_post_author}' ";
            $select_all_posts_query = mysqli_query($connection, $query);
            // query da izbereš vsak post v bazi
            // while loop da daš vsaki vrstici svoj $variable
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title   = $row["post_title"];
                $post_author  = $row["post_user"];
                $post_date    = $row["post_date"];
                $post_image   = $row["post_image"];
                $post_content = $row["post_content"];

                // s tem ustvarimo loop, kjer vsaki novi post input v database prikaže na strani
                ?>


                <h1 class="page-header">
                    Posts from
                    <small><?php echo $post_author ?></small>
                </h1>

                <!-- Blog Post
            
                spodaj bodo izpisane vse vrstice in njihova vsebina na stran
                -->
                <h2>
                    <a href="post.php?p_id=<?php echo $the_post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    <?php echo $post_author ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>

                <hr>

                <?php  }   ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>


    </div>
    <!-- /.row -->

    <hr>

        <?php include "includes/footer.php" ?>
