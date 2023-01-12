<?php
include './Components/connection.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:index.php');
};
if(isset($_POST['delete'])){
    $user_id = $_POST['user_id'];
    $delete_item = $conn->prepare("DELETE FROM `book` WHERE id = ?");
    $delete_item->execute([$user_id]);
    $message[] = 'book item deleted!';
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
                <h1>View Booking</h1>
                <p></p>
            </div>
        </div>
        <div class="booking">
            <div class="box-container">
                <?php
                if ($user_id == '') {
                    echo '<p class="empty">please login to see your Booking</p>';
                } else {
                    $select_books = $conn->prepare("SELECT * FROM `book` WHERE user_id = ?");
                    $select_books->execute([$user_id]);
                    if ($select_books->rowCount() > 0) {
                        while ($fetch_books = $select_books->fetch(PDO::FETCH_ASSOC)) {
                ?>
                            <div class="box">
                                <p>placed on : <span><?= $fetch_books['date']; ?> / <?= $fetch_books['time']; ?></span></p>
                                <p>name : <span><?= $fetch_books['name']; ?></span></p>
                                <p>number : <span><?= $fetch_books['number']; ?></span></p>
                                <p>Number of table : <span><?= $fetch_books['tables']; ?></span></p>
                                <p>No. Seats : <span><?= $fetch_books['seat']; ?></span></p>
                                <p>status : <span style="color:<?php if ($fetch_books['status'] == 'pending') {
                                                                    echo 'red';
                                                                } else {
                                                                    echo 'green';
                                                                }; ?>"><?= $fetch_books['status']; ?></span> </p>
                            </div>
                <?php
                        }
                    } else {
                        echo '<p class="empty">no Booking placed yet!</p>';
                    }
                }
                ?>
            </div>
            <br />
            <a href="Reservation.php"><button class="back-btn">
                    <svg height="16" width="16" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1024 1024">
                        <path d="M874.690416 495.52477c0 11.2973-9.168824 20.466124-20.466124 20.466124l-604.773963 0 188.083679 188.083679c7.992021 7.992021 7.992021 20.947078 0 28.939099-4.001127 3.990894-9.240455 5.996574-14.46955 5.996574-5.239328 0-10.478655-1.995447-14.479783-5.996574l-223.00912-223.00912c-3.837398-3.837398-5.996574-9.046027-5.996574-14.46955 0-5.433756 2.159176-10.632151 5.996574-14.46955l223.019353-223.029586c7.992021-7.992021 20.957311-7.992021 28.949332 0 7.992021 8.002254 7.992021 20.957311 0 28.949332l-188.073446 188.073446 604.753497 0C865.521592 475.058646 874.690416 484.217237 874.690416 495.52477z"></path>
                    </svg>
                    <span>Back</span>
                </button></a>

            <form action="" method="post">
                <input type="hidden" name="user_id" value="<?= $fetch_book['id']; ?>">
                <button class="noselect" name="delete" onclick="return confirm('delete this item?');"><span class="text">Delete</span>
                    <span class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"></path>
                        </svg>
                    </span>
                </button>
            </form>
        </div>
    </section>
    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>