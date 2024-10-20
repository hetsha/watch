-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2024 at 03:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecom_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_pass` varchar(255) NOT NULL,
  `admin_image` text NOT NULL,
  `admin_contact` varchar(255) NOT NULL,
  `admin_country` text NOT NULL,
  `admin_job` varchar(255) NOT NULL,
  `admin_about` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`, `admin_country`, `admin_job`, `admin_about`) VALUES
(1, 'het', 'hetshah6315@gmail.com', 'qwe', 'IMG_20230513_122559_265.jpg', '9427961426', 'India', 'admin', ' admin of the ora watch  '),
(2, 'akshat', 'akshat@gmail.com', 'ak', 'user1.png', '9825079765', 'India', 'admin', '   ');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `p_price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'active',
  `added_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `qty`, `p_price`, `size`, `status`, `added_on`) VALUES
(27, 3, 1, 1, 25000.00, NULL, 'active', '2024-10-19 07:59:23'),
(41, 1, 2, 1, 2500.00, NULL, 'active', '2024-10-20 12:33:38');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) NOT NULL,
  `cat_title` text NOT NULL,
  `cat_top` text NOT NULL,
  `cat_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_top`, `cat_image`) VALUES
(1, 'Casual', '', ''),
(2, 'Formal', '', ''),
(3, 'Smart watch', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `contact_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_email` text NOT NULL,
  `contact_heading` text NOT NULL,
  `contact_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`contact_id`, `name`, `contact_email`, `contact_heading`, `contact_desc`) VALUES
(1, 'Het Shah', 'hetshah6315@gmail.com', 'test', 'testing 123'),
(2, 'akshat', 'akshat@gmail.com', 'php', 'about watches');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_pass` varchar(11) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_country` text NOT NULL,
  `customer_city` text NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip_code` varchar(20) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_pass`, `customer_email`, `customer_country`, `customer_city`, `state`, `zip_code`, `customer_contact`, `phone_number`, `customer_address`, `created_at`, `updated_at`) VALUES
(1, 'het', 'qwe', 'hetshah6315@gmail.com', 'india', 'Ahmedabad', 'Gujarat', '380007', '09427961426', '09427961426', 'A 403 prakruti appt suvidha sanjivani road', '2024-10-06 17:52:29', '2024-10-20 12:49:52'),
(2, 'het shah', 'wer', 'hetshah3156@gmail.com', 'brazil', 'Ahmedabad', 'Gujarat', '380007', '1234567893', '09427961426', 'Ahmedabad Gujarat', '2024-10-07 04:58:58', '2024-10-20 12:58:31'),
(3, 'akshat', 'akshat', 'akshat@gmail.com', 'India', '', '', '', '9825079765', '', '', '2024-10-19 07:56:44', '2024-10-19 07:56:44'),
(4, 'Devang', '123', 'devang@gmail.com', 'India', 'Ahmedabad', 'Gujarat', '380007', '09427961426', '9426628007', 'Paldi', '2024-10-20 13:36:11', '2024-10-20 13:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `order_id` int(10) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `customer_id` int(10) NOT NULL,
  `due_amount` decimal(10,2) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(255) NOT NULL DEFAULT 'Complete',
  `order_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`order_id`, `invoice_id`, `customer_id`, `due_amount`, `order_date`, `order_status`, `order_total`) VALUES
(1, 1, 1, 0.00, '2024-10-07 04:43:48', 'Pending', 5000.00),
(2, 2, 2, 0.00, '2024-10-07 05:00:31', 'Pending', 111500.00),
(3, 3, 2, 0.00, '2024-10-07 15:11:06', 'Pending', 2500.00),
(4, 4, 2, 0.00, '2024-10-07 18:07:47', 'Pending', 71000.00),
(5, 5, 2, 0.00, '2024-10-07 18:14:18', 'Pending', 2500.00),
(6, 6, 2, 0.00, '2024-10-07 18:19:51', 'Pending', 2500.00),
(7, 7, 2, 0.00, '2024-10-07 18:42:38', 'Pending', 2500.00),
(8, 8, 2, 0.00, '2024-10-12 04:59:03', 'Pending', 38000.00),
(9, 9, 2, 0.00, '2024-10-12 05:04:53', 'Pending', 2500.00),
(10, 10, 2, 0.00, '2024-10-12 05:10:38', 'Pending', 2500.00),
(11, 11, 2, 0.00, '2024-10-12 05:17:12', 'Pending', 2500.00),
(12, 12, 2, 0.00, '2024-10-12 05:18:41', 'Pending', 2500.00),
(13, 13, 2, 0.00, '2024-10-12 05:24:59', 'Pending', 33000.00),
(14, 14, 1, 0.00, '2024-10-12 05:26:51', 'Pending', 33000.00),
(15, 15, 1, 0.00, '2024-10-12 05:40:44', 'Pending', 2500.00),
(17, 22, 1, 0.00, '2024-10-12 06:03:54', 'Pending', 2500.00),
(18, 23, 1, 0.00, '2024-10-20 12:18:00', 'Complete', 25000.00),
(19, 24, 4, 0.00, '2024-10-20 13:37:42', 'Complete', 150000.00);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_types`
--

CREATE TABLE `enquiry_types` (
  `enquiry_id` int(10) NOT NULL,
  `enquiry_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `enquiry_types`
