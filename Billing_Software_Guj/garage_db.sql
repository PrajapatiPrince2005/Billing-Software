-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 12:24 PM
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
-- Table structure for table `bills`
--

CREATE TABLE `bills` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `vehicle_id` int(11) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `bill_date` datetime DEFAULT current_timestamp(),
  `labour_charge` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`id`, `customer_id`, `vehicle_id`, `total_amount`, `bill_date`, `labour_charge`) VALUES
(1, 2, 1, 1500.00, '2025-07-18 12:26:53', 0.00),
(2, 2, 1, 600.00, '2025-07-18 12:42:48', 0.00),
(3, 2, 1, 1500.00, '2025-07-18 13:06:40', 0.00),
(4, 3, 2, 11400.00, '2025-07-18 13:29:27', 0.00),
(5, 3, 2, 400.00, '2025-07-18 13:45:32', 0.00),
(6, 2, 1, 2700.00, '2025-07-18 14:58:24', 1500.00);

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
(6, 6, 1, 3, 400.00);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `reach` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `reach`) VALUES
(2, 'Mukesh Bhai', '78855565656', 'Nava Gam', NULL),
(3, 'Prince', '87880536', 'Surat', NULL),
(4, 'jashes bhai ', '8780265505', 'surat', NULL),
(5, 'Tina Bhai', '871526', 'Surat', NULL),
(6, 'Prince', '8782655596', 'Surat', NULL);

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
(1, 2, 3, 1000.00, '2025-07-18 13:06:40', 'Initial Payment'),
(2, 2, NULL, 2600.00, '2025-07-18 13:13:03', 'ok'),
(3, 3, 4, 11400.00, '2025-07-18 13:29:27', 'Initial Payment'),
(4, 3, 5, 400.00, '2025-07-18 13:45:32', 'Initial Payment'),
(5, 2, 6, 2700.00, '2025-07-18 14:58:24', 'Initial Payment');

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
(1, '1542', 'Oil Box', -4, 150.00, 400.00, 'Unix Parts Seller', '2025-07-18'),
(2, '15862', 'chakar', 1517, 1500.00, 2000.00, 'Paresh Seller', '2025-07-18'),
(3, '7850', 'Enify Oil-250ml', 50, 500.00, 700.00, 'Unix Parts Seller', '2025-07-18'),
(4, '8798', 'Evify Oil-1 ltr', 50, 800.00, 1000.00, 'Parsh Bhai ', '2025-07-18');

-- --------------------------------------------------------

--
-- Table structure for table `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `vehicle_number` varchar(20) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `fuel_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicles`
--

INSERT INTO `vehicles` (`id`, `customer_id`, `vehicle_number`, `model`, `brand`, `fuel_type`) VALUES
(1, 2, '1500', 'atul', 'atul', 'Petrol'),
(2, 3, '7875', '2011', 'Atul', 'Petrol'),
(3, 5, '1587', '2015', 'Piyago', 'Diesel'),
(4, 3, '0000', '0000', 'atul', 'Petrol');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bills`
--
ALTER TABLE `bills`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bills`
--
ALTER TABLE `bills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `bill_items`
--
ALTER TABLE `bill_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer_payments`
--
ALTER TABLE `customer_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `stock_parts`
--
ALTER TABLE `stock_parts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vehicles`
--
ALTER TABLE `vehicles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vehicles`
--
ALTER TABLE `vehicles`
  ADD CONSTRAINT `vehicles_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
