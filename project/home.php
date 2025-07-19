<?php

include 'config.php';

session_start();

// Check if user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (isset($_POST['add_to_cart'])) {

    // If user is not logged in, redirect to login page
    if ($user_id === null) {
        header('Location: login.php');
        exit();
    }

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = (int)$_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $_SESSION['cart_message'] = 'Sản phẩm đã được thêm vào giỏ hàng!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $_SESSION['cart_message'] = 'Sản phẩm đã được thêm vào giỏ hàng!';
    }

    // Redirect to the same page to display message
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- <link rel="icon" href="images/avt1.png" type="image/png" /> -->

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="stylesheet" href="js/script.js">
    <style>
    /* CSS để ẩn các sản phẩm sau sản phẩm thứ 5 */
    .products .box-container .box:nth-child(n+10) {
        display: none;
    }

    /* brand-logo  */
    .brands-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
        justify-content: center;
        align-items: center;
        margin-top: 32px;
    }



    .brand-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 120px;
        text-decoration: none;
        color: #444;
        transition: transform 0.2s;
    }

    .brand-item:hover {
        transform: translateY(-6px) scale(1.07);
    }

    .brand-icon {
        width: 90px;
        height: 90px;
        background: #f5f5f7;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        font-size: 2.8rem;
        color: #888;
        transition: box-shadow 0.2s, color 0.2s, background 0.2s;
    }

    .brand-item:hover .brand-icon {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.13);
        color: #007bff;
        background: #fff;
    }

    .brand-label {
        margin-top: 4px;
        font-size: 1.3rem;
        color: #444;
        text-align: center;
        font-weight: 500;
    }

    .brands-row,
    .brands-row2 {
        display: flex;
        justify-content: center;
        gap: 50px;
        margin: 40px 10px;
    }

    .brands-row2 {
        margin-bottom: -20px;
    }

    .home {
        position: relative;
        min-height: 83vh;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .slide {
        position: absolute;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        top: 0;
        left: 0;
        opacity: 0;
        transition: opacity 0.8s ease-in-out;
    }

    .slide.show {
        opacity: 1;
    }

    .content {
        position: relative;
        color: white;
        text-align: center;
        z-index: 2;
    }

    /* Nút chuyển ảnh */
    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 2rem;
        background-color: rgba(0, 0, 0, 0.4);
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        z-index: 3;
        transition: background-color 0.3s;
    }

    .nav-btn:hover {
        background-color: rgba(0, 0, 0, 0.7);
    }

    .nav-btn.prev {
        left: 10px;
    }

    .nav-btn.next {
        right: 10px;
    }

    .slide.active {
        opacity: 1;
        z-index: 2;
    }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="home">
        <!-- Các slide ảnh nền -->
        <div class="slide show"
            style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.2)),url('../project/images/img_nền/slide-1.jpg')">
        </div>
        <div class="slide"
            style="background-image:linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.2)),url('../project/images/img_nền/slide-2.jpg')">
        </div>
        <div class="slide"
            style="background-image: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.2)),url('../project/images/img_nền/slide-3.jpg')">
        </div>

        <!-- Nút điều hướng -->
        <button class="nav-btn prev">&#10094;</button>
        <button class="nav-btn next">&#10095;</button>

        <!-- Nội dung hiển thị -->
        <div class="content">
            <h3>ĐỒNG HỒ CHÍNH HÃNG CAO CẤP</h3>
            <p>Với thiết kế hiện đại và đa dạng mẫu mã, chúng tôi tự tin rằng bạn sẽ tìm thấy một chiếc đồng hồ nam đẹp
                và ưng ý nhất cho mình.</p>
            <a href="about.php" class="white-btn">XEM THÊM</a>
        </div>
    </section>


    <!-- Section các hãng đồng hồ -->
    <section class="brands">
        <h2 class="title">CÁC HÃNG ĐỒNG HỒ NỔI BẬT</h2>
        <!-- Hàng 1 -->
        <div class="brands-row">
            <a href="shop.php?brand=Casio" class="brand-item">
                <div class="brand-icon"><i class="fas fa-calculator"></i></div>
                <div class="brand-label">Casio</div>
            </a>
            <a href="shop.php?brand=Citizen" class="brand-item">
                <div class="brand-icon"><i class="fas fa-globe"></i></div>
                <div class="brand-label">Citizen</div>
            </a>
            <a href="shop.php?brand=Seiko" class="brand-item">
                <div class="brand-icon"><i class="fas fa-stopwatch"></i></div>
                <div class="brand-label">Seiko</div>
            </a>
            <a href="shop.php?brand=Orient" class="brand-item">
                <div class="brand-icon"><i class="fas fa-compass"></i></div>
                <div class="brand-label">Orient</div>
            </a>
            <a href="shop.php?brand=Fossil" class="brand-item">
                <div class="brand-icon"><i class="fas fa-gem"></i></div>
                <div class="brand-label">Fossil</div>
            </a>
        </div>
        <!-- Hàng 2 -->
        <div class="brands-row2">
            <a href="shop.php?brand=Rolex" class="brand-item">
                <div class="brand-icon"><i class="fas fa-crown"></i></div>
                <div class="brand-label">Rolex</div>
            </a>
            <a href="shop.php?brand=Omega" class="brand-item">
                <div class="brand-icon"><i class="fas fa-circle-notch"></i></div>
                <div class="brand-label">Omega</div>
            </a>
            <a href="shop.php?brand=Longines" class="brand-item">
                <div class="brand-icon"><i class="fas fa-feather-alt"></i></div>
                <div class="brand-label">Longines</div>
            </a>
            <a href="shop.php?brand=Bulova" class="brand-item">
                <div class="brand-icon"><i class="fas fa-bullseye"></i></div>
                <div class="brand-label">Bulova</div>
            </a>
            <a href="shop.php?brand=Michael Kors" class="brand-item">
                <div class="brand-icon"><i class="fas fa-star"></i></div>
                <div class="brand-label">Michael Kors</div>
            </a>
        </div>
        </div>
    </section>

    <section class="products">

        <h1 class="title">SẢN PHẨM MỚI NHẤT!!</h1>

        <div class="box-container">
            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC LIMIT 8") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <form action="" method="post" class="box">
                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price"><?php echo number_format($fetch_products['price'], 0, ',', '.'); ?> VNĐ</div>
                <div class="actions-row">
                    <input type="number" min="1" name="product_quantity" value="1" class="qty">
                    <input type="submit" value="Thêm Vào Giỏ Hàng" name="add_to_cart" class="btn">
                </div>
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có sản phẩm!</p>';
            }
            ?>
        </div>

        <div class="load-more" style="margin-top: 2rem; text-align:center">
            <a href="shop.php" class="option-btn">Xem thêm</a>
        </div>

    </section>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/img_nền/preview_img.jpg" alt="" ">
            </div>

            <div class=" content">
                <h3>VỀ CHÚNG TÔI</h3>
                <p>Chúng tôi đánh giá cao sự quan tâm của bạn đến bộ sưu tập đồng hồ của chúng tôi. Nếu bạn có bất kỳ
                    câu hỏi hoặc cần hỗ trợ, xin vui lòng liên hệ với chúng tôi. Chúng tôi mong được phục vụ bạn.</p>
                <a href="about.php" class="btn">Xem thêm</a>
            </div>

        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>BẠN CÓ CÂU HỎI NÀO KHÔNG?</h3>
            <p>Chúng tôi rất trân trọng sự quan tâm của bạn đến bộ sưu tập đồng hồ của chúng tôi. Nếu bạn có bất kỳ câu
                hỏi nào hoặc muốn để lại đánh giá, xin vui lòng liên hệ với chúng tôi. Chúng tôi luôn sẵn sàng hỗ trợ
                bạn!</p>
            <a href="contact.php" class="white-btn">LIÊN HỆ</a>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- Custom JS File Link -->
    <script src="js/script.js"></script>

    <!-- JavaScript to show alert messages -->
    <script>
    <?php if (isset($_SESSION['cart_message'])): ?>
    alert("<?php echo $_SESSION['cart_message']; ?>");
    <?php unset($_SESSION['cart_message']); // Clear message after displaying 
            ?>
    <?php endif; ?>
    </script>

</body>

</html>