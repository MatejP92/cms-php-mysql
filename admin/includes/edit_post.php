<?php

if(isset($_GET["p_id"])){

    $the_post_id = escape($_GET["p_id"]);

}


$query = "SELECT * FROM posts WHERE post_id = $the_post_id "; 
$select_posts_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id            = $row["post_id"];
    $post_user          = $row["post_user"];
    $post_title         = $row["post_title"];
    $post_category_id   = $row["post_category_id"];
    $post_status        = $row["post_status"];
    $post_image         = $row["post_image"];
    $post_content       = $row["post_content"];
    $post_tags          = $row["post_tags"];
    $post_comment_count = $row["post_comment_count"];
    $post_date          = $row["post_date"];
}




if(isset($_POST["update_post"])) {

    
    //$post_user          = escape($_POST["post_user"]);
    $post_title         = escape($_POST["post_title"]);
    $post_category_id   = escape($_POST["post_category"]);
    //$post_status        = escape($_POST["post_status"]);
    $post_image         = escape($_FILES["image"]["name"]);
    $post_image_temp    = escape($_FILES["image"]["tmp_name"]);
    $post_content       = escape($_POST["post_content"]);
    $post_tags          = escape($_POST["post_tags"]);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if(empty($post_image)){

        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);

        while($row = mysqli_fetch_array($select_image)){
            $post_image = $row["post_image"];
        }
    }
    
    
    $query = "UPDATE posts SET
            post_title = '{$post_title}',
            post_category_id = '{$post_category_id}',
            post_date = now(),
            post_user = '{$post_user}',
            post_status = '{$post_status}',
            post_tags = '{$post_tags}',
            post_content = '{$post_content}',
            post_image = '{$post_image}'
            WHERE post_id = {$the_post_id}";

    $update_post = mysqli_query($connection, $query);

    confirmQuery($update_post);


    echo "<p class = 'bg-success'>Post Updated. <a href='../post.php?p_id=$the_post_id'>View Post</a> or 
    <a href='posts.php'>Edit More Posts</a></p>";

}

?>

<form action="" method="post" enctype="multipart/form-data">    
     
      <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title ?>">
      </div>

    <div class="form-group">
        <label for="categories">Category</label>
        <!-- <select name="post_category" id=""> -->


        <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
            $cat_id = $row["cat_id"];
            $cat_title = $row["cat_title"];

                if($cat_id == $post_category_id) {
                    echo "$cat_title";
                }
            }

            //    echo "<option selected value='{$cat_id}'>{$cat_title}</option>";
            // }else {
            //     echo "<option value='{$cat_id}'>{$cat_title}</option>";
            // }

            // }

        ?>

        </select>
    </div>
    
<!-- ADD USERS DROPDOWN TO ADD POST PAGE -->
<div class="form-group">
        <label for="users">Post User</label>
            <p><?php echo $post_user ?></p>

        <!-- <select name="post_user" id="">
        
        <?php
        // echo "<option value='{$post_user}'>{$post_user}</option>";

        //     $user_query = "SELECT * FROM users";
        //     $select_users = mysqli_query($connection, $user_query);

        //     confirmQuery($select_users);

        //     while ($row = mysqli_fetch_assoc($select_users)) {
        //         $user_id = $row["user_id"];
        //         $user_username = $row["user_username"];

        //     echo "<option value='{$user_username}'>{$user_username}</option>";

        //     }
            ?>
        </select> -->
    </div>


    <!-- <div class="form-group">
        <label for="title">Post user</label>
        <input type="text" class="form-control" name="post_user" value="<?php //echo $post_user ?>">
    </div> -->
    
    <div class="form-group">
        <label for="post_status">Post Status</label>

        <?php if(is_admin()): ?>
        <select name="post_status" id="">

        <option value="<?php echo $post_status ?>"><?php echo $post_status ?></option>

            <?php

            if($post_status == "published"){

                echo "<option value='draft'>Draft</option>";
            } else {
                echo "<option value='published'>Published</option>";
            }

            ?>

        </select>
        <?php else: ?>
            <p><?php echo "$post_status"; ?></p>

        <?php endif; ?>
        
    </div>


    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <img width="100" src="../images/<?php echo $post_image ?> " alt="Post image">
        
        <input type="file" name="image">
    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags ?>">
    </div>
    
    <div class="form-group">
        <label for="summernote">Post Content</label>
        <textarea name="post_content" id="summernote" cols="30" rows="10" class="form-control"><?php echo $post_content ?></textarea>
    </div>
    
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
    </div>
     
     
</form>
