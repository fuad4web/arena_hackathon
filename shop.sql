-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250718.d42db65a1e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 21, 2026 at 09:16 PM
-- Server version: 9.4.0-commercial
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int NOT NULL,
  `branch_name` varchar(100) DEFAULT NULL,
  `branch_slug` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_name`, `branch_slug`, `created_at`) VALUES
(1, 'Ilupeju Agoowoye', 'ilupeju-agoowoye', '2023-12-27 13:19:27'),
(2, 'Fuskydon Badoo', 'fuskydon-badoo', '2023-12-27 13:50:48'),
(3, 'Ikeja Branch', 'ikeja-branch', '2025-12-27 03:57:12');

-- --------------------------------------------------------

--
-- Table structure for table `company_settings`
--

CREATE TABLE `company_settings` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sales_price_edit` enum('editable','uneditable') NOT NULL DEFAULT 'uneditable',
  `address` text,
  `currency` varchar(10) NOT NULL DEFAULT '',
  `vat` decimal(12,2) NOT NULL DEFAULT '0.00',
  `receipt_footer` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `company_settings`
--

INSERT INTO `company_settings` (`id`, `name`, `phone_no`, `email`, `sales_price_edit`, `address`, `currency`, `vat`, `receipt_footer`) VALUES
(1, 'Mailop', '08062202161, 08056958222', 'support@ohakings.com', 'editable', 'Opp. BSU', 'NGN', 3.40, 'Get the fuck off and don&#039;t ever come here again!!!');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `branch_id` int DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `status` enum('regular','special') NOT NULL DEFAULT 'regular',
  `phone_number` varchar(100) DEFAULT NULL,
  `address` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `branch_id`, `name`, `status`, `phone_number`, `address`) VALUES
