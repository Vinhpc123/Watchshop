<?php
session_start();
include 'config.php';
// only admin allowed
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo '<ul class="product-list"><li><span>Forbidden</span><span>0</span></li></ul>';
    exit;
}
// Trả về HTML cho phần Sản phẩm mới đặt (Top 5) trong 7 ngày
$recent_query = "SELECT total_products FROM `orders` WHERE payment_status = 'Thành công' AND placed_on >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
$recent_result = mysqli_query($conn, $recent_query);
$recent_counts = array();
if($recent_result && mysqli_num_rows($recent_result) > 0) {
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
}
arsort($recent_counts);
$recent_top = array_slice($recent_counts, 0, 5, true);

ob_start();
if (!empty($recent_top)) {
    echo '<ul class="product-list">';
    $i = 1;
    foreach ($recent_top as $name => $qty) {
        echo '<li><span>' . $i . '. ' . htmlspecialchars($name) . '</span><span>' . $qty . ' cái</span></li>';
        $i++;
    }
    echo '</ul>';
} else {
    echo '<ul class="product-list"><li><span>Chưa có đơn hàng trong 7 ngày</span><span>0 cái</span></li></ul>';
}
$html = ob_get_clean();
header('Content-Type: text/html; charset=utf-8');
echo $html;
