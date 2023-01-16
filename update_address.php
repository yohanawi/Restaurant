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

    $address = $_POST['flat'] . ', ' . $_POST['building'] . ', ' . $_POST['area'] . ', ' . $_POST['town'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);

    $update_address = $conn->prepare("UPDATE `user` set address = ? WHERE id = ?");
    $update_address->execute([$address, $user_id]);

    $message[] = 'address saved!';
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
                <h1>Address</h1>
                <p></p>
            </div>
        </div>
        <div class="form-container">
            <form action="" method="post">
                <h3>your address</h3>
                <input type="text" class="box" placeholder="flat no." required maxlength="50" name="flat">
                <input type="text" class="box" placeholder="building no." required maxlength="50" name="building">
                <input type="text" class="box" placeholder="area name" required maxlength="50" name="area">
                <input type="text" class="box" placeholder="town name" required maxlength="50" name="town">
                <input type="text" class="box" placeholder="city name" required maxlength="50" name="city">
                <input type="text" class="box" placeholder="state name" required maxlength="50" name="state">
                <input type="text" class="box" placeholder="country name" required maxlength="50" name="country">
                <input type="number" class="box" placeholder="pin code" required max="999999" min="0" maxlength="6" name="pin_code">
                <input type="submit" value="save address" name="submit" class="btn">
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