/*!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.11.8-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: db    Database: db
-- ------------------------------------------------------
-- Server version	10.11.8-MariaDB-ubu2204-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bets`
--

DROP TABLE IF EXISTS `bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weekly_pick_id` bigint(20) unsigned NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `bets` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`bets`)),
  `odds` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bet_amount` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bets_weekly_pick_id_foreign` (`weekly_pick_id`),
  CONSTRAINT `bets_weekly_pick_id_foreign` FOREIGN KEY (`weekly_pick_id`) REFERENCES `weekly_picks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bets`
--

LOCK TABLES `bets` WRITE;
/*!40000 ALTER TABLE `bets` DISABLE KEYS */;
INSERT INTO `bets` VALUES
(6,12,25,'[\"tak\",null,null,\"tak\",null,null,\"tak\",null]','[\"1.75\",null,null,\"1.15\",null,null,\"1.25\",null]','2024-09-11 13:16:25','2024-09-12 08:48:28',10),
(7,13,99,'[null,null,\"tak\",null,null,\"tak\",null,null]','[null,null,\"3\",null,null,\"3.3\",null,null]','2024-09-11 15:16:48','2024-09-11 15:17:33',10),
(8,14,18,'[\"tak\",\"tak\",null,null,null,null,\"tak\",null]','[\"1.77\",\"1.9\",null,null,null,null,\"1.1\",null]','2024-09-12 08:43:55','2024-09-12 09:14:16',5),
(9,15,124,'[\"tak\",null,null,null,\"tak\",\"tak\",null,null]','[\"1.77\",null,null,null,\"4.25\",\"3.3\",null,null]','2024-09-12 09:12:37','2024-09-12 09:14:16',5);
/*!40000 ALTER TABLE `bets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES
('77de68daecd823babbb58edb1c8e14d7106e83bb','i:2;',1725438278),
('77de68daecd823babbb58edb1c8e14d7106e83bb:timer','i:1725438278;',1725438278),
('da4b9237bacccdf19c0760cab7aec4a8359010b0','i:2;',1725433667),
('da4b9237bacccdf19c0760cab7aec4a8359010b0:timer','i:1725433667;',1725433667),
('plebcio@gmail.com|172.18.0.6','i:1;',1726123257),
('plebcio@gmail.com|172.18.0.6:timer','i:1726123257;',1726123257),
('poppa@wp.pl|172.18.0.6','i:1;',1725517569),
('poppa@wp.pl|172.18.0.6:timer','i:1725517569;',1725517569);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `head2_heads`
--

DROP TABLE IF EXISTS `head2_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `head2_heads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `points` int(11) NOT NULL DEFAULT 0,
  `picks` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`picks`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `weekly_pick_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `head2heads_weekly_pick_id_foreign` (`weekly_pick_id`),
  CONSTRAINT `head2heads_weekly_pick_id_foreign` FOREIGN KEY (`weekly_pick_id`) REFERENCES `weekly_picks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `head2_heads`
--

LOCK TABLES `head2_heads` WRITE;
/*!40000 ALTER TABLE `head2_heads` DISABLE KEYS */;
INSERT INTO `head2_heads` VALUES
(7,20,'[\"home\",\"home\",\"home\",\"away\",\"away\"]','2024-09-11 13:16:25','2024-09-12 08:48:28',12),
(8,20,'[\"home\",\"home\",\"away\",\"away\",\"away\"]','2024-09-11 15:16:48','2024-09-12 09:14:16',13),
(9,20,'[\"home\",\"away\",\"away\",\"home\",\"away\"]','2024-09-12 08:43:55','2024-09-12 09:14:16',14),
(10,15,'[\"home\",\"home\",\"home\",\"away\",\"away\"]','2024-09-12 09:12:37','2024-09-12 09:14:16',15);
/*!40000 ALTER TABLE `head2_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2024_09_04_074640_add_pp_path',2),
(5,'2024_09_04_074931_add_default_pp_path',3),
(6,'2024_09_04_075510_add_default_pp_path',4),
(7,'2024_09_04_081939_add_role_to_users_table',5),
(8,'2024_09_04_113011_create_weekly_picks_table',6),
(9,'2024_09_04_113155_create_results_table',7),
(10,'2024_09_04_114130_create_scores_table',8),
(11,'2024_09_04_114911_create_head2heads_table',9),
(12,'2024_09_04_115040_edit_scores_table',10),
(13,'2024_09_04_115231_create_bets_table',11),
(14,'2024_09_04_115730_edit_head2heads_table',12),
(15,'2024_09_05_094028_add_bet_points_to_bets_table',13),
(16,'2024_09_05_095552_create_weekly_pick_template_table',14),
(17,'2024_09_05_100116_create_weekly_bets_table',15),
(18,'2024_09_05_101628_add_bet_type',16),
(19,'2024_09_05_101714_add_bet_type',17),
(20,'2024_09_06_084538_create_weekly_pick_outcomes_table',18),
(22,'2024_09_12_094914_create_showcase_table',19);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `results`
--

DROP TABLE IF EXISTS `results`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `results` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weekly_pick_id` bigint(20) unsigned NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `prediction_home` int(11) NOT NULL,
  `prediction_away` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `results_weekly_pick_id_foreign` (`weekly_pick_id`),
  CONSTRAINT `results_weekly_pick_id_foreign` FOREIGN KEY (`weekly_pick_id`) REFERENCES `weekly_picks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `results`
--

LOCK TABLES `results` WRITE;
/*!40000 ALTER TABLE `results` DISABLE KEYS */;
INSERT INTO `results` VALUES
(9,12,46,45,45,'2024-09-11 13:16:25','2024-09-11 13:17:13'),
(10,13,30,45,45,'2024-09-11 15:16:48','2024-09-12 08:44:36'),
(11,14,30,45,45,'2024-09-12 08:43:55','2024-09-12 08:44:36'),
(12,15,50,40,50,'2024-09-12 09:12:37','2024-09-12 09:14:16');
/*!40000 ALTER TABLE `results` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scores`
--

DROP TABLE IF EXISTS `scores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scores` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weekly_pick_id` bigint(20) unsigned NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `home` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`home`)),
  `away` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`away`)),
  `selected_captain` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scores_weekly_pick_id_foreign` (`weekly_pick_id`),
  CONSTRAINT `scores_weekly_pick_id_foreign` FOREIGN KEY (`weekly_pick_id`) REFERENCES `weekly_picks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scores`
--

LOCK TABLES `scores` WRITE;
/*!40000 ALTER TABLE `scores` DISABLE KEYS */;
INSERT INTO `scores` VALUES
(8,12,79,'[\"11\",\"5\",\"10\",\"0\",\"9\",\"10\",\"0\",\"0\"]','[\"15\",\"15\",\"15\",\"0\",\"0\",\"0\",\"0\",\"0\"]',3,'2024-09-11 13:16:25','2024-09-11 13:17:13'),
(9,13,8,'[\"9\",\"9\",\"9\",\"9\",\"9\",\"0\",\"0\",\"0\"]','[\"15\",\"15\",\"15\",\"0\",\"0\",\"0\",\"0\",\"0\"]',1,'2024-09-11 15:16:48','2024-09-12 08:44:36'),
(10,14,43,'[\"9\",\"9\",\"9\",\"9\",\"9\",\"0\",\"0\",\"0\"]','[\"9\",\"9\",\"9\",\"9\",\"9\",\"0\",\"0\",\"0\"]',6,'2024-09-12 08:43:55','2024-09-12 08:44:36'),
(11,15,85,'[\"8\",\"8\",\"8\",\"8\",\"8\",\"0\",\"0\",\"0\"]','[\"8\",\"8\",\"8\",\"8\",\"8\",\"10\",\"0\",\"0\"]',1,'2024-09-12 09:12:37','2024-09-12 09:14:16');
/*!40000 ALTER TABLE `scores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('gv27djQ9uJCAndOxXY7Lf6I0YhXweNlV0f6p1OKh',2,'172.18.0.6','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/128.0.0.0 Safari/537.36 Edg/128.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibFI5dHBnb3prWEJXaUswZE5NZzJCQU5TYklMVUtTbmNrcmNYa3JFciI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8va2FydGF0eXBlcmEuZGRldi5zaXRlL3Byb2ZpbGUtcGFnZS9RQllTVCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',1726136291);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `showcases`
--

DROP TABLE IF EXISTS `showcases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `showcases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `showcase_user_id_foreign` (`user_id`),
  CONSTRAINT `showcase_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `showcases`
--

LOCK TABLES `showcases` WRITE;
/*!40000 ALTER TABLE `showcases` DISABLE KEYS */;
INSERT INTO `showcases` VALUES
(2,2,'Puchar dla największego szefity','trophies/dmKGlRqkcx9ixd5FEkLe4ZKS1uQMEPzvvUjFwmN8.jpg','2024-09-12 10:59:30','2024-09-12 10:59:30'),
(4,2,'Puchar dla adma','trophies/CNjji96RXZ1TVaWNmBAjpti7iin7f8L2jWxRT0Uk.jpg','2024-09-12 11:18:07','2024-09-12 11:18:07'),
(5,2,'Puchar za pierwsze miejsce w sezonie 1','trophies/epSnOtTdAPyo8fWecY1RBh7zA9fbBSYQjsB1YTuK.jpg','2024-09-12 11:20:27','2024-09-12 11:20:27'),
(7,2,'Puchar Testowy','trophies/0KhsjxYYukBjr0xRnrDhPOQaUvRhwbd0knK5hp9E.jpg','2024-09-12 11:56:54','2024-09-12 11:56:54');
/*!40000 ALTER TABLE `showcases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `profile_picture_path` varchar(255) NOT NULL DEFAULT 'profile_pictures/no_profile_picture.png',
  `points` int(11) NOT NULL DEFAULT 0,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `description` longtext DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(2,'DeporS','depores1337@gmail.com','2024-09-04 07:06:53','$2y$12$P4QCKbT9Cy2qfqnbXcqnZeZvTOK9v43FyfkPoHLS5vEqleUcE4sGi','vM3BDSULIpRZvls5eJEf2BmLzx2rJE3BxtpdbjdEZGcbPnL2YZKs8YcLHSiG','2024-09-04 07:03:25','2024-09-12 09:43:06','profile_pictures/1Pkv5A2Fe75UIMO9CVsmRtvthD9TJtyPOZS0LNGL.jpg',327,'admin','hej polonia, polonia!'),
(3,'user','user@gmail.com','2024-09-04 08:23:42','$2y$12$B9ShwaOA9vyHfwAsnhsTS.uFPvW5jD.KMD7lykEl9TXnLVP8BJVLq',NULL,'2024-09-04 07:09:13','2024-09-04 08:23:42','profile_pictures/Xl5jpIrphoFaflKnu09CfVA8x3rsQrf8C5HBOGMR.jpg',0,'user',NULL),
(4,'plebcio','plebcio@gmail.com',NULL,'$2y$12$zUov1bB9tv2ao1rnyL.yse7/0iowJpwGB.TVZTR76nTb2q2foeU6S',NULL,'2024-09-12 08:40:26','2024-09-12 09:14:16','profile_pictures/GC5vAvuxEN3eZcKCvQG8n2PA5RnHWOYgUn5aYyIB.jpg',111,'user',NULL),
(5,'Borysław','depor@gmail.com',NULL,'$2y$12$m6PHPBhNGwht7sbM8XzKJ.iHFkPfppGYtYeMln37nDRHshgH7U9Nu',NULL,'2024-09-12 09:08:32','2024-09-12 09:10:05','profile_pictures/8HiZ7iQtkYXwIdAIRzFj4IsLIkQgFEo3ki0lrXiF.png',0,'user',NULL),
(6,'QBYST','qbyst@o2.pl',NULL,'$2y$12$XVMoyRp967QJTRL4tLNvteP3xJ8p/BQhacZT9NkbkVC6f39XyCoiK',NULL,'2024-09-12 09:11:15','2024-09-12 09:14:16','profile_pictures/Pvb8haAgL3do65E0kOc4CtSw5aJduvtBBDZUC6ch.jpg',274,'admin',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_bets`
--

DROP TABLE IF EXISTS `weekly_bets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weekly_bets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weekly_pick_template_id` bigint(20) unsigned NOT NULL,
  `bet_text` varchar(255) NOT NULL,
  `odd_yes` double NOT NULL,
  `odd_no` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bet_type` enum('purple','beige') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weekly_bets_weekly_pick_template_id_foreign` (`weekly_pick_template_id`),
  CONSTRAINT `weekly_bets_weekly_pick_template_id_foreign` FOREIGN KEY (`weekly_pick_template_id`) REFERENCES `weekly_pick_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_bets`
--

LOCK TABLES `weekly_bets` WRITE;
/*!40000 ALTER TABLE `weekly_bets` DISABLE KEYS */;
INSERT INTO `weekly_bets` VALUES
(9,4,'Jeden z braci Kowalik zaliczy defekt.',1.75,1.89,'2024-09-05 13:41:52','2024-09-05 13:41:52','purple'),
(10,4,'Waśkowiak da radę wejść na motor.',15,1.01,'2024-09-05 13:41:52','2024-09-05 13:41:52','purple'),
(11,4,'Warszawski w przerwie zagra hymn piły na saksofonie.',1.25,3.5,'2024-09-05 13:41:52','2024-09-05 13:41:52','purple'),
(12,4,'Misiak pomyli strony i pojedzie pod prąd.',1.15,4.5,'2024-09-05 13:41:52','2024-09-05 13:41:52','purple'),
(13,4,'Michna po zdobyciu 3 punktów, wyśle buziaki w stronę Baranowskiego. (jeśli nie zdobędzie 3 pkt zwrot)',1.2,4,'2024-09-05 13:41:52','2024-09-05 13:41:52','purple'),
(14,4,'Jabłoński +1,5',6,1.1,'2024-09-05 13:41:52','2024-09-05 13:41:52','beige'),
(15,4,'Matyla +13,5',1.25,3,'2024-09-05 13:41:52','2024-09-10 12:27:55','beige'),
(16,4,'Subczyński +5.5',1.82,1.82,'2024-09-05 13:41:52','2024-09-05 13:41:52','beige'),
(17,5,'bet1',1.77,1.75,'2024-09-06 11:00:41','2024-09-06 11:00:41','purple'),
(18,5,'bet2',1.9,1.81,'2024-09-06 11:00:41','2024-09-06 11:00:41','purple'),
(19,5,'bet3',3,1.3,'2024-09-06 11:00:41','2024-09-06 11:00:41','purple'),
(20,5,'bet4',10,1.02,'2024-09-06 11:00:41','2024-09-06 11:00:41','purple'),
(21,5,'bet5',4.25,1.15,'2024-09-06 11:00:41','2024-09-06 11:00:41','purple'),
(22,5,'bet6',3.3,1.26,'2024-09-06 11:00:41','2024-09-06 11:00:41','beige'),
(23,5,'bet7',1.1,6,'2024-09-06 11:00:41','2024-09-06 11:00:41','beige'),
(24,5,'bet8',1.45,2.5,'2024-09-06 11:00:41','2024-09-06 11:00:41','beige'),
(33,7,'d',1.2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','purple'),
(34,7,'2',2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','purple'),
(35,7,'2',2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','purple'),
(36,7,'2',2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','purple'),
(37,7,'2',22,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','purple'),
(38,7,'2',2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','beige'),
(39,7,'2',2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','beige'),
(40,7,'2',2,2,'2024-09-06 13:26:31','2024-09-06 13:26:31','beige');
/*!40000 ALTER TABLE `weekly_bets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_pick_outcomes`
--

DROP TABLE IF EXISTS `weekly_pick_outcomes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weekly_pick_outcomes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `weekly_pick_template_id` bigint(20) unsigned NOT NULL,
  `team_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`team_outcomes`)),
  `rider_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`rider_outcomes`)),
  `h2h_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`h2h_outcomes`)),
  `bet_outcomes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`bet_outcomes`)),
  `week` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weekly_pick_outcomes_weekly_pick_template_id_foreign` (`weekly_pick_template_id`),
  CONSTRAINT `weekly_pick_outcomes_weekly_pick_template_id_foreign` FOREIGN KEY (`weekly_pick_template_id`) REFERENCES `weekly_pick_templates` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_pick_outcomes`
--

LOCK TABLES `weekly_pick_outcomes` WRITE;
/*!40000 ALTER TABLE `weekly_pick_outcomes` DISABLE KEYS */;
INSERT INTO `weekly_pick_outcomes` VALUES
(3,4,'[\"46\",\"44\"]','[\"11\",\"5\",\"10\",\"0\",\"10\",\"10\",\"0\",\"0\",\"15\",\"15\",\"14\",\"0\",\"0\",\"0\",\"0\",\"0\"]','[\"home\",\"home\",\"away\",\"away\",\"away\"]','[\"tak\",\"tak\",\"tak\",\"tak\",\"tak\",\"tak\",\"tak\",\"tak\"]',1,'2024-09-06 10:25:56','2024-09-12 08:48:28'),
(11,5,'[\"40\",\"50\"]','[\"8\",\"8\",\"8\",\"8\",\"8\",\"0\",\"0\",\"0\",\"8\",\"8\",\"8\",\"8\",\"8\",\"10\",\"0\",\"0\"]','[\"home\",\"home\",\"away\",\"home\",\"away\"]','[\"tak\",\"tak\",\"tak\",\"tak\",\"tak\",\"tak\",\"tak\",\"tak\"]',2,'2024-09-12 08:53:31','2024-09-12 09:14:16');
/*!40000 ALTER TABLE `weekly_pick_outcomes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_pick_templates`
--

DROP TABLE IF EXISTS `weekly_pick_templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weekly_pick_templates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `teams` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`teams`)),
  `riders` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`riders`)),
  `h2hs` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`h2hs`)),
  `week` int(11) NOT NULL,
  `closes_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_pick_templates`
--

LOCK TABLES `weekly_pick_templates` WRITE;
/*!40000 ALTER TABLE `weekly_pick_templates` DISABLE KEYS */;
INSERT INTO `weekly_pick_templates` VALUES
(4,'[\"Polonia Pi\\u0142a\",\"Unia Tarn\\u00f3w\"]','[\"Matyla\",\"Warszawski\",\"Jab\\u0142o\\u0144ski\",\"Wa\\u015bkowiak\",\"Owczarek\",\"Rudy\",\"Kubisz\",\"KowalikF\",\"Mieszko\",\"Michna\",\"Baranowski\",\"Mierzwicki\",\"Subczy\\u0144ski\",\"Kupis\",\"Misiak\",\"KowalikSz\"]','[\"Matyla\",\"Warszawski\",\"Jab\\u0142o\\u0144ski\",\"Wa\\u015bkowiak\",\"KowalikF\",\"Baranowski\",\"Kupis\",\"Subczy\\u0144ski\",\"Mieszko\",\"KowalikSz\"]',1,'2024-09-11 13:41:52','2024-09-05 13:41:52','2024-09-10 12:14:56'),
(5,'[\"Unia Uj\\u015bcie\",\"Do\\u0142ki Dolaszewo\"]','[\"Burmistrz\",\"Ciotka\",\"Wujek\",\"Dziadek\",\"Matka\",\"Syn\",\"But\",\"S\\u0119dzia\",\"Szef\",\"W\\u00f3jt\",\"Babcia\",\"C\\u00f3rka\",\"Ojciec\",\"Gabriel\",\"Kalosz\",\"W\\u0119dlina\"]','[\"Burmistrz\",\"Ciotka\",\"Syn\",\"S\\u0119dzia\",\"But\",\"Szef\",\"Gabriel\",\"W\\u00f3jt\",\"Kalosz\",\"W\\u0119dlina\"]',2,'2024-09-19 11:00:41','2024-09-06 11:00:41','2024-09-11 14:31:23'),
(7,'[\"bonobo\",\"dasa\"]','[\"xdd\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\",\"d\"]','[\"xdd\",\"xdd\",\"xdd\",\"xdd\",\"xdd\",\"d\",\"d\",\"d\",\"d\",\"d\"]',3,'2024-09-25 14:25:56','2024-09-06 13:26:31','2024-09-06 13:26:31');
/*!40000 ALTER TABLE `weekly_pick_templates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `weekly_picks`
--

DROP TABLE IF EXISTS `weekly_picks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `weekly_picks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `week` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `weekly_picks_user_id_foreign` (`user_id`),
  CONSTRAINT `weekly_picks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `weekly_picks`
--

LOCK TABLES `weekly_picks` WRITE;
/*!40000 ALTER TABLE `weekly_picks` DISABLE KEYS */;
INSERT INTO `weekly_picks` VALUES
(12,2,1,170,'2024-09-11 13:16:25','2024-09-12 08:48:28'),
(13,2,2,157,'2024-09-11 15:16:48','2024-09-12 09:14:16'),
(14,4,2,111,'2024-09-12 08:43:55','2024-09-12 09:14:16'),
(15,6,2,274,'2024-09-12 09:12:37','2024-09-12 09:14:16');
/*!40000 ALTER TABLE `weekly_picks` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-12 11:04:30
