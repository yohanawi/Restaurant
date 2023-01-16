<?php
include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
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
                <h1>Profile</h1>
                <p></p>
            </div>
        </div>
        <div class="user-details">
            <div class="user">
                <?php
                ?>
                <img src="images/user-icon.png" alt="">
                <p><i class="fas fa-user"></i><span><span><?= $fetch_profile['name']; ?></span></span></p>
                <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number']; ?></span></p>
                <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email']; ?></span></p>
                <a href="update_profile.php" class="btn">update info</a>
                <p class="address"><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                                                                                    echo 'please enter your address';
                                                                                } else {
                                                                                    echo $fetch_profile['address'];
                                                                                } ?></span></p>
                <a href="update_address.php" class="btn">update address</a>
            </div>
        </div>
    </section>

    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>