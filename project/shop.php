<?php

include 'config.php';

session_start();

// Retrieve user ID from session, if available
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Initialize message array
$messages = [];

// Handle form submission
if (isset($_POST['add_to_cart'])) {

    // Check if user is logged in
    if ($user_id === null) {
        // User is not logged in, redirect to login page
        header('Location: login.php');
        exit();
    }

    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = mysqli_real_escape_string($conn, $_POST['product_price']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_quantity = (int)$_POST['product_quantity'];

    // Check if the product is already in the cart
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $_SESSION['cart_message'] = 'Sản phẩm đã được thêm trước đó rồi!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $_SESSION['cart_message'] = 'Đơn hàng đã được thêm vào giỏ hàng thành công!';
    }

    // Redirect to the same page to display message
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

    <?php include 'header.php'; ?>

    <section class="products">

        <h1 class="title">Sản phẩm mới nhất</h1>

        <div class="box-container">

            <?php  
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <form action="" method="post" class="box">
                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="name"><?php echo $fetch_products['name']; ?></div>
                <div class="price"><?php echo number_format($fetch_products['price'], 0, ',', '.'); ?> VNĐ</div>
                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="Thêm vào giỏ hàng" name="add_to_cart" class="btn">
            </form>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có sản phẩm nào!</p>';
            }
            ?>
        </div>

    </section>

    <?php include 'footer.php'; ?>

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