<?php
include '../config.php';

echo "<h2>Cập nhật tên file ảnh trong CSDL</h2>";

// Danh sách ánh xạ tên ảnh chuẩn
$updates = [
    1 => 'CASIO-MTP-1370D-1A2VDF-1.avif',
    2 => 'CASIO-MTP-1384D-7A2VDF-1.avif',
    3 => 'CASIO-MTP-1384L-1AVDF-0.avif',
    4 => 'AE-1200WHD-1AVDF.avif',
    5 => '2-orient-sun-and-moon-ra-as0105s30b.avif',
    6 => '3-orient-sun-and-moon-ra-as0106l30b.avif',
    7 => 'Review-dong-ho-Seiko-5-Sports-Field-SRPJ87K1-4.avif',
    8 => '2-koi-moonphase-k006-436-65-1-36-11-07.avif',
    9 => 'K004.153.64.14.53.11.054.avif',
    10 => 'k005-303-092-05-01-03-vs-k005-103-092-05-01-03.avif',
    11 => '1-titoni-cosmo-king-797797-s-696.avif',
    12 => '3-titoni-cosmo-king-797-s-719.avif',
    13 => '3-titoni-cosmo-king-797-sy-695.avif',
    14 => '2-titoni-airmaster-93808-s-259.avif',
    15 => '3-titoni-airmaster-93709-sy-385.avif',
    16 => 'D173TCM-4-2.avif',
    17 => 'D222RSV.avif',
    18 => 'Titoni-729-S-DB-307-4.avif',
    19 => 'Titoni-729-SY-DB-019-2.avif',
    20 => 'Titoni-729-G-DB-541-2.avif',
    21 => 'Titoni-729-SY-DB-695-2.avif'
];

foreach ($updates as $id => $image) {
    $sql = "UPDATE `products` SET image = '$image' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        echo "Cập nhật sản phẩm ID $id thành công -> $image<br>";
    } else {
        echo "Lỗi ID $id: " . mysqli_error($conn) . "<br>";
    }
}

echo "<p><a href='../home.php'>Quay lại trang chủ</a></p>";
?>
