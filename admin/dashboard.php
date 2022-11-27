<?php include "includes/admin_header.php" ?>

<div id="wrapper">


    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome to the ADMIN DASHBOARD
                        <small><?php echo get_username() ?></small>
                    </h1>   

                </div>
            </div>
       
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class='huge'><?php echo $post_count = recordCount("posts"); ?></div>

                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                    <div class='huge'><?php echo $comment_count = recordCount("comments"); ?></div>

                                    <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class='huge'><?php echo $user_count = recordCount("users"); ?></div>

                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <div class='huge'><?php echo $categories_count = recordCount("categories"); ?></div>
                                        
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <!-- Google charts -->

                <?php

                        // // SELECT ALL PUBLISHED POSTS TO DISPLAY
                    $post_published_count = checkStatus("posts", "post_status", "published");
                        // // THIS CODE BELLOW IS NOW IN functions.php in function checkStatus
                    // $query = "SELECT * FROM posts WHERE post_status = 'published'";
                    // $select_all_published_post = mysqli_query($connection, $query);
                    // $post_published_count = mysqli_num_rows($select_all_published_post);


                        // SELECT ALL DRAFT POSTS TO DISPLAY
                    $post_draft_count = checkStatus("posts", "post_status", "draft");
                        // // THIS CODE BELLOW IS NOW IN functions.php in function checkStatus                    
                    // $query = "SELECT * FROM posts WHERE post_status = 'draft'";
                    // $select_all_draft_post = mysqli_query($connection, $query);
                    // $post_draft_count = mysqli_num_rows($select_all_draft_post);

                        // SELECT ALL APPROVED COMMENTS TO DISPLAY
                    $comment_approved_count = checkStatus("comments", "comment_status", "approved");
                        // // THIS CODE BELLOW IS NOW IN functions.php in function checkStatus
                    // $query = "SELECT * FROM comments WHERE comment_status = 'approved'";
                    // $select_all_approved_comments = mysqli_query($connection, $query);
                    // $comment_approved_count = mysqli_num_rows($select_all_approved_comments);


                        // SELECT ALL UNAPPROVED COMMENTS TO DISPLAY
                    $comment_unapproved_count = checkStatus("comments", "comment_status", "unapproved");
                        // // THIS CODE BELLOW IS NOW IN functions.php in function checkStatus
                    // $query = "SELECT * FROM comments WHERE comment_status = 'unapproved'";
                    // $select_all_unapproved_comments = mysqli_query($connection, $query);
                    // $comment_unapproved_count = mysqli_num_rows($select_all_unapproved_comments);

                        // SELECT ALL ADMINS TO DISPLAY
                    $admin_count = checkStatus("users", "user_role", "admin");
                        // // THIS CODE BELLOW IS NOW IN functions.php in function checkStatus
                    // $query = "SELECT * FROM users WHERE user_role = 'admin'";
                    // $select_all_admins = mysqli_query($connection, $query);
                    // $admin_count = mysqli_num_rows($select_all_admins);
                   

                    // SELECT ALL SUBSCRIBERS TO DISPLAY
                    $subscriber_count = checkStatus("users", "user_role", "subscriber");
                        // // THIS CODE BELLOW IS NOW IN functions.php in function checkStatus
                    // $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
                    // $select_all_subscribers = mysqli_query($connection, $query);
                    // $subscriber_count = mysqli_num_rows($select_all_subscribers);

                ?>


                <div class="row">

                    <script type="text/javascript">
                        google.charts.load('current', {'packages':['bar']});
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Data', ''],


                            <?php
                                // naredimo array za vse elemente, katere želimo prikazati
                                $element_text = ["All Posts", "Published Posts", "Draft Posts", "All Comments", "Approved Comments", "Unapproved Comments", "Admins", "Subscribers", "Categories"];
                                // naredimo array za število, koliko jih je posameznih elementov
                                $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $comment_approved_count, $comment_unapproved_count, $admin_count, $subscriber_count, $categories_count];
                                // uporabimo for loop da ustvarimo array, kateri vstavi vrednosti texta in counta v array ["$element_text", $element_count]
                                
                                for($i = 0; $i < 9; $i++){

                                    echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";

                                }

                            ?>
                            // $element_text so vrednosti v levem delu array-a ['Posts']
                            // $element_count so vrednosti v desnem delu array-a [1000]
                            // ['Posts', 1000],
                            ]);

                            var options = {
                            chart: {
                                title: '',
                                subtitle: '',
                            }
                            };

                            var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

                            chart.draw(data, google.charts.Bar.convertOptions(options));
                        }
                    </script>

                    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>

                </div>

                <!-- Google charts end -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
