<?php
include '../config.php';

// Tự động kiểm tra và thêm cột stock nếu chưa có
$check_column = mysqli_query($conn, "SHOW COLUMNS FROM `products` LIKE 'stock'");
if (mysqli_num_rows($check_column) == 0) {
    $alter_query = "ALTER TABLE `products` ADD COLUMN `stock` INT(10) NOT NULL DEFAULT 100 AFTER `price`";
    if (mysqli_query($conn, $alter_query)) {
        echo "<h3 style='color:green;'>✅ Đã tự động thêm cột 'stock' vào bảng 'products' với số lượng mặc định 100!</h3>";
    } else {
        echo "<h3 style='color:red;'>❌ Lỗi khi thêm cột 'stock': " . mysqli_error($conn) . "</h3>";
    }
} else {
    echo "<h3 style='color:blue;'>ℹ️ Cột 'stock' đã tồn tại trong bảng 'products'.</h3>";
}

// Cập nhật stock = 100 cho tất cả sản phẩm đang có stock = 0 hoặc NULL
$update_stock = "UPDATE `products` SET `stock` = 100 WHERE `stock` IS NULL OR `stock` <= 0";
if (mysqli_query($conn, $update_stock)) {
    echo "<h3 style='color:green;'>✅ Đã cập nhật lại tồn kho (stock = 100) cho các sản phẩm chưa có tồn kho!</h3>";
}

// Kiểm tra bảng orders có cột total_products không
$check_orders = mysqli_query($conn, "SHOW COLUMNS FROM `orders` LIKE 'total_products'");
if (mysqli_num_rows($check_orders) == 0) {
    echo "<h3 style='color:red;'>⚠️ Cảnh báo: Bảng 'orders' chưa có cột 'total_products'!</h3>";
}

echo "<hr><p><a href='../home.php'>Quay lại trang chủ</a> | <a href='../admin/products.php'>Đến trang quản lý sản phẩm Admin</a></p>";
?>
