<?php
require_once "components/connection.php"; //databse connection
session_start();
if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   if ($select_admin->rowCount() > 0) {
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:index.php');
   } else {
      $message[] = 'incorrect username or password!';
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
   <!-- toast CSS -->
   <link href="../plugins/bower_components/toast-master/css/jquery.toast.css" rel="stylesheet">
   <!-- morris CSS -->
   <link href="../plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
   <!-- animation CSS -->
   <link href="css/animate.css" rel="stylesheet">
   <!-- Custom CSS -->
   <link href="css/style.css" rel="stylesheet">
   <link href="css/admin-css.css" rel="stylesheet">
   <!-- color CSS -->
   <link href="css/colors/blue.css" id="theme" rel="stylesheet">
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>

<body>

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
         <h3>login now</h3>
         <p>default username = <span>admin</span> & password = <span>111</span></p>
         <input type="text" name="name" maxlength="20" required placeholder="enter your username" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="password" name="pass" maxlength="20" required placeholder="enter your password" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
         <input type="submit" value="login now" name="submit" class="btn">
      </form>
   </section>
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
   <!--Counter js -->
   <script src="../plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
   <script src="../plugins/bower_components/counterup/jquery.counterup.min.js"></script>
   <!--Morris JavaScript -->
   <script src="../plugins/bower_components/raphael/raphael-min.js"></script>
   <script src="../plugins/bower_components/morrisjs/morris.js"></script>
   <!-- Custom Theme JavaScript -->
   <script src="js/custom.min.js"></script>
   <script src="js/dashboard1.js"></script>
   <!-- Sparkline chart JavaScript -->
   <script src="../plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
   <script src="../plugins/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
   <script src="../plugins/bower_components/toast-master/js/jquery.toast.js"></script>

</body>
<!--Style Switcher -->
<script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>


</body>

</html>