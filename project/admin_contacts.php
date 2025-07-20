<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
};

if (isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
    <style>
    .table-container {
        overflow-x: auto;
        padding: 20px;
    }

    .messages-table {
        width: 100%;
        min-width: 800px;
        /* Đảm bảo bảng không quá nhỏ */
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        overflow: hidden;
        table-layout: fixed;
    }

    .messages-table thead {
        background-color: #6c3aad;
        color: white;
    }

    .messages-table th,
    .messages-table td {
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        font-size: 1.6rem;
    }

    .messages-table th:nth-child(1),
    .messages-table td:nth-child(1) {
        width: 8%;
        /* User ID */
    }

    .messages-table th:nth-child(2),
    .messages-table td:nth-child(2) {
        width: 15%;
        /* Tên */
    }

    .messages-table th:nth-child(3),
    .messages-table td:nth-child(3) {
        width: 15%;
        /* SĐT */
    }

    .messages-table th:nth-child(4),
    .messages-table td:nth-child(4) {
        width: 20%;
        /* Email */
    }

    .messages-table th:nth-child(5),
    .messages-table td:nth-child(5) {
        width: 30%;
        /* Tin nhắn */
        word-wrap: break-word;
        white-space: pre-wrap;
    }

    .messages-table th:nth-child(6),
    .messages-table td:nth-child(6) {
        width: 12%;
        /* Hành động */
        text-align: center;
    }

    .delete-btn {
        background-color: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 1.4rem;
        display: inline-block;
        transition: background-color 0.3s ease;
    }

    .delete-btn:hover {
        background-color: #c82333;
    }
    </style>
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="messages">

        <h1 class="title"> Tin nhắn </h1>

        <div class="table-container">
            <table class="messages-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Tên</th>
                        <th>SĐT</th>
                        <th>Email</th>
                        <th>Tin nhắn</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                     $select_message = mysqli_query($conn, "SELECT * FROM `message` ORDER BY id DESC") or die('query failed');
                     if (mysqli_num_rows($select_message) > 0) {
                        while ($fetch_message = mysqli_fetch_assoc($select_message)) {
                     ?>
                    <tr>
                        <td><?php echo $fetch_message['user_id']; ?></td>
                        <td><?php echo $fetch_message['name']; ?></td>
                        <td><?php echo $fetch_message['number']; ?></td>
                        <td><?php echo $fetch_message['email']; ?></td>
                        <td><?php echo $fetch_message['message']; ?></td>
                        <td>
                            <a href="admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>"
                                onclick="return confirm('Bạn có muốn xóa tin nhắn này?');" class="delete-btn">Xóa</a>
                        </td>
                    </tr>
                    <?php
                     }
                  } else {
                     echo '<tr><td colspan="6" style="text-align:center; padding: 15px;">Không có tin nhắn nào!</td></tr>';
                  }
                  ?>
                </tbody>
            </table>
        </div>


    </section>









    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>