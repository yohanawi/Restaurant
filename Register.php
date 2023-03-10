<?php
include './Components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $password = sha1($_POST['password']);
    $password = filter_var($password, FILTER_SANITIZE_STRING);
    $c_password = sha1($_POST['c-password']);
    $c_password = filter_var($c_password, FILTER_SANITIZE_STRING);
    $select_user = $conn->prepare("SELECT * FROM `user` WHERE email = ? OR number = ?");
    $select_user->execute([$email, $number]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);
    if ($select_user->rowCount() > 0) {
        $message[] = 'email or number already exists!';
    } else {
        if ($password != $c_password) {
            $message[] = 'confirm password not matched!';
        } else {
            $insert_user = $conn->prepare("INSERT INTO `user`(name, email, number, password) VALUES(?,?,?,?)");
            $insert_user->execute([$name, $email, $number, $c_password]);
            $select_user = $conn->prepare("SELECT * FROM `user` WHERE email = ? AND password = ?");
            $select_user->execute([$email, $password]);
            $row = $select_user->fetch(PDO::FETCH_ASSOC);
            if ($select_user->rowCount() > 0) {
                $_SESSION['user_id'] = $row['id'];
                header('location:index.php');
            }
        }
    }
}
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
                <h1>Sign In</h1>
                <p></p>
            </div>
        </div>
        <div class="card">
            <div class="left-box-R">
                <form action="" method="POST">
                    <div class="inputBox">
                        <input type="text" name="name" placeholder="Name" required class="box">
                    </div>
                    <div class="inputBox">
                        <input type="email" name="email" placeholder="Email" required class="box">
                    </div>
                    <div class="inputBox">
                        <input type="text" name="number" placeholder="Number" required class="box">
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" placeholder="Password" required class="box">
                    </div>
                    <div class="inputBox">
                        <input type="password" name="c-password" placeholder="Confirm password" required class="box">
                    </div>
                    <center>
                        <input type="submit" value="Sign Up" name="send" class="btn" style="background-color: #EA6D27;">
                    </center>
                </form>
            </div>
            <div class="vl"></div>
            <div class="right-box-R">
                <h2> Sign Up To Restaurant</h2>
                <div class="log">
                    <p><i class="fa-duotone fa-circle-check"></i>Lorem ipsum dolor sit amet, consectetur </p>
                    <p><i class="fa-duotone fa-circle-check"></i>Lorem ipsum dolor sit amet, consectetur</p>
                    <p><i class="fa-duotone fa-circle-check"></i>Lorem ipsum dolor sit amet, consectetur</p>
                </div>
                <div class="link-R">Do you Have a Account |<a href="Login.php"> Sign in ?</a></div>
            </div>
        </div>
    </section>

    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>