-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2024 at 11:37 AM
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
-- Database: `k5`
--

-- --------------------------------------------------------

--
-- Table structure for table `isvalid`
--

CREATE TABLE `isvalid` (
  `id` int(11) NOT NULL,
  `SuaraSah` int(11) DEFAULT 1,
  `SuaraTidakSah` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jumlah_suara`
--

CREATE TABLE `jumlah_suara` (
  `id` int(11) NOT NULL,
  `Jumlah_pemilih` decimal(32,0) DEFAULT NULL,
  `Metode` varchar(50) DEFAULT NULL,
  `Lokasi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `jumlah_suara`
--

INSERT INTO `jumlah_suara` (`id`, `Jumlah_pemilih`, `Metode`, `Lokasi`) VALUES
(1, 0, '1', 'Dubai'),
(2, 0, '2', 'Dubai'),
(3, 5, '3', 'Dubai'),
(4, 2, '4', 'Dubai'),
(5, 3, '5', 'Dubai'),
(6, 2, '6', 'Dubai'),
(7, 0, '7', 'Dubai'),
(8, 0, '8', 'Dubai'),
(9, 0, '9', 'Ras Al Khaimah'),
(10, 0, '10', 'Fujairah dan Umm Al Quwain'),
(11, 0, '11', 'Sharjah, Ajman, dan Dubai'),
(12, 0, '12', 'Sharjah'),
(13, 100, '13', 'Bandung'),
(14, 75, '25', 'Bandung');

-- --------------------------------------------------------

--
-- Table structure for table `kandidat`
--

CREATE TABLE `kandidat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `partai_id` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `kandidat`
--

INSERT INTO `kandidat` (`id`, `nama`, `partai_id`, `foto`) VALUES
(1, 'KONDIDAT 1', NULL, '1.png'),
(2, 'KONDIDAT 2', NULL, '2.png'),
(3, 'KONDIDAT 3', NULL, '3.png');

-- --------------------------------------------------------

--
-- Table structure for table `partai`
--

CREATE TABLE `partai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suara`
--

CREATE TABLE `suara` (
  `id` int(11) NOT NULL,
  `kandidat_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_valid` tinyint(4) NOT NULL DEFAULT 1,
  `tps_no` varchar(10) DEFAULT NULL,
  `ksk_no` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `suara`
--

INSERT INTO `suara` (`id`, `kandidat_id`, `timestamp`, `is_valid`, `tps_no`, `ksk_no`) VALUES
(3275, 1, '2024-05-19 13:02:50', 1, '1', NULL),
(3276, 2, '2024-05-19 13:02:59', 1, '1', NULL),
(3277, 2, '2024-05-19 13:03:07', 0, '1', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suara_partai`
--

CREATE TABLE `suara_partai` (
  `id` int(11) NOT NULL,
  `partai_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_valid` tinyint(4) NOT NULL DEFAULT 1,
  `tps_no` varchar(10) DEFAULT NULL,
  `ksk_no` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tps_no` varchar(10) DEFAULT NULL,
  `ksk_no` varchar(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `userpic` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `tps_no`, `ksk_no`, `email`, `userpic`) VALUES
(2, 'DEV', 'admin', 'Z0ya$2021', '', NULL, '', NULL),
(19, 'TPSLN 01', 'tps1', 'tps1', '1', NULL, NULL, NULL),
(20, 'TPSLN 02', 'tps2', 'tps2', '2', NULL, NULL, NULL),
(21, 'TPS 03', 'tps3', 'tps3', '3', '', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `isvalid`
--
ALTER TABLE `isvalid`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jumlah_suara`
--
ALTER TABLE `jumlah_suara`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kandidat`
--
ALTER TABLE `kandidat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partai_id` (`partai_id`);

--
-- Indexes for table `partai`
--
ALTER TABLE `partai`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suara`
--
ALTER TABLE `suara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kandidat_id` (`kandidat_id`);

--
-- Indexes for table `suara_partai`
--
ALTER TABLE `suara_partai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partai_id` (`partai_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `isvalid`
--
ALTER TABLE `isvalid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jumlah_suara`
--
ALTER TABLE `jumlah_suara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kandidat`
--
ALTER TABLE `kandidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `partai`
--
ALTER TABLE `partai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `suara`
--
ALTER TABLE `suara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3278;

--
-- AUTO_INCREMENT for table `suara_partai`
--
ALTER TABLE `suara_partai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kandidat`
--
ALTER TABLE `kandidat`
  ADD CONSTRAINT `kandidat_ibfk_1` FOREIGN KEY (`partai_id`) REFERENCES `partai` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Constraints for table `suara`
--
ALTER TABLE `suara`
  ADD CONSTRAINT `suara_ibfk_1` FOREIGN KEY (`kandidat_id`) REFERENCES `kandidat` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `suara_partai`
--
ALTER TABLE `suara_partai`
  ADD CONSTRAINT `suara_partai_ibfk_1` FOREIGN KEY (`partai_id`) REFERENCES `partai` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
