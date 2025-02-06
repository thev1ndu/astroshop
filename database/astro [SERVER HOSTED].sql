-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 05, 2025 at 05:03 PM
-- Server version: 8.0.41-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.20

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
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `quantity` int NOT NULL,
  `image` varchar(100) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pid`, `name`, `price`, `quantity`, `image`, `subtotal`) VALUES
(24, 1, 5, 'AMD Ryzen 7 7700X', 300, 1, 'cpu.jpg', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` int NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payment_status` varchar(20) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'ThevinduW', '2312321', 't@gmail.com', 'cash on delivery', 'flat no. sfasfas, dsfsd, Kadawatha, Western Province, Sri Lanka - 11850', 'Headset (92 x 5), AMD Ryzen 7 7700X (300 x 9), Logitech Headset (70 x 4), EPSON Printer (400 x 8), Mouse (25 x 4), MSI Monitor (200 x 2), MSI Laptop (1200 x 5), Keyboard (40 x 15), SSD (20 x 21), External Hard Disk (50 x 40)', 16160, '2025-02-04 10:34:42', 'completed'),
(2, 1, 'tysm', '2312321', 'thevinduh21@gmail.com', 'credit card', 'flat no. sfasfas, fasfas, Kadawatha, Western Province, Sri Lanka - 11850', 'Headset (92 x 1)', 92, '2025-02-04 11:07:28', 'pending'),
(4, 1, 'ThevinduW', '2312321', 't@gmail.com', 'cash on delivery', 'flat no. sfasfas, dsfsd, Kadawatha, Western Province, Sri Lanka - 11850', 'Headset (92 x 1), AMD Ryzen 7 7700X (300 x 3), EPSON Printer (400 x 2), Keyboard (40 x 13)', 2312, '2025-02-05 16:47:22', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `details` varchar(500) NOT NULL,
  `price` int NOT NULL,
  `image_01` varchar(100) NOT NULL,
  `image_02` varchar(100) NOT NULL,
  `image_03` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `details`, `price`, `image_01`, `image_02`, `image_03`) VALUES
(3, 'Headset', 'This is headset', 92, 'home-img-3.png', 'images (4).jpeg', 'images (5).jpeg'),
(5, 'AMD Ryzen 7 7700X', 'AMD CPUs are high-performance processors known for their multi-core architecture, offering efficient parallel processing capabilities and competitive pricing. They utilize the Zen microarchitecture, delivering strong performance in gaming, content creation, and multi-threaded applications while supporting cutting-edge technologies like PCIe 4.0 and DDR4 memory.', 300, 'cpu.jpg', 'cpu.jpg', 'cpu.jpg'),
(6, 'Logitech Headset', 'Logitech headsets are known for their comfort, durability, and high-quality sound performance, designed for both gaming and professional use. Featuring advanced noise-canceling microphones, customizable sound profiles, and ergonomic designs, they cater to long hours of use with both wired and wireless options for various needs.', 70, 'headphone.jpg', 'headphone.jpg', 'headphone.jpg'),
(7, 'EPSON Printer', 'Epson printers are renowned for their reliability and high-quality printing, catering to both personal and professional use. They feature advanced technologies like PrecisionCore printheads, eco-friendly ink solutions, and versatile functionalities, including printing, scanning, and copying, with options for wireless and mobile connectivity.', 400, 'printer.png', 'printer.png', 'printer.png'),
(8, 'Mouse', 'A computer mouse is a handheld pointing device that enables users to interact with a computer&#39;s graphical interface by moving a cursor and executing commands through clicks. Modern mice come in various types, including optical, laser, and wireless, with additional features like customizable buttons, ergonomic designs, and high DPI for precise tracking.', 25, 'mouse.jpg', 'mouse.jpg', 'mouse.jpg'),
(9, 'MSI Monitor', 'MSI monitors are high-performance displays designed for gaming, productivity, and content creation, featuring vibrant colors and smooth visuals. They offer advanced features like high refresh rates, low response times, adaptive sync technologies, and ergonomic designs for an immersive and comfortable user experience.', 200, 'monitor.png', 'monitor.png', 'monitor.png'),
(10, 'MSI Laptop', 'MSI laptops are premium devices known for their high performance, durable build, and innovative designs, catering to gamers, creators, and professionals. They feature powerful hardware, including the latest Intel or AMD processors, NVIDIA GPUs, advanced cooling systems, and vibrant displays with high refresh rates for seamless multitasking and immersive experiences.', 1200, 'laptop.jpg', 'laptop.jpg', 'laptop.jpg'),
(11, 'Keyboard', 'A keyboard is an input device used to type text and execute commands on a computer, featuring an arrangement of keys for letters, numbers, and functions. Modern keyboards come in various types, including mechanical, membrane, and ergonomic designs, with additional features like RGB lighting, programmable keys, and wireless connectivity for enhanced user experience.', 40, 'keyboard.jpg', 'keyboard.jpg', 'keyboard.jpg'),
(12, 'External Hard Disk', 'An external hard drive is a portable storage device that connects to a computer via USB or other interfaces, offering additional space for data backup and transfer. Available in HDD or SSD formats, they provide varying capacities, fast read/write speeds, and durability for storing large files, making them ideal for personal and professional use.', 50, 'externalhard.jpg', 'externalhard.jpg', 'externalhard.jpg'),
(13, 'SSD', 'An SSD (Solid State Drive) is a high-speed storage device that uses flash memory to store data, offering faster read and write speeds compared to traditional hard drives. Known for their durability, energy efficiency, and compact design, SSDs significantly improve system performance, making them ideal for modern laptops, desktops, and servers.', 20, 'ssd.png', 'ssd.png', 'ssd.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES
(1, 'ThevinduW', 't@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pid` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
