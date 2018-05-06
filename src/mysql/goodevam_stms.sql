-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 05 Bulan Mei 2018 pada 13.14
-- Versi server: 5.6.36-82.1-log
-- Versi PHP: 7.1.16

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

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`goodevam_stms`@`localhost` PROCEDURE `prcDeleteRoute` (IN `_sessionID` VARCHAR(50))  BEGIN
  DELETE FROM gpslocations
  WHERE sessionID = _sessionID;
END$$

CREATE DEFINER=`goodevam_stms`@`localhost` PROCEDURE `prcGetAllRoutesForMap` ()  BEGIN
SELECT sessionId, gpsTime, CONCAT('{ "latitude":"', CAST(latitude AS CHAR),'", "longitude":"', CAST(longitude AS CHAR), '", "speed":"', CAST(speed AS CHAR), '", "direction":"', CAST(direction AS CHAR), '", "distance":"', CAST(distance AS CHAR), '", "locationMethod":"', locationMethod, '", "gpsTime":"', DATE_FORMAT(gpsTime, '%b %e %Y %h:%i%p'), '", "userName":"', userName, '", "phoneNumber":"', phoneNumber, '", "sessionID":"', CAST(sessionID AS CHAR), '", "accuracy":"', CAST(accuracy AS CHAR), '", "extraInfo":"', extraInfo, '" }') json
FROM (SELECT MAX(GPSLocationID) ID
      FROM gpslocations
      WHERE sessionID != '0' && CHAR_LENGTH(sessionID) != 0 && gpstime != '0000-00-00 00:00:00'
      GROUP BY sessionID) AS MaxID
JOIN gpslocations ON gpslocations.GPSLocationID = MaxID.ID
ORDER BY gpsTime;
END$$

CREATE DEFINER=`goodevam_stms`@`localhost` PROCEDURE `prcGetRouteForMap` (IN `_sessionID` VARCHAR(50))  BEGIN
  SELECT CONCAT('{ "latitude":"', CAST(latitude AS CHAR),'", "longitude":"', CAST(longitude AS CHAR), '", "speed":"', CAST(speed AS CHAR), '", "direction":"', CAST(direction AS CHAR), '", "distance":"', CAST(distance AS CHAR), '", "locationMethod":"', locationMethod, '", "gpsTime":"', DATE_FORMAT(gpsTime, '%b %e %Y %h:%i%p'), '", "userName":"', userName, '", "phoneNumber":"', phoneNumber, '", "sessionID":"', CAST(sessionID AS CHAR), '", "accuracy":"', CAST(accuracy AS CHAR), '", "extraInfo":"', extraInfo, '" }') json
  FROM gpslocations
  WHERE sessionID = _sessionID
  ORDER BY lastupdate;
END$$

CREATE DEFINER=`goodevam_stms`@`localhost` PROCEDURE `prcGetRoutes` ()  BEGIN
  CREATE TEMPORARY TABLE tempRoutes (
    sessionID VARCHAR(50),
    userName VARCHAR(50),
    startTime DATETIME,
    endTime DATETIME)
  ENGINE = MEMORY;

  INSERT INTO tempRoutes (sessionID, userName)
  SELECT DISTINCT sessionID, userName
  FROM gpslocations;

  UPDATE tempRoutes tr
  SET startTime = (SELECT MIN(gpsTime) FROM gpslocations gl
  WHERE gl.sessionID = tr.sessionID
  AND gl.userName = tr.userName);

  UPDATE tempRoutes tr
  SET endTime = (SELECT MAX(gpsTime) FROM gpslocations gl
  WHERE gl.sessionID = tr.sessionID
  AND gl.userName = tr.userName);

  SELECT

  CONCAT('{ "sessionID": "', CAST(sessionID AS CHAR),  '", "userName": "', userName, '", "times": "(', DATE_FORMAT(startTime, '%b %e %Y %h:%i%p'), ' - ', DATE_FORMAT(endTime, '%b %e %Y %h:%i%p'), ')" }') json
  FROM tempRoutes
  ORDER BY startTime DESC;

  DROP TABLE tempRoutes;
END$$

CREATE DEFINER=`goodevam_stms`@`localhost` PROCEDURE `prcSaveGPSLocation` (IN `_latitude` DECIMAL(10,7), IN `_longitude` DECIMAL(10,7), IN `_speed` INT(10), IN `_direction` INT(10), IN `_distance` DECIMAL(10,1), IN `_date` TIMESTAMP, IN `_locationMethod` VARCHAR(50), IN `_userName` VARCHAR(50), IN `_phoneNumber` VARCHAR(50), IN `_sessionID` VARCHAR(50), IN `_accuracy` INT(10), IN `_extraInfo` VARCHAR(255), IN `_eventType` VARCHAR(50))  BEGIN
   INSERT INTO gpslocations (latitude, longitude, speed, direction, distance, gpsTime, locationMethod, userName, phoneNumber,  sessionID, accuracy, extraInfo, eventType)
   VALUES (_latitude, _longitude, _speed, _direction, _distance, _date, _locationMethod, _userName, _phoneNumber, _sessionID, _accuracy, _extraInfo, _eventType);
   SELECT NOW();
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `ci_sessions`
--

CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('50c8fa1cf8b3dd27de762d58ed5e44a8', '::1', 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 1466507349, 'a:5:{s:9:\"user_data\";s:0:\"\";s:4:\"role\";s:13:\"Administrator\";s:7:\"user_id\";s:1:\"1\";s:8:\"username\";s:5:\"admin\";s:6:\"status\";s:1:\"1\";}');

-- --------------------------------------------------------

--
-- Struktur dari tabel `client_rate`
--

