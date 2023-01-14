<?php
include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
};

if (isset($_POST['delete'])) {
    $cart_id = $_POST['cart_id'];
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
    $delete_cart_item->execute([$cart_id]);
    $message[] = 'cart item deleted!';
}

if (isset($_POST['delete_all'])) {
    $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
    $delete_cart_item->execute([$user_id]);
    // header('location:cart.php');
    $message[] = 'deleted all from cart!';
}

if (isset($_POST['update_qty'])) {
    $cart_id = $_POST['cart_id'];
    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);
    $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
    $update_qty->execute([$qty, $cart_id]);
    $message[] = 'cart quantity updated';
}

$grand_total = 0;
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
                <h1>Restaurant Cart</h1>
                <p></p>
            </div>
        </div>
        <section class="products">
            <div class="box-container">
                <?php
                $grand_total = 0;
                $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
                $select_cart->execute([$user_id]);
                if ($select_cart->rowCount() > 0) {
                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                ?>
                        <form action="" method="post" class="box">
                            <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                            <a href="Quick.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
                            <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('delete this item?');"></button>
                            <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
                            <div class="name"><?= $fetch_cart['name']; ?></div>
                            <div class="flex">
                                <div class="price"><span>$</span><?= $fetch_cart['price']; ?></div>
                                <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
                                <button type="submit" class="fas fa-edit" name="update_qty"></button>
                            </div>
                            <div class="sub-total"> sub total : <span>$<?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
                        </form>
                <?php
                        $grand_total += $sub_total;
                    }
                } else {
                    echo '<center><p class="empty">your cart is empty</p></center>';
                }
                ?>

            </div>

            <div class="cart-total">
                <p>cart total : <span>$<?= $grand_total; ?></span></p>
                <a href="checkout.php" class="btn4 <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout</a>
            </div>

            <div class="more-btn">
                <form action="" method="post">
                    <button type="submit" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" name="delete_all" onclick="return confirm('delete all from cart?');">delete all</button>
                </form>
                <a href="Menu.php" class="btn4">continue shopping</a>
            </div>
        </section>
    </section>

    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>