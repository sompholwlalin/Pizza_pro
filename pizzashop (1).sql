-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 31, 2023 at 07:02 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzashop`
--

-- --------------------------------------------------------

--
-- Table structure for table `crust`
--

CREATE TABLE `crust` (
  `crust_id` int(11) NOT NULL,
  `crust_name` varchar(50) NOT NULL,
  `price_crust` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `crust`
--

INSERT INTO `crust` (`crust_id`, `crust_name`, `price_crust`) VALUES
(1, 'Thin', '20.00'),
(2, 'Pan', '30.00'),
(3, 'Cheese', '40.00');

-- --------------------------------------------------------

--
-- Table structure for table `iorders`
--

CREATE TABLE `iorders` (
  `iorder_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('Pending','Processing','Delivered','Cancelled') NOT NULL,
  `status_pay` enum('Paid','Unpaid') NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pizzas`
--

CREATE TABLE `pizzas` (
  `pizza_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pizzas`
--

INSERT INTO `pizzas` (`pizza_id`, `name`, `image`, `detail`, `price`) VALUES
(1, 'Seafood', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102228.png', 'หน้ารวมทะเล', '349.00'),
(2, 'Ham&Crab Sticks', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102226.png', 'ปูอัดเน้นๆ', '349.00'),
(3, 'Tom Yum Kung', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102212.png', 'ต้มยำกุ้งเข้มข้น', '349.00'),
(4, 'Seafood Cocktail', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102208.png', 'ทะเลรวมในหน้าเดียว', '349.00'),
(5, 'Spicy Super seafood', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102734.png', 'เผ็ดซีด ซีฟู๊ด', '349.00'),
(6, 'Shrimp Cocktail', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102209.png', 'กุ้งและเห็ดรวมกัน', '349.00'),
(7, 'Hawaiian', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102204.png', 'ฮาวาเอี่ยนจุใจ', '349.00'),
(8, 'Chicken Trio', 'https://cdn.1112.com/1112/public/images/products/pizza/Topping/102203.png', 'ไก่เน้นเต็มคำ', '349.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `amount` int(11) NOT NULL,
  `pid` int(11) DEFAULT NULL,
  `oid` int(11) DEFAULT NULL,
  `sid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`amount`, `pid`, `oid`, `sid`, `cid`, `product_id`) VALUES
(1, 1, NULL, 2, 3, 1),
(3, 3, NULL, 2, 2, 2),
(0, 2, NULL, 3, 3, 5),
(2, 8, NULL, 3, 3, 6),
(8, 1, NULL, 1, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL,
  `price_size` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`size_id`, `size_name`, `price_size`) VALUES
(1, 'S', '20.00'),
(2, 'M', '30.00'),
(3, 'L', '40.00'),
(4, 'XL', '50.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `address` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `phone`, `email`, `password`, `type`, `address`) VALUES
(1, 'Bobby', '011111', 'Bobby@gmail.com', '1111', 'o', '22/th'),
(2, 'Azaria', '0222', 'Azaria@gmail.com', '2222', 'c', '33/th 222'),
(3, 'Alexander', '033333', 'Alexander@gmail.com', '3333', 'c', '44/th 333');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crust`
--
ALTER TABLE `crust`
  ADD PRIMARY KEY (`crust_id`);

--
-- Indexes for table `iorders`
--
ALTER TABLE `iorders`
  ADD PRIMARY KEY (`iorder_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pizzas`
--
ALTER TABLE `pizzas`
  ADD PRIMARY KEY (`pizza_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `oid` (`oid`),
  ADD KEY `sid` (`sid`),
  ADD KEY `cid` (`cid`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`size_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crust`
--
ALTER TABLE `crust`
  MODIFY `crust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `iorders`
--
ALTER TABLE `iorders`
  MODIFY `iorder_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pizzas`
--
ALTER TABLE `pizzas`
  MODIFY `pizza_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `iorders`
--
ALTER TABLE `iorders`
  ADD CONSTRAINT `iorders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `d` FOREIGN KEY (`oid`) REFERENCES `iorders` (`iorder_id`),
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `pizzas` (`pizza_id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`oid`) REFERENCES `iorders` (`iorder_id`),
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`sid`) REFERENCES `size` (`size_id`),
  ADD CONSTRAINT `products_ibfk_4` FOREIGN KEY (`cid`) REFERENCES `crust` (`crust_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
