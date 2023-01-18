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
                <h1>Make your Order</h1>
                <p></p>
            </div>
        </div>
        <div class="orders">
            <div class="box-container">
                <?php
                if ($user_id == '') {
                    echo '<p class="empty">please login to see your orders</p>';
                } else {
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
                    $select_orders->execute([$user_id]);
                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>
                            <div class="box">
                                <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                                <p>name : <span><?= $fetch_orders['name']; ?></span></p>
                                <p>email : <span><?= $fetch_orders['email']; ?></span></p>
                                <p>number : <span><?= $fetch_orders['number']; ?></span></p>
                                <p>address : <span><?= $fetch_orders['address']; ?></span></p>
                                <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
                                <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                                <p>total price : <span>Rs. <?= $fetch_orders['total_price']; ?>/-</span></p>
                                <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                            echo 'red';
                                                                        } else {
                                                                            echo 'green';
                                                                        }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
                            </div>
                <?php
                        }
                    } else {
                        echo '<p class="empty">no orders placed yet!</p>';
                    }
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