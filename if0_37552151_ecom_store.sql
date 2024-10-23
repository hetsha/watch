-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql206.infinityfree.com
-- Generation Time: Oct 23, 2024 at 02:19 PM
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
(1, 'akshat', 'akshatjshah@gmail.com', 'ak', 'WhatsApp Image 2024-10-23 at 14.47.20_265b19ba.jpg', '9825079765', 'India ', 'Admin', '                  Senior                        '),
(2, 'het', 'hetshah6315@gmail.com', 'admin', 'IMG_20230513_122559_265.jpg', '9427961426', 'India', 'Admin', 'admin of the ora watch ');

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cart_id`, `customer_id`, `product_id`, `qty`, `p_price`, `size`, `status`, `added_on`) VALUES
(7, 1, 10, 1, '33500.00', NULL, 'active', '2024-10-22 17:41:03'),
(8, 1, 6, 1, '1350000.00', NULL, 'active', '2024-10-22 19:35:30');

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

INSERT INTO `customers` (`customer_id`, `customer_name`, `profile_pic`, `customer_pass`, `customer_email`, `customer_country`, `customer_city`, `state`, `zip_code`, `customer_contact`, `phone_number`, `customer_address`, `created_at`, `updated_at`) VALUES
(1, 'Het', 'uploads/6717f1b583c33-IMG_20230513_122559_265.jpg', '123', 'hetshah6315@gmail.com', 'India', 'Ahmedabad', 'Gujarat', '380007', '09427961426', '09427961426', 'A 403 prakruti appt suvidha sanjivani road', '2024-10-22 08:04:18', '2024-10-23 10:17:48'),
(2, 'gunjan', NULL, '1234', 'het.nakkamo@gmail.com', 'india', 'Ahmedabad', 'Gujarat', '380051', '75745656', '75749 37910', 'Vejalpur', '2024-10-22 17:01:33', '2024-10-22 17:07:37'),
(3, 'akshat', NULL, 'akak', 'akshat@gmail.com', 'India', 'Ahmedabad', 'Gujarat', '380007', '9825079765', '1234', 'abc', '2024-10-23 09:41:02', '2024-10-23 13:13:50'),
(4, 'mansi', NULL, '12345678', 'mansi@gmail.com', 'india', 'ahmedabad', 'gujrat', '254536', '1122334455', '1122334455', 'vastral', '2024-10-23 15:10:34', '2024-10-23 15:19:58');

--
-- Dumping data for table `customer_orders`
--

INSERT INTO `customer_orders` (`order_id`, `invoice_id`, `customer_id`, `due_amount`, `order_date`, `order_status`, `order_total`) VALUES
(1, 1, 1, '0.00', '2024-10-22 16:50:40', 'Complete', '33500.00'),
(2, 2, 1, '0.00', '2024-10-22 16:54:47', 'Complete', '176000.00'),
(3, 3, 2, '0.00', '2024-10-22 17:07:37', 'Complete', '67000.00'),
(4, 4, 2, '0.00', '2024-10-22 17:08:48', 'Complete', '33500.00'),
(5, 5, 1, '0.00', '2024-10-22 17:09:03', 'Complete', '33500.00'),
(6, 6, 3, '0.00', '2024-10-23 13:13:50', 'Complete', '2350000.00'),
(7, 7, 4, '0.00', '2024-10-23 15:19:58', 'Complete', '300000.00');

--
-- Dumping data for table `enquiry_types`
--

INSERT INTO `enquiry_types` (`enquiry_id`, `enquiry_title`) VALUES
(1, 'akshat@gmail.com');

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`invoice_id`, `invoice_number`, `order_id`, `customer_id`, `order_date`) VALUES
(1, '770433', 1, 1, '2024-10-22 16:50:40'),
(2, '206548', 2, 1, '2024-10-22 16:54:47'),
(3, '963302', 3, 2, '2024-10-22 17:07:37'),
(4, '778686', 4, 2, '2024-10-22 17:08:48'),
(5, '133402', 5, 1, '2024-10-22 17:09:03'),
(6, '455958', 6, 3, '2024-10-23 13:13:50'),
(7, '168391', 7, 4, '2024-10-23 15:19:58');

--
-- Dumping data for table `manufacturers`
--

INSERT INTO `manufacturers` (`manufacturer_id`, `manufacturer_title`, `manufacturer_top`, `manufacturer_image`) VALUES
(1, 'Rolex', '', ''),
(2, 'Kenneth Cole', 'yes', ''),
(3, 'Apple', '', ''),
(5, 'Titan', '', ''),
(6, 'Fire-Boltt', 'yes', ''),
(7, 'Noise', 'yes', ''),
(10, 'Tissot', '', ''),
(11, 'Emporio armani', '', ''),
(12, 'G-Shock', '', ''),
(13, 'Ttimewear', 'yes', ''),
(14, 'Fastrack', '', ''),
(15, 'Sonata', '', '');

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `qty`, `price`) VALUES
(1, 1, 10, 1, '33500.00'),
(2, 2, 8, 4, '44000.00'),
(3, 3, 10, 2, '33500.00'),
(4, 4, 10, 1, '33500.00'),
(5, 5, 10, 1, '33500.00'),
(6, 6, 7, 1, '2350000.00'),
(7, 7, 1, 1, '300000.00');

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `invoice_id`, `amount`, `payment_mode`, `ref_no`, `code`, `payment_date`) VALUES
(5, 5, 33500, 'Debit Card', 0, 0, '2024-10-22 10:09:03'),
(6, 6, 2350000, 'COD', 0, 0, '2024-10-23 06:13:50'),
(7, 7, 300000, 'Credit Card', 0, 0, '2024-10-23 08:19:58');

--
-- Dumping data for table `pending_orders`
--

INSERT INTO `pending_orders` (`order_id`, `customer_id`, `invoice_id`, `product_id`, `qty`, `p_price`, `order_status`, `order_total`, `order_date`, `payment_method`) VALUES
(1, 1, 0, '', 0, '', '', '33500.00', '99999999.99', 'COD'),
(2, 1, 0, '', 0, '', '', '176000.00', '99999999.99', 'Credit Card'),
(3, 2, 0, '', 0, '', '', '67000.00', '99999999.99', 'Credit Card'),
(4, 2, 0, '', 0, '', '', '33500.00', '99999999.99', 'Credit Card'),
(5, 1, 0, '', 0, '', '', '33500.00', '99999999.99', 'Debit Card'),
(6, 3, 0, '', 0, '', '', '2350000.00', '99999999.99', 'COD'),
(7, 4, 0, '', 0, '', '', '300000.00', '99999999.99', 'Credit Card');

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `p_cat_id`, `cat_id`, `manufacturer_id`, `date`, `product_title`, `product_url`, `product_img1`, `product_img2`, `product_img3`, `product_img4`, `product_img5`, `product_price`, `product_desc`, `product_psp_price`, `status`) VALUES
(1, 0, 1, 1, '2024-10-22 08:30:09', 'Rolex Date Black Leather Watch', 'Rolex Date Black Leather Watch', '2_9.jpg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', 'WhatsApp-Image-2023-08-25-at-5.28.04-PM-6.jpeg', '400000.00', 'The concept of innovation has become crucial when it comes to timepieces, and luxury calendar watches have established a distinct niche for themselves when it comes to innovative horology. Calendar watches are complicated yet artistically advanced pieces that combine all the functions of a calendar in a single wrist piece.', '300000.00', 'product'),
(2, 0, 1, 11, '2024-10-22 08:05:06', 'Armani black leather watch', 'Armani black leather watch', '612GjkDdOeL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '41LxlwA+0iL._SX679_.jpg', '50000.00', '', '45000.00', 'product'),
(3, 0, 1, 11, '2024-10-22 08:06:39', 'Armani ar1151', 'Armani ar1151', 'emporio-armani-ar11521-mens-watch.webp', 'emporio-armani-ar11521-mens-watch (1).webp', 'emporio-armani-ar11521-mens-watch (1).webp', 'emporio-armani-ar11521-mens-watch (1).webp', 'emporio-armani-ar11521-mens-watch (1).webp', '33000.00', '', '30000.00', 'product'),
(5, 0, 1, 11, '2024-10-23 10:06:47', 'Armani Black Leather Watch', 'Armani Black Leather Watch', 'w480 (2).webp', 'w480.webp', 'w480.webp', 'w480.webp', 'w480.webp', '90000.00', '', '85000.00', 'product'),
(6, 0, 1, 1, '2024-10-22 08:26:45', 'rolex-sky-dweller', 'rolex-sky-dweller', 'rolex-sky-dweller-336933-blkind-multiple-1.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', 'rolex-sky-dweller-336933-blkind-multiple-3.webp', '1500000.00', '', '1350000.00', 'product'),
(7, 0, 1, 1, '2024-10-22 08:27:58', 'rolex-gmt-master-ii', 'rolex-gmt-master-ii', 'rolex-gmt-master-ii-116710ln-pow-large_02.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', 'rolex-gmt-master-ii-116710ln-pow_multiple_03.webp', '2500000.00', '', '2350000.00', 'product'),
(8, 0, 1, 10, '2024-10-22 08:41:06', 'Tissot Chrono XL Classic', 'Tissot Chrono XL Classic', 'tissot-t-sport-t116-617-22-091-00-large.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', 'tissot-t-sport-t116-617-22-091-00-multiple-3.webp', '45000.00', '', '44000.00', 'product'),
(9, 0, 1, 10, '2024-10-22 08:42:03', 'Tissot T-Race Chronograph', 'Tissot T-Race Chronograph', 'tissot-t-sport-t141-417-37-051-00-large.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', 'tissot-t-sport-t141-417-37-051-00-multiple-3.webp', '59000.00', '', '58000.00', 'product'),
(10, 0, 1, 10, '2024-10-22 08:43:00', 'Tissot Xl Men Leather Watch', 'Tissot Xl Men Leather Watch', 'T1166173605203.webp', 'T1166173605203_3.webp', 'T1166173605203_3.webp', 'T1166173605203_3.webp', 'T1166173605203_3.webp', '35000.00', '', '33500.00', 'product'),
(11, 0, 3, 3, '2024-10-23 06:55:39', 'Natural Titanium Case with Alpine Loop', 'Natural Titanium Case with Alpine Loop', 'MXN13ref_VW_PF+watch-case-49-titanium-natural-ultra2_VW_PF+watch-face-49-alpine-ultra2_VW_PF_GEO_IN.jpeg', 'MXN13ref_VW_34FR+watch-case-49-titanium-natural-ultra2_VW_34FR+watch-face-49-alpine-ultra2_VW_34FR_GEO_IN.jpeg', 'MXN13ref_VW_34FR+watch-case-49-titanium-natural-ultra2_VW_34FR+watch-face-49-alpine-ultra2_VW_34FR_GEO_IN.jpeg', 'MXN13ref_VW_34FR+watch-case-49-titanium-natural-ultra2_VW_34FR+watch-face-49-alpine-ultra2_VW_34FR_GEO_IN.jpeg', 'MXN13ref_VW_34FR+watch-case-49-titanium-natural-ultra2_VW_34FR+watch-face-49-alpine-ultra2_VW_34FR_GEO_IN.jpeg', '86500.00', '', '85000.00', 'product'),
(12, 0, 3, 3, '2024-10-23 13:08:49', 'Jet Black Aluminium Case Loop', 'Jet Black Aluminium Case Loop', 'MXKW3_SR_S10_VW_PF+watch-case-42-aluminum-jetblack-nc-s10_VW_PF+watch-face-42-aluminum-jetblack-s10_VW_PF.jpeg', 'MXKW3_VW_34FR+watch-case-42-aluminum-jetblack-nc-s10_VW_34FR+watch-face-42-aluminum-jetblack-s10_VW_34FR.jpeg', 'MXKW3_VW_34FR+watch-case-42-aluminum-jetblack-nc-s10_VW_34FR+watch-face-42-aluminum-jetblack-s10_VW_34FR.jpeg', 'MXKW3_VW_34FR+watch-case-42-aluminum-jetblack-nc-s10_VW_34FR+watch-face-42-aluminum-jetblack-s10_VW_34FR.jpeg', 'MXKW3_VW_34FR+watch-case-42-aluminum-jetblack-nc-s10_VW_34FR+watch-face-42-aluminum-jetblack-s10_VW_34FR.jpeg', '80000.00', '', '78500.00', 'product'),
(13, 0, 3, 3, '2024-10-23 13:08:24', 'Apple silver Aluminium Case Loop', 'Apple silver Aluminium Case Loop', 'MYJ83_VW_PF+watch-case-40-aluminum-silver-nc-se_VW_PF+watch-face-40-aluminum-silver-se_VW_PF.jpeg', 'MYJ83_VW_34FR+watch-case-40-aluminum-silver-nc-se_VW_34FR+watch-face-40-aluminum-silver-se_VW_34FR.jpeg', 'MYJ83_VW_34FR+watch-case-40-aluminum-silver-nc-se_VW_34FR+watch-face-40-aluminum-silver-se_VW_34FR.jpeg', 'MYJ83_VW_34FR+watch-case-40-aluminum-silver-nc-se_VW_34FR+watch-face-40-aluminum-silver-se_VW_34FR.jpeg', 'MYJ83_VW_34FR+watch-case-40-aluminum-silver-nc-se_VW_34FR+watch-face-40-aluminum-silver-se_VW_34FR.jpeg', '90000.00', '', '88599.00', 'product'),
(14, 0, 3, 6, '2024-10-23 06:59:19', 'Fire-Boltt ninja pro', 'Fire-Boltt ninja pro', '61FQOvP93fL._SX679_.jpg', 'rMzLEjCO.jpg', 'rMzLEjCO.jpg', 'rMzLEjCO.jpg', 'rMzLEjCO.jpg', '3000.00', '', '2500.00', 'product'),
(15, 0, 3, 6, '2024-10-23 07:00:37', 'Fire-Boltt Maverick Smartwatch', 'Fire-Boltt Maverick Smartwatch', '81h-MXtG3OL._SX679_.jpg', '71FFcbkVcML._SX679_.jpg', '71FFcbkVcML._SX679_.jpg', '71FFcbkVcML._SX679_.jpg', '71FFcbkVcML._SX679_.jpg', '4500.00', '', '4000.00', 'product'),
(16, 0, 3, 6, '2024-10-23 07:01:43', 'Fire-Boltt Moonwatch', 'Fire-Boltt Moonwatch', '71WYaGBszvL._SX522_.jpg', '71SU77UTu9L._SX522_.jpg', '71SU77UTu9L._SX522_.jpg', '71SU77UTu9L._SX522_.jpg', '71SU77UTu9L._SX522_.jpg', '3599.00', '', '3299.00', 'product'),
(17, 0, 3, 7, '2024-10-23 07:04:10', 'Noise Vivid Call 2 Smart Watch', 'Noise Vivid Call 2 Smart Watch', '61BoaOUf+KL.jpg', '16711741848a645009a0fd823f8a75bbcff42957fa_thumbnail_720x.jpg', '16711741848a645009a0fd823f8a75bbcff42957fa_thumbnail_720x.jpg', '16711741848a645009a0fd823f8a75bbcff42957fa_thumbnail_720x.jpg', '16711741848a645009a0fd823f8a75bbcff42957fa_thumbnail_720x.jpg', '2000.00', '', '1500.00', 'product'),
(18, 0, 3, 7, '2024-10-23 07:06:17', 'Noise mettle pro2', 'Noise mettle pro2', '21bdaba1-f7ea-4803-9055-1758cbaadb1123080644_416x416.jpg', 'sg-noise-colorfit-ultra-3-sw-121-flysrpeck-original-imagpdcdfffagzdj.webp', 'sg-noise-colorfit-ultra-3-sw-121-flysrpeck-original-imagpdcdfffagzdj.webp', 'sg-noise-colorfit-ultra-3-sw-121-flysrpeck-original-imagpdcdfffagzdj.webp', 'sg-noise-colorfit-ultra-3-sw-121-flysrpeck-original-imagpdcdfffagzdj.webp', '5000.00', '', '4500.00', 'product'),
(19, 0, 3, 7, '2024-10-23 07:11:41', 'noise army pro4', 'noise army pro4', 'NoiseColorFitThrill-CamoGreen.webp', 'NoiseColorFitThrill-_nbsp_DustWaterResistant.webp', 'NoiseColorFitThrill-_nbsp_DustWaterResistant.webp', 'NoiseColorFitThrill-_nbsp_DustWaterResistant.webp', 'NoiseColorFitThrill-_nbsp_DustWaterResistant.webp', '6000.00', '', '5500.00', 'product'),
(20, 0, 4, 12, '2024-10-23 10:53:34', 'G138', 'G138', 'casio-g1384-gm-b2100gd-9adr-g-shock-mens-watch.webp', 'casio-g1384-gm-b2100gd-9adr-g-shock-mens-watch (1).webp', 'casio-g1384-gm-b2100gd-9adr-g-shock-mens-watch (1).webp', 'casio-g1384-gm-b2100gd-9adr-g-shock-mens-watch (1).webp', 'casio-g1384-gm-b2100gd-9adr-g-shock-mens-watch (1).webp', '80000.00', '', '78000.00', 'product'),
(21, 0, 4, 12, '2024-10-23 10:55:52', 'Casio G-Shock Stainless Steel Bezel', 'Casio G-Shock Stainless Steel Bezel', '71hZWFJTZCL._SX679_.jpg', 'casio-g1413-ga-2100ff-8adr-g-shock-mens-watch.webp', 'casio-g1413-ga-2100ff-8adr-g-shock-mens-watch.webp', 'casio-g1413-ga-2100ff-8adr-g-shock-mens-watch.webp', 'casio-g1413-ga-2100ff-8adr-g-shock-mens-watch.webp', '45000.00', '', '40000.00', 'product'),
(22, 0, 4, 12, '2024-10-23 11:24:53', 'G-Shock Analog Black Dial ', 'G-Shock Analog Black Dial ', 'shopping.webp', 'ae9b2453-6a97-4b73-995c-48859a4e7cf6.ccdcd3b7a1ef75d97dc1cedb0875ee2e.webp', 'ae9b2453-6a97-4b73-995c-48859a4e7cf6.ccdcd3b7a1ef75d97dc1cedb0875ee2e.webp', 'ae9b2453-6a97-4b73-995c-48859a4e7cf6.ccdcd3b7a1ef75d97dc1cedb0875ee2e.webp', 'ae9b2453-6a97-4b73-995c-48859a4e7cf6.ccdcd3b7a1ef75d97dc1cedb0875ee2e.webp', '55000.00', '', '52500.00', 'product'),
(23, 0, 4, 13, '2024-10-23 11:40:55', 'timewear w26', 'timewear w26', '81-lzjdM7fL.jpg', '813oBdk-wgL.jpg', '813oBdk-wgL.jpg', '813oBdk-wgL.jpg', '813oBdk-wgL.jpg', '400.00', '', '350.00', 'product'),
(32, 0, 4, 15, '2024-10-23 12:38:48', 'sonata green forest watch', 'sonata green forest watch', 'shopping (2).webp', 'shopping.webp', 'shopping.webp', 'shopping.webp', 'shopping.webp', '250.00', '\r\n', '200.00', 'product'),
(33, 0, 4, 15, '2024-10-23 12:39:48', 'sonata black stylish watch', 'sonata black stylish watch', '1.webp', 'shopping1.webp', 'shopping1.webp', 'shopping1.webp', 'shopping1.webp', '550.00', '', '450.00', 'product'),
(34, 0, 4, 15, '2024-10-23 12:41:02', 'sonata black', 'sonata black', 'shopping (1)1.webp', 'shopping10.webp', 'shopping10.webp', 'shopping10.webp', 'shopping10.webp', '300.00', '', '200.00', 'product'),
(35, 0, 4, 13, '2024-10-23 12:42:58', 'timewear 365', 'timewear 365', 'shopping12.webp', 'shopping (1)12.webp', 'shopping (1)12.webp', 'shopping (1)12.webp', 'shopping (1)12.webp', '289.00', '', '250.00', 'product'),
(36, 0, 4, 13, '2024-10-23 12:43:50', 'timewear green band watch', 'timewear green band watch', 'shopping19.webp', 'shopping (1)20.webp', 'shopping (1)20.webp', 'shopping (1)20.webp', 'shopping (1)20.webp', '200.00', '', '150.00', 'product'),
(37, 0, 2, 2, '2024-10-23 12:48:09', 'Kenneth cole black stylishly watch', 'Kenneth cole black stylishly watch', 'KCWGR2104204MN_1.webp', 'KCWGR2104204MN_2.webp', 'KCWGR2104204MN_2.webp', 'KCWGR2104204MN_2.webp', 'KCWGR2104204MN_2.webp', '5000.00', '\r\n\r\n', '4500.00', 'product'),
(38, 0, 2, 2, '2024-10-23 12:49:15', 'Kenneth cole leather band watch', 'Kenneth cole leather band watch', 'kenneth-cole-kcwge2220804mn-mens-watch.webp', 'kenneth-cole-kcwge2220804mn-mens-watch (1).webp', 'kenneth-cole-kcwge2220804mn-mens-watch (1).webp', 'kenneth-cole-kcwge2220804mn-mens-watch (1).webp', 'kenneth-cole-kcwge2220804mn-mens-watch (1).webp', '15000.00', '', '13500.00', 'product'),
(39, 0, 2, 2, '2024-10-23 12:50:28', 'Kenneth cole blue casual watch', 'Kenneth cole blue casual watch', 'KCWGI0027104MN_1.webp', 'KCWGI0027104MN_4.webp', 'KCWGI0027104MN_4.webp', 'KCWGI0027104MN_4.webp', 'KCWGI0027104MN_4.webp', '18999.00', '', '16500.00', 'product'),
(40, 0, 2, 5, '2024-10-23 12:51:27', 'titan brown band watch', 'titan brown band watch', '90145WL01_3.webp', '90145WL01_1.jpg', '90145WL01_1.jpg', '90145WL01_1.jpg', '90145WL01_1.jpg', '8000.00', '', '6500.00', 'product'),
(41, 0, 2, 5, '2024-10-23 12:52:43', 'titan silver mettle watch', 'titan silver mettle watch', '10009KM01_3.webp', '8905631887537_4.JPG', '8905631887537_4.JPG', '8905631887537_4.JPG', '8905631887537_4.JPG', '6000.00', '', '54999.00', 'product'),
(42, 0, 2, 5, '2024-10-23 12:53:48', 'titan leather stylishly watch', 'titan leather stylishly watch', '90110WL04_1.webp', '90110WL04_3.webp', '90110WL04_3.webp', '90110WL04_3.webp', '90110WL04_3.webp', '13999.00', '\r\n', '10500.00', 'product'),
(43, 0, 2, 14, '2024-10-23 12:56:07', 'fastrack stylish watch', 'fastrack stylish watch', 'shopping123.webp', 'shopping (1)123.webp', 'shopping (1)123.webp', 'shopping (1)123.webp', 'shopping (1)123.webp', '1500.00', '', '1100.00', 'product'),
(44, 0, 2, 14, '2024-10-23 12:57:12', 'fastrack dark brown watch', 'fastrack dark brown watch', 'shopping (2)1234.webp', 'shopping1234.webp', 'shopping1234.webp', 'shopping1234.webp', 'shopping1234.webp', '3500.00', '', '3000.00', 'product'),
(45, 0, 2, 14, '2024-10-23 12:58:11', 'fastrack luxury mettle watch', 'fastrack luxury mettle watch', 'shopping (1)1111.webp', 'shopping1111.webp', 'shopping1111.webp', 'shopping1111.webp', 'shopping1111.webp', '12500.00', '', '10500.00', 'product');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
