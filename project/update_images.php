<?php
session_start();
include 'config.php';
if (!isset($_SESSION['admin_id'])) {
    http_response_code(403);
    echo '<p>Forbidden: admin only</p>';
    exit;
}

echo "<h2>Cập nhật hình ảnh sang định dạng JPG/PNG</h2>";

// Mapping từ AVIF sang JPG có sẵn
$image_mapping = [
    'AE-1200WHD-1AVDF.avif' => 'AE-1200WHD-1AVDF-2-1.jpg',
    // Thêm các mapping khác nếu cần
];

// Lấy danh sách products với AVIF
$select_avif = mysqli_query($conn, "SELECT * FROM `products` WHERE image LIKE '%.avif'") or die('query failed');

if (mysqli_num_rows($select_avif) > 0) {
    echo "<p>Tìm thấy " . mysqli_num_rows($select_avif) . " sản phẩm sử dụng AVIF</p>";
    
    while ($product = mysqli_fetch_assoc($select_avif)) {
        $old_image = $product['image'];
        $new_image = $old_image;
        
        // Nếu có mapping, sử dụng mapping
        if (isset($image_mapping[$old_image])) {
            $new_image = $image_mapping[$old_image];
        } else {
            // Thử tìm file JPG tương ứng
            $base_name = pathinfo($old_image, PATHINFO_FILENAME);
            $jpg_candidates = [
                $base_name . '.jpg',
                $base_name . '-2-1.jpg',
                $base_name . '-1.jpg'
            ];
            
            foreach ($jpg_candidates as $candidate) {
                if (file_exists('uploaded_img/' . $candidate)) {
                    $new_image = $candidate;
                    break;
                }
            }
        }
        
        if ($new_image !== $old_image && file_exists('uploaded_img/' . $new_image)) {
            // Cập nhật database
            $update_query = "UPDATE `products` SET image = '$new_image' WHERE id = " . $product['id'];
            if (mysqli_query($conn, $update_query)) {
                echo "<p style='color: green;'>✓ Cập nhật " . $product['name'] . ": " . $old_image . " → " . $new_image . "</p>";
            } else {
                echo "<p style='color: red;'>✗ Lỗi cập nhật " . $product['name'] . "</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠ Không tìm thấy file JPG thay thế cho: " . $old_image . "</p>";
        }
    }
} else {
    echo "<p>Không có sản phẩm nào sử dụng AVIF</p>";
}

echo "<hr><a href='shop.php'>Xem Shop</a> | <a href='home.php'>Về Trang chủ</a>";
?>
