<?php include "includes/admin_header.php" ?>

<div id="wrapper">

<?php

$post_count = count_records(get_all_user_posts());

$comment_count = count_records(get_all_posts_user_comments());

$categories_count = count_records(get_all_posts_user_categories());


    // SELECT ALL USER PUBLISHED POSTS TO DISPLAY
    $post_published_count = count_records(get_all_user_published_post());

    // SELECT ALL USER DRAFT POSTS TO DISPLAY
$post_draft_count = count_records(get_all_user_draft_post());

    // SELECT ALL USER APPROVED COMMENTS TO DISPLAY
$comment_approved_count = count_records(get_all_approved_user_comments());

    // SELECT ALL USER UNAPPROVED COMMENTS TO DISPLAY
$comment_unapproved_count = count_records(get_all_unapproved_user_comments());
?>

    <?php include "includes/admin_navigation.php" ?>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome to USER DASHBOARD
                        <small><?php echo get_username(); ?></small>
                    </h1>   

                </div>

            </div>
       
                <!-- /.row -->
                
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">                             

                                        <?php echo "<div class='huge'>". $post_count ."</div>"; ?>

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

                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                    <?php echo "<div class='huge'>". $comment_count ."</div>"; ?>

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


                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                    <?php echo "<div class='huge'>". $categories_count ."</div>"; ?>
                                        
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
                                $element_text = ["All Posts", "Published Posts", "Draft Posts", "All Comments", "Approved Comments", "Unapproved Comments", "Categories"];
                                // naredimo array za število, koliko jih je posameznih elementov
                                $element_count = [$post_count, $post_published_count, $post_draft_count, $comment_count, $comment_approved_count, $comment_unapproved_count, $categories_count];
                                // uporabimo for loop da ustvarimo array, kateri vstavi vrednosti texta in counta v array ["$element_text", $element_count]
                                
                                for($i = 0; $i < 7; $i++){

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
