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

    <section class="home" id="home">

        <div class="swiper home-slider">

            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="box" style="background: url(images/home-bg-1.jpg) no-repeat;">
                        <div class="content">
                            <span>never stop</span>
                            <h3>exploring</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit unde ex molestias soluta consequatur saepe aliquam, excepturi delectus consequuntur minus!</p>
                            <a href="#" class="btn">get started</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="box second" style="background: url(images/home-bg-2.jpg) no-repeat;">
                        <div class="content">
                            <span>make tour</span>
                            <h3>amazing</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit unde ex molestias soluta consequatur saepe aliquam, excepturi delectus consequuntur minus!</p>
                            <a href="#" class="btn">get started</a>
                        </div>
                    </div>
                </div>

                <div class="swiper-slide">
                    <div class="box" style="background: url(images/home-bg-3.jpg) no-repeat;">
                        <div class="content">
                            <span>explore the</span>
                            <h3>new world</h3>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Impedit unde ex molestias soluta consequatur saepe aliquam, excepturi delectus consequuntur minus!</p>
                            <a href="#" class="btn">get started</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

        </div>

    </section>

    <!-- home section ends -->
    <!-- newsletter section  -->

    <section class="newsletter">

        <div class="content">
            <h1 class="heading">subscirbe now</h1>
            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam ipsam repellat nostrum esse officiis unde quisquam corporis doloremque adipisci similique!</p>
            <form action="">
                <input type="email" name="" placeholder="enter your email" id="" class="email">
                <input type="submit" value="subscirbe" class="btn">
            </form>
        </div>

    </section>

    <section class="clients">

        <div class="swiper clients-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide silde"><img src="images/client-logo-1.png" alt=""></div>
                <div class="swiper-slide silde"><img src="images/client-logo-2.png" alt=""></div>
                <div class="swiper-slide silde"><img src="images/client-logo-3.png" alt=""></div>
                <div class="swiper-slide silde"><img src="images/client-logo-4.png" alt=""></div>
            </div>
        </div>

    </section>
    <?php include 'Components/Footer.php'; ?>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

    <!-- custom js file link  -->
    <script src="/Js/js.js"></script>
</body>

</html>