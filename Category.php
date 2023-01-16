<?php
include './Components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

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
                <h1>Top Category</h1>
                <p>All our best meals in one delicious snap</p>
            </div>
        </div>
        <br />
        <div class="category-content">
            <div class="box-container">
                <?php
                $select_category = $conn->prepare("SELECT * FROM `category` LIMIT 6");
                $select_category->execute();
                if ($select_category->rowCount() > 0) {
                    while ($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <a href="Products.php?category=<?= $fetch_category['category']; ?>" class="swiper-slide slide">
                            <img src="images/image-removebg-preview-8-1-gzD.png" alt="">
                            <h3><?= $fetch_category['category']; ?></h3>
                        </a>
                <?php
                    }
                } else {
                    echo '<p class="empty">no Category added yet!</p>';
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