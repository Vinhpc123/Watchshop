<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

if(isset($_POST['update_order'])){

   $order_update_id = $_POST['order_id'];
   $update_payment = $_POST['update_payment'];
   mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
   $message[] = 'Trạng thái thanh toán đã được cập nhật!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

    <style>
    .table-container {
        overflow-x: auto;
        padding: 20px;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .orders-table thead {
        background-color: #6c3aad;
        color: white;
    }

    .orders-table th,
    .orders-table td {
        padding: 10px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 1.7rem;
    }


    .orders-table select,
    .orders-table input[type="submit"] {
        padding: 6px 10px;
        font-size: 13px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    .option-btn {
        background-color: #28a745;
        color: white;
        cursor: pointer;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
        padding: 6px 10px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
    }

    .delete-btn:hover,
    .option-btn:hover {
        opacity: 0.9;
    }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="orders">

        <h1 class="title">Đã đặt hàng</h1>

        <div class="table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tên</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Sản phẩm</th>
                        <th>Tổng</th>
                        <th>Thanh toán</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $select_orders = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY id DESC") or die('query failed');
                    if(mysqli_num_rows($select_orders) > 0){
                        while($fetch_orders = mysqli_fetch_assoc($select_orders)){
                    ?>
                    <tr>
                        <td><?php echo $fetch_orders['user_id']; ?></td>
                        <td><?php echo $fetch_orders['placed_on']; ?></td>
                        <td><?php echo $fetch_orders['name']; ?></td>
                        <td><?php echo $fetch_orders['number']; ?></td>
                        <td><?php echo $fetch_orders['email']; ?></td>
                        <td><?php echo $fetch_orders['address']; ?></td>
                        <td><?php echo $fetch_orders['total_products']; ?></td>
                        <td><?php echo number_format($fetch_orders['total_price'], 0, ',', '.'); ?> VNĐ</td>
                        <td><?php echo $fetch_orders['method']; ?></td>
                        <td>
                            <form method="post" style="display:flex; gap:4px;">
                                <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                                <select name="update_payment">
                                    <option selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                                    <!-- <option value="Đang duyệt">Đang duyệt</option> -->
                                    <option value="Thành công">Thành công</option>
                                </select>
                                <input type="submit" name="update_order" value="Cập nhật" class="option-btn">
                            </form>
                        </td>
                        <td>
                            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>"
                                onclick="return confirm('Bạn có muốn xóa đơn đặt hàng này?');"
                                class="delete-btn">Xóa</a>
                        </td>
                    </tr>
                    <?php }} else { ?>
                    <tr>
                        <td colspan="11">Chưa có đơn hàng nào được đặt!</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


    </section>










    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>