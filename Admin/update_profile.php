<?php
require_once "components/connection.php"; //databse connection

require_once "functions/db.php";
session_start();
$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:admin_login.php');
}
if (isset($_POST['submit'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   if (!empty($name)) {
      $select_name = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
      $select_name->execute([$name]);
      if ($select_name->rowCount() > 0) {
         $message[] = 'username already taken!';
      } else {
         $update_name = $conn->prepare("UPDATE `admin` SET name = ? WHERE id = ?");
         $update_name->execute([$name, $admin_id]);
      }
   }
   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_old_pass = $conn->prepare("SELECT password FROM `admin` WHERE id = ?");
   $select_old_pass->execute([$admin_id]);
   $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
   $prev_pass = $fetch_prev_pass['password'];
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_pass = sha1($_POST['confirm_pass']);
   $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if ($old_pass != $empty_pass) {
      if ($old_pass != $prev_pass) {
         $message[] = 'old password not matched!';
      } elseif ($new_pass != $confirm_pass) {
         $message[] = 'confirm password not matched!';
      } else {
         if ($new_pass != $empty_pass) {
            $update_pass = $conn->prepare("UPDATE `admin` SET password = ? WHERE id = ?");
            $update_pass->execute([$confirm_pass, $admin_id]);
            $message[] = 'password updated successfully!';
         } else {
            $message[] = 'please enter a new password!';
         }
      }
   }
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
                     <li class="active">Update Account</li>
                  </ol>
               </div>
               <!-- /.col-lg-12 -->
            </div>
            <!-- /row -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="white-box">
                     <?php
                     if (isset($message)) {
                        foreach ($message as $message) {
                           echo '
                              <div class="message">
                                 <span>' . $message . '</span>
                                 <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
                              </div>
                              ';
                        }
                     }
                     ?>
                     <section class="form-container">
                        <form action="" method="POST">
                           <h3>update profile</h3>
                           <input type="text" name="name" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')" placeholder="<?= $fetch_profile['name']; ?>">
                           <input type="password" name="old_pass" maxlength="20" placeholder="enter your old password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                           <input type="password" name="new_pass" maxlength="20" placeholder="enter your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                           <input type="password" name="confirm_pass" maxlength="20" placeholder="confirm your new password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
                           <input type="submit" value="update now" name="submit" class="btn">
                        </form>
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