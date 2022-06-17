<?php

    include 'includes/database.php';
    include 'includes/blogs.php';
    include 'includes/tags.php';

    $blog = new Blog($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['upload'])) {

            $target_file = 'images/upload/';
            if (!empty($_FILES['main_image']['name'])) {
                $main_image = $_FILES['main_image']['name'];
                move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file . $main_image);
            } else {
                $main_image = '';
            }

            $target_file = 'images/upload/';
            if (!empty($_FILES['alt_image']['name'])) {
                $alt_image = $_FILES['alt_image']['name'];
                move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file . $alt_image);
            } else {
                $alt_image = '';
            }

            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            $blog->n_category_id = $_POST['select_category'];	
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = $main_image;
            $blog->v_alt_image_url = $alt_image;
            $blog->n_blog_post_views = 0;
            $blog->n_home_page_placement = $opt;
            $blog->f_post_status = 1;
            $blog->d_date_created = date('Y-m-d', time());
            $blog->d_time_created = date('h:i:s', time());

            if ($blog->create()) {
                $flag = "Upload blog successfully!";
            }

            // Write blog tag
            $tag = new Tag($db);
            $tag->n_blog_post_id = $blog->last_id();
            $tag->v_tag = $_POST['blog_tags'];
            $tag->create();
            
        }

        if (isset($_POST['update'])) {

            $target_file = 'images/upload/';
            if (!empty($_FILES['main_image']['name'])) {
                $main_image = $_FILES['main_image']['name'];
                move_uploaded_file($_FILES['main_image']['tmp_name'], $target_file . $main_image);
            } else {
                $main_image = $_POST['old_main_image'];
            }

            $target_file = 'images/upload/';
            if (!empty($_FILES['alt_image']['name'])) {
                $alt_image = $_FILES['alt_image']['name'];
                move_uploaded_file($_FILES['alt_image']['tmp_name'], $target_file . $alt_image);
            } else {
                $alt_image = $_POST['old_alt_image'];
            }

            $opt = (!empty($_POST['opt_place'])) ? $_POST['opt_place'] : 0;

            // Params
            $blog->n_blog_post_id = $_POST['blog_id'];	
            $blog->n_category_id = $_POST['select_category'];	
            $blog->v_post_title = $_POST['title'];	
            $blog->v_post_meta_title = $_POST['meta_title'];	
            $blog->v_post_path = $_POST['blog_path'];	
            $blog->v_post_summary = $_POST['blog_summary'];	
            $blog->v_post_content = $_POST['blog_content'];	
            $blog->v_main_image_url = $main_image;
            $blog->v_alt_image_url = $alt_image;
            $blog->n_blog_post_views = $_POST['post_view'];	
            $blog->n_home_page_placement = $opt;
            $blog->f_post_status = $_POST['status'];
            $blog->d_date_created = $_POST['date_created'];	
            $blog->d_time_created = $_POST['time_created'];	
            $blog->d_date_updated = date('Y-m-d', time());
            $blog->d_time_updated = date('h:i:s', time());
            
            if ($blog->update()) {
                $flag = "Upload successfully!";
            }

        }

        if (isset($_POST['delete'])) {
            $tag = new Tag($db);
            $tag->n_blog_post_id = $_POST['blog_id'];
            $tag->delete();

            if ($_POST['main_image'] != '') {
                unlink('images/upload/' . $_POST['main_image']);
            }

            if ($_POST['alt_image'] != '') {
                unlink('images/upload/' . $_POST['alt_image']);
            }

            $blog->n_blog_post_id = $_POST['blog_id'];
            if ($blog->delete()) {
                $flag = "Delete blog successfully!";
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
                            Blogs
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
                                Blog Posts
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
                                                        <th>Views</th>
                                                        <th>Path</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    
                                                        $result = $blog->read();
                                                        $num = $result->rowCount();
                                                        if ($num > 0) {
                                                            while ($rows = $result->fetch()) {

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rows['n_blog_post_id']; ?></td>
                                                        <td><?php echo $rows['v_post_title']; ?></td>
                                                        <td><?php echo $rows['n_blog_post_views']; ?></td>
                                                        <td><?php echo $rows['v_post_path']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-default popup-button">View</button>
                                                            <button type="button" class="btn btn-default" onclick="location.href='edit_blog.php?id=<?php echo $rows['n_blog_post_id']; ?>'">Edit</button>
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#delete-blog<?php echo $rows['n_blog_post_id']; ?>">Drop</button>
                                                            <div class="modal fade" id="delete-blog<?php echo $rows['n_blog_post_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form role="form" method="POST" action="">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                <h4 class="modal-title" id="myModalLabel">Delete Blog</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure that you want to delete this blog?    
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="form_name" value="delete_blog">
                                                                                <input type="hidden" name="main_image" value="<?php echo $rows['v_main_image_url']; ?>">
                                                                                <input type="hidden" name="alt_image" value="<?php echo $rows['v_alt_image_url']; ?>">
                                                                                <input type="hidden" name="blog_id" value="<?php echo $rows['n_blog_post_id']; ?>">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                <button type="submit" class="btn btn-primary" name="delete">Delete</button>
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