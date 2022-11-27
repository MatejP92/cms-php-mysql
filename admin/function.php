<?php




function imagePlaceholder($image=""){

    if(!$image){
        return "lambo_1.jpg";
    } else {
        return $image;
    }
}


// ************ DATABASE HELPER FUNCTIONS *************//

function redirect($location){
    header("Location:" . $location);
    exit;
}


function query($query){
    global $connection;
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    return $result;
}

function fetchRecords($result){
    return mysqli_fetch_array($result);
}


function count_records($result){
    return mysqli_num_rows($result);
}

function confirmQuery($result){
    global $connection;
    if(!$result){
        die("query failed!" . mysqli_error($connection));
    }

}



// ************ END DATABASE HELPER FUNCTIONS *************//



// ************ GENERAL HELPER FUNCTIONS *************//

function get_username(){

    return isset($_SESSION["username"]) ? $_SESSION["username"] : null;

}

function loggedInUserId(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE user_username='" . $_SESSION["username"] ."'");
        
        $user = mysqli_fetch_array($result);

        return mysqli_num_rows($result) >= 1 ? $user["user_id"] : false;
    }
    return false;
}

function loggedInUserEmail(){
    if(isLoggedIn()){
        $result = query("SELECT * FROM users WHERE user_username='" . $_SESSION["username"] ."'");
        
        $user = mysqli_fetch_array($result);

        return mysqli_num_rows($result) >= 1 ? $user["user_email"] : false;
    }
    return false;
}

// ************ END GENERAL HELPER FUNCTIONS *************//



// ************ AUTHENTICATION HELPER FUNCTIONS *************//

function isLoggedIn(){

    if(isset($_SESSION["user_role"])){

        return true;
    }

    return false;
}


function is_admin(){
    // this function checks if the user that is logged in has the role of admin
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id =". $_SESSION["user_id"] . "");
        $row = fetchRecords($result);
        if($row["user_role"] == "admin"){
            return true;
        } else {
            return false;
        }
    }
    return false;
}

function is_subscriber(){
    // this function checks if the user that is logged in has the role of subscriber
    if(isLoggedIn()){
        $result = query("SELECT user_role FROM users WHERE user_id =". $_SESSION["user_id"] . "");
        $row = fetchRecords($result);
        if($row["user_role"] == "subscriber"){
            return true;
        } else {
            return false;
        }
    }
    return false;
}


function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){

    if(isLoggedIn()){

        redirect($redirectLocation);
    }

}

function currentUser(){

    if(isset($_SESSION["username"])){
        return $_SESSION["username"];
    } else {
        return false;
    }
}


// ************ END AUTHENTICATION HELPER FUNCTIONS *************//



// ************ USER SPECIFIC HELPER FUNCTIONS *************//

function recordCount($table){
    // this function selects data from table and returns the number of rows for that table
    global $connection;
    $query = "SELECT * FROM " . $table;
    $select_all_post = mysqli_query($connection, $query);
    $result = mysqli_num_rows($select_all_post);

    if($result != null){
        return $result;
    } else {
        return $result=0;
    }

    confirmQuery($result);

}


function get_all_user_posts(){
    return query("SELECT * FROM posts WHERE user_id=". loggedInUserId() ."");
}

