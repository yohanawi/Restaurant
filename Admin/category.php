<?php
require_once "components/connection.php"; //databse connection

require_once "functions/db.php";

$sql_category = 'SELECT * FROM category';
$query_category = mysqli_query($connection, $sql_category);

if (isset($_POST['add_category'])) {

    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    $select_category = $conn->prepare("SELECT * FROM `category` WHERE category = ?");
    $select_category->execute([$category]);

    if ($select_category->rowCount() > 0) {
        $message[] = 'category name already exist!';
        header('location: category.php');
    } else {
        move_uploaded_file($image_tmp_name, $image_folder);
        $insert_category = $conn->prepare("INSERT INTO `category`(category, image) VALUES(?,?)");
        $insert_category->execute([$category, $image]);
        $message[] = 'new category added!';
        header('location: category.php');
    }
};

if (isset($_GET['delete'])) {

    $delete_id = $_GET['delete'];
    $delete_category_image = $conn->prepare("SELECT * FROM `category` WHERE id = ?");
    $delete_category_image->execute([$delete_id]);
    $fetch_delete_image = $delete_category_image->fetch(PDO::FETCH_ASSOC);
    /*unlink('../uploaded_img/' . $fetch_delete_image['image']);*/
    $delete_category = $conn->prepare("DELETE FROM `category` WHERE id = ?");
    $delete_category->execute([$delete_id]);
    $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
    $delete_cart->execute([$delete_id]);
    header('location:category.php');
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
                            <li class="active">Category</li>
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
                                        <h3>Add Category</h3>
                                        <div class="form-group">
                                            <label>category Name</label>
                                            <input type="text" name="category" class="form-control" required="">
                                        </div>
                                        <div class="form-group">
                                            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                                        </div>
                                        <div class="flex">
                                            <input type="submit" value="add category" class="btn1" name="add_category">
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
                                <h3 class="heading">category added(<b style="color: orange;"><?php echo mysqli_num_rows($query_category); ?></b>)</h3>
                                <div class="box-container">
                                    <?php
                                    $select_category = $conn->prepare("SELECT * FROM `category`");
                                    $select_category->execute();
                                    if ($select_category->rowCount() > 0) {
                                        while ($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                            <div class="box-category">
                                                <img src="../uploaded_img/<?= $fetch_category['image']; ?>" alt="">
                                                <center>
                                                    <div class="category"><?= $fetch_category['category']; ?></div>
                                                </center>
                                                <div class="flex-btn">
                                                    <a href="category.php?delete=<?= $fetch_category['id']; ?>" class="delete-btn" onclick="return confirm('delete this category?');">delete</a>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<p class="empty">no category added yet!</p>';
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