CREATE TABLE `client_rate` (
  `id_client_rate` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `id_vehicle_type` int(11) NOT NULL,
  `vehicle_status` varchar(50) NOT NULL,
  `fixed_rate` varchar(50) NOT NULL,
  `period_rate` varchar(50) NOT NULL,
  `trip_quota` varchar(50) NOT NULL,
  `vehicle_rate` varchar(50) NOT NULL,
  `weight_rate` varchar(50) NOT NULL,
  `excess_weight_rate` varchar(50) NOT NULL,
  `min_weight` varchar(50) NOT NULL,
  `max_weight` varchar(50) NOT NULL,
  `uow` varchar(50) NOT NULL,
  `volume_rate` varchar(50) NOT NULL,
  `min_volume` varchar(50) NOT NULL,
  `uov` varchar(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `drop_destination` varchar(50) NOT NULL,
  `drop_rate` varchar(50) NOT NULL,
  `drop_charge_after` varchar(50) NOT NULL,
  `drop_rate_inner` varchar(50) NOT NULL,
  `drop_rate_outer` varchar(50) NOT NULL,
  `start_valid_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `rate_status` varchar(50) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `client_rate`
--

INSERT INTO `client_rate` (`id_client_rate`, `client_id`, `client_name`, `origin`, `destination`, `province`, `vehicle_type`, `id_vehicle_type`, `vehicle_status`, `fixed_rate`, `period_rate`, `trip_quota`, `vehicle_rate`, `weight_rate`, `excess_weight_rate`, `min_weight`, `max_weight`, `uow`, `volume_rate`, `min_volume`, `uov`, `currency`, `drop_destination`, `drop_rate`, `drop_charge_after`, `drop_rate_inner`, `drop_rate_outer`, `start_valid_date`, `expired_date`, `rate_status`, `remark`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(4, 'TNI', 'PT Trouw Nutrition Indonesia', 'BELAWAN', 'MEDAN', 'Jawa Barat', 'TRAILER 20', 10, 'oncall', '0', '0', '0', '2500000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-01', '2018-02-28', 'active', 'Trailer 20', 'admin', '2018-02-08 06:34:35', '', '0000-00-00 00:00:00'),
(5, 'TNI', 'PT Trouw Nutrition Indonesia', 'BINJAI', 'MEDAN', 'Jawa Barat', 'CDD BOX', 6, 'oncall', '0', '01-02-2018', '0', '850000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-24', '2018-02-24', 'active', 'Test', 'admin', '2018-02-27 05:44:52', '', '0000-00-00 00:00:00'),
(6, 'SFT', 'SOFTEX INDONESIA', 'MEDAN', 'JAKARTA', 'Jawa Barat', 'TRONTON BOX', 8, 'oncall', '0', '0', '0', '35000000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-01-01', '2018-12-31', 'active', 'ACTIVE', 'admin', '2018-02-27 05:44:54', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id_customer` int(11) NOT NULL,
  `customer_id` varchar(50) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address_1` varchar(255) NOT NULL,
  `customer_address_2` varchar(255) NOT NULL,
  `customer_city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `customer_latitude` varchar(50) NOT NULL,
  `customer_longitude` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id_customer`, `customer_id`, `customer_name`, `customer_address_1`, `customer_address_2`, `customer_city`, `area`, `postal_code`, `pic`, `email`, `customer_latitude`, `customer_longitude`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(8, 'IMB', 'PT Indah Maju Bersama', 'Jalan Perancis No. 1 Belawan', '', 'Belawan', 'BELAWAN', '', 'aHMAD', 'ahmad@mail.co.id', '', '', 'admin', '2018-02-08 06:42:19', 'admin', '2018-02-08 06:42:19'),
(9, 'APB', 'PT Anugerah Persada Bersama', 'Jalan Anugerah No. 2 Medan', '', 'Medan', 'MEDAN', '', 'Febri', 'Febri@mail.com', '', '', 'admin', '2018-02-08 06:42:35', 'admin', '2018-02-08 06:42:35'),
(10, '15061161', 'PT.FAJAR MULIA ABADI - BL', 'JL.BLORA-CEPU KM 3 KEL.BANGKLE KEC.', '', 'BLORA', 'BLORA', '', '', '', '', '', 'admin', '2018-02-17 22:30:58', '', '0000-00-00 00:00:00'),
(11, '15061942', 'PT. INTI BUANA RAYA', 'JL.DIPONEGORO (SMPING HARDYS) LINGK', '', 'KARANGASEM', 'KARANGASEM', '', '', '', '', '', 'admin', '2018-02-17 22:31:22', '', '0000-00-00 00:00:00'),
(12, '15062032', 'PT.SEGARPRIMA LAKSANA SAR', 'JL.LINTAS SUMATERA SAROLANGUN - LUB', '', 'SAROLANGUN', 'SAROLANGUN', '', '', '', '', '', 'admin', '2018-02-17 22:31:46', '', '0000-00-00 00:00:00'),
(13, '15070607', 'PT.ENHA PUTRA', 'JLN. FATAHILLAH, RT : 28 KEL. EKA J', '', 'Binjai', 'BINJAI', 'Test', 'Test', 'Test', '', '', 'admin', '2018-02-20 05:33:10', 'admin', '2018-02-20 05:33:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_master_invoice`
--

CREATE TABLE `detail_master_invoice` (
  `id_detail_invoice` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `manifest_id` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `trip` int(11) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `amount_rate` int(11) NOT NULL,
  `amount_client_rate` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_service`
--

CREATE TABLE `detail_service` (
  `id_detail_service` int(11) NOT NULL,
  `id_room_service_management` int(11) NOT NULL,
  `service_description` varchar(255) NOT NULL,
  `spare_part` varchar(255) NOT NULL,
  `remark` text NOT NULL,
  `type` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail_service`
--

INSERT INTO `detail_service` (`id_detail_service`, `id_room_service_management`, `service_description`, `spare_part`, `remark`, `type`, `timestamp`) VALUES
(4, 7, 'Service Desc3', 'Spare Part3', 'Remark3', 'room_service', '2018-02-06 04:43:38'),
(5, 8, '11', '11', '22', 'room_service', '2018-02-06 04:44:53'),
(6, 9, 'Lampu sen belakang', '1 Lampu sen Belakang', '', 'room_service', '2018-02-08 08:17:13'),
(7, 10, 'Lampu Sen Belakang', 'Lampu Sen Belakang', '', 'room_service', '2018-02-08 08:59:57'),
(8, 1, '', '', '', 'room_service', '2018-04-08 05:50:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_trucking_order`
--

CREATE TABLE `detail_trucking_order` (
  `id_detail_trucking_order` int(11) NOT NULL,
  `id_trucking_order` int(11) NOT NULL,
  `id_manifest` int(11) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `vehicle_type_description` varchar(255) NOT NULL,
  `id_vehicle_type` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `trip` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `origin` varchar(50) NOT NULL,
  `origin_address` varchar(255) NOT NULL,
  `origin_area` varchar(255) NOT NULL,
  `origin_pickup_date` date NOT NULL,
  `origin_pickup_time` varchar(50) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `destination_address` varchar(255) NOT NULL,
  `destination_area` varchar(255) NOT NULL,
  `destination_arrival_date` date NOT NULL,
  `destination_arrival_time` varchar(50) NOT NULL,
  `status_transport_order` varchar(10) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `direct_cost`
--

CREATE TABLE `direct_cost` (
  `id_direct_cost` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `id_vehicle_type` int(11) NOT NULL,
  `vehicle_status` varchar(50) NOT NULL,
  `fixed_rate` varchar(50) NOT NULL,
  `period_rate` varchar(50) NOT NULL,
  `trip_quota` varchar(50) NOT NULL,
  `vehicle_rate` varchar(50) NOT NULL,
  `weight_rate` varchar(50) NOT NULL,
  `excess_weight_rate` varchar(50) NOT NULL,
  `min_weight` varchar(50) NOT NULL,
  `max_weight` varchar(50) NOT NULL,
  `uow` varchar(50) NOT NULL,
  `volume_rate` varchar(50) NOT NULL,
  `min_volume` varchar(50) NOT NULL,
  `uov` varchar(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `drop_destination` varchar(50) NOT NULL,
  `drop_rate` varchar(50) NOT NULL,
  `drop_charge_after` varchar(50) NOT NULL,
  `drop_rate_inner` varchar(50) NOT NULL,
  `drop_rate_outer` varchar(50) NOT NULL,
  `start_valid_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `rate_status` varchar(50) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `direct_cost`
--

INSERT INTO `direct_cost` (`id_direct_cost`, `client_id`, `client_name`, `origin`, `destination`, `province`, `vehicle_type`, `id_vehicle_type`, `vehicle_status`, `fixed_rate`, `period_rate`, `trip_quota`, `vehicle_rate`, `weight_rate`, `excess_weight_rate`, `min_weight`, `max_weight`, `uow`, `volume_rate`, `min_volume`, `uov`, `currency`, `drop_destination`, `drop_rate`, `drop_charge_after`, `drop_rate_inner`, `drop_rate_outer`, `start_valid_date`, `expired_date`, `rate_status`, `remark`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(4, 'TNI', 'PT Trouw Nutrition Indonesia', 'BELAWAN', 'MEDAN', 'Jawa Barat', 'TRAILER 20', 10, 'oncall', '0', '2018-02-01', '0', '500000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-01', '2018-02-23', 'active', 'Trailer 20', 'admin', '2018-02-08 06:24:32', '', '0000-00-00 00:00:00'),
(5, 'TNI', 'PT Trouw Nutrition Indonesia', 'MEDAN', 'BELAWAN', 'Jawa Barat', 'CDD BOX', 6, 'oncall', '0', '2018-02-21', '0', '500000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-01', '2018-03-22', 'active', 'mEDA', 'admin', '2018-02-27 05:45:35', 'admin', '2018-02-20 04:34:00'),
(6, 'TNI', 'PT Trouw Nutrition Indonesia', 'BINJAI', 'MEDAN', 'Jawa Barat', 'CDD BOX', 6, 'oncall', '0', '2018-02-15', '0', '300000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-01', '2018-03-31', 'active', 'TES', 'admin', '2018-02-27 05:45:38', 'admin', '2018-02-20 04:34:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `distributor`
--

CREATE TABLE `distributor` (
  `id_distributor` int(11) NOT NULL,
  `regional` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `distributor_code` varchar(50) NOT NULL,
  `distributor_name` varchar(255) NOT NULL,
  `national` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `distributor`
--

INSERT INTO `distributor` (`id_distributor`, `regional`, `area`, `distributor_code`, `distributor_name`, `national`, `status`) VALUES
(1, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0010794', 'RAWAN UTAMI', 'SLSNTL', 'ACTIVE'),
(2, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0007574', 'ANTON', 'SLSNTL', 'ACTIVE'),
(3, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0004229', 'SANDI', 'SLSNTL', 'ACTIVE'),
(4, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0004306', 'SUSI', 'SLSNTL', 'ACTIVE'),
(5, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0012203', 'LILY', 'SLSNTL', 'ACTIVE'),
(6, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0018582', 'UD ASRI', 'SLSNTL', 'ACTIVE'),
(7, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0018200', 'TUNAS BARU', 'SLSNTL', 'ACTIVE'),
(8, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0007422', 'ENAM TUJUH', 'SLSNTL', 'ACTIVE'),
(9, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0005886', 'SENGLAM', 'SLSNTL', 'ACTIVE'),
(10, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0019410', 'KRD', 'SLSNTL', 'ACTIVE'),
(11, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0006976', 'LIMA SATU', 'SLSNTL', 'ACTIVE'),
(12, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0006049', 'ALI', 'SLSNTL', 'ACTIVE'),
(13, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0018138', 'CECEP', 'SLSNTL', 'ACTIVE'),
(14, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0004383', 'H. HAFID', 'SLSNTL', 'ACTIVE'),
(15, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0019452', 'HENI KUSTINA KURNIASIH', 'SLSNTL', 'ACTIVE'),
(16, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0010052', 'LILI', 'SLSNTL', 'ACTIVE'),
(17, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0003162', 'MAJU TERUS', 'SLSNTL', 'ACTIVE'),
(18, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0004548', 'MUJUR JAYA', 'SLSNTL', 'ACTIVE'),
(19, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0019651', 'SRI AWANG', 'SLSNTL', 'ACTIVE'),
(20, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0002925', 'SURYA', 'SLSNTL', 'ACTIVE'),
(21, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0008234', 'SITANGGANG', 'SLSNTL', 'ACTIVE'),
(22, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0007879', 'HARNO', 'SLSNTL', 'ACTIVE'),
(23, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0002585', 'SUPRIYATNO', 'SLSNTL', 'ACTIVE'),
(24, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0001254', 'OMEGA', 'SLSNTL', 'ACTIVE'),
(25, 'SLS RSO Sumatra 4', 'SLS ASO Lampung', 'TKG0001623', 'RIRIN', 'SLSNTL', 'ACTIVE'),
(26, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0004047', 'HAKIM', 'SLSNTL', 'ACTIVE'),
(27, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0004632', 'HARMONIS', 'SLSNTL', 'ACTIVE'),
(28, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0009058', 'KARYA TAMA', 'SLSNTL', 'ACTIVE'),
(29, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0009075', 'MACANG JAYA', 'SLSNTL', 'ACTIVE'),
(30, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0009039', 'MUIS', 'SLSNTL', 'ACTIVE'),
(31, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0008271', 'PUTRA', 'SLSNTL', 'ACTIVE'),
(32, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0006462', 'RAMA', 'SLSNTL', 'ACTIVE'),
(33, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0005717', 'SAIYO', 'SLSNTL', 'ACTIVE'),
(34, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0000064', 'SAMUDRA', 'SLSNTL', 'ACTIVE'),
(35, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0004476', 'TK HASAN', 'SLSNTL', 'ACTIVE'),
(36, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0006981', 'TK HELMI', 'SLSNTL', 'ACTIVE'),
(37, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0002100', 'TK PUTRI', 'SLSNTL', 'ACTIVE'),
(38, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0000658', 'TOKO ADI', 'SLSNTL', 'ACTIVE'),
(39, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0003751', 'TOKO ALI', 'SLSNTL', 'ACTIVE'),
(40, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0001859', 'TOKO DESTI', 'SLSNTL', 'ACTIVE'),
(41, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0002438', 'TOKO EDI FILY', 'SLSNTL', 'ACTIVE'),
(42, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0002577', 'TOKO ERICK', 'SLSNTL', 'ACTIVE'),
(43, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0000594', 'TOKO LUKMAN', 'SLSNTL', 'ACTIVE'),
(44, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0008292', 'TOKO LUNANG', 'SLSNTL', 'ACTIVE'),
(45, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0008152', 'TOKO MUKTAR', 'SLSNTL', 'ACTIVE'),
(46, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0003377', 'TOKO SINAR SELATAN', 'SLSNTL', 'ACTIVE'),
(47, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0001534', 'TOKO SUBUR LESTARI', 'SLSNTL', 'ACTIVE'),
(48, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0001266', 'TOKO TERANG JAYA', 'SLSNTL', 'ACTIVE'),
(49, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0007073', 'VIKRI', 'SLSNTL', 'ACTIVE'),
(50, 'SLS RSO Sumatra 4', 'SLS ASO Bengkulu', 'BKS0008555', 'YULI', 'SLSNTL', 'ACTIVE'),
(51, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0000282', 'EDDY', 'SLSNTL', 'ACTIVE'),
(52, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0002243', 'HERLIN', 'SLSNTL', 'ACTIVE'),
(53, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0005962', 'MORODADI', 'SLSNTL', 'ACTIVE'),
(54, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0002691', 'DAMAI JAYA', 'SLSNTL', 'ACTIVE'),
(55, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0004869', 'RAHAYU', 'SLSNTL', 'ACTIVE'),
(56, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001426', 'MAYA', 'SLSNTL', 'ACTIVE'),
(57, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001517', 'MULIA', 'SLSNTL', 'ACTIVE'),
(58, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0004892', 'LUWES', 'SLSNTL', 'ACTIVE'),
(59, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0004310', 'SIDODADI', 'SLSNTL', 'ACTIVE'),
(60, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001609', 'SLAMET', 'SLSNTL', 'ACTIVE'),
(61, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0004444', 'SRI', 'SLSNTL', 'ACTIVE'),
(62, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0003959', 'JOKO', 'SLSNTL', 'ACTIVE'),
(63, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001777', 'SUBADAR', 'SLSNTL', 'ACTIVE'),
(64, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001246', 'TIMUR JAYA', 'SLSNTL', 'ACTIVE'),
(65, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0000692', 'SUMBER JAYA', 'SLSNTL', 'ACTIVE'),
(66, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001370', 'SUYANTO', 'SLSNTL', 'ACTIVE'),
(67, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0003680', 'BASUKI ARIFIN', 'SLSNTL', 'ACTIVE'),
(68, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0001651', 'MAHA', 'SLSNTL', 'ACTIVE'),
(69, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0004936', 'SUGENG', 'SLSNTL', 'ACTIVE'),
(70, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'SOC0017649', 'BAGUSA', 'SLSNTL', 'ACTIVE'),
(71, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'SOC0005186', 'REJOMULYO', 'SLSNTL', 'ACTIVE'),
(72, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'SOC0018127', 'SUMBER REJEKI', 'SLSNTL', 'ACTIVE'),
(73, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0004366', 'LESTARI', 'SLSNTL', 'ACTIVE'),
(74, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0004136', 'ARIF', 'SLSNTL', 'ACTIVE'),
(75, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0007944', 'BAMBANG', 'SLSNTL', 'ACTIVE'),
(76, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0004718', 'MUBAROK', 'SLSNTL', 'ACTIVE'),
(77, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0008411', 'PINTER 3', 'SLSNTL', 'ACTIVE'),
(78, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0003697', 'CV. UNGGUL JAYA', 'SLSNTL', 'ACTIVE'),
(79, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0003988', 'CV. HALIM JAYA ABADI', 'SLSNTL', 'ACTIVE'),
(80, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0005878', 'REJEKI-_Kndl_5878', 'SLSNTL', 'ACTIVE'),
(81, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0000590', 'SEMBILAN', 'SLSNTL', 'ACTIVE'),
(82, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0002592', 'AGUNG - DEMAK', 'SLSNTL', 'ACTIVE'),
(83, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0001827', 'ABADI', 'SLSNTL', 'ACTIVE'),
(84, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0005835', 'REJEKI-Wrs_5835', 'SLSNTL', 'ACTIVE'),
(85, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0007008', 'PUSPITASRI', 'SLSNTL', 'ACTIVE'),
(86, 'SLS RSO RE Java 3', 'SLS ASO Semarang', 'SRG0002933', 'HADAK', 'SLSNTL', 'ACTIVE'),
(87, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0006452', 'ANDIK', 'SLSNTL', 'ACTIVE'),
(88, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0001135', 'ANDIK PUTRA', 'SLSNTL', 'ACTIVE'),
(89, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'PTI0002668', 'ARIES', 'SLSNTL', 'ACTIVE'),
(90, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0000366', 'ASIA JAYA', 'SLSNTL', 'ACTIVE'),
(91, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0001039', 'ATIK', 'SLSNTL', 'ACTIVE'),
(92, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0004635', 'ATOM', 'SLSNTL', 'ACTIVE'),
(93, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'PTI0003396', 'BUMI INDAH', 'SLSNTL', 'ACTIVE'),
(94, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'PTI0000598', 'JAGO BLORA', 'SLSNTL', 'ACTIVE'),
(95, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0002769', 'LANGGENG', 'SLSNTL', 'ACTIVE'),
(96, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'PTI0002535', 'PINGGIR KALI', 'SLSNTL', 'ACTIVE'),
(97, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'PTI0000523', 'RESTU ANDA', 'SLSNTL', 'ACTIVE'),
(98, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0004503', 'RINA', 'SLSNTL', 'ACTIVE'),
(99, 'SLS RSO RE Java 3', 'SLS ASO Tuban', 'TBN0003280', 'SANTOSO', 'SLSNTL', 'ACTIVE'),
(100, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0001043', 'HISNUDIN', 'SLSNTL', 'ACTIVE'),
(101, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0001097', 'NURTJOJO HARYONO', 'SLSNTL', 'ACTIVE'),
(102, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0003398', 'HASANUSI RAHMAN', 'SLSNTL', 'ACTIVE'),
(103, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0000017', 'SUSILO UTOMO', 'SLSNTL', 'ACTIVE'),
(104, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0001327', 'HARYANTO', 'SLSNTL', 'ACTIVE'),
(105, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0001795', 'M. ABDUL KHAFIDZ', 'SLSNTL', 'ACTIVE'),
(106, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0003423', 'JUMARI', 'SLSNTL', 'ACTIVE'),
(107, 'SLS RSO RE Java 3', 'SLS ASO Pati', 'PTI0003920', 'RUTH UNTARMI', 'SLSNTL', 'ACTIVE'),
(108, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0002750', 'AKHMADI', 'SLSNTL', 'ACTIVE'),
(109, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0003393', 'AMBAR', 'SLSNTL', 'ACTIVE'),
(110, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0005239', 'TOKO BERINGIN', 'SLSNTL', 'ACTIVE'),
(111, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0011421', 'ERIKA SEMBAKO', 'SLSNTL', 'ACTIVE'),
(112, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0003566', 'ETIK', 'SLSNTL', 'ACTIVE'),
(113, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0001954', 'GEMAH RIPAH', 'SLSNTL', 'ACTIVE'),
(114, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0003081', 'H ANWAR', 'SLSNTL', 'ACTIVE'),
(115, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0001674', 'JAMAL', 'SLSNTL', 'ACTIVE'),
(116, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0004090', 'KELAPA MAS', 'SLSNTL', 'ACTIVE'),
(117, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0000382', 'LESTARI', 'SLSNTL', 'ACTIVE'),
(118, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0001426', 'TOKO PANGESTU', 'SLSNTL', 'ACTIVE'),
(119, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0001009', 'RETNO', 'SLSNTL', 'ACTIVE'),
(120, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0011413', 'SEDULURKU', 'SLSNTL', 'ACTIVE'),
(121, 'SLS RSO RE Java 2', 'SLS ASO Yogyakarta', 'JOG0001924', 'WIWIN', 'SLSNTL', 'ACTIVE'),
(122, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0000136', 'MUHAMMAD ARFA HI. LOMBE', 'SLSNTL', 'ACTIVE'),
(123, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0000557', 'RAHMAT', 'SLSNTL', 'ACTIVE'),
(124, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0001467', 'TOKO EKA SETIA', 'SLSNTL', 'ACTIVE'),
(125, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0001877', 'TOKO SAHABAT KARIB', 'SLSNTL', 'ACTIVE'),
(126, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0002080', 'KUNTUM MEKAR', 'SLSNTL', 'ACTIVE'),
(127, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0002180', 'RAJAWALI', 'SLSNTL', 'ACTIVE'),
(128, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0002207', 'TOKO BIJAKSANA', 'SLSNTL', 'ACTIVE'),
(129, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0002398', 'ANEKA', 'SLSNTL', 'ACTIVE'),
(130, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0002476', 'ANUGRAH', 'SLSNTL', 'ACTIVE'),
(131, 'SLS RSO Patea', 'SLS ASO Ternate', 'TTE0000940', 'TOKO LADANG MAKMUR', 'SLSNTL', 'ACTIVE'),
(132, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0003740', 'Aga Jaya', 'SLSNTL', 'ACTIVE'),
(133, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0002465', 'Sumber Rejeki', 'SLSNTL', 'ACTIVE'),
(134, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0006715', 'Rukun Jaya', 'SLSNTL', 'ACTIVE'),
(135, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0000520', 'Putra Hasil Bumi', 'SLSNTL', 'ACTIVE'),
(136, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0005383', 'Lima Jaya', 'SLSNTL', 'ACTIVE'),
(137, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0001356', 'Langgeng Jaya Ud', 'SLSNTL', 'ACTIVE'),
(138, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0009823', 'Henky Yunanto, Se', 'SLSNTL', 'ACTIVE'),
(139, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'MAD0003195', 'Eka Jaya', 'SLSNTL', 'ACTIVE'),
(140, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0006271', 'Bintang Waras', 'SLSNTL', 'ACTIVE'),
(141, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0008355', 'Ud Angles', 'SLSNTL', 'ACTIVE'),
(142, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0006935', 'Tirta Jaya', 'SLSNTL', 'ACTIVE'),
(143, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0002450', 'Tentrem', 'SLSNTL', 'ACTIVE'),
(144, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0012217', 'Surya Mas', 'SLSNTL', 'ACTIVE'),
(145, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0001578', 'Sunarti', 'SLSNTL', 'ACTIVE'),
(146, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0005972', 'Sumber Tani', 'SLSNTL', 'ACTIVE'),
(147, 'SLS RSO RE Java 3', 'SLS ASO KEDIRI', 'KDR0008406', 'Wani Jaya', 'SLSNTL', 'ACTIVE'),
(148, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0024199', 'LEKOK', 'SLSNTL', 'ACTIVE'),
(149, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0007118', 'SARGINO', 'SLSNTL', 'ACTIVE'),
(150, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0000201', 'LIMA PUTERA (2)', 'SLSNTL', 'ACTIVE'),
(151, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0003180', 'PARJO', 'SLSNTL', 'ACTIVE'),
(152, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0017545', 'JUMINGAN', 'SLSNTL', 'ACTIVE'),
(153, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0014585', 'RESTU', 'SLSNTL', 'ACTIVE'),
(154, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0011016', 'GUSTI', 'SLSNTL', 'ACTIVE'),
(155, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0018587', 'SUBARKAH', 'SLSNTL', 'ACTIVE'),
(156, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0018575', 'ALI', 'SLSNTL', 'ACTIVE'),
(157, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0004911', 'H. KARMAN', 'SLSNTL', 'ACTIVE'),
(158, 'SLS RSO Sumatra 4', 'SLS ASO METRO', 'TKG0013063', 'YEYEN ', 'SLSNTL', 'ACTIVE'),
(159, 'Regional Retail Jakarta Inner', 'SLS ASO Retail Depok', 'JI20000175', 'TOKO ARCHELIA', 'SLSNTL', 'ACTIVE'),
(160, 'Regional Retail Jakarta Inner', 'SLS ASO Retail Depok', 'JK30001909', 'TOKO HARAPAN BARU', 'SLSNTL', 'ACTIVE'),
(161, 'Regional Retail Jakarta Inner', 'SLS ASO Retail Depok', 'JK30002590', 'TOKO SELLY', 'SLSNTL', 'ACTIVE'),
(162, 'Regional Retail Jakarta Inner', 'SLS ASO Retail Depok', 'JK30005192', 'TOKO JAYA', 'SLSNTL', 'ACTIVE'),
(163, 'Regional Retail Jakarta Inner', 'SLS ASO Retail Depok', 'JK30008860', 'TOKO PRIMA', 'SLSNTL', 'ACTIVE'),
(164, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0017585', 'SUMBER REZEKI', 'SLSNTL', 'ACTIVE'),
(165, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0000107', 'NURMAWATI', 'SLSNTL', 'ACTIVE'),
(166, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0000029', 'GEDE', 'SLSNTL', 'ACTIVE'),
(167, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0002981', 'KADARYONO', 'SLSNTL', 'ACTIVE'),
(168, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0004298', 'KIAN JAYA', 'SLSNTL', 'ACTIVE'),
(169, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0011479', 'ARITONANG', 'SLSNTL', 'ACTIVE'),
(170, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0003559', 'KARIM', 'SLSNTL', 'ACTIVE'),
(171, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0005646', 'RASA BARU', 'SLSNTL', 'ACTIVE'),
(172, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0000385', 'RIKA', 'SLSNTL', 'ACTIVE'),
(173, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0001888', 'NURDIN', 'SLSNTL', 'ACTIVE'),
(174, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0004486', 'ANUGRAH', 'SLSNTL', 'ACTIVE'),
(175, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0001425', 'HIDUP ABADI', 'SLSNTL', 'ACTIVE'),
(176, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0002347', 'TOKO LESTARI', 'SLSNTL', 'ACTIVE'),
(177, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'TKG0008073', 'TOKO BAYU', 'SLSNTL', 'ACTIVE'),
(178, 'SLS RSO Sumatra 4', 'SLS ASO Kotabumi', 'KBM0000236', 'TOYO', 'SLSNTL', 'ACTIVE'),
(179, 'SLS Febri', 'Area Febri', 'febri1234', 'Febri', 'SLSNTL', 'ACTIVE'),
(180, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0000319', 'GATUK', 'SLSNTL', 'ACTIVE'),
(181, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0009020', 'BAHAGIA', 'SLSNTL', 'ACTIVE'),
(182, 'SLS RSO RE Java 3', 'SLS ASO Madiun', 'MAD0002932', 'SLAMET', 'SLSNTL', 'ACTIVE'),
(183, 'SLS RSO Sumatra 3', 'SLS ASO Lahat', 'LHT0007582', 'Apri', 'SLSNTL', 'ACTIVE'),
(184, 'SLS RSO Sumatra 3', 'SLS ASO Lahat', 'LHT0000666', 'Sahabat', 'SLSNTL', 'ACTIVE'),
(185, 'SLS RSO Sumatra 3', 'SLS ASO Lahat', 'LHT0006016', 'Artomoro', 'SLSNTL', 'ACTIVE'),
(186, 'SLS RSO Sulawesi', 'SLS ASO Manado', 'MDC0007933', 'KIOS AYU', 'SLSNTL', 'ACTIVE'),
(187, 'Sumatra 3', 'Palembang', 'Palembang', 'Palembang', 'SLSNTL', 'ACTIVE'),
(188, 'SLS RSO Sulawesi', 'SLS ASO Manado', 'MDC0003349', 'BINA USAHA KIOS', 'SLSNTL', 'ACTIVE'),
(189, 'SLS RSO Sulawesi', 'SLS ASO Manado', 'MDC0002834', 'TOKO TUNAS HARAPAN', 'SLSNTL', 'ACTIVE');

-- --------------------------------------------------------

--
-- Struktur dari tabel `division`
--

CREATE TABLE `division` (
  `id_division` int(11) NOT NULL,
  `division_code` varchar(255) NOT NULL,
  `division_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `division`
--

INSERT INTO `division` (`id_division`, `division_code`, `division_name`) VALUES
(1, 'DVS012', 'Marketing');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver`
--

CREATE TABLE `driver` (
  `id_driver` int(11) NOT NULL,
  `driver_code` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_license_type` varchar(255) NOT NULL,
  `employee_status` varchar(255) NOT NULL,
  `driver_license_number` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `urutan_driver` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `driver`
--

INSERT INTO `driver` (`id_driver`, `driver_code`, `driver_name`, `driver_license_type`, `employee_status`, `driver_license_number`, `password`, `urutan_driver`) VALUES
(12, 'AHD', 'AHMAD', 'SIM A', 'employee', '870713250193', '4689c75fd0935ff5818d62fd2083ed98', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver_absence`
--

CREATE TABLE `driver_absence` (
  `id_absence` int(11) NOT NULL,
  `status_absence` varchar(25) NOT NULL,
  `driver_code` varchar(50) NOT NULL,
  `distributor_code` varchar(255) NOT NULL,
  `id_driver` int(11) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `date_absence` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  `keterangan` varchar(255) NOT NULL,
  `image_absence` varchar(255) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `keterangan_gps` varchar(255) NOT NULL,
  `setoran` int(11) NOT NULL,
  `konfirmasi_kasir` varchar(50) NOT NULL,
  `tanggal_konfirmasi_kasir` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `driver_absence`
--

INSERT INTO `driver_absence` (`id_absence`, `status_absence`, `driver_code`, `distributor_code`, `id_driver`, `driver_name`, `date_absence`, `keterangan`, `image_absence`, `latitude`, `longitude`, `keterangan_gps`, `setoran`, `konfirmasi_kasir`, `tanggal_konfirmasi_kasir`) VALUES
(11, 'hadir', 'AHD', '', 12, 'AHMAD', '2018-03-07 23:55:24', '', 'foto_absen_AHD_1520488524.jpeg', '-6.2275081', '107.0045346', '', 0, '', '0000-00-00 00:00:00'),
(12, 'hadir', 'AHD', '', 12, 'AHMAD', '2018-03-13 23:55:24', '', 'foto_absen_AHD_1520488524.jpeg', '-6.2275081', '107.0045346', '', 0, '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `email_receiver`
--

CREATE TABLE `email_receiver` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(1255) NOT NULL,
  `motorist` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `email_receiver`
--

INSERT INTO `email_receiver` (`id`, `name`, `email`, `motorist`) VALUES
(1, 'Febri Aditya', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com,Adryan.Setiadi1@ID.nestle.com,Suparmono.ID@id.nestle.com,ID.Prayitno@ID.nestle.com,DodyRachmat.Sumarwan@id.nestle.com,Yozart.Zulmi@ID.nestle.com', 'OOH'),
(2, 'Febri Aditya', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com,Adryan.Setiadi1@ID.nestle.com,Suparmono.ID@id.nestle.com,ID.Prayitno@ID.nestle.com,DodyRachmat.Sumarwan@id.nestle.com,Yozart.Zulmi@ID.nestle.com', 'Sergap'),
(3, 'Febri Aditya', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com,Adryan.Setiadi1@ID.nestle.com,Suparmono.ID@id.nestle.com,ID.Prayitno@ID.nestle.com,DodyRachmat.Sumarwan@id.nestle.com,Yozart.Zulmi@ID.nestle.com', 'Kantin'),
(4, 'Febri Aditya', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com,Adryan.Setiadi1@ID.nestle.com,Suparmono.ID@id.nestle.com,ID.Prayitno@ID.nestle.com,DodyRachmat.Sumarwan@id.nestle.com,Yozart.Zulmi@ID.nestle.com', 'Milo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gpslocations`
--

CREATE TABLE `gpslocations` (
  `GPSLocationID` int(10) UNSIGNED NOT NULL,
  `lastUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `latitude` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `longitude` decimal(10,7) NOT NULL DEFAULT '0.0000000',
  `phoneNumber` varchar(50) NOT NULL DEFAULT '',
  `userName` varchar(50) NOT NULL DEFAULT '',
  `sessionID` varchar(50) NOT NULL DEFAULT '',
  `speed` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `direction` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `distance` decimal(10,1) NOT NULL DEFAULT '0.0',
  `gpsTime` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `locationMethod` varchar(50) NOT NULL DEFAULT '',
  `accuracy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `extraInfo` varchar(255) NOT NULL DEFAULT '',
  `eventType` varchar(50) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `gpslocations`
--

INSERT INTO `gpslocations` (`GPSLocationID`, `lastUpdate`, `latitude`, `longitude`, `phoneNumber`, `userName`, `sessionID`, `speed`, `direction`, `distance`, `gpsTime`, `locationMethod`, `accuracy`, `extraInfo`, `eventType`) VALUES
(10, '2018-04-30 07:23:54', -6.1751100, 106.8650390, 'test', 'test1', '8BA21D90-3F90-407F-BAAE-800B04B1F5ED', 0, 0, 0.0, '2018-04-29 18:29:00', '', 0, '', ''),
(11, '2018-04-30 07:24:29', -6.0751100, 106.8650390, 'test', 'test1', '8BA21D90-3F90-407F-BAAE-800B04B1F5ED', 0, 0, 0.0, '2018-04-29 18:30:00', '', 0, '', ''),
(12, '2018-04-30 07:24:34', -6.2751100, 106.8650390, 'test', 'test1', '8BA21D90-3F90-407F-BAAE-800B04B1F5ED', 0, 0, 0.0, '2018-04-29 18:30:30', '', 0, '', ''),
(15, '2018-05-04 03:10:46', -6.9864110, 106.8650390, '085693268369', 'testing', '0', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(16, '2018-05-04 03:11:25', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(17, '2018-05-04 03:15:34', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(18, '2018-05-04 03:16:10', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(19, '2018-05-04 03:17:49', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(20, '2018-05-04 03:18:19', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(21, '2018-05-04 03:20:08', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(22, '2018-05-04 03:21:54', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '0000-00-00 00:00:00', '', 0, '', ''),
(23, '2018-05-04 03:22:41', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '2018-04-29 18:30:30', '', 0, '', ''),
(24, '2018-05-04 03:25:22', -6.9864110, 106.8650390, '085693268369', 'testing', '1234', 0, 0, 0.0, '2018-04-29 18:30:30', '', 0, '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `gr`
--

CREATE TABLE `gr` (
  `id_gr` int(11) NOT NULL,
  `id_po` int(11) NOT NULL,
  `gr_date` date NOT NULL,
  `remark` varchar(255) NOT NULL,
  `status_putaway` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `gr`
--

INSERT INTO `gr` (`id_gr`, `id_po`, `gr_date`, `remark`, `status_putaway`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(10, 2, '2018-01-19', '1111', '', 'admin', '2018-01-08 14:48:32', 'admin', '2018-01-08 14:48:32'),
(11, 3, '2018-01-16', 'Gr Ban', 'new', 'admin', '2018-01-10 10:53:49', '', '0000-00-00 00:00:00'),
(12, 4, '2018-01-17', 'Remark', 'new', 'admin', '2018-01-11 04:31:53', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inventory_list`
--

CREATE TABLE `inventory_list` (
  `id_inventory_list` int(11) NOT NULL,
  `id_location` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `inventory_list`
--

INSERT INTO `inventory_list` (`id_inventory_list`, `id_location`, `id_product`, `stock`, `product_name`) VALUES
(1, 7, 4, 3, 'desc'),
(5, 8, 4, 14, 'desc'),
(6, 7, 5, 10, 'Gear');

-- --------------------------------------------------------

--
-- Struktur dari tabel `json`
--

CREATE TABLE `json` (
  `id` int(11) NOT NULL,
  `nama_hewan` varchar(255) NOT NULL,
  `contoh` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `json`
--

INSERT INTO `json` (`id`, `nama_hewan`, `contoh`) VALUES
(1, 'kucing', 'cikap'),
(2, 'anjing', 'cikup');

-- --------------------------------------------------------

--
-- Struktur dari tabel `location`
--

CREATE TABLE `location` (
  `id_location` int(11) NOT NULL,
  `location_code` varchar(255) NOT NULL,
  `warehouse_code` varchar(255) NOT NULL,
  `id_warehouse` int(11) NOT NULL,
  `id_location_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `location_type`
--

CREATE TABLE `location_type` (
  `id_location_type` int(11) NOT NULL,
  `location_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `location_type`
--

INSERT INTO `location_type` (`id_location_type`, `location_type`) VALUES
(7, 'Rak'),
(8, 'SIlo');

-- --------------------------------------------------------

--
-- Struktur dari tabel `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(1, '36.84.71.48', 'asdas', '2018-05-05 17:51:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_report`
--

CREATE TABLE `log_report` (
  `id_send_report` int(11) NOT NULL,
  `date` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `motorist` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `log_report`
--

INSERT INTO `log_report` (`id_send_report`, `date`, `email`, `status`, `motorist`) VALUES
(1, '2016-11-11', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(2, '2016-11-11', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(3, '2016-11-11', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(4, '2016-11-14', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(5, '2016-11-14', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(6, '2016-11-14', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(7, '2016-11-21', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(8, '2016-11-21', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(9, '2016-11-21', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(10, '2016-11-22', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(11, '2016-11-22', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(12, '2016-11-22', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(13, '2016-11-24', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(14, '2016-11-24', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(15, '2016-11-24', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(16, '2016-11-25', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(17, '2016-11-25', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(18, '2016-11-25', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(19, '2016-12-05', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'OOH'),
(20, '2016-12-05', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Sergap'),
(21, '2016-12-05', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com', 'Sukses', 'Kantin'),
(22, '2016-12-21', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com,Adryan.Setiadi1@ID.nestle.com,Suparmono.ID@id.nestle.com,ID.Prayitno@ID.nestle.com,DodyRachmat.Sumarwan@id.nestle.com,Yozart.Zulm', 'Sukses', 'OOH'),
(23, '2016-12-21', 'febriaditya90@gmail.com,Mochamad.Nurfalaah@id.nestle.com,Rindha-Avrina-Sari.Sentani@id.nestle.com,rachmatarramadhan@gmail.com,Adryan.Setiadi1@ID.nestle.com,Suparmono.ID@id.nestle.com,ID.Prayitno@ID.nestle.com,DodyRachmat.Sumarwan@id.nestle.com,Yozart.Zulm', 'Sukses', 'OOH');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manifest_additional_cost`
--

CREATE TABLE `manifest_additional_cost` (
  `id_manifest_additional_cost` int(11) NOT NULL,
  `additional_type` varchar(50) NOT NULL,
  `manifest` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `trip` int(11) NOT NULL,
  `amount_to_client` int(11) NOT NULL,
  `amount_to_transporter` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_area`
--

CREATE TABLE `master_area` (
  `id_area` int(11) NOT NULL,
  `area_id` varchar(255) NOT NULL,
  `area_description` varchar(255) NOT NULL,
  `area_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_area`
--

INSERT INTO `master_area` (`id_area`, `area_id`, `area_description`, `area_type`) VALUES
(5, 'MEDAN', 'MEDAN', 'Sales'),
(6, 'BINJAI', 'BINJAI', 'Sales'),
(7, 'BELAWAN', 'BELAWAN', 'Branch'),
(8, 'BLORA', 'BLORA', 'Branch'),
(9, 'JAMBI', 'JAMBI', 'Sales'),
(10, 'KARANGASEM', 'KARANGASEM', 'Branch'),
(11, 'SAROLANGUN', 'SAROLANGUN', 'Sales'),
(12, 'DENPASAR', 'DENPASAR', 'Sales'),
(13, 'DEMAK', 'DEMAK', 'Branch'),
(14, 'JEMBER', 'JEMBER', 'Sales'),
(15, 'PASURUAN', 'PASURUAN', 'Branch'),
(16, 'NGAWI', 'NGAWI', 'Sales'),
(17, 'BANDUNG', 'BANDUNG', 'Branch'),
(18, 'PALEMBANG', 'PALEMBANG', 'Branch'),
(19, 'KUDUS', 'KUDUS', 'Sales'),
(21, 'JAKARTA', 'Jakarta', 'Branch');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_bank_account`
--

CREATE TABLE `master_bank_account` (
  `id_master_bank_account` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `statement_balance` int(11) NOT NULL,
  `available_credit` int(11) NOT NULL,
  `starting_balance` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` int(11) NOT NULL,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_bank_account`
--

INSERT INTO `master_bank_account` (`id_master_bank_account`, `code`, `name`, `statement_balance`, `available_credit`, `starting_balance`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(2, '0233444', 'PT Suksema Solution BCA', 298509111, 300000000, '2018-01-09', 'admin', 2018, '', '2018-01-10 11:21:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_cash_account`
--

CREATE TABLE `master_cash_account` (
  `id_cash_account` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `balance` int(11) NOT NULL,
  `starting_balance_date` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` date NOT NULL,
  `updated_date` date NOT NULL,
  `updated_by` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_cash_account`
--

INSERT INTO `master_cash_account` (`id_cash_account`, `name`, `balance`, `starting_balance_date`, `created_by`, `created_date`, `updated_date`, `updated_by`) VALUES
(3, 'Febri', 427328, '2018-01-16', 'admin', '2018-01-08', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_chasis`
--

CREATE TABLE `master_chasis` (
  `id_chasis` int(11) NOT NULL,
  `chasis_id` varchar(100) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `tire_qty` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_chasis`
--

INSERT INTO `master_chasis` (`id_chasis`, `chasis_id`, `vehicle_id`, `tire_qty`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(3, 'qqqq2', 112, 1, 'admin', '2017-11-21 07:08:23', 'admin', '2017-11-21 07:08:23'),
(4, '43555', 112, 10, 'admin', '2017-12-04 13:29:46', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_client`
--

CREATE TABLE `master_client` (
  `id_client` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `client_address_1` varchar(255) NOT NULL,
  `client_address_2` varchar(255) NOT NULL,
  `client_city` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `postal_code` varchar(10) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `client_latitude` varchar(50) NOT NULL,
  `client_longitude` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_client`
--

INSERT INTO `master_client` (`id_client`, `client_id`, `client_name`, `client_address_1`, `client_address_2`, `client_city`, `area`, `postal_code`, `pic`, `email`, `client_latitude`, `client_longitude`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(5, 'TNI', 'PT Trouw Nutrition Indonesia', 'Jalan Raya Selayar I No 20', '', 'Medan', 'MEDAN', '12345', '1', '3', '4', '6', 'admin', '2018-02-08 06:22:42', '', '0000-00-00 00:00:00'),
(6, 'SFT', 'SOFTEX INDONESIA', 'GALAXI', 'GALAXI', 'JAKARTA', 'JAKARTA', '12345', 'SIGIT', 'SIGIT@GMAIL.COM', '-6.2708854,106', '9700297,17', 'admin', '2018-02-20 06:35:23', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_data_category`
--

CREATE TABLE `master_data_category` (
  `id_master_data_category` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_data_category`
--

INSERT INTO `master_data_category` (`id_master_data_category`, `category`, `description`) VALUES
(8, 'Truck Absent', 'Baik'),
(9, 'Truck Absent', 'Tidak Baik'),
(10, 'Area Type', 'Sales'),
(11, 'Area Type', 'Branch'),
(12, 'Employee Status Driver', 'Employee Status 1'),
(13, 'Employee Status Driver', 'Employee Status 2'),
(14, 'Vehicle Status Direct Cost', 'On Call'),
(15, 'Vehicle Status Direct Cost', 'Contract'),
(16, 'Vehicle Status Client Rate', 'On Call'),
(17, 'Vehicle Status Client Rate', 'Contract'),
(18, 'Vehicle Status Transporter Rate', 'On Call'),
(19, 'Vehicle Status Transporter Rate', 'Contract'),
(20, 'Fuel Type Master Unit', 'Bensin'),
(21, 'Fuel Type Master Unit', 'solar'),
(22, 'Body Type Master Unit', 'Body Type 1'),
(23, 'Body Type Master Unit', 'Body Type 2'),
(24, 'Assembly Type Master Unit', 'Assembly 1'),
(25, 'Assembly Type Master Unit', 'Assembly 2'),
(26, 'Shift Driver', 'Shift 1'),
(27, 'Shift Driver', 'Shift 2'),
(28, 'Shift Driver', 'Non Shift'),
(29, 'Accident Type', 'Accident Type 1'),
(30, 'Accident Type', 'Accident Type 2'),
(31, 'Service Type Fleet', 'Service Type 1'),
(32, 'Service Type Fleet', 'Service Type 2'),
(33, 'Pod Code', '10 - Code 1'),
(34, 'Pod Code', '11 - POD Code 2'),
(35, 'Cargo Type', 'Pile'),
(36, 'Cargo Type', 'Tanah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_invoice`
--

CREATE TABLE `master_invoice` (
  `id_invoice` int(11) NOT NULL,
  `invoice_number` varchar(100) NOT NULL,
  `client_id` varchar(100) NOT NULL,
  `transporter` varchar(10) NOT NULL,
  `transporter_id` varchar(255) NOT NULL,
  `transporter_name` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `schedule_date_from` date NOT NULL,
  `schedule_date_to` date NOT NULL,
  `status` varchar(100) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_io`
--

CREATE TABLE `master_io` (
  `id_io` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `division_code` varchar(255) NOT NULL,
  `division_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status_invoice` varchar(50) NOT NULL,
  `status_io` varchar(10) NOT NULL,
  `io_type` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_io`
--

INSERT INTO `master_io` (`id_io`, `request_date`, `division_code`, `division_name`, `description`, `status_invoice`, `status_io`, `io_type`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(6, '2018-01-17', 'DVS012', 'Marketing', '11', '', 'new', 'assets', 'admin', '2018-01-09 11:00:40', '', '0000-00-00 00:00:00'),
(7, '2018-01-17', 'DVS012', 'Marketing', '11', '', 'approved', 'assets', 'admin', '2018-01-09 11:01:01', 'admin', '2018-01-09 11:04:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_manifest`
--

CREATE TABLE `master_manifest` (
  `id_manifest` int(11) NOT NULL,
  `id_trucking_order` int(11) NOT NULL,
  `driver_code` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_phone_number` varchar(255) NOT NULL,
  `transporter` varchar(255) NOT NULL,
  `transporter_id` varchar(255) NOT NULL,
  `transporter_name` varchar(255) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `volume_cap` varchar(255) NOT NULL,
  `weight_cap` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `vehicle_status` varchar(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `id_vehicle_type` int(11) NOT NULL,
  `trip` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `origin_id` varchar(255) NOT NULL,
  `origin_address` varchar(255) NOT NULL,
  `origin_area` varchar(255) NOT NULL,
  `destination_id` varchar(255) NOT NULL,
  `destination_address` varchar(255) NOT NULL,
  `destination_area` varchar(255) NOT NULL,
  `confirmed_manifest` varchar(50) NOT NULL,
  `confirmed_vehicle` varchar(50) NOT NULL,
  `confirmed_rate` varchar(10) NOT NULL,
  `rate` int(11) NOT NULL,
  `client_rate` int(11) NOT NULL,
  `transporter_rate` int(11) NOT NULL,
  `status_manifest` varchar(10) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `mode` varchar(100) NOT NULL,
  `seal_number` varchar(100) NOT NULL,
  `cont_number` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_manifest`
--

INSERT INTO `master_manifest` (`id_manifest`, `id_trucking_order`, `driver_code`, `driver_name`, `driver_phone_number`, `transporter`, `transporter_id`, `transporter_name`, `client_id`, `client_name`, `volume_cap`, `weight_cap`, `remark`, `vehicle_id`, `vehicle_status`, `description`, `vehicle_type`, `id_vehicle_type`, `trip`, `delivery_date`, `origin_id`, `origin_address`, `origin_area`, `destination_id`, `destination_address`, `destination_area`, `confirmed_manifest`, `confirmed_vehicle`, `confirmed_rate`, `rate`, `client_rate`, `transporter_rate`, `status_manifest`, `created_by`, `created_date`, `updated_by`, `updated_date`, `mode`, `seal_number`, `cont_number`) VALUES
(2, 0, 'AHD', 'AHMAD', '', 'assets', '', '', 'SFT', 'SOFTEX INDONESIA', '', '', '', 'B 9112 OF', 'oncall', '', 'TRAILER 20', 10, 1, '2018-05-01', '', 'Bekasi', 'Bekasi', '', 'Jakarta', 'Jakarta', '', 'yes', '', 0, 0, 0, '', 'admin', '2018-05-01 07:05:29', 'admin', '2018-05-01 06:05:29', 'land', '', ''),
(4, 0, '', '', '', '', '', '', 'TNI', 'PT Trouw Nutrition Indonesia', '', '', '', 'B 1073 IW', '', '', 'CDD BOX', 0, 1, '2018-05-01', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 'admin', '2018-05-01 08:12:04', '', '0000-00-00 00:00:00', '', '', ''),
(5, 0, '', '', '', '', '', '', 'TNI', 'PT Trouw Nutrition Indonesia', '', '', '', 'B 9112 OF', '', '', 'TRAILER 20', 0, 1, '2018-05-03', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 'admin', '2018-05-03 08:36:58', '', '0000-00-00 00:00:00', '', '', ''),
(7, 0, '', '', '', '', '', '', 'TNI', 'PT Trouw Nutrition Indonesia', '', '', '', 'Dummy 01', '', '', 'TRAILER 20', 0, 1, '2018-05-03', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 'admin', '2018-05-03 10:57:24', '', '0000-00-00 00:00:00', '', '', ''),
(8, 0, '', '', '', '', '', '', 'TNI', 'PT Trouw Nutrition Indonesia', '', '', '', 'Dummy 01', '', '', 'TRAILER 20', 0, 2, '2018-05-03', '', '', '', '', '', '', '', '', '', 0, 0, 0, '', 'admin', '2018-05-03 11:04:43', '', '0000-00-00 00:00:00', '', '', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_po`
--

CREATE TABLE `master_po` (
  `id_po` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `create_po_date` date NOT NULL,
  `request_date` date NOT NULL,
  `supplier_code` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `status_gr` varchar(50) NOT NULL,
  `warehouse_code` varchar(50) NOT NULL,
  `order_type` varchar(255) NOT NULL,
  `supplier_do` varchar(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_po`
--

INSERT INTO `master_po` (`id_po`, `reference`, `create_po_date`, `request_date`, `supplier_code`, `status`, `status_gr`, `warehouse_code`, `order_type`, `supplier_do`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(2, '6', '2018-01-08', '2018-01-17', 'sp01', 'approved', 'gr_created', 'WRS011', 'Regular', '11', 'admin', '2018-01-08 14:32:56', '', '0000-00-00 00:00:00'),
(3, '7', '2018-01-16', '2018-01-17', 'sp01', 'approved', 'gr_created', 'WRS011', 'Regular', 'Do--22222', 'admin', '2018-01-10 10:53:49', '', '0000-00-00 00:00:00'),
(4, '8', '2018-01-11', '2018-01-11', 'sp01', 'approved', 'gr_created', 'WRS011', 'Regular', 'Do-22111', 'admin', '2018-01-11 04:31:53', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_pr`
--

CREATE TABLE `master_pr` (
  `id_pr` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `division_code` varchar(255) NOT NULL,
  `division_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status_pr` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_pr`
--

INSERT INTO `master_pr` (`id_pr`, `request_date`, `division_code`, `division_name`, `description`, `status_pr`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(6, '2018-01-16', 'DVS012', 'Marketing', 'Pr Febri 123', 'po_created', 'admin', '2018-01-08 09:33:32', '', '0000-00-00 00:00:00'),
(7, '2018-01-10', 'DVS012', 'Marketing', 'Permintaan', 'po_created', 'admin', '2018-01-10 10:49:31', '', '0000-00-00 00:00:00'),
(8, '2018-01-11', 'DVS012', 'Marketing', 'Pemesanan', 'po_created', 'admin', '2018-01-11 04:02:48', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_province`
--

CREATE TABLE `master_province` (
  `id_province` int(11) NOT NULL,
  `province_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_province`
--

INSERT INTO `master_province` (`id_province`, `province_name`) VALUES
(1, 'Jawa Barat'),
(2, 'Sumatera Utara');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_remark`
--

CREATE TABLE `master_remark` (
  `id_remark` int(11) NOT NULL,
  `remark_code` varchar(50) NOT NULL,
  `remark_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_remark`
--

INSERT INTO `master_remark` (`id_remark`, `remark_code`, `remark_description`) VALUES
(1, 'L01', 'Normal'),
(2, 'L02', 'Masalah');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_tire`
--

CREATE TABLE `master_tire` (
  `id_tire` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `installed_status` varchar(255) NOT NULL,
  `unit_type` varchar(255) NOT NULL,
  `condition_off_tire` varchar(255) NOT NULL,
  `vehicle_id` varchar(50) NOT NULL,
  `chasis_id` varchar(255) NOT NULL,
  `current_odo_meter` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `warehouse_id` varchar(25) NOT NULL,
  `location_code` varchar(255) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `recycle_status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_tire`
--

INSERT INTO `master_tire` (`id_tire`, `product_code`, `serial_number`, `installed_status`, `unit_type`, `condition_off_tire`, `vehicle_id`, `chasis_id`, `current_odo_meter`, `description`, `warehouse_id`, `location_code`, `created_by`, `created_date`, `updated_by`, `updated_date`, `recycle_status`) VALUES
(1, 'dnlp22', 'aaa', 'not_installed', '', 'new', '', '', 12, 'aaa', 'WRS011', 'ASD - Rak', 'admin', '2017-11-24 09:25:39', 'admin', '2017-11-24 09:24:55', ''),
(2, '22ww', '22', 'installed', 'vehicle', 'new', '22222', '', 22, '22', '', '', 'admin', '2017-11-24 09:12:54', 'admin', '2017-11-24 09:12:54', ''),
(3, 'ee', 'ee', 'installed', 'vehicle', 'new', '112', '', 12, 'ee', '', '', 'admin', '2017-11-27 10:28:58', '', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_trucking_order`
--

CREATE TABLE `master_trucking_order` (
  `id_trucking_order` int(11) NOT NULL,
  `schedule_date` date NOT NULL,
  `trip` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `origin` varchar(50) NOT NULL,
  `origin_address` varchar(255) NOT NULL,
  `origin_area` varchar(255) NOT NULL,
  `origin_pickup_date` date NOT NULL,
  `origin_pickup_time` varchar(50) NOT NULL,
  `destination` varchar(50) NOT NULL,
  `destination_address` varchar(255) NOT NULL,
  `destination_area` varchar(255) NOT NULL,
  `destination_arrival_date` date NOT NULL,
  `destination_arrival_time` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_unit`
--

CREATE TABLE `master_unit` (
  `id_master_unit` int(11) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `manufacture_date` date NOT NULL,
  `purchase_date` date NOT NULL,
  `fuel_type` varchar(255) NOT NULL,
  `body_type` varchar(255) NOT NULL,
  `purchase_from` varchar(255) NOT NULL,
  `merk` varchar(100) NOT NULL,
  `purchase_price` int(11) NOT NULL,
  `model` varchar(100) NOT NULL,
  `assembly_type` varchar(100) NOT NULL,
  `current_odo` int(11) NOT NULL,
  `year` varchar(5) NOT NULL,
  `fuel_ratio_litre` varchar(100) NOT NULL,
  `tire_qty` int(11) NOT NULL,
  `kode_lambung` varchar(255) NOT NULL,
  `spare_tire` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_unit`
--

INSERT INTO `master_unit` (`id_master_unit`, `vehicle_id`, `vehicle_type`, `manufacture_date`, `purchase_date`, `fuel_type`, `body_type`, `purchase_from`, `merk`, `purchase_price`, `model`, `assembly_type`, `current_odo`, `year`, `fuel_ratio_litre`, `tire_qty`, `kode_lambung`, `spare_tire`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(7, 'B 9112 OF', '10', '2018-02-01', '2018-01-07', 'bensin', 'body_type_1', 'PT INDAH BERSAMA', 'VOLVO', 28000000, 'G', 'assembly_type_1', 60000, ' 2009', '2', 14, '', 2, 'admin', '2018-02-08 06:37:09', '', '0000-00-00 00:00:00'),
(8, 'Dummy 01', '10', '2018-02-01', '2018-01-07', 'bensin', 'body_type_1', 'Indah Besama-sama', 'Volvo', 0, '0', 'assembly_type_1', 0, ' 0', '0', 0, '', 0, 'admin', '2018-02-08 06:47:42', '', '0000-00-00 00:00:00'),
(9, 'Dummy 03', '6', '2018-02-21', '2018-02-28', 'Bensin', 'Body Type 1', '0', '0', 0, '0', 'Assembly 1', 0, ' 2019', '4', 6, '0', 3, 'admin', '2018-02-20 05:43:28', '', '0000-00-00 00:00:00'),
(10, 'Dummy 02', '6', '2018-02-21', '2018-02-20', 'Bensin', 'Body Type 1', '0', '0', 0, '0', 'Assembly 2', 0, ' 2015', '0', 10, '0', 2, 'admin', '2018-02-20 05:44:10', '', '0000-00-00 00:00:00'),
(11, 'B 1073 IW', '6', '2018-02-22', '2018-02-28', 'Bensin', 'Body Type 1', '0', '0', 0, '0', 'Assembly 1', 0, ' 2009', '6', 6, '0', 1, 'admin', '2018-02-20 06:07:41', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `master_vendor`
--

CREATE TABLE `master_vendor` (
  `id_vendor` int(11) NOT NULL,
  `vendor_id` varchar(255) NOT NULL,
  `vendor_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `master_vendor`
--

INSERT INTO `master_vendor` (`id_vendor`, `vendor_id`, `vendor_name`) VALUES
(1, 'VD01', 'Febri Service'),
(2, 'VD02', 'Ahmad Service');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_type`
--

CREATE TABLE `order_type` (
  `id_order_type` int(11) NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order_type`
--

INSERT INTO `order_type` (`id_order_type`, `description`) VALUES
(1, 'Langsir'),
(2, 'Import'),
(3, 'Export'),
(4, 'Regular'),
(5, 'Langsir_Empty_Cont');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pod`
--

CREATE TABLE `pod` (
  `id_pod` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `pod_date` date NOT NULL,
  `pod_time` varchar(50) NOT NULL,
  `code` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `submit_date` date NOT NULL,
  `submit_time` varchar(255) NOT NULL,
  `doc_reference` varchar(255) NOT NULL,
  `receive_date` date NOT NULL,
  `receive_time` varchar(50) NOT NULL,
  `receiver` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pod`
--

INSERT INTO `pod` (`id_pod`, `manifest`, `spk_number`, `pod_date`, `pod_time`, `code`, `pic`, `submit_date`, `submit_time`, `doc_reference`, `receive_date`, `receive_time`, `receiver`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, 2, 2, '2018-02-25', '05:27 PM', '10 - Code 1', '1212', '2018-02-25', '05:27 PM', '1212', '2018-02-25', '05:27 PM', '1212', 'admin', '2018-02-26 10:38:12', '', '0000-00-00 00:00:00'),
(6, 7, 7, '2018-02-27', '04:21 PM', '10 - Code 1', '1212', '2018-02-27', '04:21 PM', '12', '2018-02-27', '04:21 PM', '1212', 'admin', '2018-02-27 09:21:14', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id_product` int(11) NOT NULL,
  `id_warehouse` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `serial_number` varchar(255) NOT NULL,
  `product_description` text NOT NULL,
  `base_uom` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `qty_pallet` int(11) NOT NULL,
  `net_weight` varchar(50) NOT NULL,
  `gross_weight` varchar(50) NOT NULL,
  `uow` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id_product`, `id_warehouse`, `id_supplier`, `product_code`, `serial_number`, `product_description`, `base_uom`, `price`, `qty_pallet`, `net_weight`, `gross_weight`, `uow`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(4, 3, 1, '12345', 'Sn-12345', 'Ban Michellin', 'pcs', 1000000, 0, '', '20', '22', 'admin', '2018-01-10 10:47:07', '', '0000-00-00 00:00:00'),
(5, 3, 1, '54321', 'Sn-01', 'Gear', 'pcs', 500000, 0, '', '22', '22', 'admin', '2018-01-10 10:48:10', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_orders_gr`
--

CREATE TABLE `product_orders_gr` (
  `id_product_orders_gr` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `id_gr` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `qty_received` int(11) NOT NULL,
  `id_location` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_orders_gr`
--

INSERT INTO `product_orders_gr` (`id_product_orders_gr`, `id_product`, `product_code`, `price`, `id_gr`, `product_name`, `qty`, `qty_received`, `id_location`, `time_stamp`) VALUES
(13, 4, '12345', 1222, 10, 'desc', 5, 2, 7, '2018-01-08 14:47:56'),
(14, 5, '54321', 1222, 10, 'febri', 7, 2, 7, '2018-01-08 14:47:56'),
(15, 4, '12345', 1000000, 11, 'Ban Michellin', 1, 1, 7, '2018-01-10 10:53:49'),
(16, 5, '54321', 500000, 11, 'Gear', 4, 4, 7, '2018-01-10 10:53:49'),
(17, 4, '12345', 1000000, 12, 'Ban Michellin', 4, 4, 7, '2018-01-11 04:31:53'),
(18, 5, '54321', 500000, 12, 'Gear', 6, 6, 7, '2018-01-11 04:31:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_orders_invoice`
--

CREATE TABLE `product_orders_invoice` (
  `id_product_orders_invoice` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `price_total` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_orders_invoice`
--

INSERT INTO `product_orders_invoice` (`id_product_orders_invoice`, `id_product`, `product_code`, `price`, `price_total`, `id_invoice`, `product_name`, `qty`, `time_stamp`) VALUES
(1, 4, '4', 1222, 6110, 1, 'desc', 5, '2018-01-09 13:40:53'),
(2, 5, '5', 1222, 8554, 1, 'febri', 7, '2018-01-09 13:40:53'),
(3, 4, '4', 1222, 3666, 2, 'desc', 3, '2018-01-09 13:56:08'),
(4, 4, '4', 1222, 3666, 2, 'desc', 3, '2018-01-09 13:56:08'),
(5, 4, '4', 1000000, 1000000, 9, 'Ban Michellin', 1, '2018-01-10 10:55:32'),
(6, 5, '5', 500000, 2000000, 9, 'Gear', 4, '2018-01-10 10:55:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_orders_io`
--

CREATE TABLE `product_orders_io` (
  `id_product_orders_io` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `id_io` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `qty_approved` int(11) NOT NULL,
  `status_approved` varchar(50) NOT NULL,
  `id_location` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_orders_io`
--

INSERT INTO `product_orders_io` (`id_product_orders_io`, `id_product`, `product_code`, `price`, `id_io`, `product_name`, `qty`, `qty_approved`, `status_approved`, `id_location`, `time_stamp`) VALUES
(5, 4, '12345', 1222, 5, 'desc', 3, 3, 'approved', 8, '2018-01-09 08:42:30'),
(6, 4, '12345', 1222, 5, 'desc', 3, 3, 'approved', 7, '2018-01-09 08:42:32'),
(7, 4, '12345', 1222, 7, 'desc', 3, 3, 'approved', 7, '2018-01-09 23:31:47'),
(8, 4, '12345', 1222, 7, 'desc', 3, 3, 'approved', 8, '2018-01-09 23:31:50');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_orders_po`
--

CREATE TABLE `product_orders_po` (
  `id_product_orders_po` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `custom_price` int(11) NOT NULL,
  `id_po` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `id_pr` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `status_approved` varchar(10) NOT NULL,
  `qty_approve` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_orders_po`
--

INSERT INTO `product_orders_po` (`id_product_orders_po`, `id_product`, `product_code`, `price`, `custom_price`, `id_po`, `product_name`, `id_pr`, `qty`, `status_approved`, `qty_approve`, `time_stamp`) VALUES
(9, 4, '12345', 1222, 22222, 2, 'desc', 6, 10, 'approved', 5, '2018-01-08 13:30:53'),
(10, 5, '54321', 1222, 222222, 2, 'febri', 6, 20, 'approved', 7, '2018-01-08 13:30:53'),
(13, 4, '12345', 1000000, 1000000, 3, 'Ban Michellin', 7, 1, 'approved', 1, '2018-01-10 10:52:30'),
(14, 5, '54321', 500000, 500000, 3, 'Gear', 7, 5, 'approved', 4, '2018-01-10 10:52:30'),
(17, 4, '12345', 1000000, 0, 4, 'Ban Michellin', 8, 5, 'approved', 4, '2018-01-11 04:04:47'),
(18, 5, '54321', 500000, 0, 4, 'Gear', 8, 6, 'approved', 6, '2018-01-11 04:04:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_orders_pr`
--

CREATE TABLE `product_orders_pr` (
  `id_product_orders_pr` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `product_code` varchar(50) NOT NULL,
  `price` int(11) NOT NULL,
  `id_pr` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `qty` int(11) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product_orders_pr`
--

INSERT INTO `product_orders_pr` (`id_product_orders_pr`, `id_product`, `product_code`, `price`, `id_pr`, `product_name`, `qty`, `time_stamp`) VALUES
(1, 4, '12345', 1222, 6, 'desc', 10, '2018-01-08 09:33:32'),
(2, 5, '54321', 1222, 6, 'febri', 20, '2018-01-08 09:33:32'),
(3, 4, '12345', 1000000, 7, 'Ban Michellin', 1, '2018-01-10 10:49:31'),
(4, 5, '54321', 500000, 7, 'Gear', 5, '2018-01-10 10:49:31'),
(5, 4, '12345', 1000000, 8, 'Ban Michellin', 5, '2018-01-11 04:02:48'),
(6, 5, '54321', 500000, 8, 'Gear', 6, '2018-01-11 04:02:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_additional_cost_tms`
--

CREATE TABLE `purchase_additional_cost_tms` (
  `id_purchase_additional` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `additional_type` varchar(255) NOT NULL,
  `manifest` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `trip` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `purchase_additional_cost_tms`
--

INSERT INTO `purchase_additional_cost_tms` (`id_purchase_additional`, `id_invoice`, `additional_type`, `manifest`, `delivery_date`, `trip`, `amount`, `description`, `timestamp`) VALUES
(1, 3, 'Loading Charge', 28, '2018-01-16', 1, 11111, '22', '2018-01-09 14:01:38'),
(2, 3, 'Loading Charge', 28, '2018-01-16', 1, 0, '', '2018-01-09 14:01:38'),
(3, 3, 'Over Night', 28, '2018-01-16', 1, 500000, '', '2018-01-09 14:01:38'),
(4, 5, 'Loading Charge', 28, '2018-01-16', 1, 11111, '22', '2018-01-10 01:12:29'),
(5, 5, 'Loading Charge', 28, '2018-01-16', 1, 0, '', '2018-01-10 01:12:29'),
(6, 5, 'Over Night', 28, '2018-01-16', 1, 500000, '', '2018-01-10 01:12:29'),
(7, 6, 'Loading Charge', 28, '2018-01-16', 1, 11111, '22', '2018-01-10 01:15:39'),
(8, 6, 'Loading Charge', 28, '2018-01-16', 1, 0, '', '2018-01-10 01:15:40'),
(9, 6, 'Over Night', 28, '2018-01-16', 1, 500000, '', '2018-01-10 01:15:40'),
(10, 7, 'Loading Charge', 28, '2018-01-16', 1, 11111, '22', '2018-01-10 01:17:31'),
(11, 7, 'Loading Charge', 28, '2018-01-16', 1, 0, '', '2018-01-10 01:17:31'),
(12, 7, 'Over Night', 28, '2018-01-16', 1, 500000, '', '2018-01-10 01:17:31'),
(13, 8, 'Loading Charge', 28, '2018-01-16', 1, 11111, '22', '2018-01-10 01:52:21'),
(14, 8, 'Loading Charge', 28, '2018-01-16', 1, 0, '', '2018-01-10 01:52:21'),
(15, 8, 'Over Night', 28, '2018-01-16', 1, 500000, '', '2018-01-10 01:52:21'),
(16, 10, 'Over Night', 31, '2018-01-17', 1, 1000000, '1000000', '2018-01-10 11:21:21'),
(17, 10, 'Loading Charge', 31, '2018-01-17', 1, 2000000, '1000000', '2018-01-10 11:21:21'),
(18, 11, 'Loading Charge', 32, '2018-01-11', 1, 400000, 'Description 1', '2018-01-11 06:56:02'),
(19, 11, 'Multidrop Inner City', 32, '2018-01-11', 1, 200000, 'Description 2', '2018-01-11 06:56:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_invoice`
--

CREATE TABLE `purchase_invoice` (
  `id_purchase_invoice` int(11) NOT NULL,
  `id_reference` int(11) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_method` varchar(255) NOT NULL,
  `invoice_number` varchar(50) NOT NULL,
  `confirmation` varchar(50) NOT NULL,
  `invoice_type` varchar(50) NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `account` int(11) NOT NULL,
  `created_date` date NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `updated_date` date NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `purchase_invoice`
--

INSERT INTO `purchase_invoice` (`id_purchase_invoice`, `id_reference`, `invoice_date`, `invoice_method`, `invoice_number`, `confirmation`, `invoice_type`, `payment_method`, `account`, `created_date`, `created_by`, `updated_date`, `updated_by`) VALUES
(7, 28, '2018-01-16', 'sales', '11212', 'confirmed', 'tms', 'bank', 2, '2018-01-10', 'admin', '0000-00-00', ''),
(8, 28, '2018-01-16', 'sales', '1000000', 'confirmed', 'tms', 'cash', 3, '2018-01-10', 'admin', '0000-00-00', ''),
(9, 3, '2018-01-23', 'purchase', '12122', 'confirmed', 'po', 'cash', 3, '2018-01-10', 'admin', '0000-00-00', ''),
(10, 31, '2018-01-17', 'purchase', '1121', 'confirmed', 'tms', 'bank', 2, '2018-01-10', 'admin', '0000-00-00', ''),
(11, 32, '2018-01-11', 'purchase', '12345', 'confirmed', 'tms', 'cash', 3, '2018-01-11', 'admin', '0000-00-00', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `purchase_tms`
--

CREATE TABLE `purchase_tms` (
  `id_purchase_tms` int(11) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(50) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `origin_id` varchar(50) NOT NULL,
  `destination_id` varchar(255) NOT NULL,
  `cost` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `purchase_tms`
--

INSERT INTO `purchase_tms` (`id_purchase_tms`, `id_invoice`, `manifest`, `delivery_date`, `client_id`, `client_name`, `origin`, `destination`, `origin_id`, `destination_id`, `cost`, `timestamp`) VALUES
(4, 7, 28, '2018-01-16', '22', '22', 'cc02-Summarecon Bekasi-bekasi', 'cc02-Summarecon Bekasi-bekasi', 'cc02', 'cc02', 1000000, '2018-01-10 01:17:30'),
(5, 8, 28, '2018-01-16', '22', '22', 'cc02-Summarecon Bekasi-bekasi', 'cc02-Summarecon Bekasi-bekasi', 'cc02', 'cc02', 1000000, '2018-01-10 01:52:20'),
(6, 10, 31, '2018-01-17', '11', 'Febri Aditya2', 'cc02-Summarecon Bekasi-bekasi', 'cc3-Galaxy-bekasi', 'cc02', 'cc3', 2000, '2018-01-10 11:21:21'),
(7, 11, 32, '2018-01-11', '11', 'Febri Aditya2', 'cc02-Summarecon Bekasi-bekasi', 'cc3-Galaxy-bekasi', 'cc02', 'cc3', 2000, '2018-01-11 06:56:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_service`
--

CREATE TABLE `room_service` (
  `id_room_service` int(11) NOT NULL,
  `room_service_id` varchar(255) NOT NULL,
  `room_service_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `room_service`
--

INSERT INTO `room_service` (`id_room_service`, `room_service_id`, `room_service_name`) VALUES
(1, 'R001', 'Workshop Bay 1'),
(2, 'R002', 'Workshop Bay 2'),
(3, 'R003', 'Workshop Bay 3'),
(4, 'R004', 'Workshop Bay 4'),
(5, 'R005', 'Workshop Bay 5'),
(6, 'R006', 'Workshop Bay 6'),
(7, 'R007', 'Workshop Bay 7'),
(10, 'Wk01', 'Test');

-- --------------------------------------------------------

--
-- Struktur dari tabel `room_service_management`
--

CREATE TABLE `room_service_management` (
  `id_room_service_management` int(11) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `room_service_id` varchar(50) NOT NULL,
  `room_service_name` varchar(255) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `mecanic` varchar(255) NOT NULL,
  `vendor_id` varchar(50) NOT NULL,
  `vendor_name` varchar(50) NOT NULL,
  `service_status` varchar(255) NOT NULL,
  `service_man_power` varchar(255) NOT NULL,
  `start_service_date` date NOT NULL,
  `start_service_timestamp` timestamp NULL DEFAULT NULL,
  `start_service_time` varchar(50) NOT NULL,
  `finished_service_date` date NOT NULL,
  `finished_service_time` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `room_service_management`
--

INSERT INTO `room_service_management` (`id_room_service_management`, `vehicle_id`, `room_service_id`, `room_service_name`, `service_type`, `mecanic`, `vendor_id`, `vendor_name`, `service_status`, `service_man_power`, `start_service_date`, `start_service_timestamp`, `start_service_time`, `finished_service_date`, `finished_service_time`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 'B 9112 OF', 'R001', 'Workshop Bay 1', 'Quick Repair', 'Febri', '', '', 'Finished', 'inhouse_service', '2018-04-03', '2018-04-03 07:45:00', '12:45 AM', '0000-00-00', '', 'admin', '2018-04-08 05:50:58', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `service_vendor`
--

CREATE TABLE `service_vendor` (
  `id_service_vendor` int(11) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `service_status` varchar(255) NOT NULL,
  `service_date_finished` date NOT NULL,
  `vendor_id` varchar(255) NOT NULL,
  `vendor_name` varchar(255) NOT NULL,
  `service_type` varchar(255) NOT NULL,
  `start_service_date` date NOT NULL,
  `start_service_time` varchar(50) NOT NULL,
  `finished_service_date` date NOT NULL,
  `finished_service_time` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `service_vendor`
--

INSERT INTO `service_vendor` (`id_service_vendor`, `vehicle_id`, `service_status`, `service_date_finished`, `vendor_id`, `vendor_name`, `service_type`, `start_service_date`, `start_service_time`, `finished_service_date`, `finished_service_time`, `remark`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(6, 'B 9112 OF', 'On Progress', '0000-00-00', 'VD01', 'Febri Service', 'Service Type 1', '0000-00-00', '04:45 PM', '0000-00-00', '04:45 PM', 'test', 'admin', '2018-02-16 09:59:24', 'admin', '2018-02-16 09:59:24');

-- --------------------------------------------------------

--
-- Struktur dari tabel `shift`
--

CREATE TABLE `shift` (
  `id_shift` int(11) NOT NULL,
  `shift` int(11) NOT NULL,
  `shift_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `shift`
--

INSERT INTO `shift` (`id_shift`, `shift`, `shift_description`) VALUES
(1, 1, '08.00 - 17.00'),
(2, 2, '17.00 - 24.00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `supplier_code` varchar(255) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `address_1` varchar(500) NOT NULL,
  `address_2` varchar(500) NOT NULL,
  `supplier_type` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `fax` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `supplier_code`, `supplier_name`, `address_1`, `address_2`, `supplier_type`, `city`, `area`, `postal_code`, `phone`, `fax`, `pic`, `email`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, 'sp01', 'febri supplier', 'www2', 'www2', 'tipe_1', 'ww2', '', 'ww2', 'www', 'ww', 'ww', 'ww@gmail.com', 'admin', '2017-11-14 04:05:59', 'admin', '2017-11-01 03:17:37'),
(2, 'sp02', 'Mimi Supplier', 'eeee', 'eee', 'tipe_1', 'ww2', '', 'ww2', 'www', 'ww', 'ww', 'ww@gmail.com', 'admin', '2017-11-14 04:06:07', 'admin', '2017-11-01 03:17:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `test_integer`
--

CREATE TABLE `test_integer` (
  `id` int(11) NOT NULL,
  `name` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `traffic_monitoring_export`
--

CREATE TABLE `traffic_monitoring_export` (
  `id_traffic_monitoring_export` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `point_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `arrival_estimation_date` date NOT NULL,
  `arrival_estimation_time` varchar(50) NOT NULL,
  `arrival_actual_date` date NOT NULL,
  `arrival_actual_time` varchar(50) NOT NULL,
  `loading_empty_cont_documentation_date` date NOT NULL,
  `loading_empty_cont_documentation_time` varchar(50) NOT NULL,
  `loading_empty_cont_start_date` date NOT NULL,
  `loading_empty_cont_start_time` varchar(50) NOT NULL,
  `loading_empty_cont_finish_date` date NOT NULL,
  `loading_empty_cont_finish_time` varchar(50) NOT NULL,
  `loading_product_documentation_date` date NOT NULL,
  `loading_product_documentation_time` varchar(50) NOT NULL,
  `loading_product_start_date` date NOT NULL,
  `loading_product_start_time` varchar(50) NOT NULL,
  `loading_product_finish_date` date NOT NULL,
  `loading_product_finish_time` varchar(50) NOT NULL,
  `departure_estimation_date` date NOT NULL,
  `departure_estimation_time` varchar(50) NOT NULL,
  `departure_actual_date` date NOT NULL,
  `departure_actual_time` varchar(50) NOT NULL,
  `landing_cont_estimation_date` date NOT NULL,
  `landing_cont_estimation_time` varchar(50) NOT NULL,
  `landing_cont_actual_date` date NOT NULL,
  `landing_cont_actual_time` varchar(50) NOT NULL,
  `landing_location` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `traffic_monitoring_export`
--

INSERT INTO `traffic_monitoring_export` (`id_traffic_monitoring_export`, `manifest`, `spk_number`, `state`, `point_id`, `name`, `address`, `arrival_estimation_date`, `arrival_estimation_time`, `arrival_actual_date`, `arrival_actual_time`, `loading_empty_cont_documentation_date`, `loading_empty_cont_documentation_time`, `loading_empty_cont_start_date`, `loading_empty_cont_start_time`, `loading_empty_cont_finish_date`, `loading_empty_cont_finish_time`, `loading_product_documentation_date`, `loading_product_documentation_time`, `loading_product_start_date`, `loading_product_start_time`, `loading_product_finish_date`, `loading_product_finish_time`, `departure_estimation_date`, `departure_estimation_time`, `departure_actual_date`, `departure_actual_time`, `landing_cont_estimation_date`, `landing_cont_estimation_time`, `landing_cont_actual_date`, `landing_cont_actual_time`, `landing_location`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(2, 2, 2, 'origin', 'IMB', 'PT Trouw Nutrition Indonesia', 'Jalan Perancis No. 1 Belawan', '0000-00-00', '', '2018-03-10', '09:57 AM', '2018-03-10', '09:32 AM', '2018-03-10', '09:31 AM', '2018-03-10', '09:32 AM', '2018-03-10', '09:33 AM', '2018-03-10', '09:32 AM', '2018-03-10', '09:33 AM', '0000-00-00', '', '2018-03-10', '09:33 AM', '0000-00-00', '', '0000-00-00', '', '', '', '2018-03-10 08:57:09', '', '0000-00-00 00:00:00'),
(3, 2, 2, 'destination', 'APB', 'PT Trouw Nutrition Indonesia', 'Jalan Anugerah No. 2 Medan', '0000-00-00', '', '2018-03-10', '09:33 AM', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '2018-03-10', '09:33 AM', '0000-00-00', '', '2018-03-10', '09:33 AM', '', '', '2018-03-10 08:33:48', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `traffic_monitoring_import`
--

CREATE TABLE `traffic_monitoring_import` (
  `id_traffic_monitoring_import` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `point_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `arrival_estimation_date` date NOT NULL,
  `arrival_estimation_time` varchar(50) NOT NULL,
  `arrival_actual_date` date NOT NULL,
  `arrival_actual_time` varchar(50) NOT NULL,
  `loading_unloading_start_date` date NOT NULL,
  `loading_unloading_start_time` varchar(50) NOT NULL,
  `loading_unloading_finish_date` date NOT NULL,
  `loading_unloading_finish_time` varchar(50) NOT NULL,
  `loading_unloading_documentation_date` date NOT NULL,
  `loading_unloading_documentation_time` varchar(50) NOT NULL,
  `departure_estimation_date` date NOT NULL,
  `departure_estimation_time` varchar(50) NOT NULL,
  `departure_actual_date` date NOT NULL,
  `departure_actual_time` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `landing_container_estimation_date` date NOT NULL,
  `landing_container_estimation_time` varchar(50) NOT NULL,
  `landing_container_actual_date` date NOT NULL,
  `landing_container_actual_time` varchar(50) NOT NULL,
  `landing_location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `traffic_monitoring_import`
--

INSERT INTO `traffic_monitoring_import` (`id_traffic_monitoring_import`, `manifest`, `spk_number`, `state`, `point_id`, `name`, `address`, `arrival_estimation_date`, `arrival_estimation_time`, `arrival_actual_date`, `arrival_actual_time`, `loading_unloading_start_date`, `loading_unloading_start_time`, `loading_unloading_finish_date`, `loading_unloading_finish_time`, `loading_unloading_documentation_date`, `loading_unloading_documentation_time`, `departure_estimation_date`, `departure_estimation_time`, `departure_actual_date`, `departure_actual_time`, `created_by`, `created_time`, `updated_by`, `updated_time`, `landing_container_estimation_date`, `landing_container_estimation_time`, `landing_container_actual_date`, `landing_container_actual_time`, `landing_location`) VALUES
(25, 2, 2, 'origin', 'IMB', 'PT Trouw Nutrition Indonesia', 'Jalan Perancis No. 1 Belawan', '0000-00-00', '', '2018-03-10', '07:52 AM', '2018-03-10', '07:52 AM', '2018-03-10', '07:53 AM', '0000-00-00', '', '0000-00-00', '', '2018-03-10', '07:53 AM', '', '2018-03-10 06:53:18', '', '0000-00-00 00:00:00', '0000-00-00', '', '0000-00-00', '', ''),
(26, 2, 2, 'destination', 'APB', 'PT Trouw Nutrition Indonesia', 'Jalan Anugerah No. 2 Medan', '0000-00-00', '', '2018-03-10', '07:56 AM', '2018-03-10', '07:56 AM', '2018-03-10', '07:56 AM', '0000-00-00', '', '0000-00-00', '', '2018-03-10', '07:57 AM', '', '2018-03-10 06:57:25', '', '0000-00-00 00:00:00', '0000-00-00', '', '2018-03-10', '07:57 AM', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `traffic_monitoring_langsir`
--

CREATE TABLE `traffic_monitoring_langsir` (
  `id_traffic_monitoring_langsir` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `point_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `arrival_estimation_date` date NOT NULL,
  `arrival_estimation_time` varchar(50) NOT NULL,
  `arrival_actual_date` date NOT NULL,
  `arrival_actual_time` varchar(50) NOT NULL,
  `loading_landing_start_date` date NOT NULL,
  `loading_landing_start_time` varchar(50) NOT NULL,
  `loading_landing_finish_date` date NOT NULL,
  `loading_landing_finish_time` varchar(50) NOT NULL,
  `loading_landing_documentation_date` date NOT NULL,
  `loading_landing_documentation_time` varchar(50) NOT NULL,
  `departure_estimation_date` date NOT NULL,
  `departure_estimation_time` varchar(50) NOT NULL,
  `departure_actual_date` date NOT NULL,
  `departure_actual_time` varchar(50) NOT NULL,
  `landing_location` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `traffic_monitoring_langsir`
--

INSERT INTO `traffic_monitoring_langsir` (`id_traffic_monitoring_langsir`, `manifest`, `spk_number`, `state`, `point_id`, `name`, `address`, `arrival_estimation_date`, `arrival_estimation_time`, `arrival_actual_date`, `arrival_actual_time`, `loading_landing_start_date`, `loading_landing_start_time`, `loading_landing_finish_date`, `loading_landing_finish_time`, `loading_landing_documentation_date`, `loading_landing_documentation_time`, `departure_estimation_date`, `departure_estimation_time`, `departure_actual_date`, `departure_actual_time`, `landing_location`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(1, 2, 2, 'origin', 'IMB', 'PT Indah Maju Bersama', 'Jalan Perancis No. 1 Belawan', '2018-05-02', '03:15 PM', '2018-05-09', '03:15 PM', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '', '', '2018-05-01 08:14:13', 'admin', '2018-05-01 07:14:13'),
(3, 2, 2, 'destination', 'APB', 'PT Trouw Nutrition Indonesia', 'Jalan Anugerah No. 2 Medan', '0000-00-00', '', '2018-03-10', '08:53 AM', '2018-03-10', '08:54 AM', '2018-03-10', '08:55 AM', '2018-03-10', '08:55 AM', '0000-00-00', '', '2018-03-10', '08:59 AM', 'Depo', '', '2018-03-10 07:59:11', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `traffic_monitoring_langsir_empty`
--

CREATE TABLE `traffic_monitoring_langsir_empty` (
  `id_traffic_monitoring_langsir_empty_cont` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `point_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `arrival_estimation_date` date NOT NULL,
  `arrival_estimation_time` varchar(50) NOT NULL,
  `arrival_actual_date` date NOT NULL,
  `arrival_actual_time` varchar(50) NOT NULL,
  `loading_landing_start_date` date NOT NULL,
  `loading_landing_start_time` varchar(50) NOT NULL,
  `loading_landing_finish_date` date NOT NULL,
  `loading_landing_finish_time` varchar(50) NOT NULL,
  `loading_landing_documentation_date` date NOT NULL,
  `loading_landing_documentation_time` varchar(50) NOT NULL,
  `departure_estimation_date` date NOT NULL,
  `departure_estimation_time` varchar(50) NOT NULL,
  `departure_actual_date` date NOT NULL,
  `departure_actual_time` varchar(50) NOT NULL,
  `landing_location` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `traffic_monitoring_regular`
--

CREATE TABLE `traffic_monitoring_regular` (
  `id_traffic_monitoring_regular` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `state` varchar(255) NOT NULL,
  `point_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `arrival_estimation_date` date NOT NULL,
  `arrival_estimation_time` varchar(50) NOT NULL,
  `arrival_actual_date` date NOT NULL,
  `arrival_actual_time` varchar(50) NOT NULL,
  `loading_unloading_start_date` date NOT NULL,
  `loading_unloading_start_time` varchar(50) NOT NULL,
  `loading_unloading_finish_date` date NOT NULL,
  `loading_unloading_finish_time` varchar(50) NOT NULL,
  `loading_unloading_documentation_date` date NOT NULL,
  `loading_unloading_documentation_time` varchar(50) NOT NULL,
  `departure_estimation_date` date NOT NULL,
  `departure_estimation_time` varchar(50) NOT NULL,
  `departure_actual_date` date NOT NULL,
  `departure_actual_time` varchar(50) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `traffic_monitoring_regular`
--

INSERT INTO `traffic_monitoring_regular` (`id_traffic_monitoring_regular`, `manifest`, `spk_number`, `state`, `point_id`, `name`, `address`, `arrival_estimation_date`, `arrival_estimation_time`, `arrival_actual_date`, `arrival_actual_time`, `loading_unloading_start_date`, `loading_unloading_start_time`, `loading_unloading_finish_date`, `loading_unloading_finish_time`, `loading_unloading_documentation_date`, `loading_unloading_documentation_time`, `departure_estimation_date`, `departure_estimation_time`, `departure_actual_date`, `departure_actual_time`, `created_by`, `created_time`, `updated_by`, `updated_time`) VALUES
(8, 2, 2, 'origin', 'IMB', 'PT Trouw Nutrition Indonesia', 'Jalan Perancis No. 1 Belawan', '0000-00-00', '', '2018-03-11', '01:40 PM', '2018-03-11', '01:42 PM', '2018-03-10', '10:44 AM', '2018-03-10', '10:47 AM', '0000-00-00', '', '0000-00-00', '', '', '2018-03-11 12:42:03', '', '0000-00-00 00:00:00'),
(10, 2, 2, 'Destination', 'APB', 'PT Anugerah Persada Bersama', 'Jalan Anugerah No. 2 Medan', '0000-00-00', '', '2018-03-11', '03:40 PM', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', '0000-00-00', '', 'admin', '2018-03-11 08:40:35', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaction`
--

CREATE TABLE `transaction` (
  `id_transaction` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `id_invoice` int(11) NOT NULL,
  `confirmation` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `account` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaction`
--

INSERT INTO `transaction` (`id_transaction`, `type`, `id_invoice`, `confirmation`, `payment_method`, `account`, `amount`, `timestamp`) VALUES
(18, 'tms', 8, 'confirmed', 'cash', '3', 1511111, '2018-01-10 02:00:19'),
(19, 'tms', 7, 'confirmed', 'bank', '2', 1511111, '2018-01-10 02:22:28'),
(20, 'po', 9, 'confirmed', 'cash', '3', 3000000, '2018-01-10 11:11:56'),
(21, 'tms', 10, 'confirmed', 'bank', '2', 3002000, '2018-01-10 11:21:31'),
(22, 'tms', 11, 'confirmed', 'cash', '3', 602000, '2018-01-11 06:57:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transporter`
--

CREATE TABLE `transporter` (
  `id_transporter` int(11) NOT NULL,
  `transporter_id` varchar(50) NOT NULL,
  `transporter_name` varchar(255) NOT NULL,
  `transporter_address_1` varchar(255) NOT NULL,
  `transporter_address_2` varchar(255) NOT NULL,
  `transporter_city` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `postal_code` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transporter`
--

INSERT INTO `transporter` (`id_transporter`, `transporter_id`, `transporter_name`, `transporter_address_1`, `transporter_address_2`, `transporter_city`, `area`, `postal_code`, `pic`, `email`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(5, 'CCT', 'CV Cirasa Transportindo ', 'Jalan Raya Malaka No.34', '', 'Medan', 'MEDAN', '123456', 'DEdi', 'dedi@mail.co.id', 'admin', '2018-02-08 06:21:40', '', '0000-00-00 00:00:00'),
(6, 'CGM', 'PT Citra Gadjahmada Trans', 'Jalan Raya Pekayon No 32', '', 'Medan', 'MEDAN', 'test', 'test', 'test', 'admin', '2018-02-20 04:37:22', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transporter_rate`
--

CREATE TABLE `transporter_rate` (
  `id_transporter_rate` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `transporter_id` varchar(255) NOT NULL,
  `transporter_name` varchar(255) NOT NULL,
  `origin` varchar(255) NOT NULL,
  `destination` varchar(255) NOT NULL,
  `province` varchar(255) NOT NULL,
  `vehicle_type` varchar(50) NOT NULL,
  `id_vehicle_type` int(11) NOT NULL,
  `vehicle_status` varchar(50) NOT NULL,
  `fixed_rate` varchar(50) NOT NULL,
  `period_rate` varchar(50) NOT NULL,
  `trip_quota` varchar(50) NOT NULL,
  `vehicle_rate` varchar(50) NOT NULL,
  `weight_rate` varchar(50) NOT NULL,
  `excess_weight_rate` varchar(50) NOT NULL,
  `min_weight` varchar(50) NOT NULL,
  `max_weight` varchar(50) NOT NULL,
  `uow` varchar(50) NOT NULL,
  `volume_rate` varchar(50) NOT NULL,
  `min_volume` varchar(50) NOT NULL,
  `uov` varchar(50) NOT NULL,
  `currency` varchar(50) NOT NULL,
  `drop_destination` varchar(50) NOT NULL,
  `drop_rate` varchar(50) NOT NULL,
  `drop_charge_after` varchar(50) NOT NULL,
  `drop_rate_inner` varchar(50) NOT NULL,
  `drop_rate_outer` varchar(50) NOT NULL,
  `start_valid_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `rate_status` varchar(50) NOT NULL,
  `remark` varchar(50) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(50) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transporter_rate`
--

INSERT INTO `transporter_rate` (`id_transporter_rate`, `client_id`, `client_name`, `transporter_id`, `transporter_name`, `origin`, `destination`, `province`, `vehicle_type`, `id_vehicle_type`, `vehicle_status`, `fixed_rate`, `period_rate`, `trip_quota`, `vehicle_rate`, `weight_rate`, `excess_weight_rate`, `min_weight`, `max_weight`, `uow`, `volume_rate`, `min_volume`, `uov`, `currency`, `drop_destination`, `drop_rate`, `drop_charge_after`, `drop_rate_inner`, `drop_rate_outer`, `start_valid_date`, `expired_date`, `rate_status`, `remark`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(7, 'TNI', 'PT Trouw Nutrition Indonesia', 'CCT', 'CV Cirasa Transportindo ', 'BELAWAN', 'MEDAN', 'Jawa Barat', 'TRAILER 20', 10, 'oncall', '0', '2018-02-01', '0', '1500000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-01', '2018-02-28', 'active', 'Trailer 20', 'admin', '2018-02-08 06:33:08', '', '0000-00-00 00:00:00'),
(8, 'TNI', 'PT Trouw Nutrition Indonesia', 'CCT', 'CV Cirasa Transportindo ', 'BINJAI', 'MEDAN', 'Jawa Barat', 'CDD BOX', 6, 'oncall', '0', '2018-02-28', '0', '550000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-23', '2018-04-28', 'active', 'tes', 'admin', '2018-02-27 05:44:31', 'admin', '2018-02-20 05:29:55'),
(9, 'TNI', 'PT Trouw Nutrition Indonesia', 'CGM', 'PT Citra Gadjahmada Trans', 'BINJAI', 'MEDAN', 'Jawa Barat', 'CDD BOX', 6, 'oncall', '0', '2018-02-27', '0', '650000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-02-21', '2018-03-17', 'active', 'Test', 'admin', '2018-02-27 05:44:34', '', '0000-00-00 00:00:00'),
(10, 'SFT', 'SOFTEX INDONESIA', 'CCT', 'CV Cirasa Transportindo ', 'MEDAN', 'JAKARTA', 'Jawa Barat', 'TRONTON BOX', 8, 'oncall', '0', '2018-01-01', '0', '30000000', '0', '0', '0', '0', '0', '0', '0', '0', 'IDR', '0', '0', '0', '0', '0', '2018-01-01', '2019-01-31', 'active', 'ACTIVE', 'admin', '2018-02-27 05:44:35', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transport_order`
--

CREATE TABLE `transport_order` (
  `spk_number` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `pod_number` varchar(255) NOT NULL,
  `pod_confirmed` varchar(255) NOT NULL,
  `pod` varchar(255) NOT NULL,
  `do_number` varchar(255) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `delivery_date` date NOT NULL,
  `delivery_time` varchar(50) NOT NULL,
  `origin_id` varchar(255) NOT NULL,
  `origin_address` varchar(255) NOT NULL,
  `origin_area` varchar(255) NOT NULL,
  `destination_id` varchar(255) NOT NULL,
  `destination_address` varchar(255) NOT NULL,
  `destination_area` varchar(255) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `document_date` date NOT NULL,
  `document_time` varchar(50) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `posting_date` date NOT NULL,
  `status` varchar(50) NOT NULL,
  `status_to` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `actual_qty` int(11) NOT NULL,
  `reason` varchar(255) NOT NULL,
  `trip` int(11) NOT NULL,
  `qty` varchar(50) NOT NULL,
  `volume` varchar(50) NOT NULL,
  `weight` varchar(50) NOT NULL,
  `cargo_type` varchar(50) NOT NULL,
  `si` varchar(100) NOT NULL,
  `hawb` varchar(100) NOT NULL,
  `mawb` varchar(100) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `invoice_number_to_client` varchar(255) NOT NULL,
  `invoice_number_to_client_date` date NOT NULL,
  `invoice_number_from_supplier` varchar(255) NOT NULL,
  `invoice_number_from_supplier_date` date NOT NULL,
  `id_detail_trucking_order` int(11) NOT NULL,
  `id_trucking_order` int(11) NOT NULL,
  `created_by` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(100) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `transport_order`
--

INSERT INTO `transport_order` (`spk_number`, `manifest`, `pod_number`, `pod_confirmed`, `pod`, `do_number`, `reference`, `delivery_date`, `delivery_time`, `origin_id`, `origin_address`, `origin_area`, `destination_id`, `destination_address`, `destination_area`, `client_id`, `client_name`, `document_date`, `document_time`, `order_type`, `posting_date`, `status`, `status_to`, `remark`, `actual_qty`, `reason`, `trip`, `qty`, `volume`, `weight`, `cargo_type`, `si`, `hawb`, `mawb`, `notes`, `invoice_number_to_client`, `invoice_number_to_client_date`, `invoice_number_from_supplier`, `invoice_number_from_supplier_date`, `id_detail_trucking_order`, `id_trucking_order`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(1, 4, '', '', '', '223', 'wwee', '2018-05-01', '07:00 AM', 'IMB', 'Jalan Perancis No. 1 Belawan', 'BELAWAN', 'APB', 'Jalan Anugerah No. 2 Medan', 'MEDAN', 'TNI', 'PT Trouw Nutrition Indonesia', '2018-04-04', '07:00 AM', 'Regular', '2018-04-04', '', '', '23232', 0, '', 1, '', '', '', 'Pile', '', '', '', '', '', '0000-00-00', '', '0000-00-00', 3, 1, 'admin', '2018-05-01 08:12:04', '', '0000-00-00 00:00:00'),
(2, 2, '', '', '', '123', '123', '2018-05-01', '07:15 PM', 'IMB', 'Jalan Perancis No. 1 Belawan', 'BELAWAN', 'APB', 'Jalan Anugerah No. 2 Medan', 'MEDAN', 'SFT', 'SOFTEX INDONESIA', '2018-05-01', '07:15 PM', 'Langsir', '2018-05-01', '', '', '', 0, '', 1, '', '', '', '', '', '', '', '', '', '0000-00-00', '', '0000-00-00', 0, 0, 'admin', '2018-05-01 07:25:53', '', '0000-00-00 00:00:00'),
(3, 8, '', '', '', 'test123', 'test123', '2018-05-03', '03:45 PM', 'IMB', 'Jalan Perancis No. 1 Belawan', 'BELAWAN', 'APB', 'Jalan Anugerah No. 2 Medan', 'MEDAN', 'TNI', 'PT Trouw Nutrition Indonesia', '2018-05-03', '03:45 PM', 'Langsir', '2018-05-03', '', '', '', 0, '', 2, '', '', '', '', '', '', '', '', '', '0000-00-00', '', '0000-00-00', 0, 0, 'admin', '2018-05-03 11:06:38', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `truck_absent`
--

CREATE TABLE `truck_absent` (
  `id_truck_absent` int(11) NOT NULL,
  `vehicle_id` varchar(255) NOT NULL,
  `transporter_name` varchar(255) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_code` varchar(255) NOT NULL,
  `id_shift` int(11) NOT NULL,
  `kelengkapan_oli_mesin` varchar(10) NOT NULL,
  `action_kelengkapan_oli_mesin` varchar(255) NOT NULL,
  `kecukupan_air_radioator` varchar(10) NOT NULL,
  `action_kecukupan_air_radioator` varchar(255) NOT NULL,
  `kondisi_ban` varchar(10) NOT NULL,
  `action_kondisi_ban` varchar(255) NOT NULL,
  `kondisi_accu` varchar(10) NOT NULL,
  `action_kondisi_accu` varchar(255) NOT NULL,
  `kontrol_lampu` varchar(10) NOT NULL,
  `action_kontrol_lampu` varchar(255) NOT NULL,
  `angin_untuk_rem` varchar(10) NOT NULL,
  `action_angin_untuk_rem` varchar(255) NOT NULL,
  `test_mesin` varchar(10) NOT NULL,
  `action_test_mesin` varchar(255) NOT NULL,
  `kondisi_body_truck` varchar(10) NOT NULL,
  `action_kondisi_body_truck` varchar(255) NOT NULL,
  `kecukupan_isi_solar` varchar(10) NOT NULL,
  `action_kecukupan_isi_solar` varchar(255) NOT NULL,
  `kelengkapan_safety` varchar(10) NOT NULL,
  `action_kelengkapan_safety` varchar(255) NOT NULL,
  `kelengkapan_document` varchar(10) NOT NULL,
  `action_kelengkapan_document` varchar(255) NOT NULL,
  `date_absence` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `truck_absent`
--

INSERT INTO `truck_absent` (`id_truck_absent`, `vehicle_id`, `transporter_name`, `vehicle_type`, `driver_name`, `driver_code`, `id_shift`, `kelengkapan_oli_mesin`, `action_kelengkapan_oli_mesin`, `kecukupan_air_radioator`, `action_kecukupan_air_radioator`, `kondisi_ban`, `action_kondisi_ban`, `kondisi_accu`, `action_kondisi_accu`, `kontrol_lampu`, `action_kontrol_lampu`, `angin_untuk_rem`, `action_angin_untuk_rem`, `test_mesin`, `action_test_mesin`, `kondisi_body_truck`, `action_kondisi_body_truck`, `kecukupan_isi_solar`, `action_kecukupan_isi_solar`, `kelengkapan_safety`, `action_kelengkapan_safety`, `kelengkapan_document`, `action_kelengkapan_document`, `date_absence`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(3, 'B 9112 OF', '', '', 'AHMAD', 'AHD', 0, 'ok', 'Tidak Baik', 'ok', 'Tidak Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', 'ok', 'Baik', '2018-04-08', 'admin', '2018-04-08 07:13:48', '', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `truck_accident`
--

CREATE TABLE `truck_accident` (
  `id_truck_accident` int(11) NOT NULL,
  `accident_date` date NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `client_id` varchar(255) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `driver_name` varchar(255) NOT NULL,
  `driver_code` varchar(255) NOT NULL,
  `accident_type` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `chronology_accident` text NOT NULL,
  `vehicle_condition` varchar(255) NOT NULL,
  `vehicle_position` varchar(255) NOT NULL,
  `amount_less` int(11) NOT NULL,
  `bap_police` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `truck_accident`
--

INSERT INTO `truck_accident` (`id_truck_accident`, `accident_date`, `vehicle_id`, `client_id`, `client_name`, `driver_name`, `driver_code`, `accident_type`, `location`, `chronology_accident`, `vehicle_condition`, `vehicle_position`, `amount_less`, `bap_police`, `created_by`, `created_date`, `updated_by`, `updated_date`) VALUES
(5, '2018-02-08', 0, 'TNI', 'PT Trouw Nutrition Indonesia', 'AHMAD', 'AHD', 'Accident Type 1', 'Belawan', 'Ketika ada orang menyebrang supir melakukan pengeram mendadak dan ban slip ', 'lampu sen belakang hancur', 'Belawan ', 500000, 'ada', 'admin', '2018-02-08 09:00:32', 'admin', '2018-02-08 09:00:32');

-- --------------------------------------------------------

--
-- Struktur dari tabel `update_apps`
--

CREATE TABLE `update_apps` (
  `id_update_apps` int(11) NOT NULL,
  `point_id` varchar(50) NOT NULL,
  `status` varchar(255) NOT NULL,
  `order_type` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `foto` varchar(255) NOT NULL,
  `driver_code` varchar(255) NOT NULL,
  `spk_number` int(11) NOT NULL,
  `manifest` int(11) NOT NULL,
  `latitude` varchar(50) NOT NULL,
  `longitude` varchar(50) NOT NULL,
  `alasan_gps` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `update_apps`
--

INSERT INTO `update_apps` (`id_update_apps`, `point_id`, `status`, `order_type`, `state`, `timestamp`, `foto`, `driver_code`, `spk_number`, `manifest`, `latitude`, `longitude`, `alasan_gps`) VALUES
(130, 'IMB', 'arrival', 'Regular', 'origin', '2018-03-11 06:40:44', '', 'AHD', 2, 2, '3.5784272', '98.68586739999999', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `distributor_code` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `ket` varchar(255) NOT NULL,
  `user_access` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `activated` tinyint(1) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `ban_reason` varchar(255) NOT NULL,
  `new_password_key` varchar(50) NOT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) DEFAULT NULL,
  `new_email_key` varchar(50) DEFAULT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_account`
--

INSERT INTO `user_account` (`user_id`, `name`, `username`, `password`, `distributor_code`, `email`, `user_type`, `ket`, `user_access`, `code`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'ADMINISTRATOR', 'admin', 'a5dc48744f0b742a4729a42636e7b83d8a09c5347205cbc9d563629581358aa5', '', 'brianadikusumo@gmail.com', 'Administrator', '1', 12, '0', 1, 0, '', '', NULL, NULL, NULL, '::1', '2016-01-11 01:31:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_autologin`
--

CREATE TABLE `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `see_distributor` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `see_driver` varchar(10) NOT NULL,
  `add_driver` varchar(10) NOT NULL,
  `delete_driver` varchar(10) NOT NULL,
  `edit_driver` varchar(10) NOT NULL,
  `import_driver` varchar(10) NOT NULL,
  `export_driver` varchar(255) NOT NULL,
  `add_warehouse` varchar(50) NOT NULL,
  `edit_warehouse` varchar(50) NOT NULL,
  `delete_warehouse` varchar(50) NOT NULL,
  `export_warehouse` varchar(50) NOT NULL,
  `import_warehouse` varchar(50) NOT NULL,
  `see_warehouse` varchar(50) NOT NULL,
  `see_supplier` varchar(10) NOT NULL,
  `add_supplier` varchar(10) NOT NULL,
  `edit_supplier` varchar(10) NOT NULL,
  `delete_supplier` varchar(10) NOT NULL,
  `export_supplier` varchar(10) NOT NULL,
  `import_supplier` varchar(10) NOT NULL,
  `see_product` varchar(10) NOT NULL,
  `add_product` varchar(10) NOT NULL,
  `delete_product` varchar(10) NOT NULL,
  `edit_product` varchar(10) NOT NULL,
  `export_product` varchar(10) NOT NULL,
  `import_product` varchar(10) NOT NULL,
  `see_location` varchar(10) NOT NULL,
  `add_location` varchar(10) NOT NULL,
  `delete_location` varchar(10) NOT NULL,
  `edit_location` varchar(10) NOT NULL,
  `import_location` varchar(10) NOT NULL,
  `export_location` varchar(10) NOT NULL,
  `see_location_type` varchar(10) NOT NULL,
  `add_location_type` varchar(10) NOT NULL,
  `delete_location_type` varchar(10) NOT NULL,
  `edit_location_type` varchar(10) NOT NULL,
  `import_location_type` varchar(10) NOT NULL,
  `export_location_type` varchar(10) NOT NULL,
  `see_po` varchar(10) NOT NULL,
  `add_po` varchar(10) NOT NULL,
  `delete_po` text NOT NULL,
  `edit_po` varchar(10) NOT NULL,
  `import_po` varchar(10) NOT NULL,
  `export_po` varchar(10) NOT NULL,
  `see_gr` varchar(10) NOT NULL,
  `add_gr` varchar(10) NOT NULL,
  `delete_gr` varchar(10) NOT NULL,
  `edit_gr` varchar(10) NOT NULL,
  `import_gr` varchar(10) NOT NULL,
  `export_gr` varchar(10) NOT NULL,
  `see_vehicle_type` varchar(10) NOT NULL,
  `add_vehicle_type` varchar(10) NOT NULL,
  `delete_vehicle_type` varchar(10) NOT NULL,
  `edit_vehicle_type` varchar(10) NOT NULL,
  `import_vehicle_type` varchar(10) NOT NULL,
  `export_vehicle_type` varchar(10) NOT NULL,
  `see_master_unit` varchar(10) NOT NULL,
  `add_master_unit` varchar(10) NOT NULL,
  `delete_master_unit` varchar(10) NOT NULL,
  `edit_master_unit` varchar(10) NOT NULL,
  `import_master_unit` varchar(10) NOT NULL,
  `export_master_unit` varchar(10) NOT NULL,
  `see_chasis` varchar(10) NOT NULL,
  `add_chasis` varchar(10) NOT NULL,
  `delete_chasis` varchar(10) NOT NULL,
  `edit_chasis` varchar(10) NOT NULL,
  `import_chasis` varchar(10) NOT NULL,
  `export_chasis` varchar(10) NOT NULL,
  `see_tire` varchar(10) NOT NULL,
  `add_tire` varchar(10) NOT NULL,
  `delete_tire` varchar(10) NOT NULL,
  `edit_tire` varchar(10) NOT NULL,
  `import_tire` varchar(10) NOT NULL,
  `export_tire` varchar(10) NOT NULL,
  `see_truck_absent` varchar(10) NOT NULL,
  `add_truck_absent` varchar(10) NOT NULL,
  `delete_truck_absent` varchar(10) NOT NULL,
  `edit_truck_absent` varchar(10) NOT NULL,
  `import_truck_absent` varchar(10) NOT NULL,
  `export_truck_absent` varchar(10) NOT NULL,
  `see_truck_accident` varchar(10) NOT NULL,
  `add_truck_accident` varchar(10) NOT NULL,
  `edit_truck_accident` text NOT NULL,
  `delete_truck_accident` varchar(10) NOT NULL,
  `import_truck_accident` varchar(10) NOT NULL,
  `export_truck_accident` varchar(10) NOT NULL,
  `see_service_vendor` varchar(10) NOT NULL,
  `add_service_vendor` varchar(10) NOT NULL,
  `delete_service_vendor` text NOT NULL,
  `edit_service_vendor` varchar(10) NOT NULL,
  `import_service_vendor` varchar(10) NOT NULL,
  `export_service_vendor` varchar(10) NOT NULL,
  `see_area` varchar(10) NOT NULL,
  `add_area` varchar(10) NOT NULL,
  `delete_area` varchar(10) NOT NULL,
  `edit_area` varchar(10) NOT NULL,
  `import_area` varchar(10) NOT NULL,
  `export_area` varchar(10) NOT NULL,
  `see_customer` varchar(10) NOT NULL,
  `add_customer` varchar(10) NOT NULL,
  `delete_customer` varchar(10) NOT NULL,
  `edit_customer` varchar(10) NOT NULL,
  `import_customer` varchar(10) NOT NULL,
  `export_customer` varchar(10) NOT NULL,
  `see_transporter` varchar(10) NOT NULL,
  `add_transporter` varchar(10) NOT NULL,
  `delete_transporter` varchar(10) NOT NULL,
  `edit_transporter` varchar(10) NOT NULL,
  `import_transporter` varchar(10) NOT NULL,
  `export_transporter` varchar(10) NOT NULL,
  `see_client` varchar(10) NOT NULL,
  `add_client` varchar(10) NOT NULL,
  `delete_client` varchar(10) NOT NULL,
  `edit_client` varchar(10) NOT NULL,
  `import_client` varchar(10) NOT NULL,
  `export_client` varchar(10) NOT NULL,
  `see_direct_cost` varchar(10) NOT NULL,
  `add_direct_cost` varchar(10) NOT NULL,
  `delete_direct_cost` varchar(10) NOT NULL,
  `edit_direct_cost` varchar(10) NOT NULL,
  `import_direct_cost` varchar(10) NOT NULL,
  `export_direct_cost` varchar(10) NOT NULL,
  `see_transporter_rate` varchar(10) NOT NULL,
  `add_transporter_rate` varchar(10) NOT NULL,
  `edit_transporter_rate` varchar(10) NOT NULL,
  `delete_transporter_rate` varchar(10) NOT NULL,
  `export_transporter_rate` varchar(10) NOT NULL,
  `import_transporter_rate` varchar(10) NOT NULL,
  `see_room_service_management` varchar(10) NOT NULL,
  `add_room_service_management` varchar(10) NOT NULL,
  `edit_room_service_management` varchar(10) NOT NULL,
  `delete_room_service_management` varchar(10) NOT NULL,
  `import_room_service_management` varchar(10) NOT NULL,
  `export_room_service_management` varchar(10) NOT NULL,
  `see_trucking_order` varchar(10) NOT NULL,
  `add_trucking_order` varchar(10) NOT NULL,
  `delete_trucking_order` varchar(10) NOT NULL,
  `edit_trucking_order` varchar(10) NOT NULL,
  `import_trucking_order` varchar(10) NOT NULL,
  `export_trucking_order` varchar(10) NOT NULL,
  `see_transport_order` varchar(10) NOT NULL,
  `add_transport_order` varchar(10) NOT NULL,
  `delete_transport_order` varchar(10) NOT NULL,
  `edit_transport_order` varchar(10) NOT NULL,
  `import_transport_order` varchar(10) NOT NULL,
  `export_transport_order` varchar(10) NOT NULL,
  `see_division` varchar(50) NOT NULL,
  `add_division` varchar(50) NOT NULL,
  `delete_division` varchar(50) NOT NULL,
  `edit_division` varchar(50) NOT NULL,
  `import_division` varchar(50) NOT NULL,
  `export_division` varchar(50) NOT NULL,
  `see_pr` varchar(10) NOT NULL,
  `add_pr` varchar(10) NOT NULL,
  `delete_pr` varchar(10) NOT NULL,
  `edit_pr` varchar(10) NOT NULL,
  `import_pr` varchar(10) NOT NULL,
  `export_pr` varchar(10) NOT NULL,
  `see_master_bank` varchar(10) NOT NULL,
  `add_master_bank` varchar(10) NOT NULL,
  `delete_master_bank` varchar(10) NOT NULL,
  `edit_master_bank` varchar(10) NOT NULL,
  `import_master_bank` varchar(10) NOT NULL,
  `export_master_bank` varchar(10) NOT NULL,
  `see_traffic_monitoring` varchar(10) NOT NULL,
  `add_traffic_monitoring` varchar(10) NOT NULL,
  `delete_traffic_monitoring` varchar(10) NOT NULL,
  `edit_traffic_monitoring` varchar(10) NOT NULL,
  `import_traffic_monitoring` varchar(10) NOT NULL,
  `export_traffic_monitoring` varchar(10) NOT NULL,
  `see_route_planning` varchar(10) NOT NULL,
  `add_route_planning` varchar(10) NOT NULL,
  `delete_route_planning` varchar(10) NOT NULL,
  `edit_route_planning` varchar(10) NOT NULL,
  `import_route_planning` varchar(10) NOT NULL,
  `export_route_planning` varchar(10) NOT NULL,
  `see_master_cash` varchar(10) NOT NULL,
  `add_master_cash` varchar(100) NOT NULL,
  `delete_master_cash` text NOT NULL,
  `edit_master_cash` varchar(10) NOT NULL,
  `import_master_cash` varchar(10) NOT NULL,
  `export_master_cash` varchar(10) NOT NULL,
  `see_inventory_list` varchar(10) NOT NULL,
  `add_inventory_list` varchar(10) NOT NULL,
  `edit_inventory_list` varchar(10) NOT NULL,
  `delete_inventory_list` varchar(10) NOT NULL,
  `import_inventory_list` varchar(10) NOT NULL,
  `export_inventory_list` varchar(10) NOT NULL,
  `see_io` varchar(10) NOT NULL,
  `add_io` varchar(10) NOT NULL,
  `delete_io` varchar(10) NOT NULL,
  `edit_io` varchar(10) NOT NULL,
  `import_io` varchar(10) NOT NULL,
  `export_io` varchar(10) NOT NULL,
  `see_purchase_invoice` varchar(10) NOT NULL,
  `add_purchase_invoice` varchar(10) NOT NULL,
  `edit_purchase_invoice` varchar(100) NOT NULL,
  `delete_purchase_invoice` varchar(10) NOT NULL,
  `export_purchase_invoice` varchar(10) NOT NULL,
  `import_purchase_invoice` varchar(10) NOT NULL,
  `see_pod` varchar(10) NOT NULL,
  `add_pod` varchar(10) NOT NULL,
  `edit_pod` varchar(10) NOT NULL,
  `delete_pod` varchar(10) NOT NULL,
  `export_pod` varchar(10) NOT NULL,
  `import_pod` varchar(10) NOT NULL,
  `see_client_rate` varchar(10) NOT NULL,
  `add_client_rate` varchar(10) NOT NULL,
  `edit_client_rate` varchar(10) NOT NULL,
  `delete_client_rate` varchar(10) NOT NULL,
  `import_client_rate` text NOT NULL,
  `export_client_rate` varchar(10) NOT NULL,
  `see_master_category` varchar(50) NOT NULL,
  `add_master_category` varchar(50) NOT NULL,
  `edit_master_category` varchar(50) NOT NULL,
  `delete_master_category` varchar(50) NOT NULL,
  `export_master_category` varchar(50) NOT NULL,
  `import_master_category` varchar(50) NOT NULL,
  `see_room_service` varchar(50) NOT NULL,
  `add_room_service` varchar(50) NOT NULL,
  `edit_room_service` varchar(50) NOT NULL,
  `delete_room_service` varchar(50) NOT NULL,
  `import_room_service` varchar(50) NOT NULL,
  `export_room_service` varchar(50) NOT NULL,
  `see_invoice` varchar(50) NOT NULL,
  `add_invoice` varchar(50) NOT NULL,
  `delete_invoice` varchar(50) NOT NULL,
  `edit_invoice` varchar(50) NOT NULL,
  `import_invoice` varchar(50) NOT NULL,
  `export_invoice` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id_role`, `see_distributor`, `role`, `see_driver`, `add_driver`, `delete_driver`, `edit_driver`, `import_driver`, `export_driver`, `add_warehouse`, `edit_warehouse`, `delete_warehouse`, `export_warehouse`, `import_warehouse`, `see_warehouse`, `see_supplier`, `add_supplier`, `edit_supplier`, `delete_supplier`, `export_supplier`, `import_supplier`, `see_product`, `add_product`, `delete_product`, `edit_product`, `export_product`, `import_product`, `see_location`, `add_location`, `delete_location`, `edit_location`, `import_location`, `export_location`, `see_location_type`, `add_location_type`, `delete_location_type`, `edit_location_type`, `import_location_type`, `export_location_type`, `see_po`, `add_po`, `delete_po`, `edit_po`, `import_po`, `export_po`, `see_gr`, `add_gr`, `delete_gr`, `edit_gr`, `import_gr`, `export_gr`, `see_vehicle_type`, `add_vehicle_type`, `delete_vehicle_type`, `edit_vehicle_type`, `import_vehicle_type`, `export_vehicle_type`, `see_master_unit`, `add_master_unit`, `delete_master_unit`, `edit_master_unit`, `import_master_unit`, `export_master_unit`, `see_chasis`, `add_chasis`, `delete_chasis`, `edit_chasis`, `import_chasis`, `export_chasis`, `see_tire`, `add_tire`, `delete_tire`, `edit_tire`, `import_tire`, `export_tire`, `see_truck_absent`, `add_truck_absent`, `delete_truck_absent`, `edit_truck_absent`, `import_truck_absent`, `export_truck_absent`, `see_truck_accident`, `add_truck_accident`, `edit_truck_accident`, `delete_truck_accident`, `import_truck_accident`, `export_truck_accident`, `see_service_vendor`, `add_service_vendor`, `delete_service_vendor`, `edit_service_vendor`, `import_service_vendor`, `export_service_vendor`, `see_area`, `add_area`, `delete_area`, `edit_area`, `import_area`, `export_area`, `see_customer`, `add_customer`, `delete_customer`, `edit_customer`, `import_customer`, `export_customer`, `see_transporter`, `add_transporter`, `delete_transporter`, `edit_transporter`, `import_transporter`, `export_transporter`, `see_client`, `add_client`, `delete_client`, `edit_client`, `import_client`, `export_client`, `see_direct_cost`, `add_direct_cost`, `delete_direct_cost`, `edit_direct_cost`, `import_direct_cost`, `export_direct_cost`, `see_transporter_rate`, `add_transporter_rate`, `edit_transporter_rate`, `delete_transporter_rate`, `export_transporter_rate`, `import_transporter_rate`, `see_room_service_management`, `add_room_service_management`, `edit_room_service_management`, `delete_room_service_management`, `import_room_service_management`, `export_room_service_management`, `see_trucking_order`, `add_trucking_order`, `delete_trucking_order`, `edit_trucking_order`, `import_trucking_order`, `export_trucking_order`, `see_transport_order`, `add_transport_order`, `delete_transport_order`, `edit_transport_order`, `import_transport_order`, `export_transport_order`, `see_division`, `add_division`, `delete_division`, `edit_division`, `import_division`, `export_division`, `see_pr`, `add_pr`, `delete_pr`, `edit_pr`, `import_pr`, `export_pr`, `see_master_bank`, `add_master_bank`, `delete_master_bank`, `edit_master_bank`, `import_master_bank`, `export_master_bank`, `see_traffic_monitoring`, `add_traffic_monitoring`, `delete_traffic_monitoring`, `edit_traffic_monitoring`, `import_traffic_monitoring`, `export_traffic_monitoring`, `see_route_planning`, `add_route_planning`, `delete_route_planning`, `edit_route_planning`, `import_route_planning`, `export_route_planning`, `see_master_cash`, `add_master_cash`, `delete_master_cash`, `edit_master_cash`, `import_master_cash`, `export_master_cash`, `see_inventory_list`, `add_inventory_list`, `edit_inventory_list`, `delete_inventory_list`, `import_inventory_list`, `export_inventory_list`, `see_io`, `add_io`, `delete_io`, `edit_io`, `import_io`, `export_io`, `see_purchase_invoice`, `add_purchase_invoice`, `edit_purchase_invoice`, `delete_purchase_invoice`, `export_purchase_invoice`, `import_purchase_invoice`, `see_pod`, `add_pod`, `edit_pod`, `delete_pod`, `export_pod`, `import_pod`, `see_client_rate`, `add_client_rate`, `edit_client_rate`, `delete_client_rate`, `import_client_rate`, `export_client_rate`, `see_master_category`, `add_master_category`, `edit_master_category`, `delete_master_category`, `export_master_category`, `import_master_category`, `see_room_service`, `add_room_service`, `edit_room_service`, `delete_room_service`, `import_room_service`, `export_room_service`, `see_invoice`, `add_invoice`, `delete_invoice`, `edit_invoice`, `import_invoice`, `export_invoice`) VALUES
(12, 'yes', 'ADMINISTRATOR - SPECIAL', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes');

-- --------------------------------------------------------

--
-- Struktur dari tabel `vehicle_type`
--

CREATE TABLE `vehicle_type` (
  `id_vehicle_type` int(11) NOT NULL,
  `vehicle_type` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `volume_cap` varchar(255) NOT NULL,
  `weight_cap` varchar(255) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `vehicle_type`
--

INSERT INTO `vehicle_type` (`id_vehicle_type`, `vehicle_type`, `description`, `volume_cap`, `weight_cap`, `timestamp`) VALUES
(5, 'CDE BOX', 'CDE BOX', '6', '2500', '2018-02-08 06:13:00'),
(6, 'CDD BOX', 'CDD BOX', '15', '4500', '2018-02-08 06:13:21'),
(7, 'FUSO BOX', 'FUSO BOX', '28', '8000', '2018-02-08 06:13:56'),
(8, 'TRONTON BOX', 'TRONTON BOX', '32', '10000', '2018-02-08 06:14:36'),
(9, 'WINGBOX', 'WINGBOX', '40', '15000', '2018-02-08 06:14:58'),
(10, 'TRAILER 20', 'TRAILER 20', '28', '20000', '2018-02-08 06:15:24'),
(11, 'TRAILER 40', 'TRAILER 40', '67', '40000', '2018-02-08 06:16:05');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warehouse`
--

CREATE TABLE `warehouse` (
  `id_warehouse` int(11) NOT NULL,
  `warehouse_code` varchar(255) NOT NULL,
  `warehouse_name` varchar(255) NOT NULL,
  `address_1` varchar(500) NOT NULL,
  `address_2` varchar(500) NOT NULL,
  `warehouse_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `warehouse`
--

INSERT INTO `warehouse` (`id_warehouse`, `warehouse_code`, `warehouse_name`, `address_1`, `address_2`, `warehouse_type`) VALUES
(3, 'WRS011', 'Warehouse 1', 'Summarecon Block UB 50', 'Summarecon Block UC 22', 'type_1');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Indeks untuk tabel `client_rate`
--
ALTER TABLE `client_rate`
  ADD PRIMARY KEY (`id_client_rate`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD UNIQUE KEY `id_customer` (`id_customer`);

--
-- Indeks untuk tabel `detail_master_invoice`
--
ALTER TABLE `detail_master_invoice`
  ADD PRIMARY KEY (`id_detail_invoice`);

--
-- Indeks untuk tabel `detail_service`
--
ALTER TABLE `detail_service`
  ADD PRIMARY KEY (`id_detail_service`);

--
-- Indeks untuk tabel `detail_trucking_order`
--
ALTER TABLE `detail_trucking_order`
  ADD PRIMARY KEY (`id_detail_trucking_order`);

--
-- Indeks untuk tabel `direct_cost`
--
ALTER TABLE `direct_cost`
  ADD PRIMARY KEY (`id_direct_cost`);

--
-- Indeks untuk tabel `distributor`
--
ALTER TABLE `distributor`
  ADD PRIMARY KEY (`id_distributor`),
  ADD KEY `distributor_code` (`distributor_code`);

--
-- Indeks untuk tabel `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id_division`);

--
-- Indeks untuk tabel `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id_driver`);

--
-- Indeks untuk tabel `driver_absence`
--
ALTER TABLE `driver_absence`
  ADD PRIMARY KEY (`id_absence`);

--
-- Indeks untuk tabel `email_receiver`
--
ALTER TABLE `email_receiver`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `gpslocations`
--
ALTER TABLE `gpslocations`
  ADD PRIMARY KEY (`GPSLocationID`),
  ADD KEY `sessionIDIndex` (`sessionID`),
  ADD KEY `phoneNumberIndex` (`phoneNumber`),
  ADD KEY `userNameIndex` (`userName`);

--
-- Indeks untuk tabel `gr`
--
ALTER TABLE `gr`
  ADD PRIMARY KEY (`id_gr`);

--
-- Indeks untuk tabel `inventory_list`
--
ALTER TABLE `inventory_list`
  ADD PRIMARY KEY (`id_inventory_list`);

--
-- Indeks untuk tabel `json`
--
ALTER TABLE `json`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_location`);

--
-- Indeks untuk tabel `location_type`
--
ALTER TABLE `location_type`
  ADD PRIMARY KEY (`id_location_type`);

--
-- Indeks untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `log_report`
--
ALTER TABLE `log_report`
  ADD PRIMARY KEY (`id_send_report`);

--
-- Indeks untuk tabel `manifest_additional_cost`
--
ALTER TABLE `manifest_additional_cost`
  ADD PRIMARY KEY (`id_manifest_additional_cost`),
  ADD KEY `id_manifest_additional_cost` (`id_manifest_additional_cost`);

--
-- Indeks untuk tabel `master_area`
--
ALTER TABLE `master_area`
  ADD PRIMARY KEY (`id_area`);

--
-- Indeks untuk tabel `master_bank_account`
--
ALTER TABLE `master_bank_account`
  ADD PRIMARY KEY (`id_master_bank_account`);

--
-- Indeks untuk tabel `master_cash_account`
--
ALTER TABLE `master_cash_account`
  ADD PRIMARY KEY (`id_cash_account`);

--
-- Indeks untuk tabel `master_chasis`
--
ALTER TABLE `master_chasis`
  ADD PRIMARY KEY (`id_chasis`);

--
-- Indeks untuk tabel `master_client`
--
ALTER TABLE `master_client`
  ADD PRIMARY KEY (`id_client`);

--
-- Indeks untuk tabel `master_data_category`
--
ALTER TABLE `master_data_category`
  ADD PRIMARY KEY (`id_master_data_category`);

--
-- Indeks untuk tabel `master_invoice`
--
ALTER TABLE `master_invoice`
  ADD PRIMARY KEY (`id_invoice`);

--
-- Indeks untuk tabel `master_io`
--
ALTER TABLE `master_io`
  ADD PRIMARY KEY (`id_io`);

--
-- Indeks untuk tabel `master_manifest`
--
ALTER TABLE `master_manifest`
  ADD PRIMARY KEY (`id_manifest`);

--
-- Indeks untuk tabel `master_po`
--
ALTER TABLE `master_po`
  ADD PRIMARY KEY (`id_po`);

--
-- Indeks untuk tabel `master_pr`
--
ALTER TABLE `master_pr`
  ADD PRIMARY KEY (`id_pr`);

--
-- Indeks untuk tabel `master_province`
--
ALTER TABLE `master_province`
  ADD PRIMARY KEY (`id_province`);

--
-- Indeks untuk tabel `master_remark`
--
ALTER TABLE `master_remark`
  ADD PRIMARY KEY (`id_remark`);

--
-- Indeks untuk tabel `master_tire`
--
ALTER TABLE `master_tire`
  ADD PRIMARY KEY (`id_tire`);

--
-- Indeks untuk tabel `master_trucking_order`
--
ALTER TABLE `master_trucking_order`
  ADD PRIMARY KEY (`id_trucking_order`);

--
-- Indeks untuk tabel `master_unit`
--
ALTER TABLE `master_unit`
  ADD PRIMARY KEY (`id_master_unit`);

--
-- Indeks untuk tabel `master_vendor`
--
ALTER TABLE `master_vendor`
  ADD PRIMARY KEY (`id_vendor`);

--
-- Indeks untuk tabel `order_type`
--
ALTER TABLE `order_type`
  ADD PRIMARY KEY (`id_order_type`);

--
-- Indeks untuk tabel `pod`
--
ALTER TABLE `pod`
  ADD PRIMARY KEY (`id_pod`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`);

--
-- Indeks untuk tabel `product_orders_gr`
--
ALTER TABLE `product_orders_gr`
  ADD PRIMARY KEY (`id_product_orders_gr`);

--
-- Indeks untuk tabel `product_orders_invoice`
--
ALTER TABLE `product_orders_invoice`
  ADD PRIMARY KEY (`id_product_orders_invoice`);

--
-- Indeks untuk tabel `product_orders_io`
--
ALTER TABLE `product_orders_io`
  ADD PRIMARY KEY (`id_product_orders_io`);

--
-- Indeks untuk tabel `product_orders_po`
--
ALTER TABLE `product_orders_po`
  ADD PRIMARY KEY (`id_product_orders_po`);

--
-- Indeks untuk tabel `product_orders_pr`
--
ALTER TABLE `product_orders_pr`
  ADD PRIMARY KEY (`id_product_orders_pr`);

--
-- Indeks untuk tabel `purchase_additional_cost_tms`
--
ALTER TABLE `purchase_additional_cost_tms`
  ADD PRIMARY KEY (`id_purchase_additional`);

--
-- Indeks untuk tabel `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  ADD PRIMARY KEY (`id_purchase_invoice`);

--
-- Indeks untuk tabel `purchase_tms`
--
ALTER TABLE `purchase_tms`
  ADD PRIMARY KEY (`id_purchase_tms`);

--
-- Indeks untuk tabel `room_service`
--
ALTER TABLE `room_service`
  ADD PRIMARY KEY (`id_room_service`);

--
-- Indeks untuk tabel `room_service_management`
--
ALTER TABLE `room_service_management`
  ADD PRIMARY KEY (`id_room_service_management`);

--
-- Indeks untuk tabel `service_vendor`
--
ALTER TABLE `service_vendor`
  ADD PRIMARY KEY (`id_service_vendor`);

--
-- Indeks untuk tabel `shift`
--
ALTER TABLE `shift`
  ADD PRIMARY KEY (`id_shift`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `test_integer`
--
ALTER TABLE `test_integer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `traffic_monitoring_export`
--
ALTER TABLE `traffic_monitoring_export`
  ADD PRIMARY KEY (`id_traffic_monitoring_export`);

--
-- Indeks untuk tabel `traffic_monitoring_import`
--
ALTER TABLE `traffic_monitoring_import`
  ADD PRIMARY KEY (`id_traffic_monitoring_import`);

--
-- Indeks untuk tabel `traffic_monitoring_langsir`
--
ALTER TABLE `traffic_monitoring_langsir`
  ADD PRIMARY KEY (`id_traffic_monitoring_langsir`);

--
-- Indeks untuk tabel `traffic_monitoring_langsir_empty`
--
ALTER TABLE `traffic_monitoring_langsir_empty`
  ADD PRIMARY KEY (`id_traffic_monitoring_langsir_empty_cont`);

--
-- Indeks untuk tabel `traffic_monitoring_regular`
--
ALTER TABLE `traffic_monitoring_regular`
  ADD PRIMARY KEY (`id_traffic_monitoring_regular`);

--
-- Indeks untuk tabel `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id_transaction`);

--
-- Indeks untuk tabel `transporter`
--
ALTER TABLE `transporter`
  ADD PRIMARY KEY (`id_transporter`);

--
-- Indeks untuk tabel `transporter_rate`
--
ALTER TABLE `transporter_rate`
  ADD PRIMARY KEY (`id_transporter_rate`);

--
-- Indeks untuk tabel `transport_order`
--
ALTER TABLE `transport_order`
  ADD PRIMARY KEY (`spk_number`);

--
-- Indeks untuk tabel `truck_absent`
--
ALTER TABLE `truck_absent`
  ADD PRIMARY KEY (`id_truck_absent`);

--
-- Indeks untuk tabel `truck_accident`
--
ALTER TABLE `truck_accident`
  ADD PRIMARY KEY (`id_truck_accident`);

--
-- Indeks untuk tabel `update_apps`
--
ALTER TABLE `update_apps`
  ADD PRIMARY KEY (`id_update_apps`);

--
-- Indeks untuk tabel `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`);

--
-- Indeks untuk tabel `user_autologin`
--
ALTER TABLE `user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Indeks untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `vehicle_type`
--
ALTER TABLE `vehicle_type`
  ADD PRIMARY KEY (`id_vehicle_type`);

--
-- Indeks untuk tabel `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id_warehouse`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `client_rate`
--
ALTER TABLE `client_rate`
  MODIFY `id_client_rate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id_customer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `detail_master_invoice`
--
ALTER TABLE `detail_master_invoice`
  MODIFY `id_detail_invoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_service`
--
ALTER TABLE `detail_service`
  MODIFY `id_detail_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `detail_trucking_order`
--
ALTER TABLE `detail_trucking_order`
  MODIFY `id_detail_trucking_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `direct_cost`
--
ALTER TABLE `direct_cost`
  MODIFY `id_direct_cost` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `distributor`
--
ALTER TABLE `distributor`
  MODIFY `id_distributor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT untuk tabel `division`
--
ALTER TABLE `division`
  MODIFY `id_division` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `driver`
--
ALTER TABLE `driver`
  MODIFY `id_driver` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `driver_absence`
--
ALTER TABLE `driver_absence`
  MODIFY `id_absence` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `email_receiver`
--
ALTER TABLE `email_receiver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `gpslocations`
--
ALTER TABLE `gpslocations`
  MODIFY `GPSLocationID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `gr`
--
ALTER TABLE `gr`
  MODIFY `id_gr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `inventory_list`
--
ALTER TABLE `inventory_list`
  MODIFY `id_inventory_list` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `json`
--
ALTER TABLE `json`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `location`
--
ALTER TABLE `location`
  MODIFY `id_location` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `location_type`
--
ALTER TABLE `location_type`
  MODIFY `id_location_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `log_report`
--
ALTER TABLE `log_report`
  MODIFY `id_send_report` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `manifest_additional_cost`
--
ALTER TABLE `manifest_additional_cost`
  MODIFY `id_manifest_additional_cost` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_area`
--
ALTER TABLE `master_area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `master_bank_account`
--
ALTER TABLE `master_bank_account`
  MODIFY `id_master_bank_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `master_cash_account`
--
ALTER TABLE `master_cash_account`
  MODIFY `id_cash_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `master_chasis`
--
ALTER TABLE `master_chasis`
  MODIFY `id_chasis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `master_client`
--
ALTER TABLE `master_client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `master_data_category`
--
ALTER TABLE `master_data_category`
  MODIFY `id_master_data_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `master_invoice`
--
ALTER TABLE `master_invoice`
  MODIFY `id_invoice` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_io`
--
ALTER TABLE `master_io`
  MODIFY `id_io` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `master_manifest`
--
ALTER TABLE `master_manifest`
  MODIFY `id_manifest` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `master_po`
--
ALTER TABLE `master_po`
  MODIFY `id_po` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `master_pr`
--
ALTER TABLE `master_pr`
  MODIFY `id_pr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `master_province`
--
ALTER TABLE `master_province`
  MODIFY `id_province` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `master_remark`
--
ALTER TABLE `master_remark`
  MODIFY `id_remark` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `master_tire`
--
ALTER TABLE `master_tire`
  MODIFY `id_tire` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `master_trucking_order`
--
ALTER TABLE `master_trucking_order`
  MODIFY `id_trucking_order` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `master_unit`
--
ALTER TABLE `master_unit`
  MODIFY `id_master_unit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `master_vendor`
--
ALTER TABLE `master_vendor`
  MODIFY `id_vendor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `order_type`
--
ALTER TABLE `order_type`
  MODIFY `id_order_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pod`
--
ALTER TABLE `pod`
  MODIFY `id_pod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `product`
--
ALTER TABLE `product`
  MODIFY `id_product` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `product_orders_gr`
--
ALTER TABLE `product_orders_gr`
  MODIFY `id_product_orders_gr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `product_orders_invoice`
--
ALTER TABLE `product_orders_invoice`
  MODIFY `id_product_orders_invoice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `product_orders_io`
--
ALTER TABLE `product_orders_io`
  MODIFY `id_product_orders_io` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `product_orders_po`
--
ALTER TABLE `product_orders_po`
  MODIFY `id_product_orders_po` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `product_orders_pr`
--
ALTER TABLE `product_orders_pr`
  MODIFY `id_product_orders_pr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `purchase_additional_cost_tms`
--
ALTER TABLE `purchase_additional_cost_tms`
  MODIFY `id_purchase_additional` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `purchase_invoice`
--
ALTER TABLE `purchase_invoice`
  MODIFY `id_purchase_invoice` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `purchase_tms`
--
ALTER TABLE `purchase_tms`
  MODIFY `id_purchase_tms` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `room_service`
--
ALTER TABLE `room_service`
  MODIFY `id_room_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `room_service_management`
--
ALTER TABLE `room_service_management`
  MODIFY `id_room_service_management` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `service_vendor`
--
ALTER TABLE `service_vendor`
  MODIFY `id_service_vendor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `shift`
--
ALTER TABLE `shift`
  MODIFY `id_shift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `test_integer`
--
ALTER TABLE `test_integer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `traffic_monitoring_export`
--
ALTER TABLE `traffic_monitoring_export`
  MODIFY `id_traffic_monitoring_export` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `traffic_monitoring_import`
--
ALTER TABLE `traffic_monitoring_import`
  MODIFY `id_traffic_monitoring_import` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `traffic_monitoring_langsir`
--
ALTER TABLE `traffic_monitoring_langsir`
  MODIFY `id_traffic_monitoring_langsir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `traffic_monitoring_langsir_empty`
--
ALTER TABLE `traffic_monitoring_langsir_empty`
  MODIFY `id_traffic_monitoring_langsir_empty_cont` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `traffic_monitoring_regular`
--
ALTER TABLE `traffic_monitoring_regular`
  MODIFY `id_traffic_monitoring_regular` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id_transaction` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `transporter`
--
ALTER TABLE `transporter`
  MODIFY `id_transporter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `transporter_rate`
--
ALTER TABLE `transporter_rate`
  MODIFY `id_transporter_rate` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `transport_order`
--
ALTER TABLE `transport_order`
  MODIFY `spk_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `truck_absent`
--
ALTER TABLE `truck_absent`
  MODIFY `id_truck_absent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `truck_accident`
--
ALTER TABLE `truck_accident`
  MODIFY `id_truck_accident` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `update_apps`
--
ALTER TABLE `update_apps`
  MODIFY `id_update_apps` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT untuk tabel `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=952;

--
-- AUTO_INCREMENT untuk tabel `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `vehicle_type`
--
ALTER TABLE `vehicle_type`
  MODIFY `id_vehicle_type` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `warehouse`
--
ALTER TABLE `warehouse`
  MODIFY `id_warehouse` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
