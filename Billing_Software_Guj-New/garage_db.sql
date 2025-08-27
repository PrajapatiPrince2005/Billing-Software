-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2025 at 09:55 AM
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
-- Database: `garage_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', '2007');

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `vehicle_number` varchar(50) DEFAULT NULL,
  `bill_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `labour_charge` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `customer_id`, `vehicle_number`, `bill_date`, `total_amount`, `labour_charge`, `created_at`, `updated_at`) VALUES
(2, 1, NULL, '2025-08-26 18:50:54', 1002.00, 2.00, '2025-08-26 13:20:54', '2025-08-26 13:20:54'),
(6, 1, '1245', '2025-08-26 19:19:22', 2830.00, 500.00, '2025-08-26 13:49:22', '2025-08-26 13:49:22'),
(7, 1, '1245', '2025-08-26 19:22:22', 1200.00, 500.00, '2025-08-26 13:52:22', '2025-08-26 13:52:22'),
(8, 1, '1245', '2025-08-26 19:26:10', 1500.00, 500.00, '2025-08-26 13:56:10', '2025-08-26 13:56:10'),
(9, 3, '4152', '2025-08-26 19:40:38', 1500.00, 500.00, '2025-08-26 14:10:38', '2025-08-26 14:10:38'),
(10, 1, '1245', '2025-08-26 19:47:51', 530.00, 500.00, '2025-08-26 14:17:51', '2025-08-26 14:17:51'),
(11, 1, '1245', '2025-08-27 11:03:34', 1500.00, 500.00, '2025-08-27 05:33:34', '2025-08-27 05:33:34'),
(12, 4, '1520', '2025-08-27 11:55:27', 1200.00, 500.00, '2025-08-27 06:25:27', '2025-08-27 06:25:27'),
(13, 2, '7895', '2025-08-27 12:35:23', 2530.00, 500.00, '2025-08-27 07:05:23', '2025-08-27 07:05:23'),
(14, 3, '4152', '2025-08-27 12:42:08', 250.00, 150.00, '2025-08-27 07:12:08', '2025-08-27 07:12:08'),
(15, 2, '7895', '2025-08-27 12:45:19', 400.00, 200.00, '2025-08-27 07:15:19', '2025-08-27 07:15:19');

-- --------------------------------------------------------

--
-- Table structure for table `bill_items`
--

CREATE TABLE `bill_items` (
  `id` int(11) NOT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `part_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bill_items`
--

INSERT INTO `bill_items` (`id`, `bill_id`, `part_id`, `quantity`, `price`) VALUES
(1, 1, 1, 5, 300.00),
(2, 2, 1, 2, 300.00),
(3, 3, 1, 5, 300.00),
(4, 4, 1, 38, 300.00),
(5, 5, 1, 1, 400.00),
(6, 6, 1, 3, 400.00),
(7, 7, 3, 2, 700.00),
(8, 8, 1, 1, 400.00),
(9, 9, 5, 3, 30.00),
(10, 9, 5, 3, 30.00),
(11, 10, 5, 50, 30.00),
(12, 10, 4, 4, 1000.00),
(13, 11, 2, 2, 2000.00),
(14, 12, 3, 1, 700.00),
(15, 13, 2, 1, 2000.00),
(16, 14, 3, 1, 700.00),
(17, 15, 7, 2, 330.00),
(18, 16, 1, 1, 400.00),
(19, 17, 5, 1, 30.00),
(20, 17, 2, 1, 2000.00),
(21, 18, 2, 1, 2000.00),
(22, 19, 1, 1, 400.00),
(23, 20, 3, 1, 700.00),
(24, 21, 4, 1, 1000.00),
(25, 22, 2, 1, 2000.00),
(26, 23, 2, 1, 2000.00),
(27, 24, 3, 1, 700.00),
(28, 2, 4, 1, 1000.00),
(29, 6, 2, 1, 2000.00),
(30, 6, 7, 1, 330.00),
(31, 7, 3, 1, 700.00),
(32, 8, 4, 1, 1000.00),
(33, 9, 4, 1, 1000.00),
(34, 10, 5, 1, 30.00),
(35, 11, 4, 1, 1000.00),
(36, 12, 3, 1, 700.00),
(37, 13, 5, 1, 30.00),
(38, 13, 2, 1, 2000.00),
(39, 14, 8, 1, 100.00),
(40, 15, 9, 1, 200.00);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `vehicle_number` varchar(20) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `reach` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `vehicle_number`, `address`, `created_at`, `reach`) VALUES
(1, 'Prince', '8780165584', '1245', 'surat', '2025-08-23 11:09:32', NULL),
(2, 'Yash', '8780165589', '7895', 'Surat', '2025-08-26 06:15:28', NULL),
(3, 'mangesh bhai', '8798564405', '4152', 'surat', '2025-08-26 12:58:28', NULL),
(4, 'Paresh Bhai', '9635874522', '1520', 'Surat', '2025-08-27 06:25:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer_payments`
--

CREATE TABLE `customer_payments` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `bill_id` int(11) DEFAULT NULL,
  `paid_amount` decimal(10,2) DEFAULT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer_payments`
--

INSERT INTO `customer_payments` (`id`, `customer_id`, `bill_id`, `paid_amount`, `payment_date`, `note`) VALUES
(37, 1, 10, 500.00, '2025-08-26 19:47:51', 'Initial Payment'),
(38, 3, NULL, 1500.00, '2025-08-26 19:48:15', 'ok'),
(39, 1, NULL, 6562.00, '2025-08-26 19:48:26', 'ok'),
(40, 1, 11, 1000.00, '2025-08-27 11:03:34', 'Initial Payment'),
(41, 4, 12, 1200.00, '2025-08-27 11:55:27', 'Initial Payment'),
(42, 2, 13, 2530.00, '2025-08-27 12:35:23', 'Initial Payment'),
(43, 3, 14, 250.00, '2025-08-27 12:42:08', 'Initial Payment'),
(44, 2, 15, 400.00, '2025-08-27 12:45:19', 'Initial Payment');

-- --------------------------------------------------------

--
-- Table structure for table `stock_parts`
--

CREATE TABLE `stock_parts` (
  `id` int(11) NOT NULL,
  `part_number` varchar(50) NOT NULL,
  `part_name` varchar(100) NOT NULL,
  `quantity` int(11) NOT NULL,
  `purchase_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `supplier` varchar(100) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_parts`
--

INSERT INTO `stock_parts` (`id`, `part_number`, `part_name`, `quantity`, `purchase_price`, `sell_price`, `supplier`, `purchase_date`) VALUES
(8, '2', 'giris', 49, 50.00, 100.00, 'Raju Auto Parts', '2025-08-27'),
(9, '3', 'engin oil -250ml', 19, 150.00, 200.00, 'Unix parts seller', '2025-08-27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Indexes for table `bill_items`
--
ALTER TABLE `bill_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_payments`
--
ALTER TABLE `customer_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_parts`
--
ALTER TABLE `stock_parts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `part_number` (`part_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `stock_parts`
--
ALTER TABLE `stock_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bills`
--
ALTER TABLE `bills`
  ADD CONSTRAINT `bills_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
