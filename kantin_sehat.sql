-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2025 at 04:23 PM
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
-- Database: `kantin_sehat`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `size`, `description`) VALUES
(1, 'Nasi Goreng Sehat', 15000.00, 'Medium', 'Nasi goreng dengan sayuran organik'),
(2, 'Salad Buah', 12000.00, 'Regular', 'Campuran buah segar dengan yogurt'),
(3, 'Jus Alpukat', 10000.00, 'Large', 'Alpukat asli tanpa gula'),
(4, 'Sandwich Gandum', 18000.00, 'Large', 'Roti gandum dengan sayuran dan daging asap'),
(5, 'Teh Hijau', 5000.00, 'Medium', 'Teh hijau tanpa gula');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_all` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `items` text NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `total_all`, `created_at`, `items`, `total_price`) VALUES
(1, 5, 10000, '2025-12-10 15:07:07', '', 0),
(2, 5, 10000, '2025-12-10 15:07:58', '', 0),
(3, 5, 266000, '2025-12-10 15:08:57', '', 0),
(4, 5, 0, '2025-12-10 15:12:25', '{\"3\":{\"id\":\"3\",\"name\":\"Jus Alpukat\",\"price\":\"10000.00\",\"quantity\":22}}', 220000),
(5, 5, 0, '2025-12-10 15:12:42', '{\"4\":{\"id\":\"4\",\"name\":\"Sandwich Gandum\",\"price\":\"18000.00\",\"quantity\":2},\"3\":{\"id\":\"3\",\"name\":\"Jus Alpukat\",\"price\":\"10000.00\",\"quantity\":21}}', 246000),
(6, 5, 0, '2025-12-10 15:13:12', '{\"4\":{\"id\":\"4\",\"name\":\"Sandwich Gandum\",\"price\":\"18000.00\",\"quantity\":12}}', 216000),
(7, 5, 0, '2025-12-10 15:19:31', '{\"2\":{\"id\":\"2\",\"name\":\"Salad Buah\",\"price\":\"12000.00\",\"quantity\":1}}', 12000),
(8, 5, 0, '2025-12-10 15:19:34', '{\"3\":{\"id\":\"3\",\"name\":\"Jus Alpukat\",\"price\":\"10000.00\",\"quantity\":1}}', 10000),
(9, 5, 12000, '2025-12-10 15:20:07', '', 0),
(10, 5, 35574000, '2025-12-10 15:20:19', '', 0),
(11, 5, 464000, '2025-12-10 15:20:31', '', 0),
(12, 5, 144000, '2025-12-10 15:22:16', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`id`, `transaction_id`, `product_id`, `quantity`, `total_price`) VALUES
(1, 1, 3, 1, 10000),
(2, 2, 3, 1, 10000),
(3, 3, 3, 23, 230000),
(4, 3, 4, 2, 36000),
(5, 9, 2, 1, 12000),
(6, 10, 2, 12, 144000),
(7, 10, 3, 3543, 35430000),
(8, 11, 3, 32, 320000),
(9, 11, 2, 12, 144000),
(10, 12, 2, 12, 144000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(2, 'siswa', 'siswa123', 'user'),
(3, 'tester', '12345', 'user'),
(5, 'admin', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
