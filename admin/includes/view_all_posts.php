<?php include "delete_modal.php" ?>

<?php

if(is_admin()){
if(isset($_POST["checkBoxArray"])){

    foreach($_POST["checkBoxArray"] as $post_value_id){

        $bulk_options = escape($_POST['bulk_options']);

        switch($bulk_options){

            case "published";
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$post_value_id}";
                $update_to_published_status = mysqli_query($connection, $query);
                break;

            case "draft";
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$post_value_id}";
                $update_to_draft_status = mysqli_query($connection, $query);
                break;

            case "delete";
                $query = "DELETE FROM posts WHERE post_id = {$post_value_id}";
                $delete_post_query = mysqli_query($connection, $query);
                break;

            case "clone";
                $query = "SELECT * FROM posts WHERE post_id = {$post_value_id}";
                $select_post_query = mysqli_query($connection, $query);

                while($row=mysqli_fetch_array($select_post_query)){
                    $post_title       = $row["post_title"];
                    $post_category_id = $row["post_category_id"];
                    $post_date        = $row["post_date"];
                    $post_author      = $row["post_author"];
                    $post_user        = $row["post_user"];
                    $post_status      = $row["post_status"];
                    $post_image       = $row["post_image"];
                    $post_tags        = $row["post_tags"];
                    $post_content     = $row["post_content"];
                }
                $query = "INSERT INTO posts(
                            post_category_id,
                            post_title,
                            post_author,
                            post_user,
                            post_date,
                            post_image,
                            post_content,
                            post_tags,
                            post_status)
                        VALUES(
                            {$post_category_id},
                            '{$post_title}',
                            '{$post_author}',
                            '{$post_user}',
                            now(),
                            '{$post_image}', 
                            '{$post_content}', 
                            '{$post_tags}', 
                            '{$post_status}') ";

                $copy_query = mysqli_query($connection, $query);
                if(!$copy_query){
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                break;
        }
    }
}
}

?>