--

INSERT INTO `enquiry_types` (`enquiry_id`, `enquiry_title`) VALUES
(2, 'hetshah6315@gmail.com'),
(3, 'hetshah6315@gmail.com'),
(4, 'hetshah6315@gmail.com'),
(5, 'akshat@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice_number` varchar(6) NOT NULL,
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_number`, `order_id`, `customer_id`, `order_date`) VALUES
(1, '957568', 1, 1, '2024-10-06 23:13:48'),
(2, '789235', 2, 2, '2024-10-06 23:30:31'),
(3, '065404', 3, 2, '2024-10-07 09:41:06'),
(4, '219420', 4, 2, '2024-10-07 12:37:47'),
(5, '498054', 5, 2, '2024-10-07 12:44:18'),
(6, '778263', 6, 2, '2024-10-07 12:49:51'),
(7, '591731', 7, 2, '2024-10-07 13:12:38'),
(8, '311994', 8, 2, '2024-10-11 23:29:03'),
(9, '961958', 9, 2, '2024-10-11 23:34:53'),
(10, '289774', 10, 2, '2024-10-11 23:40:38'),
(11, '378237', 11, 2, '2024-10-11 23:47:12'),
(12, '945253', 12, 2, '2024-10-11 23:48:41'),
(13, '069464', 13, 2, '2024-10-11 23:54:59'),
(14, '268308', 14, 1, '2024-10-11 23:56:51'),
(15, '113957', 15, 1, '2024-10-12 05:40:44'),
(22, '962208', 17, 1, '2024-10-12 06:03:54'),
(23, '964339', 18, 1, '2024-10-20 12:18:00'),
(24, '405717', 19, 4, '2024-10-20 13:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `manufacturers`
--

CREATE TABLE `manufacturers` (
  `manufacturer_id` int(10) NOT NULL,
  `manufacturer_title` text NOT NULL,
  `manufacturer_top` text NOT NULL,
  `manufacturer_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_title`, `manufacturer_top`, `manufacturer_image`) VALUES
(1, 'ORA', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(10) NOT NULL,
  `order_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `qty` int(10) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 2, 2, 2500.00),
(2, 2, 1, 3, 33000.00),
(3, 2, 2, 5, 2500.00),
(4, 3, 2, 1, 2500.00),
(5, 4, 1, 2, 33000.00),
(6, 4, 2, 2, 2500.00),
(7, 5, 2, 1, 2500.00),
(8, 6, 2, 1, 2500.00),
(9, 7, 2, 1, 2500.00),
(10, 8, 2, 2, 2500.00),
(11, 8, 1, 1, 33000.00),
(12, 9, 2, 1, 2500.00),
(13, 10, 2, 1, 2500.00),
(14, 11, 2, 1, 2500.00),
(15, 12, 2, 1, 2500.00),
(16, 13, 1, 1, 33000.00),
(17, 14, 1, 1, 33000.00),
(18, 15, 2, 1, 2500.00),
(19, 17, 2, 1, 2500.00),
(20, 18, 1, 1, 25000.00),
(21, 19, 1, 6, 25000.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(10) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL,
  `amount` int(10) NOT NULL,
  `payment_mode` text NOT NULL,
  `ref_no` int(10) NOT NULL,
  `code` int(10) NOT NULL,
  `payment_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_id`, `amount`, `payment_mode`, `ref_no`, `code`, `payment_date`) VALUES
