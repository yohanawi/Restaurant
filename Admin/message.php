<?php
/* DATABASE CONNECTION*/
$db_name = 'mysql:host=localhost;dbname=restaurants';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);

require_once "functions/db.php";


$sql_message = "SELECT * FROM messages";
$query_message = mysqli_query($connection, $sql_message);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../Asset/icon.png">
    <title>Restaurant</title>
    <!-- Bootstrap Core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css" rel="stylesheet">
    <link href="../plugins/bower_components/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- animation CSS -->
    <link href="css/animate.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- color CSS -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!--admin css-->
    <link href="css/admin-css.css" rel="stylesheet">
</head>

<body>
    <div id="wrapper">
        <!--header-->
        <?php include './components/header.php'; ?>
        <!-- Left navbar-header -->
        <?php include './components/navbar.php'; ?>
        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12"></div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Dashboard</a></li>
                            <li class="active">Message</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-lg-12 col-md-9 col-sm-12 col-xs-12 mail_listing">
                                    <div class="inbox-center">
                                        <?php
                                        if (isset($_GET["deleted"])) {
                                            echo
                                            '<div class="alert alert-warning" >
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                                    <strong>DELETED!! </strong><p> The message has been successfully deleted.</p>
                                                    </div>';
                                        } elseif (isset($_GET["del_error"])) {
                                            echo
                                            '<div class="alert alert-danger" >
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                                    <strong>ERROR!! </strong><p> There was an error during deleting this record. Please try again.</p>
                                                    </div>';
                                        }
                                        ?>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <h4>Recent Messages(<b style="color: orange;"><?php echo mysqli_num_rows($query_message); ?></b>)</h4>
                                                        <?php
                                                        if (mysqli_num_rows($query_message) == 0) {
                                                            echo "<i style='color:brown;'>No messages Yet :( </i> ";
                                                        } else {
                                                            echo '<thead>
                                                                            <tr>
                                                                                <th>Name</th>
                                                                                <th>Message</th>
                                                                                <th>Date</th>
                                                                            </tr>
                                                                        </thead>
                                                                    <tbody>';
                                                        }
                                                        ?>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                while ($row = mysqli_fetch_array($query_message)) {
                                                    echo '
                                                            <tr>
                                                                <td class="hidden-xs"><a href="inbox.php?id=' . $row["id"] . '" />' . $row["name"] . '</td>
                                                                <td class="max-texts"><a href="inbox.php?id=' . $row["id"] . '" />' . $row["msg"] . '</td>
                                                                <td>' . $row["date"] . '</td>
                                                            </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-7 m-t-20"> Showing 1 - <?php echo mysqli_num_rows($query_message); ?> </div>
                                        <div class="col-xs-5 m-t-20">
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-left"></i></button>
                                                <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <!-- .right-sidebar -->
                <?php include './components/sidebar.php'; ?>
            </div>
            <!-- /.container-fluid -->
            <?php include './components/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="../plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="bootstrap/dist/js/tether.min.js"></script>
    <script src="bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="js/custom.min.js"></script>
    <script src="../plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- end - This is for export functionality only -->

    <!--Style Switcher -->
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>