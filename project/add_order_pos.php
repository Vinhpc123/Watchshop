<?php
require 'config.php';

header('Content-Type: application/json; charset=utf-8');

// ❗ ĐỪNG in warning/notice ra output vì sẽ phá JSON
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/pos_error.log');

$raw = file_get_contents('php://input');
if ($raw === false || $raw === '') {
    echo json_encode(['success' => false, 'error' => 'NO_INPUT']);
    exit;
}

$data = json_decode($raw, true);
if (!is_array($data)) {
    echo json_encode(['success' => false, 'error' => 'INVALID_JSON']);
    exit;
}

if (empty($data['items']) || !is_array($data['items'])) {
    echo json_encode(['success' => false, 'error' => 'EMPTY_ITEMS']);
    exit;
}

$user_id        = null; // khách lẻ
$name           = trim($data['customerName'] ?? 'Khách lẻ');
$number         = trim($data['customerNumber'] ?? 'N/A');
$email          = trim($data['customerEmail'] ?? 'N/A');
$method         = trim($data['paymentMethod'] ?? 'Tiền mặt');  // ví dụ: "Tiền mặt" | "Chuyển khoản"
$address        = trim($data['customerAddress'] ?? 'Mua tại cửa hàng');

$total_products = '';
foreach ($data['items'] as $item) {
    $pname = $item['name'] ?? 'Sản phẩm';
    $qty   = (int)($item['quantity'] ?? 1);
    $total_products .= $pname . ' (' . $qty . '), ';
}
$total_products = rtrim($total_products, ', ');

$total_price    = (int)($data['total'] ?? 0);
$placed_on      = date('Y-m-d');        // bảng của bạn là DATE
$payment_status = 'Thành công';
$order_type     = 'pos';

$stmt = $conn->prepare("
    INSERT INTO orders
        (user_id, name, number, email, method, address, total_products, total_price, placed_on, payment_status, order_type)
    VALUES
        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    error_log('Prepare failed: ' . $conn->error);
    echo json_encode(['success' => false, 'error' => 'PREPARE_FAILED']);
    exit;
}

$stmt->bind_param(
    "issssssisss",
    $user_id,
    $name,
    $number,
    $email,
    $method,
    $address,
    $total_products,
    $total_price,
    $placed_on,
    $payment_status,
    $order_type
);

if ($stmt->execute()) {
    echo json_encode([
        'success'   => true,
        'message'   => 'Đơn POS đã lưu',
        'order_id'  => $stmt->insert_id
    ], JSON_UNESCAPED_UNICODE);
} else {
    error_log('Execute failed: ' . $stmt->error);
    echo json_encode(['success' => false, 'error' => 'EXECUTE_FAILED']);
}

$stmt->close();
$conn->close();