﻿<?php

    include 'includes/database.php';
    include 'includes/contacts.php';

    $contact = new Contact($db);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        if (isset($_POST['delete'])) {
            
            $contact->n_contact_id = $_POST['contact_id'];
            if ($contact->delete()) {
                $flag = "Delete contact successfully!";
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
                            Blog Contacts
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
                                All Contacts
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fullname</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Message</th>
                                                        <th>Date Time Created</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    
                                                        $result = $contact->read();
                                                        $num = $result->rowCount();
                                                        if ($num > 0) {
                                                            while ($rows = $result->fetch()) {

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $rows['n_contact_id']; ?></td>
                                                        <td><?php echo $rows['v_fullname']; ?></td>
                                                        <td><?php echo $rows['v_email']; ?></td>
                                                        <td><?php echo $rows['v_phone']; ?></td>
                                                        <td><?php echo $rows['v_message']; ?></td>
                                                        <td><?php echo $rows['d_date_created'] . ' ' . $rows['d_time_created']; ?></td>
                                                        <td>
                                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#delete-sub<?php echo $rows['n_contact_id']; ?>">Drop</button>
                                                            <div class="modal fade" id="delete-sub<?php echo $rows['n_contact_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <form role="form" method="POST" action="">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                                                <h4 class="modal-title" id="myModalLabel">Delete Subscriber</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Are you sure that you want to delete this contact?    
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <input type="hidden" name="contact_id" value="<?php echo $rows['n_contact_id']; ?>">
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