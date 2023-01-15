<?php
require_once "components/connection.php"; //databse connection

session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:admin_login.php');
}
if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   $delete_admin = $conn->prepare("DELETE FROM `admin` WHERE id = ?");
   $delete_admin->execute([$delete_id]);
   header('location:admin_accounts.php');
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
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
   <link href="css/admin-css.css" rel="stylesheet">
   <link href="css/style.css" rel="stylesheet">
   <!-- color CSS -->
   <link href="css/colors/blue.css" id="theme" rel="stylesheet">
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
                     <li class="active">Account</li>
                  </ol>
               </div>
               <!-- /.col-lg-12 -->
            </div>
            <!-- /row -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="white-box">
                     <h1 class="heading">Admins Account</h1>
                     <div class="box-container">
                        <div class="box">
                           <p>register new admin</p>
                           <a href="register_admin.php" class="option-btn">register</a>
                        </div>
                        <?php
                        $select_account = $conn->prepare("SELECT * FROM `admin`");
                        $select_account->execute();
                        if ($select_account->rowCount() > 0) {
                           while ($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                              <div class="box">
                                 <p> admin id : <span><?= $fetch_accounts['id']; ?></span> </p>
                                 <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
                                 <div class="flex-btn">
                                    <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn" onclick="return confirm('delete this account?');">delete</a>
                                    <?php
                                    if ($fetch_accounts['id'] == $admin_id) {
                                       echo '<a href="update_profile.php" class="option-btn">update</a>';
                                    }
                                    ?>
                                 </div>
                              </div>
                        <?php
                           }
                        } else {
                           echo '<p class="empty">no accounts available</p>';
                        }
                        ?>
                     </div>
                     </section>
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