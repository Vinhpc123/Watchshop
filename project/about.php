<?php

include 'config.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('location:login.php');
    exit();
} 
$user_id = $_SESSION['user_id'];


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>about</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../project/css/style.css">

    <style>
    .heading {
        min-height: 30vh;
        display: flex;
        flex-flow: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        background: linear-gradient(rgb(0 0 0 / 50%), rgba(255, 255, 255, 0.4)), url(../project/images/img_nền/about.jpg) no-repeat;
        background-size: cover;
        background-position: center;
        text-align: center;
    }


    .heading h3 {
        font-size: 5rem;
        color: var(--white);
        text-transform: uppercase;
    }

    .heading p {
        font-size: 2.5rem;
        color: var(--light-color);
    }

    .heading p a {
        color: var(--white);
    }

    .heading p a:hover {
        text-decoration: underline;
    }

    .mission-cards {
        display: flex;
        gap: 30px;
        justify-content: center;
        flex-wrap: wrap;
        margin: 30px 0;
    }

    .mission-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        padding: 30px 24px;
        text-align: center;
        max-width: 320px;
        flex: 1 1 250px;
    }

    .mission-card i {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 15px;
    }

    .mission-card h4 {
        font-size: 1.7rem;
        margin-bottom: 10px;
        color: #222;
    }

    .mission-card p {
        font-size: 1.7rem;
        color: #444;
    }
    </style>

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">

    </div>

    <section class="about">

        <div class="flex">

            <div class="image">
                <img src="images/img_nền/fossil_watch.jpg" alt="" width="450" height="450"
                    style="opacity: 0.9 ;border-radius: 20px;">

            </div>

            <div class="content">
                <h3>Tại sao lại chọn chúng tôi?</h3>
                <p>Với kinh nghiệm nhiều năm, chúng tôi cung cấp dịch vụ chất lượng cao, thiết kế riêng theo nhu cầu của
                    bạn. Giá cả cạnh tranh đảm bảo giá trị tuyệt vời, cùng với đội ngũ hỗ trợ khách hàng tận tâm luôn
                    sẵn sàng. Chúng tôi không ngừng đổi mới và cải thiện để mang đến giải pháp tốt nhất. Hãy chọn chúng
                    tôi vì chuyên môn, chất lượng và dịch vụ đặc biệt.</p>
                <a href="contact.php" class="btn">Liên hệ</a>
            </div>

        </div>

    </section>

    <section class="reviews">

        <h1 class="title">Đánh giá của khách hàng</h1>

        <div class="box-container">

            <div class="box">
                <img src="images/img_review_customer/pic1.jpg" alt="">
                <p>Tôi rất hài lòng với chiếc đồng hồ mua tại đây. Thiết kế đẹp, chất lượng tốt và dịch vụ khách hàng
                    rất chuyên nghiệp.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Nguyen Huu Khanh</h3>
            </div>

            <div class="box">
                <img src="images/img_review_customer/pic2.jpg" alt="">
                <p>Đồng hồ của WatchStore không chỉ bền mà còn rất phong cách. Tôi nhận được nhiều lời khen từ bạn bè và
                    đồng nghiệp.
                </p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Vo Van Sau</h3>
            </div>

            <div class="box">
                <img src="images/img_review_customer/pic3.jpg" alt="">
                <p>Mua sắm tại WatchStore là một trải nghiệm tuyệt vời. Nhân viên nhiệt tình, tư vấn chu đáo và giao
                    hàng nhanh chóng.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Thanh Dat</h3>
            </div>

            <div class="box">
                <img src="images/img_review_customer/pic4.jpg" alt="">
                <p>Tôi đã mua đồng hồ cho cả gia đình và mọi người đều rất ưng ý. Giá cả hợp lý, chất lượng đảm bảo. Rất
                    đáng để quay lại.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Vo Ta Duy</h3>
            </div>

            <div class="box">
                <img src="images/img_review_customer/pic5.jpg" alt="">
                <p>Dịch vụ sau bán hàng của WatchStore thật sự xuất sắc. Họ luôn sẵn sàng hỗ trợ và giải đáp mọi thắc
                    mắc của tôi.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Pham Gia Khoi</h3>
            </div>

            <div class="box">
                <img src="images/img_review_customer/pic6.jpg" alt="">
                <p>Tôi rất thích sự đa dạng trong bộ sưu tập đồng hồ tại WatchStore. Có nhiều lựa chọn phong cách khác
                    nhau, phù hợp với mọi dịp.</p>
                <div class="stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <h3>Phan Van Hoang</h3>
            </div>

        </div>

    </section>

    <section class="mission">

        <h3 class="title">Sứ mệnh của WatchStore</h3>
        <div class="mission-cards">
            <div class="mission-card">
                <i class="fas fa-gem"></i>
                <h4>Chất lượng hàng đầu</h4>
                <p>Cam kết cung cấp đồng hồ chính hãng, chất lượng cao, bảo hành uy tín và hậu mãi tận tâm cho mọi khách
                    hàng.</p>
            </div>
            <div class="mission-card">
                <i class="fas fa-users"></i>
                <h4>Khách hàng là trung tâm</h4>
                <p>Luôn lắng nghe, thấu hiểu và phục vụ tận tình để mang lại trải nghiệm mua sắm tốt nhất cho bạn.</p>
            </div>
            <div class="mission-card">
                <i class="fas fa-shipping-fast"></i>
                <h4>Đổi mới & Nhanh chóng</h4>
                <p>Không ngừng cập nhật xu hướng mới, giao hàng nhanh toàn quốc, đáp ứng mọi nhu cầu về thời trang &
                    công nghệ.</p>
            </div>
        </div>


    </section>







    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>

</body>

</html>