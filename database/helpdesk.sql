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

-- Dumping structure for table helpdesk.complaint_images
DROP TABLE IF EXISTS `complaint_images`;
CREATE TABLE IF NOT EXISTS `complaint_images` (
  `images_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_code` char(10) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`images_id`),
  KEY `FK_complaint_images_complaint_tickets` (`ticket_code`),
  CONSTRAINT `FK_complaint_images_complaint_tickets` FOREIGN KEY (`ticket_code`) REFERENCES `complaint_tickets` (`ticket_code`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.complaint_images: ~0 rows (approximately)
DELETE FROM `complaint_images`;
/*!40000 ALTER TABLE `complaint_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `complaint_images` ENABLE KEYS */;

-- Dumping structure for table helpdesk.complaint_tickets
DROP TABLE IF EXISTS `complaint_tickets`;
CREATE TABLE IF NOT EXISTS `complaint_tickets` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_code` char(10) NOT NULL,
  `nip` char(18) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_position` varchar(255) NOT NULL,
  `employee_unit` varchar(255) NOT NULL,
  `ticket_title` varchar(255) NOT NULL,
  `ticket_desc` text NOT NULL,
  `ticket_date` datetime NOT NULL,
  `ticket_status` int(11) NOT NULL DEFAULT '0',
  `ticket_posting` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`ticket_id`),
  UNIQUE KEY `tiket_code` (`ticket_code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.complaint_tickets: ~1 rows (approximately)
DELETE FROM `complaint_tickets`;
/*!40000 ALTER TABLE `complaint_tickets` DISABLE KEYS */;
INSERT INTO `complaint_tickets` (`ticket_id`, `ticket_code`, `nip`, `employee_name`, `employee_position`, `employee_unit`, `ticket_title`, `ticket_desc`, `ticket_date`, `ticket_status`, `ticket_posting`, `created_at`, `updated_at`) VALUES
	(2, 'NZWTGEXJUU', '198505152008031001', 'FAREZI INDRA KASHOUGI S.Kom', 'Kepala Sub Bagian Perencanaan Dan Pelaporan', 'Badan Perencanaan Pembangunan Daerah', 'Ini Judul', 'test', '2022-01-30 20:15:12', 0, 0, '2022-01-30 20:15:12', '2022-01-30 20:15:12'),
	(3, 'PB7YGR0YZQ', '198505152008031001', 'FAREZI INDRA KASHOUGI S.Kom', 'Kepala Sub Bagian Perencanaan Dan Pelaporan', 'Badan Perencanaan Pembangunan Daerah', 'aa', 'ting', '2022-01-30 20:15:34', 0, 0, '2022-01-30 20:15:34', '2022-01-30 20:15:34');
/*!40000 ALTER TABLE `complaint_tickets` ENABLE KEYS */;

-- Dumping structure for table helpdesk.feedback_ticket
DROP TABLE IF EXISTS `feedback_ticket`;
CREATE TABLE IF NOT EXISTS `feedback_ticket` (
  `feedback_id` int(11) NOT NULL AUTO_INCREMENT,
  `complaint_id` int(11) NOT NULL,
  `feedback_desc` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`feedback_id`),
  KEY `complaint_id` (`complaint_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.feedback_ticket: ~0 rows (approximately)
DELETE FROM `feedback_ticket`;
/*!40000 ALTER TABLE `feedback_ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `feedback_ticket` ENABLE KEYS */;

-- Dumping structure for table helpdesk.migrations
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk.migrations: ~2 rows (approximately)
DELETE FROM `migrations`;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2019_12_14_000001_create_personal_access_tokens_table', 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table helpdesk.personal_access_tokens
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table helpdesk.personal_access_tokens: ~0 rows (approximately)
DELETE FROM `personal_access_tokens`;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

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

-- Dumping data for table helpdesk.users: ~0 rows (approximately)
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
  `unit_kerja_kode` char(10) NOT NULL,
  PRIMARY KEY (`user_id`,`unit_kerja_kode`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table helpdesk.user_maps: ~0 rows (approximately)
DELETE FROM `user_maps`;
/*!40000 ALTER TABLE `user_maps` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_maps` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
