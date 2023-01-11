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
    <div class="container">
        <section class="hero">
            <div class="swiper hero-slider">
                <div class="swiper-wrapper">
                    <div class="swiper-slide slide">
                        <div class="image">
                            <img src="images/Group 4.png" alt="">
                        </div>
                        <div class="content">
                            <h3>Welcome to Our Restaurant</h3>
                            <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</span>
                            <br /><br />
                            <a href="/Menu.php" class="btn-menu">Menu</a>
                            <a href="menu.html" class="btn-book">Book a table</a>
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
                        <a href="category.php?category=Shirt" class="swiper-slide slide">
                            <img src="images/image-removebg-preview-8-1-gzD.png" alt="">
                            <h3>Pizza</h3>
                        </a>
                        <a href="category.php?category=Shirt" class="swiper-slide slide">
                            <img src="images/image-removebg-preview-8-1-gzD.png" alt="">
                            <h3>Buggers</h3>
                        </a>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
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
                        <a href="#" class="swiper-slide slide">
                            <div class="product-card">
                                <img src="images/image-removebg-preview-8-1-gzD.png">
                                <div class="product-card-price">
                                    <p>Rs.150.00</p>
                                </div>
                                <div class="product-cover">
                                    <h1>Fish and Veggie</h1>
                                    <p>Lorem ipsum dolor sit , consectetur adipiscing elit, sed do eiusmod tempor</p>
                                </div>
                            </div>
                        </a>
                        <a href="#" class="swiper-slide slide">
                            <div class="product-card">
                                <img src="images/image-removebg-preview-8-1-gzD.png">
                                <div class="product-card-price">
                                    <p>Rs.150.00</p>
                                </div>
                                <div class="product-cover">
                                    <h1>Fish</h1>
                                    <p>Lorem ipsum dolor sit , consectetur adipiscing elit, sed do eiusmod tempor</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        <section class="deal">
            <div class="image">
                <img src="images/mask-group-Vjo.png" alt="">
            </div>
            <div class="content">
                <span>new season trending!</span>
                <h3>best summer collection</h3>
                <p>sale get up to 50% off</p>
                <a href="shop.php" class="btn">Book Now</a>
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