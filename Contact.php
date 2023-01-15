<?php
include './Components/connection.php';

/* DATABASE CONNECTION*/
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'restaurants';

global $connection;
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
    die("Cannot Establish A Secure Connection To The Host Server At The Moment!");
}
try {
    $db = new PDO('mysql:dbhost=localhost;dbname=restaurants;charset=utf8', 'root', '');
} catch (Exception $e) {

    die('Cannot Establish A Secure Connection To The Host Server At The Moment!');
}
/*DATABASE CONNECTION */

session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

if(isset($_POST['send']))
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $msg = $_POST['msg'];
        //-- Insert Data Into DB --//
        $sql = "INSERT INTO messages (name,email,subject,msg) 
        VALUES (?,?,?,?)";
        $stmt = $db->prepare($sql);
        try {
            $stmt->execute([$name,$email,$subject,$msg]);
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
                <h1>Contact Us</h1>
                <p>Lorem ipsum dolor sit amet, consectetur</p>
            </div>
        </div>
        <div class="row2">
            <form action="" method="POST">
                <h3>get in touch</h3>
                <div class="inputBox">
                    <input type="text" name="name" placeholder="Name" required maxlength="20" class="box">
                    <input type="email" name="email" placeholder="Email" required maxlength="50" class="box">
                </div>
                <div class="inputBox">
                    <input type="text" name="subject" placeholder="Subject" class="box" style="width: 100%;">
                </div>
                <div class="inputBox">
                    <textarea name="msg" placeholder="Message" cols="30" rows="10" class="box"></textarea>
                </div>
                <!--<input type="submit" value="send message" name="send" class="btn">-->
                <center>
                <input type="submit" value="send message" name="send" class="btn">
                </center>
            </form>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2283.146426885366!2d80.02078967705012!3d7.2247423166488804!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xbdb19775896da9ff!2zN8KwMTMnMjkuMSJOIDgwwrAwMScyMi43IkU!5e1!3m2!1sen!2sin!4v1657437780916!5m2!1sen!2sin" width="640" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>