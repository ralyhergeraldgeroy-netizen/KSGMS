-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2026 at 08:59 AM
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
-- Database: `resort_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `resort_name` varchar(255) NOT NULL,
  `room_number` int(11) NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `food_items` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_month` varchar(20) DEFAULT NULL,
  `booking_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `resort_name`, `room_number`, `check_in`, `check_out`, `total_price`, `food_items`, `created_at`, `booking_month`, `booking_date`) VALUES
(6, 'anthony villegas', 'Ocean Oasis Suite', 428, '2026-06-24', '2026-06-27', 714.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', '2026-06-24 06:56:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `resorts`
--

CREATE TABLE `resorts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `price_per_night` decimal(10,2) NOT NULL,
  `status` enum('Available','Fully Booked') DEFAULT 'Available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resorts`
--

INSERT INTO `resorts` (`id`, `name`, `location`, `price_per_night`, `status`, `created_at`) VALUES
(1, 'Paradise Beach Resort', 'Maldives', 250.00, 'Available', '2026-06-21 09:08:01'),
(2, 'Alpine Ski Lodge', 'Switzerland', 180.00, 'Available', '2026-06-21 09:08:01');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_number` varchar(10) DEFAULT NULL,
  `room_type` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `max_adults` int(11) DEFAULT NULL,
  `max_children` int(11) DEFAULT NULL,
  `base_price` decimal(10,2) DEFAULT NULL,
  `weekend_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Available',
  `floor` int(11) DEFAULT NULL,
  `has_aircon` tinyint(1) DEFAULT NULL,
  `has_wifi` tinyint(1) DEFAULT NULL,
  `has_sea_view` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `resort_id` int(11) NOT NULL,
  `room_number` varchar(50) NOT NULL,
  `room_type` enum('Single','Double','Suite','Penthouse') NOT NULL,
  `is_reserved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `resort_id`, `room_number`, `room_type`, `is_reserved`) VALUES
(1, 1, 'Room 101', 'Suite', 0),
(2, 1, 'Room 102', 'Penthouse', 0),
(3, 2, 'Cabin A', 'Double', 0),
(4, 2, 'Cabin B', 'Single', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(27, 'andressbayot', 'andressbayoot@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$S3VqRmxyOUpCaXVoVkZBZg$tlb/Mrk6kTELLRDB7Vq30X6o8o15+CpJ+z+ntWxPilY', '2026-06-23 11:16:08'),
(28, 'johnmichaelandres', 'andres@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$Y2tSLmZRVGdmNGR0Mk9YUQ$hGdZgIF/fBfUPvzsEUimx/oSrd0L7IV7qFqvunYersk', '2026-06-23 11:20:10'),
(29, 'kakakakkaka', 'akkakakakak@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$cjY0aVB2VXUwUzcxcWlrOQ$pomhQfSWB7i726lWQ88/h47YJ9sAgqdLcUEWQoEA81o', '2026-06-23 11:21:36'),
(30, 'KARL', 'KARL@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$d2Y3amVZRGJoOUczc3FXSg$FuH45GCacYjAfKaTrHrMP3mPg5Ft7KtCmlDIZAI8du0', '2026-06-23 11:23:06'),
(31, 'KAKAKAKA', 'LALALLALAL@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$dFNKMTIveTdIMkdJbXI1Yw$P/eWMq/k2b9F5wvrkfjFAIratgeSdP1PXN8HDEEg8nI', '2026-06-23 11:28:27'),
(32, 'HHAHAHA', 'HAHAHAH@GMail.com', '$argon2id$v=19$m=65536,t=4,p=1$Y1owbVVoS21ETjkxT3UxYQ$BbJKMSi52eWs4whElAIPKfl8z7XIzVpRy4pIwtRSZ2E', '2026-06-23 11:33:26'),
(33, 'jaskfhuahvue', 'mnjsvjnhasvhe@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$eU5vZXdkek56Snl3bWJNTA$iev2taB55FJQ1yZEZA0QRAEs9tE94Zsu/6wC2q+e1Zs', '2026-06-23 11:39:12'),
(34, 'admin', 'HAHAHA@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$d2d2UUlxYWFpeEJScXUzTg$tenNYKTzI1RzUIHIDM/8ZaLwovX+elqTw4el5H9A1tQ', '2026-06-23 11:42:16'),
(35, 'wow', 'wow@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$aHl6SFRaZ0NKaXFyd0cuag$OzMN/n45iDw5G4Zjxg/jzHMSaHSPGZIKjMXE93eGNxw', '2026-06-23 11:51:34'),
(36, 'sdagasdgsa', 'dsadasdasda@email.com', '$argon2id$v=19$m=65536,t=4,p=1$VjM1OFh6VzgzV29yRklMZA$lb5dUKPZmwBcce14UJ+C9/m5OmB4aX2dvrItKD3G3PE', '2026-06-23 11:56:27'),
(37, 'asdasdasda', 'ebhawiegae@email.com', '$argon2id$v=19$m=65536,t=4,p=1$WGNJMFh4UDFSZHhGSFdUQg$YVXazD7x/F97KrgXWeFqoVx4G5CG1eluA7koDHPNbnQ', '2026-06-23 11:57:11'),
(38, 'sdgsdgds', 'jkhsdfhufhah@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$MWJxcVAxYzI1Ti85VGw5dA$HbClv+pJlmNj2npwhp53sD+FlQgSbTsZvNm6yUfY/C8', '2026-06-23 12:15:10'),
(39, 'liamarthusbensi', 'liam@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$S2c2Rk5UREtXMnk4SmVxVA$1+ncjuTo3JiUcRa7xR33D3wTYPJD7KLGdThFNtBEfRo', '2026-06-23 12:17:05'),
(40, 'michael', 'andres@email.com', '$argon2id$v=19$m=65536,t=4,p=1$ckFneDM0cTFXaG1lSGNDLg$INotqIyfVowS85JPqngfBQiPxO1vTItRSoV0eLOUyJA', '2026-06-23 13:24:56'),
(41, 'kyocirilol', 'kyo123@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$UzVHd3MzYTlEbWRWSW16aA$cYG+KtktrSVdyE2Awe3lcj4Y2UbF9UvrTY5SC577n8o', '2026-06-23 13:29:36'),
(42, 'scnhyascha', 'cbhchha@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$T1FsL1FwVXlid3VrMS5QMg$/skVokAjNDoc8Z/DUizjrNwWcmsQ+PVV/ZVtAJxBsWc', '2026-06-24 14:50:40'),
(43, 'anthony villegas', 'villegaspogi123@gmail', '$argon2id$v=19$m=65536,t=4,p=1$UTBIN0l6eUhmci51V093MA$R/hgfpDzWBpG4Q77iZahsQGpx2RttVvOYkhG8IgvJek', '2026-06-24 14:55:52');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resorts`
--
ALTER TABLE `resorts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resort_id` (`resort_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `resorts`
--
ALTER TABLE `resorts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`resort_id`) REFERENCES `resorts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
