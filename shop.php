<?php

include 'config.php';

session_start();

// Retrieve user ID from session, if available
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialize message array
$messages = [];

if (isset($_POST['add_to_cart'])) {

    // Nếu chưa đăng nhập thì chuyển hướng
    if ($user_id === null) {
        header('Location: login.php');
        exit();
    }

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = (int)$_POST['product_quantity'];

    // Lấy số lượng tồn kho từ bảng products
    $check_stock = mysqli_query($conn, "SELECT stock FROM `products` WHERE name = '$product_name' LIMIT 1") or die(mysqli_error($conn));
    $stock_data = mysqli_fetch_assoc($check_stock);
    $available_stock = (int)$stock_data['stock'];


    if ($product_quantity > $available_stock) {
        $_SESSION['cart_message'] = "Số lượng bạn chọn vượt quá số lượng tồn kho! (Còn lại $available_stock sản phẩm)";
    } else {
        // Kiểm tra sản phẩm đã có trong giỏ chưa
        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $_SESSION['cart_message'] = 'Sản phẩm đã có trong giỏ hàng!';
        } else {
            mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) 
                                 VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
            $_SESSION['cart_message'] = 'Sản phẩm đã được thêm vào giỏ hàng!';
        }
    }

    // Redirect để hiển thị alert
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
}

// Clear message after showing
if (isset($_SESSION['cart_message'])) {
    $cart_message = $_SESSION['cart_message'];
    unset($_SESSION['cart_message']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'includes/header.php'; ?>

    <section class="products">

        <h1 class="title">Sản phẩm mới nhất</h1>

        <div class="box-container">

            <?php  
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <form action="" method="post" class="box" itemscope itemtype="https://schema.org/Product">
                <div class="image-wrapper">
                    <img class="image" 
                         src="uploaded_img/<?php echo htmlspecialchars($fetch_products['image']); ?>" 
                         alt="<?php echo htmlspecialchars($fetch_products['name']); ?>" 
                         itemprop="image" 
                         loading="lazy">
                </div>
                
                <h3 class="name" itemprop="name"><?php echo htmlspecialchars($fetch_products['name']); ?></h3>
                
                <div class="price" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                    <meta itemprop="priceCurrency" content="VND">
                    <meta itemprop="price" content="<?php echo $fetch_products['price']; ?>">
                    <link itemprop="availability" href="https://schema.org/InStock" />
                    <span><?php echo number_format($fetch_products['price'], 0, ',', '.'); ?>đ</span>
                </div>
                
                <div class="actions-row">
                    <div class="qty-wrapper">
                        <button type="button" class="qty-btn" onclick="this.nextElementSibling.stepDown()">-</button>
                        <input type="number" min="1" name="product_quantity" value="1" class="qty-input" aria-label="Số lượng">
                        <button type="button" class="qty-btn" onclick="this.previousElementSibling.stepUp()">+</button>
                    </div>
                    
                    <button type="submit" name="add_to_cart" class="btn-add-cart">
                        <i class="fas fa-shopping-bag"></i>
                        <span>Thêm vào giỏ</span>
                    </button>
                </div>

                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($fetch_products['name']); ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($fetch_products['image']); ?>">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có sản phẩm nào!</p>';
            }
            ?>
        </div>

    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- Custom JS File Link -->
    <script src="./js/script.js"></script>

    <!-- JavaScript to show alert messages -->
    <script>
    <?php if (isset($cart_message)): ?>
    alert("<?php echo $cart_message; ?>");
    <?php endif; ?>
    </script>

</body>

</html>