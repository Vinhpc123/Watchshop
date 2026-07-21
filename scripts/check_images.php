<?php
include '../config.php';

echo "<h2>Kiểm tra hình ảnh trong CSDL</h2>";

$query = mysqli_query($conn, "SELECT id, name, image FROM `products` LIMIT 20");

echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Tên sản phẩm</th><th>Hình ảnh trong DB</th><th>Trạng thái file</th></tr>";

while ($row = mysqli_fetch_assoc($query)) {
    $img_name = $row['image'];
    $file_path = "../uploaded_img/" . $img_name;
    $exists = file_exists($file_path) ? "<span style='color:green'>Tồn tại</span>" : "<span style='color:red'>Không tìm thấy!</span>";
    
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['name'] . "</td>";
    echo "<td>" . $img_name . "</td>";
    echo "<td>" . $exists . "</td>";
    echo "</tr>";
}

echo "</table>";
?>
