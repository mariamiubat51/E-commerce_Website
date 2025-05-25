-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 08:52 AM
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
-- Database: `ecommerce_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$AWuidji7ACtdRbSm8WvDl.jpBEREs7dZ2BGs8SXDo49frkH2ePSVy');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(100) DEFAULT NULL,
  `customer_address` text DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_address`, `total_amount`, `order_date`) VALUES
(1, 'popy', 'poly@gmail.com', 'dhaka', 40.00, '2025-05-09 06:42:48'),
(2, 'lopa', 'lopa@gmail.com', 'Tongi', 60.00, '2025-05-13 16:29:40'),
(3, 'lina', 'lina@gimail.com', 'dhaka', 111.00, '2025-05-14 05:14:37'),
(4, 'lina', 'lina@gimail.com', 'dhaka', 25.00, '2025-05-14 05:20:12'),
(5, 'lina', 'lina@gimail.com', 'dhaka', 20.00, '2025-05-14 06:29:26'),
(6, 'diya', 'diya@gmail.com', 'dhaka', 50.00, '2025-05-14 06:48:12'),
(7, 'diya', 'diya@gmail.com', 'dhaka', 26.00, '2025-05-14 07:17:30'),
(8, 'lina', 'lina@gimail.com', 'dhaka', 25.00, '2025-05-14 07:32:38'),
(9, 'lina', 'lina@gimail.com', 'dhaka', 78.00, '2025-05-14 10:43:36'),
(10, 'lina', 'lina@gimail.com', 'dhaka', 37.00, '2025-05-14 10:50:44'),
(11, 'Rupa', 'rupa@gmail.com', 'dhaka', 120.00, '2025-05-14 17:39:42'),
(12, 'Mily', 'mily@gmail.com', 'dhaka', 145.00, '2025-05-14 17:49:01'),
(13, 'Sima', 'sima@gmail.com', 'dhaka', 284.00, '2025-05-14 18:04:11');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_name`, `quantity`, `price`) VALUES
(1, 1, 'Baby Boy Outfit	', 2, 20.00),
(2, 2, 'Baby Boy Outfit	', 3, 20.00),
(3, 3, 'Ladies Bag', 3, 37.00),
(4, 4, 'Khimar', 1, 25.00),
(5, 5, 'Clock', 1, 20.00),
(6, 6, 'HP Laptop', 1, 50.00),
(7, 7, 'Wall Clock', 1, 26.00),
(8, 8, 'Khimar', 1, 25.00),
(9, 9, 'Baby Boy Dress', 1, 78.00),
(10, 10, 'Ladies Bag', 1, 37.00),
(11, 11, 'Baby Boy Dress', 2, 60.00),
(12, 12, 'School Bag', 2, 54.00),
(13, 12, 'Ladies Bag', 1, 37.00),
(14, 13, 'Baby Boy Dress', 3, 78.00),
(15, 13, 'HP Laptop', 1, 50.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  `main_category` varchar(100) NOT NULL,
  `sub_category` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `main_category`, `sub_category`, `created_at`) VALUES
(12, 'borka', 25.00, 'khimar.jpg', 'Dress', 'Female', '2025-05-14 03:30:24'),
(13, 'Clock', 20.00, 'clock1.png', 'Electronic Devices', 'Clocks', '2025-05-14 04:08:09'),
(15, 'HP Laptop', 50.00, 'hp_laptop_1.png', 'Electronic Devices', 'Laptops', '2025-05-14 04:23:41'),
(17, 'Baby Boy Dress', 60.00, 'baby_boy2.png', 'Dress', 'Child', '2025-05-14 07:51:13'),
(18, 'Baby Boy Dress', 57.00, 'baby_boy3.jpg', 'Dress', 'Child', '2025-05-14 07:51:56'),
(19, 'Baby Boy Dress', 78.00, 'baby_dress1.jpg', 'Dress', 'Child', '2025-05-14 07:52:21'),
(20, 'Smart Clock', 80.00, 'smart_clock1.png', 'Electronic Devices', 'Clocks', '2025-05-14 07:54:01'),
(21, 'Female Bag', 49.00, 'ladies_bag2.png', 'Bag', 'Handbag', '2025-05-14 08:04:35'),
(22, 'Female Bag', 65.00, 'ladies_bag3.png', 'Bag', 'Handbag', '2025-05-14 08:04:59'),
(23, 'Nice Bag', 95.00, 'ladies_bag4.png', 'Bag', 'Handbag', '2025-05-14 08:06:57'),
(24, 'Shirt', 48.00, 'male_dress1.jpg', 'Dress', 'Male', '2025-05-14 10:49:23'),
(25, 'School Bag', 54.00, 'school_bag2.png', 'Bag', 'School Bag', '2025-05-14 17:47:37'),
(26, 'Baby Girls Dress', 86.00, 'baby_girl3.jpeg', 'Dress', 'Child', '2025-05-14 18:02:18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Mariam', 'mariam@gmail.com', '$2y$10$pCgZmobfh.dJTWTga23pt.MB0v01ujRyelLR4Je5QVH4HlHKOyNKO', '2025-04-28 18:59:06'),
(3, 'Popy', 'popy@iubat.com', '$2y$10$o2w67eRGrbCFWsHND8YjTeJ5s7SfUH0z2v0QGYHMxxyJQEWx9LWFW', '2025-04-28 19:13:45'),
(4, 'lina', 'lina@gimail.com', '$2y$10$GHP5vmFsR.xkNPp7ey1s5erzjmZcweXhjXx2popSQXR/CKlg2la8S', '2025-05-14 03:17:05'),
(5, 'diya', 'diya@gmail.com', '$2y$10$kwfR9l0HJaMfsSNRRohtfOmcY6JESaueUj4pgKM2lCnnnFMNDWH5a', '2025-05-14 06:46:02'),
(6, 'Rupa', 'rupa@gmail.com', '$2y$10$gc.zpmOA4yPK4pXK/Ua4k.FOv/tFEfZF1/jdqlWil1d15oKA6l6E6', '2025-05-14 17:37:53'),
(7, 'Mily', 'mily@gmail.com', '$2y$10$DOy0Mvbyq4YaIerigveK9.0mxs6izCyltYf2w9XKe.rH3ZzpyXxC6', '2025-05-14 17:45:00'),
(8, 'Sima', 'sima@gmail.com', '$2y$10$lheoDD1buUYHwrRbgPMOV.Y80Cff7uBjknia3kd1vObPY2GS5glo6', '2025-05-14 17:59:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
