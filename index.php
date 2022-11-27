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
            //  number of posts per page !
            $per_page = 4;

            if(isset($_GET["page"])){
                $page = escape($_GET["page"]);
            } else {
                $page = "";
            }
            if($page == "" || $page == 1){
                $page_1 = 0;
            } else {
                $page_1 = ($page * $per_page) - $per_page;  // $page tells us on which page we are 
            }



            if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "admin"){

                $post_query_count = "SELECT * FROM posts";
                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count);

                if($count < 1){
                    echo "<h1 class='text-center'>No Posts Available!</h1>";
                } else {
                    $count = ceil($count / $per_page);
                }
            } else {

                $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
                $find_count = mysqli_query($connection, $post_query_count);
                $count = mysqli_num_rows($find_count);

                if($count < 1){
                    echo "<h1 class='text-center'>No Posts Available!</h1>";
                } else {
                    $count = ceil($count / $per_page);
                }

            }

            
            // $post_query_count = "SELECT * FROM posts WHERE post_status = 'published'";
            // $find_count = mysqli_query($connection, $post_query_count);
            // // mysqli num rows counts how many rows are there in the specific table -> how many posts
            // $count = mysqli_num_rows($find_count);

            // if($count < 1){

            //     echo "<h1 class='text-center'>No Posts Available!</h1>";
            // } else {

            // //show how many posts will be on first page, ceil rounds the number up. here we want $per_page posts per page
            // $count = ceil($count / $per_page);






            if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "admin"){

                // s tem nam pokaže samo tisti post, na kerega stisnemo
                $query = "SELECT * FROM posts ORDER BY post_id DESC LIMIT $page_1 ,$per_page";

            } else {
                $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1 ,$per_page";
            }




            // $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_id DESC LIMIT $page_1 ,$per_page";
            $select_all_posts_query = mysqli_query($connection, $query);
            // query da izbereš vsak post v bazi
            // while loop da daš vsaki vrstici svoj $variable
            while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_id = $row["post_id"];
                $post_title = $row["post_title"];
                $post_author = $row["post_author"];
                $post_user = $row["post_user"];
                $post_date = $row["post_date"];
                $post_image = $row["post_image"];
                $post_content = substr($row["post_content"],0 ,100);
                $post_status = $row["post_status"];

                // s tem ustvarimo loop, kjer vsaki novi post input v database prikaže na strani
            ?>


                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- Blog Post
            
                spodaj bodo izpisane vse vrstice in njihova vsebina na stran
            -->
                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>


                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_user ?>&p_id=<?php echo $post_id ?>"><?php echo $post_user ?></a>
                </p>

                
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                    <img class="img-responsive" src="images/<?php echo imagePlaceholder($post_image) ?>" alt="" >
                </a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

            <?php  }   ?>



        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>


    </div>
    <!-- /.row -->

    <hr>
<!-- pagination -->
    <ul class="pager">
        <?php
            for($i = 1; $i<= $count; $i++){

                if($i == $page) {
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";

                } else {
                echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                }
            }
        ?>
    </ul>
    <!-- pagination end -->

        <?php include "includes/footer.php" ?>
