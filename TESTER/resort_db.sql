-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2026 at 07:13 AM
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
  `remarks` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_month` varchar(20) DEFAULT NULL,
  `booking_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `customer_name`, `resort_name`, `room_number`, `check_in`, `check_out`, `total_price`, `food_items`, `remarks`, `created_at`, `booking_month`, `booking_date`) VALUES
(1, 'Aaron A. Santos', 'Ocean Oasis Suite', 113, '2026-10-05', '2026-10-06', 472.45, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'October', '2026-10-05'),
(2, 'Albert B. Reyes', 'Botanical Sanctuary', 447, '2026-10-12', '2026-10-13', 645.25, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'October', '2026-10-12'),
(3, 'Alex C. Cruz', 'Botanical Sanctuary', 212, '2026-08-27', '2026-08-28', 602.68, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-27'),
(4, 'Andrew D. Garcia', 'Sunset Crag Pavilion', 358, '2026-09-14', '2026-09-16', 781.92, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-14'),
(5, 'Anthony E. Mendoza', 'Emerald Canopy Treehouse', 275, '2026-09-03', '2026-09-07', 528.37, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-03'),
(6, 'Arthur F. Bautista', 'Minimalist Skyline', 421, '2026-10-18', '2026-10-21', 697.44, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-18'),
(7, 'Benjamin G. Flores', 'Ocean Oasis Suite', 184, '2026-09-21', '2026-09-24', 412.58, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-21'),
(8, 'Brandon H. Navarro', 'Sunset Crag Pavilion', 396, '2026-08-31', '2026-09-02', 735.61, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'August', '2026-08-31'),
(9, 'Caleb I. Torres', 'Botanical Sanctuary', 247, '2026-10-02', '2026-10-04', 568.29, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-02'),
(10, 'Cameron J. Aquino', 'Minimalist Skyline', 319, '2026-09-11', '2026-09-14', 824.73, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-11'),
(11, 'Carlos K. Castillo', 'Emerald Canopy Treehouse', 462, '2026-08-29', '2026-09-01', 451.86, 'None', NULL, '2026-08-26 05:09:20', 'August', '2026-08-29'),
(12, 'Cedric L. Morales', 'Ocean Oasis Suite', 128, '2026-09-26', '2026-09-27', 673.42, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-26'),
(13, 'Charles M. Ramirez', 'Botanical Sanctuary', 391, '2026-10-08', '2026-10-11', 756.19, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'October', '2026-10-08'),
(14, 'Chester N. Domingo', 'Sunset Crag Pavilion', 205, '2026-09-07', '2026-09-09', 384.65, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-07'),
(15, 'Clarence O. Mercado', 'Emerald Canopy Treehouse', 336, '2026-10-15', '2026-10-18', 618.37, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-15'),
(16, 'Clark P. Valdez', 'Minimalist Skyline', 478, '2026-08-30', '2026-09-03', 543.28, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-30'),
(17, 'Colin Q. Salazar', 'Ocean Oasis Suite', 156, '2026-09-18', '2026-09-20', 789.54, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-18'),
(18, 'Connor R. Manalo', 'Botanical Sanctuary', 284, '2026-10-21', '2026-10-23', 471.83, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-21'),
(19, 'Darren S. Herrera', 'Sunset Crag Pavilion', 427, '2026-09-02', '2026-09-06', 812.65, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-02'),
(20, 'David T. Santiago', 'Emerald Canopy Treehouse', 193, '2026-10-09', '2026-10-10', 395.42, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-09'),
(21, 'Dominic U. Villanueva', 'Ocean Oasis Suite', 365, '2026-09-28', '2026-10-01', 721.36, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-28'),
(22, 'Douglas V. Fernandez', 'Minimalist Skyline', 241, '2026-08-27', '2026-08-30', 654.77, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-27'),
(23, 'Edward W. Alvarado', 'Botanical Sanctuary', 414, '2026-10-01', '2026-10-05', 829.31, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-01'),
(24, 'Elijah X. Villareal', 'Sunset Crag Pavilion', 172, '2026-09-16', '2026-09-18', 573.62, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-16'),
(25, 'Elliot Y. Dela Cruz', 'Emerald Canopy Treehouse', 308, '2026-09-05', '2026-09-07', 488.94, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-05'),
(26, 'Emmanuel Z. Santos', 'Ocean Oasis Suite', 453, '2026-10-11', '2026-10-14', 706.18, 'Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-11'),
(27, 'Eric A. Reyes', 'Botanical Sanctuary', 226, '2026-08-28', '2026-08-31', 621.45, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-28'),
(28, 'Ethan B. Cruz', 'Minimalist Skyline', 389, '2026-09-23', '2026-09-25', 447.83, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-23'),
(29, 'Felix C. Garcia', 'Sunset Crag Pavilion', 116, '2026-10-06', '2026-10-08', 799.52, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-06'),
(30, 'Fernando D. Mendoza', 'Emerald Canopy Treehouse', 341, '2026-09-12', '2026-09-15', 586.29, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-12'),
(31, 'Francis E. Bautista', 'Ocean Oasis Suite', 264, '2026-08-26', '2026-08-29', 734.16, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'August', '2026-08-26'),
(32, 'Frank F. Flores', 'Botanical Sanctuary', 477, '2026-10-19', '2026-10-22', 518.74, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-19'),
(33, 'Frederick G. Navarro', 'Sunset Crag Pavilion', 203, '2026-09-30', '2026-10-02', 663.81, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'September', '2026-09-30'),
(34, 'George H. Torres', 'Minimalist Skyline', 352, '2026-09-08', '2026-09-10', 432.69, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-08'),
(35, 'Gerald I. Aquino', 'Emerald Canopy Treehouse', 438, '2026-10-03', '2026-10-06', 775.48, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-03'),
(36, 'Gian J. Castillo', 'Ocean Oasis Suite', 179, '2026-09-19', '2026-09-22', 547.35, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-19'),
(37, 'Gilbert K. Morales', 'Botanical Sanctuary', 321, '2026-08-30', '2026-09-01', 691.27, 'Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'August', '2026-08-30'),
(38, 'Gregory L. Ramirez', 'Sunset Crag Pavilion', 405, '2026-10-10', '2026-10-13', 823.65, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'October', '2026-10-10'),
(39, 'Harold M. Domingo', 'Emerald Canopy Treehouse', 289, '2026-09-04', '2026-09-06', 458.32, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-04'),
(40, 'Hector N. Mercado', 'Minimalist Skyline', 467, '2026-10-14', '2026-10-17', 712.46, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-14'),
(41, 'Henry O. Valdez', 'Ocean Oasis Suite', 143, '2026-09-25', '2026-09-28', 634.18, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-25'),
(42, 'Ian P. Salazar', 'Botanical Sanctuary', 376, '2026-08-27', '2026-08-29', 497.53, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-27'),
(43, 'Isaac Q. Manalo', 'Sunset Crag Pavilion', 254, '2026-09-17', '2026-09-21', 805.72, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-17'),
(44, 'Ivan R. Herrera', 'Emerald Canopy Treehouse', 418, '2026-10-07', '2026-10-09', 561.48, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-07'),
(45, 'Jack S. Santiago', 'Ocean Oasis Suite', 297, '2026-09-01', '2026-09-03', 678.26, 'Citrus Seared King Scallops, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-01'),
(46, 'Jacob T. Villanueva', 'Minimalist Skyline', 382, '2026-09-22', '2026-09-25', 742.91, 'Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-22'),
(47, 'Jared U. Fernandez', 'Botanical Sanctuary', 159, '2026-08-31', '2026-09-02', 519.64, 'None', NULL, '2026-08-26 05:09:20', 'August', '2026-08-31'),
(48, 'Jason V. Alvarado', 'Sunset Crag Pavilion', 444, '2026-10-12', '2026-10-16', 847.38, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-12'),
(49, 'Javier W. Villareal', 'Emerald Canopy Treehouse', 234, '2026-09-13', '2026-09-15', 389.72, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-13'),
(50, 'Jeremiah X. Dela Cruz', 'Ocean Oasis Suite', 415, '2026-10-04', '2026-10-07', 683.49, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-04'),
(51, 'Jeremy Y. Santos', 'Botanical Sanctuary', 268, '2026-09-09', '2026-09-11', 571.86, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-09'),
(52, 'Joel Z. Reyes', 'Minimalist Skyline', 329, '2026-08-29', '2026-09-02', 794.31, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-29'),
(53, 'Jonathan A. Cruz', 'Sunset Crag Pavilion', 486, '2026-09-20', '2026-09-23', 628.74, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-20'),
(54, 'Jordan B. Garcia', 'Emerald Canopy Treehouse', 218, '2026-10-16', '2026-10-18', 705.53, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-16'),
(55, 'Joseph C. Mendoza', 'Ocean Oasis Suite', 351, '2026-09-06', '2026-09-09', 476.19, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-06'),
(56, 'Joshua D. Bautista', 'Botanical Sanctuary', 137, '2026-10-08', '2026-10-10', 816.42, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-08'),
(57, 'Julian E. Flores', 'Sunset Crag Pavilion', 294, '2026-08-28', '2026-08-30', 592.83, 'None', NULL, '2026-08-26 05:09:20', 'August', '2026-08-28'),
(58, 'Justin F. Navarro', 'Minimalist Skyline', 463, '2026-09-15', '2026-09-19', 760.27, 'Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-15'),
(59, 'Keith G. Torres', 'Emerald Canopy Treehouse', 185, '2026-09-27', '2026-09-29', 453.66, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'September', '2026-09-27'),
(60, 'Kenneth H. Aquino', 'Ocean Oasis Suite', 406, '2026-10-20', '2026-10-23', 638.91, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-20'),
(61, 'Kevin I. Castillo', 'Botanical Sanctuary', 271, '2026-09-03', '2026-09-04', 422.57, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-03'),
(62, 'Kyle J. Morales', 'Sunset Crag Pavilion', 398, '2026-10-02', '2026-10-05', 781.46, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-02'),
(63, 'Lance K. Ramirez', 'Emerald Canopy Treehouse', 119, '2026-09-18', '2026-09-21', 557.82, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-18'),
(64, 'Lawrence L. Domingo', 'Minimalist Skyline', 445, '2026-08-27', '2026-08-29', 697.35, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-27'),
(65, 'Leonard M. Mercado', 'Ocean Oasis Suite', 308, '2026-09-10', '2026-09-12', 483.21, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-10'),
(66, 'Leo N. Valdez', 'Botanical Sanctuary', 167, '2026-10-06', '2026-10-10', 826.57, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-06'),
(67, 'Liam O. Salazar', 'Sunset Crag Pavilion', 377, '2026-09-23', '2026-09-26', 619.48, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-23'),
(68, 'Logan P. Manalo', 'Emerald Canopy Treehouse', 429, '2026-10-13', '2026-10-15', 536.74, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-13'),
(69, 'Louis Q. Herrera', 'Ocean Oasis Suite', 256, '2026-09-07', '2026-09-10', 745.29, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-07'),
(70, 'Lucas R. Santiago', 'Minimalist Skyline', 318, '2026-08-30', '2026-09-03', 580.16, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-30'),
(71, 'Marco S. Villanueva', 'Botanical Sanctuary', 402, '2026-09-12', '2026-09-14', 668.43, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-12'),
(72, 'Marcus T. Fernandez', 'Sunset Crag Pavilion', 229, '2026-10-17', '2026-10-20', 804.75, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'October', '2026-10-17'),
(73, 'Mario U. Alvarado', 'Emerald Canopy Treehouse', 361, '2026-09-26', '2026-09-28', 496.38, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-26'),
(74, 'Martin V. Villareal', 'Ocean Oasis Suite', 144, '2026-08-26', '2026-08-29', 712.84, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'August', '2026-08-26'),
(75, 'Matthew W. Dela Cruz', 'Botanical Sanctuary', 286, '2026-10-09', '2026-10-12', 648.91, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'October', '2026-10-09'),
(76, 'Maurice X. Santos', 'Minimalist Skyline', 419, '2026-09-19', '2026-09-20', 429.57, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-19'),
(77, 'Maxwell Y. Reyes', 'Sunset Crag Pavilion', 333, '2026-10-11', '2026-10-15', 836.24, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-11'),
(78, 'Michael Z. Cruz', 'Emerald Canopy Treehouse', 174, '2026-09-05', '2026-09-08', 593.72, 'Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-05'),
(79, 'Nathan A. Garcia', 'Ocean Oasis Suite', 452, '2026-09-29', '2026-10-02', 770.18, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-29'),
(80, 'Nathaniel B. Mendoza', 'Botanical Sanctuary', 215, '2026-08-31', '2026-09-04', 518.62, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-31'),
(81, 'Nicholas C. Bautista', 'Sunset Crag Pavilion', 367, '2026-10-03', '2026-10-06', 689.45, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'October', '2026-10-03'),
(82, 'Noah D. Flores', 'Minimalist Skyline', 291, '2026-09-16', '2026-09-18', 451.28, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-16'),
(83, 'Oliver E. Navarro', 'Emerald Canopy Treehouse', 413, '2026-09-08', '2026-09-10', 724.36, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-08'),
(84, 'Oscar F. Torres', 'Ocean Oasis Suite', 138, '2026-10-14', '2026-10-16', 576.19, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-14'),
(85, 'Owen G. Aquino', 'Botanical Sanctuary', 325, '2026-09-02', '2026-09-05', 812.74, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-02'),
(86, 'Paul H. Castillo', 'Sunset Crag Pavilion', 472, '2026-10-07', '2026-10-09', 638.25, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-07'),
(87, 'Peter I. Morales', 'Minimalist Skyline', 201, '2026-08-28', '2026-09-01', 483.76, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'August', '2026-08-28'),
(88, 'Philip J. Ramirez', 'Emerald Canopy Treehouse', 359, '2026-09-21', '2026-09-23', 705.62, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-21'),
(89, 'Ramon K. Domingo', 'Ocean Oasis Suite', 247, '2026-10-18', '2026-10-22', 819.47, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-18'),
(90, 'Randolph L. Mercado', 'Botanical Sanctuary', 387, '2026-09-11', '2026-09-13', 467.35, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-11'),
(91, 'Raymond M. Valdez', 'Sunset Crag Pavilion', 164, '2026-10-01', '2026-10-04', 611.82, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-01'),
(92, 'Richard N. Salazar', 'Minimalist Skyline', 436, '2026-09-25', '2026-09-27', 759.13, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-25'),
(93, 'Robert O. Manalo', 'Emerald Canopy Treehouse', 312, '2026-08-29', '2026-09-02', 543.76, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-29'),
(94, 'Rodrigo P. Herrera', 'Ocean Oasis Suite', 471, '2026-09-14', '2026-09-17', 681.25, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-14'),
(95, 'Roland Q. Santiago', 'Botanical Sanctuary', 195, '2026-10-10', '2026-10-12', 399.68, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-10'),
(96, 'Ronald R. Villanueva', 'Sunset Crag Pavilion', 348, '2026-09-06', '2026-09-08', 727.46, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-06'),
(97, 'Russell S. Fernandez', 'Minimalist Skyline', 425, '2026-10-16', '2026-10-19', 573.82, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-16'),
(98, 'Ryan T. Alvarado', 'Emerald Canopy Treehouse', 267, '2026-09-30', '2026-10-03', 845.17, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-30'),
(99, 'Samuel U. Villareal', 'Ocean Oasis Suite', 181, '2026-08-27', '2026-08-28', 419.55, 'None', NULL, '2026-08-26 05:09:20', 'August', '2026-08-27'),
(100, 'Scott V. Dela Cruz', 'Botanical Sanctuary', 393, '2026-09-17', '2026-09-20', 634.71, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-17'),
(101, 'Sean W. Santos', 'Sunset Crag Pavilion', 216, '2026-10-05', '2026-10-08', 768.39, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-05'),
(102, 'Sebastian X. Reyes', 'Minimalist Skyline', 479, '2026-09-23', '2026-09-25', 492.67, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-23'),
(103, 'Seth Y. Cruz', 'Emerald Canopy Treehouse', 302, '2026-10-12', '2026-10-14', 713.48, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-12'),
(104, 'Shane Z. Garcia', 'Ocean Oasis Suite', 155, '2026-09-04', '2026-09-07', 580.29, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-04'),
(105, 'Simon A. Mendoza', 'Botanical Sanctuary', 346, '2026-08-30', '2026-09-01', 671.83, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-30'),
(106, 'Stephen B. Bautista', 'Sunset Crag Pavilion', 427, '2026-09-09', '2026-09-12', 808.46, 'Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-09'),
(107, 'Steven C. Flores', 'Emerald Canopy Treehouse', 238, '2026-10-20', '2026-10-22', 527.91, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-20'),
(108, 'Terry D. Navarro', 'Minimalist Skyline', 368, '2026-09-13', '2026-09-16', 749.32, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'September', '2026-09-13'),
(109, 'Theodore E. Torres', 'Ocean Oasis Suite', 284, '2026-10-08', '2026-10-10', 418.73, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-08'),
(110, 'Thomas F. Aquino', 'Botanical Sanctuary', 409, '2026-09-27', '2026-09-30', 682.19, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-27'),
(111, 'Timothy G. Castillo', 'Sunset Crag Pavilion', 126, '2026-08-26', '2026-08-29', 594.68, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-26'),
(112, 'Tristan H. Morales', 'Emerald Canopy Treehouse', 357, '2026-09-20', '2026-09-22', 776.41, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-20'),
(113, 'Victor I. Ramirez', 'Ocean Oasis Suite', 442, '2026-10-03', '2026-10-07', 831.52, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-03'),
(114, 'Vincent J. Domingo', 'Botanical Sanctuary', 217, '2026-09-15', '2026-09-17', 537.84, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-15'),
(115, 'Walter K. Mercado', 'Minimalist Skyline', 376, '2026-08-31', '2026-09-02', 698.27, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'August', '2026-08-31'),
(116, 'Warren L. Valdez', 'Sunset Crag Pavilion', 463, '2026-10-09', '2026-10-12', 615.49, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-09'),
(117, 'Wayne M. Salazar', 'Emerald Canopy Treehouse', 248, '2026-09-01', '2026-09-04', 753.16, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-01'),
(118, 'William N. Manalo', 'Ocean Oasis Suite', 331, '2026-09-22', '2026-09-24', 481.73, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-22'),
(119, 'Xavier O. Herrera', 'Botanical Sanctuary', 419, '2026-10-17', '2026-10-20', 726.48, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'October', '2026-10-17'),
(120, 'Zachary P. Santiago', 'Sunset Crag Pavilion', 152, '2026-09-07', '2026-09-10', 604.35, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-07'),
(121, 'Adrian Q. Villanueva', 'Minimalist Skyline', 385, '2026-08-28', '2026-08-31', 557.92, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'August', '2026-08-28'),
(122, 'Angelo R. Fernandez', 'Emerald Canopy Treehouse', 264, '2026-10-04', '2026-10-06', 785.63, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-04'),
(123, 'Bryan S. Alvarado', 'Ocean Oasis Suite', 407, '2026-09-19', '2026-09-22', 636.28, 'Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-19'),
(124, 'Carlo T. Villareal', 'Botanical Sanctuary', 179, '2026-09-29', '2026-10-01', 718.94, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'September', '2026-09-29'),
(125, 'Christian U. Dela Cruz', 'Sunset Crag Pavilion', 318, '2026-10-13', '2026-10-15', 458.62, 'None', NULL, '2026-08-26 05:09:20', 'October', '2026-10-13'),
(126, 'Daniel V. Santos', 'Minimalist Skyline', 246, '2026-09-10', '2026-09-13', 824.17, 'Truffle Infused Kelp Ramen, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-10'),
(127, 'Diego W. Reyes', 'Emerald Canopy Treehouse', 431, '2026-08-29', '2026-09-01', 569.38, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'August', '2026-08-29'),
(128, 'Elvin X. Cruz', 'Ocean Oasis Suite', 294, '2026-10-06', '2026-10-08', 702.54, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-06'),
(129, 'Gabriel Y. Garcia', 'Botanical Sanctuary', 364, '2026-09-24', '2026-09-27', 779.46, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-24'),
(130, 'Jerome Z. Mendoza', 'Sunset Crag Pavilion', 219, '2026-09-03', '2026-09-06', 489.71, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-03'),
(131, 'Julius A. Bautista', 'Emerald Canopy Treehouse', 402, '2026-10-18', '2026-10-21', 816.29, 'Glazed Atlantic Cod, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'October', '2026-10-18'),
(132, 'Miguel B. Flores', 'Ocean Oasis Suite', 156, '2026-09-12', '2026-09-15', 645.83, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-12'),
(133, 'Patrick C. Navarro', 'Minimalist Skyline', 373, '2026-08-27', '2026-08-30', 532.46, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'August', '2026-08-27'),
(134, 'Rafael D. Torres', 'Botanical Sanctuary', 288, '2026-09-18', '2026-09-21', 713.57, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'September', '2026-09-18'),
(135, 'Rico E. Aquino', 'Sunset Crag Pavilion', 416, '2026-10-02', '2026-10-05', 836.41, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-02'),
(136, 'Rogelio F. Castillo', 'Emerald Canopy Treehouse', 225, '2026-09-26', '2026-09-28', 472.69, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-26'),
(137, 'Travis G. Morales', 'Ocean Oasis Suite', 391, '2026-10-10', '2026-10-13', 694.82, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'October', '2026-10-10'),
(138, 'Vince H. Ramirez', 'Botanical Sanctuary', 147, '2026-09-05', '2026-09-07', 573.28, 'Glazed Atlantic Cod, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-05'),
(139, 'Wilson I. Domingo', 'Minimalist Skyline', 438, '2026-08-30', '2026-09-02', 781.65, 'Citrus Seared King Scallops', NULL, '2026-08-26 05:09:20', 'August', '2026-08-30'),
(140, 'Zion J. Mercado', 'Sunset Crag Pavilion', 304, '2026-09-16', '2026-09-18', 428.93, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-16'),
(141, 'Alden K. Valdez', 'Emerald Canopy Treehouse', 361, '2026-10-07', '2026-10-10', 647.51, 'Aged Wagyu Carpaccio, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-07'),
(142, 'Andre L. Salazar', 'Ocean Oasis Suite', 196, '2026-09-11', '2026-09-14', 758.34, 'Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'September', '2026-09-11'),
(143, 'Arvin M. Manalo', 'Botanical Sanctuary', 427, '2026-10-15', '2026-10-17', 592.76, 'Citrus Seared King Scallops, Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'October', '2026-10-15'),
(144, 'Benedict N. Herrera', 'Sunset Crag Pavilion', 235, '2026-09-02', '2026-09-05', 816.73, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-02'),
(145, 'Brent O. Santiago', 'Minimalist Skyline', 314, '2026-09-28', '2026-10-01', 464.29, 'None', NULL, '2026-08-26 05:09:20', 'September', '2026-09-28'),
(146, 'Dylan P. Villanueva', 'Emerald Canopy Treehouse', 448, '2026-08-26', '2026-08-29', 735.18, 'Glazed Atlantic Cod', NULL, '2026-08-26 05:09:20', 'August', '2026-08-26'),
(147, 'Enzo Q. Fernandez', 'Ocean Oasis Suite', 276, '2026-10-11', '2026-10-14', 688.47, 'Citrus Seared King Scallops, Truffle Infused Kelp Ramen', NULL, '2026-08-26 05:09:20', 'October', '2026-10-11'),
(148, 'Gavin R. Alvarado', 'Botanical Sanctuary', 189, '2026-09-20', '2026-09-23', 527.61, 'Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-20'),
(149, 'Harvey S. Villareal', 'Botanical Sanctuary', 160, '2026-09-11', '2026-09-14', 782.46, 'Truffle Infused Kelp Ramen, Aged Wagyu Carpaccio', NULL, '2026-08-26 05:09:20', 'September', '2026-09-11');

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
(2, 'Mark Anthony D. Santos', 'anthony@email.com', '$argon2id$v=19$m=65536,t=4,p=1$c2FUbFVLblFaemNMRGZoeQ$QjJeVP+vVBDzgd8n9P0yg5yFuZhVt0h3W7BDMQCghqQ', '2026-08-26 12:53:07'),
(3, 'Kevin R. Villanueva', 'kevin@email.com', '$argon2id$v=19$m=65536,t=4,p=1$Qms1dE4uLzlsS1VMdThnLw$Zj+Nz+Jx8/J/nu45IMQU2aU5SAbbHlGA2mo0s5XpC+Q', '2026-08-26 12:54:55'),
(4, 'Daniel P. Mendoza', 'mendoza@email.com', '$argon2id$v=19$m=65536,t=4,p=1$NUQxbnpBZDVQZUFmNEN5Uw$oOHuglO/p6q9WJmHaa4uZeXGX4/c5ezYl+kRoZBjUG4', '2026-08-26 12:56:27'),
(5, 'Joshua C. Ramirez', 'ramirez@email.com', '$argon2id$v=19$m=65536,t=4,p=1$Q1dZeXpYMC9jUW9hL2JCMA$Zz/QHGC//BwkWcya4j29WyYcJEeDH8Gq9zpReqYnhYc', '2026-08-26 12:58:08'),
(6, 'Adrian L. Bautista', 'bautista@email.com', '$argon2id$v=19$m=65536,t=4,p=1$OWtzMEtyblNKNldQNU0xMw$4Xh2lHMs6Ldgturq32Ly2KHBlst8z9iTEPQ6OGfZQ2M', '2026-08-26 12:59:04'),
(7, 'Christian M. Flores', 'flores@email.com', '$argon2id$v=19$m=65536,t=4,p=1$bDRLNmZoRzY2eGUvTzBKRA$vMwK7yZ1vBqmohY5+5L43UzeoUl9g+DnpZ0jgeezXFc', '2026-08-26 13:00:06'),
(8, 'Nathaniel J. Cruz', 'cruz@email.com', '$argon2id$v=19$m=65536,t=4,p=1$RzM0RE1BNVQxcTBzaHFOTw$2PH2uZD6Opucf3T9T0u6hkk4631puAjFzebUWI8m0fQ', '2026-08-26 13:01:15'),
(9, 'Miguel A. Navarro', 'navarro@email.com', '$argon2id$v=19$m=65536,t=4,p=1$U3hqQ1J0cEh0blFnaWhyVQ$sq17l5rOxEVkHVKEAW/2eIzsxmduIzqzr9zAOqi9eVs', '2026-08-26 13:02:03'),
(10, 'Patrick S. Reyes', 'reyes@email.com', '$argon2id$v=19$m=65536,t=4,p=1$SmZnVjlDNzhCcmFYa0EvTw$ROP46rS3MR9XI90eKmPnl+BkyJNliuByCJzVJK59L0Y', '2026-08-26 13:04:09');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

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
