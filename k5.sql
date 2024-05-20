-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Bulan Mei 2024 pada 15.16
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

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
-- Struktur dari tabel `isvalid`
--

CREATE TABLE `isvalid` (
  `id` int(11) NOT NULL,
  `SuaraSah` int(11) DEFAULT 1,
  `SuaraTidakSah` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jumlah_suara`
--

CREATE TABLE `jumlah_suara` (
  `id` int(11) NOT NULL,
  `Jumlah_pemilih` decimal(32,0) DEFAULT NULL,
  `Metode` varchar(50) DEFAULT NULL,
  `Lokasi` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `jumlah_suara`
--

INSERT INTO `jumlah_suara` (`id`, `Jumlah_pemilih`, `Metode`, `Lokasi`) VALUES
(20, '99', 'TPS002', 'Dubai'),
(21, '0', 'TPS001', 'Bandung');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kandidat`
--

CREATE TABLE `kandidat` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `partai_id` int(11) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kandidat`
--

INSERT INTO `kandidat` (`id`, `nama`, `partai_id`, `foto`) VALUES
(1, 'KONDIDAT 1', NULL, '1.png'),
(2, 'KONDIDAT 2', NULL, '2.png'),
(3, 'KONDIDAT 3', NULL, '3.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `partai`
--

CREATE TABLE `partai` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `suara`
--

CREATE TABLE `suara` (
  `id` int(11) NOT NULL,
  `kandidat_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_valid` tinyint(4) NOT NULL DEFAULT 1,
  `tps_no` varchar(10) DEFAULT NULL,
  `ksk_no` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `suara`
--

INSERT INTO `suara` (`id`, `kandidat_id`, `timestamp`, `is_valid`, `tps_no`, `ksk_no`) VALUES
(3275, 1, '2024-05-19 13:02:50', 1, '1', NULL),
(3276, 2, '2024-05-19 13:02:59', 1, '1', NULL),
(3277, 2, '2024-05-19 13:03:07', 0, '1', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `suara_partai`
--

CREATE TABLE `suara_partai` (
  `id` int(11) NOT NULL,
  `partai_id` int(11) DEFAULT NULL,
  `timestamp` datetime DEFAULT current_timestamp(),
  `is_valid` tinyint(4) NOT NULL DEFAULT 1,
  `tps_no` varchar(10) DEFAULT NULL,
  `ksk_no` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tps_no` varchar(10) DEFAULT NULL,
  `ksk_no` varchar(1) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `userpic` mediumblob DEFAULT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `tps_no`, `ksk_no`, `email`, `userpic`, `role`) VALUES
(1, 'Administrator', 'admin', 'admin', NULL, NULL, NULL, NULL, 1),
(32, 'Asro', 'asro', 'asro', 'TPS001', NULL, NULL, NULL, 0),
(33, 'nurdhiat', 'nurdhiat', 'nurdhiat', 'TPS002', NULL, NULL, NULL, 0),
(34, 'malik', 'malik', 'malik', 'TPS003', NULL, NULL, NULL, 0),
(35, 'Lelita', 'lelita', 'lelita', 'TPS004', NULL, NULL, NULL, 0),
(39, 'Hedi', 'hedi', 'hedi', 'TPS005', NULL, NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `isvalid`
--
ALTER TABLE `isvalid`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `jumlah_suara`
--
ALTER TABLE `jumlah_suara`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partai_id` (`partai_id`);

--
-- Indeks untuk tabel `partai`
--
ALTER TABLE `partai`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `suara`
--
ALTER TABLE `suara`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kandidat_id` (`kandidat_id`);

--
-- Indeks untuk tabel `suara_partai`
--
ALTER TABLE `suara_partai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partai_id` (`partai_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `isvalid`
--
ALTER TABLE `isvalid`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jumlah_suara`
--
ALTER TABLE `jumlah_suara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `partai`
--
ALTER TABLE `partai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `suara`
--
ALTER TABLE `suara`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3278;

--
-- AUTO_INCREMENT untuk tabel `suara_partai`
--
ALTER TABLE `suara_partai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kandidat`
--
ALTER TABLE `kandidat`
  ADD CONSTRAINT `kandidat_ibfk_1` FOREIGN KEY (`partai_id`) REFERENCES `partai` (`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `suara`
--
ALTER TABLE `suara`
  ADD CONSTRAINT `suara_ibfk_1` FOREIGN KEY (`kandidat_id`) REFERENCES `kandidat` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `suara_partai`
--
ALTER TABLE `suara_partai`
  ADD CONSTRAINT `suara_partai_ibfk_1` FOREIGN KEY (`partai_id`) REFERENCES `partai` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
