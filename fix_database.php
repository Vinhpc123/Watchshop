<?php
include 'config.php';

echo "🔧 Bắt đầu cập nhật database...\n\n";

// 1. Cập nhật cấu trúc bảng
echo "1. Cập nhật cột placed_on thành DATETIME...\n";
$alter_query = "ALTER TABLE `orders` MODIFY COLUMN `placed_on` DATETIME DEFAULT NULL";
if (mysqli_query($conn, $alter_query)) {
    echo "✅ Cập nhật cấu trúc thành công!\n\n";
} else {
    echo "❌ Lỗi: " . mysqli_error($conn) . "\n\n";
}

// 2. Cập nhật dữ liệu hiện có
echo "2. Cập nhật thời gian cho các đơn hàng hiện có...\n";
$update_query = "UPDATE `orders` SET `placed_on` = CONCAT(DATE(placed_on), ' ', 
    CASE 
        WHEN id % 24 = 0 THEN '00:00:00'
        WHEN id % 24 = 1 THEN '01:00:00'
        WHEN id % 24 = 2 THEN '02:00:00'
        WHEN id % 24 = 3 THEN '03:00:00'
        WHEN id % 24 = 4 THEN '04:00:00'
        WHEN id % 24 = 5 THEN '05:00:00'
        WHEN id % 24 = 6 THEN '06:00:00'
        WHEN id % 24 = 7 THEN '07:00:00'
        WHEN id % 24 = 8 THEN '08:00:00'
        WHEN id % 24 = 9 THEN '09:00:00'
        WHEN id % 24 = 10 THEN '10:00:00'
        WHEN id % 24 = 11 THEN '11:00:00'
        WHEN id % 24 = 12 THEN '12:00:00'
        WHEN id % 24 = 13 THEN '13:00:00'
        WHEN id % 24 = 14 THEN '14:00:00'
        WHEN id % 24 = 15 THEN '15:00:00'
        WHEN id % 24 = 16 THEN '16:00:00'
        WHEN id % 24 = 17 THEN '17:00:00'
        WHEN id % 24 = 18 THEN '18:00:00'
        WHEN id % 24 = 19 THEN '19:00:00'
        WHEN id % 24 = 20 THEN '20:00:00'
        WHEN id % 24 = 21 THEN '21:00:00'
        WHEN id % 24 = 22 THEN '22:00:00'
        ELSE '23:00:00'
    END)
WHERE placed_on IS NOT NULL";

if (mysqli_query($conn, $update_query)) {
    echo "✅ Cập nhật dữ liệu thành công!\n\n";
} else {
    echo "❌ Lỗi: " . mysqli_error($conn) . "\n\n";
}

// 3. Thêm dữ liệu test cho hôm nay
echo "3. Thêm dữ liệu test cho hôm nay...\n";
date_default_timezone_set('Asia/Ho_Chi_Minh');
$today = date('Y-m-d');

$test_orders = [
    ['08:30:00', 'Test User 1', 500000, 'Test Product 1'],
    ['14:15:00', 'Test User 2', 750000, 'Test Product 2'],
    ['20:45:00', 'Test User 3', 300000, 'Test Product 3'],
    [date('H:i:s'), 'Current User', 1000000, 'Current Product']
];

foreach ($test_orders as $order) {
    $datetime = $today . ' ' . $order[0];
    $insert_query = "INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) VALUES
    (11, '{$order[1]}', '0355367829', 'test@gmail.com', 'Thanh toán khi giao hàng', 'Test Address', ', {$order[3]} (1) ', {$order[2]}, '$datetime', 'Thành công')";
    
    if (mysqli_query($conn, $insert_query)) {
        echo "✅ Thêm đơn hàng lúc {$order[0]} thành công!\n";
    } else {
        echo "❌ Lỗi thêm đơn hàng: " . mysqli_error($conn) . "\n";
    }
}

echo "\n🎉 Hoàn thành cập nhật database!\n";

// 4. Kiểm tra kết quả
echo "\n4. Kiểm tra dữ liệu:\n";
$check_query = "SELECT id, name, placed_on, DATE(placed_on) as order_date, HOUR(placed_on) as order_hour, total_price 
                FROM `orders` 
                WHERE payment_status = 'Thành công' 
                ORDER BY placed_on DESC LIMIT 10";
$result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "ID: {$row['id']} | {$row['name']} | {$row['placed_on']} | Giờ: {$row['order_hour']}h | " . number_format($row['total_price']) . " VNĐ\n";
    }
} else {
    echo "Không có dữ liệu\n";
}

mysqli_close($conn);
?>