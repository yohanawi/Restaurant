<?php
include './Components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
include 'Components/add_cart.php';
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
        <div class="products">
            <div class="box-container">
                <?php
                $select_products = $conn->prepare("SELECT * FROM `product`");
                $select_products->execute();
                if ($select_products->rowCount() > 0) {
                    while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                            <a href="Quick.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                            <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                            <img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="">
                            <a href="category.php?category=<?= $fetch_products['category']; ?>" class="cat"><?= $fetch_products['category']; ?></a>
                            <div class="name"><?= $fetch_products['name']; ?></div>
                            <div class="flex">
                                <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                                <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                            </div>
                        </form>
                <?php
                    }
                } else {
                    echo '<p class="empty">no products added yet!</p>';
                }
                ?>

            </div>
        </div>
    </section>
    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>