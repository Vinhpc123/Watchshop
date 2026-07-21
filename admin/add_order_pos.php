<?php
require 'config.php';

header('Content-Type: application/json; charset=utf-8');

// â— KhÃ´ng in warning ra output vÃ¬ sáº½ phÃ¡ JSON
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

$user_id        = null; // khÃ¡ch láº»
$name           = trim($data['customerName'] ?? 'KhÃ¡ch láº»');
$number         = trim($data['customerNumber'] ?? 'N/A');
$email          = trim($data['customerEmail'] ?? 'N/A');
$method         = trim($data['paymentMethod'] ?? 'Tiá»n máº·t');  // vÃ­ dá»¥: "Tiá»n máº·t" | "Chuyá»ƒn khoáº£n"
$address        = trim($data['customerAddress'] ?? 'Mua táº¡i cá»­a hÃ ng');

$total_products = '';
foreach ($data['items'] as $item) {
    $pname = $item['name'] ?? 'Sáº£n pháº©m';
    $qty   = (int)($item['quantity'] ?? 1);
    $total_products .= $pname . ' (' . $qty . '), ';
}
$total_products = rtrim($total_products, ', ');

$total_price    = (int)($data['total'] ?? 0);
$placed_on      = date('Y-m-d');        // báº£ng cá»§a báº¡n lÃ  DATE
$payment_status = 'ThÃ nh cÃ´ng';
$order_type     = 'pos';

// âœ… 1. LÆ°u Ä‘Æ¡n hÃ ng
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

// âœ… 2. LÆ°u chi tiáº¿t sáº£n pháº©m & trá»« kho
$updateStockStmt = $conn->prepare("
    UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?
");

if ( !$updateStockStmt) {
    error_log('Prepare item/stock failed: ' . $conn->error);
    echo json_encode(['success' => false, 'error' => 'PREPARE_DETAIL_FAILED']);
    $conn->close();
    exit;
}

foreach ($data['items'] as $item) {
    $pid  = (int)$item['id'];
    $qty  = (int)$item['quantity'];
    $price = (float)$item['price'];

    

    // Trá»« tá»“n kho (chá»‰ trá»« náº¿u cÃ²n Ä‘á»§ hÃ ng)
    $updateStockStmt->bind_param("iii", $qty, $pid, $qty);
    if (!$updateStockStmt->execute()) {
        error_log("Update stock failed for product $pid: " . $updateStockStmt->error);
    }
}


$updateStockStmt->close();

$conn->close();

echo json_encode([
    'success'   => true,
    'message'   => 'ÄÆ¡n POS Ä‘Ã£ lÆ°u vÃ  cáº­p nháº­t tá»“n kho',
    'order_id'  => $order_id
], JSON_UNESCAPED_UNICODE);

