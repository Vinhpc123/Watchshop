<?php

include 'config.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập hoặc báo lỗi
    header('Location: login.php');
    exit(); // Dừng chương trình ngay sau khi chuyển hướng
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
    /* style.css */
    body {
        font-family: 'Roboto', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .heading {
        background-color: #f5f5f5;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .heading h3 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .heading p {
        margin: 5px 0 0;
        color: #666;
    }

    .placed-orders {
        padding: 20px;
    }

    .title {
        font-size: 4rem;
        margin-bottom: 30px;
        text-align: center;
        color: #333;
    }

    .order-container {
        display: flex;
        flex-direction: column;
        gap: 20px;
        padding: 1rem 30rem;

    }

    .order-box {
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .order-info {
        display: flex;
        flex-direction: column;
    }

    .order-details p {
        margin: 5px 0;
        font-size: 2rem;

    }

    .order-details span {
        font-weight: 500;
    }

    .payment-status {
        font-weight: bold;
        padding: 2px 5px;
        border-radius: 4px;
    }

    .payment-status.pending {
        color: #ff6f6f;
        background-color: #ffe5e5;
    }

    .payment-status.completed {
        color: #4caf50;
        background-color: #e8f5e9;
    }



    /* ...existing code... */
    .order-box {
        background: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        padding: 20px 24px;
        transition: box-shadow 0.2s;
    }

    .order-box:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
    }

    .order-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px dashed #ddd;
        padding-bottom: 10px;
        margin-bottom: 14px;
    }

    .order-header i {
        font-size: 2.2rem;
        color: #007bff;
        margin-right: 10px;
    }

    .order-date {
        font-size: 1.7rem;
        color: #888;
        margin-right: 10px;
    }

    .order-status {
        font-size: 1.2rem;
        font-weight: bold;
        padding: 3px 10px;
        border-radius: 5px;
    }

    .order-status.pending {
        background: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }

    .order-status.completed {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .order-details-grid {
        display: flex;
        gap: 40px;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .order-details-grid>div {
        flex: 1 1 220px;
    }

    .order-details-grid p {
        font-size: 1.7rem;
        margin: 12px 50px;
    }

    .order-total {
        color: #e53935;
        font-size: 1.7rem;
        font-weight: bold;
        margin-top: 10px;
    }

    /* ...existing code... */
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="placed-orders">
        <h1 class="title">Đơn đặt hàng</h1>
        <div class="order-container">
            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id' ORDER BY id DESC") or die('query failed');
            if (mysqli_num_rows($order_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
            ?>
            <div class="order-box">
                <div class="order-header">
                    <i class="fas fa-receipt"></i>
                    <div>
                        <span
                            class="order-date"><?php echo date('d/m/Y', strtotime($fetch_orders['placed_on'])); ?></span>
                        <span
                            class="order-status <?php echo ($fetch_orders['payment_status'] == 'Đang duyệt') ? 'pending' : 'completed'; ?>">
                            <?php echo $fetch_orders['payment_status']; ?>
                        </span>
                    </div>
                </div>
                <div class="order-details-grid">
                    <div>
                        <p><b>Khách hàng:</b> <?php echo $fetch_orders['name']; ?></p>
                        <p><b>Điện thoại:</b> <?php echo $fetch_orders['number']; ?></p>
                        <p><b>Email:</b> <?php echo $fetch_orders['email']; ?></p>
                        <p><b>Địa chỉ:</b> <?php echo $fetch_orders['address']; ?></p>
                    </div>
                    <div>
                        <p><b>Phương thức:</b> <?php echo $fetch_orders['method']; ?></p>
                        <p><b>Sản phẩm:</b> <?php echo $fetch_orders['total_products']; ?></p>
                        <p class="order-total"><b>Tổng:</b>
                            <?php echo number_format($fetch_orders['total_price'], 0, ',', '.'); ?> VNĐ</p>
                    </div>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="empty">Chưa có đơn hàng nào!</p>';
            }
            ?>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <!-- Custom JS File Link -->
    <script src="js/script.js"></script>
</body>

</html>