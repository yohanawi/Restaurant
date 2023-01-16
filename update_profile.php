<?php

include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:home.php');
};

if (isset($_POST['submit'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);

   if (!empty($name)) {
      $update_name = $conn->prepare("UPDATE `user` SET name = ? WHERE id = ?");
      $update_name->execute([$name, $user_id]);
   }

   if (!empty($email)) {
      $select_email = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
      $select_email->execute([$email]);
      if ($select_email->rowCount() > 0) {
         $message[] = 'email already taken!';
      } else {
         $update_email = $conn->prepare("UPDATE `user` SET email = ? WHERE id = ?");
         $update_email->execute([$email, $user_id]);
      }
   }

   if (!empty($number)) {
      $select_number = $conn->prepare("SELECT * FROM `user` WHERE number = ?");
      $select_number->execute([$number]);
      if ($select_number->rowCount() > 0) {
         $message[] = 'number already taken!';
      } else {
         $update_number = $conn->prepare("UPDATE `user` SET number = ? WHERE id = ?");
         $update_number->execute([$number, $user_id]);
      }
   }

   $empty_password = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $select_prev_password = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
   $select_prev_pass->execute([$user_id]);
   $fetch_prev_password = $select_prev_password->fetch(PDO::FETCH_ASSOC);
   $prev_password = $fetch_prev_password['password'];
   $old_password = sha1($_POST['old_password']);
   $old_password = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_password = sha1($_POST['new_password']);
   $new_password = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $confirm_password = sha1($_POST['confirm_password']);
   $confirm_password = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

   if ($old_password != $empty_password) {
      if ($old_password != $prev_password) {
         $message[] = 'old password not matched!';
      } elseif ($new_password != $confirm_password) {
         $message[] = 'confirm password not matched!';
      } else {
         if ($new_password != $empty_password) {
            $update_password = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
            $update_password->execute([$confirm_password, $user_id]);
            $message[] = 'password updated successfully!';
         } else {
            $message[] = 'please enter a new password!';
         }
      }
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
            <h1>Ppdate Profile</h1>
            <p></p>
         </div>
      </div>
      <div class="form-container update-form">
         <form action="" method="post">
            <h3>update profile</h3>
            <input type="text" name="name" placeholder="<?= $fetch_profile['name']; ?>" class="box" maxlength="50">
            <input type="email" name="email" placeholder="<?= $fetch_profile['email']; ?>" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="number" name="number" placeholder="<?= $fetch_profile['number']; ?>"" class=" box" min="0" max="9999999999" maxlength="10">
            <input type="password" name="old_password" placeholder="enter your old password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="new_password" placeholder="enter your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="password" name="confirm_password" placeholder="confirm your new password" class="box" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
            <input type="submit" value="update now" name="submit" class="btn">
            <a href="Profile.php" class="btn">Go Back</a>
         </form>
      </div>
   </section>
   <?php include 'Components/Footer.php'; ?>
   <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
   <!-- custom js file link  -->
   <script src="/Js/js.js"></script>

</body>

</html>