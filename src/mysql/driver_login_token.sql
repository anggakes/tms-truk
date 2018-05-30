-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Waktu pembuatan: 13 Bulan Mei 2018 pada 12.30
-- Versi server: 10.2.14-MariaDB-10.2.14+maria~jessie
-- Versi PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `goodevam_stms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver_login_token`
--

CREATE TABLE `driver_login_token` (
  `id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `driver_login_token`
--

INSERT INTO `driver_login_token` (`id`, `token`, `timestamp`, `driver_id`) VALUES
(4, '279838fe05d01c878f40af5a4274a60d', '2018-05-06 12:28:11', 12),
(5, '20cef24b7302a24b5c88fa6951af3bc2', '2018-05-06 13:38:05', 12),
(6, '689fb567f4654aff5891e11c448a5505', '2018-05-06 13:38:16', 12),
(7, '9183466eba55bbde6c89f67d2946a640', '2018-05-06 13:38:40', 12),
(8, '10b44e14010cf3da6f72f287d6191f59', '2018-05-06 13:39:29', 12),
(9, 'cb1b2d9ab83195fd240e721d5c068910', '2018-05-06 22:33:45', 12),
(10, '3ac39cf53043e51d94be5e4099d2d9bd', '2018-05-06 22:42:29', 12),
(19, '5eb3097d951158bb117215de9966c904', '2018-05-08 03:46:30', 12),
(20, 'e96c2b393e1f4810155a4426adc28aa7', '2018-05-10 17:13:17', 12),
(21, 'e431bcb3704b0363418a47d483a6cb94', '2018-05-12 11:43:43', 12),
(22, '40243091e6b2c2c61ce2996ae8b7588d', '2018-05-13 05:23:35', 12),
(23, 'de511647d49101ff15d1ae37c69d64ab', '2018-05-13 12:04:11', 12),
(24, '1f5d0441aa651297c5a2080ad72c4826', '2018-05-13 12:21:59', 12);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `driver_login_token`
--
ALTER TABLE `driver_login_token`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `driver_login_token`
--
ALTER TABLE `driver_login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
