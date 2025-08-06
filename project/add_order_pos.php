<?php
// Kết nối cơ sở dữ liệu
include 'config.php'; // chứa mysqli_connect(...)

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $user_id = $data['customerId'] ?? 1;
    $name = $data['customerName'] ?? 'Khách lẻ';
    $number = 'N/A'; // bạn không có nên gán mặc định
    $email = 'N/A';
    $method = $data['paymentMethod'] ?? 'Tiền mặt';
    $address = 'N/A';
    
    // chuyển items thành chuỗi
    $total_products = '';
    foreach ($data['items'] as $item) {
        $total_products .= $item['name'] . ' x ' . $item['quantity'] . ', ';
    }
    $total_products = rtrim($total_products, ', ');
    
    $total_price = $data['total'];
    $placed_on = date('Y-m-d H:i:s', strtotime($data['date']));
    $payment_status = 'Thành công';

    // Chuẩn bị câu SQL
    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssiss", $user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on, $payment_status);

    if ($stmt->execute()) {
        echo "Thêm đơn hàng thành công!";
    } else {
        echo "Lỗi: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Không có dữ liệu nhận được.";
}
?>