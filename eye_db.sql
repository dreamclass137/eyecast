-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2025 at 06:13 AM
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
-- Database: `eye_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address_tbl`
--

CREATE TABLE `address_tbl` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

CREATE TABLE `admin_tbl` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart_tbl`
--

CREATE TABLE `cart_tbl` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pcolor_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

CREATE TABLE `category_tbl` (
  `category_id` int(11) NOT NULL,
  `c_name` varchar(150) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `colour_tbl`
--

CREATE TABLE `colour_tbl` (
  `color_id` int(11) NOT NULL,
  `color_name` varchar(50) NOT NULL,
  `color_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items_tbl`
--

CREATE TABLE `order_items_tbl` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pcolor_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

CREATE TABLE `order_tbl` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Paid','Unpaid') DEFAULT 'Unpaid',
  `order_status` enum('Pending','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments_tbl`
--

CREATE TABLE `payments_tbl` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('UPI','Card','Netbanking','Wallet','Cash') DEFAULT NULL,
  `status` enum('Success','Failed','Pending') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_colors_tbl`
--

CREATE TABLE `product_colors_tbl` (
  `pcolor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `color_id` int(11) NOT NULL,
  `f_image` varchar(255) DEFAULT NULL,
  `b_image` varchar(255) DEFAULT NULL,
  `tryon_image` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

CREATE TABLE `product_tbl` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `shape_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `gender` enum('Male','Female','Unisex','Kids') DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` enum('Small','Medium','Large') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_tbl`
--

CREATE TABLE `review_tbl` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL CHECK (`rating` between 1 and 5),
  `review_text` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shape_tbl`
--

CREATE TABLE `shape_tbl` (
  `shape_id` int(11) NOT NULL,
  `s_name` varchar(150) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `user_status` enum('Active','Blocked') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_tbl`
--

CREATE TABLE `wishlist_tbl` (
  `wishlist_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `pcolor_id` int(11) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_tbl`
--
ALTER TABLE `address_tbl`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `pcolor_id` (`pcolor_id`);

--
-- Indexes for table `category_tbl`
--
ALTER TABLE `category_tbl`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `colour_tbl`
--
ALTER TABLE `colour_tbl`
  ADD PRIMARY KEY (`color_id`);

--
-- Indexes for table `order_items_tbl`
--
ALTER TABLE `order_items_tbl`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `pcolor_id` (`pcolor_id`);

--
-- Indexes for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `payments_tbl`
--
ALTER TABLE `payments_tbl`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `product_colors_tbl`
--
ALTER TABLE `product_colors_tbl`
  ADD PRIMARY KEY (`pcolor_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indexes for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `shape_id` (`shape_id`);

--
-- Indexes for table `review_tbl`
--
ALTER TABLE `review_tbl`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shape_tbl`
--
ALTER TABLE `shape_tbl`
  ADD PRIMARY KEY (`shape_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist_tbl`
--
ALTER TABLE `wishlist_tbl`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `pcolor_id` (`pcolor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_tbl`
--
ALTER TABLE `address_tbl`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_tbl`
--
ALTER TABLE `admin_tbl`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_tbl`
--
ALTER TABLE `category_tbl`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `colour_tbl`
--
ALTER TABLE `colour_tbl`
  MODIFY `color_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items_tbl`
--
ALTER TABLE `order_items_tbl`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tbl`
--
ALTER TABLE `order_tbl`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments_tbl`
--
ALTER TABLE `payments_tbl`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_colors_tbl`
--
ALTER TABLE `product_colors_tbl`
  MODIFY `pcolor_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_tbl`
--
ALTER TABLE `product_tbl`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_tbl`
--
ALTER TABLE `review_tbl`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shape_tbl`
--
ALTER TABLE `shape_tbl`
  MODIFY `shape_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist_tbl`
--
ALTER TABLE `wishlist_tbl`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_tbl`
--
ALTER TABLE `address_tbl`
  ADD CONSTRAINT `address_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`);

--
-- Constraints for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD CONSTRAINT `cart_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`),
  ADD CONSTRAINT `cart_tbl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`),
  ADD CONSTRAINT `cart_tbl_ibfk_3` FOREIGN KEY (`pcolor_id`) REFERENCES `product_colors_tbl` (`pcolor_id`);

--
-- Constraints for table `order_items_tbl`
--
ALTER TABLE `order_items_tbl`
  ADD CONSTRAINT `order_items_tbl_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_tbl` (`order_id`),
  ADD CONSTRAINT `order_items_tbl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`),
  ADD CONSTRAINT `order_items_tbl_ibfk_3` FOREIGN KEY (`pcolor_id`) REFERENCES `product_colors_tbl` (`pcolor_id`);

--
-- Constraints for table `order_tbl`
--
ALTER TABLE `order_tbl`
  ADD CONSTRAINT `order_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`),
  ADD CONSTRAINT `order_tbl_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `address_tbl` (`address_id`);

--
-- Constraints for table `payments_tbl`
--
ALTER TABLE `payments_tbl`
  ADD CONSTRAINT `payments_tbl_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order_tbl` (`order_id`);

--
-- Constraints for table `product_colors_tbl`
--
ALTER TABLE `product_colors_tbl`
  ADD CONSTRAINT `product_colors_tbl_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_colors_tbl_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `colour_tbl` (`color_id`) ON DELETE CASCADE;

--
-- Constraints for table `product_tbl`
--
ALTER TABLE `product_tbl`
  ADD CONSTRAINT `product_tbl_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category_tbl` (`category_id`),
  ADD CONSTRAINT `product_tbl_ibfk_2` FOREIGN KEY (`shape_id`) REFERENCES `shape_tbl` (`shape_id`);

--
-- Constraints for table `review_tbl`
--
ALTER TABLE `review_tbl`
  ADD CONSTRAINT `review_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`),
  ADD CONSTRAINT `review_tbl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`);

--
-- Constraints for table `wishlist_tbl`
--
ALTER TABLE `wishlist_tbl`
  ADD CONSTRAINT `wishlist_tbl_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_tbl` (`user_id`),
  ADD CONSTRAINT `wishlist_tbl_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product_tbl` (`product_id`),
  ADD CONSTRAINT `wishlist_tbl_ibfk_3` FOREIGN KEY (`pcolor_id`) REFERENCES `product_colors_tbl` (`pcolor_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
