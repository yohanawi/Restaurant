<!-- header section starts  -->
<header class="header">
    <a href="/index.php" class="logo"><img src="/Images/Beige & Brown Illustration Restaurant Logo no bg.png"> </a>
    <nav class="navbar">
        <div id="nav-close" class="fas fa-times"></div>
        <a href="/About.php">About</a>
        <a href="/Menu.php">Menu</a>
        <a href="/Category.php">Category</a>
        <a href="/Order.php">Orders</a>
        <a href="/Contact.php">Contact</a>
    </nav>
    <div class="icons">
        <?php
        $count_cart_items = $conn->prepare("SELECT * FROM `cart`");
    
        $total_cart_items = $count_cart_items->rowCount();
        ?>
        <div id="menu-btn" class="fas fa-bars"></div>
        <a href="/Cart.php" class="fas fa-shopping-cart" style="width: 24px; margin-left: 150px"><span>(<?= $total_cart_items; ?>)</span></a>
        <button class="btn-sign" onclick="window.location='./Login.php';"> Sign in</button>
        <div id="search-btn"></div>
        <!--<button class="btn-sign"> Button</button>-->
    </div>
</header>
<!-- header section ends -->
<!-- search form  -->
<div class="search-form">
    <div id="close-search"></div>
</div>