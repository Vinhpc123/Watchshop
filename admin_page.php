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
        $day_labels = array();

        // Lấy doanh thu theo ngày - mặc định 7 ngày gần nhất (bao gồm hôm nay)
        $days = 7; // bạn có thể thay đổi thành 30 để hiển thị 30 ngày
        $today = date('Y-m-d');

        // Build dates from oldest -> newest
        $dates = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $dates[] = date('Y-m-d', strtotime("-{$i} days"));
        }

        $current_day_index = null;
        foreach ($dates as $idx => $d) {
            $query = "SELECT SUM(total_price) as revenue FROM `orders` 
                     WHERE DATE(placed_on) = '$d'
                     AND payment_status = 'Thành công'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_assoc($result);
            $revenue = $row['revenue'] ? (int)$row['revenue'] : 0;
            $revenue_data[] = $revenue;

            // Label format: dd/mm
            $day_labels[] = date('d/m', strtotime($d));

            if ($d === $today) {
                $current_day_index = count($day_labels) - 1;
            }
        }

        // Chuyển mảng PHP thành JSON cho JavaScript
        $revenue_json = json_encode($revenue_data);
        $labels_json = json_encode($day_labels);

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
                <p style="color: #666; font-size: 14px; margin-bottom: 15px;">
                    📅 <?php echo $day_of_week_vn[$day_of_week] . ', ' . $current_date; ?> |
                    🕐 Giờ hiện tại: <?php echo $current_time; ?> (GMT+7)
                </p>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="best-sellers">
                <h2>Sản phẩm bán chạy (Top 5)</h2>
                <ul class="product-list">
                    <?php
                    // Lấy tất cả đơn hàng thành công và xử lý bằng PHP
                    $orders_query = "SELECT total_products FROM `orders` WHERE payment_status = 'Thành công'";
                    $orders_result = mysqli_query($conn, $orders_query);
                    
                    $product_counts = array();
                    
                    if(mysqli_num_rows($orders_result) > 0) {
                        while($order = mysqli_fetch_assoc($orders_result)) {
                            $total_products = $order['total_products'];
                            
                            // Tách các sản phẩm bằng dấu phẩy
                            $products = explode(',', $total_products);
                            
                            foreach($products as $product) {
                                $product = trim($product);
                                
                                // Skip empty strings
                                if(empty($product)) continue;
                                
                                // Extract product name và quantity từ format: "Product Name (quantity)"
                                if(preg_match('/(.+?)\s*\((\d+)\)/', $product, $matches)) {
                                    $product_name = trim($matches[1]);
                                    $quantity = (int)$matches[2];
                                    
                                    if(!empty($product_name)) {
                                        if(isset($product_counts[$product_name])) {
                                            $product_counts[$product_name] += $quantity;
                                        } else {
                                            $product_counts[$product_name] = $quantity;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    // Sort by quantity descending và lấy top 5
                    arsort($product_counts);
                    $top_products = array_slice($product_counts, 0, 5, true);
                    
                    $rank = 1;
                    if(!empty($top_products)) {
                        foreach($top_products as $product_name => $total_quantity) {
                            echo '<li>';
                            echo '<span>' . $rank . '. ' . htmlspecialchars($product_name) . '</span>';
                            echo '<span>' . $total_quantity . ' cái</span>';
                            echo '</li>';
                            $rank++;
                        }
                    } else {
                        echo '<li><span>Chưa có dữ liệu bán hàng</span><span>0 cái</span></li>';
                    }
                    ?>
                </ul>
                <!-- Biểu đồ: Sản phẩm mới đặt (7 ngày gần nhất) -->
                <?php
                // Tính sản phẩm được đặt trong 7 ngày gần nhất (đặt trước khi render list)
                $recent_query = "SELECT total_products FROM `orders` WHERE payment_status = 'Thành công' AND placed_on >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                $recent_result = mysqli_query($conn, $recent_query);
                $recent_counts = array();
                if($recent_result && mysqli_num_rows($recent_result) > 0) {
                    while($order = mysqli_fetch_assoc($recent_result)) {
                        $total_products = $order['total_products'];
                        $products = explode(',', $total_products);
                        foreach($products as $product) {
                            $product = trim($product);
                            if(empty($product)) continue;
                            if(preg_match('/(.+?)\s*\((\d+)\)/', $product, $m)) {
                                $pname = trim($m[1]);
                                $qty = (int)$m[2];
                                if($pname === '') continue;
                                if(isset($recent_counts[$pname])) $recent_counts[$pname] += $qty; else $recent_counts[$pname] = $qty;
                            }
                        }
                    }
                }
                // Lấy top 5 recent
                arsort($recent_counts);
                $recent_top = array_slice($recent_counts, 0, 5, true);
                ?>
                <div style="display:flex; align-items:center; justify-content:space-between; gap:10px;">
                    <h2 style="margin-top:1.5rem">Sản phẩm mới đặt (7 ngày)</h2>
                    <button id="refresh-recent" class="option-btn" style="margin-top:1.5rem; padding:6px 12px; font-size:14px">Refresh</button>
                </div>
                <div id="recent-products-container" style="margin-top:0.5rem">
                    <?php
                    if (!empty($recent_top)) {
                        echo '<ul class="product-list">';
                        $i = 1;
                        foreach ($recent_top as $name => $qty) {
                            if ($i > 5) break;
                            echo '<li><span>' . $i . '. ' . htmlspecialchars($name) . '</span><span>' . $qty . ' cái</span></li>';
                            $i++;
                        }
                        echo '</ul>';
                    } else {
                        echo '<ul class="product-list"><li><span>Chưa có đơn hàng trong 7 ngày</span><span>0 cái</span></li></ul>';
                    }
                    ?>
                </div>
                <?php
                // Tính sản phẩm được đặt trong 7 ngày gần nhất
                $recent_query = "SELECT total_products FROM `orders` WHERE payment_status = 'Thành công' AND placed_on >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
                $recent_result = mysqli_query($conn, $recent_query);
                $recent_counts = array();
                if(mysqli_num_rows($recent_result) > 0) {
                    while($order = mysqli_fetch_assoc($recent_result)) {
                        $total_products = $order['total_products'];
                        $products = explode(',', $total_products);
                        foreach($products as $product) {
                            $product = trim($product);
                            if(empty($product)) continue;
                            if(preg_match('/(.+?)\s*\((\d+)\)/', $product, $m)) {
                                $pname = trim($m[1]);
                                $qty = (int)$m[2];
                                if($pname === '') continue;
                                if(isset($recent_counts[$pname])) $recent_counts[$pname] += $qty; else $recent_counts[$pname] = $qty;
                            }
                        }
                    }
                }
                // Lấy top 5 recent
                arsort($recent_counts);
                $recent_top = array_slice($recent_counts, 0, 5, true);
                $recent_labels = array_keys($recent_top);
                $recent_values = array_values($recent_top);
                $recent_labels_json = json_encode($recent_labels);
                $recent_values_json = json_encode($recent_values);
                // Debug: in ra mảng recent_top khi truy cập với ?debug_recent=1
                if (isset($_GET['debug_recent']) && $_GET['debug_recent'] == '1') {
                    echo '<pre style="font-size:12px; background:#fff; padding:10px; border:1px solid #eee; margin-top:10px;">DEBUG recent_top:\n' . htmlspecialchars(print_r($recent_top, true)) . '</pre>';
                }
                ?>
            </div>
        </div>

    </section>

    <!-- admin dashboard section ends -->

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>



    <!-- code cải tiến với múi giờ Việt Nam -->
    <script>
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');

    // Sử dụng dữ liệu thực từ PHP (theo ngày)
    const revenueData = <?php echo $revenue_json; ?>;
    const dayLabels = <?php echo $labels_json; ?>;
    const currentDayIndex = <?php echo json_encode($current_day_index !== null ? $current_day_index : -1); ?>;

    // Tạo màu cho các điểm - làm nổi bật ngày hiện tại
    const pointColors = dayLabels.map((label, index) => {
        return index === currentDayIndex ? '#ff6b6b' : '#3b82f6';
    });

    const pointRadius = dayLabels.map((label, index) => {
        return index === currentDayIndex ? 8 : 4;
    });

    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: dayLabels,
            datasets: [{
                label: 'Doanh thu theo ngày (VNĐ)',
                data: revenueData,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: pointRadius,
                pointHoverRadius: 8,
                pointBackgroundColor: pointColors,
                pointBorderColor: '#ffffff',
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
                            const day = context[0].label;
                            const isCurrent = context[0].dataIndex === currentDayIndex;
                            return day + (isCurrent ? ' (Hôm nay)' : '');
                        },
                        label: function(context) {
                            const value = new Intl.NumberFormat('vi-VN').format(context.parsed.y);
                            return 'Doanh thu: ' + value + ' VNĐ';
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
                            return context.index === currentDayIndex ? '#ff6b6b' : '#6b7280';
                        },
                        font: {
                            size: 11,
                            weight: function(context) {
                                return context.index === currentDayIndex ? 'bold' : 'normal';
                            }
                        },
                        maxTicksLimit: 10
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            }
        }
    });

    // Thêm auto-refresh mỗi 5 phút
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 phút = 300000ms
    </script>
    <script>
    // AJAX loader cho phần Sản phẩm mới đặt
    (function(){
        const container = document.getElementById('recent-products-container');
        const btn = document.getElementById('refresh-recent');
        function loadRecent() {
            fetch('recent_products_fragment.php')
                .then(r => r.text())
                .then(html => { container.innerHTML = html; })
                .catch(err => { console.error(err); });
        }
        if (btn) btn.addEventListener('click', loadRecent);
        // load once on page load to ensure fresh data
        loadRecent();
    })();
    </script>

    

</body>

</html>