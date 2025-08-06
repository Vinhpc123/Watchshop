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
        min-height: 400px;
        position: relative;
    }

    .chart-area canvas {
        max-height: 350px !important;
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

        <?php
        // Thiết lập múi giờ Việt Nam
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $revenue_data = array();
        $hour_labels = array();
        
        $today = date('Y-m-d');
        $current_hour = (int)date('H');
        
        for($hour = 0; $hour < 24; $hour++) {
            $hour_formatted = sprintf('%02d', $hour);
            
            
            $query = "SELECT SUM(total_price) as revenue FROM `orders` 
                     WHERE DATE(placed_on) = '$today' 
                     AND HOUR(placed_on) = $hour
                     AND payment_status = 'Thành công'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            
            $revenue = $row['revenue'] ? (int)$row['revenue'] : 0;
            $revenue_data[] = $revenue;
            
            if ($hour == $current_hour) {
                $hour_labels[] = $hour_formatted . ":00 (Hiện tại)";
            } else {
                $hour_labels[] = $hour_formatted . ":00";
            }
        }
        
        // Chuyển mảng PHP thành JSON cho JavaScript
        $revenue_json = json_encode($revenue_data);
        $labels_json = json_encode($hour_labels);
        
        // Lấy thông tin thời gian hiện tại
        $current_time = date('H:i:s');
        $current_date = date('d/m/Y');
        $day_of_week = date('l');
        $day_of_week_vn = array(
            'Monday' => 'Thứ Hai',
            'Tuesday' => 'Thứ Ba', 
            'Wednesday' => 'Thứ Tư',
            'Thursday' => 'Thứ Năm',
            'Friday' => 'Thứ Sáu',
            'Saturday' => 'Thứ Bảy',
            'Sunday' => 'Chủ Nhật'
        );
        ?>

        <div class="dashboard-analytics">
            <div class="chart-area">
                <h2>Biểu đồ Doanh Thu</h2>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="best-sellers">
                <h2>Sản phẩm bán chạy (Top 5)</h2>
                <ul class="product-list">
                    <?php
                    // Lấy top 5 sản phẩm bán chạy nhất
                    $best_sellers_query = "SELECT total_products, 
                                          SUM(CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(total_products, '(', -1), ')', 1) AS UNSIGNED)) as total_sold
                                          FROM `orders` 
                                          WHERE payment_status = 'Thành công' 
                                          GROUP BY SUBSTRING_INDEX(total_products, '(', 1)
                                          ORDER BY total_sold DESC 
                                          LIMIT 5";
                    
                    $best_sellers_result = mysqli_query($conn, $best_sellers_query);
                    $rank = 1;
                    
                    if(mysqli_num_rows($best_sellers_result) > 0) {
                        while($product = mysqli_fetch_assoc($best_sellers_result)) {
                            $product_name = trim(str_replace(',', '', explode('(', $product['total_products'])[0]));
                            if(!empty($product_name) && $product_name != '') {
                                echo '<li>';
                                echo '<span>' . $rank . '. ' . htmlspecialchars($product_name) . '</span>';
                                echo '<span>' . $product['total_sold'] . ' cái</span>';
                                echo '</li>';
                                $rank++;
                            }
                        }
                    } else {
                        echo '<li><span>Chưa có dữ liệu bán hàng</span><span>0 cái</span></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>

    </section>

    <!-- admin dashboard section ends -->

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>



    <!-- code cải tiến với múi giờ Việt Nam -->
    <script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: hourLabels,
            datasets: [{
                label: 'Doanh thu theo giờ (VNĐ)',
                data: revenueData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: pointRadius,
                pointHoverRadius: 8,
                pointBackgroundColor: pointColors,
                pointBorderColor: pointBorderColors,
                pointBorderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: '#333',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    borderColor: '#3b82f6',
                    borderWidth: 1,
                    callbacks: {
                        title: function(context) {
                            const hour = context[0].label;
                            const isCurrentHour = context[0].dataIndex === currentHour;
                            return hour + (isCurrentHour ? ' ⭐' : '');
                        },
                        label: function(context) {
                            const value = new Intl.NumberFormat('vi-VN').format(context.parsed.y);
                            return 'Doanh thu: ' + value + ' VNĐ';
                        },
                        afterLabel: function(context) {
                            if (context.dataIndex === currentHour) {
                                return '🕐 Giờ hiện tại';
                            }
                            return '';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000) {
                                return (value / 1000000).toFixed(1) + 'M';
                            } else if (value >= 1000) {
                                return (value / 1000).toFixed(1) + 'K';
                            }
                            return new Intl.NumberFormat('vi-VN').format(value);
                        },
                        color: '#6b7280',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        color: function(context) {
                            // Làm nổi bật nhãn giờ hiện tại
                            return context.index === currentHour ? '#ff6b6b' : '#6b7280';
                        },
                        font: {
                            size: 10,
                            weight: function(context) {
                                return context.index === currentHour ? 'bold' : 'normal';
                            }
                        },
                        maxTicksLimit: 12,
                        callback: function(value, index) {
                            // Hiển thị tất cả nhãn nhưng làm nổi bật giờ hiện tại
                            const label = this.getLabelForValue(value);
                            if (index === currentHour) {
                                return '⭐ ' + label.replace(' (Hiện tại)', '');
                            }
                            return index % 2 === 0 ? label : '';
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });
    </script>

</body>

</html>