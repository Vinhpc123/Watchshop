-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2025 at 02:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
-- Table structure for table `cart`
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
-- Table structure for table `message`
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
-- Dumping data for table `message`
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
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int(100) NOT NULL,
  `placed_on` date DEFAULT NULL,
  `payment_status` varchar(20) NOT NULL DEFAULT 'Đang duyệt'
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
(45, 11, 'TRẦN THANH VINH', '0355367829', 'vinh7085@gmail.com', 'ATM', '5, 524244, Ho Chi Minh, Việt Nam', ', ss f4 (1) ', 23123123, '0000-00-00', 'Thành công'),
(47, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', TRẦN THANH VINH (5) , adya (5) ', 2147483647, '2025-08-09', 'Thành công'),
(48, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', TRẦN THANH VINH (101) ', 10100000, '2025-08-11', 'Thành công'),
(51, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', TRẦN THANH VINH (5) ', 500000, '2025-08-17', 'Thành công'),
(53, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', blat (1) ', 16165165, '2025-08-17', 'Thành công'),
(54, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', 1 (1) ', 23123123, '2025-08-17', 'Thành công'),
(55, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', TRẦN THANH VINH (1) , adya (1) ', 1523332323, '2025-08-17', 'Thành công'),
(56, 11, 'lambo rari', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', Titoni Airmaster  (5) ', 2147483647, '2025-08-17', 'Thành công'),
(57, 11, 'lllll', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', 'số nhà huhu, huhu, Vietnam - ', ', TRẦN THANH VINH (6) ', 600000, '0000-00-00', 'Thành công'),
(58, 11, 'kkk', '0380333666', 'httt202020@gmail.com', 'Thanh toán khi giao hàng', '123122, huhu, huhu, Vietnam', ', adya (5) ', 2147483647, '2025-08-17', 'Thành công');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `stock` int(100) NOT NULL DEFAULT 100,
  `sold` int(100) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `stock`, `sold`) VALUES
(22, 'TRẦN THANH VINH', 100000, 'AE-1200WHD-1AVDF-2-1.jpg', 93, 7),
(27, 'adya', 1523232323, 'dong-ho-citizen-aw1030-50b-fe1010-57b-doi-eco-drive-day-inox-2.jpg', 94, 6),
(28, 'Titoni Airmaster ', 2147483647, 'hinh-anh-dong-ho-casio-mtp-1374l-1avdf-nam-pin-day-da-new-1.jpg', 95, 5),
(29, 'ss f4', 23123123, 'dong-ho-doi-olympianus-OP130-03MK-GL-OP130-03LK-GL-1-1.png', 100, 0),
(30, 'Saga Stella 71836-SVWHBL-2 – Nữ', 1331313, 'shopping.jpg', 100, 0),
(31, 'blat', 16165165, '2-titoni-airmaster-83733-sy-561.avif', 100, 0),
(32, '1', 23123123, 'BEM-100D-1A2VDF-BEL-100D-1A2VDF.jpg', 100, 0),
(33, '2', 123123123, 'DW00100431.avif', 100, 0),
(34, '3', 213123213, 'T137.407.11.351.00.avif', 100, 0),
(35, '4', 312312312, 'AE-1200WHD-1AVDF.avif', 100, 0),
(36, '7', 232423423, '83538-SY-099-23538-SY-099.avif', 100, 0),
(37, 'lambo rari', 1000000, '71836-SVWHBL-2-3.avif', 100, 0),
(38, 'rari', 5000000, '54_SSA377J1.avif', 100, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `user_type`) VALUES
(10, 'TRẦN THANH VINH', '2251120131@ut.edu.vn', 'c4ca4238a0b923820dcc509a6f75849b', 'admin'),
(11, 'TRẦN THANH VINH', 'vinh7085@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
