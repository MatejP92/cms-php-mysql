<?php include "includes/db.php" ?>
<?php include "includes/header.php" ?>



<!-- Navigation -->
<?php include "includes/navigation.php" ?>


<?php

// LIKING

if(isset($_POST["liked"])) {

    // we are getting these values from the ajax request from down bellow from <script>
    $post_id = $_POST["post_id"];
    $user_id = $_POST["user_id"];

    // 1 - FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id =$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post["likes"];

    // 2 - UPDATE-INCREMENT POST WITH LIKES
    mysqli_query($connection, "UPDATE posts SET likes=$likes+1 WHERE post_id =$post_id");

    // 3 - CREATE LIKES FOR POST

    mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
    exit();

}

// UNLIKING

if(isset($_POST["unliked"])) {


    // we are getting these values from the ajax request from down bellow from <script>
    $post_id = $_POST["post_id"];
    $user_id = $_POST["user_id"];

    // 1 - FETCHING THE RIGHT POST

    $query = "SELECT * FROM posts WHERE post_id =$post_id";
    $postResult = mysqli_query($connection, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post["likes"];

    // 2 - DELETE LIKES

    mysqli_query($connection, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");

    // 3 - UPDATE-DECREMENT POST WITH LIKES
    mysqli_query($connection, "UPDATE posts SET likes=$likes-1 WHERE post_id =$post_id");
    exit();

}

?>



<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <?php

            if(isset($_GET["p_id"])){

                $the_post_id = escape($_GET["p_id"]);

                //this query will add 1 to the post_view_count column in database so that we will see, how many clicks the post has
                $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = $the_post_id";
                $send_query = mysqli_query($connection, $view_query);


            if(isset($_SESSION["user_role"]) && $_SESSION["user_role"] == "admin"){

                // s tem nam pokaže samo tisti post, na kerega stisnemo
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";

            } else {
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
            }

                $select_all_posts_query = mysqli_query($connection, $query);
                // query da izbereš vsak post v bazi

                if(mysqli_num_rows($select_all_posts_query) < 1){
                    echo "<h2 class='text-center'>No Posts</h2>";
                } else {


                // while loop da daš vsaki vrstici svoj $variable
                while ($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_title   = $row["post_title"];
                    $post_author  = $row["post_author"];
                    $post_user    = $row["post_user"];
                    $post_date    = $row["post_date"];
                    $post_image   = $row["post_image"];
                    $post_content = $row["post_content"];

                    // s tem ustvarimo loop, kjer vsaki novi post input v database prikaže na strani
                    ?>


                    <h1 class="page-header">
                        Post
                    </h1>

                    <!-- Blog Post
                
                    spodaj bodo izpisane vse vrstice in njihova vsebina na stran
                    -->
                    <h2>
                        <a href=""><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="/cms/author_posts.php?author=<?php echo $post_user ?>&p_id=<?php echo $the_post_id ?>"><?php echo $post_user ?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                    <hr>
                    <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image) ?>" alt="image">
                    <hr>
                    <p><?php echo $post_content ?></p>

                    <hr>

                    <?php 
                    
                        if(isLoggedIn()){ ?>

                        <div class="row">
                            <p class="pull-right">
                                <a class="<?php echo userLikedThisPost($the_post_id) ? 'unlike': 'like' ?>" 
                                   data-togle="tooltip"
                                   data-placement="top" 
                                   title="<?php echo userLikedThisPost($the_post_id) ? ' Already liked': ' Want to like it?' ?>" 
                                   href="">
                                    <span class="glyphicon glyphicon-thumbs-up" >
                                    </span>
                                    <?php echo userLikedThisPost($the_post_id) ? ' Unlike': ' Like' ?>
                                    
                                </a>
                            </p>
                        </div>

                    

            
                    <?php } else { ?>
                    
                        <div class="row">
                            <p class="pull-right login-to-post">You need to <a href="/cms/login">LOGIN</a> to like</p>
                        </div>

                    <?php } ?>
                    

<!-- 
                    <div class="row">
                        <p class="pull-right"><a class="like" href="#"><span class="glyphicon glyphicon-thumbs-up"></span>Like</a></p>
                    </div>

                    <div class="row">
                        <p class="pull-right"><a class="unlike" href="#"><span class="glyphicon glyphicon-thumbs-down"></span>Unlike</a></p>
                    </div> -->

                    <div class="row">
                        <p class="pull-right likes glyphicon glyphicon-thumbs-up"></p><p class="pull-right likes"> <?php getPostLikes($the_post_id) ?>  </p>
                    </div>

                    <div class="clearfix">

                    </div>

                <?php } ?>



                    
                <!-- Blog Comments -->

                <?php

$comment_author  = get_username();
$comment_email   = loggedInUserEmail();
                if(isset($_POST["create_comment"])){

                    $the_post_id = escape($_GET["p_id"]);


                    $comment_content = escape($_POST["comment_content"]);

                    if(!empty($comment_content)){

                        $query = "INSERT INTO comments
                            (comment_post_id,
                            comment_author,
                            comment_email,
                            comment_content,
                            comment_status,
                            comment_date)
                        VALUES (${the_post_id},
                            '{$comment_author}',
                            '{$comment_email}',
                            '{$comment_content}',
                            'unapproved',
                            now())";

                        $create_comment_query = mysqli_query($connection, $query);

                        if(!$create_comment_query){
                            die("QUERY FAILED" . mysqli_error($connection));
                        }

                        
                        
                        // header("Location: post.php?p_id=$the_post_id");

                    } else {
                            // javascript code inside, pop-up message
                        echo "<script>alert('Fields cannot be empty')</script>";
                    }
                }

                    ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="POST" role="form">

                        <div class="form-group">
                            <label for="author">Author</label>
                            <p><?php echo $comment_author ?></p>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <p><?php echo $comment_email ?></p>
                        </div>

                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" name="comment_content" rows="3"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <hr>

                <!-- Posted Comments -->
                <?php
                    $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} 
                            AND comment_status = 'approved' ORDER BY comment_id DESC ";
                    $select_comment_query = mysqli_query($connection, $query);
                    if(!$select_comment_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }
                    while($row = mysqli_fetch_array($select_comment_query)){
                        $comment_date    = $row['comment_date'];
                        $comment_content = $row['comment_content'];
                        $comment_author  = $row['comment_author'];
                        ?>

                        <!-- Comment -->
                        <div class="media">

                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author ?>
                                    <small><?php echo $comment_date ?></small>
                                </h4>
                                <?php echo $comment_content ?>
                            </div>
                            <br>
                        </div>


                    <?php }
                
                }} else {
                    header("Location: index.php");
                }
                
             
             
                ?>
                



        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>


    </div>
    <!-- /.row -->

    <hr>



        <?php include "includes/footer.php" ?>


        <script>

            

            $(document).ready(function(){

                $("[data-toggle='tooltip']").tooltip();


                var post_id = <?php echo $the_post_id; ?>;

                var user_id = <?php echo loggedInUserId(); ?>;

                // LIKING

                $(".like").click(function(){
                    $.ajax({

                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: "post",
                        data: {
                            'liked': 1,
                            'post_id': post_id,
                            'user_id': user_id,
                        }

                    });
                });

                // UNLIKING

                $(".unlike").click(function(){
                    $.ajax({

                        url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                        type: "post",
                        data: {
                            'unliked': 1,
                            'post_id': post_id,
                            'user_id': user_id,
                        }

                    });
                });

            });




            


        </script>