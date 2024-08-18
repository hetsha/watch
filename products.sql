-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 17, 2024 at 04:28 PM
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(10) NOT NULL,
  `p_cat_id` int(10) NOT NULL,
  `cat_id` int(10) NOT NULL,
  `manufacturer_id` int(10) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `product_title` text NOT NULL,
  `product_url` text NOT NULL,
  `product_img1` text NOT NULL,
  `product_img2` text NOT NULL,
  `product_img3` text NOT NULL,
  `product_price` int(10) NOT NULL,
  `product_psp_price` int(100) NOT NULL,
  `product_desc` text NOT NULL,
  `product_features` text NOT NULL,
  `product_video` text NOT NULL,
  `product_keywords` text NOT NULL,
  `product_label` text NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `manufacturer_id`, `date`, `product_title`, `product_url`, `product_img1`, `product_img2`, `product_img3`, `product_price`, `product_psp_price`, `product_desc`, `product_features`, `product_video`, `product_keywords`, `product_label`, `status`) VALUES
(5, 1, 1, 2, '2024-08-17 12:41:51', 'test', 'test', 'LC06673.362 = 69 EURO-600x660.jpg', 'LC06673.362 = 69 EURO-600x660.jpg', 'LC06673.362 = 69 EURO-600x660.jpg', 5000, 1000, '\r\n\r\nasd', '\r\n\r\n', '\r\n\r\n', 'asd', 'asd', 'product'),
(4, 1, 1, 2, '2024-08-16 15:59:42', 'het', 'het', 'citizen.png', 'citizen.png', 'citizen.png', 5000, 3000, '\r\n\r\n', '\r\n\r\n', '\r\n\r\n', 'watch', 'watch', 'product'),
(3, 1, 1, 2, '2024-08-16 15:43:53', 'watch', 'watch_name', 'armani.png', 'armani.png', 'armani.png', 600, 200, '\r\n  \r\n\r\n\r\n  ', '\r\n  \r\n\r\n\r\n  ', '\r\n  \r\n\r\n\r\n  ', 'asd', 'watch', 'product'),
(2, 1, 1, 2, '2024-08-16 15:44:35', 'watch', 'watch_name', '360_F_567486394_PxcgLM8vtZqyH71fpkcpeKLDZfsbTyHO.jpg', 'BingImageOfTheDay.jpg', 'marble-product-backdrop-with-blank-space_53876-104163.avif', 1000, 600, '\r\n  \r\n  \r\n\r\n\r\n  \r\n  ', '\r\n  \r\n  \r\n\r\n\r\n  \r\n  ', '\r\n  \r\n  \r\n\r\n\r\n  \r\n  ', 'watch', 'watch', 'product');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
