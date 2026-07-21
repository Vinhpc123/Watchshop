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
            <a href="index.php">Trang chá»§</a>
            <a href="products.php">Sáº£n pháº©m</a>
            <a href="orders.php">Äáº·t hÃ ng</a>
            <a href="users.php">Users</a>
            <a href="contacts.php">Tin nháº¯n</a>
            <a href="pos.php">BÃ¡n hÃ ng</a>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>

        <div class="account-box">
            <p>TÃªn ngÆ°á»i dÃ¹ng : <span><?php echo isset($_SESSION['admin_name']) ? htmlspecialchars($_SESSION['admin_name'], ENT_QUOTES, 'UTF-8') : ''; ?></span></p>
            <p>Email : <span><?php echo isset($_SESSION['admin_email']) ? htmlspecialchars($_SESSION['admin_email'], ENT_QUOTES, 'UTF-8') : ''; ?></span></p>
            <a href="../logout.php" class="delete-btn">ÄÄƒng xuáº¥t</a>
            <div> <a href="../login.php">ÄÄƒng nháº­p</a> | <a href="../register.php">ÄÄƒng kÃ½</a></div>
        </div>

    </div>

</header>

