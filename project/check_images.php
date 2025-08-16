<?php
include 'config.php';

echo "<h2>Kiểm tra hình ảnh trong database:</h2>";

$select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 5") or die('query failed');

if (mysqli_num_rows($select_products) > 0) {
    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        $image_path = "uploaded_img/" . $fetch_products['image'];
        $file_exists = file_exists($image_path);
        
        echo "<div style='border: 1px solid #ccc; margin: 10px; padding: 10px;'>";
        echo "<strong>Sản phẩm:</strong> " . $fetch_products['name'] . "<br>";
        echo "<strong>File ảnh:</strong> " . $fetch_products['image'] . "<br>";
        echo "<strong>Đường dẫn:</strong> " . $image_path . "<br>";
        echo "<strong>File tồn tại:</strong> " . ($file_exists ? "CÓ" : "KHÔNG") . "<br>";
        
        if ($file_exists) {
            echo "<img src='" . $image_path . "' style='max-width: 200px; height: auto;' alt='Test image'><br>";
        }
        
        echo "</div><hr>";
    }
} else {
    echo "Không có sản phẩm nào trong database.";
}
?>
