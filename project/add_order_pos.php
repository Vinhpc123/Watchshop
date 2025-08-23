<?php
require 'config.php';

header('Content-Type: application/json; charset=utf-8');

// ❗ Không in warning ra output vì sẽ phá JSON
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

// ✅ 1. Lưu đơn hàng
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

if (!$stmt->execute()) {
    error_log('Execute failed: ' . $stmt->error);
    echo json_encode(['success' => false, 'error' => 'EXECUTE_FAILED']);
    $stmt->close();
    $conn->close();
    exit;
}

$order_id = $stmt->insert_id;
$stmt->close();

// ✅ 2. Lưu chi tiết sản phẩm & trừ kho
$itemStmt = $conn->prepare("
    INSERT INTO order_items (order_id, product_id, quantity, price)
    VALUES (?, ?, ?, ?)
");
$updateStockStmt = $conn->prepare("
    UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?
");

if (!$itemStmt || !$updateStockStmt) {
    error_log('Prepare item/stock failed: ' . $conn->error);
    echo json_encode(['success' => false, 'error' => 'PREPARE_DETAIL_FAILED']);
    $conn->close();
    exit;
}

foreach ($data['items'] as $item) {
    $pid  = (int)$item['id'];
    $qty  = (int)$item['quantity'];
    $price = (float)$item['price'];

    // Lưu chi tiết đơn hàng
    $itemStmt->bind_param("iiid", $order_id, $pid, $qty, $price);
    if (!$itemStmt->execute()) {
        error_log("Insert order item failed: " . $itemStmt->error);
    }

    // Trừ tồn kho (chỉ trừ nếu còn đủ hàng)
    $updateStockStmt->bind_param("iii", $qty, $pid, $qty);
    if (!$updateStockStmt->execute()) {
        error_log("Update stock failed for product $pid: " . $updateStockStmt->error);
    }
}

$itemStmt->close();
$updateStockStmt->close();

$conn->close();

echo json_encode([
    'success'   => true,
    'message'   => 'Đơn POS đã lưu và cập nhật tồn kho',
    'order_id'  => $order_id
], JSON_UNESCAPED_UNICODE);