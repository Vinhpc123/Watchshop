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
        width: 95%;
        max-width: 1200px;
        margin: auto;
        overflow-x: auto;
        background: #fff;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
    }

    .messages-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1.5rem;
        text-align: center;
    }

    .messages-table th,
    .messages-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #ddd;
        border: 1px solid #ccc;
    }

    .messages-table th {
        background-color: #f0f0f0;
        color: #000;
        font-weight: 600;
    }



    .delete-btn {
        background-color: #e74c3c;
        color: white;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        display: inline-block;
        transition: 0.3s ease;
        margin-bottom: 10px;
    }

    .delete-btn:hover {
        background-color: #c0392b;
    }

    /* Responsive - Mobile */
    @media (max-width: 768px) {
        .messages-table thead {
            display: none;
        }

        .messages-table,
        .messages-table tbody,
        .messages-table tr,
        .messages-table td {
            display: block;
            width: 100%;
        }

        .messages-table tr {
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            padding: 12px;
        }

        .messages-table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
        }

        .messages-table td::before {
            content: attr(data-label);
            position: absolute;
            left: 15px;
            font-weight: bold;
            color: #555;
            text-align: left;
        }
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