function get_all_posts_user_comments(){
    return query("SELECT * FROM posts 
                  INNER JOIN comments ON posts.post_id = comments.comment_post_id
                  WHERE user_id=".loggedInUserId()."");
}

function get_all_posts_user_categories(){
    return query("SELECT * FROM categories WHERE user_id=".loggedInUserId()."");
}


function get_all_user_published_post(){
    return query("SELECT * FROM posts WHERE user_id=". loggedInUserId() ." AND post_status='published'");
}

function get_all_user_draft_post(){
    return query("SELECT * FROM posts WHERE user_id=". loggedInUserId() ." AND post_status='draft'");
}

function get_all_approved_user_comments(){
    return query("SELECT * FROM posts 
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()." AND comments.comment_status='approved'");
}

function get_all_unapproved_user_comments(){
    return query("SELECT * FROM posts 
    INNER JOIN comments ON posts.post_id = comments.comment_post_id
    WHERE user_id=".loggedInUserId()." AND comments.comment_status='unapproved'");
}

// ************ END USER SPECIFIC HELPER FUNCTIONS *************//

function ifItIsMethod($method=null){

    if($_SERVER["REQUEST_METHOD"] == strtoupper($method)){
        return true;
    }
        return false;
}





function users_online(){

    if(isset($_GET["onlineusers"])){

    
        global $connection;

        if(!$connection){
            session_start();
            include("../includes/db.php");

            // with this we create how many time has to pass to log out the user --> users online section
            $session = session_id();    // session_id() is a function, when we have a session started, this function will catch the id of the user whether its on chrome, firefox...
            $time = time();             // 
            $time_out_in_seconds = 60;  // the ammount of time for user to be marked offline / afk
            $time_out = $time - $time_out_in_seconds;   // 

            $query = "SELECT * FROM users_online WHERE session = '$session'";
            $send_query = mysqli_query($connection, $query);
            $count = mysqli_num_rows($send_query);  // this count tells us how many users are online

            if($count == NULL) { // if null, that means that a new user just logged in, and we are assigning a new session to table (new row)

                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('$session', '$time')");
                } else {    // this else means, that the user has been here before and the session will just update
                    mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");
                }

            $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'"); // with this we count the number of active users online
            $count_users_online = mysqli_num_rows($users_online_query);
            echo $count_users_online;
        }
    }
}

users_online();



function checkStatus($table, $column, $status){
    // this function selects data from tables with diferent statuses (post status -> draft/published, user_role -> admin/subscriber, ...)
    global $connection;

    $query = "SELECT * FROM $table WHERE $column = '$status' ";
    $result = mysqli_query($connection, $query);
    return mysqli_num_rows($result);
}








function username_exists($username){

    global $connection;

    $query = "SELECT user_username FROM users WHERE user_username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}

function email_exists($email){

    global $connection;

    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0){
        return true;
    } else {
        return false;
    }
}


function userLikedThisPost($post_id){

    $result = query("SELECT * FROM likes WHERE user_id=" . loggedInUserId() . " AND post_id={$post_id}");
    confirmQuery($result);
    return mysqli_num_rows($result) >= 1 ? true : false;
}


function getPostLikes($post_id){
    $result = query("SELECT * FROM likes WHERE post_id=$post_id");
    confirmQuery($result);
    echo mysqli_num_rows($result);
}






function escape($string){
global $connection;

return mysqli_real_escape_string($connection, trim($string));
}







function insert_categories(){

   // CREATE CATEGORY
    global $connection;

   if (isset($_POST["submit"])) {

    $cat_title = $_POST["cat_title"];

    if ($cat_title == "" || empty($cat_title)) {
        echo "This field should not be empty!";
    } else {
        $query = "INSERT INTO categories(cat_title) ";
        $query .= "VALUE ('{$cat_title}') ";

        $create_category_query = mysqli_query($connection, $query);
        header("Location: categories.php");

        if (!$create_category_query) {
            die("Query failed" . mysqli_error($connection));
            }
        }
    }


}


function findAllCategories(){

    global $connection;

    // FIND ALL CATEGORIES QUERY
    $query = "SELECT * FROM categories"; 
    // če še dodaš LIMIT <številka> lahko omejiš koliko kategorij se bo prikazalo ... FROM categories LIMIT <#>
    $select_categories = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row["cat_id"];
        $cat_title = $row["cat_title"];

        echo "<tr>";
       // echo "<td>$cat_id</td>";
        echo "<td>$cat_title</td>";
        echo "<td><a class='btn btn-danger' href = 'categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a class='btn btn-info' href = 'categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "</tr>";
    }
}



function deleteCategory(){

    global $connection;

    if(isset($_GET["delete"])){

        $the_cat_id = $_GET["delete"];
        $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: categories.php");                               
    }   


}





function register_user($username, $email, $password){

    global $connection;
    
    $username   = mysqli_real_escape_string($connection, $username);
    $email      = mysqli_real_escape_string($connection, $email);
    $password   = mysqli_real_escape_string($connection, $password);

    $password = password_hash($password, PASSWORD_BCRYPT, array("cost" => 12)); // with this you don't need to write all that code to crypt the password

        // OLD WAY PASSWORD HASH with RandSalt...
    // $query = "SELECT randSalt FROM users";
    // $select_randsalt_query = mysqli_query($connection, $query);
    // if(!$select_randsalt_query) {
    //     die("Query Failed" . mysqli_error($connection));
    // }

    // $row = mysqli_fetch_array($select_randsalt_query);
    // $salt = $row["randSalt"];
    // // with crypt function we take the entered password and the randSalt value from database and crypt function encrypts the password
    // $password = crypt($password, $salt);

    $query = "INSERT INTO users(
                user_username,
                user_email,
                user_password,
                user_role)
            VALUES(
                '{$username}',
                '{$email}',
                '{$password}',
                'subscriber')";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);

    
    } 




function login_user($username, $password){

    global $connection;


    $username = trim($username);
    $password = trim($password);

    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);


    $query = "SELECT * FROM users WHERE user_username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query){
        die("QUERY FAILED" . mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)){

        $db_user_id         = $row["user_id"];
        $db_user_username   = $row["user_username"];
        $db_user_password   = $row["user_password"];
        $db_user_first_name = $row["user_first_name"];
        $db_user_last_name  = $row["user_last_name"];
        $db_user_role       = $row["user_role"];

        // this crypt function will revert crypted password back to original, so the user can login
        //$password = crypt($password, $db_user_password);
        if(password_verify($password, $db_user_password)){ 
            $_SESSION["user_id"]    = $db_user_id;
            $_SESSION["username"]   = $db_user_username;
            $_SESSION["first_name"] = $db_user_first_name;
            $_SESSION["last_name"]  = $db_user_last_name;
            $_SESSION["user_role"]  = $db_user_role;
            // if (session_status() == PHP_SESSION_NONE) session_start();

            if($db_user_role === "admin"){
                redirect("/cms/admin/");
            } elseif ($db_user_role === "subscriber") {
                redirect("/cms/index.php");
            }
        }
    }
}

