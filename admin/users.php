<?php

include '../config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:../login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:users.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>users</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="../css/admin_style.css">

    <style>
    .table-container {
        overflow-x: auto;
        margin: 2rem auto;
        max-width: 1200px;
        padding: 1rem;
        background: var(--white);
        border-radius: .5rem;
        box-shadow: var(--box-shadow);
    }

    /* Báº£ng chÃ­nh */
    .user-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 1.7rem;
        min-width: 700px;
        /* Ä‘áº£m báº£o báº£ng khÃ´ng bá»‹ bÃ³p quÃ¡ nhá» */
    }

    .user-table thead {
        background: #f1f1f1;
    }

    .user-table th,
    .user-table td {
        padding: 1.2rem 1.5rem;
        border: 1px solid #ccc;
        text-align: center;
        white-space: nowrap;
        /* giá»¯ chá»¯ khÃ´ng bá»‹ xuá»‘ng dÃ²ng */
    }

    /* NÃºt xÃ³a */
    .user-table td a.delete-btn {
        background: var(--red);
        color: white;
        border-radius: .3rem;
        text-decoration: none;
        font-size: 1.4rem;
        margin-bottom: 10px;
    }

    .user-table td a.delete-btn:hover {
        background: #c0392b;
    }

    /* --- Responsive --- */
    @media screen and (max-width: 768px) {
        .table-container {
            padding: 0.5rem;
        }

        .user-table {
            font-size: 1.4rem;
            min-width: unset;
        }

        .user-table th,
        .user-table td {
            padding: 0.8rem;
            font-size: 1.3rem;
        }

        .user-table td a.delete-btn {
            padding: 0.4rem 0.8rem;
            font-size: 1.2rem;
        }
    }

    @media screen and (max-width: 480px) {
        .user-table {
            font-size: 1.2rem;
        }

        .user-table th,
        .user-table td {
            padding: 0.5rem;
        }

        .user-table td a.delete-btn {
            padding: 0.3rem 0.6rem;
            font-size: 1.1rem;
        }
    }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="users">

        <h1 class="title"> TÃ i khoáº£n </h1>

        <div class="table-container">
            <table class="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>TÃªn ngÆ°á»i dÃ¹ng</th>
                        <th>Email</th>
                        <th>Loáº¡i tÃ i khoáº£n</th>
                        <th>HÃ nh Ä‘á»™ng</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                        while($fetch_users = mysqli_fetch_assoc($select_users)){
                    ?>
                    <tr>
                        <td><?php echo $fetch_users['id']; ?></td>
                        <td><?php echo $fetch_users['name']; ?></td>
                        <td><?php echo $fetch_users['email']; ?></td>
                        <td style="color:<?php echo ($fetch_users['user_type'] == 'admin') ? 'orange' : '#6c5ce7'; ?>">
                            <?php echo $fetch_users['user_type']; ?>
                        </td>
                        <td>
                            <a href="users.php?delete=<?php echo $fetch_users['id']; ?>"
                                onclick="return confirm('Báº¡n cÃ³ cháº¯c muá»‘n xÃ³a tÃ i khoáº£n nÃ y?');"
                                class="delete-btn">XÃ³a</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        </div>

    </section>









    <!-- custom admin js file link  -->
    <script src="../js/admin_script.js"></script>

</body>

</html>

