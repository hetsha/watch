-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2024 at 05:52 PM
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
(1, 'het', 'hetshah6315@gmail.com', 'admin', 'IMG_20230513_122559_265.jpg', '9427961426', 'India', 'Admin', 'founder  ');

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
(29, 2, 7, 2, 566.00, NULL, 'active', '2024-10-01 19:24:01');

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
(1, 'Quantum / watch', 'no', ''),
(2, 'watch', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `contact_id` int(10) NOT NULL,
  `contact_email` text NOT NULL,
  `contact_heading` text NOT NULL,
  `contact_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `coupon_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL,
  `coupon_title` varchar(255) NOT NULL,
  `coupon_price` varchar(255) NOT NULL,
  `coupon_code` varchar(255) NOT NULL,
  `coupon_limit` int(100) NOT NULL,
  `coupon_used` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(10) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_pass` int(11) NOT NULL,
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
(1, 'het', 123, 'hetshah6315@gmail.com', 'india', '', '', '', '9427961426', '', '', '2024-10-04 09:06:23', '2024-10-04 09:24:16'),
(2, 'heet', 123, 'heetshah6315@gmail.com', 'india', '', '', '', '644523458', '', '', '2024-10-04 09:06:23', '2024-10-04 09:24:11'),
(3, '', 123, '', 'India', '', 'Gujarat', '', '', '', '', '2024-10-04 09:06:23', '2024-10-04 09:30:19'),
(4, 'Het Shah', 123, 'hetshah6315@gmail.com', '', 'Ahmedabad', 'Gujarat', '380007', '', '', 'Ahmedabad Gujarat', '2024-10-04 09:08:55', '2024-10-04 09:23:59'),
(5, 'Het Shah', 123, 'hetshah6315@gmail.com', '', 'Ahmedabad', 'Gujarat', '380007', '', '', 'Ahmedabad Gujarat', '2024-10-04 09:13:09', '2024-10-04 09:24:04'),
(6, 'Het Shah', 1234, 'hetshah6315@gmail.com', 'india', 'Ahmedabad', 'Gujarat', '380007', '09427961426', '09427961426', 'Ahmedabad Gujarat', '2024-10-04 09:48:06', '2024-10-04 10:39:24'),
(7, 'meet', 345, 'meet@gmail.com', 'india', 'Ahmedabad', 'Gujarat', '380007', '09427961426', '09427961426', 'a403 prakruti', '2024-10-04 15:50:32', '2024-10-04 15:52:02');

-- --------------------------------------------------------

--
-- Table structure for table `customer_orders`
--

CREATE TABLE `customer_orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `due_amount` decimal(10,2) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `order_status` varchar(255) NOT NULL DEFAULT 'Pending',
  `order_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`order_id`, `customer_id`, `due_amount`, `invoice_number`, `order_date`, `order_status`, `order_total`) VALUES
(1, 1, 0.00, '', '2024-10-04 08:56:33', 'Pending', 3122.00),
(2, 1, 0.00, '', '2024-10-04 08:59:27', 'Pending', 3122.00),
(3, 1, 0.00, '', '2024-10-04 08:59:30', 'Pending', 3122.00),
(4, 1, 0.00, '', '2024-10-04 09:00:22', 'Pending', 3122.00),
(5, 1, 0.00, '', '2024-10-04 09:01:41', 'Pending', 4799.00),
(6, 4, 0.00, '', '2024-10-04 09:08:55', 'Pending', 4799.00),
(7, 5, 0.00, '', '2024-10-04 09:13:09', 'Pending', 4799.00),
(8, 1, 0.00, '', '2024-10-04 09:15:25', 'Pending', 4799.00),
(9, 1, 0.00, '', '2024-10-04 09:15:47', 'Pending', 4799.00),
(10, 1, 0.00, '', '2024-10-04 09:16:37', 'Pending', 3752.00),
(11, 3, 0.00, '', '2024-10-04 09:30:19', 'Pending', 8046.00),
(12, 6, 0.00, '', '2024-10-04 09:49:14', 'Pending', 3584.00),
(13, 6, 0.00, '', '2024-10-04 09:57:07', 'Pending', 4505.00),
(14, 6, 0.00, '', '2024-10-04 09:58:04', 'Pending', 4505.00),
(15, 6, 0.00, '', '2024-10-04 09:58:38', 'Pending', 4505.00),
(16, 6, 0.00, '', '2024-10-04 10:07:53', 'Pending', 4505.00),
(17, 6, 0.00, '', '2024-10-04 10:15:13', 'Pending', 4505.00),
(18, 6, 0.00, '', '2024-10-04 10:15:22', 'Pending', 4505.00),
(19, 6, 0.00, '', '2024-10-04 10:16:07', 'Pending', 4505.00),
(20, 6, 0.00, '632483', '2024-10-04 10:40:10', 'Pending', 2200.00),
(21, 6, 0.00, '342196', '2024-10-04 14:10:05', 'Pending', 6579.00),
(22, 7, 0.00, '163346', '2024-10-04 15:52:02', 'Pending', 2473.00);

-- --------------------------------------------------------

--
-- Table structure for table `enquiry_types`
--

CREATE TABLE `enquiry_types` (
  `enquiry_id` int(10) NOT NULL,
  `enquiry_title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice_number` varchar(6) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'ORA', 'no', ''),
(2, 'Audemars Piguet', 'no', ''),
(3, 'Breguet', '', ''),
(4, 'Breitling', '', ''),
(5, 'Rolex', '', '');

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
(1, 9, 10, 3, 1213.00),
(2, 9, 5, 5, 232.00),
(3, 10, 3, 1, 500.00),
(4, 10, 7, 2, 566.00),
(5, 10, 6, 1, 2120.00),
(6, 11, 8, 2, 2200.00),
(7, 11, 2, 1, 1220.00),
(8, 11, 10, 2, 1213.00),
(9, 12, 9, 1, 2120.00),
(10, 12, 5, 2, 232.00),
(11, 12, 3, 2, 500.00),
(12, 19, 4, 2, 20.00),
(13, 19, 6, 1, 2120.00),
(14, 19, 7, 2, 566.00),
(15, 19, 10, 1, 1213.00),
(16, 20, 8, 1, 2200.00),
(17, 21, 10, 3, 1213.00),
(18, 21, 2, 2, 1220.00),
(19, 21, 3, 1, 500.00),
(20, 22, 10, 1, 1213.00),
(21, 22, 4, 2, 20.00),
(22, 22, 2, 1, 1220.00);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(10) NOT NULL,
  `invoice_no` int(10) NOT NULL,
  `amount` int(10) NOT NULL,
  `payment_mode` text NOT NULL,
  `ref_no` int(10) NOT NULL,
  `code` int(10) NOT NULL,
  `payment_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_no`, `amount`, `payment_mode`, `ref_no`, `code`, `payment_date`) VALUES
(1, 1, 5000, 'credit_card', 0, 0, ''),
(2, 2, 5000, 'paypal', 0, 0, ''),
(3, 0, 4505, 'Cash on Delivery', 0, 0, '2024-10-04 15:46:07'),
(4, 0, 2200, 'Cash on Delivery', 0, 0, '2024-10-04 16:10:10'),
(5, 0, 6579, 'cod', 0, 0, '2024-10-04 19:40:05'),
(6, 0, 2473, 'online', 0, 0, '2024-10-04 21:22:02');

-- --------------------------------------------------------

--
-- Table structure for table `pending_orders`
--

CREATE TABLE `pending_orders` (
  `order_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `invoice_number` int(10) NOT NULL,
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

INSERT INTO `pending_orders` (`order_id`, `customer_id`, `invoice_number`, `product_id`, `qty`, `p_price`, `order_status`, `order_total`, `order_date`, `payment_method`) VALUES
(1, 1, 0, '1', 1, '', '', NULL, NULL, ''),
(2, 1, 0, '2', 1, '', '', NULL, NULL, ''),
(3, 0, 0, '10', 2, '1213', '', NULL, NULL, ''),
(4, 0, 0, '10', 2, '1213', '', NULL, NULL, ''),
(5, 0, 0, '10', 3, '1213', '', NULL, NULL, ''),
(6, 0, 0, '10', 3, '1213', '', NULL, NULL, ''),
(7, 0, 0, '10', 3, '1213', '', NULL, NULL, ''),
(19, 6, 0, '', 0, '', '', 4505.00, 99999999.99, 'Cash on Delivery'),
(20, 6, 0, '', 0, '', '', 2200.00, 99999999.99, 'Cash on Delivery'),
(21, 6, 0, '', 0, '', '', 6579.00, 99999999.99, 'cod'),
(22, 7, 0, '', 0, '', '', 2473.00, 99999999.99, 'online');

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
(2, 1, 1, 1, '2024-09-30 17:22:23', 'watch', 'ads', '001_08b7b78b.jpg', '001_08b7b78b.jpg', '008_cef4e301.jpg', '001_08b7b78b.jpg', '001_08b7b78b.jpg', 20000.00, '\r\n                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Et neque voluptatibus aliquam reprehenderit. Enim est sit aperiam accusantium ab ducimus animi obcaecati, architecto officia qui illum eum odio, amet reprehenderit autem, consequatur praesentium dolorum quidem accusamus expedita cum doloremque vero! Exercitationem, aliquam dicta nam nostrum, fuga, fugiat nihil provident voluptatem in repellat quasi saepe eveniet molestias.', 1220.00, 'product'),
(3, 2, 1, 2, '2024-09-30 17:31:23', 'hert', 'sdf', '009_6982b6e3.jpg', '010_e78c7f30.jpg', '011_7f5ac369.jpg', '012_3c899e6e.jpg', '002_2497781c.jpg', 1000.00, '', 500.00, 'product'),
(4, 1, 1, 1, '2024-09-30 17:43:26', 'test1', 'test1', '007_72efa7c1.jpg', '009_31bb50c4.jpg', '004_d6fe2704.jpg', '012_2c424055.jpg', '015_2a8dc2cf.jpg', 20.00, '', 20.00, 'product'),
(5, 2, 2, 2, '2024-09-30 17:44:38', 'test2', 'test2', '060_314132eb.jpg', '011_1e220276.jpg', '025_3afc50b5.jpg', '027_84925832.jpg', '029_5fe069c0.jpg', 2334.00, '', 232.00, 'product'),
(6, 3, 2, 2, '2024-09-30 17:47:53', 'test3', 'test3', '027_84925832.jpg', '047_5b6defcd.jpg', '058_af1114a7.jpg', '082_24f7231e.jpg', '044_38373e14.jpg', 5000.00, '', 2120.00, 'product'),
(7, 3, 2, 4, '2024-09-30 17:52:19', 'test4', 'test4', '040_18299624.jpg', '069_9f4abe6e.jpg', '060_314132eb.jpg', '067_107be655.jpg', '070_c01c2208.jpg', 1000.00, '', 566.00, 'product'),
(8, 3, 2, 2, '2024-09-30 17:53:23', 'test5', 'asd', '009_f0b8f646.jpg', '004_4e254570.jpg', '011_4cdc1c21.jpg', '007_a61f128f.jpg', '006_413ea940.jpg', 6000.00, '', 2200.00, 'product'),
(9, 3, 2, 5, '2024-09-30 18:25:07', 'test6', 'test7', '008_5fbcab7d.jpg', '010_d40686b8.jpg', '011_8a8b8c13.jpg', '007_0c194eab.jpg', '012_102632b5.jpg', 5652.00, '', 2120.00, 'product'),
(10, 3, 1, 4, '2024-09-30 18:25:58', 'test8', 'ert', '028_602a8ee5.jpg', '023_5f9b2835.jpg', '025_c55abace.jpg', '030_a13829fa.jpg', '026_3fdbbdc0.jpg', 8956.00, '', 1213.00, 'product');

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
(1, 'Quantum', 'no', ''),
(2, 'Rolex', '', ''),
(3, 'Breguet', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `store_id` int(10) NOT NULL,
  `store_title` varchar(255) NOT NULL,
  `store_image` varchar(255) NOT NULL,
  `store_desc` text NOT NULL,
  `store_button` varchar(255) NOT NULL,
  `store_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `wishlist_id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `product_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

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
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`coupon_id`);

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
  ADD KEY `customer_id` (`customer_id`);

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
  ADD KEY `order_id` (`order_id`),
  ADD KEY `customer_id` (`customer_id`);

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
  ADD PRIMARY KEY (`payment_id`);

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
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`store_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `contact_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `coupon_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `customer_orders`
--
ALTER TABLE `customer_orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `enquiry_types`
--
ALTER TABLE `enquiry_types`
  MODIFY `enquiry_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `manufacturers`
--
ALTER TABLE `manufacturers`
  MODIFY `manufacturer_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pending_orders`
--
ALTER TABLE `pending_orders`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `p_cat_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `store_id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(10) NOT NULL AUTO_INCREMENT;

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
  ADD CONSTRAINT `customer_orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`);

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `customer_orders` (`order_id`),
  ADD CONSTRAINT `invoices_ibfk_2` FOREIGN KEY (`customer_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `customer_orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`manufacturer_id`) REFERENCES `manufacturers` (`manufacturer_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
