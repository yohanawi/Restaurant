<?php
require_once "components/connection.php"; //databse connection
require_once "functions/db.php";
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:admin_login.php');
}

if (isset($_POST['update'])) {

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `product` SET name = ?, category = ?, price = ? WHERE id = ?");
   $update_product->execute([$name, $category, $price, $pid]);

   $message[] = 'product updated!';

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/' . $image;

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'images size is too large!';
      } else {
         $update_image = $conn->prepare("UPDATE `product` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/' . $old_image);
         $message[] = 'image updated!';
      }
   }
}
$sql_category = 'SELECT * FROM category';
$query_category = mysqli_query($connection, $sql_category);
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
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
                     <section class="update-product">
                        <h1 class="heading">Update Product</h1>
                        <?php
                        $update_id = $_GET['update'];
                        $show_products = $conn->prepare("SELECT * FROM `product` WHERE id = ?");
                        $show_products->execute([$update_id]);
                        if ($show_products->rowCount() > 0) {
                           while ($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                              <form action="" method="POST" enctype="multipart/form-data">
                                 <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                                 <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
                                 <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                                 <span>Update name</span>
                                 <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
                                 <span>Update price</span>
                                 <input type="number" min="0" max="9999999999" required placeholder="enter product price" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
                                 <span>Update description</span>
                                 <input type="text" required placeholder="enter product description" name="description" maxlength="1000" class="box" value="<?= $fetch_products['description']; ?>">
                                 <span>Update category</span>
                                 <?php
                                 $options = "";
                                 while ($row2 = mysqli_fetch_array($query_category)) {
                                    $options = $options . "<option>$row2[1]</option>";
                                 }
                                 ?>
                                 <div class="inputGroup">
                                    <select name="category" class="box" required value="<?= $fetch_products['category']; ?>">
                                       <?php echo $options; ?>
                                    </select>
                                 </div>
                                 <span>Update image</span>
                                 <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
                                 <div class="flex-btn">
                                    <input type="submit" value="update" class="btn" name="update">
                                    <a href="./product.php" class="option-btn">go back</a>
                                 </div>
                              </form>
                        <?php
                           }
                        } else {
                           echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>
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