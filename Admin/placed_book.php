<?php
require_once "components/connection.php"; //databse connection
require_once "functions/db.php";

$sql_book = "SELECT * FROM book";
$query_book = mysqli_query($connection, $sql_book);

if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $update_status = $conn->prepare("UPDATE `book` SET status = ? WHERE id = ?");
    $update_status->execute([$status, $order_id]);
    $message[] = 'status updated!';
}
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
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
                            <li class="active">Booking</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">Bookings ( <x style="color: orange;"><?php echo mysqli_num_rows($query_book); ?></x> )</h3>
                            <div class="box-container">
                                <?php
                                $select_book = $conn->prepare("SELECT * FROM `book`");
                                $select_book->execute();
                                if ($select_book->rowCount() > 0) {
                                    while ($fetch_book = $select_book->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <div class="box">
                                            <p> user id : <span><?= $fetch_book['user_id']; ?></span> </p>
                                            <p> placed on : <span><?= $fetch_book['date']; ?> | <?= $fetch_book['time']; ?></span> </p>
                                            <p> name : <span><?= $fetch_book['name']; ?></span> </p>
                                            <p> email : <span><?= $fetch_book['number']; ?></span> </p>
                                            <p> number : <span><?= $fetch_book['tables']; ?></span> </p>
                                            <p> address : <span><?= $fetch_book['seat']; ?></span> </p>
                                            <form action="" method="POST">
                                                <input type="hidden" name="order_id" value="<?= $fetch_book['id']; ?>">
                                                <select name="status" class="drop-down">
                                                    <option value="" selected disabled><?= $fetch_book['status']; ?></option>
                                                    <option value="pending">pending</option>
                                                    <option value="completed">completed</option>
                                                </select>
                                                <div class="flex-btn">
                                                    <input type="submit" value="update" class="btn" name="update_status">
                                                </div>
                                            </form>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo '<p class="empty">no orders placed yet!</p>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                            <?php
                            if (isset($_GET["success"])) {
                                echo
                                '<div class="alert alert-success" >
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                            <strong>DONE!! </strong><p> The new Administrator has been added. They can now log in to their account with their credentials.</p>
                                        </div>';
                            } elseif (isset($_GET["deleted"])) {
                                echo
                                '<div class="alert alert-warning" >
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                            <strong>DELETED!! </strong><p> The User has been successfully removed.</p>
                                        </div>';
                            } elseif (isset($_GET["del_error"])) {
                                echo
                                '<div class="alert alert-danger" >
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                            <strong>ERROR!! </strong><p> There was an error during deleting this record. Please try again.</p>
                                        </div>';
                            }
                            ?>
                            <h3 class="box-title m-b-0">Bookings ( <x style="color: orange;"><?php echo mysqli_num_rows($query_book); ?></x> )</h3>
                            <p class="text-muted m-b-30">Export data to Copy, CSV, Excel, PDF & Print</p>
                            <div class="table-responsive">
                                <table id="example23" class="display nowrap" cellspacing="0" width="100%">
                                    <?php
                                    if (mysqli_num_rows($query_book) == 0) {
                                        echo "<i style='color:brown;'>No Users Here :( </i> ";
                                    } else {
                                        echo '
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Mobile No.</th>
                                                            <th>Table No</th>
                                                            <th>Seat No</th>
                                                            <th>Date</th>
                                                            <th>Time</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                <tbody>';
                                    }
                                    while ($row = mysqli_fetch_array($query_book)) {
                                        // $id = $row["id"]
                                        echo '
                                                    <tr>
                                                        <td>' . $row["name"] . '</td>
                                                        <td>' . $row["number"] . '</td> 
                                                        <td>' . $row["tables"] . '</td> 
                                                        <td>' . $row["seat"] . '</td>   
                                                        <td>' . $row["date"] . '</td>   
                                                        <td>' . $row["time"] . '</td>     
                                                        <td>' . $row["status"] . '</td>                                           
                                                        <td><a href="#"><i class="fa fa-trash" data-toggle="modal" data-target="#responsive-modal' . $row["id"] . '" title="remove" style="color:red;"></i></a></td>
                                                        <!-- /.modal -->
                                                        <div id="responsive-modal' . $row["id"] . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                        <h4 class="modal-title">Are you sure you want to delete this booking?</h4>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="functions/delete-reservation.php" method="post">
                                                                            <input type="hidden" name="id" value="' . $row["id"] . '"/>
                                                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <!-- End Modal -->
                                                    </tr>
                                                ';
                                    }
                                    ?>
                                    </tbody>
                                </table>
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
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    </script>
    <!--Style Switcher -->
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>