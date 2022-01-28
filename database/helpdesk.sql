-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.3.0.6295
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table helpdesk.complaint_tikets
DROP TABLE IF EXISTS `complaint_tikets`;
CREATE TABLE IF NOT EXISTS `complaint_tikets` (
  `ticket_id` int(11) NOT NULL,
  `ticket_code` char(20) NOT NULL,
  `nip` char(18) NOT NULL,
  `ticket_desc` text NOT NULL,
  `ticket_date` datetime NOT NULL,
  `file_name` varchar(100) DEFAULT '',
  `file_path` varchar(100) DEFAULT '',
  `feedback_desc` text,
  `feedback_status` bit(1) NOT NULL DEFAULT b'0',
  `feedback_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ticket_id`),
  UNIQUE KEY `tiket_code` (`ticket_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.complaint_tikets: ~0 rows (approximately)
DELETE FROM `complaint_tikets`;
/*!40000 ALTER TABLE `complaint_tikets` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaint_tikets` ENABLE KEYS */;

-- Dumping structure for table helpdesk.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `level_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk.users: ~1 rows (approximately)
DELETE FROM `users`;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `level_id`, `username`, `name`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 1, 'admin', 'Yusda', '$2y$10$ngFZzmAcphj2x3yp58dDXeQI1svdR/MLMVgXaszqJmflldsUtDNKe', NULL, '2022-01-25 14:20:43', NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Dumping structure for table helpdesk.user_levels
DROP TABLE IF EXISTS `user_levels`;
CREATE TABLE IF NOT EXISTS `user_levels` (
  `level_id` int(11) NOT NULL,
  `level_name` varchar(255) NOT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.user_levels: ~2 rows (approximately)
DELETE FROM `user_levels`;
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT INTO `user_levels` (`level_id`, `level_name`) VALUES
	(1, 'Administrator'),
	(2, 'Helpdesk User');
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;

-- Dumping structure for table helpdesk.user_maps
DROP TABLE IF EXISTS `user_maps`;
CREATE TABLE IF NOT EXISTS `user_maps` (
  `user_id` int(11) NOT NULL,
  `unit` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`unit`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.user_maps: ~0 rows (approximately)
DELETE FROM `user_maps`;
/*!40000 ALTER TABLE `user_maps` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_maps` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
