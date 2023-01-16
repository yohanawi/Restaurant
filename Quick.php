<?php
include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
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
                <h1>Food Details</h1>
                <p></p>
            </div>
        </div>
        <div class="quick-view">
            <?php
            $pid = $_GET['pid'];
            $select_products = $conn->prepare("SELECT * FROM `product` WHERE id = ?");
            $select_products->execute([$pid]);
            if ($select_products->rowCount() > 0) {
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="" method="post" class="box">
                        <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                        <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                        <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                        <input type="hidden" name="image" value="<?= $fetch_product['image']; ?>">
                        <div class="row">
                            <div class="image-container">
                                <div class="main-image">
                                    <img src="uploaded_img/<?= $fetch_product['image']; ?>" alt="">
                                </div>
                            </div>
                            <div class="content">
                                <div class="name"><?= $fetch_product['name']; ?></div>
                                <div class="flex">
                                    <div class="price"><span>Rs.</span><?= $fetch_product['price']; ?><span>/-</span></div>
                                    <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
                                </div>
                                <div class="details"><?= $fetch_product['description']; ?></div>
                                <div class="flex-btn">
                                    <input type="submit" value="add to cart" class="btn3" name="add_to_cart">

                                </div>
                            </div>
                        </div>
                    </form>
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