<form action="" method="post">

    <table class="table table-bordered table-hover">

        <div id="BulkOptionsContainer" class="col-xs-2">
            <select class="form-control" name="bulk_options" id="">
                <option value="">Select Options</option>
                <?php if(is_admin()): ?>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="clone">Clone</option>
                <?php endif; ?>
                <option value="delete">Delete</option>

            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="?source=add_post">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" name="" id="selectAllBoxes"></th>
                <th>Id</th>
                <th>Author</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Image</th>
                <th>Content</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Edit Post</th>
                <th>Delete Post</th>
                <th>Post Views</th>
                <th>Reset Post Views</th>
            </tr>
        </thead>                     
        <tbody>
            
            <?php
            // $query = "SELECT * FROM posts ORDER BY post_id DESC"; 
            // we are now gonna join tables, so we dont need so many querys
            // we write SELECT <database table name>.<collumn name>, <database table name>.<collumn name>
            // so we can use data from different tables

            //    // LONGER WAY!!
            // $query = "SELECT posts.post_id,
            //                  posts.post_author,
            //                  posts.post_user,
            //                  posts.post_title,
            //                  posts.post_category_id,
            //                  posts.post_status,
            //                  posts.post_image,
            //                  posts.post_content,
            //                  posts.post_tags,
            //                  posts.post_comment_count,
            //                  posts.post_date,
            //                  posts.post_view_count,
            //                  categories.cat_id,
            //                  categories.cat_title
            //             FROM posts LEFT JOIN categories ON post.post_category_id = categories.cat_id"; 
                        // here we need a common collumn in both tables. we have cat_id and post_category_id which are the same, they are related


            // ******* with this we show posts only from the user that is currently logged in ******
            // $user = currentUser();
            // $query = "SELECT * FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_user = '$user' ORDER BY posts.post_id DESC";


            // with this query we show all posts, not only from 1 user
                // SHORTER WAY -> because we are selecting everything from posts table              
                if(is_admin()){
                    $query = "SELECT * FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";


                    $select_posts = mysqli_query($connection, $query);
                } else {
                    $user = get_username();
                    $query = "SELECT * FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE posts.post_user='{$user}' ORDER BY posts.post_id DESC";


                    $select_posts = mysqli_query($connection, $query);
                }

            // $query = "SELECT * FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";


            // $select_posts = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_posts)) {
                $post_id    	    = $row["post_id"];
                $post_author        = $row["post_author"];
                $post_user          = $row["post_user"];
                $post_title         = $row["post_title"];
                $post_category_id   = $row["post_category_id"];
                $post_status        = $row["post_status"];
                $post_image         = $row["post_image"];
                $post_content       = substr($row["post_content"],0,80);
                $post_tags          = $row["post_tags"];
                $post_comment_count = $row["post_comment_count"];
                $post_date          = $row["post_date"];
                $post_view_count    = $row["post_view_count"];
                $category_title     = $row["cat_title"];
                $category_id        = $row["cat_id"];

                echo "<tr>";
                ?>
                    <td><input type='checkbox' name='checkBoxArray[]' class='checkBoxes' value="<?php echo $post_id ?>"></td>
                <?php
                echo "<td>{$post_id}</td>";

                if(!empty($post_author)){
                    echo "<td>{$post_author}</td>";
                } elseif(!empty($post_user)) {
                    echo "<td>{$post_user}</td>";
                }

                




                echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";

                        // show category name instead of category id
                    // $query = "SELECT * FROM categories WHERE cat_id = $post_category_id  ";
                    // $select_categories_id = mysqli_query($connection, $query);
        
                    // while ($row = mysqli_fetch_assoc($select_categories_id)) {
                    //     $cat_id = $row["cat_id"];
                    //     $cat_title = $row["cat_title"];
                    echo "<td>{$category_title}</td>";
                    // }
                echo "<td>{$post_status}</td>";
                echo "<td><img width='100' src='../images/$post_image' alt='image'></td>";
                echo "<td>{$post_content}</td>";
                echo "<td>{$post_tags}</td>";

                    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                    $send_comment_query = mysqli_query($connection, $query);

                    $row = mysqli_fetch_array($send_comment_query);

                    if(!empty($row)){
                        $comment_id = $row["comment_id"];
                        $count_comments = mysqli_num_rows($send_comment_query);
    
                    echo "<td><a href='post_comment.php?id=$post_id'>{$count_comments}</a></td>";
                    } else {
                        $count_comments = 0;
                        echo "<td>{$count_comments}</td>";
                    }





                echo "<td>{$post_date}</td>";
                echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit Post</a></td>";

                ?>
                <!-- <form action="" method="post">
                    <input type="hidden" name="post_id" value="<?php //echo $post_id ?>">
                    <?php
                    //echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>"
                    ?>
                </form> -->
                <?php 

                echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link btn btn-danger'>Delete Post</a></td>"; // this echo uses a bootstrap modal instead of vanilla javascript
                // echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to Delete?'); \" href='posts.php?delete={$post_id}'>Delete Post</a></td>";

                echo "<td>{$post_view_count}</td>";
                echo "<td><a class='btn btn-info' onClick=\"javascript: return confirm('Are you sure you want to reset views?'); \" href='posts.php?reset={$post_id}'>Reset Views</a></td>";

                echo "</tr>";
            }
            ?>

        </tbody>
    </table>

</form>

<?php

if(isset($_GET["delete"])){

    $the_post_id = escape($_GET["post_id"]);

    $query = "DELETE FROM posts WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['delete']) ." ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: /cms/admin/posts.php");
    
}


if(isset($_GET["reset"])){

    $the_post_id = escape($_GET["reset"]);

    $query = "UPDATE posts SET post_view_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) ." ";
    $reset_views_query = mysqli_query($connection, $query);
    header("Location: posts.php");
}

?>



<script>

$(document).ready(function(){
    
    $(".delete_link").on("click", function(){

        var id = $(this).attr("rel");

        var delete_url = "posts.php?delete=" + id;

        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal("show");

    });

});

</script>
