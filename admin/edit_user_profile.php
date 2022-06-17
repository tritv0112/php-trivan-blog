<?php

    include 'includes/database.php';
    include 'includes/users.php';

    $user = new User($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['edit_user_profile'])) {

            if (!empty($_FILES['image_profile']['name'])) {
                $target_file = 'images/avatars/';
                $image_name = $_FILES['image_profile']['name'];
                move_uploaded_file($_FILES['image_profile']['tmp_name'], $target_file . $image_name);
            } else {
                $image_name = $_POST['old_image_profile'];    
            }

            $user->n_user_id = $_POST['user_id'];
            $user->v_fullname = $_POST['name'];
            $user->v_email = $_POST['email'];
            $user->v_username = $_POST['username'];
            $user->v_password = ($_POST['password'] != $_POST['old_password']) ? md5($_POST['password']) : $_POST['old_password'];
            $user->v_phone = $_POST['phone'];
            $user->v_image = $image_name;
            $user->v_message = $_POST['about'];
            $user->d_date_updated = date('Y-m-d', time());
            $user->d_time_updated = date('h:i:s', time());

            if ($user->update()) {
                $flag = "Update profile successfully!";
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
                            User Profile
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
                                Profile Page
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <?php

                                        $result = $user->read();
                                        $row = $result->fetch();

                                    ?>

                                    <div class="col-lg-9">
                                        <form role="form" method="POST" action="" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label>Full Name</label>
                                                <input class="form-control" name="name" value="<?php echo $row['v_fullname']; ?>" placeholder="Enter full name">
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input class="form-control" name="email" value="<?php echo $row['v_email']; ?>" placeholder="Enter email">
                                            </div>
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input class="form-control" name="username" value="<?php echo $row['v_username']; ?>" placeholder="Enter username">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" name="password" value="<?php echo $row['v_password']; ?>"placeholder="Enter password">
                                                <input type="hidden" name="old_password" value="<?php echo $row['v_password']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Phone Number</label>
                                                <input class="form-control" name="phone" value="<?php echo $row['v_phone']; ?>"placeholder="Enter phone number">
                                            </div>
                                            <div class="form-group">
                                                <label>Image Profile</label>
                                                <input type="file" name="image_profile">
                                                <input type="hidden" name="old_image_profile" value="<?php echo $row['v_image']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label>About Me</label>
                                                <textarea class="form-control" id="summernote_profile" name="about" rows="3"><?php echo $row['v_message']; ?></textarea>
                                            </div>
                                            <input type="hidden" name="user_id" value="<?php echo $row['n_user_id']; ?>">
                                            <button type="submit" class="btn btn-default" name="edit_user_profile">Upload Profile</button>
                                        </form>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                Image Profile
                                            </div>
                                            <div class="panel-body" align="center">
                                                <?php 
                                                    if (empty($row['v_image'])) {
                                                ?>
                                                <img class="img-thumbnail" src="images/avatars/user-01.jpg" alt="Vinhs" width="180px">
                                                <?php 
                                                    } else {
                                                ?>
                                                <img class="img-thumbnail" src="images/avatars/<?php echo $row['v_image']; ?>" alt="Vinhs" width="180px">
                                                <?php 
                                                    }
                                                ?>
                                            </div>
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
        $('#summernote_profile').summernote({
            placeholder: 'About me',
            height: '100',
        });
    </script>

</body>

</html>