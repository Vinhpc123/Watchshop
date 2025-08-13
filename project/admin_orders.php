<?php
include 'config.php';
session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

// Cập nhật trạng thái thanh toán
if (isset($_POST['update_order'])) {
    $order_update_id = $_POST['order_id'];
    $update_payment = $_POST['update_payment'];
    mysqli_query($conn, "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'") or die('query failed');
    $message[] = 'Trạng thái thanh toán đã được cập nhật!';
}

// Xóa đơn hàng
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
    exit();
}

// Lấy giá trị tìm kiếm
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = "";
if (!empty($search)) {
    if (ctype_digit($search)) {
        $whereClause = "WHERE id = '$search' 
                        OR id LIKE '%$search%' 
                        OR name LIKE '%$search%' 
                        OR email LIKE '%$search%' 
                        OR number LIKE '%$search%'";
    } else {
        $whereClause = "WHERE name LIKE '%$search%' 
                        OR email LIKE '%$search%' 
                        OR number LIKE '%$search%'";
    }
}

// Phân trang
$orders_per_page = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $orders_per_page;

$total_orders_query = mysqli_query($conn, "SELECT * FROM `orders` $whereClause") or die('query failed');
$total_orders = mysqli_num_rows($total_orders_query);
$total_pages = ceil($total_orders / $orders_per_page);

// Lấy đơn hàng
$select_orders = mysqli_query($conn, "SELECT * FROM `orders` $whereClause ORDER BY id DESC LIMIT $start_from, $orders_per_page") or die('query failed');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
    /* Giữ nguyên style bảng của bạn */
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

    .orders-table th,
    .orders-table td {
        padding: 1.2rem 1rem;
        text-align: left;
        border: 1px solid #ccc;
        color: #000;
    }

    .orders-table th {
        background-color: #f0f0f0;
        font-size: 1.5rem;
        text-align: center;
    }

    .orders-table tbody tr:hover {
        background-color: #f2f2f2;
    }

    .option-btn,
    .delete-btn {
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 1.2rem;
        cursor: pointer;
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
    }

    .pagination a.active {
        background-color: #2196f3;
        color: white;
        font-weight: bold;
    }

    .pagination a:hover {
        background-color: #d5d5d5;
    }

    .search-box {
        text-align: right;
        margin: 1rem 3.5rem;
    }

    .search-box input {
        width: 30%;
        padding: 1rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1.5rem;
        outline: none;
        transition: border-color 0.2s;
        margin-bottom: 0.5rem;
    }

    .search-box button {
        padding: 1rem 1rem;
        border: none;
        border-radius: 8px;
        background: #3498db;
        color: #fff;
        cursor: pointer;
    }

    .search-box button:hover {
        background: #2980b9;
    }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="orders">
        <h1 class="title">Quản lý đơn hàng</h1>

        <!-- Form tìm kiếm -->
        <form method="get" class="search-box" style="margin: 1rem 3.5rem; text-align: left;">
            <input type="text" name="search" placeholder="Tìm theo ID, tên, email, SĐT..."
                value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Tìm kiếm</button>
            <select name="limit" onchange="this.form.submit()">
                <option value="5" <?php if ($orders_per_page == 5) echo 'selected'; ?>>5</option>
                <option value="10" <?php if ($orders_per_page == 10) echo 'selected'; ?>>10</option>
                <option value="20" <?php if ($orders_per_page == 20) echo 'selected'; ?>>20</option>
                <option value="50" <?php if ($orders_per_page == 50) echo 'selected'; ?>>50</option>
            </select>
            <input type="hidden" name="page" value="1">
        </form>

        <div class="table-container">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Ngày đặt</th>
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
                    <?php if (mysqli_num_rows($select_orders) > 0): ?>
                    <?php while ($fetch_orders = mysqli_fetch_assoc($select_orders)): ?>
                    <tr>
                        <td><?php echo $fetch_orders['id']; ?></td>
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
                                onclick="return confirm('Xóa đơn này?');" class="delete-btn">Xóa</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="11" style="text-align:center;">Không tìm thấy đơn hàng!</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Phân trang -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                <a
                    href="?page=<?php echo $page-1; ?>&limit=<?php echo $orders_per_page; ?>&search=<?php echo urlencode($search); ?>">Trước</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>&limit=<?php echo $orders_per_page; ?>&search=<?php echo urlencode($search); ?>"
                    class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                <a
                    href="?page=<?php echo $page+1; ?>&limit=<?php echo $orders_per_page; ?>&search=<?php echo urlencode($search); ?>">Sau</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <script src="js/admin_script.js"></script>
</body>

</html>