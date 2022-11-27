<!-- *********** -->
<!--    BUGS     -->
<!-- *********** -->



<!-- ADMIN DASHBOARD -->

query failed if there are no comments on any post 

*** FIXED ***
added if(!empty) to recordCount function


<!-- ADD / EDIT POSTS -->

problem with summernote editor, doesn't strip html tags, doesn't show content in view_all_posts.php because of that -- just in chrome(even if you use paste as plain text), in edge it works(if you paste as plain text)

<!-- PROFILE PAGE -->

if password field is empty and you update user, it changes the password, so you cannot login anymore. if you put password it works fine








<!-- *********** -->
<!--    TO DO    -->
<!-- *********** -->


restrict subscriber in admin page -> show him only My data, his own posts (he can only edit them, admin publishes them etc.), Profile. 
Categories, comments and users is hidden for subscriber --> DONE


add checkboxes and bulk options to categories, comments and user pages in admin


add pagination to posts for specific categories in Front page (CMS home)
