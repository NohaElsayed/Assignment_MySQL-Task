-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 23, 2026 at 11:23 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `city` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `salary`, `city`, `password`) VALUES
(1, 'Ahmed Ali', 25000.00, 'Cairo', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
(2, 'Tariq Hassan', 18000.00, 'Alex', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
(3, 'Sara Mohamed', 35000.00, 'Cairo', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
(4, 'Omar Khaled', 22000.00, 'Giza', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
(5, 'Mona Samir', 45000.00, 'Alex', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
(6, 'Youssef Adel', 15000.00, 'Cairo', '$2y$10$e0NRZ1V8Y5Q8Y5Q8Y5Q8Yu5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5Q8Y5'),
(7, 'Simone Fulton', 46.00, 'Est velit aperiam eligendi voluptatem id', '$2y$10$9kGwYeMpOjbVKM7/b5trWOok3gOUKIJoxaaQgFnDpfrQD6QfANUEa'),
(8, 'noha', 80.00, 'Rerum rem magna quaerat officia magni occaecat sit beatae distinctio Qui ipsa nobis officia neque ', '$2y$10$bNjqcG0pxuDdliKYtTrZsefZ18KFcxRYGdSTlfQvkyoCystaePZvW');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `manager_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `manager_id`) VALUES
(1, 'CEO Boss', NULL),
(2, 'Manager Ali', 1),
(3, 'Manager Sara', 1),
(4, 'Employee Omar', 2),
(5, 'Employee Mona', 2),
(6, 'Employee Youssef', 3),
(7, 'Employee Khaled', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `customer_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `order_date` date DEFAULT (curdate())
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `product_id`, `quantity`, `order_date`) VALUES
(1, 1, 1, 5, '2026-07-23'),
(2, 1, 2, 8, '2026-07-23'),
(3, 1, 3, 3, '2026-07-23'),
(4, 1, 4, 1, '2026-07-23'),
(5, 1, 5, 4, '2026-07-23'),
(6, 2, 1, 2, '2026-07-23'),
(7, 2, 3, 3, '2026-07-23'),
(8, 2, 5, 1, '2026-07-23'),
(9, 2, 6, 2, '2026-07-23'),
(10, 2, 2, 4, '2026-07-23'),
(11, 3, 1, 10, '2026-07-23'),
(12, 3, 2, 8, '2026-07-23'),
(13, 3, 4, 5, '2026-07-23'),
(14, 3, 6, 3, '2026-07-23'),
(15, 4, 2, 6, '2026-07-23'),
(16, 4, 5, 2, '2026-07-23'),
(17, 4, 1, 3, '2026-07-23'),
(18, 5, 4, 7, '2026-07-23'),
(19, 5, 6, 5, '2026-07-23'),
(20, 5, 1, 4, '2026-07-23'),
(21, 5, 3, 2, '2026-07-23'),
(22, 6, 2, 3, '2026-07-23'),
(23, 6, 5, 1, '2026-07-23');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'Milk', 12.50),
(2, 'Orange', 8.75),
(3, 'Bread', 15.00),
(4, 'Cheese', 45.00),
(5, 'Juice', 20.00),
(6, 'Rice', 30.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
