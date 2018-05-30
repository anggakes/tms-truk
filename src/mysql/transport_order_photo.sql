-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Waktu pembuatan: 13 Bulan Mei 2018 pada 05.18
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
-- Struktur dari tabel `transport_order_photo`
--

CREATE TABLE `transport_order_photo` (
  `id_transport_order_photo` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `ref_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transport_order_photo`
--

INSERT INTO `transport_order_photo` (`id_transport_order_photo`, `url`, `status`, `ref_id`) VALUES
(1, 'RunAppDownload.jpg', 'selesai muat', '2'),
(2, 'http://localhost/index.php/files/images/RunAppDownload.jpg', 'selesai muat', '2'),
(3, 'http://localhost/files/images/RunAppDownload.jpg', 'selesai muat', '2');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `transport_order_photo`
--
ALTER TABLE `transport_order_photo`
  ADD PRIMARY KEY (`id_transport_order_photo`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `transport_order_photo`
--
ALTER TABLE `transport_order_photo`
  MODIFY `id_transport_order_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
