-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 08:49 AM
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
-- Database: `pbo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `full_name`, `email`, `password`, `created_at`) VALUES
(1, 'rehan', 'rehan@gmail.com', '$2y$10$Gw1NB50D3W.iLhh6dcmI2.Q4Q4udJyftzQXgGF5lrBPM81QaB5V4W', '2024-12-03 17:01:59'),
(2, 'Hengky Gunawan', 'kyy@gmail.com', '$2y$10$b8HDspSt4zoTgvylzc5WAeESI1MWlSBnUeFFk9taD5CsdmkHlqrqG', '2024-12-05 03:38:15');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(255) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `tipe_menu` varchar(50) NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `harga`, `tipe_menu`, `gambar`) VALUES
(2, 'Ice Tea', 10000.00, 'minuman', 'es teh.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `nama` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `role_user` enum('admin','user','','') DEFAULT NULL,
  `id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`nama`, `email`, `username`, `password`, `role_user`, `id`) VALUES
('intan', 'intan@gmail.com', 'intandong', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 1),
('sasa', 'salsa@gmail.com', 'salsa', '202cb962ac59075b964b07152d234b70', 'user', 2),
('ery', 'ery@gmail.com', 'ery', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 3),
('admin', 'admin@gmail.com', 'mince', '827ccb0eea8a706c4c34a16891f84e7b', 'admin', 4),
('saya', 'saya123@gmail.com', 'iya', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 5);

-- --------------------------------------------------------

--
-- Table structure for table `reservasiadmin`
--

CREATE TABLE `reservasiadmin` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `restaurant_name` varchar(255) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `number_of_people` int(11) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservasiadmin`
--

INSERT INTO `reservasiadmin` (`id`, `name`, `phone`, `email`, `restaurant_name`, `booking_date`, `booking_time`, `number_of_people`, `notes`) VALUES
(10, 'Hengky Gunawan', '085716891435', 'kyy@gmail.com', 'GoTan: Savor The Flavor', '2024-12-19', '11:37:00', 2, 'hh'),
(14, '', '', '', '', '0000-00-00', '00:00:00', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `place` varchar(255) NOT NULL,
  `booking_time` datetime NOT NULL,
  `people_count` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `place`, `booking_time`, `people_count`, `full_name`, `phone_number`, `email`, `notes`) VALUES
(1, 'Indoor', '2024-12-20 12:47:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'njnj'),
(2, 'Outdoor', '2024-12-27 16:49:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'vgv'),
(3, 'Outdoor', '2025-01-01 16:51:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'cde'),
(4, 'Outdoor', '2024-12-26 12:54:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'vgv'),
(5, 'Outdoor', '2024-12-17 15:56:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'cde'),
(6, 'Outdoor', '2024-12-19 23:58:00', 2, 'j j j', ' 00998', 'salsa@gmail.com', '  kmkmkmk'),
(7, 'Outdoor', '2024-12-26 01:09:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'cde'),
(8, 'Outdoor', '2024-12-19 01:10:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'cde'),
(9, 'Indoor', '2024-12-12 00:47:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'njnkmk'),
(10, 'Indoor', '2024-12-12 00:47:00', 2, 'sasa', '09877777777', 'salsa@gmail.com', 'njnkmk'),
(11, 'Indoor', '2024-12-12 00:47:00', 1, 'sasa', '09877777', 'salsa@gmail.com', 'bhbujnkmk'),
(12, 'Indoor', '2024-12-12 00:47:00', 1, 'sasa', '09877777', 'salsa@gmail.com', 'bhbujnkmk');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reservasiadmin`
--
ALTER TABLE `reservasiadmin`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reservasiadmin`
--
ALTER TABLE `reservasiadmin`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
