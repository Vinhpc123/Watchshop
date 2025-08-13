<?php
include 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $user_id = $data['customerId'] ?? 1;
    $name = $data['customerName'] ?? 'Khách lẻ';
    $number = 'N/A';
    $email = 'N/A';
    $method = $data['paymentMethod'] ?? 'Tiền mặt';
    $address = 'N/A';

    $total_products = '';
    foreach ($data['items'] as $item) {
        $total_products .= $item['name'] . ' (' . $item['quantity'] . '), ';
    }
    $total_products = rtrim($total_products, ', ');

    $total_price = (int)$data['total']; // đảm bảo int
    $placed_on = date('Y-m-d H:i:s', strtotime($data['date'])); // ngày + giờ
    $payment_status = 'Thành công';

    header('Content-Type: application/json');

    $stmt = $conn->prepare("INSERT INTO orders (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssiss", $user_id, $name, $number, $email, $method, $address, $total_products, $total_price, $placed_on, $payment_status);

    if ($stmt->execute()) {
        $order_id = $conn->insert_id;

        echo json_encode([
            'id' => $order_id,
            'customerId' => $user_id,
            'customerName' => $name,
            'date' => $placed_on,
            'items' => $data['items'],
            'total' => $total_price,
            'paymentMethod' => $method,
            'status' => $payment_status
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Không có dữ liệu nhận được.']);
}