(1, 1, 'Abdulhammed Fuad', 'regular', '07067752068', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(2, 1, 'Abdulhammed Fuad', 'regular', '07067752099', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(3, 1, 'Akojie Erewe', 'regular', '08099887754', 'Koyemi'),
(4, 1, 'Yummy', 'special', '08098564232', 'Bajebaje'),
(5, 1, 'Abdulhammed Fuad', 'regular', '09000443333', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(6, 2, 'Abdulhammed Fuad', 'regular', '8968775567476', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(7, 1, 'mandira', 'regular', '57637678765', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(8, 2, 'Abdulhammed Fuad', 'regular', '059000553222', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(9, 1, 'Abdulhammed Fuad', 'special', '89978543567', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State'),
(10, 2, 'Onaopepo', 'regular', '07067752998', 'lhyurtdrihol'),
(11, 2, 'Raheemah Baby 💕', 'special', '09095432546', 'IY89sdjoekwe'),
(12, 2, 'Convert Roar', 'special', '08077665543', 'I have something to do!'),
(13, 1, 'Friday', 'regular', '09098765434', '19, Kujore Street, Ikeja, Lagos-State.'),
(14, 1, 'SALAM AUTOS', 'regular', '08099887700', '19, Onajirin Street Igbo_olomu, Ikorodu'),
(15, 2, 'Last Customer', 'regular', '07067752092', 'Street'),
(16, 3, 'Fuskydon', 'regular', '09099999990', 'No Address'),
(17, 2, 'Basherah', 'regular', '89978543567', 'No Address');

-- --------------------------------------------------------

--
-- Table structure for table `distributors`
--

CREATE TABLE `distributors` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone_no` varchar(14) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `distributors`
--

INSERT INTO `distributors` (`id`, `name`, `phone_no`, `email`, `address`, `created_at`) VALUES
(1, 'OLAITAN WHOLESALES LTD', '08142617702', 'modeenah@GMAIL.COM', 'NO 29,ADABI STRT,IBD', '2022-11-29 22:00:15'),
(2, 'SARAH WISE', '081', 'sondefathia@gmail.com', 'lagos', '2022-12-11 05:54:28'),
(3, 'socculet', '081', 'sondefathia@gmail.com', 'ore', '2022-12-11 05:54:56'),
(4, 'MC', '081', 'sondefathia@gmail.com', 'ORE', '2022-12-11 05:55:33'),
(5, 'MUM COKE', '081', 'sondefathia@gmail.com', 'SABO', '2022-12-11 05:56:03'),
(6, 'FEAR GOD', '081', 'sondefathia@gmail.com', 'SABO', '2022-12-11 06:01:12'),
(7, 'KC', '081', 'KC@gmail.com', 'ORE', '2022-12-11 06:02:01'),
(8, 'MONDAY COKE', '081', 'monday@gmail.com', 'ore', '2022-12-11 06:03:17'),
(9, 'CHUKWUMA', '08125053921', 'chukwuma@gmail.com', 'sabo', '2022-12-11 06:28:37'),
(10, 'GOD BLESS', '08038274046', 'godbless@gmail.com', 'ORE', '2022-12-11 06:29:39'),
(11, 'MOBILITY', '07030973885', 'EKEVENTURE@YAHOO.COM', 'LOAGOS ISLAND', '2022-12-11 06:31:08'),
(12, 'W.I. ONYEMA', '081', 'ONYEMA@GMAIKL.COM', 'SABO', '2022-12-11 07:57:18'),
(13, 'Abdulhammed', '09099888800', 'zf6454@gmail.com', '19, Onajirin Street, Igbo-Olomu, Ikorodu, Lagos State', '2024-09-23 14:57:28'),
(14, 'Fuad', '09099887766', 'fuad@gmail.com', 'Fuad location', '2024-12-19 12:09:16'),
(15, 'Friday', '09099887766', 'salam@gmail.com', 'Address', '2025-12-30 16:19:54');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `exp_branch_id` int DEFAULT NULL,
  `purpose` varchar(100) DEFAULT NULL,
  `amount` decimal(50,2) NOT NULL DEFAULT '0.00',
  `remarks` text,
  `created_at` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `user_id`, `exp_branch_id`, `purpose`, `amount`, `remarks`, `created_at`) VALUES
(1, 16, 1, 'Food', 5000.00, 'Hkweowe sdue erihwe eriwerh erjkher erherio rihweio lsdihios weilwehoiw sdklhai jh klhw silja', '2025-01-21'),
(2, 12, 2, 'Slippers', 8000.00, 'I don&#039;t even undestand', '2025-01-23'),
(3, 12, 2, 'Slippers', 500.00, 'Ko Nssary', '2025-07-24'),
(4, 12, 2, 'Slippers', 87.00, 'klhioh', '2025-07-24'),
(5, 12, 2, 'Food', 300.00, 'kloiqw', '2025-07-24'),
(6, 12, 2, 'Slippers', 600.00, 'For Toilet', '2025-08-31'),
(7, 12, 2, 'Food', 3400.00, 'We bought Food Stuffs', '2025-12-27'),
(11, 12, 2, 'wkljkqw', 70.00, 'sdklhsi', '2025-12-29'),
(12, 12, 3, 'Bash', 55.00, 'awser', '2025-12-30');

-- --------------------------------------------------------

--
-- Table structure for table `market_products`
--

CREATE TABLE `market_products` (
  `id` int NOT NULL,
  `branch_id` int DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `barcode` varchar(25) DEFAULT NULL,
  `price` decimal(50,2) DEFAULT '0.00',
  `code` varchar(10) DEFAULT NULL,
  `quantity` decimal(20,10) NOT NULL DEFAULT '0.0000000000',
  `category` int DEFAULT NULL,
  `distributor` int DEFAULT NULL,
  `product_pics` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg',
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `market_products`
--

INSERT INTO `market_products` (`id`, `branch_id`, `name`, `barcode`, `price`, `code`, `quantity`, `category`, `distributor`, `product_pics`, `description`, `created_at`) VALUES
(1, 1, 'Ayoofe Muqodas', NULL, 349.00, '7uz90', 89.0000000000, 7, 7, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2023-02-03 04:11:10'),
(2, 2, 'Last Product Seh', '123456', 8200.00, 'w83y;', 22.0000000000, 5, 5, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1727588999/khlscorrpffaa2xr5lzq.jpg', '', '2024-09-29 06:50:00'),
(3, 2, 'iPhone 16', '', 2200000.00, 'j#28i', 0.0000000000, 11, 13, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1733827297/ezcuvopsv6heuroevphc.jpg', '', '2024-12-10 11:41:17'),
(4, 2, 'Adeyemi Aishat', '', 8500.00, '%249e', 90.0000000000, 4, 6, '74897609.png', '', '2024-12-23 15:27:07'),
(5, 2, 'Adeyemi Aishat', '', 8500.00, 'kjyeh', 90.0000000000, 6, 4, 'productImage/80698359.png', '', '2024-12-23 15:29:09'),
(6, 2, 'Standard Room', '', 9876.00, 'k#jdf', 90.0000000000, 6, 5, 'productImage/50206995.png', '', '2024-12-23 15:33:07'),
(7, 2, 'Latest Property', '', 67687.00, 'Mev3x', 78.0000000000, 3, 4, 'productImage/76259786.png', '', '2024-12-23 15:35:00'),
(8, 2, 'Tremblant In Canada', '897653w4rty', 876564.00, 'oxu8i', 90.0000000000, 3, 2, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1734995107/mfogji6wkachell5yawh.jpg', '', '2024-12-23 17:09:01'),
(9, 2, 'yuiytr', '78675734356', 5678.00, 'jz35)', 90.0000000000, 3, 3, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2024-12-23 17:15:24'),
(10, 2, 'iodfuioerwe', '', 8675.00, 'owl3h', 8.0000000000, 3, 2, 'productImage//94305241.png', '', '2024-12-23 17:16:25'),
(11, 2, 'Hioioe', '', 867.00, 'upedY', 8.0000000000, 3, 1, 'productImage/33311939.png', '', '2024-12-23 17:27:44'),
(12, 1, 'ioytur', '', 786.00, 'kyrjp', 5.0000000000, 3, 2, 'productImage/30484468.png', '', '2024-12-23 17:29:21'),
(13, 2, 'uiyiuopo', '', 8900.00, 'u89uo', 94.0000000000, 2, 4, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2024-12-23 17:32:46'),
(14, 2, 'Mixture', NULL, 3500.00, '24rdx', 8.0000000000, 11, 14, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-27 22:46:25'),
(15, 2, 'Omituntun', '', 980.00, '6h4m9', 20.0000000000, 2, 4, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 05:41:30'),
(16, 2, 'Ejatuntun', '', 2200.00, '1n7le', 25.0000000000, 5, 7, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 05:43:15'),
(17, 2, 'ShiShi', '', 2333.00, 'k30wu', 42.0000000000, 2, 8, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1756651606/wgs49j3gmaoyxb2xkgjy.png', '', '2025-08-31 07:46:47'),
(18, 2, 'ShiSdfsd', '', 2333.00, 'qje79', 56.0000000000, 2, 3, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 07:48:11'),
(19, 2, 'srerr', '', 33434.00, 'e5mw9', 43.0000000000, 3, 3, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 07:49:40'),
(20, 2, 'Coca-Cola (Crate)', 'sdfghjkgfds', 3000.00, '66361', 97.0000000000, 6, 5, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1758711547/czuishqxvdpyytsjwn3l.jpg', 'sdghuytrewq', '2025-08-31 07:50:46'),
(21, 2, 'Fanta Crate', '', 11500.00, 'n07wm', 3.0000000000, 1, 14, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-09-24 02:57:46'),
(22, 2, 'Career Book 1', 'kytr56er7tuh', 2300.00, 'ele7a', 50.0000000000, 2, 8, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1764318765/up0vgtu8x6af3lnbal48.jpg', 'Tis is a book for Career students, students that are serious with thier Career and know what theywanna do with thier Lufe, students that are very straight forward and doesn&#039;t takle what they shouldn&#039;t', '2025-11-28 00:32:46'),
(23, 2, 'Rara Product', '', 2400.00, '1591gwlib', 1.0000000000, 1, 4, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1766401484/dnjfavldzfbd87fgel0p.jpg', 'No need for description now', '2025-12-22 03:04:44'),
(24, 2, 'Peak Milk', '', 200.00, 'iq9bj69qs', 20.0000000000, 11, 1, 'productImage/70049203.png', 'This is a Peak Milk product of 20 Packs as we can see but it has 12 quantities in each packs so we can sell by pack or by quantity as we wish and we can also sell it by saying 3 and half packs and so on', '2025-12-27 03:56:44');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `product_id` bigint DEFAULT NULL,
  `checked` varchar(100) DEFAULT 'unread',
  `notify_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `product_id`, `checked`, `notify_date`) VALUES
(1, 74, 'unread', '2024-01-08 07:07:47'),
(2, 73, 'unread', '2024-01-08 07:07:47');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int NOT NULL,
  `page_name` varchar(200) DEFAULT NULL,
  `route` varchar(200) DEFAULT NULL,
  `sub_menu` int DEFAULT NULL,
  `status` enum('page','function') DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `page_name`, `route`, `sub_menu`, `status`, `created_at`) VALUES
(1, 'Settings', 'nill', NULL, 'page', '2025-01-18 07:25:19'),
(2, 'Settings', 'settings', 1, 'page', '2025-01-18 07:25:19'),
(3, 'Dashboard', 'nill', NULL, 'page', '2025-01-18 14:37:32'),
(4, 'Dashboard', 'admin_dashboard', 3, 'page', '2025-01-18 14:37:32'),
(5, 'Sales', 'nill', NULL, 'page', '2025-01-18 14:42:43'),
(6, 'Sales', 'orders', 5, 'page', '2025-01-18 14:42:43'),
(7, 'List My Ordered Products', 'ordered_products', 5, 'page', '2025-01-18 14:42:43'),
(8, 'List All Ordered Products', 'allordered_products', 5, 'page', '2025-01-18 14:42:43'),
(9, 'Report Page', 'record', 5, 'page', '2025-01-18 14:42:43'),
(10, 'Creditors', 'creditors', 5, 'page', '2025-01-18 14:42:43'),
(11, 'Products', 'nill', NULL, 'page', '2025-01-18 14:46:18'),
(12, 'List Product(s)', 'product', 11, 'page', '2025-01-18 14:46:18'),
(13, 'Create New Product', 'create_product', 11, 'page', '2025-01-18 14:46:18'),
(14, 'Wholesale Products', 'nill', NULL, 'page', '2025-01-18 14:47:26'),
(15, 'List market Product(s)', 'market_product', 14, 'page', '2025-01-18 14:47:26'),
(16, 'Product Categories', 'nill', NULL, 'page', '2025-01-18 14:49:27'),
(17, 'List Categories', 'category', 16, 'page', '2025-01-18 14:49:27'),
(18, 'Create New Category', 'create_category', 16, 'page', '2025-01-18 14:49:27'),
(19, 'Company Branches', 'nill', NULL, 'page', '2025-01-18 14:51:05'),
(20, 'List Branches', 'branch', 19, 'page', '2025-01-18 14:51:05'),
(21, 'Create New Branch', 'create_branch', 19, 'page', '2025-01-18 14:51:05'),
(22, 'Distributor Companies', 'nill', NULL, 'page', '2025-01-18 14:52:48'),
(23, 'List Distributors', 'distributor', 22, 'page', '2025-01-18 14:52:48'),
(24, 'Create New Distributor', 'create_distributor', 22, 'page', '2025-01-18 14:52:48'),
(25, 'Staff Members', 'nill', NULL, 'page', '2025-01-18 14:54:22'),
(26, 'Staff Members', 'staffs', 25, 'page', '2025-01-18 14:54:22'),
(27, 'Admins', 'admins', 25, 'page', '2025-01-18 14:54:22'),
(28, 'Registration Page', 'register', 25, 'page', '2025-01-18 14:54:22'),
(29, 'List of Customers', 'nill', NULL, 'page', '2025-01-18 14:55:33'),
(30, 'Customers', 'customers', 29, 'page', '2025-01-18 14:55:33'),
(31, 'Company Settings', 'nill', NULL, 'page', '2025-01-18 14:56:41'),
(32, 'Settings', 'settings', 31, 'page', '2025-01-18 14:56:41'),
(33, 'Transfer Products', 'nill', NULL, 'page', '2025-01-18 14:57:55'),
(34, 'Transfer Product(s)', 'transfer_product', 33, 'page', '2025-01-18 14:57:55'),
(35, 'Return Products', 'nill', NULL, 'page', '2025-01-18 14:59:23'),
(36, 'Return Product', 'return_product', 35, 'page', '2025-01-18 14:59:23'),
(37, 'List Products returned', 'products_return', 35, 'page', '2025-01-18 14:59:23'),
(38, 'Profile', 'nill', NULL, 'page', '2025-01-18 15:00:24'),
(39, 'Profile', 'profile', 38, 'page', '2025-01-18 15:00:24'),
(40, 'Expenses', 'expenses', 5, 'page', '2025-01-19 14:50:32'),
(41, 'Delete Product', 'delete_product', 11, 'function', '2025-01-20 11:54:55'),
(42, 'Update Product', 'update_product', 11, 'function', '2025-01-20 11:54:55'),
(43, 'Delete Category', 'delete_category', 16, 'function', '2025-01-20 12:07:56'),
(44, 'Update Category', 'update_category', 16, 'function', '2025-01-20 12:07:56'),
(45, 'Delete Branch', 'delete_branch', 19, 'function', '2025-01-20 12:18:50'),
(46, 'Update Branch', 'update_branch', 19, 'function', '2025-01-20 12:18:50'),
(47, 'Delete Distributor', 'delete_distributor', 22, 'function', '2025-01-20 12:23:00'),
(48, 'Update Distributor', 'update_distributor', 22, 'function', '2025-01-20 12:23:00'),
(49, 'Delete Member', 'delete_member', 25, 'function', '2025-01-20 12:30:47'),
(50, 'Activate/Deactivate Member', 'access', 25, 'function', '2025-01-20 12:30:47'),
(51, 'Page Access', 'edit_page', 25, 'function', '2025-01-20 12:30:47'),
(53, 'Swap', 'nill', NULL, 'page', '2025-01-18 14:42:43'),
(54, 'Swap', 'swap', 53, 'page', '2025-01-18 14:42:43'),
(55, 'List Swap(s)', 'swaps_list', 53, 'page', '2025-01-18 14:42:43');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `branch_id` int DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `barcode` varchar(25) DEFAULT NULL,
  `price` decimal(30,2) DEFAULT '0.00',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `special_price` decimal(30,2) DEFAULT '0.00',
  `status` tinyint DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `quantity` decimal(20,10) NOT NULL DEFAULT '0.0000000000',
  `is_pack` int DEFAULT NULL,
  `pack_size` int DEFAULT NULL,
  `category` int DEFAULT NULL,
  `distributor` int DEFAULT NULL,
  `product_pics` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg',
  `description` text,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `branch_id`, `name`, `barcode`, `price`, `market_price`, `special_price`, `status`, `code`, `quantity`, `is_pack`, `pack_size`, `category`, `distributor`, `product_pics`, `description`, `created_at`) VALUES
(72, 1, 'Soft Drinks', '976435534232344', 2726.00, 0.00, 0.00, 1, 'rjhxy', 283.0000000000, NULL, NULL, 4, 7, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2022-12-20 15:55:30'),
(73, 2, 'Mouse', '', 700.99, 0.00, 0.00, 0, 'w7s6g', -3.0000000000, NULL, NULL, 4, 5, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2022-12-20 15:56:23'),
(74, 1, 'Soft Drinks 23', '787453423478', 900.00, 0.00, 0.00, 0, 'djunv', 19.0000000000, NULL, NULL, 5, 6, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2023-02-03 04:03:35'),
(75, 1, 'Odunayo', '79865324thj', 90000.00, 0.00, 0.00, 1, 'sy0l2', 90.0000000000, NULL, NULL, 5, 4, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1732878646/ootneqkl1vnliccsqmdx.jpg', 'I should add preview to this updating of products page', '2023-12-25 13:23:28'),
(77, 2, 'samsung', NULL, 90000.00, 0.00, 0.00, 0, '97!4j', 0.0000000000, NULL, NULL, 11, 11, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2024-01-11 19:45:30'),
(78, 1, 'Aso Oke', '98463378', 5000.00, 0.00, 0.00, 0, 'id9dk', 0.0000000000, NULL, NULL, 9, 4, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1726996413/vvdz6z6awmpunbazliar.jpg', 'I just love this...', '2024-09-22 10:13:34'),
(79, 2, 'Ramoni ni Seh!', '09787896653', 5600.00, 0.00, 5200.00, 0, '8nhhw', 2.0000000000, NULL, NULL, 5, 4, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1732878501/xzu9vxv2bkwsk581mrlf.jpg', 'Who be that? Is like tis is not a product but a company logo.', '2024-09-29 06:42:24'),
(80, 1, 'Rahtip', '7865869753', 4000.00, 0.00, 0.00, 0, 'i$7i2', 90.0000000000, NULL, NULL, 2, 8, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1727588868/q3xde1hlyzbfbs1ewcjc.png', 'Yirhe erioujowe', '2024-09-29 06:47:49'),
(81, 2, 'Last Product Seh', '1239099', 10000.00, 0.00, 9500.00, 0, 'w83y;', 22.0000000000, NULL, NULL, 8, 5, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1727588999/khlscorrpffaa2xr5lzq.jpg', 'No word to say on it', '2024-09-29 06:50:00'),
(83, 1, 'Ramoni ni Seh!', '09787896653', 5600.00, 0.00, 5200.00, 0, '8nhhw', 38.0000000000, NULL, NULL, 5, 4, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1732878501/xzu9vxv2bkwsk581mrlf.jpg', 'Who be that? Is like tis is not a product but a company logo.', '2024-12-07 08:49:36'),
(84, 2, 'iPhone 16', '', 2500000.00, 0.00, 2450000.00, 0, 'j#28i', 0.0000000000, NULL, NULL, 11, 13, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1733827297/ezcuvopsv6heuroevphc.jpg', '', '2024-12-10 11:41:17'),
(85, 1, 'iPhone 16', '', 2700000.00, 0.00, 2650000.00, 0, 'j#28i', 2.0000000000, NULL, NULL, 11, 13, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1733827297/ezcuvopsv6heuroevphc.jpg', '', '2024-12-10 11:56:21'),
(90, 2, 'Tremblant In Canada', '897653w4rty', 89765.00, 0.00, 89765.00, 0, 'oxu8i', 70.0000000000, NULL, NULL, 3, 2, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1734995107/mfogji6wkachell5yawh.jpg', '', '2024-12-23 17:09:01'),
(91, 2, 'yuiytr', '78675734356', 6789.00, 0.00, 675.00, 0, 'jz35)', 90.0000000000, NULL, NULL, 3, 3, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2024-12-23 17:15:24'),
(94, 1, 'ioytur', '', 8976.00, 0.00, 7867.00, 0, 'kyrjp', 5.0000000000, NULL, NULL, 3, 2, 'productImage/30484468.png', '', '2024-12-23 17:29:21'),
(95, 2, 'uiyiuopo', '', 900.00, 0.00, 67.00, 0, 'u89uo', 88.0000000000, NULL, NULL, 2, 4, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2024-12-23 17:32:46'),
(96, 2, 'Mixture', NULL, 4000.00, 0.00, 3800.00, 0, '24rdx', 8.6133000000, 1, 12, 11, 14, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-27 22:46:25'),
(97, 2, 'Omituntun', '', 1000.00, 0.00, 990.00, 0, '6h4m9', 19.0000000000, 0, NULL, 2, 4, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 05:41:30'),
(98, 2, 'Ejatuntun', '', 2500.00, 2300.00, 2350.00, 0, '1n7le', 25.9700000000, 1, 100, 5, 7, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 05:43:15'),
(99, 2, 'ShiShi', 'eerty6554', 3332.00, 3150.00, 3200.00, 0, 'k30wu', 45.0000000000, 0, 0, 10, 8, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1756651606/wgs49j3gmaoyxb2xkgjy.png', 'This is Shi-Shi Product', '2025-08-31 07:46:47'),
(100, 2, 'ShiSdfsd', '', 3332.00, 0.00, 2233.00, 0, 'qje79', 56.0000000000, 1, 43, 2, 3, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 07:48:11'),
(101, 2, 'srerr', '', 55545.00, 0.00, 4344.00, 0, 'e5mw9', 44.0000000000, 0, NULL, 3, 3, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-08-31 07:49:40'),
(102, 2, 'Coca-Cola (Crate)', 'sdfghjkgfds', 4000.00, 3000.00, 5000.00, 0, '66361', 97.9167000000, 1, 20, 6, 5, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1758711547/czuishqxvdpyytsjwn3l.jpg', 'Cocacola Description', '2025-08-31 07:50:46'),
(103, 2, 'Fanta Crate', '', 12000.00, 11500.00, 11100.00, 0, 'n07wm', 0.8750000000, 1, 24, 1, 14, 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '', '2025-09-24 02:57:45'),
(104, 2, 'Career Book 1', 'kytr56er7tuh', 2500.00, 2300.00, 2400.00, 0, 'ele7a', 48.0000000000, 0, NULL, 2, 8, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1764318765/up0vgtu8x6af3lnbal48.jpg', 'Tis is a book for Career students, students that are serious with thier Career and know what theywanna do with thier Lufe, students that are very straight forward and doesn&#039;t takle what they shouldn&#039;t', '2025-11-28 00:32:46'),
(105, 1, 'Last Product Seh', '1239099', 10000.00, 0.00, 0.00, 0, 'w83y;', 3.0000000000, NULL, NULL, 8, 5, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1727588999/khlscorrpffaa2xr5lzq.jpg', 'No word to say on it', '2025-11-28 00:48:14'),
(106, 1, 'ShiShi', '', 3332.00, 0.00, 0.00, 0, 'k30wu', 7.0000000000, NULL, NULL, 2, 8, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1756651606/wgs49j3gmaoyxb2xkgjy.png', '', '2025-11-29 01:24:15'),
(107, 1, 'Tremblant In Canada', '897653w4rty', 89765.00, 0.00, 0.00, 0, 'm39fwty03', 20.0000000000, NULL, NULL, 3, 2, 'https://res.cloudinary.com/do9whlpl9/image/upload/v1734995107/mfogji6wkachell5yawh.jpg', '', '2025-12-15 06:47:22'),
(108, 2, 'Rara Product', '', 2500.00, 2400.00, 2300.00, 0, '1591gwlib', 1.0000000000, 1, 6, 1, 4, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1766401484/dnjfavldzfbd87fgel0p.jpg', 'No need for description now', '2025-12-22 03:04:44'),
(109, 2, 'Peak Milk', '', 250.00, 250.00, 235.00, 0, 'iq9bj69qs', 19.0000000000, 1, 12, 11, 1, 'productImage/70049203.png', 'This is a Peak Milk product of 20 Packs as we can see but it has 12 quantities in each packs so we can sell by pack or by quantity as we wish and we can also sell it by saying 3 and half packs and so on', '2025-12-27 03:56:44'),
(110, 3, 'Coca-Cola (Crate)', 'sdfghjkgfds', 4000.00, 3500.00, 3700.00, 0, '873w8gi2r', 3.0000000000, 0, 0, 6, 5, 'productImage/70414444.png', 'Cocacola Description', '2025-12-27 04:00:23'),
(111, 1, 'Coca-Cola (Crate)', 'sdfghjkgfds', 4000.00, 0.00, 0.00, 0, '6yo0h5md8', 2.0000000000, NULL, NULL, 6, 5, 'https://res.cloudinary.com/dodl3q3vr/image/upload/v1758711547/czuishqxvdpyytsjwn3l.jpg', 'Cocacola Description', '2025-12-30 01:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `code` varchar(7) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `name`, `code`, `created_at`) VALUES
(1, 'SOFT DRINK', '3w10l9h', '2022-11-29 22:03:21'),
(2, 'PERISHABLE GOODS', 'o873jy1', '2022-11-29 22:03:48'),
(3, 'SOAP', 'og3ipd5', '2022-12-11 05:32:19'),
(4, 'drug', '2dx78z3', '2022-12-11 05:44:59'),
(5, 'detergent', 'r3l79gm', '2022-12-11 05:45:45'),
(6, 'Alcoholic', 'uspe0zm', '2022-12-11 05:57:30'),
(7, 'beverages', '8tavjmq', '2022-12-11 06:37:38'),
(8, 'food stuff', 'rfown7t', '2022-12-11 06:38:02'),
(9, 'wine', '7xgezwa', '2022-12-11 06:38:11'),
(10, 'TOOTHPASTE', 'ly29oxs', '2022-12-11 07:01:35'),
(11, 'PROVISION', 'i0j3yko', '2022-12-11 07:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `product_purchase`
--

CREATE TABLE `product_purchase` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `branch_id` bigint DEFAULT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `price_type` enum('regular','special','market') CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'regular',
  `customer_id` bigint DEFAULT NULL,
  `quantity` varchar(255) DEFAULT NULL,
  `total_price` varchar(255) DEFAULT NULL,
  `vat` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_mode` varchar(10) DEFAULT NULL,
  `credit` varchar(100) NOT NULL DEFAULT '0',
  `grand_total` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `trans_code` varchar(20) DEFAULT NULL,
  `additional_info` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product_purchase`
--

INSERT INTO `product_purchase` (`id`, `user_id`, `branch_id`, `product_id`, `price_type`, `customer_id`, `quantity`, `total_price`, `vat`, `payment_mode`, `credit`, `grand_total`, `trans_code`, `additional_info`, `created_at`) VALUES
(1, 10, 1, '1', 'regular', 3, '11', '2750', 0.00, 'cash', '0', '2750', '355G152', NULL, '2022-11-30 20:13:03'),
(2, 10, 1, '1', 'regular', 3, '5', '1250', 0.00, 'cash', '0', '1250', 'L2068JK', NULL, '2022-11-30 20:14:19'),
(3, 10, 1, '2', 'regular', 3, '5', '2500', 0.00, 'cheque', '0', '2500', 'G1Y4783', NULL, '2022-11-30 20:15:33'),
(4, 10, 1, '3', 'regular', 3, '76', '102600', 0.00, 'cheque', '0', '102600', '8035228', NULL, '2022-12-02 06:38:05'),
(5, 10, 1, '3,5', 'regular', 3, '12,2', '16200,1356', 0.00, 'transfer', '0', '17556', '2032HD7', NULL, '2022-12-02 06:43:05'),
(6, 10, 1, '5,1', 'regular', 3, '1,1', '678,250', 0.00, 'cash', '0', '928', 'YV87A87', NULL, '2022-12-02 06:44:15'),
(7, 10, 1, '5,4,3', 'regular', 3, '4,2,3', '2712,600,4050', 0.00, 'cash', '0', '7362', '73H35LV', NULL, '2022-12-02 21:09:41'),
(8, 10, 1, '1', 'regular', 3, '10', '2500', 0.00, 'transfer', '0', '2500', 'T3KC8W6', NULL, '2022-12-02 21:20:50'),
(9, 10, 1, '2', 'regular', 3, '5', '2500', 0.00, 'cheque', '0', '2500', '32Q7729', NULL, '2022-12-02 21:46:38'),
(10, 10, 1, '4', 'regular', 4, '10', '3000', 0.00, 'cash', '0', '3000', '6837D68', NULL, '2022-12-02 22:02:10'),
(11, 10, 1, '3', 'regular', 3, '10', '13500', 0.00, 'transfer', '0', '13500', '381I789', NULL, '2022-12-06 05:34:16'),
(12, 10, 1, '1,2,5', 'regular', 3, '10,11,12', '2500,5500,8136', 0.00, 'cash', '0', '16136', 'D867R2F', NULL, '2022-12-06 05:35:56'),
(13, 10, 1, '4,3', 'regular', 3, '8,3', '2400,4050', 0.00, 'cash', '0', '6450', 'G04FRZ4', NULL, '2022-12-09 08:22:06'),
(14, 11, 1, '4', 'regular', 3, '10', '3000', 0.00, 'cash', '0', '3000', 'GSS13D7', NULL, '2022-12-10 08:07:02'),
(15, 11, 1, '3', 'regular', 2, '13', '17550', 0.00, 'cash', '0', '17550', 'B7832A3', NULL, '2022-12-10 08:07:39'),
(16, 11, 1, '5,4,1,3,2', 'regular', 3, '1,1,10,1,10', '678,300,2500,1350,5000', 0.00, 'cash', '0', '9828', '712234J', NULL, '2022-12-10 08:10:17'),
(17, 10, 1, '4', 'regular', 3, '10', '3000', 0.00, 'cash', '0', '3000', '6OWDTL5', NULL, '2022-12-10 22:40:00'),
(18, 12, 1, '6', 'regular', 1, '2', '3100', 0.00, 'transfer', '0', '3100', 'Q2383SD', NULL, '2022-12-11 05:27:02'),
(19, 12, 1, '22,23,26', 'regular', 3, '1,1,1', '650,640,380', 0.00, 'cash', '0', '1670', '68B3273', NULL, '2022-12-11 07:20:25'),
(22, 13, 1, '73,72', 'regular', 3, '2,7', '1401.98,19082', 0.00, 'transfer', '0', '20483.98', '343L29Z', NULL, '2023-02-03 03:53:13'),
(23, 12, 1, '74', 'regular', 3, '5', '4500', 0.00, 'transfer', '0', '4500', '53S373J', NULL, '2023-02-03 04:04:10'),
(24, 14, 1, '73,72', 'regular', 3, '3,2', '2102.97,5452', 0.00, 'transfer', '0', '7554.97', '1XA7549', NULL, '2023-12-06 20:32:25'),
(25, 12, 1, '74', 'regular', 3, '2', '1800', 0.00, 'creditor', '550', '1800', '87C3820', NULL, '2023-12-13 10:34:40'),
(26, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'creditor', '265.99', '700.99', '3SD873S', NULL, '2023-12-13 10:37:34'),
(27, 12, 1, '73', 'regular', 3, '4', '2803.96', 0.00, 'cash', '0', '2803.96', 'V7F833W', NULL, '2024-01-07 20:58:10'),
(28, 12, 1, '73', 'regular', 3, '2', '1401.98', 0.00, 'cash', '', '1401.98', '4DP32D6', NULL, '2024-01-07 21:00:40'),
(29, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'transfer', '', '900', 'LZ39NVO', NULL, '2024-01-07 21:01:33'),
(30, 12, 1, '76', 'regular', 3, '4', '18000', 0.00, 'cash', '', '18000', '5PJT553', NULL, '2024-01-11 13:37:00'),
(31, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '', '700.99', '98T6252', NULL, '2024-01-11 13:43:38'),
(32, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '', '700.99', '34OGZ40', NULL, '2024-01-11 13:45:22'),
(33, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '', '700.99', 'F3GH7B9', NULL, '2024-01-11 13:45:51'),
(34, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '', '700.99', '0G33S48', NULL, '2024-01-11 13:46:04'),
(35, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '', '700.99', '3S638Z2', NULL, '2024-01-11 13:47:11'),
(36, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '0', '700.99', 'V4857Z8', NULL, '2024-01-11 13:48:58'),
(37, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '0', '700.99', 'G636DYG', NULL, '2024-01-11 13:49:50'),
(38, 12, 1, '75', 'regular', 3, '2', '800000', 0.00, 'cash', '0', '800000', 'DW0G2BF', NULL, '2024-01-11 13:51:11'),
(39, 12, 1, '77', 'regular', 3, '3', '270000', 0.00, 'transfer', '0', '270000', '7V22IH7', NULL, '2024-01-11 19:46:31'),
(40, 12, 1, '73', 'regular', 3, '1', '700.99', 0.00, 'cash', '0', '700.99', '58ZS5W7', NULL, '2024-01-15 14:34:14'),
(41, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '1OD5683', NULL, '2024-01-15 14:35:20'),
(42, 12, 1, '75', 'regular', 3, '1', '400000', 0.00, 'cash', '0', '400000', 'DJ878S7', NULL, '2024-01-15 14:38:25'),
(43, 12, 1, '76', 'regular', 3, '1', '4500', 0.00, 'cash', '0', '4500', '6R9Q6V2', NULL, '2024-01-15 14:49:38'),
(44, 12, 1, '75', 'regular', 3, '1', '400000', 0.00, 'cash', '0', '400000', '3Y863B7', NULL, '2024-01-15 15:06:16'),
(45, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '25F3389', NULL, '2024-01-15 15:07:10'),
(46, 12, 1, '77', 'regular', 3, '1', '90000', 0.00, 'cash', '0', '90000', '7033432', NULL, '2024-01-15 15:08:03'),
(47, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'TO716S3', NULL, '2024-01-15 15:10:29'),
(48, 15, 1, '77,74', 'regular', 3, '1,3', '90000,2700', 0.00, 'cash', '0', '92700', '02QB572', NULL, '2024-02-17 22:02:29'),
(49, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '7638821', NULL, '2024-09-26 12:31:27'),
(50, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'DBN1321', NULL, '2024-09-26 12:33:09'),
(51, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '207S475', NULL, '2024-09-26 12:33:47'),
(52, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '877X26D', NULL, '2024-09-26 12:34:22'),
(53, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '3S8872C', NULL, '2024-09-26 12:35:17'),
(54, 12, 1, '77', 'regular', 3, '1', '90000', 0.00, 'cash', '0', '90000', '132986S', NULL, '2024-09-26 12:36:00'),
(55, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '032DG88', NULL, '2024-09-26 12:36:24'),
(56, 12, 1, '77', 'regular', 3, '1', '90000', 0.00, 'cash', '0', '90000', '28V32V3', NULL, '2024-09-26 12:37:30'),
(57, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '2SP3036', NULL, '2024-09-26 12:37:53'),
(58, 12, 1, '77', 'regular', 3, '1', '90000', 0.00, 'cash', '0', '90000', '8VDD32S', NULL, '2024-09-26 12:38:52'),
(59, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '718S322', NULL, '2024-09-26 13:21:49'),
(60, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '1RV5937', NULL, '2024-09-26 13:22:55'),
(61, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '0253682', NULL, '2024-09-26 13:26:12'),
(62, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'N9864D5', NULL, '2024-09-26 13:26:23'),
(63, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '6D26342', NULL, '2024-09-26 13:35:30'),
(64, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '64QFA8S', NULL, '2024-09-26 13:37:48'),
(65, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '722825S', NULL, '2024-09-26 13:38:03'),
(66, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '753SC32', NULL, '2024-09-26 13:38:49'),
(67, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '52Q37FR', NULL, '2024-09-26 13:40:51'),
(68, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '773F9JV', NULL, '2024-09-26 13:41:08'),
(69, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'R662734', NULL, '2024-09-26 13:42:21'),
(70, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '53B8357', NULL, '2024-09-26 13:44:02'),
(71, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'L9F74H3', NULL, '2024-09-26 13:45:17'),
(72, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '975353D', NULL, '2024-09-26 13:45:41'),
(73, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '232R3Y7', NULL, '2024-09-26 14:09:30'),
(74, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'transfer', '0', '900', '278Z66J', NULL, '2024-09-27 17:07:44'),
(75, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'H2945GD', NULL, '2024-09-27 17:08:44'),
(76, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '845630N', NULL, '2024-11-27 10:35:59'),
(77, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '6F78S72', NULL, '2024-11-25 17:19:09'),
(78, 12, 2, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '2W8808G', NULL, '2024-11-29 07:22:40'),
(79, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '3277457', NULL, '2024-11-29 07:22:40'),
(80, 12, 2, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '7HC16M3', NULL, '2024-11-29 07:22:40'),
(81, 12, 1, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', '793YQ38', NULL, '2024-11-29 07:22:40'),
(82, 12, 2, '74', 'regular', 3, '1', '900', 0.00, 'cash', '0', '900', 'K5Z9377', NULL, '2024-11-29 07:22:40'),
(83, 12, 2, '79', 'regular', 4, '4', '20000', 0.00, 'cash', '0', '20000', 'B881RDI', NULL, '2024-11-29 07:22:40'),
(84, 12, 1, '81', 'regular', 7, '6', '60000', 0.00, 'cash', '0', '60000', '24J6S99', NULL, '2024-11-29 07:22:40'),
(85, 12, 1, '81', 'regular', 1, '5', '50000', 0.00, 'cash', '0', '50000', '67V3885', NULL, '2024-11-29 07:22:40'),
(86, 12, 2, '81', 'regular', 7, '7', '70000', 0.00, 'cash', '0', '70000', '2582ZJQ', NULL, '2024-11-29 07:22:40'),
(87, 12, 1, '79', 'regular', 10, '3', '15000', 0.00, 'creditor', '12000', '15000', 'E0D12XG', NULL, '2024-11-29 10:54:18'),
(88, 12, 1, '80', 'regular', 10, '3', '1200', 0.00, 'creditor', '350', '1200', '3326236', NULL, '2024-11-29 10:57:22'),
(89, 12, 1, '81', 'regular', 10, '1', '10000', 0.00, 'creditor', '5600', '10000', '6Z4Q6S8', NULL, '2024-11-29 10:59:01'),
(90, 12, 1, '79', 'regular', 10, '2', '10000', 0.00, 'creditor', '1300', '10000', '2D77K51', NULL, '2024-11-29 11:09:04'),
(91, 12, 1, '74', 'regular', 10, '1', '900', 0.00, 'creditor', '560', '900', '2WT37J3', NULL, '2024-11-29 11:12:51'),
(92, 12, 1, '74', 'regular', 10, '1', '900', 0.00, 'creditor', '560', '900', '1RH8W6B', NULL, '2024-11-29 11:13:49'),
(93, 12, 1, '74', 'regular', 10, '1', '900', 0.00, 'cash', '350', '900', '6AQ8537', NULL, '2024-11-29 11:14:21'),
(94, 12, 1, '74', 'regular', 10, '1', '900', 0.00, 'cash', '350', '900', '29Q6M8Z', NULL, '2024-11-29 11:18:26'),
(95, 12, 1, '80', 'regular', 10, '1', '400', 0.00, 'cash', '50', '400', 'VQ92JS7', NULL, '2024-11-29 11:19:28'),
(96, 15, 2, '74', 'regular', 10, '1', '900', 0.00, 'cash', '105', '900', '72FXTSH', NULL, '2024-11-29 11:39:24'),
(97, 15, 2, '81,79', 'regular', 12, '3,2', '30000,11200', 0.00, 'cash', '10200', '41200', '6453W58', NULL, '2024-12-10 11:12:42'),
(98, 12, 1, '74,79', 'regular', 12, '1,5', '900,28000', 0.00, 'cash', '-5500', '28900', 'Z255663', NULL, '2024-12-14 11:54:08'),
(99, 12, 1, '81', 'regular', 11, '1', '10000', 0.00, 'cash', '0', '10000', '704J785', NULL, '2024-12-23 18:57:59'),
(100, 12, 1, '94', 'regular', 4, '1', '8976', 0.00, 'cash', '0', '8976', '3J63722', NULL, '2024-12-23 18:58:34'),
(101, 12, 1, '79,81', 'regular', 11, '2,3', '10400,28500', 0.00, 'cash', '0', '38900', '6Q38874', NULL, '2025-07-31 00:34:25'),
(102, 12, 1, '79,81', 'regular', 12, '3,2', '15600,19000', 0.00, 'cash', '0', '34600', '33763BH', NULL, '2025-07-31 00:36:21'),
(103, 12, 1, '81', 'regular', 12, '1', '9500.00', 0.00, 'cash', '0', '9500', 'YL83AD4', NULL, '2025-07-31 00:41:44'),
(104, 12, 2, '81,79', 'special', 10, '3,4', '28500,20800', 0.00, 'cash', '0', '49300', '726R883', NULL, '2025-07-31 01:07:50'),
(105, 12, 2, '79,81', 'special', 1, '2,1', '10400,9500.00', 0.00, 'transfer', '0', '19900', '9676Z5S', NULL, '2025-07-31 01:13:17'),
(106, 12, 2, '84', 'regular', 11, '1', '2500000.00', 0.00, 'cash', '0', '2500000', '2DR679A', NULL, '2025-08-07 10:09:08'),
(107, 12, 2, '84', 'regular', 11, '1', '2500000.00', 0.00, 'cash', '0', '2500000', '867292J', NULL, '2025-08-07 10:11:43'),
(108, 12, 2, '81', 'special', 11, '1', '9500.00', 0.00, 'cash', '0', '9500', '5625Y65', NULL, '2025-08-07 10:15:26'),
(109, 12, 2, '81', 'market', 11, '1', '8200.00', 0.00, 'cash', '0', '8200', 'VR2W723', NULL, '2025-08-07 10:17:57'),
(110, 12, 2, '95', 'regular', 11, '2', '1800', 0.00, 'transfer', '0', '1800', '374DGU1', NULL, '2025-08-14 10:02:51'),
(111, 12, 2, '84', 'special', 11, '1', '2450000.00', 0.00, 'cash', '0', '2450000', '5T5S77D', NULL, '2025-08-28 23:38:04'),
(112, 12, 2, '81', 'special', 1, '3', '28500', 0.00, 'cash', '0', '28500', 'V856H26', NULL, '2025-08-28 23:50:20'),
(113, 12, 2, '96', 'special', 10, '4|single', '15200.00', 0.00, 'cash', '0', '15200', '1V8464S', NULL, '2025-08-30 03:51:36'),
(114, 12, 2, '81,95', 'special', 3, '2|single,3|single', '20000.00,201.00', 0.00, 'cash', '0', '20201', '5Ct15W5', NULL, '2025-08-30 09:58:04'),
(115, 12, 2, '81,95', 'special', 10, '2|single,3|single', '20000.00,201.00', 0.00, 'cash', '0', '20201', '517K0V7', NULL, '2025-08-30 10:08:22'),
(116, 12, 2, '81,96', 'market', 10, '1|single,2|pack+0|single', '9500.00,7000.00', 0.00, 'cash', '0', '16500', '4t13556', NULL, '2025-08-30 10:34:03'),
(117, 12, 2, '96', 'regular', 10, '2|pack+2|single', '8666.67', 0.00, 'cash', '0', '8666.6666666667', 't3I661Q', NULL, '2025-08-30 10:53:15'),
(118, 12, 2, '81,96', 'market', 3, '1|single,2|pack+3|single', '10000.00,9000.00', 0.00, 'cash', '0', '19000', 'xD1U23P', NULL, '2025-08-30 13:49:23'),
(119, 12, 2, '81,96', 'market', 11, '2|single,1|pack+6|single', '16400.00,5250.00', 0.00, 'cash', '0', '21650', '311CxW5', NULL, '2025-08-30 13:55:17'),
(120, 12, 2, '96', 'special', 1, '3|pack+8|single', '13933.33', 0.00, 'cash', '0', '13933.33', '12UN5HA', NULL, '2025-08-30 13:58:47'),
(121, 12, 2, '96', 'market', 10, '0|pack+6|single', '1750.00', 0.00, 'cheque', '0', '1750', '128rM79', NULL, '2025-08-31 03:56:20'),
(122, 12, 2, '98', 'market', 1, '3|pack+10|single', '6820.00', 0.00, 'cash', '0', '6820', 'tC6TY44', NULL, '2025-08-31 05:44:17'),
(123, 12, 2, '102', 'regular', 11, '2|pack+6|single', '9999.00', 0.00, 'cash', '0', '9999', 'x08A517', NULL, '2025-09-24 04:05:08'),
(124, 12, 2, '103', 'special', 10, '2|pack+12|single', '27750.00', 0.00, 'transfer', '0', '27750', '7O8H3PZ', NULL, '2025-09-24 04:17:12'),
(125, 12, 2, '102', 'market', 10, '2|pack+2|single', '6943.75', 0.00, 'cash', '0', '6943.75', 't175XAx', NULL, '2025-09-25 06:18:18'),
(126, 12, 2, '99,102', 'market', 11, '1|single,4|pack+0|single', '2333.00,12000.00', 0.00, 'creditor', '3633', '14333', '7T64H87', NULL, '2025-12-16 22:43:04'),
(127, 12, 2, '79,98', 'regular', 3, '2|single,2|pack+0|single', '11200.00,5000.00', 0.00, 'transfer', '0', '16200', '7x73661', NULL, '2025-12-16 23:31:11'),
(128, 12, 2, '79,102', 'regular', 11, '1|single,1|pack+0|single', '5600.00,4000.00', 0.00, 'cash', '0', '9600', 'r6U95L7', NULL, '2025-12-16 23:32:14'),
(129, 12, 2, '81', 'regular', 12, '1|single', '10000.00', 0.00, 'cash', '0', '10000', '0t67r3B', NULL, '2025-12-17 22:47:24'),
(130, 12, 2, '96', 'regular', 10, '2|pack+6|single', '10000.00', 0.00, 'cash', '0', '10000', '5489r20', NULL, '2025-12-17 23:55:23'),
(131, 12, 2, '99,98', 'regular', 11, '2|single,1|pack+5|single', '6664.00,2625.00', 696.68, 'cash', '0', '9289', '7794107', NULL, '2025-12-26 10:49:34'),
(132, 12, 2, '99,103', 'regular', 10, '4|single,2|pack+12|single', '13328.00,30000.00', 3249.60, 'creditor', '8028', '43328', 'Y385x1t', NULL, '2025-12-27 03:45:48'),
(133, 12, 2, '103', 'regular', 7067752092, '1|pack+3|single', '13500.00', 459.00, 'cash', '0', '13500', 'tx71S72', NULL, '2025-12-30 01:09:15'),
(134, 12, 3, '102', 'special', 9099999990, '1|pack+1|single', '5250.00', 178.50, 'cash', '0', '5250', '9x83r17', NULL, '2025-12-30 15:54:52'),
(135, 12, 3, '102', 'regular', 16, '1|pack+0|single', '4000.00', 136.00, 'cash', '0', '4000', '6178Q13', NULL, '2025-12-30 16:06:54'),
(136, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', 'x50E86N', NULL, '2026-01-09 22:18:00'),
(137, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', '8I6889T', NULL, '2026-01-09 22:18:08'),
(138, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', 'A6W21t5', NULL, '2026-01-09 22:18:09'),
(139, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', '21E7xV8', NULL, '2026-01-09 22:18:17'),
(140, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', 'xtrH782', NULL, '2026-01-09 22:18:18'),
(141, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', '9S6x208', NULL, '2026-01-09 22:18:35'),
(142, 12, 2, '99', 'regular', 11, '1|single', '3332.00', 113.29, 'cash', '0', '3332', '322C178', NULL, '2026-01-09 22:18:44'),
(143, 12, 2, '99', 'regular', 17, '1|single', '3332.00', 113.29, 'cash', '0', '3332', '1074N6r', '', '2026-01-09 22:31:32'),
(144, 12, 2, '99', 'regular', 17, '1|single', '3332.00', 113.29, 'cash', '0', '3332', 'I8J2VMr', '', '2026-01-09 22:32:48'),
(145, 12, 2, '99', 'regular', 17, '1|single', '3332.00', 113.29, 'cash', '0', '3332', 'L0x662E', '', '2026-01-09 22:34:45'),
(146, 12, 2, '99', 'regular', 17, '1|single', '3332.00', 113.29, 'cash', '0', '3332', 'Wx480N4', '237653768, USDY782368912, SY8Q7Y2', '2026-01-09 22:42:28'),
(147, 12, 3, '102', 'regular', 16, '3|pack+0|single', '12000.00', 408.00, 'cash', '0', '12000', '3Vrx517', 'No Info', '2026-06-15 08:35:52'),
(148, 12, 3, '102', 'regular', 16, '2|pack+0|single', '8600.00', 292.40, 'cash', '0', '8600', 'Ix2875N', '', '2026-06-15 23:10:36'),
(149, 12, 3, '102', 'regular', 16, '2|pack+0|single', '8600.00', 292.40, 'cash', '0', '8600', '51SF5Z2', '', '2026-06-15 23:12:25'),
(150, 12, 3, '102', 'regular', 16, '2|pack+0|single', '8600.00', 292.40, 'cash', '0', '8600', '1Mt578G', '', '2026-06-15 23:27:53'),
(151, 12, 2, '96,108', 'regular', 11, '3|pack+2|single,3|pack+0|single', '13800.00,6900.00', 703.80, 'cash', '0', '20700', '37I90r7', '', '2026-06-15 23:45:09');

-- --------------------------------------------------------

--
-- Table structure for table `return_product`
--

CREATE TABLE `return_product` (
  `id` int NOT NULL,
  `branch_id` int DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `price_type` varchar(20) DEFAULT NULL,
  `return_grand_total` decimal(10,2) DEFAULT NULL,
  `return_total_price` decimal(10,2) DEFAULT NULL,
  `return_quantity` decimal(10,2) DEFAULT NULL,
  `staff_id` int DEFAULT NULL,
  `reason` text,
  `return_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `return_product`
--

INSERT INTO `return_product` (`id`, `branch_id`, `product_id`, `customer_id`, `price_type`, `return_grand_total`, `return_total_price`, `return_quantity`, `staff_id`, `reason`, `return_date`) VALUES
(1, 2, 99, 12, 'regular', 9996.00, 3332.00, 3.00, 12, 'Customer return', '2025-12-22 23:33:08'),
(2, 2, 102, 12, 'regular', 5200.00, 200.00, 26.00, 12, 'Customer return', '2025-12-22 23:33:08'),
(3, 2, 99, 10, 'regular', 6664.00, 3332.00, 2.00, 12, 'Customer return', '2025-12-27 13:01:04');

-- --------------------------------------------------------

--
-- Table structure for table `swaps`
--

CREATE TABLE `swaps` (
  `id` int UNSIGNED NOT NULL,
  `trans_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `branch_id` int UNSIGNED DEFAULT NULL,
  `customer_id` int UNSIGNED DEFAULT NULL,
  `brought_product_id` int UNSIGNED NOT NULL,
  `brought_product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brought_quantity` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `brought_unit_value` decimal(12,2) NOT NULL DEFAULT '0.00',
  `wanted_product_id` int UNSIGNED NOT NULL,
  `wanted_product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `wanted_quantity` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `wanted_unit_value` decimal(12,2) NOT NULL DEFAULT '0.00',
  `cash_added` decimal(12,2) NOT NULL DEFAULT '0.00',
  `additional_info` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `swaps`
--

INSERT INTO `swaps` (`id`, `trans_code`, `user_id`, `branch_id`, `customer_id`, `brought_product_id`, `brought_product_name`, `brought_quantity`, `brought_unit_value`, `wanted_product_id`, `wanted_product_name`, `wanted_quantity`, `wanted_unit_value`, `cash_added`, `additional_info`, `created_at`, `updated_at`) VALUES
(1, '16Vw7G3s10', 12, 2, NULL, 102, 'Coca-Cola (Crate)', 1.0000, 2000.00, 103, 'Fanta Crate', 1.0000, 5000.00, 3000.00, 'Just wanna test this', '2026-01-25 11:28:21', NULL),
(2, 'p45603099S', 12, 2, NULL, 102, 'Coca-Cola (Crate)', 1.0000, 2000.00, 103, 'Fanta Crate', 1.0000, 5000.00, 3000.00, 'Just wanna test this', '2026-01-25 11:29:27', NULL),
(3, '43R31s96pQ', 12, 2, NULL, 102, 'Coca-Cola (Crate)', 1.0000, 200.00, 103, 'Fanta Crate', 1.0000, 500.00, 400.00, 'Additoonal Info', '2026-01-25 11:46:23', NULL),
(4, '1M23E9241G', 12, 2, NULL, 99, 'ShiShi', 1.0000, 2000.00, 97, 'Omituntun', 1.0000, 3000.00, 4500.00, 'Additional Info', '2026-01-25 11:49:42', NULL),
(5, '994Y63KOs9', 12, 2, 11, 99, 'ShiShi', 1.0000, 200.00, 104, 'Career Book 1', 1.0000, 300.00, 1000.00, '', '2026-01-27 06:06:14', NULL),
(6, '9PZwNp6sO4', 12, 2, 11, 99, 'ShiShi', 1.0000, 200.00, 104, 'Career Book 1', 1.0000, 300.00, 1000.00, '', '2026-01-27 06:18:13', NULL),
(7, 'p75Ys64wNT', 12, 2, 11, 0, 'ShiShi', 1.0000, 200.00, 109, 'Peak Milk', 1.0000, 300.00, 1000.00, '', '2026-01-27 06:19:25', NULL),
(8, '7111w632XF', 12, 2, 12, 101, 'srerr', 1.0000, 200.00, 108, 'Rara Product', 1.0000, 450.00, 500.00, '', '2026-01-27 06:20:11', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `fullname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `profile_pics` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg',
  `password` varchar(50) DEFAULT NULL,
  `status` enum('staff','admin') DEFAULT NULL,
  `branch_id` int DEFAULT NULL,
  `access` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `fullname`, `email`, `profile_pics`, `password`, `status`, `branch_id`, `access`, `created_at`) VALUES
(12, 'SHOP OWNER', 'fuskydon@gmail.com', 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1726997686/dk4bybrsh5hj86ldqpdv.png', '15317ede3526ea08664db7c5737ba843', 'admin', 1, 1, '2022-12-11 05:11:53'),
(13, 'Abdulhammed Fuad', 'yeseeroh@gmail.com', 'default.jpg', '15317ede3526ea08664db7c5737ba843', 'staff', 1, 0, '2022-12-20 15:42:10'),
(14, 'Brother Jamiu', 'jamiu@gmail.com', 'default.jpg', '15317ede3526ea08664db7c5737ba843', 'staff', 1, 0, '2023-02-03 04:15:09'),
(15, 'Mailop Software', 'aish@gmail.com', '70445047.png', '15317ede3526ea08664db7c5737ba843', 'staff', 2, 1, '2023-12-27 14:13:44'),
(16, 'Adikwu Simon', 'adikwu@gmail.com', 'https://res.cloudinary.com/do9whlpl9/image/upload/v1733828072/had6qzqibgbfgndre1q0.jpg', '15317ede3526ea08664db7c5737ba843', 'staff', 2, 1, '2024-12-10 11:54:11'),
(17, 'Adikwu Simon', 'adi@gmail.com', 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1724392766/default_tfrstf.jpg', '0192023a7bbd73250516f069df18b500', 'admin', 2, 1, '2025-01-14 10:31:47'),
(18, 'Mailop Exclusive', 'mailop@gmail.com', 'profileImage/51429124.png', '15317ede3526ea08664db7c5737ba843', 'staff', 3, 1, '2025-12-27 03:58:11');

-- --------------------------------------------------------

--
-- Table structure for table `user_pages`
--

CREATE TABLE `user_pages` (
  `id` bigint NOT NULL,
  `user_id` int DEFAULT NULL,
  `page_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_pages`
--

INSERT INTO `user_pages` (`id`, `user_id`, `page_id`, `created_at`) VALUES
(3, 12, 3, '2025-01-18 15:16:11'),
(4, 12, 4, '2025-01-18 15:16:11'),
(5, 12, 5, '2025-01-18 15:16:11'),
(6, 12, 6, '2025-01-18 15:16:11'),
(7, 12, 7, '2025-01-18 15:16:11'),
(8, 12, 8, '2025-01-18 15:16:11'),
(9, 12, 9, '2025-01-18 15:16:11'),
(10, 12, 10, '2025-01-18 15:16:11'),
(11, 12, 11, '2025-01-18 15:16:11'),
(12, 12, 12, '2025-01-18 15:16:11'),
(13, 12, 13, '2025-01-18 15:16:11'),
(14, 12, 14, '2025-01-18 15:16:11'),
(15, 12, 15, '2025-01-18 15:16:11'),
(16, 12, 16, '2025-01-18 15:16:11'),
(17, 12, 17, '2025-01-18 15:16:11'),
(18, 12, 18, '2025-01-18 15:16:11'),
(19, 12, 19, '2025-01-18 15:16:11'),
(20, 12, 20, '2025-01-18 15:16:11'),
(21, 12, 21, '2025-01-18 15:16:11'),
(22, 12, 22, '2025-01-18 15:16:11'),
(23, 12, 23, '2025-01-18 15:16:11'),
(24, 12, 24, '2025-01-18 15:16:11'),
(25, 12, 25, '2025-01-18 15:16:11'),
(26, 12, 26, '2025-01-18 15:16:11'),
(27, 12, 27, '2025-01-18 15:16:11'),
(28, 12, 28, '2025-01-18 15:16:11'),
(29, 12, 29, '2025-01-18 15:16:11'),
(30, 12, 30, '2025-01-18 15:16:11'),
(31, 12, 31, '2025-01-18 15:16:11'),
(32, 12, 32, '2025-01-18 15:16:11'),
(33, 12, 33, '2025-01-18 15:16:11'),
(34, 12, 34, '2025-01-18 15:16:11'),
(35, 12, 35, '2025-01-18 15:16:11'),
(36, 12, 36, '2025-01-18 15:16:11'),
(37, 12, 37, '2025-01-18 15:16:11'),
(38, 12, 38, '2025-01-18 15:16:11'),
(39, 12, 39, '2025-01-18 15:16:11'),
(46, 12, 40, '2025-01-19 14:51:34'),
(47, 12, 41, '2025-01-20 12:39:06'),
(48, 12, 42, '2025-01-20 12:39:06'),
(49, 12, 43, '2025-01-20 12:39:06'),
(50, 12, 44, '2025-01-20 12:39:06'),
(51, 12, 45, '2025-01-20 12:39:06'),
(52, 12, 46, '2025-01-20 12:39:06'),
(53, 12, 47, '2025-01-20 12:39:06'),
(54, 12, 48, '2025-01-20 12:39:06'),
(55, 12, 49, '2025-01-20 12:39:06'),
(56, 12, 50, '2025-01-20 12:39:06'),
(57, 12, 51, '2025-01-20 12:39:06'),
(63, 12, 1, '2025-01-21 13:37:52'),
(64, 12, 7, '2025-01-21 13:37:52'),
(65, 12, 5, '2025-01-21 13:37:52'),
(66, 12, 8, '2025-01-21 13:37:52'),
(67, 12, 12, '2025-01-21 13:37:52'),
(68, 12, 11, '2025-01-21 13:37:52'),
(69, 12, 18, '2025-01-21 13:37:52'),
(70, 12, 16, '2025-01-21 13:37:52'),
(71, 12, 26, '2025-01-21 13:37:52'),
(72, 12, 25, '2025-01-21 13:37:52'),
(73, 12, 28, '2025-01-21 13:37:52'),
(74, 12, 53, '2025-01-18 15:16:11'),
(75, 12, 54, '2025-01-18 15:16:11'),
(76, 12, 55, '2025-01-18 15:16:11'),
(77, 15, 54, '2026-06-20 19:08:31'),
(78, 15, 53, '2026-06-20 19:08:31'),
(79, 15, 55, '2026-06-20 19:08:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_settings`
--
ALTER TABLE `company_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `distributors`
--
ALTER TABLE `distributors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `market_products`
--
ALTER TABLE `market_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_purchase`
--
ALTER TABLE `product_purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_product`
--
ALTER TABLE `return_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `staff_id` (`staff_id`);

--
-- Indexes for table `swaps`
--
ALTER TABLE `swaps`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_code` (`trans_code`),
  ADD KEY `trans_code_2` (`trans_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `branch_id` (`branch_id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_pages`
--
ALTER TABLE `user_pages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `market_products`
--
ALTER TABLE `market_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `return_product`
--
ALTER TABLE `return_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `swaps`
--
ALTER TABLE `swaps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_pages`
--
ALTER TABLE `user_pages`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `return_product`
--
ALTER TABLE `return_product`
  ADD CONSTRAINT `return_product_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`),
  ADD CONSTRAINT `return_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `return_product_ibfk_3` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `return_product_ibfk_4` FOREIGN KEY (`staff_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
