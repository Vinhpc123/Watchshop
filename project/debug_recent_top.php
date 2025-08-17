<?php
session_start();
include 'config.php';
header('Content-Type: application/json; charset=utf-8');
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Forbidden: admin only']);
    exit;
}
$recent_query = "SELECT total_products, placed_on FROM `orders` WHERE payment_status = 'Thành công' AND placed_on >= DATE_SUB(NOW(), INTERVAL 7 DAY) ORDER BY placed_on DESC";
$recent_result = mysqli_query($conn, $recent_query) or die(json_encode(['error'=>mysqli_error($conn)]));
$recent_counts = array();
while($order = mysqli_fetch_assoc($recent_result)) {
    $total_products = $order['total_products'];
    $products = explode(',', $total_products);
    foreach($products as $product) {
        $product = trim($product);
        if(empty($product)) continue;
        if(preg_match('/(.+?)\s*\((\d+)\)/', $product, $m)) {
            $pname = trim($m[1]);
            $qty = (int)$m[2];
            if($pname === '') continue;
            if(isset($recent_counts[$pname])) $recent_counts[$pname] += $qty; else $recent_counts[$pname] = $qty;
        }
    }
}
arsort($recent_counts);
$recent_top = array_slice($recent_counts, 0, 5, true);
echo json_encode(['recent_top'=>$recent_top, 'all_counts'=>$recent_counts], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
