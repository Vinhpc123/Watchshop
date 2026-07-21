<?php
if (isset($message) && is_array($message)) {
    foreach ($message as $msg) {
        echo '
      <div class="message">
         <span>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<header class="header">

    <div class="header-1">
        <div class="flex">
            <div class="share">
                <a href="#" class="fab fa-facebook-f" aria-label="Facebook"></a>
                <a href="#" class="fab fa-tiktok" aria-label="TikTok"></a>
                <a href="#" class="fab fa-instagram" aria-label="Instagram"></a>
                <a href="#" class="fab fa-youtube" aria-label="YouTube"></a>
            </div>
            <a href="home.php">
                <img src="images/img_nền/logo.png" alt="WatchStore Logo">
            </a>
            <p>
                <?php if (isset($_SESSION['user_name'])): ?>
                    <span>Xin chào, <b><?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?></b></span>
                <?php else: ?>
                    <a href="login.php">Đăng nhập</a> | <a href="register.php">Đăng ký</a>
                <?php endif; ?>
            </p>
        </div>
    </div>

    <div class="header-2">
        <div class="flex">
            <a href="home.php" class="logo">WATCHSTORE.</a>

            <nav class="navbar">
                <a href="home.php">Trang chủ</a>
                <a href="about.php">Giới thiệu</a>
                <a href="shop.php">Shop</a>
                <a href="contact.php">Liên hệ</a>
                <a href="orders.php">Đơn hàng</a>
            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars" role="button" tabindex="0" aria-label="Menu"></div>
                <a href="search_page.php" class="fas fa-search" aria-label="Search"></a>
                <div id="user-btn" class="fas fa-user" role="button" tabindex="0" aria-label="User Account"></div>
                <?php
                $cart_rows_number = 0;
                if (!empty($user_id)) {
                    $select_cart_number = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                    $fetch_cart_number = mysqli_fetch_assoc($select_cart_number);
                    $cart_rows_number = $fetch_cart_number['total'] ?? 0;
                }
                ?>
                <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo (int)$cart_rows_number; ?>)</span>
                </a>
            </div>

            <?php if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])): ?>
            <div class="user-box">
                <p>Username : <span><?php echo htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                <p>Email : <span><?php echo htmlspecialchars($_SESSION['user_email'], ENT_QUOTES, 'UTF-8'); ?></span></p>
                <a href="logout.php" class="delete-btn">Đăng xuất</a>
            </div>
            <?php else: ?>
            <div class="user-box">
                <p style="color: red;">Vui lòng <a href="login.php">đăng nhập</a> để sử dụng dịch vụ!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

</header>