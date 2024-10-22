-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql206.infinityfree.com
-- Generation Time: Oct 22, 2024 at 11:17 AM
-- Server version: 10.6.19-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_37552151_ecom_store`
--

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_pass`, `admin_image`, `admin_contact`, `admin_country`, `admin_job`, `admin_about`) VALUES
(1, 'akshat', '', 'ak', '', '', '', '', '');

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`, `cat_top`, `cat_image`) VALUES
(1, 'Formal', '', ''),
(2, 'Casual', '', ''),
(3, 'Smart Watches', 'yes', ''),
(4, 'Sports', '', '');

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_pass`, `customer_email`, `customer_country`, `customer_city`, `state`, `zip_code`, `customer_contact`, `phone_number`, `customer_address`, `created_at`, `updated_at`) VALUES
(1, 'Het', '123', 'hetshah6315@gmail.com', 'India', '', '', '', '9427961426', '', '', '2024-10-22 08:04:18', '2024-10-22 08:04:18');

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_title`, `manufacturer_top`, `manufacturer_image`) VALUES
(1, 'Rolex', '', ''),
(2, 'ORA', '', ''),
(3, 'Apple', '', ''),
(5, 'Titan', '', ''),
(6, 'Boat', '', ''),
(7, 'Noice', '', ''),
(10, 'Tissot', '', ''),
(11, 'Emporio armani', '', ''),
(12, 'G-Shock', '', ''),
(13, 'Casio', '', ''),
(14, 'Fastrack', '', ''),
(15, 'Sonata', '', '');

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `manufacturer_id`, `date`, `product_title`, `product_url`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `product_img5`, `product_price`, `product_desc`, `product_psp_price`, `status`) VALUES
(1, 0, 1, 1, '2024-10-22 08:30:09', 'Rolex Date Black Leather Watch', 'Rolex Date Black Leather Watch', '2_9.jpg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', '400000.00', 'The concept of innovation has become crucial when it comes to timepieces, and luxury calendar watches have established a distinct niche for themselves when it comes to innovative horology. Calendar watches are complicated yet artistically advanced pieces that combine all the functions of a calendar in a single wrist piece.', '300000.00', 'product'),
(2, 0, 1, 11, '2024-10-22 08:05:06', 'Armani black leather watch', 'Armani black leather watch', '612GjkDdOeL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '50000.00', '', '45000.00', 'product'),
(3, 0, 1, 11, '2024-10-22 08:06:39', 'Armani ar1151', 'Armani ar1151', 'emporio-armani-ar11521-mens-watch.webp', 'emporio-armani-ar11521-mens-watch (1).webp', 'emporio-armani-ar11521-mens-watch (1).webp', 'emporio-armani-ar11521-mens-watch (1).webp', 'emporio-armani-ar11521-mens-watch (1).webp', '33000.00', '', '30000.00', 'product'),
(5, 0, 1, 11, '2024-10-22 08:24:29', 'Armani Chronograph Black Leather Watch', 'Armani Chronograph Black Leather Watch', 'w480 (2).webp', 'w480.webp', 'w480.webp', 'w480.webp', 'w480.webp', '90000.00', '', '85000.00', 'product'),
(6, 0, 1, 1, '2024-10-22 08:26:45', 'rolex-sky-dweller', 'rolex-sky-dweller', 'rolex-sky-dweller-336933-blkind-multiple-1.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', '1500000.00', '', '1350000.00', 'product'),
(7, 0, 1, 1, '2024-10-22 08:27:58', 'rolex-gmt-master-ii', 'rolex-gmt-master-ii', 'rolex-gmt-master-ii-116710ln-pow-large_02.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', '2500000.00', '', '2350000.00', 'product'),
(8, 0, 1, 10, '2024-10-22 08:41:06', 'Tissot Chrono XL Classic', 'Tissot Chrono XL Classic', 'tissot-t-sport-t116-617-22-091-00-large.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', '45000.00', '', '44000.00', 'product'),
(9, 0, 1, 10, '2024-10-22 08:42:03', 'Tissot T-Race Chronograph', 'Tissot T-Race Chronograph', 'tissot-t-sport-t141-417-37-051-00-large.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', '59000.00', '', '58000.00', 'product'),
(10, 0, 1, 10, '2024-10-22 08:43:00', 'Tissot Xl Men Leather Watch', 'Tissot Xl Men Leather Watch', 'T1166173605203.webp', 'T1166173605203_3.webp', 'T1166173605203_3.webp', 'T1166173605203_3.webp', 'T1166173605203_3.webp', '35000.00', '', '33500.00', 'product');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
