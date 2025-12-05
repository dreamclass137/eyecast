-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 05, 2026 at 10:49 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `speczo_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `address_tbl`
--

DROP TABLE IF EXISTS `address_tbl`;
CREATE TABLE IF NOT EXISTS `address_tbl` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `city` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pincode` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`address_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address_tbl`
--

INSERT INTO `address_tbl` (`address_id`, `user_id`, `address`, `city`, `state`, `pincode`) VALUES
(9, 6, '1004 12 E/A greencity pal bhatha', 'surat', 'gujarat', '395003'),
(10, 8, '1004 12 E/A greencity pal bhatha', 'surat', 'gujarat', '395003'),
(11, 11, '1004 12 E/A greencity pal bhatha', 'surat', 'gujarat', '395003');

-- --------------------------------------------------------

--
-- Table structure for table `admin_tbl`
--

DROP TABLE IF EXISTS `admin_tbl`;
CREATE TABLE IF NOT EXISTS `admin_tbl` (
  `admin_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_tbl`
--

INSERT INTO `admin_tbl` (`admin_id`, `username`, `email`, `password`) VALUES
(1, 'Speczo', 'speczo2025@gmail.com', '$2y$10$4sI3Vl0/jXRBKwyUDEwYWO/E.p6V7E.8sdTEYYZzeTTIHO7hs8XEi'),
(2, 'Riya Patel', 'riya123@gmail.com', '$2y$10$Z2.FVCsBnW9ssKJZsNt9buY0DW6OW960xfmmfOcYy3GfiebQ3cjYe'),
(3, 'tisha shivnani', 'tishashivnani@gmail.com', '$2y$10$PBnuZuGe2SLbq61Q6yGFtepazlOKOE5rTcP.Tx1Yo3kvcyIqMiWca');

-- --------------------------------------------------------

--
-- Table structure for table `cart_tbl`
--

DROP TABLE IF EXISTS `cart_tbl`;
CREATE TABLE IF NOT EXISTS `cart_tbl` (
  `cart_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `pimage` int NOT NULL,
  `pvariation` int NOT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`cart_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  KEY `pimage` (`pimage`),
  KEY `pvariation` (`pvariation`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category_tbl`
--

DROP TABLE IF EXISTS `category_tbl`;
CREATE TABLE IF NOT EXISTS `category_tbl` (
  `category_id` int NOT NULL AUTO_INCREMENT,
  `c_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category_tbl`
--

INSERT INTO `category_tbl` (`category_id`, `c_name`) VALUES
(1, 'Sunglasses'),
(2, 'Eyeglasses'),
(3, 'Zero Power Screen Glasses'),
(4, 'Clip - on');

-- --------------------------------------------------------

--
-- Table structure for table `color_tbl`
--

DROP TABLE IF EXISTS `color_tbl`;
CREATE TABLE IF NOT EXISTS `color_tbl` (
  `color_id` int NOT NULL AUTO_INCREMENT,
  `color_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `color_code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color_tbl`
--

INSERT INTO `color_tbl` (`color_id`, `color_name`, `color_code`) VALUES
(1, 'Black', '#000000'),
(2, ' Mid Gunmetal', '#3C3F41'),
(3, 'Olive Green', '#556B2F'),
(4, 'Dark Blue', '#1E4A78'),
(5, 'Dark Gunmetal', '#6A6E6F'),
(6, 'Silver', '#C0C0C0'),
(7, 'Light Gray', '#6E6E6E'),
(8, 'Blue', '#2E5D7F'),
(9, 'Crystal Transparent', '#F6F6F6'),
(10, 'Crystal Blue', '#E2F3FB'),
(11, 'Transparent Pink', '#F7C6D9'),
(12, 'Metallic Gold', '#D4AF37'),
(13, 'Lavender Metallic', '#B57EDC'),
(14, 'Metallic Blue', '#5DADEC'),
(15, 'Forest Charcoal', '#2F433A'),
(16, 'Teal Blue', '#25A4B3'),
(17, 'Steel Blue', '#7A93B5'),
(18, 'Dark Slate Blue', '#353856'),
(19, 'Burnt Orange', '#CE7F34'),
(20, 'Jet Black', '#3A3A3A'),
(21, 'Glossy Black', '#1A1818'),
(22, 'Midnight Blue', '#1A2A3B'),
(23, 'Transparent Gray', '#A8A8A8'),
(24, 'Muted Lavender Gray', '#837890'),
(25, 'Dusty Rose Brown', '#8A6365'),
(26, 'Slate Blue Gray', '#778899'),
(27, 'Light Pink Rose', '#FDAFC9'),
(28, 'Muted Sage Green', '#819C8F'),
(29, 'Muted Rosewood', '#A67974'),
(30, 'Dusky Pink', '#D08AA2'),
(31, 'Light Rose Tint', '#FAEEF4'),
(32, 'Gunmetal', '#3E4649'),
(33, 'Gold', '#FFDB1C'),
(34, 'Green', '#0D6E0D'),
(35, 'Tortoise Brown', '#5B3A29'),
(36, 'Teal Green Tortoise', '#2F6F73'),
(37, 'Gray', '#DADADA'),
(38, 'Crystal Blue Grey', '#4F7FA0'),
(39, 'Mauve', '#C18A9A'),
(40, 'Gold Matte', '#C9B037'),
(41, 'Smoke Black', '#4A4A4A'),
(42, 'Brown', '#89420F'),
(43, 'Brown Transparent', '#6B5A3C'),
(44, 'Matte Black', '#1C1C1C'),
(45, 'Flamingo', '#FB799C'),
(46, 'Soft Purple', '#9586BB'),
(47, 'Purple', '#800080'),
(48, 'Aqua Mint', '#9FE0D2'),
(49, 'Off White', '#F2EEE6'),
(50, 'Orange', '#F26B4F'),
(51, 'Red', '#C62828'),
(52, 'Pink', '#EB79A7'),
(53, 'Cobalt Blue', '#3F51B5');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries_tbl`
--

DROP TABLE IF EXISTS `inquiries_tbl`;
CREATE TABLE IF NOT EXISTS `inquiries_tbl` (
  `inquiry_id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`inquiry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries_tbl`
--

INSERT INTO `inquiries_tbl` (`inquiry_id`, `full_name`, `email`, `subject`, `message`, `created_at`) VALUES
(33, 'Krisha Tamakuwala', 'krisha@gmail.com', 'good order', 'wowwwwwwwieeeeeeeeeee', '2026-01-29 09:42:03'),
(34, 'Krisha Tamakuwala', 'krisha@gmail.com', 'good order', 'lytrdesrtyuiop[poiuytrdesdfghjuioftyuiop[poiugyht', '2026-01-30 08:39:50'),
(35, 'Krisha Tamakuwala', 'krisha@gmail.com', 'good order', 'kjhgfdsmnbvcx', '2026-01-30 08:46:30'),
(36, 'Krisha Tamakuwala', 'krisha@gmail.com', 'good order', 'iuytrejhdmnc', '2026-01-30 09:01:54'),
(37, 'Krisha Tamakuwala', 'krisha@gmail.com', 'good order', 'jhgfdsabvcxzgfdsfdsa', '2026-01-30 09:04:00'),
(38, 'zc', 'zn@gmail.com', 'sdjhds', 'ddyhdh', '2026-01-30 09:06:39'),
(39, 'zxb', 'krisha@gmail.com', 'good order', 'zxzx', '2026-01-30 09:06:52'),
(40, 'adi', 'adi@gmail.com', 'asjas', 'shdhd', '2026-01-30 09:19:59'),
(41, 'ad', 'adi@gmail.com', 'as', 's', '2026-01-30 09:31:31'),
(42, 'yyyyyy', 'db@gmail.com', 'testtt', 'dsjh', '2026-01-30 09:34:49'),
(43, 'bhauna patel', 'riya123@gmail.com', 'testing', 'ashjh', '2026-01-30 09:38:18'),
(44, 'testtttttttttttttt', 'adiiioo@oogmail.com', 'yhhhh', 'dtgd', '2026-01-30 09:53:19'),
(45, 'okkkk', 'ok@gmail.com', 'adiii', 'test okkk', '2026-01-30 09:56:39'),
(46, 'chotu', 'hdsajh@gmail.com', 'good', 'i want to', '2026-01-30 09:59:13'),
(47, 'shreya', 'sk@gmail.com', 'bad product', 'i iw ant to complain', '2026-01-30 10:00:14'),
(48, 'sockes', 'kbhbh@gmail.com', 'hhhhh', 'hhhhhhdshbihbdsibcicbsdi', '2026-01-30 10:05:27'),
(49, 'fggg', 'fg@gmail.com', 'yey', 'boiii', '2026-01-30 10:08:09'),
(50, 'ooooooo', 'oooo@gmail.com', 'dsd', 'ss', '2026-01-30 10:10:57'),
(51, 'oooooooo', 'okoo@gmail.com', 'j', 'n', '2026-01-30 10:11:28'),
(52, 'hh', 'okoo@gmail.com', 'jhh', 'nbjh', '2026-01-30 10:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `order_items_tbl`
--

DROP TABLE IF EXISTS `order_items_tbl`;
CREATE TABLE IF NOT EXISTS `order_items_tbl` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `pvariation_id` int NOT NULL,
  `pimage_id` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`),
  KEY `pimage_id` (`pimage_id`),
  KEY `pvariation_id` (`pvariation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items_tbl`
--

INSERT INTO `order_items_tbl` (`item_id`, `order_id`, `product_id`, `pvariation_id`, `pimage_id`, `price`, `quantity`) VALUES
(15, 6, 57, 76, 1, 2000.00, 1),
(16, 7, 130, 150, 42, 2500.00, 1),
(17, 8, 130, 150, 42, 2500.00, 2),
(18, 9, 120, 140, 1, 880.00, 1),
(19, 10, 129, 149, 1, 2700.00, 1),
(20, 10, 128, 148, 8, 500.00, 1),
(21, 11, 120, 140, 1, 880.00, 2),
(22, 12, 129, 149, 1, 2700.00, 1),
(23, 13, 130, 150, 42, 2500.00, 1),
(24, 14, 121, 141, 42, 790.00, 1),
(25, 15, 129, 149, 1, 2700.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `order_tbl`
--

DROP TABLE IF EXISTS `order_tbl`;
CREATE TABLE IF NOT EXISTS `order_tbl` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address_id` int NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_status` enum('Paid','Unpaid') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Unpaid',
  `o_status` enum('Pending','Shipped','Delivered','Cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  KEY `address_id` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_tbl`
--

INSERT INTO `order_tbl` (`order_id`, `user_id`, `address_id`, `total_amount`, `payment_status`, `o_status`, `created_at`) VALUES
(5, 6, 9, 1420.00, 'Paid', 'Pending', '2026-02-21 10:57:05'),
(6, 6, 9, 2000.00, 'Paid', 'Delivered', '2026-02-26 14:37:39'),
(7, 6, 9, 2500.00, 'Paid', 'Delivered', '2026-02-26 14:48:32'),
(8, 6, 9, 5000.00, 'Paid', 'Pending', '2026-02-26 14:49:24'),
(9, 8, 10, 900.00, 'Paid', 'Pending', '2026-02-26 15:27:40'),
(10, 8, 10, 3200.00, 'Unpaid', 'Pending', '2026-02-26 15:35:56'),
(11, 11, 11, 1760.00, 'Paid', 'Pending', '2026-02-26 15:44:08'),
(12, 8, 10, 2700.00, 'Unpaid', 'Pending', '2026-02-27 22:07:08'),
(13, 8, 10, 2500.00, 'Unpaid', 'Pending', '2026-02-27 22:07:39'),
(14, 8, 10, 810.00, 'Unpaid', 'Pending', '2026-02-27 22:08:05'),
(15, 8, 10, 2700.00, 'Unpaid', 'Pending', '2026-02-27 22:08:26');

-- --------------------------------------------------------

--
-- Table structure for table `payments_tbl`
--

DROP TABLE IF EXISTS `payments_tbl`;
CREATE TABLE IF NOT EXISTS `payments_tbl` (
  `payment_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('UPI','Card','Netbanking','Wallet','Cash') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `py_status` enum('Success','Failed','Pending') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments_tbl`
--

INSERT INTO `payments_tbl` (`payment_id`, `order_id`, `amount`, `method`, `py_status`, `created_at`) VALUES
(3, 6, 2000.00, 'Cash', 'Pending', '2026-02-26 09:07:39'),
(4, 7, 2500.00, 'Cash', 'Pending', '2026-02-26 09:18:32'),
(5, 8, 5000.00, 'Cash', 'Pending', '2026-02-26 09:19:24'),
(6, 9, 900.00, 'UPI', 'Success', '2026-02-26 09:57:40'),
(7, 10, 3200.00, 'Cash', 'Pending', '2026-02-26 10:05:56'),
(8, 11, 1760.00, 'UPI', 'Success', '2026-02-26 10:14:08'),
(9, 12, 2700.00, 'Cash', 'Pending', '2026-02-27 16:37:08'),
(10, 13, 2500.00, 'Cash', 'Pending', '2026-02-27 16:37:39'),
(11, 14, 810.00, 'Cash', 'Pending', '2026-02-27 16:38:05'),
(12, 15, 2700.00, 'Cash', 'Pending', '2026-02-27 16:38:26');

-- --------------------------------------------------------

--
-- Table structure for table `product_image_tbl`
--

DROP TABLE IF EXISTS `product_image_tbl`;
CREATE TABLE IF NOT EXISTS `product_image_tbl` (
  `image_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `pvariation_id` int NOT NULL,
  `color_id` int NOT NULL,
  `f_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `b_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `third_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fourth_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `fifth_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tryon_image` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `i_status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`image_id`),
  KEY `product_id` (`product_id`),
  KEY `pvariation_id` (`pvariation_id`),
  KEY `product_image_tbl_ibfk_1` (`color_id`)
) ENGINE=InnoDB AUTO_INCREMENT=238 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_image_tbl`
--

INSERT INTO `product_image_tbl` (`image_id`, `product_id`, `pvariation_id`, `color_id`, `f_image`, `b_image`, `third_image`, `fourth_image`, `fifth_image`, `tryon_image`, `i_status`) VALUES
(1, 1, 1, 1, 'uploads/1771240100_1766489291_img_2-removebg-preview.png', 'uploads/1771240100_1766489291_img_1-removebg-preview.png', 'uploads/1771240100_1766489291_img_4-removebg-preview.png', 'uploads/1771240100_1766489291_img_3-removebg-preview.png', 'uploads/1771240100_1766489291_img_5-removebg-preview.png', '', '1'),
(3, 1, 1, 9, 'uploads/1771240122_1766489818_img_7-removebg-preview.png', 'uploads/1771240122_1766489818_img_6-removebg-preview.png', 'uploads/1771240122_1766489818_img_9-removebg-preview.png', 'uploads/1771240122_1766669453_img_4-removebg-preview.png', 'uploads/1771240122_1766669453_img_5-removebg-preview.png', '', '1'),
(4, 1, 1, 32, 'uploads/1771240144_1766552926_img_12-removebg-preview.png', 'uploads/1771240144_1766552926_img_11-removebg-preview.png', 'uploads/1771240144_1766552926_img_14-removebg-preview.png', 'uploads/1771240144_1766552926_img_13-removebg-preview.png', 'uploads/1771240144_1766552926_img_15-removebg-preview.png', '', '1'),
(5, 2, 2, 1, 'uploads/1771239853_1766567066_img_18-removebg-preview.png', 'uploads/1771239853_1766567066_img_17-removebg-preview.png', 'uploads/1771239853_1766567066_img_20-removebg-preview.png', 'uploads/1771239853_1766670667_img_3-removebg-preview.png', 'uploads/1771239853_1766670667_img_6-removebg-preview.png', '', '1'),
(6, 2, 2, 20, 'uploads/1771239877_1766567312_img_23-removebg-preview.png', 'uploads/1771239877_1766567312_img_22-removebg-preview.png', 'uploads/1771239877_1766567312_img_25-removebg-preview.png', 'uploads/1771239877_1766670731_img_3-removebg-preview.png', 'uploads/1771239877_1766670731_img_5-removebg-preview.png', '', '1'),
(7, 3, 3, 11, 'uploads/1771239665_1766568725_img_26-removebg-preview.png', 'uploads/1771239665_1766568725_img_25-removebg-preview.png', 'uploads/1771239665_1766568725_img_28-removebg-preview.png', 'uploads/1771239665_1766669243_img_13-removebg-preview.png', 'uploads/1771239665_1766669243_img_14-removebg-preview.png', '', '1'),
(8, 4, 4, 25, 'uploads/1771239516_1766671378_img_2-removebg-preview.png', 'uploads/1771239516_1766671378_img_1-removebg-preview.png', 'uploads/1771239516_1766671378_img_8-removebg-preview.png', 'uploads/1771239516_1766671378_img_3-removebg-preview.png', 'uploads/1771239516_1766671378_img_6-removebg-preview.png', '', '1'),
(9, 4, 4, 32, 'uploads/1771239540_1766671603_img_2-removebg-preview.png', 'uploads/1771239540_1766671603_img_1-removebg-preview.png', 'uploads/1771239540_1766671603_img_8-removebg-preview.png', 'uploads/1771239540_1766671603_img_3-removebg-preview.png', 'uploads/1771239540_1766671603_img_5-removebg-preview.png', '', '1'),
(10, 4, 4, 4, 'uploads/1771239572_1766672353_img_2-removebg-preview.png', 'uploads/1771239572_1766672353_img_1-removebg-preview.png', 'uploads/1771239572_1766672353_img_8-removebg-preview.png', 'uploads/1771239572_1766672353_img_4-removebg-preview.png', 'uploads/1771239572_1766672353_img_5-removebg-preview.png', '', '1'),
(11, 5, 5, 25, 'uploads/1771239363_1766674302_img_2-removebg-preview.png', 'uploads/1771239363_1766674302_img_1-removebg-preview.png', 'uploads/1771239363_1766674302_img_8-removebg-preview.png', 'uploads/1771239363_1766674302_img_3-removebg-preview.png', 'uploads/1771239363_1766674302_img_5-removebg-preview.png', '', '1'),
(12, 6, 6, 19, 'uploads/1771492294_1766674766_img_2-removebg-preview (1).png', 'uploads/1771492294_1766674766_img_1-removebg-preview (1).png', 'uploads/1771492294_1766674766_img_8-removebg-preview (1).png', 'uploads/1771492294_1766674766_img_3-removebg-preview (1).png', 'uploads/1771492294_1766674766_img_6-removebg-preview (1).png', '', '1'),
(14, 7, 7, 15, 'uploads/1771238927_1766676073_img_24-removebg-preview.png', 'uploads/1771238927_1766676073_img_23-removebg-preview.png', 'uploads/1771238927_1766676073_img_26-removebg-preview.png', 'uploads/1771238927_1766676073_img_25-removebg-preview.png', 'uploads/1771238927_1766676073_img_27-removebg-preview.png', '', '1'),
(15, 7, 7, 1, 'uploads/1771238975_1766676180_img_7-removebg-preview.png', 'uploads/1771238975_1766676180_img_11-removebg-preview.png', 'uploads/1771238975_1766676180_img_9-removebg-preview.png', 'uploads/1771238975_1766676180_img_8-removebg-preview.png', 'uploads/1771238975_1766676180_img_10-removebg-preview.png', '', '1'),
(16, 7, 8, 1, 'uploads/1771239109_1766674766_img_2-removebg-preview.png', 'uploads/1771239109_1766674766_img_1-removebg-preview.png', 'uploads/1771239109_1766674766_img_8-removebg-preview.png', 'uploads/1771239109_1766674766_img_3-removebg-preview.png', 'uploads/1771239109_1766674766_img_6-removebg-preview.png', '', '1'),
(17, 7, 9, 7, 'uploads/1771239234_1766676802_img_2-removebg-preview.png', 'uploads/1771239234_1766676802_img_1-removebg-preview.png', 'uploads/1771239234_1766676802_img_8-removebg-preview.png', 'uploads/1771239234_1766676802_img_4-removebg-preview.png', 'uploads/1771239234_1766676802_img_5-removebg-preview.png', '', '1'),
(18, 8, 10, 1, 'uploads/1771229990_1766677252_img_2-removebg-preview.png', 'uploads/1771229990_1766677252_img_1-removebg-preview.png', 'uploads/1771229990_1766677252_img_8-removebg-preview.png', 'uploads/1771229990_1766677252_img_3-removebg-preview.png', 'uploads/1771229990_1766677252_img_13-removebg-preview.png', '', '1'),
(19, 8, 10, 2, 'uploads/1771230017_1766677669_img_2-removebg-preview.png', 'uploads/1771230017_1766677669_img_1-removebg-preview.png', 'uploads/1771230017_1766677669_img_8-removebg-preview.png', 'uploads/1771230017_1766677669_img_3-removebg-preview.png', 'uploads/1771230017_1766677252_img_13-removebg-preview.png', '', '1'),
(20, 8, 11, 33, 'uploads/1771230062_1766678000_img_2-removebg-preview.png', 'uploads/1771230062_1766678000_img_1-removebg-preview.png', 'uploads/1771230062_1766678000_img_8-removebg-preview.png', 'uploads/1771230062_1766678000_img_4-removebg-preview.png', 'uploads/1771230062_1766678000_img_6-removebg-preview.png', '', '1'),
(21, 9, 12, 34, 'uploads/1771229621_1766679292_img_2-removebg-preview.png', 'uploads/1771229621_1766679292_img_1-removebg-preview.png', 'uploads/1771229621_1766679292_img_8-removebg-preview.png', 'uploads/1771229621_1766679292_img_15-removebg-preview.png', 'uploads/1771229621_1766679292_img_12-removebg-preview.png', '', '1'),
(22, 9, 13, 1, 'uploads/1771229645_1766679529_img_2-removebg-preview.png', 'uploads/1771229645_1766679529_img_1-removebg-preview.png', 'uploads/1771229645_1766679529_img_8-removebg-preview.png', 'uploads/1771229645_1766679529_img_4-removebg-preview.png', 'uploads/1771229645_1766679529_img_6-removebg-preview.png', '', '1'),
(23, 10, 14, 6, 'uploads/1771229471_1766679959_img_2-removebg-preview.png', 'uploads/1771229471_1766679959_img_1-removebg-preview.png', 'uploads/1771229471_1766679959_img_8-removebg-preview.png', 'uploads/1771229471_1766679959_img_3-removebg-preview.png', 'uploads/1771229471_1766679959_img_5-removebg-preview.png', '', '1'),
(24, 11, 15, 9, 'uploads/1771229381_1766680285_img_2-removebg-preview.png', 'uploads/1771229381_1766680285_img_1-removebg-preview.png', 'uploads/1771229381_1766680285_img_8-removebg-preview.png', 'uploads/1771229381_1766680285_img_3-removebg-preview.png', 'uploads/1771229381_1766680285_img_6-removebg-preview.png', '', '1'),
(25, 12, 16, 1, 'uploads/1771229152_1766680767_img_2-removebg-preview.png', 'uploads/1771229152_1766680767_img_1-removebg-preview.png', 'uploads/1771229152_1766680767_img_9-removebg-preview.png', 'uploads/1771229152_1766680767_img_4-removebg-preview.png', 'uploads/1771229152_1766680767_img_6-removebg-preview.png', '', '1'),
(26, 13, 17, 2, 'uploads/1771229014_1766721933_img_2-removebg-preview.png', 'uploads/1771229014_1766721933_img_1-removebg-preview.png', 'uploads/1771229014_1766721933_img_8-removebg-preview.png', 'uploads/1771229014_1766721933_img_3-removebg-preview.png', 'uploads/1771229014_1766721933_img_6-removebg-preview.png', '', '1'),
(27, 13, 17, 12, 'uploads/1771229040_1766722084_img_2-removebg-preview.png', 'uploads/1771229040_1766722084_img_1-removebg-preview.png', 'uploads/1771229040_1766722084_img_8-removebg-preview.png', 'uploads/1771229040_1766722084_img_3-removebg-preview.png', 'uploads/1771229040_1766722084_img_6-removebg-preview.png', '', '1'),
(28, 14, 18, 1, 'uploads/1771228768_1766722420_img_2-removebg-preview.png', 'uploads/1771228768_1766722420_img_1-removebg-preview.png', 'uploads/1771228768_1766722420_img_8-removebg-preview.png', 'uploads/1771228768_1766722420_img_3-removebg-preview.png', 'uploads/1771228768_1766722420_img_5-removebg-preview.png', '', '1'),
(29, 15, 19, 34, 'uploads/1771228342_1766722873_img_37-removebg-preview.png', 'uploads/1771228342_1766722873_img_45-removebg-preview.png', 'uploads/1771228342_1766722873_img_43-removebg-preview.png', 'uploads/1771228342_1766722873_img_38-removebg-preview.png', 'uploads/1771228342_1766722873_img_41-removebg-preview.png', '', '1'),
(30, 15, 19, 9, 'uploads/1771228410_1766722945_img_47-removebg-preview.png', 'uploads/1771228410_1766722945_img_55-removebg-preview.png', 'uploads/1771228410_1766722945_img_53-removebg-preview.png', 'uploads/1771228410_1766722945_img_48-removebg-preview.png', 'uploads/1771228410_1766722945_img_50-removebg-preview.png', '', '1'),
(31, 16, 20, 36, 'uploads/1771227669_1766723749_img_2-removebg-preview.png', 'uploads/1771227669_1766723749_img_1-removebg-preview.png', 'uploads/1771227669_1766723749_img_8-removebg-preview.png', 'uploads/1771227669_1766723749_img_3-removebg-preview.png', 'uploads/1771227669_1766723749_img_6-removebg-preview.png', '', '1'),
(32, 17, 22, 35, 'uploads/1771227345_1766724287_img_2-removebg-preview.png', 'uploads/1771227345_1766724287_img_1-removebg-preview.png', 'uploads/1771227345_1766724287_img_8-removebg-preview.png', 'uploads/1771227345_1766724287_img_4-removebg-preview.png', 'uploads/1771227345_1766724287_img_5-removebg-preview.png', '', '1'),
(33, 18, 23, 6, 'uploads/1771225652_1766742731_img_50-removebg-preview.png', 'uploads/1771225652_1766742731_img_58-removebg-preview.png', 'uploads/1771225652_1766742731_img_56-removebg-preview.png', 'uploads/1771225652_1766742731_img_52-removebg-preview.png', 'uploads/1771225652_1766742731_img_54-removebg-preview.png', '', '1'),
(34, 17, 21, 33, 'uploads/1771227456_1766743093_img_60-removebg-preview.png', 'uploads/1771227456_1766743093_img_68-removebg-preview.png', 'uploads/1771227456_1766743155_img_76-removebg-preview.png', 'uploads/1771227456_1766743093_img_71-removebg-preview.png', 'uploads/1771227456_1766743093_img_64-removebg-preview.png', '', '1'),
(35, 17, 21, 1, 'uploads/1771227507_1766743155_img_74-removebg-preview.png', 'uploads/1771227507_1766743155_img_82-removebg-preview.png', 'uploads/1771227507_1766743155_img_80-removebg-preview.png', 'uploads/1771227507_1766743155_img_76-removebg-preview.png', 'uploads/1771227507_1766743155_img_78-removebg-preview.png', '', '1'),
(36, 17, 22, 6, 'uploads/1771227537_1766743468_img_89-removebg-preview.png', 'uploads/1771227537_1766743468_img_88-removebg-preview.png', 'uploads/1771227537_1766743468_img_95-removebg-preview.png', 'uploads/1771227537_1766743468_img_90-removebg-preview.png', 'uploads/1771227537_1766743468_img_91-removebg-preview.png', '', '1'),
(37, 19, 25, 35, 'uploads/1771225318_1766744121_img_88-removebg-preview.png', 'uploads/1771225318_1766744121_img_96-removebg-preview.png', 'uploads/1771225318_1766744121_img_94-removebg-preview.png', 'uploads/1771225318_1766744121_img_90-removebg-preview.png', 'uploads/1771225318_1766744121_img_92-removebg-preview.png', '', '1'),
(38, 19, 24, 1, 'uploads/1771225371_1766744257_img_88-removebg-preview (1).png', 'uploads/1771225371_1766744257_img_96-removebg-preview (1).png', 'uploads/1771225371_1766744257_img_94-removebg-preview (1).png', 'uploads/1771225371_1766744257_img_90-removebg-preview (1).png', 'uploads/1771225371_1766744257_img_92-removebg-preview (1).png', '', '1'),
(39, 19, 26, 1, 'uploads/1771225405_1766744405_img_87-removebg-preview.png', 'uploads/1771225405_1766744405_img_95-removebg-preview.png', 'uploads/1771225405_1766744405_img_93-removebg-preview.png', 'uploads/1771225405_1766744405_img_89-removebg-preview.png', 'uploads/1771225405_1766744405_img_90-removebg-preview.png', '', '1'),
(40, 20, 27, 1, 'uploads/1771223835_1766745712_img_76-removebg-preview.png', 'uploads/1771223835_1766745712_img_75-removebg-preview.png', 'uploads/1771223835_1766745712_img_78-removebg-preview.png', 'uploads/1771223835_1766745712_img_77-removebg-preview.png', 'uploads/1771223835_1766745712_img_79-removebg-preview.png', '', '1'),
(41, 20, 28, 4, 'uploads/1771224316_1766745944_img_78-removebg-preview.png', 'uploads/1771224316_1766746685_img_77-removebg-preview.png', 'uploads/1771224316_1766745944_img_90-removebg-preview.png', 'uploads/1771224316_1766745944_img_80-removebg-preview.png', 'uploads/1771224316_1766745944_img_82-removebg-preview.png', '', '1'),
(42, 20, 28, 37, 'uploads/1771224583_1766746438_img_2-removebg-preview.png', 'uploads/1771224583_1766746438_img_1-removebg-preview.png', 'uploads/1771224583_1766746438_img_8-removebg-preview.png', 'uploads/1771224583_1766746438_img_3-removebg-preview.png', 'uploads/1771224583_1766746438_img_6-removebg-preview.png', '', '1'),
(43, 21, 29, 34, 'uploads/1771000241_1766747022_img_90-removebg-preview.png', 'uploads/1771000241_1766747022_img_89-removebg-preview.png', 'uploads/1771000241_1766747022_img_96-removebg-preview.png', 'uploads/1771000241_1766747022_img_92-removebg-preview.png', 'uploads/1771000241_1766747022_img_93-removebg-preview.png', '', '1'),
(44, 21, 29, 38, 'uploads/1771000272_1766747308_img_94-removebg-preview.png', 'uploads/1771000272_1766747308_img_102-removebg-preview.png', 'uploads/1771000272_1766747308_img_100-removebg-preview.png', 'uploads/1771000272_1766747308_img_95-removebg-preview.png', 'uploads/1771000272_1766747308_img_97-removebg-preview.png', '', '1'),
(45, 22, 30, 39, 'uploads/1771000205_1766747708_img_2-removebg-preview.png', 'uploads/1771000205_1766747708_img_1-removebg-preview.png', 'uploads/1771000205_1766747708_img_8-removebg-preview.png', 'uploads/1771000205_1766747708_img_4-removebg-preview.png', 'uploads/1771000205_1766747708_img_5-removebg-preview.png', '', '1'),
(46, 23, 31, 33, 'uploads/1771000172_1766747995_img_1-removebg-preview.png', 'uploads/1771000172_1766747995_img_2-removebg-preview.png', 'uploads/1771000172_1766747995_img_3-removebg-preview.png', 'uploads/1771000172_1766747995_img_6-removebg-preview.png', 'uploads/1771000172_1766747995_img_9-removebg-preview.png', '', '1'),
(47, 24, 32, 6, 'uploads/1770999394_1766748366_img_2-removebg-preview.png', 'uploads/1770999394_1766748366_img_1-removebg-preview.png', 'uploads/1770999394_1766748366_img_8-removebg-preview.png', 'uploads/1770999394_1766748366_img_3-removebg-preview.png', 'uploads/1770999394_1766748366_img_6-removebg-preview.png', '', '1'),
(48, 25, 33, 1, 'uploads/1770999316_1766756078_img_100-removebg-preview.png', 'uploads/1770999316_1766756078_img_106-removebg-preview.png', 'uploads/1770999316_1766748366_img_8-removebg-preview.png', 'uploads/1770999316_1766756078_img_102-removebg-preview.png', 'uploads/1770999316_1766756078_img_104-removebg-preview.png', '', '1'),
(49, 25, 33, 40, 'uploads/1770999362_1766756450_img_106-removebg-preview.png', 'uploads/1770999362_1766756450_img_105-removebg-preview.png', 'uploads/1770999362_1766756450_img_112-removebg-preview.png', 'uploads/1770999362_1766756450_img_108-removebg-preview.png', 'uploads/1770999362_1766756450_img_110-removebg-preview.png', '', '1'),
(50, 26, 34, 1, 'uploads/1770999278_1766926754_img_112-removebg-preview.png', 'uploads/1770999278_1766926754_img_111-removebg-preview.png', 'uploads/1770999278_1766756450_img_112-removebg-preview.png', 'uploads/1770999278_1766926754_img_114-removebg-preview.png', 'uploads/1770999278_1766926754_img_116-removebg-preview.png', '', '1'),
(51, 27, 35, 33, 'uploads/1770999245_1766927175_img_2-removebg-preview.png', 'uploads/1770999245_1766927175_img_1-removebg-preview.png', 'uploads/1770999245_1766926754_img_118-removebg-preview.png', 'uploads/1770999245_1766927175_img_4-removebg-preview.png', 'uploads/1770999245_1766927175_img_5-removebg-preview.png', '', '1'),
(52, 28, 36, 1, 'uploads/1770998426_1766928180_img_2-removebg-preview.png', 'uploads/1770998426_1766928180_img_1-removebg-preview.png', 'uploads/1770998426_1766928180_img_8-removebg-preview.png', 'uploads/1770998426_1766928180_img_3-removebg-preview.png', 'uploads/1770998426_1766928180_img_5-removebg-preview.png', '', '1'),
(53, 28, 37, 9, 'uploads/1770998466_1766928421_img_2-removebg-preview.png', 'uploads/1770998466_1766928421_img_1-removebg-preview.png', 'uploads/1770998466_1766928421_img_5-removebg-preview.png', 'uploads/1770998466_1766928421_img_8-removebg-preview.png', 'uploads/1770998466_1766928421_img_3-removebg-preview.png', '', '1'),
(54, 28, 37, 11, 'uploads/1770998515_1766937333_img_2-removebg-preview.png', 'uploads/1770998515_1766937333_img_1-removebg-preview.png', 'uploads/1770998515_1766937333_img_8-removebg-preview.png', 'uploads/1770998515_1766937333_img_3-removebg-preview.png', 'uploads/1770998515_1766937333_img_5-removebg-preview.png', '', '1'),
(55, 29, 38, 1, 'uploads/1770998363_1766937905_img_4-removebg-preview.png', 'uploads/1770998363_1766937905_img_1-removebg-preview.png', 'uploads/1770998363_1766937905_img_6-removebg-preview.png', 'uploads/1770998363_1766937905_img_5-removebg-preview.png', 'uploads/1770998363_1766937905_img_2-removebg-preview.png', '', '1'),
(56, 30, 39, 25, 'uploads/1770998289_1766938272_img_2-removebg-preview.png', 'uploads/1770998289_1766938272_img_1-removebg-preview.png', 'uploads/1770998289_1766938272_img_8-removebg-preview.png', 'uploads/1770998289_1766938272_img_3-removebg-preview.png', 'uploads/1770998289_1766938272_img_5-removebg-preview.png', '', '1'),
(57, 30, 39, 1, 'uploads/1770998326_1766939095_img_2-removebg-preview.png', 'uploads/1770998326_1766939095_img_1-removebg-preview.png', 'uploads/1770998326_1766939095_img_8-removebg-preview.png', 'uploads/1770998326_1766939095_img_4-removebg-preview.png', 'uploads/1770998326_1766939095_img_5-removebg-preview.png', '', '1'),
(58, 31, 40, 41, 'uploads/1770995275_1766939571_img_2-removebg-preview.png', 'uploads/1770995275_1766939571_img_1-removebg-preview.png', 'uploads/1770995275_1766939571_img_9-removebg-preview.png', 'uploads/1770995275_1766939571_img_14-removebg-preview.png', 'uploads/1770995275_1766939571_img_15-removebg-preview.png', '', '1'),
(59, 29, 38, 25, 'uploads/1770998396_1766940193_img_2-removebg-preview.png', 'uploads/1770998396_1766940193_img_1-removebg-preview.png', 'uploads/1770998396_1766940193_img_8-removebg-preview.png', 'uploads/1770998396_1766940193_img_3-removebg-preview.png', 'uploads/1770998396_1766940193_img_6-removebg-preview.png', '', '1'),
(60, 33, 41, 33, 'uploads/1770996264_1766941733_img_2-removebg-preview.png', 'uploads/1770996264_1766941733_img_1-removebg-preview.png', 'uploads/1770996264_1766941733_img_4-removebg-preview.png', 'uploads/1770996264_1766941733_img_3-removebg-preview.png', 'uploads/1770996264_1766941792_img_5-removebg-preview.png', '', '1'),
(61, 33, 41, 1, 'uploads/1770995679_1766944326_img_2-removebg-preview.png', 'uploads/1770995679_1766944326_img_1__1_-removebg-preview.png', 'uploads/1770995679_1766944326_img_4-removebg-preview.png', 'uploads/1770995679_1766944326_img_3-removebg-preview.png', 'uploads/1770995679_1766944326_img_5-removebg-preview.png', '', '1'),
(62, 33, 41, 21, 'uploads/1770996063_1766944533_img_2-removebg-preview.png', 'uploads/1770996063_1766944533_img_10-removebg-preview.png', 'uploads/1770996063_1766944533_img_8-removebg-preview.png', 'uploads/1770996063_1766944533_img_4-removebg-preview.png', 'uploads/1770996063_1766944533_img_6-removebg-preview.png', '', '1'),
(63, 33, 41, 9, 'uploads/1770995923_1766944699_img_2-removebg-preview.png', 'uploads/1770995923_1766944699_img_1-removebg-preview.png', 'uploads/1770995923_1766944699_img_8-removebg-preview.png', 'uploads/1770995923_1766944699_img_3-removebg-preview.png', 'uploads/1770995923_1766944699_img_5-removebg-preview.png', '', '1'),
(64, 33, 41, 40, 'uploads/1770996464_1766945069_img_2-removebg-preview.png', 'uploads/1770996464_1766945069_img_1-removebg-preview.png', 'uploads/1770996464_1766945069_img_8-removebg-preview.png', 'uploads/1770996464_1766945069_img_3-removebg-preview.png', 'uploads/1770996464_1766945069_img_5-removebg-preview.png', '', '1'),
(65, 33, 42, 33, 'uploads/1770996974_1766945962_img_2-removebg-preview.png', 'uploads/1770996974_1766945962_img_1-removebg-preview.png', 'uploads/1770996974_1766945962_img_8-removebg-preview.png', 'uploads/1770996974_1766945962_img_4-removebg-preview.png', 'uploads/1770996974_1766945962_img_6-removebg-preview.png', '', '1'),
(66, 33, 43, 32, 'uploads/1770997132_1766945725_img_2-removebg-preview.png', 'uploads/1770997132_1766945725_img_1-removebg-preview.png', 'uploads/1770997132_1766945725_img_8-removebg-preview.png', 'uploads/1770997132_1766945725_img_3-removebg-preview.png', 'uploads/1770997132_1766945725_img_5-removebg-preview.png', '', '1'),
(68, 33, 43, 1, 'uploads/1770996740_1766946122_img_2-removebg-preview.png', 'uploads/1770996740_1766946122_img_1-removebg-preview.png', 'uploads/1770996740_1766946122_img_8-removebg-preview.png', 'uploads/1770996740_1766946122_img_3-removebg-preview.png', 'uploads/1770996740_1766946122_img_5-removebg-preview.png', '', '1'),
(69, 33, 43, 3, 'uploads/1770997271_1766946368_img_2-removebg-preview.png', 'uploads/1770997271_1766946368_img_1-removebg-preview.png', 'uploads/1770997271_1766946368_img_4-removebg-preview.png', 'uploads/1770997271_1766946368_img_3-removebg-preview.png', 'uploads/1770997271_1766946368_img_5-removebg-preview.png', '', '1'),
(70, 34, 44, 1, 'uploads/1770994853_1766946645_img_2-removebg-preview.png', 'uploads/1770994853_1766946645_img_1-removebg-preview.png', 'uploads/1770994853_1766946645_img_8-removebg-preview (1).png', 'uploads/1770994853_1766946645_img_3-removebg-preview.png', 'uploads/1770994853_1766946645_img_5-removebg-preview.png', '', '1'),
(71, 34, 45, 2, 'uploads/1770994983_1766946759_img_2-removebg-preview.png', 'uploads/1770994983_1766946759_img_1-removebg-preview.png', 'uploads/1770994983_1766946759_img_8-removebg-preview.png', 'uploads/1770994983_1766946759_img_3-removebg-preview.png', 'uploads/1770994983_1766946759_img_5-removebg-preview.png', '', '1'),
(72, 34, 45, 1, 'uploads/1770995018_1766946873_img_2-removebg-preview.png', 'uploads/1770995018_1766946873_img_1-removebg-preview.png', 'uploads/1770995018_1766946873_img_8-removebg-preview.png', 'uploads/1770995018_1766946873_img_4-removebg-preview.png', 'uploads/1770995018_1766946873_img_5-removebg-preview.png', '', '1'),
(73, 35, 46, 1, 'uploads/1770994354_1766947252_img_2-removebg-preview.png', 'uploads/1770994354_1766947252_img_1-removebg-preview.png', 'uploads/1770994354_1766947252_img_8-removebg-preview.png', 'uploads/1770994354_1766947252_img_4-removebg-preview.png', 'uploads/1770994354_1766947252_img_5-removebg-preview.png', '', '1'),
(74, 36, 47, 32, 'uploads/1770994079_1766947729_img_2-removebg-preview (1).png', 'uploads/1770994079_1766947729_img_1-removebg-preview.png', 'uploads/1770994079_1766947729_img_8-removebg-preview.png', 'uploads/1770994079_1766947729_img_3-removebg-preview.png', 'uploads/1770994079_1766947729_img_6-removebg-preview.png', '', '1'),
(75, 36, 48, 1, 'uploads/1770994110_1766947880_img_2-removebg-preview.png', 'uploads/1770994110_1766947880_img_1-removebg-preview.png', 'uploads/1770994110_1766947880_img_8-removebg-preview.png', 'uploads/1770994110_1766947880_img_3-removebg-preview.png', 'uploads/1770994110_1766947880_img_5-removebg-preview.png', '', '1'),
(76, 36, 48, 33, 'uploads/1770994149_1766947996_img_2-removebg-preview.png', 'uploads/1770994149_1766947996_img_1-removebg-preview.png', 'uploads/1770994149_1766947996_img_8-removebg-preview.png', 'uploads/1770994149_1766947996_img_3-removebg-preview.png', 'uploads/1770994149_1766947996_img_5-removebg-preview.png', '', '1'),
(77, 36, 48, 40, 'uploads/1770994185_1766948169_img_2-removebg-preview.png', 'uploads/1770994185_1766948169_img_1-removebg-preview.png', 'uploads/1770994185_1766948169_img_5-removebg-preview.png', 'uploads/1770994185_1766948169_img_4-removebg-preview.png', 'uploads/1770994185_1766948169_img_6-removebg-preview.png', '', '1'),
(78, 37, 49, 11, 'uploads/1770992246_1766948538_img_2-removebg-preview.png', 'uploads/1770992246_1766948538_img_1-removebg-preview.png', 'uploads/1770992246_1766948538_img_7-removebg-preview.png', 'uploads/1770992246_1766948538_img_3-removebg-preview.png', 'uploads/1770992246_1766948538_img_3-removebg-preview (1).png', '', '1'),
(79, 38, 50, 25, 'uploads/1770992291_1766948757_img_2-removebg-preview.png', 'uploads/1770992291_1766948757_img_1-removebg-preview.png', 'uploads/1770992291_1766948757_img_8-removebg-preview.png', 'uploads/1770992291_1766948757_img_3-removebg-preview.png', 'uploads/1770992291_1766948757_img_5-removebg-preview.png', '', '1'),
(80, 38, 50, 23, 'uploads/1770993334_1766948840_img_2-removebg-preview.png', 'uploads/1770993334_1766948840_img_1-removebg-preview.png', 'uploads/1770993334_1766948840_img_8-removebg-preview.png', 'uploads/1770993334_1766948840_img_4-removebg-preview.png', 'uploads/1770993334_1766948840_img_6-removebg-preview.png', '', '1'),
(81, 38, 51, 23, 'uploads/1770993369_1766948971_img_2-removebg-preview.png', 'uploads/1770993369_1766948971_img_1-removebg-preview.png', 'uploads/1770993369_1766948971_img_8-removebg-preview.png', 'uploads/1770993369_1766948971_img_3-removebg-preview.png', 'uploads/1770993369_1766948971_img_5-removebg-preview.png', '', '1'),
(82, 38, 51, 1, 'uploads/1770993398_1766949092_img_2-removebg-preview.png', 'uploads/1770993398_1766949092_img_1-removebg-preview.png', 'uploads/1770993398_1766949092_img_11-removebg-preview.png', 'uploads/1770993398_1766949092_img_6-removebg-preview.png', 'uploads/1770993398_1766949092_img_9-removebg-preview.png', '', '1'),
(83, 39, 52, 5, 'uploads/1770631267_1766949415_img_2-removebg-preview.png', 'uploads/1770631267_1766949415_img_1-removebg-preview.png', 'uploads/1770631267_1766949415_img_8-removebg-preview.png', 'uploads/1770631267_1766949415_img_3-removebg-preview.png', 'uploads/1770631267_1766949415_img_5-removebg-preview.png', '', '1'),
(84, 39, 52, 43, 'uploads/1770631300_1766949572_img_2-removebg-preview.png', 'uploads/1770631300_1766949572_img_1-removebg-preview.png', 'uploads/1770631300_1766949572_img_4-removebg-preview.png', 'uploads/1770631300_1766949572_img_3-removebg-preview.png', 'uploads/1770631300_1766949572_img_5-removebg-preview.png', '', '1'),
(85, 39, 54, 4, 'uploads/1770631337_1766949661_img_2-removebg-preview.png', 'uploads/1770631337_1766949661_img_1-removebg-preview.png', 'uploads/1770631337_1766949661_img_9-removebg-preview.png', 'uploads/1770631337_1766949661_img_3-removebg-preview.png', 'uploads/1770631337_1766949661_img_5-removebg-preview.png', '', '1'),
(86, 39, 53, 1, 'uploads/1770631376_1766949749_img_2-removebg-preview (1).png', 'uploads/1770631376_1766949749_img_1-removebg-preview.png', 'uploads/1770631376_1766949749_img_4-removebg-preview.png', 'uploads/1770631376_1766949749_img_3-removebg-preview (1).png', 'uploads/1770631376_1766949749_img_5-removebg-preview (1).png', '', '1'),
(87, 39, 53, 3, 'uploads/1770631421_1766949905_img_2-removebg-preview.png', 'uploads/1770631421_1766949905_img_1-removebg-preview.png', 'uploads/1770631421_1766949905_img_9-removebg-preview.png', 'uploads/1770631421_1766949905_img_14-removebg-preview.png', 'uploads/1770631421_1766949905_img_15-removebg-preview.png', '', '1'),
(88, 41, 56, 1, 'uploads/1770628853_1766988254_img_2-removebg-preview (1).png', 'uploads/1770628853_1766988254_img_1-removebg-preview (1).png', 'uploads/1770628853_1766988254_img_8-removebg-preview (1).png', 'uploads/1770628853_1766988254_img_3-removebg-preview (1).png', 'uploads/1770628853_1766988254_img_5-removebg-preview (1).png', '', '1'),
(89, 41, 56, 2, 'uploads/1770628889_1766995340_img_2-removebg-preview (1).png', 'uploads/1770628889_1766995340_img_1-removebg-preview (1).png', 'uploads/1770628889_1766995340_img_8-removebg-preview (1).png', 'uploads/1770628889_1766995340_img_3-removebg-preview (1).png', 'uploads/1770628889_1766995340_img_5-removebg-preview (1).png', '', '1'),
(90, 41, 56, 23, 'uploads/1770628937_1766995655_img_2-removebg-preview.png', 'uploads/1770628937_1766995655_img_1-removebg-preview.png', 'uploads/1770628937_1766995655_img_4-removebg-preview.png', 'uploads/1770628937_1766995890_grey-transparent__1_-removebg-preview.png', 'uploads/1770628937_1766995890_grey-transparent__2_-removebg-preview.png', '', '1'),
(91, 42, 57, 44, 'uploads/1770627642_1766998776_img_2-removebg-preview.png', 'uploads/1770627642_1766998776_img_1-removebg-preview.png', 'uploads/1770627642_1766998776_img_8-removebg-preview.png', 'uploads/1770627642_1766998776_img_3-removebg-preview.png', 'uploads/1770627642_1766998776_img_5-removebg-preview.png', '', '1'),
(92, 41, 58, 6, 'uploads/1770629238_1766999136_img_3-removebg-preview.png', 'uploads/1770629238_1766999136_img_1-removebg-preview.png', 'uploads/1770629238_1766999136_img_9-removebg-preview.png', 'uploads/1770629238_1766999136_img_5-removebg-preview.png', 'uploads/1770629238_1766999136_img_7-removebg-preview.png', '', '1'),
(93, 41, 58, 1, 'uploads/1770629861_1766999481_img_2-removebg-preview.png', 'uploads/1770629861_1766999481_img_1-removebg-preview.png', 'uploads/1770629861_1766999481_img_4-removebg-preview.png', 'uploads/1770629861_1766999481_img_3-removebg-preview.png', 'uploads/1770629861_1766999481_img_5-removebg-preview.png', '', '1'),
(94, 43, 59, 42, 'uploads/1770627301_1766999802_img_1-removebg-preview.png', 'uploads/1770627301_1766999802_img_2-removebg-preview.png', 'uploads/1770627301_1766999802_img_6-removebg-preview.png', 'uploads/1770627301_1766999802_img_3-removebg-preview.png', 'uploads/1770627301_1766999802_img_4-removebg-preview.png', '', '1'),
(95, 41, 56, 3, 'uploads/1770629292_1767000224_img_2-removebg-preview.png', 'uploads/1770629292_1767000224_img_1-removebg-preview.png', 'uploads/1770629292_1767000224_img_8-removebg-preview.png', 'uploads/1770629292_1767000224_img_3-removebg-preview.png', 'uploads/1770629292_1767000224_img_5-removebg-preview.png', '', '1'),
(96, 44, 60, 1, 'uploads/1770627097_1767000846_img_2-removebg-preview.png', 'uploads/1770627097_1767000846_img_1-removebg-preview.png', 'uploads/1770627097_1767000846_img_8-removebg-preview.png', 'uploads/1770627097_1767000846_img_4-removebg-preview.png', 'uploads/1770627097_1767000846_img_5-removebg-preview.png', '', '1'),
(97, 45, 61, 40, 'uploads/1771492078_1767019677_img_2-removebg-preview (1).png', 'uploads/1771492078_1767019677_img_1-removebg-preview (1).png', 'uploads/1771492078_1767019677_img_8-removebg-preview (1).png', 'uploads/1771492078_1767019677_img_11-removebg-preview (1).png', 'uploads/1771492078_1767019677_img_12-removebg-preview (1).png', '', '1'),
(98, 46, 62, 20, 'uploads/1770626831_1767020050_img_2-removebg-preview (1).png', 'uploads/1770626831_1767020050_img_1-removebg-preview (1).png', 'uploads/1770626831_1767020050_img_8-removebg-preview (1).png', 'uploads/1770626831_1767020050_img_3-removebg-preview (1).png', 'uploads/1770626831_1767020050_img_6-removebg-preview (1).png', '', '1'),
(99, 41, 58, 34, 'uploads/1770629655_1767020239_img_2-removebg-preview.png', 'uploads/1770629655_1767020239_img_1-removebg-preview.png', 'uploads/1770629655_1767020239_img_8-removebg-preview.png', 'uploads/1770629655_1767020239_img_3-removebg-preview.png', 'uploads/1770629655_1767020239_img_6-removebg-preview.png', '', '1'),
(100, 41, 56, 4, 'uploads/1770629368_1767020396_img_2-removebg-preview (1).png', 'uploads/1770629368_1767020396_img_1-removebg-preview (1).png', 'uploads/1770629368_1767020396_img_8-removebg-preview (1).png', 'uploads/1770629368_1767020396_img_3-removebg-preview (1).png', 'uploads/1770629368_1767020396_img_5-removebg-preview (1).png', '', '1'),
(101, 47, 63, 8, 'uploads/1770626723_1767021575_img_2-removebg-preview.png', 'uploads/1770626723_1767021575_img_1-removebg-preview.png', 'uploads/1770626723_1767021575_img_8-removebg-preview.png', 'uploads/1770626723_1767021575_img_3-removebg-preview.png', 'uploads/1770626723_1767021575_img_6-removebg-preview.png', '', '1'),
(102, 47, 64, 30, 'uploads/1770626780_1767021858_img_2-removebg-preview.png', 'uploads/1770626780_1767021858_img_1-removebg-preview.png', 'uploads/1770626780_1767021858_img_4-removebg-preview.png', 'uploads/1770626780_1767021858_img_3-removebg-preview.png', 'uploads/1770626780_1767021858_img_5-removebg-preview.png', '', '1'),
(104, 41, 56, 25, 'uploads/1770629425_1767022321_img_2-removebg-preview (1).png', 'uploads/1770629425_1767022321_img_1-removebg-preview (1).png', 'uploads/1770629425_1767022321_img_4-removebg-preview (1).png', 'uploads/1770629425_1767022321_img_3-removebg-preview (1).png', 'uploads/1770629425_1767022321_img_5-removebg-preview (1).png', '', '1'),
(105, 48, 66, 1, 'uploads/1770626660_1767022705_img_2-removebg-preview.png', 'uploads/1770626660_1767022705_img_1-removebg-preview.png', 'uploads/1770626660_1767022705_img_8-removebg-preview.png', 'uploads/1770626660_1767022705_img_4-removebg-preview.png', 'uploads/1770626660_1767022705_img_5-removebg-preview.png', '', '1'),
(106, 49, 67, 25, 'uploads/1770626566_1767023107_img_2-removebg-preview.png', 'uploads/1770626566_1767023107_img_1-removebg-preview.png', 'uploads/1770626566_1767023107_img_8-removebg-preview.png', 'uploads/1770626566_1767023107_img_11-removebg-preview.png', 'uploads/1770626566_1767023107_img_6-removebg-preview.png', '', '1'),
(107, 50, 68, 1, 'uploads/1770622559_1767099905_img_2-removebg-preview.png', 'uploads/1770622559_1767099905_img_1-removebg-preview.png', 'uploads/1770622559_1767099905_img_9-removebg-preview.png', 'uploads/1770622559_1767099905_img_5-removebg-preview.png', 'uploads/1770622559_1767099905_img_6-removebg-preview.png', '', '1'),
(108, 50, 68, 34, 'uploads/1770622605_1767100194_img_2-removebg-preview.png', 'uploads/1770622605_1767100194_img_2-removebg-preview.png', 'uploads/1770622605_1767100194_img_10-removebg-preview.png', 'uploads/1770622605_1767100194_img_15-removebg-preview.png', 'uploads/1770622605_1767100194_img_16-removebg-preview.png', '', '1'),
(109, 51, 69, 7, 'uploads/1770622476_1767100484_img_2-removebg-preview.png', 'uploads/1770622476_1767100484_img_1-removebg-preview.png', 'uploads/1770622476_1767100484_img_11-removebg-preview.png', 'uploads/1770622476_1767100484_img_9-removebg-preview.png', 'uploads/1770622476_1767100484_img_8-removebg-preview.png', '', '1'),
(110, 50, 70, 42, 'uploads/1770622667_1767101034_img_2-removebg-preview.png', 'uploads/1770622667_1767101034_img_1-removebg-preview.png', 'uploads/1770622667_1767101034_img_8-removebg-preview.png', 'uploads/1770622667_1767101034_img_3-removebg-preview.png', 'uploads/1770622667_1767101034_img_5-removebg-preview.png', '', '1'),
(111, 50, 70, 26, 'uploads/1770622706_1767101280_img_2-removebg-preview.png', 'uploads/1770622706_1767101280_img_1-removebg-preview.png', 'uploads/1770622706_1767101280_img_8-removebg-preview.png', 'uploads/1770622706_1767101280_img_4-removebg-preview.png', 'uploads/1770622706_1767101280_img_5-removebg-preview.png', '', '1'),
(112, 52, 71, 21, 'uploads/1770375573_1767102268_img_2-removebg-preview.png', 'uploads/1770375573_1767102268_img_1-removebg-preview.png', 'uploads/1770375573_1767102268_img_8-removebg-preview.png', 'uploads/1770375573_1767102268_img_3-removebg-preview.png', 'uploads/1770375573_1767102268_img_7-removebg-preview.png', '', '1'),
(113, 50, 72, 25, 'uploads/1770622762_1767102580_img_2-removebg-preview.png', 'uploads/1770622762_1767102580_img_1-removebg-preview.png', 'uploads/1770622762_1767102580_img_8-removebg-preview.png', 'uploads/1770622762_1767102580_img_3-removebg-preview.png', 'uploads/1770622762_1767102580_img_5-removebg-preview.png', '', '1'),
(114, 53, 73, 1, 'uploads/1770371013_1767102906_img_2-removebg-preview (1).png', 'uploads/1770371013_1767102906_img_1-removebg-preview (1).png', 'uploads/1770371013_1767102906_img_12-removebg-preview (1).png', 'uploads/1770371013_1767102906_img_3-removebg-preview (1).png', 'uploads/1770371013_1767102906_img_7-removebg-preview (1).png', '', '1'),
(115, 54, 74, 39, 'uploads/1770375271_1767103265_img_2-removebg-preview.png', 'uploads/1770375271_1767103265_img_1-removebg-preview.png', 'uploads/1770375271_1767103265_img_4-removebg-preview.png', 'uploads/1770375271_1767103265_img_3-removebg-preview.png', 'uploads/1770375271_1767103265_img_5-removebg-preview.png', '', '1'),
(116, 54, 74, 34, 'uploads/1770375353_1767103408_img_2-removebg-preview.png', 'uploads/1770375353_1767103408_img_1-removebg-preview.png', 'uploads/1770375353_1767103408_img_4-removebg-preview.png', 'uploads/1770375353_1767103408_img_3-removebg-preview.png', 'uploads/1770375353_1767103408_img_5-removebg-preview.png', '', '1'),
(117, 54, 74, 42, 'uploads/1770375521_1767103546_img_2-removebg-preview.png', 'uploads/1770375521_1767103546_img_1-removebg-preview.png', 'uploads/1770375521_1767103546_img_4-removebg-preview.png', 'uploads/1770375521_1767103546_img_3-removebg-preview.png', 'uploads/1770375521_1767103546_img_5-removebg-preview.png', '', '1'),
(118, 56, 75, 44, 'uploads/1767103880_img_2.jpg', 'uploads/1767103880_img_1.jpg', 'uploads/1767103880_img_4.jpg', 'uploads/1767103880_img_3.jpg', 'uploads/1767103880_img_5.jpg', '', '1'),
(119, 57, 76, 34, 'uploads/1770374733_1767196256_img_2-removebg-preview.png', 'uploads/1770374733_1767196256_img_1-removebg-preview.png', 'uploads/1770374733_1767196256_img_8-removebg-preview.png', 'uploads/1770374733_1767196256_img_3-removebg-preview.png', 'uploads/1770374733_1767196256_img_5-removebg-preview.png', '', '1'),
(120, 57, 76, 38, 'uploads/1770374829_1767196417_img_2-removebg-preview.png', 'uploads/1770374829_1767196417_img_1-removebg-preview.png', 'uploads/1770374829_1767196417_img_8-removebg-preview.png', 'uploads/1770374829_1767196417_img_3-removebg-preview.png', 'uploads/1770374829_1767196417_img_5-removebg-preview.png', '', '1'),
(121, 57, 76, 42, 'uploads/1770374935_1767196589_img_2-removebg-preview.png', 'uploads/1770374935_1767196589_img_1-removebg-preview.png', 'uploads/1770374935_1767196589_img_4-removebg-preview.png', 'uploads/1770374935_1767196589_img_3-removebg-preview.png', 'uploads/1770374935_1767196589_img_5-removebg-preview.png', '', '1'),
(122, 57, 76, 1, 'uploads/1770375055_1767196765_img_2-removebg-preview.png', 'uploads/1770375055_1767196765_img_1-removebg-preview.png', 'uploads/1770375055_1767196765_img_8-removebg-preview.png', 'uploads/1770375055_1767196765_img_12-removebg-preview.png', 'uploads/1770375055_1767196765_img_5-removebg-preview.png', '', '1'),
(123, 57, 77, 1, 'uploads/1770375139_1767196933_img_2-removebg-preview.png', 'uploads/1770375139_1767196933_img_1-removebg-preview.png', 'uploads/1770375139_1767196933_img_4-removebg-preview.png', 'uploads/1770375139_1767196933_img_3-removebg-preview.png', 'uploads/1770375139_1767196933_img_5-removebg-preview.png', '', '1'),
(124, 57, 77, 42, 'uploads/1770375204_1767197079_img_2-removebg-preview.png', 'uploads/1770375204_1767197079_img_1-removebg-preview.png', 'uploads/1770375204_1767197079_img_6-removebg-preview.png', 'uploads/1770375204_1767197079_img_5-removebg-preview.png', 'uploads/1770375204_1767197079_img_7-removebg-preview.png', '', '1'),
(125, 58, 78, 42, 'uploads/1770370964_1767245144_img_2-removebg-preview.png', 'uploads/1770370964_1767245144_img_1-removebg-preview.png', 'uploads/1770370964_1767245144_img_8-removebg-preview.png', 'uploads/1770370964_1767245144_img_3-removebg-preview.png', 'uploads/1770370964_1767245144_img_6-removebg-preview.png', '', '1'),
(126, 59, 79, 34, 'uploads/1770370886_1767245294_img_2-removebg-preview.png', 'uploads/1770370886_1767245294_img_1-removebg-preview.png', 'uploads/1770370886_1767245294_img_8-removebg-preview.png', 'uploads/1770370886_1767245294_img_4-removebg-preview.png', 'uploads/1770370886_1767245294_img_5-removebg-preview.png', '', '1'),
(127, 60, 80, 43, 'uploads/1770370830_1767245535_img_2-removebg-preview.png', 'uploads/1770370830_1767245535_img_1-removebg-preview.png', 'uploads/1770370830_1767245535_img_15-removebg-preview.png', 'uploads/1770370830_1767245535_img_3-removebg-preview.png', 'uploads/1770370830_1767245535_img_12-removebg-preview.png', '', '1'),
(128, 61, 81, 40, 'uploads/1770370748_1767245788_img_2-removebg-preview.png', 'uploads/1770370748_1767245788_img_1-removebg-preview.png', 'uploads/1770370748_1767245788_img_7-removebg-preview.png', 'uploads/1770370748_1767245788_img_4-removebg-preview.png', 'uploads/1770370748_1767245788_img_5-removebg-preview.png', '', '1'),
(129, 62, 82, 8, 'uploads/1770368603_1767245916_img_2-removebg-preview.png', 'uploads/1770368603_1767245916_img_1-removebg-preview.png', 'uploads/1770368603_1767245916_img_8-removebg-preview.png', 'uploads/1770368603_1767245916_img_4-removebg-preview.png', 'uploads/1770368603_1767245916_img_5-removebg-preview.png', '', '1'),
(130, 63, 83, 6, 'uploads/1770368191_1767246084_img_2-removebg-preview.png', 'uploads/1770368191_1767246084_img_1-removebg-preview.png', 'uploads/1770368191_1767246084_img_6-removebg-preview.png', 'uploads/1770368191_1767246084_img_5-removebg-preview.png', 'uploads/1770368191_1767246084_img_7-removebg-preview.png', '', '1'),
(131, 64, 84, 1, 'uploads/1770309042_1767246246_img_2-removebg-preview.png', 'uploads/1770309042_1767246246_img_1-removebg-preview.png', 'uploads/1770309042_1767246246_img_8-removebg-preview.png', 'uploads/1770309042_1767246246_img_4-removebg-preview.png', 'uploads/1770309042_1767246246_img_5-removebg-preview.png', '', '1'),
(132, 65, 85, 34, 'uploads/1770308758_1767246411_img_2-removebg-preview.png', 'uploads/1770308758_1767246411_img_1-removebg-preview.png', 'uploads/1770308758_1767246411_img_8-removebg-preview.png', 'uploads/1770308758_1767246412_img_7-removebg-preview.png', 'uploads/1770308758_1767246412_img_9-removebg-preview.png', '', '1'),
(133, 66, 86, 1, 'uploads/1770308800_1767246739_img_2-removebg-preview.png', 'uploads/1770308800_1767246739_img_1-removebg-preview.png', 'uploads/1770308800_1767246739_img_8-removebg-preview.png', 'uploads/1770308800_1767246739_img_4-removebg-preview.png', 'uploads/1770308800_1767246739_img_5-removebg-preview.png', '', '1'),
(134, 66, 86, 42, 'uploads/1770308842_1767246870_img_2-removebg-preview.png', 'uploads/1770308842_1767246870_img_1-removebg-preview.png', 'uploads/1770308842_1767246870_img_8-removebg-preview.png', 'uploads/1770308842_1767246870_img_7-removebg-preview.png', 'uploads/1770308842_1767246870_img_9-removebg-preview.png', '', '1'),
(135, 67, 87, 34, 'uploads/1770308701_1767246998_img_2-removebg-preview.png', 'uploads/1770308701_1767246998_img_1-removebg-preview.png', 'uploads/1770308701_1767246998_img_6-removebg-preview.png', 'uploads/1770308701_1767246998_img_5-removebg-preview.png', 'uploads/1770308701_1767246998_img_7-removebg-preview.png', '', '1'),
(136, 68, 88, 1, 'uploads/1770308661_1767247109_img_2-removebg-preview.png', 'uploads/1770308661_1767247109_img_1-removebg-preview.png', 'uploads/1770308661_1767247109_img_8-removebg-preview.png', 'uploads/1770308661_1767247109_img_3-removebg-preview.png', 'uploads/1770308661_1767247109_img_5-removebg-preview.png', '', '1'),
(137, 69, 89, 30, 'uploads/1770308618_1767247250_img_2-removebg-preview.png', 'uploads/1770308618_1767247250_img_1-removebg-preview.png', 'uploads/1770308618_1767247250_img_6-removebg-preview.png', 'uploads/1770308618_1767247250_img_5-removebg-preview.png', 'uploads/1770308618_1767247250_img_7-removebg-preview.png', '', '1'),
(138, 70, 90, 9, 'uploads/1770308575_1767247586_img_2-removebg-preview.png', 'uploads/1770308575_1767247586_img_1-removebg-preview.png', 'uploads/1770308575_1767247586_img_6-removebg-preview.png', 'uploads/1770308575_1767247586_img_5-removebg-preview.png', 'uploads/1770308575_1767247586_img_7-removebg-preview.png', '', '1'),
(139, 71, 91, 42, 'uploads/1770306550_1767247763_img_2-removebg-preview.png', 'uploads/1770306550_1767247763_img_1-removebg-preview.png', 'uploads/1770306550_1767247763_img_9-removebg-preview.png', 'uploads/1770306550_1767247763_img_3-removebg-preview.png', 'uploads/1770306550_1767247763_img_7-removebg-preview.png', '', '1'),
(140, 72, 92, 1, 'uploads/1770306498_1767247891_img_2-removebg-preview.png', 'uploads/1770306498_1767247891_img_1-removebg-preview.png', 'uploads/1770306498_1767247891_img_11-removebg-preview.png', 'uploads/1770306498_1767247891_img_3-removebg-preview.png', 'uploads/1770306498_1767247891_img_5-removebg-preview.png', '', '1'),
(141, 73, 93, 38, 'uploads/1770306450_1767248071_img_2-removebg-preview.png', 'uploads/1770306450_1767248071_img_1-removebg-preview.png', 'uploads/1770306450_1767248071_img_6-removebg-preview.png', 'uploads/1770306450_1767248071_img_5-removebg-preview.png', 'uploads/1770306450_1767248071_img_7-removebg-preview.png', '', '1'),
(142, 74, 94, 37, 'uploads/1770306404_1767248203_img_2-removebg-preview.png', 'uploads/1770306404_1767248203_img_1-removebg-preview.png', 'uploads/1770306404_1767248203_img_8-removebg-preview.png', 'uploads/1770306404_1767248203_img_7-removebg-preview.png', 'uploads/1770306404_1767248203_img_9-removebg-preview.png', '', '1'),
(143, 75, 95, 6, 'uploads/1770305080_1767248411_img_2-removebg-preview.png', 'uploads/1770305080_1767248411_img_1-removebg-preview.png', 'uploads/1770305080_1767248411_img_8-removebg-preview.png', 'uploads/1770305080_1767248411_img_4-removebg-preview.png', 'uploads/1770305080_1767248411_img_6-removebg-preview.png', '', '1'),
(144, 76, 96, 1, 'uploads/1770304822_1767248522_img_2-removebg-preview.png', 'uploads/1770304822_1767248522_img_1-removebg-preview.png', 'uploads/1770304822_1767248522_img_8-removebg-preview.png', 'uploads/1770304822_1767248522_img_4-removebg-preview.png', 'uploads/1770304822_1767248522_img_6-removebg-preview.png', '', '1'),
(145, 77, 97, 34, 'uploads/1770304774_1767248682_img_2-removebg-preview.png', 'uploads/1770304774_1767248682_img_1-removebg-preview.png', 'uploads/1770304774_1767248682_img_4-removebg-preview.png', 'uploads/1770304774_1767248682_img_3-removebg-preview.png', 'uploads/1770304774_1767248682_img_5-removebg-preview.png', '', '1'),
(146, 78, 98, 42, 'uploads/1770304732_1767248864_img_2-removebg-preview.png', 'uploads/1770304732_1767248864_img_1-removebg-preview.png', 'uploads/1770304732_1767248864_img_8-removebg-preview.png', 'uploads/1770304732_1767248864_img_4-removebg-preview.png', 'uploads/1770304732_1767248864_img_6-removebg-preview.png', '', '1'),
(147, 79, 99, 9, 'uploads/1770284821_1767259844_img_2-removebg-preview.png', 'uploads/1770284821_1767259844_img_1-removebg-preview.png', 'uploads/1770284821_1767259844_img_8-removebg-preview.png', 'uploads/1767259844_img_3.jpg', 'uploads/1767259844_img_5.jpg', '', '1'),
(148, 79, 99, 4, 'uploads/1770284846_1767330908_img_2-removebg-preview.png', 'uploads/1770284846_1767330908_img_1-removebg-preview.png', 'uploads/1770284846_1767330908_img_8-removebg-preview.png', 'uploads/1767330908_img_3.jpg', 'uploads/1767330908_img_5.jpg', '', '1'),
(149, 81, 101, 8, 'uploads/1770284786_1767331455_img_2-removebg-preview.png', 'uploads/1770284786_1767331455_img_1-removebg-preview.png', 'uploads/1770284786_1767331455_img_4-removebg-preview.png', 'uploads/1770284786_1767331455_img_3-removebg-preview.png', 'uploads/1770284786_1767331455_img_5-removebg-preview.png', '', '1'),
(150, 82, 102, 38, 'uploads/1770284753_1767331586_img_2-removebg-preview.png', 'uploads/1770284753_1767331586_img_1-removebg-preview.png', 'uploads/1770284753_1767331586_img_4-removebg-preview.png', 'uploads/1770284753_1767331586_img_3-removebg-preview.png', 'uploads/1770284753_1767331586_img_5-removebg-preview.png', '', '1'),
(151, 83, 103, 1, 'uploads/1770284562_1767331895_img_2-removebg-preview.png', 'uploads/1770284562_1767331895_img_12-removebg-preview.png', 'uploads/1770284562_1767331895_img_10-removebg-preview.png', 'uploads/1770284562_1767331895_img_9-removebg-preview.png', 'uploads/1770284562_1767331895_img_11-removebg-preview.png', '', '1'),
(152, 83, 103, 33, 'uploads/1770284588_1767332118_img_2-removebg-preview.png', 'uploads/1770284588_1767332118_img_1-removebg-preview.png', 'uploads/1770284588_1767332118_img_8-removebg-preview.png', 'uploads/1767332118_img_3.jpg', 'uploads/1767332118_img_6.jpg', '', '1'),
(153, 83, 103, 45, 'uploads/1770284624_1767332278_img_2-removebg-preview.png', 'uploads/1770284624_1767332278_img_1-removebg-preview.png', 'uploads/1770284624_1767332278_img_10-removebg-preview.png', 'uploads/1770284624_1767332278_img_7-removebg-preview.png', 'uploads/1770284624_1767332278_img_11-removebg-preview.png', '', '1'),
(154, 83, 103, 46, 'uploads/1770284647_1767332437_img_2-removebg-preview.png', 'uploads/1770284647_1767332437_img_1-removebg-preview.png', 'uploads/1770284647_1767332437_img_10-removebg-preview.png', 'uploads/1767332437_img_3.jpg', 'uploads/1767332437_img_5.jpg', '', '1'),
(155, 83, 103, 37, 'uploads/1770284681_1767332819_img_2-removebg-preview.png', 'uploads/1770284681_1767332819_img_1-removebg-preview.png', 'uploads/1770284681_1767332819_img_4-removebg-preview.png', 'uploads/1770284681_1767332819_img_3-removebg-preview.png', 'uploads/1770284681_1767332819_img_5-removebg-preview.png', '', '1'),
(156, 83, 103, 27, 'uploads/1770284720_1767332959_img_2-removebg-preview.png', 'uploads/1770284720_1767332959_img_1-removebg-preview.png', 'uploads/1770284720_1767332959_img_8-removebg-preview.png', 'uploads/1770284720_1767332959_img_7-removebg-preview.png', 'uploads/1770284720_1767332959_img_9-removebg-preview.png', '', '1'),
(157, 85, 105, 13, 'uploads/1770283019_1767333750_img_2-removebg-preview.png', 'uploads/1770283019_1767333750_img_1-removebg-preview.png', 'uploads/1770283019_1767333750_img_8-removebg-preview.png', 'uploads/1767333750_img_3.jpg', 'uploads/1767333750_img_6.jpg', '', '1');
INSERT INTO `product_image_tbl` (`image_id`, `product_id`, `pvariation_id`, `color_id`, `f_image`, `b_image`, `third_image`, `fourth_image`, `fifth_image`, `tryon_image`, `i_status`) VALUES
(158, 86, 106, 1, 'uploads/1770282562_1767334061_img_2-removebg-preview.png', 'uploads/1770282562_1767334061_img_1-removebg-preview.png', 'uploads/1770282562_1767334061_img_9-removebg-preview.png', 'uploads/1767334061_img_3.jpg', 'uploads/1767334061_img_5.jpg', '', '1'),
(159, 87, 107, 14, 'uploads/1770282520_1767334191_img_1-removebg-preview.png', 'uploads/1770282520_1767334191_img_2-removebg-preview.png', 'uploads/1770282520_1767334191_img_9-removebg-preview.png', 'uploads/1767334191_img_5.jpg', 'uploads/1767334191_img_6.jpg', '', '1'),
(160, 88, 108, 4, 'uploads/1770282484_1767334396_img_2-removebg-preview.png', 'uploads/1770282484_1767334396_img_1-removebg-preview.png', 'uploads/1770282484_1767334396_img_8-removebg-preview (1).png', 'uploads/1767334396_img_3.png', 'uploads/1767334396_img_5.png', '', '1'),
(161, 89, 109, 7, 'uploads/1770282458_1767334691_img_2-removebg-preview (1).png', 'uploads/1770282458_1767334691_img_1-removebg-preview (1).png', 'uploads/1770282458_1767334691_img_8-removebg-preview.png', 'uploads/1767334691_img_4.png', 'uploads/1767334691_img_5.png', '', '1'),
(162, 90, 110, 4, 'uploads/1770275826_1767335134_img_1-removebg-preview.png', 'uploads/1770275826_1767335134_img_2-removebg-preview.png', 'uploads/1770275826_1767335134_img_8-removebg-preview.png', 'uploads/1767335134_img_4.jpg', 'uploads/1767335134_img_5.jpg', '', '1'),
(163, 91, 111, 14, 'uploads/1770275339_1767335389_img_2-removebg-preview.png', 'uploads/1770275339_1767335389_img_1-removebg-preview.png', 'uploads/1770275339_1767335389_img_8-removebg-preview.png', 'uploads/1767335389_img_3.png', 'uploads/1767335389_img_5.png', '', '1'),
(164, 91, 111, 7, 'uploads/1770275378_1767335525_img_2-removebg-preview.png', 'uploads/1770275378_1767335525_img_1-removebg-preview.png', 'uploads/1770275378_1767259844_img_8-removebg-preview.png', 'uploads/1767335525_img_4.jpg', 'uploads/1767335525_img_6.jpg', '', '1'),
(165, 91, 111, 10, 'uploads/1770275416_1767335672_img_2-removebg-preview.png', 'uploads/1770275416_1767335672_img_1-removebg-preview.png', 'uploads/1770275416_1767335672_img_8-removebg-preview.png', 'uploads/1767335672_img_4.jpg', 'uploads/1767335672_img_5.jpg', '', '1'),
(166, 91, 111, 30, 'uploads/1770275482_1767335798_img_2-removebg-preview.png', 'uploads/1770275482_1767335798_img_1-removebg-preview.png', 'uploads/1770275482_1767335798_img_10-removebg-preview.png', 'uploads/1767335798_img_3.jpg', 'uploads/1767335798_img_5.jpg', '', '1'),
(167, 91, 111, 13, 'uploads/1770275557_1767335975_img_2-removebg-preview.png', 'uploads/1770275557_1767335975_img_1-removebg-preview.png', 'uploads/1770275557_1767335975_img_8-removebg-preview.png', 'uploads/1770275557_1767335975_img_7-removebg-preview.png', 'uploads/1770275557_1767335975_img_10-removebg-preview.png', '', '1'),
(169, 92, 112, 47, 'uploads/1770274771_1767336498_img_2-removebg-preview.png', 'uploads/1770274771_1767336498_img_1-removebg-preview.png', 'uploads/1770274771_1767336498_img_9-removebg-preview.png', 'uploads/1767336498_img_5.jpg', 'uploads/1767336498_img_6.jpg', '', '1'),
(170, 92, 112, 14, 'uploads/1770274803_1767336649_img_2-removebg-preview.png', 'uploads/1770274803_1767336649_img_1-removebg-preview.png', 'uploads/1770274803_1767336649_img_8-removebg-preview.png', 'uploads/1767336649_img_3.jpg', 'uploads/1767336649_img_5.jpg', '', '1'),
(171, 93, 113, 7, 'uploads/1770273633_1767336854_img_2-removebg-preview.png', 'uploads/1770273633_1767336854_img_1-removebg-preview.png', 'uploads/1770273633_1767336854_img_8-removebg-preview.png', 'uploads/1767336854_img_3.jpg', 'uploads/1767336854_img_5.jpg', '', '1'),
(172, 94, 114, 4, 'uploads/1770273601_1767337075_img_2-removebg-preview.png', 'uploads/1770273601_1767337075_img_1-removebg-preview.png', 'uploads/1770273601_1767337075_img_8-removebg-preview.png', 'uploads/1767337075_img_3.jpg', 'uploads/1767337075_img_5.jpg', '', '1'),
(173, 95, 115, 4, 'uploads/1770273567_1767339468_img_2-removebg-preview.png', 'uploads/1770273567_1767339468_img_1-removebg-preview.png', 'uploads/1770273567_1767339468_img_8-removebg-preview.png', 'uploads/1767339468_img_3.png', 'uploads/1767339468_img_5.png', '', '1'),
(174, 96, 116, 13, 'uploads/1770272415_1767339782_img_2-removebg-preview.png', 'uploads/1770272415_1767339782_img_1-removebg-preview.png', 'uploads/1770272415_1767339782_img_8-removebg-preview.png', 'uploads/1770272415_1767339782_img_7-removebg-preview.png', 'uploads/1767339782_img_5.jpg', '', '1'),
(175, 97, 117, 39, 'uploads/1770272315_1767340528_img_2-removebg-preview.png', 'uploads/1770272315_1767340528_img_1-removebg-preview.png', 'uploads/1770272315_1767340528_img_6-removebg-preview.png', 'uploads/1770272315_1767340528_img_3-removebg-preview.png', 'uploads/1770272315_1767340528_img_7-removebg-preview.png', '', '1'),
(176, 98, 118, 46, 'uploads/1770272235_1767340655_img_2-removebg-preview.png', 'uploads/1770272235_1767340655_img_1-removebg-preview.png', 'uploads/1770272235_1767340655_img_4-removebg-preview.png', 'uploads/1770272235_1767340655_img_3-removebg-preview.png', 'uploads/1770272235_1767340655_img_5-removebg-preview.png', '', '1'),
(177, 99, 119, 27, 'uploads/1770271926_1767340745_img_2-removebg-preview.png', 'uploads/1770271926_1767340745_img_1-removebg-preview.png', 'uploads/1770271926_1767340745_img_6-removebg-preview.png', 'uploads/1770271926_1767340745_img_5-removebg-preview.png', 'uploads/1770271926_1767340745_img_7-removebg-preview.png', '', '1'),
(178, 99, 119, 24, 'uploads/1770272005_1767340893_img_2-removebg-preview.png', 'uploads/1770272005_1767340893_img_1-removebg-preview.png', 'uploads/1770272005_1767340893_img_6-removebg-preview.png', 'uploads/1770272005_1767340893_img_5-removebg-preview.png', 'uploads/1770272005_1767340893_img_7-removebg-preview.png', '', '1'),
(179, 100, 120, 14, 'uploads/1770271875_1767345032_img_2-removebg-preview (1).png', 'uploads/1770271875_1767345032_img_1-removebg-preview.png', 'uploads/1770271875_1767345032_img_6-removebg-preview.png', 'uploads/1767345032_img_3.png', 'uploads/1767345032_img_9.png', '', '1'),
(180, 99, 119, 42, 'uploads/1770272061_1767345253_img_2-removebg-preview.png', 'uploads/1770272061_1767345253_img_1-removebg-preview.png', 'uploads/1770272061_1767345253_img_8-removebg-preview.png', 'uploads/1767345253_img_4.jpg', 'uploads/1767345253_img_6.jpg', '', '1'),
(181, 99, 119, 9, 'uploads/1770272136_1767345368_img_2-removebg-preview.png', 'uploads/1770272136_1767345368_img_1-removebg-preview.png', 'uploads/1770272136_1767345368_img_8-removebg-preview.png', 'uploads/1767345368_img_4.jpg', 'uploads/1767345368_img_6.jpg', '', '1'),
(182, 101, 121, 45, 'uploads/1770271830_1767345503_img_2-removebg-preview (1).png', 'uploads/1770271830_1767345503_img_1-removebg-preview (1).png', 'uploads/1770271830_1767345503_img_6-removebg-preview (1).png', 'uploads/1767345503_img_3.png', 'uploads/1767345503_img_4.png', '', '1'),
(183, 102, 122, 30, 'uploads/1770271651_1767345882_img_2-removebg-preview (1).png', 'uploads/1770271651_1767345882_img_1-removebg-preview.png', 'uploads/1770271651_1767345882_img_7-removebg-preview (1).png', 'uploads/1767345882_img_3.jpg', 'uploads/1767345882_img_5.jpg', '', '1'),
(184, 102, 122, 37, 'uploads/1770271740_1767346029_img_2-removebg-preview (1).png', 'uploads/1770271740_1767346029_img_1-removebg-preview (1).png', 'uploads/1770271740_1767346029_img_11-removebg-preview (1).png', 'uploads/1770271740_1767346029_img_12-removebg-preview.png', 'uploads/1767346029_img_3.jpg', '', '1'),
(185, 103, 123, 48, 'uploads/1770271579_1767346330_img_2-removebg-preview.png', 'uploads/1770271579_1767346330_img_1-removebg-preview.png', 'uploads/1770271579_1767346330_img_8-removebg-preview.png', 'uploads/1767346330_img_3.jpg', 'uploads/1767346330_img_5.jpg', '', '1'),
(186, 104, 124, 8, 'uploads/1770206651_1767347318_img_2-removebg-preview.png', 'uploads/1770206651_1767347318_img_1-removebg-preview.png', 'uploads/1770206651_1767347318_img_10-removebg-preview.png', 'uploads/1767347318_img_5.jpg', 'uploads/1767347318_img_3.jpg', '', '1'),
(187, 104, 124, 1, 'uploads/1770206893_1767347455_img_2-removebg-preview.png', 'uploads/1770206893_1767347455_img_1-removebg-preview.png', 'uploads/1770206893_1767347455_img_10-removebg-preview.png', 'uploads/1767347455_img_5.jpg', 'uploads/1767347455_img_8.jpg', '', '1'),
(188, 104, 124, 4, 'uploads/1770206957_1767348544_img_2-removebg-preview.png', 'uploads/1770206957_1767348544_img_1-removebg-preview.png', 'uploads/1770206957_1767348544_img_8-removebg-preview.png', 'uploads/1767348544_img_3.jpg', 'uploads/1767348544_img_5.jpg', '', '1'),
(189, 104, 124, 46, 'uploads/1770207034_1767348767_img_2-removebg-preview.png', 'uploads/1770207034_1767348767_img_1-removebg-preview.png', 'uploads/1770207034_1767348767_img_8-removebg-preview.png', 'uploads/1767348767_img_4.jpg', 'uploads/1767348767_img_6.jpg', '', '1'),
(190, 105, 125, 4, 'uploads/1770204011_1767349218_img_2-removebg-preview.png', 'uploads/1770204011_1767349218_img_1-removebg-preview.png', 'uploads/1770204011_1767349218_img_9-removebg-preview.png', 'uploads/1767349218_img_3.jpg', 'uploads/1767349218_img_5.jpg', '', '1'),
(191, 105, 125, 5, 'uploads/1770204612_1767349372_img_2-removebg-preview.png', 'uploads/1770204612_1767349372_img_1-removebg-preview.png', 'uploads/1770204612_1767349372_img_8-removebg-preview.png', 'uploads/1767349372_img_3.jpg', 'uploads/1767349372_img_5.jpg', '', '1'),
(192, 105, 125, 49, 'uploads/1770204665_1767370704_img_2-removebg-preview.png', 'uploads/1770204665_1767370704_img_1-removebg-preview.png', 'uploads/1770204665_1767370704_img_10-removebg-preview.png', 'uploads/1767370704_img_3.jpg', 'uploads/1767370704_img_5.jpg', '', '1'),
(193, 105, 125, 1, 'uploads/1770204743_1767370865_img_2-removebg-preview - Copy.png', 'uploads/1770204743_1767370865_img_1-removebg-preview - Copy.png', 'uploads/1770204743_1767370865_img_8-removebg-preview - Copy.png', 'uploads/1767370865_img_3.jpg', 'uploads/1767370865_img_5.jpg', '', '1'),
(195, 106, 126, 38, 'uploads/1770201564_1767371698_img_2-removebg-preview.png', 'uploads/1770201564_1767371698_img_1-removebg-preview.png', 'uploads/1770201564_1767371698_img_8-removebg-preview.png', 'uploads/1767371698_img_3.jpg', 'uploads/1767371698_img_5.jpg', '', '1'),
(196, 107, 127, 8, 'uploads/1770201340_1767371548_img_2-removebg-preview.png', 'uploads/1770201340_1767371548_img_1-removebg-preview.png', 'uploads/1770201340_1767371548_img_8-removebg-preview.png', 'uploads/1767371548_img_3.jpg', 'uploads/1767371548_img_5.jpg', '', '1'),
(197, 108, 128, 1, 'uploads/1770200760_1767371899_img_2-removebg-preview.png', 'uploads/1770200760_1767371899_img_1-removebg-preview.png', 'uploads/1770200760_1767371899_img_8-removebg-preview.png', 'uploads/1767371899_img_4.jpg', 'uploads/1767371899_img_6.jpg', '', '1'),
(198, 108, 128, 14, 'uploads/1770200790_1767371965_img_2-removebg-preview.png', 'uploads/1770200790_1767371965_img_1-removebg-preview.png', 'uploads/1770200790_1767371965_img_8-removebg-preview.png', 'uploads/1767371965_img_4.jpg', 'uploads/1767371965_img_5.jpg', '', '1'),
(199, 108, 128, 50, 'uploads/1770200844_1767372115_img_2-removebg-preview.png', 'uploads/1770200844_1767372115_img_1-removebg-preview.png', 'uploads/1770200844_1767372115_img_8-removebg-preview.png', 'uploads/1767372115_img_4.jpg', 'uploads/1767372115_img_5.jpg', '', '1'),
(200, 108, 128, 8, 'uploads/1770200934_1767372241_img_2-removebg-preview.png', 'uploads/1770200934_1767372241_img_1-removebg-preview.png', 'uploads/1770200934_1767372241_img_8-removebg-preview.png', 'uploads/1767372241_img_3.jpg', 'uploads/1767372241_img_5.jpg', '', '1'),
(201, 108, 128, 29, 'uploads/1770200975_1767372391_img_2-removebg-preview.png', 'uploads/1770200975_1767372391_img_1-removebg-preview.png', 'uploads/1770200975_1767372391_img_8-removebg-preview.png', 'uploads/1767372391_img_3.jpg', 'uploads/1767372391_img_5.jpg', '', '1'),
(202, 109, 129, 49, 'uploads/1770199516_1767372666_img_2-removebg-preview.png', 'uploads/1770199516_1767372666_img_1-removebg-preview.png', 'uploads/1770199516_1767372666_img_10-removebg-preview.png', 'uploads/1767372666_img_3.jpg', 'uploads/1767372666_img_5.jpg', '', '1'),
(203, 109, 129, 4, 'uploads/1770199540_1767372888_img_2-removebg-preview.png', 'uploads/1770199540_1767372888_img_1-removebg-preview.png', 'uploads/1770199540_1767372888_img_10-removebg-preview.png', 'uploads/1767372888_img_4.jpg', 'uploads/1767372888_img_5.jpg', '', '1'),
(204, 110, 130, 1, 'uploads/1770194725_1767373117_img_2-removebg-preview.png', 'uploads/1770194725_1767373117_img_1-removebg-preview.png', 'uploads/1770194725_1767373117_img_9-removebg-preview.png', 'uploads/1767373117_img_3.jpg', 'uploads/1767373117_img_5.jpg', '', '1'),
(205, 111, 131, 10, 'uploads/1770194701_1767373443_img_2-removebg-preview.png', 'uploads/1770194701_1767373443_img_1-removebg-preview.png', 'uploads/1770194701_1767373443_img_8-removebg-preview.png', 'uploads/1767373443_img_4.jpg', 'uploads/1767373443_img_5.jpg', '', '1'),
(206, 112, 132, 51, 'uploads/1770194141_1767373645_img_2-removebg-preview.png', 'uploads/1770194141_1767373645_img_1-removebg-preview.png', 'uploads/1770194141_1767373645_img_9-removebg-preview.png', 'uploads/1767373645_img_3.jpg', 'uploads/1767373645_img_5.jpg', '', '1'),
(207, 113, 133, 48, 'uploads/1770194053_1767374040_img_3-removebg-preview.png', 'uploads/1770194053_1767374040_img_2-removebg-preview.png', 'uploads/1770194053_1767374040_img_10-removebg-preview.png', 'uploads/1767374040_img_5.jpg', 'uploads/1767374040_img_8.jpg', '', '1'),
(208, 113, 133, 40, 'uploads/1770194080_1767374212_img_2-removebg-preview.png', 'uploads/1770194080_1767374212_img_1-removebg-preview.png', 'uploads/1770194080_1767374212_img_9-removebg-preview.png', 'uploads/1767374212_img_4.jpg', 'uploads/1767374212_img_7.jpg', '', '1'),
(209, 114, 134, 52, 'uploads/1770193598_1767374582_img_2-removebg-preview.png', 'uploads/1770193598_1767374582_img_1-removebg-preview.png', 'uploads/1770193598_1767374582_img_10-removebg-preview.png', 'uploads/1767374582_img_5.jpg', 'uploads/1767374582_img_8.jpg', '', '1'),
(210, 92, 112, 1, 'uploads/1770274830_1767374676_img_2-removebg-preview.png', 'uploads/1770274830_1767374676_img_1-removebg-preview.png', 'uploads/1770274830_1767374676_img_8-removebg-preview.png', 'uploads/1767374676_img_4.jpg', 'uploads/1767374676_img_6.jpg', '', '1'),
(211, 92, 112, 4, 'uploads/1770274854_1767374862_img_2-removebg-preview.png', 'uploads/1770274854_1767374862_img_1-removebg-preview.png', 'uploads/1770274854_1767374862_img_8-removebg-preview.png', 'uploads/1767374862_img_4.jpg', 'uploads/1767374862_img_5.jpg', '', '1'),
(212, 116, 136, 30, 'uploads/1770192723_1767375031_img_2-removebg-preview.png', 'uploads/1770192723_1767375031_img_1-removebg-preview.png', 'uploads/1770192723_1767375031_img_9-removebg-preview.png', 'uploads/1770192723_1767375031_img_8-removebg-preview.png', 'uploads/1770192723_1767375031_img_10-removebg-preview.png', '', '1'),
(213, 117, 137, 8, 'uploads/1770192425_1767375179_img_2-removebg-preview.png', 'uploads/1770192425_1767375179_img_1-removebg-preview.png', 'uploads/1770192425_1767375179_img_10-removebg-preview.png', 'uploads/1767375179_img_4.jpg', 'uploads/1767375179_img_5.jpg', '', '1'),
(214, 118, 138, 46, 'uploads/1770187377_1767375559_img_2-removebg-preview.png', 'uploads/1770187377_1767375559_img_1-removebg-preview.png', 'uploads/1770187377_1767375559_img_8-removebg-preview.png', 'uploads/1767375559_img_3.jpg', 'uploads/1767375559_img_5.jpg', '', '1'),
(215, 118, 138, 4, 'uploads/1770187400_1767375658_img_2-removebg-preview.png', 'uploads/1770187400_1767375658_img_1-removebg-preview.png', 'uploads/1770187400_1767375658_img_8-removebg-preview.png', 'uploads/1767375658_img_3.jpg', 'uploads/1767375658_img_5.jpg', '', '1'),
(216, 118, 138, 18, 'uploads/1770187432_1767375751_img_2-removebg-preview.png', 'uploads/1770187432_1767375751_img_1-removebg-preview.png', 'uploads/1770187432_1767375751_img_9-removebg-preview.png', 'uploads/1767375751_img_5.jpg', 'uploads/1767375751_img_7.jpg', '', '1'),
(217, 115, 135, 50, 'uploads/1770193454_1767375875_img_2-removebg-preview.png', 'uploads/1770193454_1767375875_img_1-removebg-preview.png', 'uploads/1770193454_1767375875_img_10-removebg-preview (1).png', 'uploads/1767375875_img_3.jpg', 'uploads/1767375875_img_5.jpg', '', '1'),
(218, 92, 112, 48, 'uploads/1770274879_1767376065_img_2-removebg-preview.png', 'uploads/1770274879_1767376065_img_1-removebg-preview.png', 'uploads/1770274879_1767376065_img_10-removebg-preview.png', 'uploads/1767376065_img_4.jpg', 'uploads/1767376065_img_5.jpg', '', '1'),
(219, 118, 138, 8, 'uploads/1770187481_hooper-hp-s16591l-c2-sunglasses_img_9418_05_jan24-removebg-preview.png', 'uploads/1770187481_1767376253_img_1-removebg-preview.png', 'uploads/1770187481_hooper-hp-s16591l-c2-sunglasses_img_9422_05_jan24-removebg-preview.png', 'uploads/1767376253_img_3.jpg', 'uploads/1767376253_img_6.jpg', '', '1'),
(220, 119, 139, 34, 'uploads/1770186865_1767376454_img_2-removebg-preview.png', 'uploads/1770186865_1767376454_img_1-removebg-preview.png', 'uploads/1770186865_1767376454_img_8-removebg-preview.png', 'uploads/1767376454_img_3.jpg', 'uploads/1767376454_img_5.jpg', '', '1'),
(221, 119, 139, 51, 'uploads/1770186898_1767376653_img_2-removebg-preview.png', 'uploads/1770186898_1767376653_img_1-removebg-preview.png', 'uploads/1770186898_1767376653_img_8-removebg-preview.png', 'uploads/1767376653_img_3.jpg', 'uploads/1767376653_img_5.jpg', '', '1'),
(222, 120, 140, 1, 'uploads/1770186613_1767376979_img_2-removebg-preview.png', 'uploads/1770186613_1767376979_img_1-removebg-preview.png', 'uploads/1770186613_1767376979_img_8-removebg-preview.png', 'uploads/1767376979_img_3.jpg', 'uploads/1767376979_img_5.jpg', '', '1'),
(223, 121, 141, 42, 'uploads/1770186409_1767377664_img_2-removebg-preview.png', 'uploads/1770186409_1767377664_img_1-removebg-preview.png', 'uploads/1770186409_1767377664_img_9-removebg-preview.png', 'uploads/1767377664_img_4.jpg', 'uploads/1767377664_img_6.jpg', '', '1'),
(224, 121, 141, 18, 'uploads/1770186430_1767377887_img_2-removebg-preview.png', 'uploads/1770186430_1767377887_img_1-removebg-preview.png', 'uploads/1770186430_hooper-hp-s16593l-c2-sunglasses_img_9454_05_jan24-removebg-preview.png', 'uploads/1767377887_img_4.jpg', 'uploads/1767377887_img_5.jpg', '', '1'),
(226, 122, 142, 1, 'uploads/1770185886_1767378131_img_2-removebg-preview.png', 'uploads/1770185886_1767378131_img_1-removebg-preview.png', 'uploads/1770185886_1767378131_img_8-removebg-preview.png', 'uploads/1767378131_img_3.jpg', 'uploads/1767378131_img_5.jpg', '', '1'),
(227, 123, 143, 36, 'uploads/1770185625_1767378363_img_2-removebg-preview.png', 'uploads/1770185625_1767378363_img_1-removebg-preview.png', 'uploads/1770185625_1767378363_img_8-removebg-preview (1).png', 'uploads/1767378363_img_3.jpg', 'uploads/1767378363_img_5.jpg', '', '1'),
(228, 123, 143, 1, 'uploads/1770185728_1767378470_img_2-removebg-preview.png', 'uploads/1770185728_1767378470_img_1-removebg-preview.png', 'uploads/1770185728_1767378363_img_8-removebg-preview.png', 'uploads/1767378470_img_3.jpg', 'uploads/1767378470_img_5.jpg', '', '1'),
(229, 124, 144, 53, 'uploads/1770185222_1767378612_img_2-removebg-preview.png', 'uploads/1770185222_1767378612_img_1-removebg-preview.png', 'uploads/1770185222_1767378612_img_8-removebg-preview.png', 'uploads/1767378612_img_4.jpg', 'uploads/1767378612_img_5.jpg', '', '1'),
(230, 125, 145, 47, 'uploads/1770184480_1767378954_img_2-removebg-preview.png', 'uploads/1770184480_1767378954_img_6-removebg-preview.png', 'uploads/1770184480_1767378954_img_4-removebg-preview.png', 'uploads/1770184480_1767378954_img_3-removebg-preview.png', 'uploads/1770184480_1767378954_img_1-removebg-preview.png', '', '1'),
(231, 125, 145, 34, 'uploads/1770185071_1767379100_img_5-removebg-preview.png', 'uploads/1770185071_1767379100_img_1-removebg-preview.png', 'uploads/1770185071_1767379100_img_4-removebg-preview.png', 'uploads/1770185071_1767379100_img_3-removebg-preview.png', 'uploads/1770185071_1767379100_img_5-removebg-preview.png', '', '1'),
(232, 125, 145, 33, 'uploads/1770184910_1767379210_img_5-removebg-preview (1).png', 'uploads/1770184910_1767379210_img_1-removebg-preview.png', 'uploads/1770184910_1767379210_img_4-removebg-preview.png', 'uploads/1770184910_1767379210_img_3-removebg-preview.png', 'uploads/1770184910_1767379210_img_1-removebg-preview.png', '', '1'),
(233, 126, 146, 48, 'uploads/1770031447_img_101.jpg', 'uploads/1770031447_img_4.jpg', 'uploads/1770031447_img_39.jpg', 'uploads/1770031447_img_79.jpg', 'uploads/1770031447_img_92.jpg', '', '1'),
(234, 127, 147, 2, 'uploads/1770031749_img_4.jpg', 'uploads/1770031749_img_1.jpg', 'uploads/1770031749_img_6.jpg', 'uploads/1770031749_img_10.jpg', 'uploads/1770031749_img_5.jpg', '', '1'),
(235, 128, 148, 8, 'uploads/1771566894_img_130-removebg-preview.png', 'uploads/1771566894_img_131-removebg-preview.png', 'uploads/1771566894_img_139-removebg-preview.png', 'uploads/1771566894_img_133-removebg-preview.png', 'uploads/1771566894_img_134-removebg-preview.png', '', '1'),
(236, 129, 149, 1, 'uploads/1771567594_img_136-removebg-preview.png', 'uploads/1771567594_img_137-removebg-preview.png', 'uploads/1771567594_img_142-removebg-preview.png', 'uploads/1771567594_img_145-removebg-preview.png', 'uploads/1771567594_grey-black-full-rim-square-lenskart-air-switch-la-e15319-c5-clip-on-eyeglasses_216622_12_21_01_2026-removebg-preview.png', '', '1'),
(237, 130, 150, 42, 'uploads/1771568108_img_147-removebg-preview.png', 'uploads/1771568108_img_148-removebg-preview.png', 'uploads/1771568108_img_158-removebg-preview.png', 'uploads/1771568108_img_151-removebg-preview.png', 'uploads/1771568108_img_155-removebg-preview.png', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_tbl`
--

DROP TABLE IF EXISTS `product_tbl`;
CREATE TABLE IF NOT EXISTS `product_tbl` (
  `product_id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `category_id` int NOT NULL,
  `shape_id` int NOT NULL,
  `gender` enum('Men','Women','Kids','All') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'All',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `p_status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `shape_id` (`shape_id`)
) ENGINE=InnoDB AUTO_INCREMENT=131 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_tbl`
--

INSERT INTO `product_tbl` (`product_id`, `title`, `category_id`, `shape_id`, `gender`, `created_at`, `p_status`) VALUES
(1, 'Full Rim Square', 2, 6, 'Men', '2025-12-23 05:39:17', '1'),
(2, 'Shaded Full Rim Square', 2, 6, 'Men', '2025-12-24 03:23:13', '1'),
(3, 'Pink Full Rim Square', 2, 6, 'Men', '2025-12-24 03:41:04', '1'),
(4, 'Apex Full Rim Square', 2, 6, 'Men', '2025-12-25 08:29:22', '1'),
(5, 'Transparent Blue Brown Full Rim Square', 2, 6, 'Men', '2025-12-25 09:17:30', '1'),
(6, 'Gold Rimless Square', 2, 6, 'Men', '2025-12-25 09:24:15', '1'),
(7, 'Rimless Square', 2, 6, 'Men', '2025-12-25 09:32:53', '1'),
(8, 'Half Rim Square', 2, 6, 'Men', '2025-12-25 10:04:56', '1'),
(9, 'Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 10:41:07', '1'),
(10, 'Basic Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 10:51:25', '1'),
(11, 'Crystal Transparent Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 10:58:14', '1'),
(12, 'Black Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 11:03:09', '1'),
(13, 'Reading Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 22:26:23', '1'),
(14, 'Black Gold Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 22:42:20', '1'),
(15, 'Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 22:46:25', '1'),
(16, 'Tortoise Full Rim Rectangle', 2, 4, 'Men', '2025-12-25 22:55:30', '1'),
(17, 'Rimless Rectangle', 2, 4, 'Men', '2025-12-25 23:10:08', '1'),
(18, 'Silver Rimless Rectangle', 2, 4, 'Men', '2025-12-26 04:12:17', '1'),
(19, 'Half Rim Rectangle', 2, 4, 'Men', '2025-12-26 04:36:11', '1'),
(20, 'Full Rim Round', 2, 3, 'Men', '2025-12-26 05:01:23', '1'),
(21, 'Full Rim Rounded', 2, 3, 'Men', '2025-12-26 05:29:15', '1'),
(22, 'Mauve Full Rim Round', 2, 3, 'Men', '2025-12-26 05:39:46', '1'),
(23, 'Gold Full Rim Round', 4, 3, 'Men', '2025-12-26 05:45:37', '1'),
(24, 'Full Rim Round', 2, 3, 'Men', '2025-12-26 05:53:07', '1'),
(25, 'Metal Combo Full Rim Round', 2, 3, 'Men', '2025-12-26 08:00:15', '1'),
(26, 'Black Half Rim Round', 2, 3, 'Men', '2025-12-28 07:09:46', '1'),
(27, 'Gold Rimless Round', 2, 3, 'Men', '2025-12-28 07:30:19', '1'),
(28, 'Black Full Rim Cat Eye', 2, 8, 'Men', '2025-12-28 07:39:40', '1'),
(29, 'Full Rim Cat Eye', 2, 8, 'Women', '2025-12-28 10:30:13', '1'),
(30, 'Full Rim Cat Eye', 2, 8, 'Men', '2025-12-28 10:37:02', '1'),
(31, 'Demi Full Rim Cat Eye', 2, 8, 'Men', '2025-12-28 10:57:04', '1'),
(33, 'Full Rim Aviator', 2, 10, 'Men', '2025-12-28 11:36:50', '1'),
(34, 'Half Rim Aviator', 2, 10, 'Men', '2025-12-28 12:56:55', '1'),
(35, 'Black Rimless Aviator', 2, 10, 'Men', '2025-12-28 13:06:05', '1'),
(36, 'Full Rim Geometric', 2, 7, 'Men', '2025-12-28 13:15:38', '1'),
(37, 'Pink Transparent Full Rim Geometric', 2, 7, 'Men', '2025-12-28 13:30:36', '1'),
(38, 'Full Rim Geometric', 2, 7, 'Men', '2025-12-28 13:33:15', '1'),
(39, 'Full Rim Clubmaster', 2, 2, 'Men', '2025-12-28 13:43:38', '1'),
(41, 'Full Rim Square', 1, 6, 'Men', '2025-12-29 00:32:07', '1'),
(42, 'Matte Black Full Rim Square', 1, 6, 'Men', '2025-12-29 02:48:27', '1'),
(43, 'Demi Full Rim Square', 1, 6, 'Men', '2025-12-29 03:44:08', '1'),
(44, 'Black Full Rim Square', 1, 6, 'Men', '2025-12-29 03:55:30', '1'),
(45, 'Gold Full Rim Square', 1, 6, 'Men', '2025-12-29 09:13:48', '1'),
(46, 'Jet Black Full Rim Square', 1, 6, 'Men', '2025-12-29 09:19:15', '1'),
(47, 'Full Rim Square', 1, 6, 'Men', '2025-12-29 09:47:08', '1'),
(48, 'Black Rimless Square', 1, 6, 'Men', '2025-12-29 10:04:50', '1'),
(49, 'Gold Rimless Square', 1, 6, 'Men', '2025-12-29 10:11:28', '1'),
(50, 'Full Rim Rectangle Sunglass', 1, 4, 'Men', '2025-12-30 07:29:56', '1'),
(51, 'Silver Full Rim Rectangle Sunglass', 1, 4, 'Men', '2025-12-30 07:41:59', '1'),
(52, 'Gold Full Rim Rectangle Sunglass', 1, 4, 'Men', '2025-12-30 08:05:19', '1'),
(53, 'Black Full Rim Rectangle Sunglass', 1, 4, 'Men', '2025-12-30 08:23:17', '1'),
(54, 'Rimless Rectangle Sunglass', 1, 4, 'Men', '2025-12-30 08:26:34', '1'),
(57, 'Full Rim Round Sunglass', 1, 3, 'Men', '2025-12-31 10:14:50', '1'),
(58, 'Tortoise Full Rim Round Sunglass', 1, 3, 'Men', '2025-12-31 23:44:45', '1'),
(59, 'Gold Full Rim Round Sunglass', 1, 3, 'Men', '2025-12-31 23:57:13', '1'),
(60, 'Gold Full Rim Aviator Sunglass', 1, 10, 'Men', '2025-12-31 23:59:39', '1'),
(61, 'Gold Full Rim Aviator Sunglass', 1, 10, 'Men', '2026-01-01 00:03:27', '1'),
(62, 'Blue Transparent Full Rim Aviator Sunglass', 1, 10, 'Men', '2026-01-01 00:07:43', '1'),
(63, 'Silver Full Rim Aviator Sunglass', 1, 10, 'Men', '2026-01-01 00:10:00', '1'),
(64, 'Black Full Rim Aviator Sunglass', 1, 10, 'Men', '2026-01-01 00:12:53', '1'),
(65, 'Gold Half Rim Aviator Sunglass', 1, 10, 'Men', '2026-01-01 00:15:29', '1'),
(66, 'Full Rim Cat Eye Sunglass', 1, 8, 'Men', '2026-01-01 00:20:46', '1'),
(67, 'Green Full Rim Cat Eye Sunglass', 1, 8, 'Men', '2026-01-01 00:25:32', '1'),
(68, 'Black Full Rim Cat Eye Sunglass', 1, 8, 'Men', '2026-01-01 00:27:39', '1'),
(69, 'Rose Gold Full Rim Cat Eye Sunglass', 1, 8, 'Men', '2026-01-01 00:28:56', '1'),
(70, 'Crystal Transparent Full Rim Cat Eye Sunglass', 1, 8, 'Men', '2026-01-01 00:35:12', '1'),
(71, 'Brown Full Rim Geometric Sunglass', 1, 7, 'Men', '2026-01-01 00:38:33', '1'),
(72, 'Black Full Rim Geometric Sunglass', 1, 7, 'Men', '2026-01-01 00:40:25', '1'),
(73, 'Sky Blue Full Rim Geometric Sunglass', 1, 7, 'Men', '2026-01-01 00:42:56', '1'),
(74, 'Grey Full Rim Geometric Sunglass', 1, 7, 'Men', '2026-01-01 00:45:35', '1'),
(75, 'Silver Full Rim Clubmaster Sunglass', 1, 2, 'Men', '2026-01-01 00:49:14', '1'),
(76, 'Black Full Rim Clubmaster Sunglass', 1, 2, 'Men', '2026-01-01 00:51:12', '1'),
(77, 'Green Full Rim Clubmaster Sunglass', 1, 2, 'Men', '2026-01-01 00:53:27', '1'),
(78, 'Goldish Brown Full Rim Oval Sunglass', 1, 5, 'Men', '2026-01-01 00:56:31', '1'),
(79, 'Crystal Transparent Full Rim Square', 2, 6, 'Kids', '2026-01-01 03:53:00', '1'),
(81, 'Navy Blue Full Rim Square', 2, 6, 'Kids', '2026-01-01 23:52:46', '1'),
(82, 'Light Blue Full Rim Square', 2, 6, 'Kids', '2026-01-01 23:55:25', '1'),
(83, 'Full Rim Square', 2, 6, 'Kids', '2026-01-01 23:58:26', '1'),
(85, 'Purple Transparent Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:31:07', '1'),
(86, 'Black Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:34:27', '1'),
(87, 'Blue Transparent Blue Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:35:49', '1'),
(88, 'Ocean Blue Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:41:58', '1'),
(89, 'Light Gray Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:46:48', '1'),
(90, 'Blue Black Grey Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:49:13', '1'),
(91, 'Full Rim Rectangle', 2, 4, 'Kids', '2026-01-02 00:56:53', '1'),
(92, 'Full Rim Round', 2, 3, 'Kids', '2026-01-02 01:12:55', '1'),
(93, 'Gray Transparent Full Rim Round', 2, 3, 'Kids', '2026-01-02 01:22:30', '1'),
(94, 'Sky Blue Full Rim Round', 2, 3, 'Kids', '2026-01-02 01:25:29', '1'),
(95, 'Navy Blue Full Rim Round', 2, 3, 'Kids', '2026-01-02 01:29:15', '1'),
(96, 'Lavender Full Rim Round', 2, 3, 'Kids', '2026-01-02 02:11:25', '1'),
(97, 'Matte Gunmetal Purple Full Rim Cat Eye', 2, 8, 'Kids', '2026-01-02 02:21:43', '1'),
(98, 'Lavender Full Rim Cat Eye', 2, 8, 'Kids', '2026-01-02 02:23:56', '1'),
(99, 'Full Rim Cat Eye', 2, 8, 'Kids', '2026-01-02 02:26:34', '1'),
(100, 'Sky Blue Full Rim Cat Eye', 2, 8, 'Kids', '2026-01-02 03:36:34', '1'),
(101, 'Pink Transparent Full Rim Cat Eye', 2, 8, 'Kids', '2026-01-02 03:47:19', '1'),
(102, 'Full Rim Geometric', 2, 7, 'Kids', '2026-01-02 03:52:50', '1'),
(103, 'Green Full Rim Oval', 2, 5, 'Kids', '2026-01-02 03:58:34', '1'),
(104, 'Full Rim Square Sunglass', 1, 6, 'Kids', '2026-01-02 04:14:52', '1'),
(105, 'Super Hero Sunglass', 1, 6, 'Kids', '2026-01-02 04:44:22', '1'),
(106, 'Blue Transparent Full Rim Square Sunglass', 1, 6, 'Kids', '2026-01-02 10:52:12', '1'),
(107, 'Crystal Transparent Full Rim Square Sunglass', 1, 6, 'Kids', '2026-01-02 10:53:27', '1'),
(108, 'Basic Full Rim Square Sunglass', 1, 6, 'Kids', '2026-01-02 11:06:15', '1'),
(109, 'Full Rim Rectangle Sunglass', 1, 4, 'Kids', '2026-01-02 11:19:00', '1'),
(110, 'Black Full Rim Rectangle Sunglass', 1, 4, 'Kids', '2026-01-02 11:27:43', '1'),
(111, 'Sky Blue Full Rim Rectangle Sunglass', 1, 4, 'Kids', '2026-01-02 11:30:44', '1'),
(112, 'Red Full Rim Rectangle Sunglass', 1, 4, 'Kids', '2026-01-02 11:34:56', '1'),
(113, 'Rectangle Sunnies', 1, 4, 'Kids', '2026-01-02 11:40:15', '1'),
(114, 'Pink Transparent Full Rim Round Sunglass', 1, 3, 'Kids', '2026-01-02 11:49:00', '1'),
(115, 'full Rim round sunglass', 1, 3, 'Kids', '2026-01-02 11:53:30', '1'),
(116, 'Rose Transparent Full Rim Round Sunglass', 1, 3, 'Kids', '2026-01-02 11:56:46', '1'),
(117, 'Sky Blue Full Rim Round Sunglass', 1, 3, 'Kids', '2026-01-02 11:59:31', '1'),
(118, 'Printed Full Rim Round Sunglass', 1, 3, 'Kids', '2026-01-02 12:05:16', '1'),
(119, 'Full Rim Cat Eye Sunglass', 1, 8, 'Kids', '2026-01-02 12:22:31', '1'),
(120, 'Black Full Rim Cat Eye Sunglass', 1, 8, 'Kids', '2026-01-02 12:25:20', '1'),
(121, 'Multi Color Full Rim Cat Eye Sunglass', 1, 8, 'Kids', '2026-01-02 12:39:33', '1'),
(122, 'Black Full Rim Cat Eye Sunglass', 1, 8, 'Kids', '2026-01-02 12:46:06', '1'),
(123, 'Full Rim Geometric Sunglass', 1, 7, 'Kids', '2026-01-02 12:53:27', '1'),
(124, 'Blue Full Rim Geometric Sunglass', 1, 7, 'Kids', '2026-01-02 12:59:19', '1'),
(125, 'Full Rim Geometric Sunglass', 1, 7, 'Kids', '2026-01-02 13:02:41', '1'),
(128, 'Blue Zero Power Screen Glass', 3, 8, 'Kids', '2026-02-20 00:12:16', '1'),
(129, 'Black Full Rim Clip On', 4, 6, 'Men', '2026-02-20 00:28:36', '1'),
(130, 'Black Brown full Rim Square', 4, 6, 'Men', '2026-02-20 00:41:37', '1');

-- --------------------------------------------------------

--
-- Table structure for table `product_variation_tbl`
--

DROP TABLE IF EXISTS `product_variation_tbl`;
CREATE TABLE IF NOT EXISTS `product_variation_tbl` (
  `pvariation_id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `size` enum('Small','Medium','Regular','Narrow','Extra Narrow','Wide','Extra Wide','large') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `v_status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`pvariation_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=151 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_variation_tbl`
--

INSERT INTO `product_variation_tbl` (`pvariation_id`, `product_id`, `size`, `description`, `price`, `v_status`) VALUES
(1, 1, 'Medium', 'A full rim square eyeglass offers a perfect blend of bold style and everyday comfort, making it an ideal choice for those who like a confident, structured look. The square-shaped frame adds sharp definition to the face, enhancing features while providing a modern and versatile appeal that suits both casual and formal wear. Crafted with a sturdy full-rim design, it ensures durability and long-lasting support for lenses, making it practical for daily use.', 3100.00, '1'),
(2, 2, 'Wide', 'A full rim square eyeglass offers a perfect blend of bold style and everyday comfort, making it an ideal choice for those who like a confident, structured look. The square-shaped frame adds sharp definition to the face, enhancing features while providing a modern and versatile appeal that suits both casual and formal wear. Crafted with a sturdy full-rim design, it ensures durability and long-lasting support for lenses, making it practical for daily use. Whether paired with professional attire or relaxed outfits, this eyeglass delivers a refined, stylish appearance while offering reliable comfort and clarity throughout the day.\r\n', 3100.00, '1'),
(3, 3, 'Wide', 'Pink full rim square frames bring together a playful pop of color and a bold, structured design to create eyewear that stands out with confidence. The square shape offers clean, sharp lines that add definition to the face, making it especially flattering for round and oval face types. With full rim construction, the frame provides durability and a secure fit for everyday use. The pink hue adds a soft yet stylish touch, ranging from subtle blush tones to vibrant shades, allowing the frame to feel both modern and expressive.', 3100.00, '1'),
(4, 4, 'Medium', 'The square-shaped frame adds sharp definition to the face, enhancing features while providing a modern and versatile appeal that suits both casual and formal wear. Crafted with a sturdy full-rim design, it ensures durability and long-lasting support for lenses, making it practical for daily use. Whether paired with professional attire or relaxed outfits, this eyeglass delivers a refined, stylish appearance while offering reliable comfort and clarity throughout the day.', 4000.00, '1'),
(5, 5, 'Extra Wide', 'The Transparent Blue Brown Full Rim Square eyeglass brings together subtle color contrast and a contemporary silhouette for a truly distinctive look. The clear base blended with blue and brown tones creates a layered, modern finish that feels both elegant and youthful. Its square shape adds sharp definition to the face, making it a great choice for those who prefer structured yet stylish frames. Designed with a full rim for added strength and lens support, this eyeglass is comfortable for all-day wear while maintaining a premium appearance.', 4900.00, '1'),
(6, 6, 'Narrow', 'The Gold Rimless Square eyeglass exudes understated luxury with its sleek, minimalist design and refined golden accents. The rimless square shape offers a clean and modern look, giving the face a sharp yet lightweight appearance without overwhelming facial features. Subtle gold-toned temples and fittings add a touch of elegance, making this frame ideal for both professional and formal settings. Designed for comfort and durability, it provides a barely-there feel while ensuring clear vision and stability. Perfect for those who appreciate sophistication with simplicity, this eyeglass delivers timeless style and effortless confidence.\r\n', 3100.00, '1'),
(7, 7, 'Narrow', 'The Rimless Square eyeglass offers a clean, modern look with a lightweight and barely-there feel, making it ideal for everyday comfort. Its square lens shape adds subtle structure to the face while maintaining a refined and minimal appearance. Free from bulky frames, this design highlights facial features naturally and pairs effortlessly with both professional and casual outfits. Crafted with durable fittings for reliable support, it ensures long-lasting wear without compromising on style. Perfect for those who prefer simplicity and elegance, this eyeglass delivers clarity, comfort, and a timeless modern appeal.', 3900.00, '1'),
(8, 7, 'Wide', 'The Rimless Square eyeglass offers a clean, modern look with a lightweight and barely-there feel, making it ideal for everyday comfort. Its square lens shape adds subtle structure to the face while maintaining a refined and minimal appearance. Free from bulky frames, this design highlights facial features naturally and pairs effortlessly with both professional and casual outfits. Crafted with durable fittings for reliable support, it ensures long-lasting wear without compromising on style. Perfect for those who prefer simplicity and elegance, this eyeglass delivers clarity, comfort, and a timeless modern appeal.', 3500.00, '1'),
(9, 7, 'Extra Wide', 'The Rimless Square eyeglass offers a clean, modern look with a lightweight and barely-there feel, making it ideal for everyday comfort. Its square lens shape adds subtle structure to the face while maintaining a refined and minimal appearance. Free from bulky frames, this design highlights facial features naturally and pairs effortlessly with both professional and casual outfits. Crafted with durable fittings for reliable support, it ensures long-lasting wear without compromising on style. Perfect for those who prefer simplicity and elegance, this eyeglass delivers clarity, comfort, and a timeless modern appeal.', 4500.00, '1'),
(10, 8, 'Extra Wide', 'The Half Rim Full Square eyeglass combines modern styling with a smart, lightweight design for a polished everyday look. Featuring a square lens shape with a semi-rim structure, it offers the bold definition of a square frame while keeping the overall appearance sleek and refined. The half-rim design reduces visual bulk, making it comfortable for long hours of wear and ideal for professional or casual settings. Crafted for durability and balanced support, this eyeglass delivers clear vision with a contemporary edge, making it a perfect choice for those who appreciate subtle sophistication with modern functionality.', 3900.00, '1'),
(11, 8, 'Wide', 'The Half Rim Full Square eyeglass combines modern styling with a smart, lightweight design for a polished everyday look. Featuring a square lens shape with a semi-rim structure, it offers the bold definition of a square frame while keeping the overall appearance sleek and refined. The half-rim design reduces visual bulk, making it comfortable for long hours of wear and ideal for professional or casual settings. Crafted for durability and balanced support, this eyeglass delivers clear vision with a contemporary edge, making it a perfect choice for those who appreciate subtle sophistication with modern functionality.', 3500.00, '1'),
(12, 9, 'Medium', 'The Full Rim Rectangle eyeglass delivers a clean, confident look with a timeless design that suits everyday wear. Its rectangular frame shape adds a sharp, well-defined structure to the face, making it especially appealing for those who prefer a modern and professional appearance. Built with a sturdy full-rim construction, it offers excellent durability and secure lens support for long-lasting comfort. Versatile and stylish, this eyeglass pairs effortlessly with both formal and casual outfits, making it a reliable choice for those seeking practicality without compromising on refined style.\r\n', 3100.00, '1'),
(13, 9, 'Extra Wide', 'The Full Rim Rectangle eyeglass delivers a clean, confident look with a timeless design that suits everyday wear. Its rectangular frame shape adds a sharp, well-defined structure to the face, making it especially appealing for those who prefer a modern and professional appearance. Built with a sturdy full-rim construction, it offers excellent durability and secure lens support for long-lasting comfort. Versatile and stylish, this eyeglass pairs effortlessly with both formal and casual outfits, making it a reliable choice for those seeking practicality without compromising on refined style.\r\n', 3100.00, '1'),
(14, 10, 'Wide', 'The Full Rim Rectangle eyeglass delivers a clean, confident look with a timeless design that suits everyday wear. Its rectangular frame shape adds a sharp, well-defined structure to the face, making it especially appealing for those who prefer a modern and professional appearance. Built with a sturdy full-rim construction, it offers excellent durability and secure lens support for long-lasting comfort. Versatile and stylish, this eyeglass pairs effortlessly with both formal and casual outfits, making it a reliable choice for those seeking practicality without compromising on refined style.\r\n', 3500.00, '1'),
(15, 11, 'Medium', 'The Full Rim Rectangle eyeglass is designed for those who appreciate a balanced mix of sophistication and everyday functionality. Its sleek rectangular silhouette creates a refined, elongated look that enhances facial features while maintaining a subtle, modern charm. The full-rim build adds strength and stability, ensuring the frame holds up well to daily use and extended wear. Comfortable, versatile, and effortlessly stylish, this eyeglass transitions smoothly from work settings to casual outings, making it an ideal choice for individuals who value durability, clarity, and understated elegance.\r\n', 3100.00, '1'),
(16, 12, 'Medium', 'The Black Full Rim Rectangle eyeglass makes a strong style statement with its bold yet refined appearance. The deep black finish adds a touch of sophistication, while the rectangular frame shape provides clean lines that enhance facial structure. Crafted with a solid full-rim design, it offers excellent durability and dependable lens support for all-day comfort. Ideal for both professional environments and everyday wear, this eyeglass pairs seamlessly with any outfit, delivering a confident, polished look that never goes out of style.\r\n', 4100.00, '1'),
(17, 13, 'Medium', 'Reading Full Rim Rectangle Eyeglasses are designed to offer both comfort and clarity for everyday reading needs. Featuring a sturdy full-rim construction, these glasses provide excellent lens support and long-lasting durability, making them ideal for regular use. The rectangular shape delivers a clean, modern look that suits most face shapes while offering a wider field of vision for effortless reading. Lightweight yet strong materials ensure a comfortable fit without pressure on the nose or ears, allowing you to read, work, or browse for extended periods with ease.', 4100.00, '1'),
(18, 14, 'Wide', 'The Full Rim Rectangle eyeglass is designed for those who appreciate a balanced mix of sophistication and everyday functionality. Its sleek rectangular silhouette creates a refined, elongated look that enhances facial features while maintaining a subtle, modern charm. The full-rim build adds strength and stability, ensuring the frame holds up well to daily use and extended wear. Comfortable, versatile, and effortlessly stylish, this eyeglass transitions smoothly from work settings to casual outings, making it an ideal choice for individuals who value durability, clarity, and understated elegance.\r\n', 4900.00, '1'),
(19, 15, 'Extra Narrow', 'The Full Rim Rectangle eyeglass delivers a clean, confident look with a timeless design that suits everyday wear. Its rectangular frame shape adds a sharp, well-defined structure to the face, making it especially appealing for those who prefer a modern and professional appearance. Built with a sturdy full-rim construction, it offers excellent durability and secure lens support for long-lasting comfort. Versatile and stylish, this eyeglass pairs effortlessly with both formal and casual outfits, making it a reliable choice for those seeking practicality without compromising on refined style.\r\n', 3100.00, '1'),
(20, 16, 'Medium', 'The Tortoise Full Rim Rectangle eyeglass blends classic character with modern refinement, making it a timeless style choice. Its rich tortoise pattern adds depth and warmth to the frame, creating a distinctive look that stands out without being overpowering. The rectangular shape offers a clean, structured profile that complements a variety of face shapes, while the full-rim construction ensures durability and reliable lens support. Comfortable and versatile, this eyeglass transitions effortlessly from professional settings to casual wear, delivering a perfect balance of elegance, personality, and everyday practicality.\r\n', 4900.00, '1'),
(21, 17, 'Medium', 'The Rimless Rectangle eyeglass offers a sleek and lightweight design that emphasizes clarity and modern sophistication. With its clean rectangular lens shape and minimal hardware, it delivers a sharp, professional look while maintaining a barely-there feel on the face. The rimless construction reduces visual bulk, allowing natural facial features to stand out, and ensures all-day comfort during extended wear. Ideal for work or everyday use, this eyeglass is perfect for those who prefer a refined, understated style with a contemporary edge.\r\n', 4100.00, '1'),
(22, 17, 'Wide', 'The Wide Rimless Rectangle eyeglass is designed for those who prefer a broader fit without compromising on elegance and minimalism. Its wide rectangular lens shape offers enhanced coverage and a balanced look, making it ideal for wider face profiles. The rimless construction keeps the frame lightweight and refined, while subtle hardware provides stability and durability for everyday wear. With its clean lines and comfortable design, this eyeglass delivers a modern, professional appearance that feels effortless and sophisticated throughout the day.\r\n', 4200.00, '1'),
(23, 18, 'Medium', 'The Silver Rimless Rectangle eyeglass showcases a sleek, contemporary design with a refined metallic touch. The rimless rectangular lenses create a clean and lightweight profile, while the silver-toned temples and fittings add subtle elegance and a modern finish. Designed for all-day comfort, this frame offers a barely-there feel without sacrificing stability or durability. Perfect for professional and formal settings, it delivers a polished, sophisticated look that complements any outfit with understated confidence.\r\n', 4100.00, '1'),
(24, 19, 'Extra Wide', 'The Half Rim Rectangle eyeglass offers a smart blend of modern design and lightweight comfort. Featuring a rectangular lens shape with a semi-rim structure, it provides a clean and structured appearance while keeping the frame visually minimal. The half-rim design reduces overall weight, making it comfortable for extended wear throughout the day. With its refined lines and practical build, this eyeglass is well suited for both professional environments and everyday use, delivering a polished look with effortless functionality.\r\n', 4100.00, '1'),
(25, 19, 'Medium', 'The Half Rim Rectangle eyeglass offers a smart blend of modern design and lightweight comfort. Featuring a rectangular lens shape with a semi-rim structure, it provides a clean and structured appearance while keeping the frame visually minimal. The half-rim design reduces overall weight, making it comfortable for extended wear throughout the day. With its refined lines and practical build, this eyeglass is well suited for both professional environments and everyday use, delivering a polished look with effortless functionality.\r\n', 4100.00, '1'),
(26, 19, 'Wide', ' The Half Rim Rectangle eyeglass offers a smart blend of modern design and lightweight comfort. Featuring a rectangular lens shape with a semi-rim structure, it provides a clean and structured appearance while keeping the frame visually minimal. The half-rim design reduces overall weight, making it comfortable for extended wear throughout the day. With its refined lines and practical build, this eyeglass is well suited for both professional environments and everyday use, delivering a polished look with effortless functionality.\r\n', 4100.00, '1'),
(27, 20, 'Narrow', 'The Full Rim Round eyeglass offers a timeless and expressive design that adds a touch of vintage charm to modern eyewear. Its smooth round shape creates a soft, balanced look that complements facial features while delivering a distinct style statement. Crafted with a sturdy full-rim construction, it provides reliable durability and secure lens support for everyday use. Comfortable and versatile, this eyeglass pairs effortlessly with both casual and smart outfits, making it an ideal choice for those who appreciate classic elegance with a contemporary feel.\r\n', 3100.00, '1'),
(28, 20, 'Medium', 'The Full Rim Round Medium eyeglass is thoughtfully designed to offer a perfect balance between classic style and everyday comfort. With its medium-sized round frame, it provides a well-proportioned fit that suits a wide range of face shapes without appearing too bold or too subtle. The full-rim construction ensures durability and strong lens support, making it ideal for regular wear. Stylish yet practical, this eyeglass delivers a refined look that works seamlessly with both casual and professional outfits, offering timeless appeal with a comfortable, confident fit.\r\n', 3100.00, '1'),
(29, 21, 'Narrow', 'The Full Rim Round eyeglass offers a timeless and expressive design that adds a touch of vintage charm to modern eyewear. Its smooth round shape creates a soft, balanced look that complements facial features while delivering a distinct style statement. Crafted with a sturdy full-rim construction, it provides reliable durability and secure lens support for everyday use. Comfortable and versatile, this eyeglass pairs effortlessly with both casual and smart outfits, making it an ideal choice for those who appreciate classic elegance with a contemporary feel.\r\n', 1550.00, '1'),
(30, 22, 'Medium', 'The Mauve Full Rim Round eyeglass brings a soft yet stylish touch to everyday eyewear with its elegant pastel tone. The subtle mauve shade adds warmth and sophistication, making it a refreshing alternative to classic neutrals while still remaining versatile. Its round frame shape offers a smooth, balanced look that enhances facial features with a hint of vintage charm. Crafted with a sturdy full-rim design, this eyeglass ensures durability and comfortable all-day wear, making it perfect for those who enjoy gentle color accents paired with timeless style.\r\n', 6000.00, '1'),
(31, 23, 'Medium', 'The Gold Full Rim Round eyeglass brings a touch of luxury to a classic silhouette, making it a standout choice for refined everyday style. The warm gold finish adds elegance and sophistication, while the round frame shape offers a balanced, vintage-inspired look that softens facial features. Crafted with a durable full-rim construction, it provides strong lens support and comfortable all-day wear. Perfect for both professional and special occasions, this eyeglass blends timeless charm with a premium feel, delivering confidence and understated glamour in every look.\r\n', 4100.00, '1'),
(32, 24, 'Narrow', 'The Full Rim Round eyeglass features a classic design that blends timeless appeal with modern comfort. Its smooth, rounded frame creates a balanced and expressive look, adding a touch of vintage charm while remaining effortlessly stylish. Built with a sturdy full-rim construction, it offers reliable durability and secure lens support for daily use. Comfortable and versatile, this eyeglass complements both casual and formal outfits, making it an ideal choice for those who value elegance, practicality, and enduring style.\r\n', 4100.00, '1'),
(33, 25, 'Wide', 'The Metal Combo Full Rim Round eyeglass blends contemporary design with classic elegance, making it a refined choice for everyday wear. Featuring a stylish combination of metal elements with a full-rim round silhouette, it offers a balanced look that feels both modern and timeless. The round shape softens facial features, while the sturdy full-rim construction ensures durability and reliable lens support. Lightweight and comfortable, this eyeglass is ideal for long hours of use and transitions effortlessly from professional settings to casual occasions, delivering a polished and confident appearance.\r\n', 4100.00, '1'),
(34, 26, 'Medium', 'The black half rim round eyeglasses offer a refined balance of classic shape and modern minimalism. Designed with a sleek black half rim structure and smooth round lenses, this frame delivers a lightweight and comfortable feel while maintaining a sharp, intelligent look. The subtle rim detailing adds definition without overpowering the face, making it suitable for both professional and casual wear. Its versatile black finish pairs effortlessly with any outfit, enhancing everyday style with understated elegance and long-lasting appeal.\r\n', 6000.00, '1'),
(35, 27, 'Extra Narrow', 'The gold rimless round eyeglasses bring together timeless elegance and modern sophistication. Featuring a lightweight rimless design paired with finely crafted gold-toned temples and bridge, this frame offers a barely-there feel with a refined visual appeal. The round lens shape adds a classic, intellectual charm, while the subtle gold finish enhances the overall look with a touch of luxury. Perfect for both formal and everyday wear, these eyeglasses deliver comfort, durability, and understated style that effortlessly complements any outfit.\r\n', 4100.00, '1'),
(36, 28, 'Medium', 'The black full rim cat eye eyeglasses are a bold expression of elegance and confidence, designed to highlight feminine features with a stylish vintage touch. Crafted with a sleek full rim frame in a classic black finish, this design offers excellent durability while making a strong fashion statement. The signature upswept cat eye shape adds definition and lifts the look, enhancing facial contours with a flattering silhouette. Versatile and timeless, these eyeglasses seamlessly transition from everyday wear to special occasions, pairing comfort with a sophisticated, glamorous appeal.\r\n', 3100.00, '1'),
(37, 28, 'Wide', 'The black full rim cat eye eyeglasses are a bold expression of elegance and confidence, designed to highlight feminine features with a stylish vintage touch. Crafted with a sleek full rim frame in a classic black finish, this design offers excellent durability while making a strong fashion statement. The signature upswept cat eye shape adds definition and lifts the look, enhancing facial contours with a flattering silhouette. Versatile and timeless, these eyeglasses seamlessly transition from everyday wear to special occasions, pairing comfort with a sophisticated, glamorous appeal.\r\n', 3100.00, '1'),
(38, 29, 'Medium', 'The full rim cat eye eyeglasses are a perfect blend of classic glamour and contemporary style, designed to accentuate facial features with a bold yet elegant silhouette. Featuring a well-defined full rim structure, this frame offers durability and a confident look while beautifully framing the eyes. The iconic cat eye shape adds a graceful lift and a touch of retro charm, making it ideal for those who love expressive, fashion-forward eyewear. Comfortable for all-day wear and versatile enough for both casual and formal outfits, these eyeglasses bring personality, sophistication, and timeless appeal to any look.\r\n', 3100.00, '1'),
(39, 30, 'Extra Narrow', 'The full rim cat eye extra narrow eyeglasses are thoughtfully designed for petite and slim face shapes, offering a refined fit without compromising on style. Crafted with a sleek full rim construction, this frame provides durability while maintaining a lightweight and comfortable feel. The extra narrow cat eye silhouette delivers a subtle upswept effect that enhances facial features with elegance and precision, adding a touch of modern sophistication. Ideal for everyday wear as well as dressier occasions, these eyeglasses combine a flattering fit with timeless fashion, making them a perfect choice for those who prefer a delicate yet confident look.\r\n', 3100.00, '1'),
(40, 31, 'Extra Wide', 'The demi full rim cat eye eyeglasses offer a stylish blend of soft color contrast and timeless elegance. Designed with a demi or dual-tone finish, this full rim frame adds visual depth while maintaining a refined and balanced look. The classic cat eye shape gently lifts the facial contours, creating a flattering and feminine silhouette. Lightweight yet durable, these eyeglasses provide all-day comfort and versatility, making them suitable for both everyday wear and special occasions. With their modern color appeal and graceful design, they bring a touch of sophistication and personality to any outfit.\r\n', 4100.00, '1'),
(41, 33, 'Wide', 'The full rim aviator eyeglasses offer a bold and timeless design inspired by classic pilot frames, reimagined for everyday wear. Crafted with a complete rim structure, this style provides enhanced durability while preserving the iconic aviator silhouette with its distinctive double bridge and softly contoured lenses. The full rim build adds a modern edge and stable fit, making the frame comfortable for all-day use. Versatile and stylish, full rim aviator eyeglasses effortlessly blend vintage charm with contemporary appeal, making them suitable for both casual and formal looks.\r\n', 3100.00, '1'),
(42, 33, 'Medium', 'The medium full rim aviator eyeglasses are designed to deliver the iconic pilot-inspired look with a perfectly balanced fit for everyday comfort. Featuring a sturdy full rim construction, this frame offers durability while maintaining the classic aviator silhouette, complete with a distinctive double bridge and smooth, contoured lenses. The medium size ensures a comfortable and proportionate fit for most face shapes, making it ideal for long hours of wear. Stylish yet practical, these eyeglasses combine timeless appeal with modern functionality, effortlessly complementing both casual and professional outfits.\r\n', 4100.00, '1'),
(43, 33, 'Narrow', 'The full rim aviator eyeglasses offer a bold and timeless design inspired by classic pilot frames, reimagined for everyday wear. Crafted with a complete rim structure, this style provides enhanced durability while preserving the iconic aviator silhouette with its distinctive double bridge and softly contoured lenses. The full rim build adds a modern edge and stable fit, making the frame comfortable for all-day use. Versatile and stylish, full rim aviator eyeglasses effortlessly blend vintage charm with contemporary appeal, making them suitable for both casual and formal looks.\r\n', 4100.00, '1'),
(44, 34, 'Extra Narrow', 'The half rim aviator eyeglasses combine the iconic pilot-inspired silhouette with a lightweight, modern design. Featuring a classic aviator shape with a sleek half rim construction, this frame offers a refined balance of style and comfort while maintaining an open, minimal look. The distinctive double bridge adds a timeless touch, while the reduced rim structure keeps the frame light and easy to wear throughout the day. Perfect for both professional and casual settings, half rim aviator eyeglasses deliver durability, elegance, and a contemporary edge to a classic design.\r\n', 3100.00, '1'),
(45, 34, 'Wide', 'The half rim aviator eyeglasses in a narrow shape are thoughtfully crafted for slimmer face profiles, offering a sharp and well-balanced look. Designed with a lightweight half rim structure, this frame preserves the classic aviator silhouette and signature double bridge while keeping the overall design sleek and unobtrusive. The narrow lens width and streamlined proportions ensure a comfortable, secure fit without overwhelming facial features. Stylish and practical, these eyeglasses blend timeless aviator appeal with modern minimalism, making them ideal for everyday wear and professional settings.\r\n', 4100.00, '1'),
(46, 35, 'Extra Narrow', 'The black rimless aviator eyeglasses for narrow faces offer a sleek, modern interpretation of the classic pilot style. Designed with a lightweight rimless construction, this frame delivers a clean, barely-there look while retaining the iconic aviator shape and double bridge detailing. The slim, narrow fit ensures a precise and comfortable wear, making it ideal for smaller or slimmer face shapes. Finished in a refined black tone, these eyeglasses strike the perfect balance between sophistication and minimalism, suitable for both everyday use and professional settings.\r\n', 4100.00, '1'),
(47, 36, 'Extra Narrow', 'The full rim geometric eyeglasses for narrow faces are designed to make a bold style statement while maintaining a sleek, well-proportioned fit. Featuring a sharp geometric lens shape and a structured full rim build, this frame adds definition and a contemporary edge without overwhelming slimmer facial features. The narrow sizing ensures a secure, comfortable fit, while the clean lines and modern design enhance facial symmetry. Ideal for fashion-forward individuals, these eyeglasses combine durability, comfort, and standout style, making them perfect for both everyday wear and expressive looks.\r\n', 4100.00, '1'),
(48, 36, 'Medium', 'The full rim geometric eyeglasses for narrow faces are designed to make a bold style statement while maintaining a sleek, well-proportioned fit. Featuring a sharp geometric lens shape and a structured full rim build, this frame adds definition and a contemporary edge without overwhelming slimmer facial features. The narrow sizing ensures a secure, comfortable fit, while the clean lines and modern design enhance facial symmetry. Ideal for fashion-forward individuals, these eyeglasses combine durability, comfort, and standout style, making them perfect for both everyday wear and expressive looks.\r\n', 3200.00, '1'),
(49, 37, 'Medium', 'The pink transparent full rim geometric eyeglasses for narrow faces bring a fresh, modern charm with a lightweight and stylish appeal. Crafted with a sleek full rim construction in a soft transparent pink finish, this frame adds subtle color while maintaining a clean and airy look. The geometric lens shape introduces sharp, contemporary lines that enhance facial features without overpowering slimmer face profiles. Designed for comfort and a precise narrow fit, these eyeglasses are perfect for everyday wear, effortlessly blending playful elegance with modern sophistication.\r\n', 4200.00, '1'),
(50, 38, 'Narrow', 'The full rim geometric eyeglasses for narrow faces are designed to make a bold style statement while maintaining a sleek, well-proportioned fit. Featuring a sharp geometric lens shape and a structured full rim build, this frame adds definition and a contemporary edge without overwhelming slimmer facial features. The narrow sizing ensures a secure, comfortable fit, while the clean lines and modern design enhance facial symmetry. Ideal for fashion-forward individuals, these eyeglasses combine durability, comfort, and standout style, making them perfect for both everyday wear and expressive looks.\r\n', 4200.00, '1'),
(51, 38, 'Wide', 'The full rim geometric eyeglasses for narrow faces are designed to make a bold style statement while maintaining a sleek, well-proportioned fit. Featuring a sharp geometric lens shape and a structured full rim build, this frame adds definition and a contemporary edge without overwhelming slimmer facial features. The narrow sizing ensures a secure, comfortable fit, while the clean lines and modern design enhance facial symmetry. Ideal for fashion-forward individuals, these eyeglasses combine durability, comfort, and standout style, making them perfect for both everyday wear and expressive looks.\r\n', 4100.00, '1'),
(52, 39, 'Medium', 'The full rim Clubmaster eyeglasses offer a refined blend of vintage inspiration and modern craftsmanship. Featuring the iconic Clubmaster design with a bold upper frame and balanced full rim construction, this style delivers a confident and sophisticated look. The structured silhouette adds definition to the face while ensuring durability and a comfortable fit for all-day wear. Timeless yet versatile, full rim Clubmaster eyeglasses effortlessly complement both professional and casual outfits, making them a classic choice for those who appreciate retro charm with contemporary appeal.\r\n', 4100.00, '1'),
(53, 39, 'Wide', 'The full rim Clubmaster eyeglasses offer a refined blend of vintage inspiration and modern craftsmanship. Featuring the iconic Clubmaster design with a bold upper frame and balanced full rim construction, this style delivers a confident and sophisticated look. The structured silhouette adds definition to the face while ensuring durability and a comfortable fit for all-day wear. Timeless yet versatile, full rim Clubmaster eyeglasses effortlessly complement both professional and casual outfits, making them a classic choice for those who appreciate retro charm with contemporary appeal.\r\n', 4100.00, '1'),
(54, 39, 'Extra Wide', 'The full rim Clubmaster eyeglasses offer a refined blend of vintage inspiration and modern craftsmanship. Featuring the iconic Clubmaster design with a bold upper frame and balanced full rim construction, this style delivers a confident and sophisticated look. The structured silhouette adds definition to the face while ensuring durability and a comfortable fit for all-day wear. Timeless yet versatile, full rim Clubmaster eyeglasses effortlessly complement both professional and casual outfits, making them a classic choice for those who appreciate retro charm with contemporary appeal.\r\n', 4100.00, '1'),
(55, 40, 'Wide', 'A Full Rim Square sunglass offers a bold, structured look that combines modern style with everyday comfort. The defined square frame adds sharpness to facial features, making it an excellent choice for those who prefer a confident and contemporary appearance. Crafted with a sturdy full-rim design, it provides enhanced durability while securely holding the lenses in place. The wide frame coverage helps reduce glare and offers better sun protection, making it ideal for outdoor use. Versatile and stylish, full rim square sunglasses pair effortlessly with casual outfits as well as smart, fashion-forward looks, delivering both function and standout style in one refined design.\r\n', 1200.00, '1'),
(56, 41, 'Wide', 'A Full Rim Square sunglass offers a bold, structured look that combines modern style with everyday comfort. The defined square frame adds sharpness to facial features, making it an excellent choice for those who prefer a confident and contemporary appearance. Crafted with a sturdy full-rim design, it provides enhanced durability while securely holding the lenses in place. The wide frame coverage helps reduce glare and offers better sun protection, making it ideal for outdoor use. Versatile and stylish, full rim square sunglasses pair effortlessly with casual outfits as well as smart, fashion-forward looks, delivering both function and standout style in one refined design.\r\n', 1200.00, '1'),
(57, 42, 'Extra Wide', 'The Matte Black Full Rim Square frame features a clean, modern design that blends style with everyday comfort. Crafted with a full-rim structure, it offers durability and a confident look, while the square shape adds sharp definition that suits a wide range of face types. The matte black finish gives it a sleek, understated elegance, making it versatile for both casual and professional wear. Lightweight yet sturdy, this frame is designed for all-day comfort without compromising on style.\r\n', 1200.00, '1'),
(58, 41, 'Medium', 'A Full Rim Square sunglass offers a bold, structured look that combines modern style with everyday comfort. The defined square frame adds sharpness to facial features, making it an excellent choice for those who prefer a confident and contemporary appearance. Crafted with a sturdy full-rim design, it provides enhanced durability while securely holding the lenses in place. The wide frame coverage helps reduce glare and offers better sun protection, making it ideal for outdoor use. Versatile and stylish, full rim square sunglasses pair effortlessly with casual outfits as well as smart, fashion-forward looks, delivering both function and standout style in one refined design.\r\n', 1500.00, '1'),
(59, 43, 'Extra Wide', 'A Demi Full Rim Square frame blends classic structure with a subtle touch of contrast, making it a stylish yet balanced eyewear choice. The square shape delivers a sharp, well-defined look that enhances facial features, while the demi finish—typically combining two complementary tones—adds depth and visual interest to the frame. Designed with a full rim build, it offers durability, lens stability, and all-day comfort. This style works effortlessly for both professional and casual settings, giving a polished appearance without looking too bold. The demi full rim square frame is ideal for those who appreciate timeless design with a modern, fashion-forward edge.\r\n', 6000.00, '1'),
(60, 44, 'Wide', 'A Full Rim Square sunglass offers a bold, structured look that combines modern style with everyday comfort. The defined square frame adds sharpness to facial features, making it an excellent choice for those who prefer a confident and contemporary appearance. Crafted with a sturdy full-rim design, it provides enhanced durability while securely holding the lenses in place. The wide frame coverage helps reduce glare and offers better sun protection, making it ideal for outdoor use. Versatile and stylish, full rim square sunglasses pair effortlessly with casual outfits as well as smart, fashion-forward looks, delivering both function and standout style in one refined design.\r\n', 1200.00, '1'),
(61, 45, 'Medium', 'Gold Full Rim Square eyeglasses bring a perfect blend of luxury and modern design, making them an ideal choice for those who appreciate refined style. The bold square silhouette adds structure to the face, while the rich gold finish delivers a premium, eye-catching appeal. Crafted with a full rim frame, these glasses offer durability and a comfortable fit for all-day wear. The sleek metallic tone enhances both formal and casual looks, adding a subtle touch of elegance without being overpowering. Ideal for individuals who want a confident, polished appearance, Gold Full Rim Square frames effortlessly balance sophistication with everyday practicality.\r\n', 1500.00, '1'),
(62, 46, 'Extra Wide', 'Jet Black Full Rim Square eyeglasses offer a bold, timeless look that never goes out of style. The clean square shape provides sharp definition to the face, making it a versatile choice for both professional and casual wear. Finished in a deep jet black tone, the frame delivers a sleek, confident appeal with a modern edge. The full rim construction ensures durability and a secure fit, making these glasses suitable for all-day comfort. Perfect for those who prefer a strong yet understated style, Jet Black Full Rim Square frames effortlessly combine functionality with classic elegance.\r\n', 2000.00, '1'),
(63, 47, 'Wide', 'Blue Transparent Full Rim Square eyeglasses offer a refreshing blend of modern style and subtle elegance. The clear blue finish adds a light, airy feel to the frame, giving it a contemporary look that stands out without appearing too bold. Designed with a structured square shape, these glasses provide sharp definition while complementing a variety of face shapes. The full rim construction ensures durability and a secure, comfortable fit for everyday wear. Perfect for those who like a clean, stylish aesthetic with a hint of color, Blue Transparent Full Rim Square frames bring a cool, confident charm to both casual and professional outfits.\r\n', 1200.00, '1'),
(64, 47, 'Narrow', 'A Full Rim Square sunglass offers a bold, structured look that combines modern style with everyday comfort. The defined square frame adds sharpness to facial features, making it an excellent choice for those who prefer a confident and contemporary appearance. Crafted with a sturdy full-rim design, it provides enhanced durability while securely holding the lenses in place. The wide frame coverage helps reduce glare and offers better sun protection, making it ideal for outdoor use. Versatile and stylish, full rim square sunglasses pair effortlessly with casual outfits as well as smart, fashion-forward looks, delivering both function and standout style in one refined design.\r\n', 1700.00, '1'),
(65, 1, 'Extra Wide', 'A Full Rim Square sunglass offers a bold, structured look that combines modern style with everyday comfort. The defined square frame adds sharpness to facial features, making it an excellent choice for those who prefer a confident and contemporary appearance. Crafted with a sturdy full-rim design, it provides enhanced durability while securely holding the lenses in place. The wide frame coverage helps reduce glare and offers better sun protection, making it ideal for outdoor use. Versatile and stylish, full rim square sunglasses pair effortlessly with casual outfits as well as smart, fashion-forward looks, delivering both function and standout style in one refined design.\r\n', 3000.00, '1'),
(66, 48, 'Extra Wide', 'A Black Rimless Square frame delivers a clean, minimal look with a touch of modern sophistication. The square lens shape adds structure and balance to the face, while the rimless design keeps the overall appearance lightweight and refined. Accented with sleek black temples and fittings, it offers subtle contrast without overpowering the face. Designed for comfort and everyday wear, this style feels almost weightless while maintaining a sharp, professional appeal. Ideal for formal, office, or minimalist fashion preferences, the black rimless square frame is a perfect choice for those who value understated elegance and contemporary design.\r\n', 1200.00, '1'),
(67, 49, 'Medium', 'A Gold Rimless Square frame exudes understated luxury with a refined, modern appeal. The crisp square lens shape adds definition to the face, while the rimless construction creates a light, barely-there feel for all-day comfort. Finished with elegant gold-toned temples and accents, it brings a subtle touch of sophistication without appearing flashy. This design balances minimalism and elegance, making it suitable for both professional and formal settings. The gold rimless square frame is an excellent choice for those who prefer a clean, polished look with a hint of premium style.\r\n', 1200.00, '1'),
(68, 50, 'Extra Wide', 'A Full Rim Rectangle frame offers a clean, structured look that blends everyday comfort with modern style. Designed with a complete rim encasing the lenses, this frame provides strong support and long-lasting durability, making it ideal for daily wear. The rectangular shape adds a sharp, balanced appearance that suits a wide range of face shapes, especially round and oval faces. With its sleek lines and versatile design, a full rim rectangle frame works effortlessly for both professional and casual settings, delivering a confident, polished finish while ensuring all-day comfort and stability.\r\n', 2000.00, '1'),
(69, 51, 'Medium', 'A Silver Full Rim Rectangle frame delivers a refined and contemporary look with a touch of understated elegance. The full rim construction offers excellent durability and secure lens support, making it perfect for everyday use. Its rectangular shape creates a sharp, well-defined appearance that complements round and oval face shapes, adding balance and structure to the features. The silver finish enhances the frame with a sleek, modern shine, making it suitable for both professional and casual wear. Lightweight yet sturdy, this frame combines comfort, style, and practicality for a polished, confident look throughout the day.\r\n', 3000.00, '1'),
(70, 50, 'Medium', 'A Full Rim Rectangle frame offers a clean, structured look that blends everyday comfort with modern style. Designed with a complete rim encasing the lenses, this frame provides strong support and long-lasting durability, making it ideal for daily wear. The rectangular shape adds a sharp, balanced appearance that suits a wide range of face shapes, especially round and oval faces. With its sleek lines and versatile design, a full rim rectangle frame works effortlessly for both professional and casual settings, delivering a confident, polished finish while ensuring all-day comfort and stability.\r\n', 2690.00, '1'),
(71, 52, 'Medium', 'A Full Rim Rectangle frame offers a clean, structured look that blends everyday comfort with modern style. Designed with a complete rim encasing the lenses, this frame provides strong support and long-lasting durability, making it ideal for daily wear. The rectangular shape adds a sharp, balanced appearance that suits a wide range of face shapes, especially round and oval faces. With its sleek lines and versatile design, a full rim rectangle frame works effortlessly for both professional and casual settings, delivering a confident, polished finish while ensuring all-day comfort and stability.\r\n', 1500.00, '1'),
(72, 50, 'Wide', 'A Full Rim Rectangle frame offers a clean, structured look that blends everyday comfort with modern style. Designed with a complete rim encasing the lenses, this frame provides strong support and long-lasting durability, making it ideal for daily wear. The rectangular shape adds a sharp, balanced appearance that suits a wide range of face shapes, especially round and oval faces. With its sleek lines and versatile design, a full rim rectangle frame works effortlessly for both professional and casual settings, delivering a confident, polished finish while ensuring all-day comfort and stability.\r\n', 1200.00, '1'),
(73, 53, 'Extra Wide', 'A Black Full Rim Rectangle frame is a timeless choice that combines classic style with everyday practicality. The full rim design provides strong lens support and durability, making it ideal for regular wear. Its rectangular shape offers a clean, structured look that enhances facial balance, especially for round and oval face shapes. The bold black finish adds a touch of sophistication and versatility, easily pairing with both formal and casual outfits. Comfortable, sturdy, and stylish, this frame delivers a confident, polished appearance that never goes out of fashion.\r\n', 2000.00, '1'),
(74, 54, 'Medium', 'A Rimless Rectangle sunglass offers a sleek, lightweight design that delivers a modern and minimal look. With no full frame around the lenses, it provides an airy, barely-there feel while ensuring clear, unobstructed vision. The rectangular lens shape adds a sharp, contemporary edge that flatters round and oval face shapes, creating a balanced and refined appearance. Perfect for outdoor wear, this sunglass combines comfort with style, making it ideal for long hours under the sun. Its clean, understated design suits both casual and smart outfits, offering effortless elegance with everyday functionality.\r\n', 2000.00, '1'),
(75, 56, 'Extra Wide', 'A Matte Black Half Rim Rectangle frame brings together modern design and everyday comfort with a sleek, understated appeal. The half rim construction offers a lighter feel while still providing reliable lens support, making it ideal for long hours of wear. Its rectangular shape creates a sharp, professional look that adds structure to the face, especially complementing round and oval face shapes. The matte black finish gives the frame a refined, non-glossy appearance, enhancing its contemporary style and versatility. Durable yet comfortable, this frame is perfect for both work and casual settings, delivering a confident and polished look.\r\n', 3000.00, '1'),
(76, 57, 'Narrow', 'A Full Rim Round sunglass offers a perfect blend of vintage charm and modern style, making it a timeless accessory for any wardrobe. Designed with a complete circular frame, it provides excellent lens support and durability while creating a bold, well-defined look on the face. The rounded shape softens sharp features and adds a classic, retro-inspired appeal that suits both casual and stylish outfits. Crafted for comfort, the full rim construction ensures a secure fit for all-day wear, while the lenses provide reliable protection from sunlight and glare. Ideal for those who love effortless fashion with a touch of sophistication, the Full Rim Round sunglass is a versatile choice that never goes out of trend.\r\n', 2000.00, '1'),
(77, 57, 'Extra Wide', 'A Full Rim Round sunglass offers a perfect blend of vintage charm and modern style, making it a timeless accessory for any wardrobe. Designed with a complete circular frame, it provides excellent lens support and durability while creating a bold, well-defined look on the face. The rounded shape softens sharp features and adds a classic, retro-inspired appeal that suits both casual and stylish outfits. Crafted for comfort, the full rim construction ensures a secure fit for all-day wear, while the lenses provide reliable protection from sunlight and glare. Ideal for those who love effortless fashion with a touch of sophistication, the Full Rim Round sunglass is a versatile choice that never goes out of trend.\r\n', 2000.00, '1'),
(78, 58, 'Wide', 'The Tortoise Full Rim Round frame blends timeless elegance with everyday versatility, making it a standout choice for those who appreciate classic style with a modern touch. Featuring a rich tortoiseshell pattern in warm brown and amber tones, this frame adds depth and character to any look. The full rim round shape offers a soft, balanced silhouette that flatters a wide range of face shapes while delivering a retro-inspired appeal. Crafted for durability and comfort, it sits securely on the face, making it ideal for all-day wear. Perfect for both casual and polished outfits, this frame brings a refined yet expressive charm to your eyewear collection.\r\n', 2000.00, '1');
INSERT INTO `product_variation_tbl` (`pvariation_id`, `product_id`, `size`, `description`, `price`, `v_status`) VALUES
(79, 59, 'Wide', 'The Gold Full Rim Round Sunglass exudes a luxurious and refined charm, perfect for those who love a bold yet classy look. Designed with a sleek full rim in a radiant gold finish, this sunglass brings a touch of vintage elegance while maintaining a modern edge. The round silhouette offers a balanced and flattering shape that complements various face types, adding softness and sophistication to your style. Crafted for comfort and durability, it ensures a secure fit for everyday wear. Ideal for both casual outings and statement looks, this sunglass effortlessly elevates your appearance with a polished and premium feel.\r\n', 2000.00, '1'),
(80, 60, 'Extra Wide', 'The Gold Full Rim Aviator Sunglass delivers a perfect blend of iconic style and modern sophistication. Featuring a classic aviator silhouette enhanced with a full rim in a rich gold finish, this sunglass adds a bold yet elegant statement to any look. The structured frame provides a confident, defined appearance while maintaining the timeless appeal aviators are known for. Designed for comfort and durability, it offers a secure fit suitable for all-day wear. Ideal for both casual and stylish occasions, this sunglass brings a premium, effortlessly cool edge to your eyewear collection.\r\n', 3500.00, '1'),
(81, 61, 'Medium', 'The Gold Full Rim Aviator Sunglass combines iconic design with a touch of luxury, making it a timeless style essential. Crafted with a sturdy full rim in a gleaming gold finish, this aviator frame delivers a bold yet sophisticated look. The classic aviator shape enhances facial features while offering a confident, structured appeal. Designed for comfort and long-lasting wear, it sits securely and feels lightweight on the face. Perfect for travel, outdoor wear, or everyday styling, this sunglass effortlessly elevates both casual and refined outfits with its premium and polished presence.\r\n', 4500.00, '1'),
(82, 62, 'Extra Wide', 'The Blue Transparent Full Rim Aviator Sunglass offers a fresh and contemporary take on the classic aviator style. Designed with a clear blue transparent full rim, it adds a modern, lightweight feel while maintaining the bold character of the iconic aviator shape. The subtle transparency creates a stylish, eye-catching look that feels both playful and refined. Comfortable for extended wear, this frame provides a secure fit and easy versatility. Ideal for casual outings and trend-forward styling, it brings a cool, confident vibe to your everyday eyewear collection.\r\n', 4000.00, '1'),
(83, 63, 'Extra Wide', 'The Silver Full Rim Aviator Sunglass showcases a sleek and timeless design that blends classic appeal with modern elegance. Featuring a polished silver full rim, this aviator frame delivers a bold yet refined look that stands out without being overpowering. The iconic aviator shape adds a confident, structured silhouette that complements a variety of face shapes. Crafted for comfort and durability, it ensures a secure fit for all-day wear. Perfect for both casual and stylish occasions, this sunglass adds a clean, sophisticated edge to your eyewear collection.\r\n', 4000.00, '1'),
(84, 64, 'Extra Wide', 'The Black Full Rim Aviator Sunglass delivers a bold and confident look with a timeless edge. Designed with a solid black full rim, this frame adds depth and sophistication to the classic aviator silhouette. The structured shape enhances facial features while maintaining the iconic aviator appeal. Built for comfort and durability, it offers a secure fit suitable for extended wear. Perfect for everyday use or statement styling, this sunglass pairs effortlessly with both casual and polished outfits, making it a versatile and stylish choice.\r\n', 4000.00, '1'),
(85, 65, 'Medium', 'The Gold Half Rim Aviator Sunglass offers a refined and contemporary twist on the iconic aviator design. Featuring a sleek gold half rim, it delivers a lightweight feel while maintaining a bold, stylish presence. The classic aviator shape adds a confident and balanced silhouette, while the open lower rim enhances its modern appeal. Crafted for comfort and durability, it ensures a secure fit for all-day wear. Ideal for both casual outings and polished looks, this sunglass brings a subtle touch of luxury and effortless sophistication to your eyewear collection.\r\n', 4500.00, '1'),
(86, 66, 'Medium', 'Full Rim Cat Eye Sunglasses are a perfect blend of elegance and bold style, designed to add a fashionable edge to any look. Featuring a distinctive upswept frame, they beautifully enhance facial features while offering a flattering, feminine silhouette. The full-rim construction provides durability and a confident presence, making these sunglasses suitable for both everyday wear and special outings. With lenses that offer reliable sun protection and a frame that balances comfort with statement design, full rim cat eye sunglasses are ideal for those who love a chic, vintage-inspired accessory with a modern touch.\r\n', 4500.00, '1'),
(87, 67, 'Wide', 'Green Full Rim Cat Eye Sunglasses bring a fresh and stylish twist to a classic silhouette, making them a standout accessory for any wardrobe. The elegant cat eye shape adds a feminine, flattering lift to the face, while the rich green full-rim frame offers a unique blend of sophistication and modern charm. Designed for both comfort and durability, these sunglasses provide reliable sun protection and a secure fit for all-day wear. Perfect for casual outings or statement styling, green full rim cat eye sunglasses effortlessly combine bold color with timeless fashion appeal.\r\n', 4000.00, '1'),
(88, 68, 'Wide', 'Black Full Rim Cat Eye Sunglasses offer a timeless and elegant look with a bold fashion-forward edge. The classic cat eye shape enhances facial features with its graceful, upswept design, adding a touch of glamour and confidence. The solid black full-rim frame delivers durability and a sleek, versatile appeal that pairs effortlessly with any outfit. Crafted for comfort and effective sun protection, these sunglasses are ideal for everyday wear as well as special occasions, making them a must-have accessory for those who appreciate sophisticated style with a modern finish.\r\n', 4690.00, '1'),
(89, 69, 'Wide', 'Rose Gold Full Rim Cat Eye Sunglasses exude elegance and modern glamour, making them a stunning statement accessory. The graceful cat eye silhouette beautifully accentuates facial features, while the rose gold full-rim frame adds a soft metallic shine that feels both luxurious and feminine. Designed for comfort and durability, these sunglasses offer reliable sun protection along with a lightweight, secure fit. Perfect for elevating everyday outfits or complementing special looks, rose gold full rim cat eye sunglasses blend timeless charm with contemporary sophistication.\r\n', 4300.00, '1'),
(90, 70, 'Narrow', 'Crystal Transparent Full Rim Cat Eye Sunglasses offer a sleek and contemporary take on a classic feminine design. The clear, crystal-transparent frame creates a light and airy look while allowing the elegant cat eye shape to stand out beautifully. With a full-rim structure that ensures durability and comfort, these sunglasses provide reliable sun protection without overpowering your style. Perfect for both casual and chic outfits, crystal transparent full rim cat eye sunglasses add a subtle yet fashionable touch, making them ideal for those who love modern elegance with a minimal, trendy appeal.\r\n', 3500.00, '1'),
(91, 71, 'Wide', 'Brown Full Rim Geometric Sunglasses showcase a bold and contemporary design that stands out with effortless style. The sharp geometric frame adds a modern edge, while the warm brown full-rim finish brings a sense of sophistication and versatility. Crafted for durability and all-day comfort, these sunglasses offer dependable sun protection along with a confident, structured look. Ideal for those who prefer unique shapes with a refined color palette, brown full rim geometric sunglasses perfectly balance fashion-forward appeal with everyday wearability.\r\n', 4000.00, '1'),
(92, 72, 'Medium', 'Black Full Rim Geometric Sunglasses deliver a striking, modern look with a bold architectural edge. The defined geometric shape creates a confident and fashion-forward silhouette, while the classic black full-rim frame adds timeless sophistication and versatility. Built for durability and comfortable daily wear, these sunglasses provide reliable sun protection without compromising on style. Perfect for trendsetters and minimalists alike, black full rim geometric sunglasses make a powerful statement while remaining effortlessly stylish.\r\n', 3000.00, '1'),
(93, 73, 'Medium', 'Sky Blue Full Rim Geometric Sunglasses bring a fresh and contemporary vibe to bold eyewear styling. The distinctive geometric frame creates a sharp, modern silhouette, while the soothing sky blue full-rim color adds a playful yet refined touch. Designed for comfort and durability, these sunglasses offer dependable sun protection along with a lightweight feel for all-day wear. Ideal for those who love experimenting with color and shape, sky blue full rim geometric sunglasses make a stylish statement while keeping the look effortlessly cool and modern.\r\n', 3000.00, '1'),
(94, 74, 'Narrow', 'Grey Full Rim Geometric Sunglasses offer a perfect balance of modern design and understated elegance. The bold geometric shape gives a sharp, contemporary look, while the neutral grey full-rim frame adds a refined and versatile appeal. Crafted for durability and comfortable everyday wear, these sunglasses provide reliable sun protection with a sleek, minimalist finish. Ideal for both casual and smart styling, grey full rim geometric sunglasses are a great choice for those who appreciate subtle sophistication with a fashion-forward edge.\r\n', 3400.00, '1'),
(95, 75, 'Medium', 'Silver Full Rim Clubmaster Sunglasses combine classic retro charm with a sleek, modern finish. The iconic clubmaster design delivers a bold brow line and balanced proportions, while the silver full-rim frame adds a refined metallic touch that enhances its timeless appeal. Built for durability and comfortable all-day wear, these sunglasses provide dependable sun protection along with a confident, stylish look. Perfect for both casual and polished outfits, silver full rim clubmaster sunglasses are an excellent choice for those who appreciate vintage-inspired fashion with a contemporary edge.\r\n', 4320.00, '1'),
(96, 76, 'Wide', 'Black Full Rim Clubmaster Sunglasses bring together timeless retro style and modern sophistication. Featuring the iconic clubmaster silhouette with a bold upper frame, the classic black full-rim design adds a sharp, confident appeal that suits a wide range of face shapes. Crafted for durability and comfortable everyday wear, these sunglasses offer reliable sun protection while maintaining a sleek, versatile look. Ideal for both casual outings and smart styling, black full rim clubmaster sunglasses are a must-have for those who appreciate effortless style with a vintage-inspired edge.\r\n', 4100.00, '1'),
(97, 77, 'Extra Narrow', 'Green Full Rim Clubmaster Sunglasses offer a refreshing twist on a timeless retro design. The signature clubmaster silhouette delivers a bold and structured look, while the green full-rim frame adds a unique, modern touch that stands out with subtle sophistication. Designed for durability and all-day comfort, these sunglasses provide reliable sun protection along with a confident, stylish fit. Perfect for those who like classic shapes with a hint of color, green full rim clubmaster sunglasses effortlessly blend vintage charm with contemporary fashion.\r\n', 2500.00, '1'),
(98, 78, 'Narrow', 'Gold Full Rim Oval Sunglasses exude timeless elegance with a refined, fashion-forward appeal. The smooth oval shape offers a soft, balanced look that flatters a variety of face shapes, while the gold full-rim frame adds a touch of luxury and sophistication. Crafted for durability and comfortable all-day wear, these sunglasses provide dependable sun protection along with a lightweight, polished finish. Perfect for both casual and upscale styling, gold full rim oval sunglasses bring classic charm and modern elegance together effortlessly.\r\n', 4000.00, '1'),
(99, 79, 'Small', 'Full Rim Square eyeglasses for kids are thoughtfully designed to combine comfort, durability, and playful style, making them perfect for everyday wear. Crafted from lightweight yet sturdy materials, these frames provide a secure fit that can handle active school days and outdoor play. The square shape adds a smart, modern look while offering good lens coverage for clear and comfortable vision. With smooth edges, flexible hinges, and kid-friendly sizing, these eyeglasses ensure all-day comfort without pinching or slipping. Available in fun and vibrant colors, full rim square eyeglasses help kids express their personality while giving parents confidence in long-lasting quality and eye protection.\r\n', 750.00, '1'),
(100, 80, 'Small', 'A sky blue full-rim rectangle eyeglass for kids combines playful style with everyday practicality. The vibrant sky blue frame adds a cheerful pop of color that kids will love, while the full-rim design offers sturdy protection for active little ones. Its classic rectangle shape provides a modern and versatile look that flatters most face shapes, making it perfect for school, play, and family outings. Made from lightweight and durable materials, these glasses ensure comfort and long-lasting wear, with secure temples that stay in place during all kinds of fun activities. Ideal for young wearers who want both function and style, these sky blue rectangle eyeglasses make seeing clearly feel cool.\r\n', 950.00, '1'),
(101, 81, 'Small', 'A navy blue full-rim square eyeglass for kids blends timeless style with dependable durability to suit everyday wear. The deep navy blue frame adds a cool and sophisticated touch that’s still fun for young personalities, while the full-rim design offers strong protection around the lenses—perfect for active school days and outdoor play. Its classic square shape provides a bold, modern look that complements a variety of face shapes and adds a smart, confident flair to any outfit. Made from lightweight yet sturdy materials, these glasses ensure all-day comfort and long-lasting wear, with temples designed to stay secure through every adventure. Comfortable, stylish, and practical, these navy blue square eyeglasses help kids see clearly while looking great.\r\n', 950.00, '1'),
(102, 82, 'Small', 'A light blue full-rim square eyeglass for kids offers a perfect mix of playful charm and everyday comfort. The soft light blue frame brings a cheerful, youthful vibe that kids will enjoy wearing, while the full-rim design ensures sturdy protection and long-lasting durability for lively school days and active play. Its square shape gives a modern, balanced look that suits many face shapes and adds a smart, stylish touch to any outfit. Made from lightweight and kid-friendly materials, these glasses provide all-day comfort and stay secure through all kinds of adventures. Practical yet fun, these light blue square eyeglasses help children see clearly with confidence and style.\r\n', 750.00, '1'),
(103, 83, 'Small', 'A full-rim square eyeglass for kids is a perfect blend of durability, comfort, and style designed for everyday wear. The full-rim frame provides strong protection around the lenses, making it ideal for active children who are always on the move, whether at school, during playtime, or on family outings. Its classic square shape offers a modern, confident look that complements a variety of face shapes, giving kids a smart and stylish appearance. Made from lightweight, kid-friendly materials, these glasses ensure comfortable all-day wear and a secure fit that stays in place through all kinds of fun and activity. Practical and fashionable, these full-rim square eyeglasses help young wearers see clearly while expressing their personality with ease.\r\n', 780.00, '1'),
(104, 84, 'Small', 'A blue transparent full-rim rectangle eyeglass for kids offers a fun and functional blend of style and comfort perfect for everyday wear. The clear blue transparent frame gives a cool, modern look that lets light shine through with a subtle tint of color, adding a playful yet refined touch that kids will enjoy. Its full-rim design provides sturdy protection around the lenses, making the glasses durable and reliable for school, playtime, and all kinds of activities. The classic rectangle shape flatters many face shapes and gives a smart, polished appearance while still feeling youthful. Crafted from lightweight, kid-friendly materials, these glasses are comfortable for all-day wear and stay secure through active moments. Bright, practical, and stylish, these blue transparent rectangle eyeglasses help children see clearly with confidence and personality.\r\n', 1000.00, '1'),
(105, 85, 'Small', 'A purple transparent full-rim rectangle eyeglass for kids combines playful color with everyday practicality to create a stylish and comfortable eyewear option. The translucent purple frame brings a fun and vibrant look that lets light gently shine through, giving the glasses a cheerful and youthful appeal that kids will love. The full-rim design adds sturdy protection around the lenses, making them durable and dependable for school, play, and active adventures. With its classic rectangle shape, these glasses flatter a variety of face shapes while offering a modern, clean silhouette. Made from lightweight, kid-friendly materials, they provide comfortable all-day wear and a secure fit that stays put through all kinds of activities. Bright, fun, and functional, these purple transparent rectangle eyeglasses help children see clearly while expressing their personality with confidence.\r\n', 500.00, '1'),
(106, 86, 'Small', 'A black full-rim rectangle eyeglass for kids is a timeless and versatile eyewear choice that blends classic style with everyday practicality. The sleek black frame gives a bold yet polished look that pairs easily with any outfit, making it suitable for school, casual outings, and special occasions alike. Its full-rim design offers strong protection around the lenses, enhancing durability and ensuring the glasses stay sturdy during all kinds of active play. The rectangle shape provides a balanced, modern appearance that flatters many face shapes and adds a smart, confident touch to a child’s look. Crafted from lightweight, kid-friendly materials, these glasses are comfortable for all-day wear and secure enough to handle energetic movements. Functional, stylish, and durable, these black full-rim rectangle eyeglasses help children see clearly while expressing a cool, confident personality.\r\n', 750.00, '1'),
(107, 87, 'Small', 'A blue transparent full-rim rectangle eyeglass for kids offers a fun and functional blend of style and comfort perfect for everyday wear. The clear blue transparent frame gives a cool, modern look that lets light shine through with a subtle tint of color, adding a playful yet refined touch that kids will enjoy. Its full-rim design provides sturdy protection around the lenses, making the glasses durable and reliable for school, playtime, and all kinds of activities. The classic rectangle shape flatters many face shapes and gives a smart, polished appearance while still feeling youthful. Crafted from lightweight, kid-friendly materials, these glasses are comfortable for all-day wear and stay secure through active moments. Bright, practical, and stylish, these blue transparent rectangle eyeglasses help children see clearly with confidence and personality.\r\n', 500.00, '1'),
(108, 88, 'Small', 'A ocean blue full-rim rectangle eyeglass for kids is a stylish and practical eyewear choice that brings both function and fun to everyday wear. The vibrant ocean blue frame evokes the refreshing hues of the sea, adding a lively pop of color that kids will enjoy wearing with any outfit. Its full-rim design offers sturdy protection around the lenses, making the glasses durable and reliable for school, playtime, and all kinds of activities. The classic rectangle shape provides a modern and balanced look that flatters many face shapes while giving a smart, confident appearance. Made from lightweight, kid-friendly materials, these eyeglasses are comfortable for all-day wear and stay securely in place during active moments. Bright, cheerful, and dependable, these ocean blue full-rim rectangle eyeglasses help children see clearly with confidence and style.\r\n', 950.00, '1'),
(109, 89, 'Small', 'A light gray full-rim rectangle eyeglass for kids is a sleek and versatile eyewear option that combines subtle style with dependable everyday performance. The gentle light gray frame offers a soft, neutral tone that pairs easily with any outfit, making it a great choice for school, casual wear, and special occasions alike. Its full-rim design provides strong protection around the lenses, ensuring durability and resilience for active days filled with play and learning. The classic rectangle shape gives a modern, balanced look that complements a variety of face shapes, adding a smart and confident touch to a child’s appearance. Made from lightweight, kid-friendly materials, these glasses are comfortable for all-day wear and stay securely in place through energetic moments. Practical, stylish, and comfortable, these light gray full-rim rectangle eyeglasses help children see clearly while looking effortlessly cool.\r\n', 750.00, '1'),
(110, 90, 'Small', 'A blue-black-grey full-rim rectangle eyeglass for kids is a stylish and versatile eyewear choice that combines bold colors with everyday functionality. The mix of deep blue, sleek black, and cool grey tones gives the frame a dynamic, modern look that kids will love, while still remaining easy to pair with any outfit. The full-rim design offers strong protection around the lenses, making these glasses durable and dependable for school, play, and all kinds of adventures. Its classic rectangle shape provides a balanced, contemporary appearance that flatters many face shapes and adds a smart, confident touch to a child’s look. Crafted from lightweight, kid-friendly materials, these eyeglasses ensure comfortable all-day wear and stay secure even during active moments. Bright, bold, and practical, these blue-black-grey full-rim rectangle eyeglasses help children see clearly while expressing personality and style.\r\n', 1000.00, '1'),
(111, 91, 'Small', 'A full-rim rectangle eyeglass for kids is a classic and reliable eyewear choice that perfectly balances style, comfort, and everyday practicality. The full-rim frame surrounds the lenses completely, giving extra protection and durability—ideal for active children who are always on the go, whether at school, during play, or on family outings. Its timeless rectangle shape provides a clean, modern look that flatters a variety of face shapes and adds a smart, confident touch to a child’s appearance. Crafted from lightweight, kid-friendly materials, these glasses ensure comfortable all-day wear and stay secure through all kinds of fun activities. With a design that’s both functional and fashionable, these full-rim rectangle eyeglasses help young wearers see clearly while expressing their personality with ease.\r\n', 799.00, '1'),
(112, 92, 'Small', 'A full rim round eyeglass for kids is a fun and functional eyewear option that combines playful design with everyday durability. The complete full-rim frame surrounds the lenses, offering strong protection and making it perfect for busy, active children who need glasses that can keep up with school, play, and adventures. The classic round shape gives a charming and youthful look that flatters many face shapes and adds a cheerful, stylish touch to a child’s appearance. Crafted from lightweight, kid-friendly materials, these glasses are comfortable for all-day wear and fit securely through all kinds of energetic activities. Practical yet fashionable, these full-rim round eyeglasses help young wearers see clearly while expressing personality with confidence and ease.\r\n', 950.00, '1'),
(113, 93, 'Small', 'A gray transparent full rim round eyeglass for kids is a stylish and practical eyewear choice that blends subtle design with everyday comfort. The gray transparent frame offers a light, modern look that lets soft hues and natural light shine through, giving the glasses a fresh and playful appeal that’s perfect for young wearers. Its full-rim construction surrounds the lenses completely, providing sturdy protection and durability—ideal for school days, playtime, and all kinds of active adventures. The round shape adds a cheerful, classic charm that flatters many face shapes while giving a fun and trendy touch to a child’s appearance.', 450.00, '1'),
(114, 94, 'Small', 'A sky blue full-rim round eyeglass for kids is a delightful blend of playful charm and practical design that’s perfect for everyday wear. The cheerful sky blue frame brings a bright, uplifting splash of color that kids will love, making these glasses fun to wear for school, outings, and playtime alike. The full-rim construction surrounds the lenses completely, providing sturdy protection and durability for active young lifestyles. Its round shape adds a classic, friendly look that flatters many face shapes and gives a joyful, stylish touch to a child’s appearance. Made from lightweight, kid-friendly materials, these eyeglasses ensure comfortable all-day wear and a secure fit during all kinds of activities. With a combination of vibrant color, timeless shape, and dependable comfort, these sky blue full-rim round eyeglasses help children see clearly while expressing their personality with confidence and flair.\r\n', 1000.00, '1'),
(115, 95, 'Small', 'A navy blue full-rim round eyeglass for kids is a stylish and versatile eyewear option that beautifully balances classic charm with everyday strength. The deep navy blue frame adds a cool, confident pop of color that’s both timeless and fun for young wearers, making these glasses perfect for school, play, and casual outings. The full-rim design fully encircles the lenses, offering sturdy protection and added durability to stand up to active kids’ adventures. With its round shape, the eyeglass frames create a friendly and charming look that flatters a variety of face shapes and brings a cheerful, expressive touch to a child’s style. Crafted from lightweight, kid-friendly materials, these glasses ensure comfortable all-day wear and stay securely in place during energetic activities. Practical, fashionable, and comfortable, these navy blue full-rim round eyeglasses help children see clearly with confidence and personality.\r\n', 800.00, '1'),
(116, 96, 'Small', 'A lavender full-rim round eyeglass for kids is a charming and delightful eyewear option that perfectly blends playful color with practical design. The soft lavender frame brings a gentle, cheerful hue that kids will love, adding a fun and stylish touch to everyday wear—whether at school, during playtime, or out with family. Its full-rim construction surrounds the lenses completely, offering sturdy protection and durability for little adventurers who stay active throughout the day. The classic round shape gives the glasses a friendly, whimsical look that flatters many face shapes and adds personality to a child’s appearance.', 750.00, '1'),
(117, 97, 'Small', 'A matte gunmetal purple full-rim cat-eye eyeglass for kids is a chic and playful eyewear choice that perfectly blends bold style with everyday comfort. The unique **matte gunmetal purple** finish gives the frame a cool, modern look with a subtle shimmer of purple that’s both trendy and kid-friendly, making these glasses stand out in a fun yet sophisticated way. The full-rim design provides strong protection around the lenses, ensuring durability for school days, playtime, and all kinds of adventures. Its stylish **cat-eye shape** adds a fashionable, expressive flair that flatters many face shapes and brings a confident, spirited touch to a child’s appearance. Made from lightweight, kid-safe materials, these eyeglasses are comfortable for all-day wear and stay secure during active moments. With a perfect mix of trendy design, durable construction, and comfortable fit, these matte gunmetal purple cat-eye eyeglasses help kids see clearly while expressing their unique personality with flair.\r\n', 1400.00, '1'),
(118, 98, 'Small', 'A lavender full-rim cat-eye eyeglass for kids is a delightful and stylish eyewear option that beautifully combines playful charm with everyday durability. The soft lavender hue gives the frame a fun, cheerful color that kids will love, adding a whimsical touch to both school outfits and casual wear. Its full-rim design ensures sturdy protection around the lenses, making these glasses resilient enough to handle active play and daily adventures. The cat-eye shape adds a trendy, expressive flair that flatters many face shapes and brings a confident, fashion-forward look to a child’s appearance. Made from lightweight, kid-friendly materials, these eyeglasses are comfortable for all-day wear and stay secure through energetic activities. Vibrant, comfortable, and full of personality, these lavender full-rim cat-eye eyeglasses help children see clearly while expressing their unique style with charm and confidence.\r\n', 750.00, '1'),
(119, 99, 'Small', 'A full-rim cat-eye eyeglass for kids is a fun and fashionable eyewear choice that blends timeless design with everyday durability. The full-rim frame fully encircles the lenses, offering sturdy protection and making these glasses resilient enough for school, play, and all kinds of active adventures. Its classic cat-eye shape adds a playful, stylish flair that’s both trendy and flattering on many young face shapes, giving kids a confident and expressive look. Made from lightweight, kid-friendly materials, these eyeglasses are comfortable for all-day wear and stay secure during energetic moments. Perfectly combining practical strength with charming design, these full-rim cat-eye eyeglasses help children see clearly while showcasing their unique personality with confidence and style.\r\n', 750.00, '1'),
(120, 100, 'Small', 'A sky blue full-rim cat-eye eyeglass for kids is a charming blend of playful color and stylish design, perfect for young trendsetters. The bright sky blue frame brings a cheerful and lively pop of color that kids will enjoy wearing every day, whether at school, family outings, or playtime with friends. Its full-rim construction provides sturdy protection around the lenses, making the glasses durable and dependable for active little ones. The cat-eye shape adds a fun and fashionable flair that flatters many face shapes and gives a confident, expressive touch to a child’s look. Made from lightweight, kid-friendly materials, these eyeglasses are comfortable for all-day wear and stay secure through energetic activities.', 750.00, '1'),
(121, 101, 'Small', 'A pink transparent full-rim cat-eye eyeglass for kids is a delightful and stylish eyewear choice that beautifully merges playful color with practical design. The translucent pink frame gives a soft, shimmering pop of color that lets light shine through, creating a fun and cheerful look kids will be excited to wear every day. Its full-rim construction surrounds the lenses completely, offering sturdy protection and durability—perfect for school, playtime, and all kinds of active days. The trendy cat-eye shape adds a touch of flair and personality that flatters young face shapes and brings a confident, expressive twist to a child’s appearance.', 1400.00, '1'),
(122, 102, 'Small', 'A full-rim geometric eyeglass for kids is a fun and modern eyewear choice that blends youthful style with everyday strength. The full-rim frame fully surrounds the lenses, offering durable protection ideal for active kids who wear glasses at school, during play, and on family outings. Its unique geometric shape—featuring trendy angles and clean lines—gives the glasses a contemporary, eye-catching look that flatters a variety of face shapes and adds personality to a child’s style. Made from lightweight, kid-friendly materials, these eyeglasses provide comfortable all-day wear and stay secure through energetic activities. Stylish yet practical, these full-rim geometric eyeglasses help children see clearly while expressing their individuality with confidence and flair.\r\n', 850.00, '1'),
(123, 103, 'Small', 'A green full-rim oval eyeglass for kids is a fresh and cheerful eyewear choice that beautifully combines vibrant color with comfortable, everyday wearability. The lively green frame brings a playful pop of color that kids will enjoy wearing to school, outings, and playtime, while the full-rim design surrounds the lenses completely, offering sturdy protection and long-lasting durability. Its classic oval shape provides a soft, balanced look that flatters many face shapes and gives a friendly, stylish touch to a child’s appearance. Crafted from lightweight, kid-friendly materials, these glasses ensure comfortable all-day wear and stay secure during all kinds of active moments.', 550.00, '1'),
(124, 104, 'Small', 'A full-rim square sunglass for kids is a fun and practical eyewear choice that combines cool style with reliable protection. The full-rim frame fully surrounds the lenses, offering durability and sturdiness that stands up to active play, outdoor adventures, and everyday wear. Its classic square shape gives a bold, modern look that flatters many face shapes and adds a confident, stylish touch to a child’s appearance. Designed with kids in mind, these sunglasses provide excellent coverage from the sun while staying comfortable for all-day wear. Made from lightweight, kid-friendly materials, they stay securely in place through running, jumping, and travel.', 600.00, '1'),
(125, 105, 'Small', 'Super Squad Square (Superhero Edition) sunglasses for kids are designed to bring together bold style, fun character detailing, and reliable sun protection for little heroes on the go. Featuring a sturdy full-rim square frame, these sunglasses offer a cool, confident look inspired by superhero vibes, making them an instant favorite for kids. The comfortable, lightweight build ensures a secure fit for active play, outdoor adventures, and everyday wear, while the wide lenses provide excellent coverage against bright sunlight. With eye-catching superhero accents and a durable design made for young explorers, these sunglasses add excitement to any outfit while helping protect young eyes in style.\r\n', 1000.00, '1'),
(126, 106, 'Small', 'A blue transparent full-rim square sunglass for kids is a stylish and functional eyewear option that’s perfect for sunny days and outdoor fun. The transparent blue frame gives a cool, modern look with a subtle tint that lets light shine through while adding a playful splash of color kids will love. Its full-rim construction surrounds the lenses completely, offering sturdy protection and long-lasting durability—ideal for active youngsters who love to explore, play, and stay on the move. The classic square shape provides a bold yet balanced appearance that flatters many face shapes and adds a confident, trendy touch to a child’s style. Designed with comfort in mind, these sunglasses are made from lightweight, kid-friendly materials that stay secure through all kinds of adventures.', 1000.00, '1'),
(127, 107, 'Small', 'A crystal transparent full-rim square sunglass for kids is a chic and modern eyewear choice that combines sleek design with everyday practicality. The crystal transparent frame offers a clear, light-catching look that feels fresh, fun, and versatile—perfect for pairing with any outfit while letting a hint of color shine through. Its full-rim construction fully surrounds the lenses, providing sturdy protection and durability that can keep up with playful kids during outdoor adventures, beach days, and bright sunny afternoons. The classic square shape gives a bold yet balanced appearance that flatters many face shapes and adds a cool, confident touch to a child’s style. Made with comfortable, kid-friendly materials, these sunglasses are lightweight and secure, ideal for all-day wear.', 950.00, '1'),
(128, 108, 'Small', 'A basic full-rim square sunglass for kids is a simple yet stylish eyewear essential designed for everyday comfort and reliable sun protection. The classic square shape offers a clean, modern look that suits a variety of face shapes, making it easy for kids to wear with any outfit. Its full-rim frame provides sturdy support and durability, ideal for active days at the park, school outings, or family trips. Made from lightweight, kid-friendly materials, these sunglasses ensure a comfortable fit and stay secure during play. With effective UV-protective lenses and a timeless design, these basic full-rim square sunglasses are a practical and stylish choice for keeping young eyes protected in bright sunlight.\r\n', 1000.00, '1'),
(129, 109, 'Small', 'A full-rim rectangle sunglass for kids is a perfect blend of classic style, comfort, and dependable sun protection. The rectangular frame offers a clean, modern look that suits a variety of face shapes, giving kids a cool and confident appearance for everyday wear. Its full-rim construction provides added strength and durability, making these sunglasses ideal for active play, outdoor adventures, and family outings. Designed with lightweight, kid-friendly materials, they ensure a comfortable fit that stays secure throughout the day. With effective UV-protective lenses and a timeless silhouette, these full-rim rectangle sunglasses help keep young eyes safe while adding a stylish touch to any outfit.\r\n', 600.00, '1'),
(130, 110, 'Small', 'A black full-rim rectangle sunglass for kids is a timeless and versatile eyewear choice that combines cool style with reliable sun protection. The classic black frame gives a smart, confident look that pairs easily with any outfit, making it perfect for school trips, outdoor play, and family outings. Its full-rim construction adds extra durability and strength, ensuring the sunglasses can handle active movement and everyday wear. The rectangle shape offers a clean, modern silhouette that suits many face shapes while providing good coverage from bright sunlight. Made from lightweight, kid-friendly materials and equipped with UV-protective lenses, these sunglasses deliver all-day comfort and dependable eye protection, helping kids enjoy sunny days in style.\r\n', 1000.00, '1'),
(131, 111, 'Small', 'A sky blue full-rim rectangle sunglass for kids is a fun and stylish eyewear choice designed to keep young eyes protected while adding a cheerful pop of color. The bright sky blue frame brings a fresh, playful look that kids will love wearing for outdoor activities, holidays, and everyday fun. Its full-rim construction offers sturdy support and durability, making the sunglasses reliable for active play and on-the-go adventures. The classic rectangle shape provides a modern, balanced appearance that suits many face shapes and offers good coverage from sunlight. Made from lightweight, kid-friendly materials and fitted with UV-protective lenses, these sunglasses ensure comfortable all-day wear while helping keep children’s eyes safe in bright conditions.\r\n', 1000.00, '1'),
(132, 112, 'Small', 'A red full-rim rectangle sunglass for kids is a bold and energetic eyewear choice that adds fun and flair to sunny-day adventures. The vibrant red frame brings a lively pop of color that kids love, making these sunglasses stand out while still being easy to pair with casual outfits. Its full-rim construction provides sturdy support and durability, ideal for active play, outdoor trips, and everyday wear. The classic rectangle shape offers a modern, balanced look and good coverage to protect young eyes from bright sunlight. Crafted from lightweight, kid-friendly materials and fitted with UV-protective lenses, these sunglasses ensure comfortable all-day wear while helping keep children’s eyes safe in style.\r\n', 1000.00, '1'),
(133, 113, 'Small', 'It is a cheerful and stylish eyewear choice designed to keep young eyes protected while adding a fun pop of color. The bright sky blue frame brings a fresh, playful look that kids will enjoy wearing during outdoor activities, vacations, and everyday fun. Its full-rim construction offers extra strength and durability, making the sunglasses reliable for active play and on-the-go adventures. The classic rectangle shape provides a clean, modern appearance and offers good coverage against sunlight. Made from lightweight, kid-friendly materials and equipped with UV-protective lenses, these sunglasses ensure comfortable all-day wear while helping keep children’s eyes safe in bright conditions.\r\n', 1000.00, '1'),
(134, 114, 'Small', 'A pink transparent full-rim round sunglass for kids is a fun and stylish accessory that adds a playful charm to sunny-day outings. The translucent pink frame gives a soft, glossy look that lets light pass through, creating a cheerful and trendy appearance kids will love. Its full-rim design offers sturdy support and durability, making these sunglasses perfect for active play, outdoor adventures, and everyday wear. The classic round shape provides a cute, friendly silhouette that suits many face shapes while offering good coverage from bright sunlight. Crafted from lightweight, kid-friendly materials and fitted with UV-protective lenses, these sunglasses ensure comfortable all-day wear while helping keep young eyes safe in style.\r\n', 600.00, '1'),
(135, 115, 'Small', 'A full rim round sunglass for kids is a fun and stylish eyewear essential designed to keep young eyes protected during sunny days. The classic round frame gives a cute, playful look that suits many face shapes and adds a cheerful touch to a child’s outfit. Its full-rim construction provides sturdy support and durability, making these sunglasses reliable for active play, outdoor adventures, and everyday use. Made from lightweight, kid-friendly materials, they ensure a comfortable fit that stays secure throughout the day. Equipped with UV-protective lenses and a timeless design, these full-rim round sunglasses help children enjoy bright sunlight safely while looking cool and confident.\r\n', 1000.00, '1'),
(136, 116, 'Small', 'A rose transparent full-rim round sunglass for kids is a charming and stylish accessory that brings a soft, playful vibe to sunny-day wear. The translucent rose frame adds a gentle pop of color with a glossy, light-catching finish that kids will love, making these sunglasses fun and fashionable at the same time. Its full-rim design offers sturdy support and durability, ideal for active play, outdoor outings, and everyday adventures. The classic round shape creates a cute, friendly look that flatters many face shapes while providing good coverage from bright sunlight. Crafted from lightweight, kid-friendly materials and fitted with UV-protective lenses, these sunglasses ensure comfortable all-day wear while helping keep young eyes safe in sweet, stylish flair.\r\n', 880.00, '1'),
(137, 117, 'Small', 'A sky blue full-rim round sunglass for kids is a cheerful and stylish eyewear choice made for sunny-day fun and everyday adventures. The bright sky blue frame adds a fresh, playful pop of color that kids will love wearing to the park, on vacations, or during outdoor play. Its full-rim construction provides sturdy support and durability, making the sunglasses reliable for active little ones. The classic round shape gives a cute, friendly look that suits many face shapes while offering good coverage from sunlight. Made from lightweight, kid-friendly materials and fitted with UV-protective lenses, these sunglasses ensure comfortable all-day wear while helping keep young eyes safe in bright conditions.\r\n', 750.00, '1'),
(138, 118, 'Small', 'A printed full-rim round sunglass for kids is a playful blend of comfort, protection, and standout style designed for bright, sunny days. The colorful printed frame adds a fun, creative touch that reflects a child’s cheerful personality, making these sunglasses a favorite for outdoor games, beach days, and family outings. Its full-rim build provides reliable strength and durability, ideal for energetic movement and everyday use. The rounded silhouette gives a soft, friendly look that suits many face shapes while offering ample coverage from sunlight. Crafted from lightweight, kid-friendly materials and fitted with UV-protective lenses, these sunglasses ensure a secure, comfortable fit and dependable eye protection, letting kids enjoy the sun with confidence and flair.\r\n', 1000.00, '1'),
(139, 119, 'Small', 'A full rim cat eye sunglass is a bold and stylish eyewear choice that brings a touch of glamour to everyday sun protection. Designed with a distinctive upswept silhouette, the cat-eye shape adds a fashionable, confident edge while enhancing facial features beautifully. The full-rim frame offers a solid, well-balanced structure that ensures durability and reliable lens support for regular wear. Perfect for casual outings, vacations, or sunny days out, these sunglasses provide comfortable coverage while making a strong style statement. Crafted from lightweight, high-quality materials and fitted with sun-protective lenses, full-rim cat-eye sunglasses combine eye safety with standout style for a chic, modern look.\r\n', 780.00, '1'),
(140, 120, 'Small', 'A black full-rim cat-eye sunglass is a timeless style statement that blends bold fashion with everyday functionality. The sleek black frame adds a touch of elegance and confidence, making these sunglasses easy to pair with both casual and dressy outfits. Featuring a signature cat-eye silhouette with gently lifted corners, they create a flattering, expressive look that enhances facial features. The full-rim design provides a strong, well-structured build, ensuring durability and a secure lens fit for regular wear. Crafted from lightweight, comfortable materials and equipped with sun-protective lenses, these black cat-eye sunglasses offer dependable eye protection while delivering a classic, fashion-forward appeal.\r\n', 880.00, '1'),
(141, 121, 'Small', 'A multi-color full-rim cat-eye sunglass is a vibrant and fashion-forward accessory designed to make any look stand out. Featuring a blend of lively hues across the frame, these sunglasses bring a playful yet stylish twist to the classic cat-eye silhouette. The upswept shape adds a bold, expressive charm that highlights facial features, while the full-rim construction ensures a sturdy, well-balanced feel for everyday wear. Perfect for vacations, casual outings, or sunny days when you want to add personality to your outfit, these sunglasses combine eye-catching design with comfortable coverage. Made from lightweight materials and fitted with sun-protective lenses, multi-color cat-eye sunglasses offer reliable eye protection while letting your style shine with confidence and flair.\r\n', 790.00, '1'),
(142, 122, 'Small', 'A black full-rim cat-eye sunglass delivers a striking mix of classic elegance and modern attitude. The deep black frame creates a bold, polished look that instantly elevates any outfit, from everyday casual wear to more dressed-up styles. Designed with the iconic cat-eye shape, the gently flared corners add a touch of drama and confidence while enhancing facial features beautifully. The full-rim structure provides a solid, durable build that supports the lenses securely and feels comfortable for regular use. Crafted from lightweight materials and paired with sun-protective lenses, these sunglasses offer dependable eye protection while making a powerful, fashion-forward statement.\r\n', 700.00, '1'),
(143, 123, 'Small', 'A full-rim geometric sunglass for kids is a fun and modern eyewear choice that adds a cool, playful edge to sunny-day looks. Designed with unique angular lines and a bold geometric shape, these sunglasses give kids a trendy style that stands out while still being age-appropriate. The full-rim frame offers strong support and durability, making it ideal for active play, outdoor adventures, and everyday wear. Lightweight, kid-friendly materials ensure a comfortable and secure fit throughout the day, while the lenses provide reliable protection from bright sunlight. With a mix of creative design, comfort, and practicality, these full-rim geometric sunglasses let kids enjoy the outdoors with confidence and style.\r\n', 650.00, '1'),
(144, 124, 'Small', 'A blue full-rim geometric sunglass for kids brings a cool splash of color together with a modern, playful design perfect for sunny adventures. The bold blue frame adds an energetic and cheerful vibe, while the geometric shape with clean angles gives the sunglasses a trendy, standout look that kids will love wearing. Built with a full-rim construction, the frame offers added strength and durability to handle active play and outdoor fun. Made from lightweight, kid-friendly materials, these sunglasses provide a comfortable, secure fit for all-day wear. With protective lenses that help shield young eyes from bright sunlight, these blue geometric sunglasses combine eye safety with fresh, confident style.\r\n', 770.00, '1');
INSERT INTO `product_variation_tbl` (`pvariation_id`, `product_id`, `size`, `description`, `price`, `v_status`) VALUES
(145, 125, 'Wide', 'A full-rim geometric sunglass for kids is a bold and playful eyewear option designed to add a modern edge to sunny-day style. Featuring a distinctive geometric frame with sharp lines and unique angles, these sunglasses help kids stand out while still feeling comfortable and confident. The full-rim construction provides a strong, durable structure that can handle active play, outdoor fun, and everyday adventures. Crafted from lightweight, kid-friendly materials, they offer a secure and comfortable fit throughout the day. With lenses designed to protect young eyes from bright sunlight and a design that encourages self-expression, these full-rim geometric sunglasses combine creativity, comfort, and practicality in one stylish accessory.\r\n', 880.00, '1'),
(147, 127, 'Small', 'xcvbnm,sdfghjkltyuikol', 4567.00, '1'),
(148, 128, 'Small', 'A blue zero-power screen glass for kids is a lightweight, stylish eyewear designed specifically for children who spend time on digital devices. Unlike prescription glasses, these have zero optical power—meaning they don’t correct vision—but they feature a special blue-light filtering coating that helps reduce the amount of high-energy visible (HEV) blue light emitted from screens. For kids who use tablets, phones, computers, or watch videos for homework or play, these glasses can help reduce eye strain, dryness, and fatigue while encouraging better focus. Typically made with durable, kid-friendly frames and shatter-resistant lenses, they’re comfortable to wear throughout the day and come in fun colors and shapes to appeal to younger wearers', 500.00, '1'),
(149, 129, 'large', 'A black full-rim clip-on is a versatile eyewear accessory designed to combine style and convenience. It features a solid black, full-rim frame that fully encircles the lenses for a bold, classic look and added durability. The defining feature is the clip-on mechanism, which allows you to easily attach or detach tinted or protective lenses over your regular prescription glasses. This makes it ideal for people who want sun protection, glare reduction, or enhanced outdoor vision without switching between multiple pairs of eyewear. The clip-on fits securely and comfortably, offering both practicality and a sleek appearance.', 2700.00, '1'),
(150, 130, 'Medium', 'A black-brown full-rim square clip-on is a stylish and practical eyewear accessory that blends classic design with everyday functionality. The frame features a full-rim construction in a refined black and brown color combination, giving it a versatile, timeless look that complements many face shapes and outfits. Its square shape adds a modern edge and provides balanced coverage, making it suitable for both casual and professional settings. The clip-on component allows you to easily attach tinted or protective lenses over your regular prescription glasses, instantly transforming them into sunglasses or glare-reducing eyewear without needing a second pair', 2500.00, '1');

-- --------------------------------------------------------

--
-- Table structure for table `review_tbl`
--

DROP TABLE IF EXISTS `review_tbl`;
CREATE TABLE IF NOT EXISTS `review_tbl` (
  `review_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `rating` int DEFAULT NULL,
  `review_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`review_id`),
  UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=193 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `review_tbl`
--

INSERT INTO `review_tbl` (`review_id`, `user_id`, `product_id`, `rating`, `review_text`, `created_at`) VALUES
(1, 6, 41, 3, 'Very good quality', '2026-02-19 08:59:37'),
(2, 7, 42, 2, 'Nice design', '2026-02-19 08:59:37'),
(3, 8, 43, 1, 'Worth the money', '2026-02-19 08:59:37'),
(4, 9, 44, 4, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(5, 10, 45, 2, 'Amazing experience', '2026-02-19 08:59:37'),
(6, 6, 46, 1, 'Highly recommended', '2026-02-19 08:59:37'),
(7, 7, 47, 4, 'Premium quality', '2026-02-19 08:59:37'),
(8, 8, 48, 4, 'Loved this product', '2026-02-19 08:59:37'),
(9, 9, 49, 4, 'Good overall experience', '2026-02-19 08:59:37'),
(10, 10, 50, 3, 'Excellent product', '2026-02-19 08:59:37'),
(11, 6, 51, 5, 'Very good quality', '2026-02-19 08:59:37'),
(12, 7, 52, 5, 'Nice design', '2026-02-19 08:59:37'),
(13, 8, 53, 3, 'Worth the money', '2026-02-19 08:59:37'),
(14, 9, 54, 4, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(15, 7, 57, 5, 'Premium quality', '2026-02-19 08:59:37'),
(16, 8, 58, 2, 'Loved this product', '2026-02-19 08:59:37'),
(17, 9, 59, 1, 'Good overall experience', '2026-02-19 08:59:37'),
(18, 10, 60, 1, 'Excellent product', '2026-02-19 08:59:37'),
(19, 6, 61, 5, 'Very good quality', '2026-02-19 08:59:37'),
(20, 7, 62, 5, 'Nice design', '2026-02-19 08:59:37'),
(21, 8, 63, 4, 'Worth the money', '2026-02-19 08:59:37'),
(22, 9, 64, 4, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(23, 10, 65, 5, 'Amazing experience', '2026-02-19 08:59:37'),
(24, 6, 66, 5, 'Highly recommended', '2026-02-19 08:59:37'),
(25, 7, 67, 2, 'Premium quality', '2026-02-19 08:59:37'),
(26, 8, 68, 4, 'Loved this product', '2026-02-19 08:59:37'),
(27, 9, 69, 2, 'Good overall experience', '2026-02-19 08:59:37'),
(28, 10, 70, 4, 'Excellent product', '2026-02-19 08:59:37'),
(29, 6, 71, 4, 'Very good quality', '2026-02-19 08:59:37'),
(30, 7, 72, 2, 'Nice design', '2026-02-19 08:59:37'),
(31, 8, 73, 1, 'Worth the money', '2026-02-19 08:59:37'),
(32, 9, 74, 5, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(33, 10, 75, 2, 'Amazing experience', '2026-02-19 08:59:37'),
(34, 6, 76, 2, 'Highly recommended', '2026-02-19 08:59:37'),
(35, 7, 77, 4, 'Premium quality', '2026-02-19 08:59:37'),
(36, 8, 78, 3, 'Loved this product', '2026-02-19 08:59:37'),
(37, 9, 104, 1, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(38, 10, 105, 3, 'Amazing experience', '2026-02-19 08:59:37'),
(39, 6, 106, 3, 'Highly recommended', '2026-02-19 08:59:37'),
(40, 7, 107, 2, 'Premium quality', '2026-02-19 08:59:37'),
(41, 8, 108, 3, 'Loved this product', '2026-02-19 08:59:37'),
(42, 9, 109, 2, 'Good overall experience', '2026-02-19 08:59:37'),
(43, 10, 110, 2, 'Excellent product', '2026-02-19 08:59:37'),
(44, 6, 111, 5, 'Very good quality', '2026-02-19 08:59:37'),
(45, 7, 112, 2, 'Nice design', '2026-02-19 08:59:37'),
(46, 8, 113, 3, 'Worth the money', '2026-02-19 08:59:37'),
(47, 9, 114, 1, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(48, 10, 115, 1, 'Amazing experience', '2026-02-19 08:59:37'),
(49, 6, 116, 5, 'Highly recommended', '2026-02-19 08:59:37'),
(50, 7, 117, 2, 'Premium quality', '2026-02-19 08:59:37'),
(51, 8, 118, 1, 'Loved this product', '2026-02-19 08:59:37'),
(52, 9, 119, 4, 'Good overall experience', '2026-02-19 08:59:37'),
(53, 10, 120, 5, 'Excellent product', '2026-02-19 08:59:37'),
(54, 6, 121, 4, 'Very good quality', '2026-02-19 08:59:37'),
(55, 7, 122, 5, 'Nice design', '2026-02-19 08:59:37'),
(56, 8, 123, 4, 'Worth the money', '2026-02-19 08:59:37'),
(57, 9, 124, 1, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(58, 10, 125, 4, 'Amazing experience', '2026-02-19 08:59:37'),
(59, 6, 1, 1, 'Very good quality', '2026-02-19 08:59:37'),
(60, 7, 2, 2, 'Nice design', '2026-02-19 08:59:37'),
(61, 8, 3, 2, 'Worth the money', '2026-02-19 08:59:37'),
(62, 9, 4, 2, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(63, 10, 5, 1, 'Amazing experience', '2026-02-19 08:59:37'),
(64, 6, 6, 4, 'Highly recommended', '2026-02-19 08:59:37'),
(65, 7, 7, 3, 'Premium quality', '2026-02-19 08:59:37'),
(66, 8, 8, 1, 'Loved this product', '2026-02-19 08:59:37'),
(67, 9, 9, 4, 'Good overall experience', '2026-02-19 08:59:37'),
(68, 10, 10, 1, 'Excellent product', '2026-02-19 08:59:37'),
(69, 6, 11, 4, 'Very good quality', '2026-02-19 08:59:37'),
(70, 7, 12, 5, 'Nice design', '2026-02-19 08:59:37'),
(71, 8, 13, 5, 'Worth the money', '2026-02-19 08:59:37'),
(72, 9, 14, 3, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(73, 10, 15, 2, 'Amazing experience', '2026-02-19 08:59:37'),
(74, 6, 16, 3, 'Highly recommended', '2026-02-19 08:59:37'),
(75, 7, 17, 3, 'Premium quality', '2026-02-19 08:59:37'),
(76, 8, 18, 4, 'Loved this product', '2026-02-19 08:59:37'),
(77, 9, 19, 3, 'Good overall experience', '2026-02-19 08:59:37'),
(78, 10, 20, 3, 'Excellent product', '2026-02-19 08:59:37'),
(79, 6, 21, 1, 'Very good quality', '2026-02-19 08:59:37'),
(80, 7, 22, 5, 'Nice design', '2026-02-19 08:59:37'),
(81, 9, 24, 1, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(82, 10, 25, 3, 'Amazing experience', '2026-02-19 08:59:37'),
(83, 6, 26, 1, 'Highly recommended', '2026-02-19 08:59:37'),
(84, 7, 27, 2, 'Premium quality', '2026-02-19 08:59:37'),
(85, 8, 28, 2, 'Loved this product', '2026-02-19 08:59:37'),
(86, 9, 29, 5, 'Good overall experience', '2026-02-19 08:59:37'),
(87, 10, 30, 5, 'Excellent product', '2026-02-19 08:59:37'),
(88, 6, 31, 2, 'Very good quality', '2026-02-19 08:59:37'),
(89, 8, 33, 4, 'Worth the money', '2026-02-19 08:59:37'),
(90, 9, 34, 4, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(91, 10, 35, 2, 'Amazing experience', '2026-02-19 08:59:37'),
(92, 6, 36, 4, 'Highly recommended', '2026-02-19 08:59:37'),
(93, 7, 37, 3, 'Premium quality', '2026-02-19 08:59:37'),
(94, 8, 38, 3, 'Loved this product', '2026-02-19 08:59:37'),
(95, 9, 39, 2, 'Good overall experience', '2026-02-19 08:59:37'),
(96, 9, 79, 3, 'Good overall experience', '2026-02-19 08:59:37'),
(97, 6, 81, 1, 'Very good quality', '2026-02-19 08:59:37'),
(98, 7, 82, 2, 'Nice design', '2026-02-19 08:59:37'),
(99, 8, 83, 4, 'Worth the money', '2026-02-19 08:59:37'),
(100, 10, 85, 3, 'Amazing experience', '2026-02-19 08:59:37'),
(101, 6, 86, 1, 'Highly recommended', '2026-02-19 08:59:37'),
(102, 7, 87, 2, 'Premium quality', '2026-02-19 08:59:37'),
(103, 8, 88, 2, 'Loved this product', '2026-02-19 08:59:37'),
(104, 9, 89, 2, 'Good overall experience', '2026-02-19 08:59:37'),
(105, 10, 90, 5, 'Excellent product', '2026-02-19 08:59:37'),
(106, 6, 91, 2, 'Very good quality', '2026-02-19 08:59:37'),
(107, 7, 92, 1, 'Nice design', '2026-02-19 08:59:37'),
(108, 8, 93, 2, 'Worth the money', '2026-02-19 08:59:37'),
(109, 9, 94, 1, 'Satisfied with purchase', '2026-02-19 08:59:37'),
(110, 10, 95, 3, 'Amazing experience', '2026-02-19 08:59:37'),
(111, 6, 96, 4, 'Highly recommended', '2026-02-19 08:59:37'),
(112, 7, 97, 1, 'Premium quality', '2026-02-19 08:59:37'),
(113, 8, 98, 2, 'Loved this product', '2026-02-19 08:59:37'),
(114, 9, 99, 2, 'Good overall experience', '2026-02-19 08:59:37'),
(115, 10, 100, 5, 'Excellent product', '2026-02-19 08:59:37'),
(116, 6, 101, 5, 'Very good quality', '2026-02-19 08:59:37'),
(117, 7, 102, 1, 'Nice design', '2026-02-19 08:59:37'),
(118, 8, 103, 5, 'Worth the money', '2026-02-19 08:59:37'),
(119, 8, 23, 4, 'Worth the money', '2026-02-19 08:59:37'),
(128, 8, 42, 4, 'Really impressed with the quality and finish', '2026-02-19 09:05:38'),
(129, 8, 47, 4, 'Exceeded my expectations', '2026-02-19 09:05:38'),
(130, 8, 52, 4, 'Totally worth the price', '2026-02-19 09:05:38'),
(131, 8, 57, 5, 'Good quality product and nice design', '2026-02-19 09:05:38'),
(132, 8, 62, 4, 'Very happy with this purchase', '2026-02-19 09:05:38'),
(133, 8, 67, 4, 'Looks stylish and feels comfortable', '2026-02-19 09:05:38'),
(134, 8, 72, 4, 'Really impressed with the quality and finish', '2026-02-19 09:05:38'),
(135, 8, 77, 4, 'Exceeded my expectations', '2026-02-19 09:05:38'),
(136, 8, 107, 4, 'Exceeded my expectations', '2026-02-19 09:05:38'),
(137, 8, 112, 4, 'Totally worth the price', '2026-02-19 09:05:38'),
(138, 8, 117, 5, 'Good quality product and nice design', '2026-02-19 09:05:38'),
(139, 8, 122, 4, 'Very happy with this purchase', '2026-02-19 09:05:38'),
(140, 8, 2, 4, 'Very happy with this purchase', '2026-02-19 09:05:38'),
(141, 8, 7, 5, 'Looks stylish and feels comfortable', '2026-02-19 09:05:38'),
(142, 8, 12, 4, 'Really impressed with the quality and finish', '2026-02-19 09:05:38'),
(143, 8, 17, 4, 'Exceeded my expectations', '2026-02-19 09:05:38'),
(144, 8, 22, 5, 'Totally worth the price', '2026-02-19 09:05:38'),
(145, 8, 27, 5, 'Good quality product and nice design', '2026-02-19 09:05:38'),
(146, 8, 37, 5, 'Looks stylish and feels comfortable', '2026-02-19 09:05:38'),
(147, 8, 82, 4, 'Totally worth the price', '2026-02-19 09:05:38'),
(148, 8, 87, 5, 'Good quality product and nice design', '2026-02-19 09:05:38'),
(149, 8, 92, 5, 'Very happy with this purchase', '2026-02-19 09:05:38'),
(150, 8, 97, 5, 'Looks stylish and feels comfortable', '2026-02-19 09:05:38'),
(151, 8, 102, 4, 'Really impressed with the quality and finish', '2026-02-19 09:05:38'),
(152, 9, 42, 4, 'Premium build and excellent performance', '2026-02-19 09:05:38'),
(153, 9, 47, 4, 'Highly recommended product', '2026-02-19 09:05:38'),
(154, 9, 52, 5, 'Quality is really good for the price', '2026-02-19 09:05:38'),
(155, 9, 57, 5, 'Very satisfied with the overall experience', '2026-02-19 09:05:38'),
(156, 9, 62, 4, 'Works perfectly and looks great', '2026-02-19 09:05:38'),
(157, 9, 67, 4, 'Loved the design and quality', '2026-02-19 09:05:38'),
(158, 9, 72, 5, 'Premium build and excellent performance', '2026-02-19 09:05:38'),
(159, 9, 77, 5, 'Highly recommended product', '2026-02-19 09:05:38'),
(160, 9, 107, 4, 'Highly recommended product', '2026-02-19 09:05:38'),
(161, 9, 112, 5, 'Quality is really good for the price', '2026-02-19 09:05:38'),
(162, 9, 117, 5, 'Very satisfied with the overall experience', '2026-02-19 09:05:38'),
(163, 9, 122, 4, 'Works perfectly and looks great', '2026-02-19 09:05:38'),
(164, 9, 2, 4, 'Works perfectly and looks great', '2026-02-19 09:05:38'),
(165, 9, 7, 5, 'Loved the design and quality', '2026-02-19 09:05:38'),
(166, 9, 12, 4, 'Premium build and excellent performance', '2026-02-19 09:05:38'),
(167, 9, 17, 4, 'Highly recommended product', '2026-02-19 09:05:38'),
(168, 9, 22, 5, 'Quality is really good for the price', '2026-02-19 09:05:38'),
(169, 9, 27, 4, 'Very satisfied with the overall experience', '2026-02-19 09:05:38'),
(170, 9, 37, 5, 'Loved the design and quality', '2026-02-19 09:05:38'),
(171, 9, 82, 4, 'Quality is really good for the price', '2026-02-19 09:05:38'),
(172, 9, 87, 4, 'Very satisfied with the overall experience', '2026-02-19 09:05:38'),
(173, 9, 92, 4, 'Works perfectly and looks great', '2026-02-19 09:05:38'),
(174, 9, 97, 4, 'Loved the design and quality', '2026-02-19 09:05:38'),
(175, 9, 102, 5, 'Premium build and excellent performance', '2026-02-19 09:05:38'),
(191, 6, 129, 5, 'aaaaaaaaaaaaaaaaaaaaaa', '2026-02-26 05:41:30'),
(192, 11, 120, 3, 'Bohut Achha prodcut hai', '2026-02-26 10:14:52');

-- --------------------------------------------------------

--
-- Table structure for table `shape_tbl`
--

DROP TABLE IF EXISTS `shape_tbl`;
CREATE TABLE IF NOT EXISTS `shape_tbl` (
  `shape_id` int NOT NULL AUTO_INCREMENT,
  `s_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`shape_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shape_tbl`
--

INSERT INTO `shape_tbl` (`shape_id`, `s_name`) VALUES
(1, 'Hexagonal'),
(2, 'Clubmaster'),
(3, 'Round'),
(4, 'Rectangle'),
(5, 'Oval'),
(6, 'Square'),
(7, 'Geometric'),
(8, 'Cateye'),
(9, 'Wide'),
(10, 'Aviator');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

DROP TABLE IF EXISTS `user_tbl`;
CREATE TABLE IF NOT EXISTS `user_tbl` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `u_status` enum('1','0') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `name`, `email`, `phone`, `password`, `u_status`, `created_at`) VALUES
(6, 'tisha shivnani', 'tishashivnani@gmail.com', '9601670225', '$2y$10$/1RxK1R/bdpaRD8C5hGAWu/wsgLB6/h.li3G1UJR15Fa1GzKfvHD2', '1', '2026-02-17 07:41:27'),
(7, 'mahek tamakuwala', 'mahek@gmail.com', '09601670229', '$2y$10$dsogLcAAdMEahEajzrzRhuQj7UywUwatZ3vcOV.knw5uqqOrLBEr2', '1', '2026-02-18 10:10:11'),
(8, 'riya patel', 'Riya@gmail.com', '9601670444', '$2y$10$EHUmsBWEHIF.M2BA7EOld.Mhvyk3fQBgWltJ1m/97e1.K.s18iUEW', '1', '2026-02-19 07:06:51'),
(9, 'krisha tamakuwala', 'k@gmail.com', '9601670446', '$2y$10$9cutdhxucpjoXo1X90IZ2.fl.Ol4MmVanvmheVrV6yRcy0u41M3J.', '1', '2026-02-19 07:12:47'),
(10, 'jiya patel', 'j@gmail.com', '09601670999', '$2y$10$tgUMexX/MV13oOCoTTmOMeaWPnlt0UI1DMJce9W/d.IYj.I1ls0Gm', '1', '2026-02-19 07:14:24'),
(11, 'krisha tamakuwala', 'k10@gmail.com', '', '$2y$10$uTrZwRt3gBLcxDFGqY9PyO/9nG3IcBQnmNKDmdwTVFOForaLkHo1i', '1', '2026-02-26 10:07:59');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_tbl`
--

DROP TABLE IF EXISTS `wishlist_tbl`;
CREATE TABLE IF NOT EXISTS `wishlist_tbl` (
  `wishlist_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `pimage_id` int NOT NULL,
  `pvariation_id` int NOT NULL,
  `w_status` tinyint DEFAULT '1',
  PRIMARY KEY (`wishlist_id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  KEY `pimage_id` (`pimage_id`),
  KEY `pvariation_id` (`pvariation_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_tbl`
--
ALTER TABLE `cart_tbl`
  ADD CONSTRAINT `cart_tbl_ibfk_1` FOREIGN KEY (`pimage`) REFERENCES `product_image_tbl` (`image_id`),
  ADD CONSTRAINT `cart_tbl_ibfk_2` FOREIGN KEY (`pvariation`) REFERENCES `product_variation_tbl` (`pvariation_id`);

--
-- Constraints for table `order_items_tbl`
--
ALTER TABLE `order_items_tbl`
  ADD CONSTRAINT `order_items_tbl_ibfk_1` FOREIGN KEY (`pimage_id`) REFERENCES `product_image_tbl` (`image_id`),
  ADD CONSTRAINT `order_items_tbl_ibfk_2` FOREIGN KEY (`pvariation_id`) REFERENCES `product_variation_tbl` (`pvariation_id`);

--
-- Constraints for table `product_image_tbl`
--
ALTER TABLE `product_image_tbl`
  ADD CONSTRAINT `product_image_tbl_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `color_tbl` (`color_id`);

--
-- Constraints for table `wishlist_tbl`
--
ALTER TABLE `wishlist_tbl`
  ADD CONSTRAINT `wishlist_tbl_ibfk_1` FOREIGN KEY (`pimage_id`) REFERENCES `product_image_tbl` (`image_id`),
  ADD CONSTRAINT `wishlist_tbl_ibfk_2` FOREIGN KEY (`pvariation_id`) REFERENCES `product_variation_tbl` (`pvariation_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
