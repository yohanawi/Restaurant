<?php
include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
};

if(isset($_POST['book'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $tables = $_POST['tables'];
    $tables = filter_var($tables, FILTER_SANITIZE_STRING);
    $seat = $_POST['seat'];
    $seat = filter_var($seat, FILTER_SANITIZE_STRING);
    $time = $_POST['time'];
    $time = filter_var($time, FILTER_SANITIZE_STRING);
    $date = $_POST['date'];
    $date = filter_var($date, FILTER_SANITIZE_STRING);

    $select_book = $conn->prepare("SELECT * FROM `book` WHERE user_id = ?");
    $select_book->execute([$user_id]);
 
    if($select_book->rowCount() > 0){
       $book[] = 'already sent book!';
    }else{
 
       $insert_book = $conn->prepare("INSERT INTO `book`(user_id,name, number, tables, seat, time, date) VALUES(?,?,?,?,?,?,?)");
       $insert_book->execute([$user_id, $name, $number, $tables, $seat, $time, $date]);
 
       $book[] = 'sent book successfully!';
 
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
                <h1>Reserve your Seats</h1>
                <p></p>
            </div>
        </div>
        <div class="row3">
            <form action="" method="POST">
                <h3>get in touch</h3>
                <div class="inputBox">
                    <input type="name" name="name" placeholder="Name" class="box" style="width: 100%;">
                </div>
                <div class="inputBox">
                    <input type="text" name="number" placeholder="Mobile No." class="box" style="width: 100%;">
                </div>
                <div class="inputBox" style="width: 95%;">
                    <select name="tables" class="box" required style="width: 48%;">
                        <option value="" disabled selected>select Table --</option>
                        <option value="2">2</option>
                    </select>
                    <select name="seat" class="box" required style="width: 48%;">
                        <option value="" disabled selected>select Setas --</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="inputBox">
                    <input type="time" name="time" placeholder="Time" class="box" style="width: 100%;">
                </div>
                <div class="inputBox">
                    <input type="date" name="date" placeholder="Date" class="box" style="width: 100%;">
                </div>
                <!--<input type="submit" value="send message" name="send" class="btn">-->
                <center>
                    <input type="submit" value="Book Now" name="book" class="btn">
                </center>
                <a href="view-reservation.php">View Booking</a>
            </form>
           <div class="video">
                <video autoplay muted loop id="myVideo">
                    <source src="/video/tables.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </section>
    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>