<?php
include './Components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};
include './Components/add_cart.php';
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
    <!--font animation cdn link-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- custom css file link  -->
    <link rel="stylesheet" href="Css/style.css">

</head>

<body>
    <?php include 'Components/Header.php'; ?>
    <div class="container">
        <section class="hero">
            <div class="swiper hero-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide slide">
                        <div class="image">
                            <img src="images/Group 4.png" alt="">
                        </div>
                        <div class="content">
                            <h3 class="animate__animated animate__fadeInLeft">Welcome to Our Restaurant</h3>
                            <span class="animate__animated animate__fadeInLeft">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                            <br /><br />
                            <a href="/Menu.php" class="btn-menu">Menu</a>
                            <a href="/Reservation.php" class="btn-book">Book a table</a>

                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </section>
        <section class="banner-container">
            <div class="banner">
                <img src="images/image-11.png" class="hat">
                <img src="images/image-removebg-preview-8-1-gzD.png" alt="">
                <div class="content">
                    <span>special offer</span>
                    <h3>upto 50% off</h3><br />
                    <a href="/Menu.php" class="btn-banner">shop now</a>
                </div>
            </div>
        </section>
        <section>
            <div class="category-content">
                <h1>Top List is Back</h1>
                <p>All our best meals in one delicious snap</p>
                <br />
                <div class="swiper category-slider">
                    <div class="swiper-wrapper">
                        <?php
                        $select_category = $conn->prepare("SELECT * FROM `category` LIMIT 6");
                        $select_category->execute();
                        if ($select_category->rowCount() > 0) {
                            while ($fetch_category = $select_category->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <a href="Products.php?category=<?= $fetch_category['category']; ?>" class="swiper-slide slide">
                                    <img src="images/image-removebg-preview-8-1-gzD.png" alt="">
                                    <h3><?= $fetch_category['category']; ?></h3>
                                </a>
                        <?php
                            }
                        } else {
                            echo '<p class="empty">no Category added yet!</p>';
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <center>
                    <a href="/Category.php" class="btn">View all</a>
                </center>
            </div>
        </section>
        <section>
            <div class="about-content">
                <div class="image-about">
                    <img src="/Asset/Group 4.png" alt="about" class="first">
                    <img src="/Asset/Group 4.png" alt="about" class="second">
                </div>
                <div class="topic-about">
                    <h2>About</h2>
                </div>
                <div class="logo-about">
                    <img src="/Images/Beige & Brown Illustration Restaurant Logo no bg.png">
                </div>
                <div class="content-about">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <a href="/About.php">Read more</a>
                </div>
            </div>
        </section>
        <section>
            <div class="product-content">
                <h1>Our Special Dishes</h1>
                <p>Lorem ipsum dolor sit amet, consectetur</p>
                <br />
                <div class="swiper product-slider">
                    <div class="swiper-wrapper">
                        <?php
                        $select_products = $conn->prepare("SELECT * FROM `product` LIMIT 6");
                        $select_products->execute();
                        if ($select_products->rowCount() > 0) {
                            while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                                <a href="Quick.php?pid=<?= $fetch_products['id']; ?>" class="swiper-slide slide">

                                    <div class="product-card">
                                        <img src="uploaded_img/<?= $fetch_products['image']; ?>">
                                        <div class="product-card-price">
                                            <p><?= $fetch_products['price']; ?></p>
                                        </div>
                                        <div class="product-cover">
                                            <h1><?= $fetch_products['name']; ?></h1>
                                            <p><?= $fetch_products['description']; ?></p>
                                        </div>
                                    </div>

                                </a>
                        <?php
                            }
                        } else {
                            echo '<p class="empty">no products added yet!</p>';
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <center>
                    <a href="/Category.php" class="btn">View all</a>
                </center>
            </div>
        </section>
        <section class="deal">
            <div class="image">
                <img src="images/mask-group-Vjo.png" alt="">
            </div>
            <div class="content">
                <span>new season trending!</span>
                <h3>best summer season</h3>
                <p>sale get up to 50% off</p>
                <a href="./Reservation.php" class="btn">Book Now</a>
            </div>
        </section>
        <section class="newsletter">
            <div class="content">
                <h1 class="heading">subscirbe now</h1>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam ipsam repellat nostrum esse officiis unde quisquam corporis doloremque adipisci similique!</p>
                <form action="./Components/New.php" method="POST">
                    <input type="email" name="subscribe" placeholder="enter your email" id="" class="email">
                    <input type="submit" value="subscirbe" class="btn" name="sub">
                </form>
            </div>
        </section>
    </div>
    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
    <script>
        var swiper = new Swiper(".hero-slider", {
            loop: true,
            grabCursor: true,
            effect: "flip",
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
        var swiper = new Swiper(".category-slider", {
            loop: true,
            spaceBetween: 20,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                650: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
            },
        });
        var swiper = new Swiper(".product-slider", {
            loop: true,
            spaceBetween: 1,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 2,
                },
                650: {
                    slidesPerView: 3,
                },
                768: {
                    slidesPerView: 4,
                },
                1024: {
                    slidesPerView: 5,
                },
            },
        });
    </script>
</body>

</html>