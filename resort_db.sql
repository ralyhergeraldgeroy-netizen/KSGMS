-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2026 at 04:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_month` varchar(20) DEFAULT NULL,
  `booking_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `resort_name`, `room_number`, `check_in`, `check_out`, `total_price`, `food_items`, `remarks`, `created_at`, `booking_month`, `booking_date`) VALUES
(1, 'Gerald M. Geroy', 'Emerald Canopy Treehouse', 374, '2026-07-07', '2026-07-10', 473.99, 'Citrus Seared King Scallops, Aged Wagyu Carpaccio', NULL, '2026-07-07 11:25:01', NULL, NULL),
(2, 'Marjun S. Carriaga', 'Minimalist Skyline', 416, '2026-07-07', '2026-07-10', 504.00, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-07-07 11:26:11', NULL, NULL),
(3, 'John Miacheal C. Andres', 'Botanical Sanctuary', 356, '2026-07-07', '2026-07-10', 390.00, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-07-07 11:27:06', NULL, NULL),
(4, 'Robenar John M. Cinco', 'Emerald Canopy Treehouse', 341, '2026-07-09', '2026-07-12', 524.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-07-09 06:56:21', NULL, NULL),
(5, 'Alvin C. Abad', 'Sunset Crag Pavilion', 291, '2026-07-09', '2026-07-12', 714.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-07-09 07:07:23', NULL, NULL),
(6, 'Jerby Carl M. Geroy', 'Ocean Oasis Suite', 145, '2026-07-09', '2026-07-12', 685.00, 'Citrus Seared King Scallops, Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-07-09 07:34:18', NULL, NULL),
(7, 'Ryzil Jane', 'Ocean Oasis Suite', 138, '2026-08-03', '2026-08-06', 714.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-03 02:59:30', NULL, NULL),
(8, 'Ryzil Jane', 'Minimalist Skyline', 409, '2026-08-03', '2026-08-06', 584.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-03 03:03:39', NULL, NULL),
(9, 'punisher', 'Botanical Sanctuary', 229, '2026-08-11', '2026-08-14', 394.00, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-11 02:46:31', NULL, NULL),
(10, 'punisher', 'Ocean Oasis Suite', 271, '2026-08-11', '2026-08-14', 714.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-11 02:46:55', NULL, NULL),
(11, 'punisher', 'Botanical Sanctuary', 471, '2876-03-21', '2876-03-24', 474.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', 'i have a baby boys with six pack abs and the name is arkin', '2026-08-11 03:12:41', NULL, NULL),
(12, 'punisher', 'Emerald Canopy Treehouse', 497, '2027-12-25', '2027-12-28', 524.00, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod, Aged Wagyu Carpaccio', 'i have a dog and  marjun in the house with his wife\r\nand i have so many chicks in the house no matter how my dog is small', '2026-08-11 03:53:44', NULL, NULL);

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
(1, 'Gerald M. Geroy', 'geraldgeroy@email.com', '$argon2id$v=19$m=65536,t=4,p=1$OFI4bXAuVkNZV1lka1ZINQ$snqzqjn9rLle8QCz78d8irIosfMlUqL2m2FmgIrLCg0', '2026-07-07 19:24:24'),
(2, 'Marjun S. Carriaga', 'carriagamarjun@email.com', '$argon2id$v=19$m=65536,t=4,p=1$L1pselZiR3p2d1dzb2tJdA$W2se0vq90DVPtXLy/vo5/JkdB64oisakjfr5YG0WUac', '2026-07-07 19:26:05'),
(3, 'John Miacheal C. Andres', 'andres@email.com', '$argon2id$v=19$m=65536,t=4,p=1$QjFQTHVzSUo1TmFMNnZ1NQ$o1m9HG/g1j4yJgLklo5Sv0U9WeANK3ZF1rJ2H3F9xxA', '2026-07-07 19:27:01'),
(4, 'Robenar John M. Cinco', 'johncinco@email.com', '$argon2id$v=19$m=65536,t=4,p=1$LkZBOVM1bnBFbm1MUmF2ZQ$SsxtNk8YkQcHzvDPYZeSBqTK/rL0qdtkIXwJ/LvxqQI', '2026-07-09 14:56:12'),
(5, 'Alvin C. Abad', 'alvinabad@email.com', '$argon2id$v=19$m=65536,t=4,p=1$VG1uNlVpbFU1eENTWkdiQg$HNSv1fvz6M/zpCPmEQxbT36Ss/cGpzSznFe9RKsqUUY', '2026-07-09 15:07:15'),
(6, 'Jerby Carl M. Geroy', 'jerbygeroy@email.com', '$argon2id$v=19$m=65536,t=4,p=1$QkxtRENSUFVxRGlGRjludA$WoEU12YdSkY/+HgoBlE8/x7DovD0TwOhdM/MkGOcoTA', '2026-07-09 15:34:05'),
(7, 'liamboss', 'akoliam@email.com', '$argon2id$v=19$m=65536,t=4,p=1$NUlZZjY5RVJnVms0eGt1Tg$saCXyXiaD6b2A8dkN+wEKHq/hwkm8x7bucXJNfG+iqk', '2026-08-03 10:52:47'),
(8, 'Ryzil Jane', 'Ryzil@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$WC5uRDNoQVNkbE4wU25jMA$gMKmrx0Rd65ySmprLXrGe/I46WY8X75VVbpE36NtHqo', '2026-08-03 10:58:56'),
(9, 'afedsfaf', 'wafsf@EMAIL.COM', '$argon2id$v=19$m=65536,t=4,p=1$LjNocmhzWUg4cjZValhabA$7dZkkgYASzpTajsg7BL9Jh91AtEgst6n2Kq4BIGNT6k', '2026-08-10 11:55:34'),
(10, 'punisher', 'frank@email.com', '$argon2id$v=19$m=65536,t=4,p=1$TXBwY2RRMjJzeFAvZzhDaQ$6b3qWKs7WOkZs5Zu3jQ/yXX65u2JDFMm+oebyQ6yxjQ', '2026-08-11 10:45:32');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
