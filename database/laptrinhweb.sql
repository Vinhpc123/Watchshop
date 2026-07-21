-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 23, 2025 lúc 03:55 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `laptrinhweb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `message`
--

CREATE TABLE `message` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Đang duyệt',
  `order_type` enum('online','pos') DEFAULT 'online'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`, `order_type`) VALUES
(6, 1, 'TRẦN THANH VINH', '0355367829', 'vinh38881@gmail.com', 'Thanh toán khi giao hàng', '123, tân thới hiệp 15, quận 12, tp hcm, Hồ Chí Minh, Việt Nam', ', KOI Sheen K004.153.64.14.53.11.05 (1) , Casio MTP-1384L-1AVDF (1) ', 6344000, '2025-08-19', 'Thành công', 'online'),
(9, 1, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', '12, 524244, Ho Chi Minh, Việt Nam', ', Titoni Airmaster 93709 SY-385 (1) ', 40900000, '2025-08-19', 'Thành công', 'online'),
(25, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Cosmo King 797 S-719 (1), Titoni Cosmo King 797 SY-695 (1)', 79110000, '2025-08-19', 'Thành công', 'pos'),
(26, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Airmaster 93709 SY-385 (1), Orient RA-AS0106L30B  (1)', 56900000, '2025-08-19', 'Thành công', 'pos'),
(27, 1, 'TRẦN THANH VINH', '0355367829', 'vinh38881@gmail.com', 'Thanh toán khi giao hàng', '123, tân thới hiệp 15, quận 12, tp hcm, Hồ Chí Minh, Việt Nam', ', Casio MTP-1384L-1AVDF (1) , Titoni Cosmo King 797 (6) ', 223744000, '2025-08-19', 'Thành công', 'online'),
(28, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Cosmo King 797 S-719 (1), Titoni Cosmo King 797 SY-695 (1)', 79110000, '2025-08-19', 'Thành công', 'pos'),
(29, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Orient RA-AS0106L30B  (1), Titoni Airmaster 93709 SY-385 (1)', 56900000, '2025-08-19', 'Thành công', 'pos'),
(30, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Airmaster 93709 SY-385 (1)', 40900000, '2025-08-19', 'Thành công', 'pos'),
(31, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Orient RA-AS0106L30B  (1)', 16000000, '2025-08-19', 'Thành công', 'pos'),
(32, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Cosmo King 797 S-719 (1)', 38380000, '2025-08-19', 'Thành công', 'pos'),
(33, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'KOI Moonphase K006.436.65 (1), Seiko 5 Sports Field SRPJ87K1 (3), Titoni Cosmo Queen 729 G-DB-541 (1), Koi Đôi K005.303.092.05.01.03 (1)', 79300000, '2025-08-19', 'Thành công', 'pos'),
(34, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Airmaster 93709 SY-385 (1)', 40900000, '2025-08-19', 'Thành công', 'pos'),
(35, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Cosmo King 797 S-719 (1), Titoni Cosmo King 797 SY-695 (1)', 79110000, '2025-08-20', 'Thành công', 'pos'),
(36, 1, 'TRẦN THANH VINH', '0355367829', 'vinh38881@gmail.com', 'Thanh toán khi giao hàng', '12a, tân thới hiệp 15, quận 12, tp hcm, Hồ Chí Minh, Việt Nam', ', Titoni Airmaster 93808 (1) ', 37700000, '2025-08-20', 'Thành công', 'online'),
(37, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'KOI Sheen K004.153.64.14.53.11.05 (1), Doxa Noble D173TCM (1)', 53000000, '2025-08-20', 'Thành công', 'pos'),
(38, 1, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', '23423, 524244, Ho Chi Minh, Việt Nam', ', Orient RA-AS0105S30B (10) ', 168000000, '2025-08-20', 'Thành công', 'online'),
(39, 1, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', '123, 524244, Ho Chi Minh, Việt Nam', ', Orient RA-AS0105S30B (1) ', 16800000, '2025-08-20', 'Thành công', 'online'),
(42, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Koi Đôi K005.303.092.05.01.03 (1), KOI Moonphase K006.436.65 (1), Titoni Cosmo King 797 (1)', 47180000, '2025-08-21', 'Thành công', 'pos'),
(43, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Orient RA-AS0105S30B (20)', 336000000, '2025-08-21', 'Thành công', 'pos'),
(44, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Orient RA-AS0105S30B (1), Titoni Airmaster 93808 (1)', 54500000, '2025-08-21', 'Thành công', 'pos'),
(45, NULL, 'Khách lẻ', 'N/A', 'N/A', 'Tiền mặt', 'Mua tại cửa hàng', 'Titoni Airmaster 93709 SY-385 (1), Orient RA-AS0106L30B  (1), Titoni Cosmo King 797 SY-695 (1), Titoni Cosmo King 797 S-719 (1)', 136010000, '2025-08-23', 'Thành công', 'pos'),
(46, 1, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', '2342, Tân thới hiệp 15 - quận 12, Ho Chi Minh, Việt Nam', ', Orient RA-AS0105S30B (1) ', 16800000, '2025-08-23', 'Thành công', 'online'),
(50, 1, 'TRẦN THANH VINH', '0355367829', 'vinh38881@gmail.com', 'Thanh toán khi giao hàng', '2342, tân thới hiệp 15, quận 12, tp hcm, Hồ Chí Minh, Việt Nam', ', KOI Sheen K004.153.64.14.53.11.05 (100) ', 376000000, '2025-08-23', 'Thành công', 'online'),
(52, 1, 'TRẦN THANH VINH', '0355367829', 'vinh38881@gmail.com', 'Thanh toán khi giao hàng', '30/6a, tân thới hiệp 15, quận 12, tp hcm, Hồ Chí Minh, Việt Nam', ', Orient RA-AS0105S30B (155) ', 2147483647, '2025-08-23', 'Thành công', 'online'),
(54, 1, 'TRẦN THANH VINH', '0355367829', 'vinh38881@gmail.com', 'Thanh toán khi giao hàng', '23423, tân thới hiệp 15, quận 12, tp hcm, Hồ Chí Minh, Việt Nam', ', Casio MTP-1384L-1AVDF (22) ', 56848000, '2025-08-23', 'Thành công', 'online');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `stock` int(100) NOT NULL DEFAULT 0,
  `sold` int(100) NOT NULL DEFAULT 0,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `stock`, `sold`, `image`) VALUES
(1, 'Orient RA-AS0105S30B', 16800000, 0, 155, '2-orient-sun-and-moon-ra-as0105s30b.avif'),
(2, 'Orient RA-AS0106L30B ', 16000000, 87, 0, '3-orient-sun-and-moon-ra-as0106l30b.avif'),
(3, 'Titoni Airmaster 93709 SY-385', 40900000, 120, 0, '3-titoni-airmaster-93709-sy-385.avif'),
(4, 'Titoni Airmaster 93808', 37700000, 20, 0, '2-titoni-airmaster-93808-s-259.avif'),
(5, 'Titoni Cosmo King 797 SY-695', 40730000, 60, 0, '3-titoni-cosmo-king-797-sy-695.avif'),
(6, 'Titoni Cosmo King 797 S-719', 38380000, 60, 0, '3-titoni-cosmo-king-797-s-719.avif'),
(7, 'Titoni Cosmo King 797', 36860000, 20, 0, '1-titoni-cosmo-king-797797-s-696.avif'),
(8, 'KOI Moonphase K006.436.65', 4520000, 70, 0, '2-koi-moonphase-k006-436-65-1-36-11-07.avif'),
(9, 'Koi Đôi K005.303.092.05.01.03', 5800000, 10, 0, 'k005-303-092-05-01-03-vs-k005-103-092-05-01-03.avif'),
(10, 'Doxa Love Quartet – D222RSV', 58960000, 90, 0, 'D222RSV.avif'),
(11, 'Seiko 5 Sports Field SRPJ87K1', 9640000, 98, 0, 'Review-dong-ho-Seiko-5-Sports-Field-SRPJ87K1-4.avif'),
(12, 'Titoni Cosmo Queen 729 G-DB-541', 40060000, 20, 0, 'Titoni-729-G-DB-541-2.avif'),
(13, 'Titoni Cosmo Queen 729 S-DB-307', 36190000, 50, 0, 'Titoni-729-S-DB-307-4.avif'),
(14, 'Titoni Cosmo Queen 729 SY-DB-019', 39560000, 120, 0, 'Titoni-729-SY-DB-019-2.avif'),
(15, 'Titoni Cosmo Queen 729 SY-DB-695', 39560000, 90, 0, 'Titoni-729-SY-DB-695-2.avif'),
(16, 'Casio World Time AE-1200WHD', 1627000, 30, 0, 'AE-1200WHD-1AVDF.avif'),
(17, 'Doxa Noble D173TCM', 49240000, 110, 0, 'D173TCM-4-2.avif'),
(18, 'Casio MTP-1370D-1A2VDF', 1906000, 90, 0, 'CASIO-MTP-1370D-1A2VDF-1.avif'),
(19, 'Casio MTP-1384D-7A2VDF ', 2694000, 15, 0, 'CASIO-MTP-1384D-7A2VDF-1.avif'),
(20, 'Casio MTP-1384L-1AVDF', 2584000, 0, 22, 'CASIO-MTP-1384L-1AVDF-0.avif'),
(21, 'KOI Sheen K004.153.64.14.53.11.05', 3760000, 0, 100, 'K004.153.64.14.53.11.054.avif');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(1, 'Vinh Trần', 'vinh38882@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user'),
(2, 'Trần Thanh Vinh', 'vinh7085@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT cho bảng `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
