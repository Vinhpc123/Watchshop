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
    .dashboard {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .dashboard .title {
        text-align: center;
        margin-bottom: 2rem;
        text-transform: uppercase;
        color: var #333 (--black);
        font-size: 4rem;
    }

    /* Grid layout */
    .box-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 25px;
    }

    /* Card box style */
    .box {
        background: #fff;
        border-radius: 16px;
        padding: 30px 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        transition: all 0.3s ease;
        border: 1px solid #eee;
    }

    .box:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
    }

    .box i {
        font-size: 2rem;
        color: #6c5ce7;
        margin-bottom: 15px;
    }

    .box h3 {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 10px 0;
        color: #2f3542;
    }

    .box p {
        background-color: #f1f2f6;
        color: #6c5ce7;
        font-weight: 600;
        padding: 10px 14px;
        border-radius: 8px;
        font-size: 1rem;
        display: inline-block;
        margin-top: 10px;
        transition: background 0.3s;
    }

    .box p:hover {
        background-color: #dcdde1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard .title {
            font-size: 2.2rem;
        }

        .box h3 {
            font-size: 1.8rem;
        }
    }

    @media (max-width: 480px) {
        .box {
            padding: 24px 14px;
        }

        .box h3 {
            font-size: 1.6rem;
        }

        .box p {
            font-size: 0.95rem;
        }
    }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- admin dashboard section starts  -->

    <section class="dashboard">

        <h1 class="title">Bảng điều khiển</h1>

        <div class="box-container">

            <div class="box">
                <?php
            $total_pendings = 0;
            $select_pending = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'pending'") or die('query failed');
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
            $select_completed = mysqli_query($conn, "SELECT total_price FROM `orders` WHERE payment_status = 'completed'") or die('query failed');
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

    </section>

    <!-- admin dashboard section ends -->









    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>