<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    $message[] = 'Trạng thái thanh toán đã được cập nhật!';
}

if (isset($_GET['delete'])) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
    .table-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow-x: auto;
        padding: 1rem;
        max-width: 95%;
        margin: 0 auto;
    }


    .orders-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1.5rem;
        min-width: 1200px;
    }

    .orders-table thead {
        background-color: #f9fafb;
    }

    .orders-table th,
    .orders-table td {
        padding: 1.2rem 1rem;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
        color: #000;
        border: 1px solid #ccc;
    }

    .orders-table th {
        background-color: #f0f0f0;
        font-size: 1.5rem;
    }

    .orders-table tbody tr:hover {
        background-color: #f2f2f2;
        transition: background 0.3s ease;
    }

    .option-btn,
    .delete-btn {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-bottom: 10px;
    }

    .option-btn {
        background: #3498db;
        color: #fff;
        border: none;
    }

    .option-btn:hover {
        background: #2980b9;
    }

    .delete-btn {
        background: #e74c3c;
        color: #fff;
        text-decoration: none;
    }

    .delete-btn:hover {
        background: #c0392b;
    }

    select {
        display: inline-block;
        padding: 6px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
    }

    .status-success {
        background-color: #e0f8e8;
        color: #28a745;
    }

    .status-pending {
        background-color: #fff3e0;
        color: #ff9800;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .pagination a {
        padding: 10px 16px;
        background-color: #f1f1f1;
        color: #333;
        border-radius: 10px;
        text-decoration: none;
        font-size: 1.2rem;
        transition: background 0.3s ease;
    }

    .pagination a.active {
        background-color: #2196f3;
        color: white;
        font-weight: bold;
    }

    .pagination a:hover {
        background-color: #d5d5d5;
    }

    @media (max-width: 768px) {
        .orders-table {
            font-size: 1.2rem;
            min-width: 100%;
        }

        .orders .title {
            font-size: 2rem;
        }

        .option-btn,
        .delete-btn {
            font-size: 1rem;
            padding: 5px 10px;
        }

        .table-container {
            padding: 0.5rem;
        }
    }
    </style>
</head>

<body>
    <?php include 'admin_header.php'; ?>

    <section class="orders">
        <h1 class="title">Đã đặt hàng</h1>

        <?php
        $orders_per_page = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $start_from = ($page - 1) * $orders_per_page;

        $total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `orders`"));
        $total_pages = ceil($total_orders / $orders_per_page);
        ?>

        <form method="get" style="margin: 1rem 3.5rem; text-align: right;">
            Hiển thị:
            <select name="limit" onchange="this.form.submit()">
                <option value="5" <?php if ($orders_per_page == 5) echo 'selected'; ?>>5</option>
                <option value="10" <?php if ($orders_per_page == 10) echo 'selected'; ?>>10</option>
                <option value="20" <?php if ($orders_per_page == 20) echo 'selected'; ?>>20</option>
                <option value="50" <?php if ($orders_per_page == 50) echo 'selected'; ?>>50</option>
            </select> đơn mỗi trang
            <input type="hidden" name="page" value="1">
        </form>


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
                    $select_orders = mysqli_query($conn, "SELECT * FROM `orders` ORDER BY id DESC LIMIT $start_from, $orders_per_page") or die('query failed');
                    if (mysqli_num_rows($select_orders) > 0) {
                        while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
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
                                <select name="update_payment"
                                    class="<?php echo ($fetch_orders['payment_status'] == 'Thành công') ? 'status-success' : 'status-pending'; ?>">
                                    <option selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
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

            <div class="pagination">
                <?php if ($page > 1): ?>
                <a href="admin_orders.php?page=<?php echo $page - 1; ?>&limit=<?php echo $orders_per_page; ?>">Trước</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="admin_orders.php?page=<?php echo $i; ?>&limit=<?php echo $orders_per_page; ?>"
                    class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <a href="admin_orders.php?page=<?php echo $page + 1; ?>&limit=<?php echo $orders_per_page; ?>">Sau</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="js/admin_script.js"></script>
</body>

</html>