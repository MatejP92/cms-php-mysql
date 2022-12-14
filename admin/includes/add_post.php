<?php


if(isset($_POST["create_post"])){

    


    $post_title       = escape($_POST["title"]);
    if(is_admin()){
        $post_user    = escape($_POST["post_user"]);
    } else {
        $post_user    = get_username();
    }
    $user_id          = loggedInUserId(); // with this we add the current logged in id to the table, makes more sense
    $post_category_id = escape($_POST["post_category_id"]);
    $post_status      = escape($_POST["post_status"]);

    $post_image       = escape($_FILES["image"]["name"]);
    $post_image_temp  = escape($_FILES["image"]["tmp_name"]);

    $post_tags        = escape($_POST["post_tags"]);
    $post_content     = escape($_POST["post_content"]);
    $post_date        = date("d-m-y");

    move_uploaded_file($post_image_temp, "../images/$post_image");





    $query = "INSERT INTO posts(
                post_category_id, 
                user_id,
                post_title,
                post_user,
                post_date,
                post_image,
                post_content,
                post_tags,
                post_status) 
            VALUES(
                {$post_category_id},
                {$user_id},
                '{$post_title}',
                '{$post_user}',
                now(),
                '{$post_image}',
                '{$post_content}',
                '{$post_tags}',
                '{$post_status}') ";

    $create_post_query = mysqli_query($connection, $query);

    confirmQuery($create_post_query);

    // this mysqli function gets the post with the last Id that was created and assigns it to a variable $the_post_id
    $the_post_id = mysqli_insert_id($connection);

    echo "<p class = 'bg-success'>Post Created. <a href='../post.php?p_id=$the_post_id'>View Post</a> or 
    <a href='posts.php'>Edit Posts</a></p>";
}

?>

<form action="" method="post" enctype="multipart/form-data">    
     
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
    </div>

<!-- add category dropdown to add post page -->
    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category_id" id="">

        <?php
            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirmQuery($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row["cat_id"];
                $cat_title = $row["cat_title"];

            echo "<option value='{$cat_id}'>{$cat_title}</option>";

            

            }
            ?>
        </select>
    </div>

<!--       
     <div class="form-group">
         <label for="author">Post Author</label>
         <input type="text" class="form-control" name="author">
     </div> -->

<!-- ADD USERS DROPDOWN TO ADD POST PAGE -->
    <div class="form-group">
        <label for="users">Post User</label>
        
        <?php if(is_admin()): ?>

        <select name="post_user" id="">

        <?php
            $user_query = "SELECT * FROM users";
            $select_users = mysqli_query($connection, $user_query);

            confirmQuery($select_users);

            while ($row = mysqli_fetch_assoc($select_users)) {
                $user_id = $row["user_id"];
                $user_username = $row["user_username"];
            echo "<option value='{$user_username}'>{$user_username}</option>";
            }
            ?>
        </select>
        <?php else: ?>
            <?php echo get_username() ?>
        <?php endif; ?>
    </div>




     
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <?php if(is_admin()): ?>
            <select name="post_status" id="">
                <option value="draft">Draft</option>
                <option value="published">Published</option>
            </select>
        <?php else: ?>
            <select name="post_status" id="">
                <option value="draft">Draft</option>
        <?php endif; ?>
     </div>
     
    <div class="form-group">
         <label for="post_image">Post Image</label>
         <input type="file" name="image">
     </div>
   
     <div class="form-group">
         <label for="post_tags">Post Tags</label>
         <input type="text" class="form-control" name="post_tags">
     </div>
      
      <div class="form-group">
         <label for="summernote">Post Content</label>
         <textarea name="post_content" id="summernote" cols="30" rows="10" class="form-control"></textarea>
     </div>
     
     <div class="form-group">
     <input type="submit" class="btn btn-primary" name="create_post" value="Create Post">
     
     </div>
     
     
</form>

