<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['order_btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = $_POST['number'];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . '' . $_POST['pin_code']);
    $placed_on = date('Y-m-d');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['name'] . ' (' . $cart_item['quantity'] . ') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if ($cart_total == 0) {
        $_SESSION['cart_message'] = 'Giỏ hàng của bạn đang trống!';
    } else {
        if (mysqli_num_rows($order_query) > 0) {
            $_SESSION['cart_message'] = 'Đơn hàng đã được đặt trước đó!';
        } else {
            mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
            $_SESSION['cart_message'] = 'Đơn hàng đã được đặt thành công!';
            mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        }
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
    <title>Checkout</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">


</head>

<body>

    <?php include 'header.php'; ?>



    <section class="display-order">
        <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if (mysqli_num_rows($select_cart) > 0) {
        while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>
        <div class="cart-item">
            <div class="cart-image">
                <!-- Assuming the product image URL is stored in `product_image` -->
                <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="">
            </div>
            <div class="cart-details">
                <p><?php echo $fetch_cart['name']; ?>
                    <span>(<?php echo number_format($fetch_cart['price'], 0, ',', '.') . ' VNĐ x ' . $fetch_cart['quantity']; ?>)</span>
                </p>
            </div>
        </div>
        <?php
        }
    } else {
        echo '<p class="empty">Giỏ hàng của bạn đang trống!</p>';
    }
    ?>
    </section>

    <!-- Grand Total outside the product items loop -->
    <div class="grand-total">Tổng: <span><?php echo number_format($grand_total, 0, ',', '.'); ?> VNĐ</span></div>




    <section class="checkout">

        <form action="" method="post">
            <h3>Địa chỉ giao hàng</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Họ và tên :</span>
                    <input type="text" name="name" required placeholder="Vui lòng nhập tên">
                </div>
                <div class="inputBox">
                    <span>Số điện thoại:</span>
                    <input type="text" name="number" required placeholder="VD: 038xxxxxxx"
                        pattern="(032|033|034|035|036|037|038|039|070|079|077|076|078|081|082|083|084|085|056|058|059)\d{7}"
                        maxlength="10" title="Số điện thoại hợp lệ gồm 10 số, bắt đầu bằng đầu số di động Việt Nam"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);">
                </div>


                <div class="inputBox">
                    <span>Email :</span>
                    <input type="email" name="email" required placeholder="Vui lòng nhập email">
                </div>
                <div class="inputBox">
                    <span>Hình thức thanh toán :</span>
                    <select name="method">
                        <option value="Thanh toán khi giao hàng">Thanh toán khi giao hàng</option>
                        <option value="ATM">Chuyển khoản ngân hàng</option>
                        <option value="Momo">Thanh toán qua Momo</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Số nhà(Nếu có):</span>
                    <input type="text" min="0" name="flat" required placeholder="">
                </div>
                <div class="inputBox">
                    <span>Đường-Quận-Huyện :</span>
                    <input type="text" name="street" required placeholder="Vui lòng nhập địa chỉ giao hàng">
                </div>
                <div class="inputBox">
                    <span>Thành phố :</span>
                    <input type="text" name="city" required placeholder="Vui lòng nhập địa chỉ giao hàng">
                </div>

                <div class="inputBox">
                    <span>Quốc gia :</span>
                    <input type="text" name="country" required placeholder="Vui lòng nhập địa chỉ giao hàng">
                </div>

            </div>
            <input type="submit" value="Đặt hàng" class="btn" name="order_btn">
        </form>

    </section>

    <?php include 'footer.php'; ?>

    <!-- Custom JS File Link -->
    <script src="js/script.js"></script>

    <!-- JavaScript to show alert messages -->
    <script>
    <?php if (isset($_SESSION['cart_message'])): ?>
    alert("<?php echo $_SESSION['cart_message']; ?>");
    <?php unset($_SESSION['cart_message']); // Clear message after displaying ?>
    <?php endif; ?>
    </script>

</body>

</html>