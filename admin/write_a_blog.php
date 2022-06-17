<?php

    include 'includes/database.php';
    include 'includes/categories.php';

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
    <!-- Include summernote css/js -->
    <link href='assets/summernote/summernote.min.css' rel='stylesheet' />
    
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
                            Write A Blog
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
                                Write A Blog
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <form role="form" method="POST" action="blogs.php" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input class="form-control" name="title" placeholder="Enter category">
                                            </div>
                                            <div class="form-group">
                                                <label>Meta Title</label>
                                                <input class="form-control" name="meta_title" placeholder="Enter meta category">
                                            </div>
                                            <?php

                                                $cate = new Category($db);
                                                $result = $cate->read();

                                            ?>
                                            <div class="form-group">
                                                <label>Blog Category</label>
                                                <select class="form-control" name="select_category">
                                                    <?php 
                                                        while ($rs = $result->fetch()) {
                                                    ?>
                                                    <option value="<?php echo $rs['n_category_id']; ?>"><?php echo $rs['v_category_title']; ?></option>
                                                    <?php 
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Main Image</label>
                                                <input type="file" name="main_image">
                                            </div>
                                            <div class="form-group">
                                                <label>Alt Image</label>
                                                <input type="file" name="alt_image"></div>
                                            <div class="form-group">
                                                <label>Summary</label>
                                                <textarea class="form-control" id="summernote_summary" name="blog_summary" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Content</label>
                                                <textarea class="form-control" id="summernote_content" name="blog_content" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Tags</label>
                                                <input class="form-control" name="blog_tags" placeholder="Enter meta title">
                                            </div>
                                            <div class="form-group">
                                                <label>Blog Path</label>
                                                <input class="form-control" name="blog_path" placeholder="Enter meta title">
                                            </div>
                                            <div class="form-group">
                                                <label>Home Page Placement</label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline1" value="1">1
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline2" value="2">2
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="opt_place" id="optionsRadiosInline3" value="3">3
                                                </label>
                                            </div>
                                            <button type="submit" class="btn btn-default" name="upload">Create Blog</button>
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
    <!-- Summernote Js -->
    <script src="assets/summernote/summernote.min.js"></script>

    <script>
        $('#summernote_summary').summernote({
            placeholder: 'Blog summary',
            height: '100',
        });
        $('#summernote_content').summernote({
            placeholder: 'Blog content',
            height: '200',
        });
    </script>

</body>

</html>