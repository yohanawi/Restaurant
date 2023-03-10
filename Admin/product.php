<?php
require_once "components/connection.php"; //databse connection

require_once "functions/db.php";

$sql_product = "SELECT * FROM product";
$query_product = mysqli_query($connection, $sql_product);
$sql_category = 'SELECT * FROM category';
$query_category = mysqli_query($connection, $sql_category);

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = $_POST['price'];
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $description = $_POST['description'];
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $select_product = $conn->prepare("SELECT * FROM `product` WHERE name = ?");
    $select_product->execute([$name]);

    if ($select_product->rowCount() > 0) {
        $message[] = 'product name already exist!';
        header('location: product.php');
    } else {
        move_uploaded_file($image_tmp_name, $image_folder);
        $insert_product = $conn->prepare("INSERT INTO `product`(name, price, description, category, image) VALUES(?,?,?,?,?)");
        $insert_product->execute([$name, $price, $description, $category, $image]);
        $message[] = 'new product added!';
        header('location: product.php');
    }
};

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_product_image = $conn->prepare("SELECT * FROM `product` WHERE id = ?");
    $delete_product_image->execute([$delete_id]);
    $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
    /*unlink('../uploaded_img/' . $fetch_delete_image['image']);*/
    $delete_product = $conn->prepare("DELETE FROM `product` WHERE id = ?");
    $delete_product->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:product.php');
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
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
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
                            <li class="active">Products</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /row -->
                <div class="row">
                    <div class="col-sm-6">
                        <div class="white-box">
                            <div class="row">
                                <div class="col-sm-12 col-xs-6">
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <h3>Add Product</h3>
                                        <div class="form-group">
                                            <label>Product Name</label>
                                            <input type="text" name="name" class="form-control" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Product Price</label>
                                            <input type="number" name="price" class="form-control" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Product Description</label>
                                            <textarea type="text" name="description" class="form-control" required=""></textarea>
                                        </div>
                                        <?php
                                        $options = "";
                                        while ($row2 = mysqli_fetch_array($query_category)) {
                                            $options = $options . "<option>$row2[1]</option>";
                                        }
                                        ?>
                                        <div class="form-group">
                                            <select name="category" class="form-control" required>
                                                <option value="" disabled selected>select category --</option>
                                                <?php echo $options; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                                        </div>
                                        <div class="flex">
                                            <input type="submit" value="add product" class="btn1" name="add_product">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <section class="show-products">
                                <h3 class="heading">products added(<b style="color: orange;"><?php echo mysqli_num_rows($query_product); ?></b>)</h3>
                                <div class="box-container">
                                    <?php
                                    $select_product = $conn->prepare("SELECT * FROM `product`");
                                    $select_product->execute();
                                    if ($select_product->rowCount() > 0) {
                                        while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                            <div class="box">
                                                <img src="../uploaded_img/<?= $fetch_product['image']; ?>" alt="">
                                                <div class="name"><?= $fetch_product['name']; ?></div>
                                                <div class="price">Rs.<span><?= $fetch_product['price']; ?></span>/-</div>
                                                <div class="category"><?= $fetch_product['category']; ?></div>
                                                <div class="description"><span><?= $fetch_product['description']; ?></span></div>
                                                <div class="flex-btn">
                                                    <a href="update_product.php?update=<?= $fetch_product['id']; ?>" class="option-btn">update</a>
                                                    <a href="product.php?delete=<?= $fetch_product['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<p class="empty">no products added yet!</p>';
                                    }
                                    ?>
                                </div>
                            </section>
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