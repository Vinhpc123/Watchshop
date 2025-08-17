<?php
session_start();
include 'config.php';
header('Content-Type: application/json; charset=utf-8');
// chỉ cho admin truy cập
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden: admin only']);
    exit;
}
$days = 7;
$query = "SELECT id, placed_on, payment_status, total_products FROM `orders` WHERE placed_on >= DATE_SUB(NOW(), INTERVAL $days DAY) ORDER BY placed_on DESC LIMIT 100";
$res = mysqli_query($conn, $query) or die(json_encode(['error'=>mysqli_error($conn)]));
$rows = [];
while($r = mysqli_fetch_assoc($res)) {
    $rows[] = $r;
}
echo json_encode(['count' => count($rows), 'rows' => $rows], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
