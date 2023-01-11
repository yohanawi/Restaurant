<?php
include './Components/connection.php';

if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $msg = $_POST['msg'];
    //-- Insert Data Into DB --//
    $sql = "INSERT INTO messages (name,email,subject,msg) 
        VALUES (?,?,?,?)";
    $stmt = $db->prepare($sql);
    try {
        $stmt->execute([$name, $email, $subject, $msg]);
        header('Location:../Contact.php?success');
    } catch (Exception $e) {
        $e->getMessage();
        echo "Error";
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
            <div class="right-box">
                <h2> Sign In To Restaurant</h2>
                <div class="log">
                    <p><i class="fa-duotone fa-circle-check"></i>Lorem ipsum dolor sit amet, consectetur </p>
                    <p><i class="fa-duotone fa-circle-check"></i>Lorem ipsum dolor sit amet, consectetur</p>
                    <p><i class="fa-duotone fa-circle-check"></i>Lorem ipsum dolor sit amet, consectetur</p>
                </div>
                <div class="link">Don’t Have a Account |<a href="Register.php"> Register ?</a></div>
            </div>
            <div class="vl"></div>
            <div class="left-box">
                <form action="" method="POST">
                    <div class="inputBox">
                        <input type="email" name="email" placeholder="Email" required class="box">
                    </div>
                    <div class="inputBox">
                        <input type="password" name="password" placeholder="password" required class="box">
                    </div>
                    <center>
                        <input type="submit" value="Sign in" name="send" class="btn" style="background-color: #EA6D27;">
                    </center>
                </form>
            </div>
        </div>
    </section>

    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>