(1, 1, 5000, 'cash_on_delivery', 0, 0, '2024-10-07 10:13:48'),
(2, 2, 111500, 'cash_on_delivery', 0, 0, '2024-10-07 10:30:31'),
(3, 3, 2500, 'cash_on_delivery', 0, 0, '2024-10-07 20:41:06'),
(4, 4, 71000, 'cash_on_delivery', 0, 0, '2024-10-07 23:37:47'),
(5, 5, 2500, 'credit_card', 0, 0, '2024-10-07 23:44:18'),
(6, 6, 2500, 'Cash on Delivery', 0, 0, '2024-10-07 23:49:51'),
(7, 7, 2500, 'COD', 0, 0, '2024-10-08 00:12:38'),
(8, 8, 38000, 'COD', 0, 0, '2024-10-12 10:29:03'),
(9, 9, 2500, 'COD', 0, 0, '2024-10-12 10:34:53'),
(10, 10, 2500, 'COD', 0, 0, '2024-10-12 10:40:38'),
(11, 11, 2500, 'Credit Card', 0, 0, '2024-10-12 10:47:12'),
(12, 12, 2500, 'COD', 0, 0, '2024-10-12 10:48:41'),
(13, 13, 33000, 'COD', 0, 0, '2024-10-12 10:54:59'),
(14, 14, 33000, 'COD', 0, 0, '2024-10-12 10:56:51'),
(15, 15, 2500, 'COD', 0, 0, '2024-10-12 11:10:44'),
(16, 22, 2500, 'Credit Card', 0, 0, '2024-10-12 11:33:54'),
(17, 23, 25000, 'UPI', 0, 0, '2024-10-20 17:48:00'),
(18, 24, 150000, 'Credit Card', 0, 0, '2024-10-20 19:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `pending_orders`
--

CREATE TABLE `pending_orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `invoice_id` int(10) NOT NULL,
  `product_id` text NOT NULL,
  `qty` int(10) NOT NULL,
  `p_price` text NOT NULL,
  `order_status` text NOT NULL,
  `order_total` decimal(10,2) DEFAULT NULL,
  `order_date` decimal(10,2) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pending_orders`
--

INSERT INTO `pending_orders` (`order_id`, `customer_id`, `invoice_id`, `product_id`, `qty`, `p_price`, `order_status`, `order_total`, `order_date`, `payment_method`) VALUES
(3, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'cash_on_delivery'),
(4, 2, 0, '', 0, '', '', 71000.00, 99999999.99, 'cash_on_delivery'),
(5, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'credit_card'),
(6, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'Cash on Delivery'),
(7, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'COD'),
(8, 2, 0, '', 0, '', '', 38000.00, 99999999.99, 'COD'),
(9, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'COD'),
(10, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'COD'),
(11, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'Credit Card'),
(12, 2, 0, '', 0, '', '', 2500.00, 99999999.99, 'COD'),
(13, 2, 0, '', 0, '', '', 33000.00, 99999999.99, 'COD'),
(14, 1, 0, '', 0, '', '', 33000.00, 99999999.99, 'COD'),
(15, 1, 0, '', 0, '', '', 2500.00, 99999999.99, 'COD'),
(17, 1, 0, '', 0, '', '', 2500.00, 99999999.99, 'Credit Card'),
(18, 1, 0, '', 0, '', '', 25000.00, 99999999.99, 'UPI'),
(19, 4, 0, '', 0, '', '', 150000.00, 99999999.99, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `manufacturer_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` varchar(255) NOT NULL,
  `product_url` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text NOT NULL,
  `product_img4` text NOT NULL,
  `product_img5` text NOT NULL,
  `product_price` decimal(10,2) NOT NULL,
  `product_desc` text NOT NULL,
  `product_psp_price` decimal(10,2) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'product'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `manufacturer_id`, `date`, `product_title`, `product_url`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `product_img5`, `product_price`, `product_desc`, `product_psp_price`, `status`) VALUES
(1, 0, 2, 1, '2024-10-12 08:52:08', 'AL-prado', 'AL-prado', '001_8a65959a.jpg', '007_003ebd8c.jpg', '008_1c061100.jpg', '002_ce68dcc5.jpg', '011_d1838ad7.jpg', 35000.00, '', 25000.00, 'product'),
(2, 0, 1, 1, '2024-10-07 04:39:44', 'test1', 'test1', '010_eb22bd2f.jpg', '012_4fadea8c.jpg', '009_c04c6b85.jpg', '004_323ae7a2.jpg', '006_26bab30f.jpg', 5000.00, '', 2500.00, 'product');

-- --------------------------------------------------------

--
-- Table structure for table `product_categories`
--

CREATE TABLE `product_categories` (
  `p_cat_id` int(10) NOT NULL,
  `p_cat_title` text NOT NULL,
  `p_cat_top` text NOT NULL,
  `p_cat_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `product_categories`
--

INSERT INTO `product_categories` (`p_cat_id`, `p_cat_title`, `p_cat_top`, `p_cat_image`) VALUES
(1, 'Casual', '', ''),
(2, 'Formal', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `fk_customer_orders_invoice_id` (`invoice_id`) USING BTREE;

--
-- Indexes for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  ADD PRIMARY KEY (`enquiry_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `invoices_ibfk_2` (`customer_id`),
  ADD KEY `fk_invoices_order` (`order_id`);

--
-- Indexes for table `manufacturers`
--
ALTER TABLE `manufacturers`
  ADD PRIMARY KEY (`manufacturer_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `fk_payments_invoice_id` (`invoice_id`);

--
-- Indexes for table `pending_orders`
--
ALTER TABLE `pending_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `manufacturer_id` (`manufacturer_id`);

--
-- Indexes for table `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`p_cat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  MODIFY `enquiry_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `customer_orders`
--
ALTER TABLE `customer_orders`
  ADD CONSTRAINT `customer_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`),
  ADD CONSTRAINT `fk_customer_orders_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `fk_invoices_order` FOREIGN KEY (`order_id`) REFERENCES `customer_orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `customer_orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_payments_invoice_id` FOREIGN KEY (`invoice_id`) REFERENCES `invoices` (`invoice_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
