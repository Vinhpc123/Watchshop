<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
    .dashboard .box-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1rem 3rem;
    }

    .dashboard .box-container .box {
        background-color: var(--white);
        border-radius: var(--radius);
        padding: 2rem;
        text-align: center;
        box-shadow: var(--shadow);
        transition: all 0.3s ease;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        border-radius: 12px;

    }

    .dashboard .box-container .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .dashboard .box-container .box h3 {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--purple);
        margin-bottom: .5rem;
    }

    .dashboard .box-container .box p {
        font-size: 1.4rem;
        color: var(--gray-text);
    }

    /* Biểu đồ & bảng */
    .dashboard-analytics {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto 4rem;
        padding: 0 1rem;
    }

    .chart-area,
    .best-sellers {
        background-color: var(--white);
        padding: 2rem;
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        border-radius: 12px;

    }

    .chart-area {
        flex: 2;
    }

    .best-sellers {
        flex: 1;
    }

    .best-sellers h2,
    .chart-area h2 {
        font-size: 1.8rem;
        margin-bottom: 1.2rem;
        font-weight: bold;
    }

    .product-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .product-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.8rem 0;
        border-bottom: 1px solid #eee;
        font-size: 1.5rem;
        color: #333;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard .box-container {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (max-width: 500px) {
        .dashboard .box-container {
            grid-template-columns: 1fr;
        }

        .dashboard-analytics {
            flex-direction: column;
        }
    }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- admin dashboard section starts  -->
    <section class="dashboard">

        <h1 class="title">Bảng điều khiển</h1>

        <div class="box-container">

            <div class="box">
                <?php
                    $total_pendings = 0;
                    $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'Đang duyệt'") or die('query failed');
                    if(mysqli_num_rows($select_pending) > 0){
                    while($fetch_pendings = mysqli_fetch_assoc($select_pending)){
                        $total_price = $fetch_pendings['total_price'];
                        $total_pendings += $total_price;
                    };
                    };
                ?>
                <h3><?php echo number_format($total_pendings, 0, ',', '.'); ?> VNĐ</h3>
                <p>Tổng tiền đang xử lý</p>
            </div>

            <div class="box">
                <?php
                    $total_completed = 0;
                    $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'Thành công'") or die('query failed');
                    if(mysqli_num_rows($select_completed) > 0){
                    while($fetch_completed = mysqli_fetch_assoc($select_completed)){
                        $total_price = $fetch_completed['total_price'];
                        $total_completed += $total_price;
                    };
                    };
                ?>
                <h3><?php echo number_format($total_completed, 0, ',', '.'); ?> VNĐ</h3>
                <p>Thanh toán thành công</p>
            </div>

            <div class="box">
                <?php 
                    $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
                    $number_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3><?php echo $number_of_orders; ?></h3>
                <p>Tổng đơn hàng</p>
            </div>

            <div class="box">
                <?php 
                    $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                    $number_of_products = mysqli_num_rows($select_products);
                ?>
                <h3><?php echo $number_of_products; ?></h3>
                <p>Tổng sản phẩm</p>
            </div>

            <div class="box">
                <?php 
                    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'user'") or die('query failed');
                    $number_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?php echo $number_of_users; ?></h3>
                <p>Tài khoản User</p>
            </div>

            <div class="box">
                <?php 
                    $select_admins = mysqli_query($conn, "SELECT * FROM `users` WHERE user_type = 'admin'") or die('query failed');
                    $number_of_admins = mysqli_num_rows($select_admins);
                ?>
                <h3><?php echo $number_of_admins; ?></h3>
                <p>Tài khoản Admin</p>
            </div>

            <div class="box">
                <?php 
                    $select_account = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                    $number_of_account = mysqli_num_rows($select_account);
                ?>
                <h3><?php echo $number_of_account; ?></h3>
                <p>Tổng tài khoản</p>
            </div>

            <div class="box">
                <?php 
                    $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                    $number_of_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?php echo $number_of_messages; ?></h3>
                <p>Thông báo mới</p>
            </div>

        </div>


        <div class="dashboard-analytics">
            <div class="chart-area">
                <h2>Biểu đồ Doanh Thu</h2>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="best-sellers">
                <h2>Sản phẩm bán chạy</h2>
                <ul class="product-list">
                    <li>
                        <span>1. iPhone 15 Pro Max</span>
                        <span>120 cái</span>
                    </li>
                    <li>
                        <span>2. Laptop Dell XPS</span>
                        <span>87 cái</span>
                    </li>
                    <li>
                        <span>3. AirPods Pro</span>
                        <span>62 cái</span>
                    </li>
                </ul>
            </div>
        </div>

    </section>

    <!-- admin dashboard section ends -->

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>



    <!-- code minh họa -->
    <script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
            datasets: [{
                label: 'Doanh thu',
                data: [5000000, 8000000, 12000000, 6000000, 14000000, 10000000],
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#333'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.formattedValue.replace(
                                /\B(?=(\d{3})+(?!\d))/g, ".") + ' VNĐ';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' VNĐ';
                        },
                        color: '#6b7280'
                    }
                },
                x: {
                    ticks: {
                        color: '#6b7280'
                    }
                }
            }
        }
    });
    </script>

</body>

</html>