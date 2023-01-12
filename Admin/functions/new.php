<?php
/* DATABASE CONNECTION*/
$db_name = 'mysql:host=localhost;dbname=restaurants';
$user_name = 'root';
$user_password = '';

$conn = new PDO($db_name, $user_name, $user_password);
/*DATABASE CONNECTION */
if (isset($_POST['add'])) {
    $category = $_POST['category'];
    $category = filter_var($category, FILTER_SANITIZE_STRING);
    //-- Insert Data Into DB --//
    $select_category = $conn->prepare("SELECT * FROM `category` WHERE category = ?");
    $select_category->execute([$category]);

    if ($select_category->rowCount() > 0) {
        $message[] = 'product name already exist!';
        header('location: ../category.php');
    } else {
        $insert_category = $conn->prepare("INSERT INTO `category`(category) VALUES(?)");
        $insert_category->execute([$category]);
        if ($insert_category) {
            $message[] = 'new product added!';
            header('location: ../category.php');
        }
    }
};

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
        header('location: ../product.php');
    } else {
        $insert_product = $conn->prepare("INSERT INTO `product`(name, price, description, category, image ) VALUES(?,?,?,?,?)");
        $insert_product->execute([$name, $price, $description, $category, $image]);
        if ($insert_product) {
            if ($image_size > 2000000) {
                $message[] = 'image size is too large!';
            } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'new product added!';
                header('location: ../product.php');
            }
        }
    }
};
?>