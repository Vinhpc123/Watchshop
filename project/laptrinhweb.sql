-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 02, 2025 lúc 11:36 AM
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
-- Database: `laptrinhweb`
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

--
-- Đang đổ dữ liệu cho bảng `message`
--

INSERT INTO `message` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(34, 11, 'TRẦN THANH VINH', 'vinh7085@gmail.com', '0355367829', '1'),
(36, 11, 'TRẦN THANH VINH', 'vinh7085@gmail.com', '0355367829', '.table-container {\r\n    width: 95%;\r\n    max-width: 1200px;\r\n    margin: auto;\r\n    overflow-x: auto;\r\n    background: #fff;\r\n    padding: 24px;\r\n    border-radius: 12px;\r\n    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);\r\n}\r\n\r\n.messages-table {\r\n    width: 100%;\r\n    border-collapse: collapse;\r\n    font-size: 1rem;\r\n    text-align: center;\r\n}\r\n\r\n.messages-table th,\r\n.messages-table td {\r\n    padding: 14px 12px;\r\n    border-bottom: 1px solid #ddd;\r\n}\r\n\r\n.messages-table th {\r\n    background-color: ');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(37, 11, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', 'Việt Nam, 524244, Ho Chi Minh, Việt Nam', ', Patek 1992 (1) ', 212000, '2025-08-01', 'Thành công'),
(38, 11, 'TRẦN VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', '4234, 70 TO KY, QUAN 12, TP HCM, HCM, Việt Nam', ', TRẦN THANH VINH (1) , Patek 1992 (1155155) ', 2147483647, '2025-08-01', 'Thành công'),
(39, 11, 'pham nguyen', '0355367829', 'vinh93170@gmail.com', 'Thanh toán khi giao hàng', '30/6a, 70 TO KY, QUAN 12, TP HCM, HCM, Việt Nam', ', TRẦN THANH VINH (3) ', 300000, '2025-08-01', 'Thành công'),
(40, 11, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', 'Việt Nam, 524244, Ho Chi Minh, Việt Nam', ', ss f4 (1) ', 23123123, '0000-00-00', 'Thành công'),
(41, 14, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', '1, 524244, Ho Chi Minh, Việt Nam', ', Titoni Airmaster  (1) ', 2147483647, '0000-00-00', 'Thành công'),
(43, 11, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', 'Việt Nam, Tân thới hiệp 15 - quận 12, Ho Chi Minh, Việt Nam', ', adya (1) ', 1523232323, '0000-00-00', 'Thành công'),
(44, 11, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'Thanh toán khi giao hàng', 'ư4234, 524244, Ho Chi Minh, Việt Nam', ', ss f4 (1) ', 23123123, '0000-00-00', 'Thành công'),
(45, 11, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'ATM', '5, 524244, Ho Chi Minh, Việt Nam', ', ss f4 (1) ', 23123123, '0000-00-00', 'Thành công');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`) VALUES
(22, 'TRẦN THANH VINH', 100000, 'Screenshot 2025-07-28 083836.png'),
(27, 'adya', 1523232323, 'Screenshot 2025-07-28 083836.png'),
(28, 'Titoni Airmaster ', 2147483647, 'Screenshot 2025-08-01 165919.png'),
(29, 'ss f4', 23123123, 'Screenshot 2025-08-01 163513.png'),
(30, 'Saga Stella 71836-SVWHBL-2 – Nữ', 1331313, 'Screenshot 2025-07-28 083836.png'),
(31, 'blat', 16165165, 'Screenshot 2025-08-01 163513.png'),
(32, '1', 23123123, 'Screenshot 2025-08-02 095659.png'),
(33, '2', 123123123, 'Screenshot 2025-08-02 095712.png'),
(34, '3', 213123213, 'Screenshot 2025-08-02 101237.png'),
(35, '4', 312312312, 'mountain-night-aurora-borealis-digital-scenery-art-4k-wallpaper-uhdpaper.com-649@2@b.jpg'),
(36, '7', 232423423, 'shinobu-kocho-insect-hashira-demon-slayer-kimetsu-no-yaiba-0-4k-wallpaper-3840x2160-uhdpaper.com-617');

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
(10, 'TRẦN THANH VINH', '2251120131@ut.edu.vn', 'c4ca4238a0b923820dcc509a6f75849b', 'admin'),
(11, 'TRẦN THANH VINH', 'vinh7085@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user');

--
-- Indexes for dumped tables
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
-- Indexes for table `orders`
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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT cho bảng `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
