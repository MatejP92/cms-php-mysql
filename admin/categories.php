<?php include "includes/admin_header.php" ?>

<div id="wrapper">

    <?php include "includes/admin_navigation.php" ?>






    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">

                    <h1 class="page-header">
                        Welcome to ADMIN
                        <small>Author</small>
                    </h1>

                    <div class="col-xs-6">
                        
                        <!-- CREATE CATEGORY FORM -->

                        <?php insert_categories(); ?> 
                            
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="cat_title">Add Category</label>
                                <input type="text" class="form-control" name="cat_title">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                            </div>
                        </form>

                   <!-- CREATE CATEGORY FORM END -->
                
                        <?php
                        // UPDATE CATEGORY and include query

                        if(isset($_GET["edit"])) {
                            $cat_id = escape($_GET["edit"]);
                            include "includes/update_categories.php";
                        }
                
                        // UPDATE CATEGORY END
                        ?>
                        
                    </div>



                    <div class="col-xs-6">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <!-- <th class="text-center">Id</th> -->
                                    <th class="text-center">Category Title</th>
                                    <th class="text-center">Delete Category</th>
                                    <th class="text-center">Edit Category</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                
                                <?php findAllCategories(); ?>


                                <?php deleteCategory(); ?>

                            </tbody>
                        </table>



                    </div>

                </div>



            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
