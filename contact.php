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




if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = $_POST['number'];
   $msg = mysqli_real_escape_string($conn, $_POST['message']);

   if (!preg_match('/^(03[2-9]|05[6|8|9]|07[0-9]|08[1-9]|09[0-9])[0-9]{7}$/', $number)) {
    $message[] = 'Số điện thoại không hợp lệ! Vui lòng nhập đúng số của nhà mạng Việt Nam.';
    } else {
        $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

        if(mysqli_num_rows($select_message) > 0){
            $message[] = 'Tin nhắn đã được gửi trước đó!';
        } else {
            mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
            $message[] = 'Gửi tin nhắn thành công!';
        }
    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
    .contact {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        max-width: 1000px;
        margin: -20px auto;
        border-radius: 10px;
        overflow: hidden;
    }

    .contact-form,
    form {
        flex: 1 1 400px;
        padding: 30px;
    }

    .contact-form h2 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #8e44ad;
    }

    .contact-form p {
        font-size: 20px;
        color: #444;
        line-height: 1.6;
    }

    .contact-info p {
        margin: 12px 0;
        font-size: 17px;
        color: #555;
    }

    .contact-info i {
        margin-right: 10px;
    }

    .social-icons a {
        margin-right: 12px;
        font-size: 20px;
        color: #555;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .social-icons a:hover {
        color: #8e44ad;
    }

    h3 {
        font-size: 4rem;
        margin-bottom: 15px;
    }

    form h3 {
        font-size: 24px;
        text-align: center;
        margin-bottom: 25px;
        color: #1d3b2a;
    }

    form .box,
    form textarea {
        width: 100%;
        padding: 12px 15px;
        margin-bottom: 20px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        transition: border 0.3s ease;
    }

    form .box:focus,
    form textarea:focus {
        border-color: #1d3b2a;
        outline: none;
        background-color: #fff;
    }

    form textarea {
        resize: vertical;
        min-height: 120px;
    }

    form input[type="submit"] {
        background-color: #8e44ad;
        color: white;
        padding: 12px 25px;
        border: none;
        font-size: 16px;
        cursor: pointer;
        display: block;
        width: 100%;
        border-radius: 6px;
        transition: background-color 0.3s ease;
    }

    form input[type="submit"]:hover {
        opacity: 0.9;
        background-color: var(--black);
    }

    @media screen and (max-width: 768px) {
        .contact {
            flex-direction: column;
        }

        .contact-form,
        form {
            padding: 25px;
        }
    }
    </style>
</head>

<body>

    <?php include 'header.php'; ?>
    <section class="contact">

        <div class="contact-form">
            <h3>Liên hệ với chúng tôi!</h3>
            <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn. Hãy liên hệ với chúng tôi nếu bạn có bất kỳ thắc mắc,
                góp ý hoặc nhu cầu hợp tác nào!</p>

            <div class="contact-info">
                <p><i class="fas fa-phone"></i> +84 355367829</p>
                <p><i class="fas fa-envelope"></i> vinh7085@gmail.com</p>
                <p><i class="fas fa-map-marker-alt"></i> 70 Tô Ký, Q12, Tp.HCM</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-tiktok"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>

        <form action="" method="post">
            <input type="text" name="name" required placeholder="Vui lòng nhập tên" class="box">
            <input type="tel" name="number" required placeholder="Vui lòng nhập số điện thoại" class="box"
                pattern="[0-9]{10,11}">
            <input type="email" name="email" required placeholder="Vui lòng nhập email" class="box">
            <textarea name="message" class="box" placeholder="Vui lòng nhập lời nhắn" cols="30" rows="10"></textarea>
            <input type="submit" value="Gửi tin nhắn" name="send" class="btn">
        </form>


    </section>


    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>