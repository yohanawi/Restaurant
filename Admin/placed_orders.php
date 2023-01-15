<?php
require_once "components/connection.php"; //databse connection
require_once "functions/db.php";

$sql_order = "SELECT * FROM orders";
$query_order = mysqli_query($connection, $sql_order);

if (isset($_POST['update_payment'])) {

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
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
                     <li class="active">Orders</li>
                  </ol>
               </div>
               <!-- /.col-lg-12 -->
            </div>
            <!-- /row -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="white-box">
                     <h3 class="box-title m-b-0">Orders ( <x style="color: orange;"><?php echo mysqli_num_rows($query_order); ?></x> )</h3>
                     <div class="box-container">
                        <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        if ($select_orders->rowCount() > 0) {
                           while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                              <div class="box">
                                 <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
                                 <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
                                 <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
                                 <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
                                 <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
                                 <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
                                 <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
                                 <p> total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span> </p>
                                 <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
                                 <form action="" method="POST">
                                    <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
                                    <select name="payment_status" class="drop-down">
                                       <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
                                       <option value="pending">pending</option>
                                       <option value="completed">completed</option>
                                    </select>
                                    <div class="flex-btn">
                                       <input type="submit" value="update" class="btn1" name="update_payment">
                                       <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
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