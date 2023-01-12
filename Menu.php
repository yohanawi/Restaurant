<?php
include './Components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
include './Components/add_cart.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="./Asset/icon.png">
    <title>Restaurant</title>
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- custom css file link  -->
    <link rel="stylesheet" href="Css/style.css">
</head>

<body>
    <?php include 'Components/Header.php'; ?>
    <section class="page">
        <div class="row">
            <div class="page-heading">
                <h1>Menu</h1>
                <p>All our best meals in one delicious snap</p>
            </div>
        </div>
        <div class="box-container">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `product`");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="pro-card">
                        <div class="pro-card-img"><img src="uploaded_img/<?= $fetch_products['image']; ?>"></div>
                        <div class="pro-card-info">
                            <p class="pro-text-title"><?= $fetch_products['name']; ?></p>
                            <p class="pro-text-body"><?= $fetch_products['description']; ?></p>
                        </div>
                        <div class="pro-card-footer">
                            <span class="pro-text-title"><?= $fetch_products['price']; ?></span>
                            <div class="pro-card-button">
                                <button type="submit" name="add_to_cart" class="cart-btn"><i class="fas fa-shopping-cart"></i></button>
                            </div>
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
    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>