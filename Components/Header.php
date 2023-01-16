<!-- header section starts  -->
<header class="header">
    <a href="/index.php" class="logo"><img src="/Images/Beige & Brown Illustration Restaurant Logo no bg.png"> </a>
    <nav class="navbar">
        <div id="nav-close" class="fas fa-times"></div>
        <a href="/About.php">About</a>
        <a href="/Menu.php">Menu</a>
        <a href="/Category.php">Category</a>
        <a href="/Reservation.php">Booking</a>
        <a href="/Contact.php">Contact</a>
    </nav>
    <div class="icons">
        <?php
        $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $count_cart_items->execute([$user_id]);
        $total_cart_items = $count_cart_items->rowCount();
        ?>
        <div id="menu-btn" class="fas fa-bars"></div>
        <a href="/Cart.php" class="fas fa-shopping-cart" style="width: 24px; margin-left: 150px"><span>(<?= $total_cart_items; ?>)</span></a>&nbsp;&nbsp;
        <div id="user-btn" class="fas fa-user"></div>
        <div id="search-btn"></div>
    </div>
    <div class="profile">
        <?php
        $select_profile = $conn->prepare("SELECT * FROM `user` WHERE id = ?");
        $select_profile->execute([$user_id]);
        if ($select_profile->rowCount() > 0) {
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
        ?>
            <p class="name"><?= $fetch_profile['name']; ?></p>
            <div class="flex">
                <a href="/Profile.php" class="btn">profile</a>
                <a href="Components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
            </div>
            <p class="account">
                <a href="login.php">login</a> or
                <a href="Register.php">register</a>
            </p>
        <?php
        } else {
        ?>
            <p class="name">please login first!</p>
            <a href="login.php" class="btn">login</a>
        <?php
        }
        ?>
    </div>
</header>
<!-- header section ends -->
<!-- search form  -->
<div class="search-form">
    <div id="close-search"></div>
</div>