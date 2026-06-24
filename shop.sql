-- phpMyAdmin SQL Dump
-- version 6.0.0-dev+20250718.d42db65a1e
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 24, 2026 at 02:10 AM
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
(1, 'Main Branch', 'main-branch', '2026-06-24 10:16:27'),
(2, 'Anthony Branch', 'anthony-branch', '2026-06-24 10:17:06');

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
(1, 1, 'Qudus', 'regular', '07067752068', '');

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
(1, 'Main Supplier', '07067752068', 'mainsupplier@gmail.com', 'Anthony', '2026-06-24 10:18:43');

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
(1, 1, 'New Product', 'kasgyuaswi', 9000.00, 'ov3pk67l2', 20.0000000000, 1, 1, 'productImage/82171562.png', '', '2026-06-24 11:06:21');

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
(5, 'Point of Sale (POS)', 'nill', NULL, 'page', '2025-01-18 14:42:43'),
(6, 'Point of Sale (POS)', 'orders', 5, 'page', '2025-01-18 14:42:43'),
(7, 'My Sales', 'ordered_products', 5, 'page', '2025-01-18 14:42:43'),
(8, 'Sales History/All Sales', 'allordered_products', 5, 'page', '2025-01-18 14:42:43'),
(9, 'Sales Report', 'record', 5, 'page', '2025-01-18 14:42:43'),
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
(22, 'Suppliers', 'nill', NULL, 'page', '2025-01-18 14:52:48'),
(23, 'Suppliers', 'distributor', 22, 'page', '2025-01-18 14:52:48'),
(24, 'Create New Supplier', 'create_distributor', 22, 'page', '2025-01-18 14:52:48'),
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
(1, 1, 'New Product', 'kasgyuaswi', 15000.00, 9000.00, 13500.00, 0, 'ov3pk67l2', 20.0000000000, 0, NULL, 1, 1, 'productImage/82171562.png', '', '2026-06-24 11:06:21');

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
(1, 'Main Category', 'jh3079i', '2026-06-24 10:17:35');

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
(1, 1, 1, '1', 'regular', 7067752068, '3|single', '45000.00', 1530.00, 'cash', '0', '45000', '2671Ut0', '', '2026-06-24 11:10:27');

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
(1, 'Visionary Minds', 'visionaryminds@gmail.com', 'https://res.cloudinary.com/dxadk9e9b/image/upload/v1726997686/dk4bybrsh5hj86ldqpdv.png', '15317ede3526ea08664db7c5737ba843', 'admin', 1, 1, '2026-06-24 10:15:14');

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
(3, 1, 3, '2025-01-18 15:16:11'),
(4, 1, 4, '2025-01-18 15:16:11'),
(5, 1, 5, '2025-01-18 15:16:11'),
(6, 1, 6, '2025-01-18 15:16:11'),
(7, 1, 7, '2025-01-18 15:16:11'),
(8, 1, 8, '2025-01-18 15:16:11'),
(9, 1, 9, '2025-01-18 15:16:11'),
(10, 1, 10, '2025-01-18 15:16:11'),
(11, 1, 11, '2025-01-18 15:16:11'),
(12, 1, 12, '2025-01-18 15:16:11'),
(13, 1, 13, '2025-01-18 15:16:11'),
(14, 1, 14, '2025-01-18 15:16:11'),
(15, 1, 15, '2025-01-18 15:16:11'),
(16, 1, 16, '2025-01-18 15:16:11'),
(17, 1, 17, '2025-01-18 15:16:11'),
(18, 1, 18, '2025-01-18 15:16:11'),
(19, 1, 19, '2025-01-18 15:16:11'),
(20, 1, 20, '2025-01-18 15:16:11'),
(21, 1, 21, '2025-01-18 15:16:11'),
(22, 1, 22, '2025-01-18 15:16:11'),
(23, 1, 23, '2025-01-18 15:16:11'),
(24, 1, 24, '2025-01-18 15:16:11'),
(25, 1, 25, '2025-01-18 15:16:11'),
(26, 1, 26, '2025-01-18 15:16:11'),
(27, 1, 27, '2025-01-18 15:16:11'),
(28, 1, 28, '2025-01-18 15:16:11'),
(29, 1, 29, '2025-01-18 15:16:11'),
(30, 1, 30, '2025-01-18 15:16:11'),
(31, 1, 31, '2025-01-18 15:16:11'),
(32, 1, 32, '2025-01-18 15:16:11'),
(33, 1, 33, '2025-01-18 15:16:11'),
(34, 1, 34, '2025-01-18 15:16:11'),
(35, 1, 35, '2025-01-18 15:16:11'),
(36, 1, 36, '2025-01-18 15:16:11'),
(37, 1, 37, '2025-01-18 15:16:11'),
(38, 1, 38, '2025-01-18 15:16:11'),
(39, 1, 39, '2025-01-18 15:16:11'),
(46, 1, 40, '2025-01-19 14:51:34'),
(47, 1, 41, '2025-01-20 12:39:06'),
(48, 1, 42, '2025-01-20 12:39:06'),
(49, 1, 43, '2025-01-20 12:39:06'),
(50, 1, 44, '2025-01-20 12:39:06'),
(51, 1, 45, '2025-01-20 12:39:06'),
(52, 1, 46, '2025-01-20 12:39:06'),
(53, 1, 47, '2025-01-20 12:39:06'),
(54, 1, 48, '2025-01-20 12:39:06'),
(55, 1, 49, '2025-01-20 12:39:06'),
(56, 1, 50, '2025-01-20 12:39:06'),
(57, 1, 51, '2025-01-20 12:39:06'),
(63, 1, 1, '2025-01-21 13:37:52'),
(74, 1, 53, '2025-01-18 15:16:11'),
(75, 1, 54, '2025-01-18 15:16:11'),
(76, 1, 55, '2025-01-18 15:16:11');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `company_settings`
--
ALTER TABLE `company_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `distributors`
--
ALTER TABLE `distributors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `market_products`
--
ALTER TABLE `market_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `product_purchase`
--
ALTER TABLE `product_purchase`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_product`
--
ALTER TABLE `return_product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `swaps`
--
ALTER TABLE `swaps`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
