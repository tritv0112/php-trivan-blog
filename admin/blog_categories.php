<?php

    include 'includes/database.php';
    include 'includes/categories.php';

    $category = new Category($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if ($_POST['form_name'] == 'add_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];

            // Bind Params
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->create()) {
                $flag = "Create category successfully!";
            }

        }

        if ($_POST['form_name'] == 'edit_category') {
            $title = $_POST['category_title'];
            $metaTitle = $_POST['category_meta_title'];
            $path = $_POST['category_path'];
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            $category->v_category_title = $title;
            $category->v_category_meta_title = $metaTitle;
            $category->v_category_path = $path;
            $category->d_date_created = date('Y/m/d', time()); 
            $category->d_time_created = date('h:i:s', time());
            
            if ($category->update()) {
                $flag = "Edit category successfully!";
            }

        }

        if ($_POST['form_name'] == 'delete_category') {
            $id = $_POST['category_id'];

            // Bind Params
            $category->n_category_id = $id;
            if ($category->delete()) {
                $flag = "Delete category successfully!";
            }

        }

    }

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Free Bootstrap Admin Template : Dream</title>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Morris Chart Styles-->
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <!-- Custom Styles-->
    <link href="assets/css/custom-styles.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>

<body>
    <div id="wrapper">
        <?php 
            include 'header.php'; 
            include 'sidebar.php'; 
        ?>
        
        <div id="page-wrapper">
            <div id="page-inner">


                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Blog Categories
                        </h1>
                    </div>
                </div>
                <!-- /. ROW  -->

                <?php 
                
                    if (isset($flag)) {
                
                ?>

                <div class="alert alert-success">
                    <strong><?php echo $flag; ?></strong>
                </div>

                <?php 
                
                    }
                
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Add Category
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="">
                                            <div class="form-group">
                                                <label>Category Title</label>
                                                <input class="form-control" name="category_title" placeholder="Enter title">
                                            </div>
                                            <div class="form-group">
                                                <label>Category Meta Title</label>
                                                <input class="form-control" name="category_meta_title" placeholder="Enter meta title">
                                            </div>
                                            <div class="form-group">
                                                <label>Category Path (lowercase, no spaces)</label>
                                                <input class="form-control" name="category_path" placeholder="Enter path">
                                            </div>
                                            <input type="hidden" name="form_name" value="add_category">
                                            <button type="submit" class="btn btn-default">Add Category</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                All Categories
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Title</th>
                                                        <th>Meta Title</th>
                                                        <th>Path</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    
                                                        $result = $category->read();
                                                        $num = $result->rowCount();
                                                        if ($num > 0) {
                                                            while ($rows = $result->fetch()) {

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rows['n_category_id']; ?></td>
                                                        <td><?php echo $rows['v_category_title']; ?></td>
                                                        <td><?php echo $rows['v_category_meta_title']; ?></td>
                                                        <td><?php echo $rows['v_category_path']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-default popup-button">View</button>
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#edit-category<?php echo $rows['n_category_id']; ?>">Edit</button>
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#delete-category<?php echo $rows['n_category_id']; ?>">Drop</button>
                                                            <div class="modal fade" id="edit-category<?php echo $rows['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form role="form" method="POST" action="">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                <h4 class="modal-title" id="myModalLabel">Modal title Here</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label>Category Title</label>
                                                                                    <input class="form-control" name="category_title" value="<?php echo $rows['v_category_title']; ?>">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Category Meta Title</label>
                                                                                    <input class="form-control" name="category_meta_title" value="<?php echo $rows['v_category_meta_title']; ?>">
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label>Category Path (lowercase, no spaces)</label>
                                                                                    <input class="form-control" name="category_path" value="<?php echo $rows['v_category_path']; ?>">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="form_name" value="edit_category">
                                                                                <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal fade" id="delete-category<?php echo $rows['n_category_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form role="form" method="POST" action="">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                <h4 class="modal-title" id="myModalLabel">Delete Category</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure that you want to delete this category?    
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="form_name" value="delete_category">
                                                                                <input type="hidden" name="category_id" value="<?php echo $rows['n_category_id']; ?>">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary">Delete</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <?php

                                                            }
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.row (nested) -->
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

				<footer><p>&copy;2022</p></footer>
            </div>
            <!-- /. PAGE INNER  -->
        </div>
        <!-- /. PAGE WRAPPER  -->
    </div>
    <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- Bootstrap Js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- THAY DOI NAVBAR -->
    <script src="assets/js/thay-doi-navbar.js"></script>
    <!-- Metis Menu Js -->
    <script src="assets/js/jquery.metisMenu.js"></script>
    <!-- Morris Chart Js -->
    <script src="assets/js/morris/raphael-2.1.0.min.js"></script>
    <script src="assets/js/morris/morris.js"></script>
    <!-- Custom Js -->
    <script src="assets/js/custom-scripts.js"></script>


</body>

</html>