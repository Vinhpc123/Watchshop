<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

    <div class="flex">

        <a href="index.php" class="logo">Admin<span>Panel</span></a>

        <nav class="navbar">
            <a href="index.php">Trang chủ</a>
            <a href="products.php">Sản phẩm</a>
            <a href="orders.php">Đặt hàng</a>
            <a href="users.php">Users</a>
            <a href="contacts.php">Tin nhắn</a>
            <a href="pos.php">Bán hàng</a>

        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>Tên người dùng : <span><?php echo htmlspecialchars($_SESSION['admin_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span></p>
            <p>Email : <span><?php echo htmlspecialchars($_SESSION['admin_email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span></p>
            <a href="../logout.php" class="delete-btn">Đăng xuất</a>
            <div> <a href="../login.php">Đăng nhập</a> | <a href="../register.php">Đăng ký</a></div>
        </div>

    </div>

</header>