<?php

include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:index.php');
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      if ($address == '') {
         $message[] = 'please add your address!';
      } else {

         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'order placed successfully!';
      }
   } else {
      $message[] = 'your cart is empty';
   }
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
      <section class="checkout">

         <form action="" method="post">

            <div class="cart-items">
               <h3>cart items</h3>
               <?php
               $grand_total = 0;
               $cart_items[] = '';
               $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $select_cart->execute([$user_id]);
               if ($select_cart->rowCount() > 0) {
                  while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                     $total_products = implode($cart_items);
                     $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
               ?>
                     <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">$<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
               <?php
                  }
               } else {
                  echo '<p class="empty">your cart is empty!</p>';
               }
               ?>
               <p class="grand-total"><span class="name">grand total :</span><span class="price">$<?= $grand_total; ?></span></p>
               <a href="cart.php" class="btn">veiw cart</a>
            </div>

            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
            <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
            <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
            <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

            <div class="user-info">
               <h3>your info</h3>
               <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
               <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
               <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
               <a href="update_profile.php" class="btn">update info</a>
               <h3>delivery address</h3>
               <p><i class="fas fa-map-marker-alt"></i><span><?php if ($fetch_profile['address'] == '') {
                                                                  echo 'please enter your address';
                                                               } else {
                                                                  echo $fetch_profile['address'];
                                                               } ?></span></p>
               <a href="update_address.php" class="btn">update address</a>
               <select name="method" class="box" required>
                  <option value="" disabled selected>select payment method --</option>
                  <option value="cash on delivery">cash on delivery</option>
                  <option value="credit card">credit card</option>
                  <option value="paytm">paytm</option>
                  <option value="paypal">paypal</option>
               </select>
               <div class="flex">
                  <a href="Order.php" class="btn">View Order</a>
                  <input type="submit" value="place order" class="btn <?php if ($fetch_profile['address'] == '') {
                                                                           echo 'disabled';
                                                                        } ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
               </div>
            </div>

         </form>
      </section>
   </section>

   <?php include 'Components/Footer.php'; ?>
   <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
   <!-- custom js file link  -->
   <script src="/Js/js.js"></script>

</body>

</html>