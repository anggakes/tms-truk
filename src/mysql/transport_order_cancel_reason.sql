-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Waktu pembuatan: 13 Bulan Mei 2018 pada 12.29
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
-- Struktur dari tabel `transport_order_cancel_reason`
--

CREATE TABLE `transport_order_cancel_reason` (
  `id_transport_order_cancel_reason` int(11) NOT NULL,
  `ref_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transport_order_cancel_reason`
--

INSERT INTO `transport_order_cancel_reason` (`id_transport_order_cancel_reason`, `ref_id`, `status`, `reason`) VALUES
(1, '24', 'tidak terkirim', 'asdasdasd'),
(2, '24', 'unloading', 'asdasdasd'),
(3, '25', 'unloading', 'asdasdasd'),
(4, '24', 'loading', 'asdasdasd'),
(5, '25', 'loading', 'asdasdasd'),
(6, '21', 'loading', 'asdasdasd');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `transport_order_cancel_reason`
--
ALTER TABLE `transport_order_cancel_reason`
  ADD PRIMARY KEY (`id_transport_order_cancel_reason`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `transport_order_cancel_reason`
--
ALTER TABLE `transport_order_cancel_reason`
  MODIFY `id_transport_order_cancel_reason` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
