<?php
require_once "components/connection.php"; //databse connection
require_once "functions/db.php";

$sql = 'SELECT * FROM category';
$query = mysqli_query($connection, $sql);

if (isset($_POST['add'])) {
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    $image = $_FILES['image']['name'];
    $image = filter_var($image, FILTER_SANITIZE_STRING);
    $image_size = $_FILES['image']['size'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = '../uploaded_img/' . $image;
    //-- Insert Data Into DB --//
    $select_category = $conn->prepare("SELECT * FROM `category` WHERE category = ?");
    $select_category->execute([$category]);

    if ($select_category->rowCount() > 0) {
        $message[] = 'product name already exist!';
        header('location: category.php');
    } else {
        move_uploaded_file($image_tmp_name, $image_folder);
        $insert_category = $conn->prepare("INSERT INTO `category`(category, image) VALUES(?,?)");
        $insert_category->execute([$category, $image]);

        $message[] = 'new Category added!';
        header('location: category.php');
    }
};
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
    <!-- Menu CSS -->
    <link href="../plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css" rel="stylesheet">
    <!-- morris CSS -->
    <link href="../plugins/bower_components/morrisjs/morris.css" rel="stylesheet">
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
                            <li><a href="index.php">Dashboard</a></li>
                            <li class="active">Category</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- row -->
                <div class="row">
                    <div class="col-md-6">
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
                            <h3 class="box-title m-b-0">Add Category</h3>
                            <p class="text-muted m-b-30 font-13"> (Food category) </p>
                            <div class="row">
                                <div class="col-sm-12 col-xs-6">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label>Category</label>
                                            <input type="text" name="category" class="form-control" required="">
                                        </div>
                                        <div class="form-group">
                                            <label>Category Image</label>
                                            <input type="file" name="image" class="form-control" accept="image/jpg, image/jpeg, image/png, image/webp" required>
                                        </div>
                                        <div class="form-group text-center m-t-20">
                                            <div class="col-xs-12">
                                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="add">Add</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Left sidebar -->
                    <div class="col-md-12">
                        <div class="white-box">
                            <!-- row -->
                            <div class="row">
                                <div class="col-lg-12 col-md-9 col-sm-12 col-xs-12 mail_listing">
                                    <div class="inbox-center">
                                        <?php
                                        if (isset($_GET["deleted"])) {
                                            echo
                                            '<div class="alert alert-warning" >
                                                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                                                    <strong>DELETED!! </strong><p> The category has been successfully deleted.</p>
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
                                                        <h4>Category(<b style="color: orange;"><?php echo mysqli_num_rows($query); ?></b>)</h4>
                                                        <?php
                                                        if (mysqli_num_rows($query) == 0) {
                                                            echo "<i style='color:brown;'>No role Yet :( </i> ";
                                                        } else {
                                                            echo '<thead>
                                                                            <tr>
                                                                                <th>Category</th>
                                                                                <th>Category image</th>
                                                                                <th>Action</th>
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
                                                while ($row = mysqli_fetch_array($query)) {
                                                    echo '
                                                            <tr>
                                                                <td class="hidden-xs">' . $row["category"] . '</td>
                                                                <td class="hidden-xs">' . $row["image"] . '</td>
                                                                <td><a href="#"><i class="fa fa-trash"  data-toggle="modal" data-target="#responsive-modal' . $row["id"] . '" title="remove" style="color:red;"></i></a></td>
                                                                <!-- /.modal -->
                                                                <div id="responsive-modal' . $row["id"] . '" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h4 class="modal-title">Are you sure you want to delete this category?</h4>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <form action="functions/delete.php" method="post">
                                                                                    <input type="hidden" name="id" value="' . $row["id"] . '"/>
                                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                                    <button type="submit" class="btn btn-danger waves-effect waves-light">Delete</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </tr>';
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-7 m-t-20"> Showing 1 - <?php echo mysqli_num_rows($query); ?> </div>
                                        <div class="col-xs-5 m-t-20">
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-left"></i></button>
                                                <button type="button" class="btn btn-default waves-effect"><i class="fa fa-chevron-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.row -->
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
    <!--Style Switcher -->
    <script src="../plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>

</html>