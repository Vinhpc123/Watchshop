<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];
if (!isset($admin_id)) {
   header('location:login.php');
}

// Thêm sản phẩm
if (isset($_POST['add_product'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = $_POST['price'];
   $image = $_FILES['image']['name'];
   $image_tmp = $_FILES['image']['tmp_name'];
   $image_size = $_FILES['image']['size'];
   $folder = 'uploaded_img/' . $image;

   $check = mysqli_query($conn, "SELECT name FROM products WHERE name='$name'");
   if (mysqli_num_rows($check) > 0) {
      $message[] = 'Sản phẩm đã tồn tại';
   } else {
      if ($image_size > 2000000) {
         $message[] = 'Hình ảnh quá lớn';
      } else {
         move_uploaded_file($image_tmp, $folder);
         mysqli_query($conn, "INSERT INTO products(name, price, image) VALUES('$name', '$price', '$image')");
         $message[] = 'Đã thêm sản phẩm';
      }
   }
}

// Xóa sản phẩm
if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   $img = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM products WHERE id='$id'"));
   unlink('uploaded_img/' . $img['image']);
   mysqli_query($conn, "DELETE FROM products WHERE id='$id'");
   header('location:admin_products.php');
}

// Cập nhật sản phẩm
if (isset($_POST['update_product'])) {
   $id = $_POST['update_id'];
   $name = $_POST['update_name'];
   $price = $_POST['update_price'];
   $old_img = $_POST['update_old_image'];

   mysqli_query($conn, "UPDATE products SET name='$name', price='$price' WHERE id='$id'");

   if (!empty($_FILES['update_image']['name'])) {
      $new_img = $_FILES['update_image']['name'];
      $tmp = $_FILES['update_image']['tmp_name'];
      $size = $_FILES['update_image']['size'];
      if ($size <= 2000000) {
         move_uploaded_file($tmp, 'uploaded_img/' . $new_img);
         mysqli_query($conn, "UPDATE products SET image='$new_img' WHERE id='$id'");
         unlink('uploaded_img/' . $old_img);
      }
   }

   header('location:admin_products.php');
}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
    /* Ẩn spinner trong input type=number (Chrome, Safari, Edge) */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Ẩn spinner trong Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .container {
        width: 95%;
        max-width: 1200px;
        margin: auto;
    }

    /* Form thêm sản phẩm */
    .add-products form,
    .edit-product-form form {
        background: #fff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        max-width: 600px;
        margin: 20px auto;
    }

    .edit-product-form {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }

    .edit-product-form form {
        background: #fff;
        width: 90%;
        max-width: 500px;
        padding: 30px;
        border-radius: 12px;
        position: relative;
    }

    .box {
        width: 100%;
        padding: 14px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1.5rem;
    }

    .btn {
        width: 100%;
        padding: 14px;
        background: #8e44ad;
        color: white;
        border: none;
        font-weight: 600;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    a#close-update {
        background: #2980b9;
        text-align: center;
    }

    a#close-update:hover {
        background: var(--black);
    }

    .product-list {
        background: #fff;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin: 30px auto;
    }

    .top-bar,
    .filter-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 10px;
    }

    .filter-left {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-left select {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 0.95rem;
    }

    .top-bar h2 {
        font-size: 1.8rem;
        color: #34495e;
    }

    .actions a,
    .custom-btn {
        padding: 10px 16px;
        background: #2980b9;
        color: #fff;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        margin-left: 10px;
        transition: 0.3s;
    }

    .actions a.add-btn {
        background: #8e44ad;
    }

    .product-table {
        width: 100%;
        border-collapse: collapse;
    }

    .product-table th,
    .product-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #ddd;
        font-size: 1.5rem;
        text-align: center;

    }

    .product-table th {
        background-color: #f0f0f0;
        font-weight: bold;
        color: #000;
    }

    .thumb {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #ccc;
    }

    .status.enabled {
        color: #27ae60;
        font-weight: 600;
    }

    .option-btn,
    .delete-btn {
        padding: 8px 12px;
        border-radius: 6px;
        font-size: 1.4rem;
        text-decoration: none;
        color: white;
        margin-right: 5px;
        margin-bottom: 10px;
    }

    .option-btn {
        background-color: #2980b9;
    }

    .delete-btn {
        background-color: #e74c3c;
    }

    .edit-product-form img {
        width: 100%;
        max-width: 300px;
        height: 200px;
        object-fit: contain;
        margin: 0 auto 15px auto;
        display: block;
        border-radius: 10px;
        background: #f5f5f5;
        border: 1px solid #ccc;
    }

    .filter-bar label,
    .filter-bar span,
    .add-btn,
    .custom-btn {
        font-size: 1.2rem;
    }

    @media (max-width: 768px) {

        .top-bar,
        .filter-bar {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .product-table {
            font-size: 0.9rem;
        }

        .actions a,
        .custom-btn {
            width: 100%;
            margin: 8px 0 0 0;
        }
    }
    </style>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <div class="container">
        <section class="add-products" id="add">
            <h2 class="title">Thêm sản phẩm mới</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Tên sản phẩm" class="box" required>
                <input type="number" name="price" placeholder="Giá sản phẩm" class="box" required>
                <input type="file" name="image" accept="image/*" class="box" required>
                <input type="submit" name="add_product" value="Thêm Sản Phẩm" class="btn">
            </form>
        </section>

        <section class="product-list">
            <div class="top-bar">
                <h2>Danh sách sản phẩm</h2>
                <div class="actions">
                    <button class="custom-btn">Nút tùy chỉnh</button>
                    <a href="#add" class="add-btn">+ Thêm sản phẩm</a>
                </div>
            </div>

            <div class="filter-bar">
                <div class="filter-left">
                    <label for="per-page">Hiển thị:</label>
                    <select id="per-page" name="per_page">
                        <option>10</option>
                        <option selected>20</option>
                        <option>50</option>
                    </select>
                </div>
                <?php
                  $select_products = mysqli_query($conn, "SELECT * FROM products");
                  ?>
                <span>Tìm thấy <?php echo mysqli_num_rows($select_products); ?> sản phẩm</span>
            </div>

            <table class="product-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($select_products)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><img src="uploaded_img/<?php echo $row['image']; ?>" class="thumb" alt=""></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><span class="status enabled">Hiện</span></td>
                        <td>
                            <a href="admin_products.php?update=<?php echo $row['id']; ?>" class="option-btn">Sửa</a>
                            <a href="admin_products.php?delete=<?php echo $row['id']; ?>" class="delete-btn"
                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <?php if (isset($_GET['update'])):
            $id = $_GET['update'];
            $data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM products WHERE id='$id'"));
         ?>
        <section class="edit-product-form">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_id" value="<?php echo $data['id']; ?>">
                <input type="hidden" name="update_old_image" value="<?php echo $data['image']; ?>">
                <img id="preview" src="uploaded_img/<?php echo $data['image']; ?>" alt="">
                <input type="text" name="update_name" value="<?php echo $data['name']; ?>" class="box" required>
                <input type="number" name="update_price" value="<?php echo $data['price']; ?>" class="box" required>
                <input type="file" name="update_image" accept="image/*" class="box" onchange="previewImage(event)">
                <input type="submit" name="update_product" value="Cập nhật sản phẩm" class="btn">
                <a href="admin_products.php" id="close-update" class="btn">Hủy</a>
            </form>
        </section>
        <?php endif; ?>
    </div>

    <script src="js/admin_script.js"></script>
    <script>
    document.querySelector('#close-update').onclick = () => {
        document.querySelector('.edit-product-form').style.display = 'none';
        window.location.href = 'admin_products.php';
    }
    </script>

</body>

</html>