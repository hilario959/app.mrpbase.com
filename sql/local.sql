-- MySQL dump 10.13  Distrib 8.0.16, for macos10.14 (x86_64)
--
-- Host: localhost    Database: local
-- ------------------------------------------------------
-- Server version	8.0.16

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `clients` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'2020-07-22 07:40:32','2020-08-20 02:47:15','Dorian','Aguilar','Signs','info@scvisual.gt','23032303','Mixco','654615-8',NULL);
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
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
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1);
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1);
INSERT INTO `migrations` VALUES (3,'2019_08_19_000000_create_failed_jobs_table',1);
INSERT INTO `migrations` VALUES (4,'2020_07_17_053600_create_clients_table',1);
INSERT INTO `migrations` VALUES (5,'2020_07_19_152110_create_products_table',1);
INSERT INTO `migrations` VALUES (6,'2020_07_19_203844_create_orders_table',1);
INSERT INTO `migrations` VALUES (7,'2020_07_20_185231_create_order_products_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_products`
--

DROP TABLE IF EXISTS `order_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `order_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` double(10,2) NOT NULL,
  `remaining_quantity` double(10,2) DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_products_order_id_index` (`order_id`),
  KEY `order_products_product_id_index` (`product_id`),
  CONSTRAINT `order_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_products`
--

LOCK TABLES `order_products` WRITE;
/*!40000 ALTER TABLE `order_products` DISABLE KEYS */;
INSERT INTO `order_products` VALUES (26,NULL,NULL,14,3,5.00,0.00,490.00);
INSERT INTO `order_products` VALUES (27,NULL,NULL,15,3,1.00,0.00,490.00);
INSERT INTO `order_products` VALUES (28,NULL,NULL,16,3,10.00,0.00,490.00);
INSERT INTO `order_products` VALUES (29,NULL,NULL,17,3,100.00,96.00,1.00);
INSERT INTO `order_products` VALUES (30,NULL,NULL,18,6,1.00,0.00,1.00);
INSERT INTO `order_products` VALUES (40,NULL,NULL,22,12,34.00,34.00,34.00);
INSERT INTO `order_products` VALUES (43,NULL,NULL,23,3,10000.00,10000.00,1.00);
INSERT INTO `order_products` VALUES (45,NULL,NULL,25,3,3.00,3.00,3.00);
INSERT INTO `order_products` VALUES (46,NULL,NULL,25,15,3.00,3.00,3.00);
/*!40000 ALTER TABLE `order_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `client_id` int(10) unsigned DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `notes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_production` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_client_id_index` (`client_id`),
  CONSTRAINT `orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (14,'2020-08-17 06:58:36','2020-08-18 21:23:07','SO-14',1,3,'2020-08-24',NULL,NULL);
INSERT INTO `orders` VALUES (15,'2020-08-17 07:29:07','2020-08-18 21:23:07','SO-15',1,3,'2020-08-18',NULL,NULL);
INSERT INTO `orders` VALUES (16,'2020-08-18 21:42:56','2020-08-19 10:42:31','SO-16',1,3,'2020-08-19',NULL,NULL);
INSERT INTO `orders` VALUES (17,'2020-08-19 10:29:10','2020-08-19 10:42:31','SO-17',1,2,'2020-08-19',NULL,NULL);
INSERT INTO `orders` VALUES (18,'2020-08-19 10:41:32','2020-08-19 10:42:31','SO-18',1,3,'2020-08-18',NULL,NULL);
INSERT INTO `orders` VALUES (20,'2020-08-20 02:52:31','2020-08-20 02:52:31','SO-20',1,0,'2020-08-18',NULL,NULL);
INSERT INTO `orders` VALUES (21,'2020-08-20 02:52:36','2020-08-20 02:52:36','SO-21',1,0,'2020-08-18',NULL,NULL);
INSERT INTO `orders` VALUES (22,'2020-08-20 02:53:28','2020-08-20 10:27:11','SO-22',1,2,'2020-08-18',NULL,NULL);
INSERT INTO `orders` VALUES (23,'2020-08-20 02:56:31','2020-08-20 03:13:14','SO-23',1,2,'2020-08-20',NULL,NULL);
INSERT INTO `orders` VALUES (24,'2020-08-20 03:19:18','2020-08-20 03:19:18','SO-24',1,0,'2020-08-19','3',NULL);
INSERT INTO `orders` VALUES (25,'2020-08-20 03:21:14','2020-08-20 10:27:11','SO-25',1,2,'2020-08-03','r',NULL);
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES ('vinod@indiaresults.com','$2y$10$1IH/RhosCzuRlde0Oof9aO.4NRWxgWrfJQOElXNR1ZyU15M4IuxDW','2020-07-22 21:45:48');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productions`
--

DROP TABLE IF EXISTS `productions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `productions` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `product_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remaining_quantity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `production_date` date DEFAULT NULL,
  `to_be_produced` int(11) DEFAULT NULL,
  `unique_id` bigint(11) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `productions_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productions`
--

LOCK TABLES `productions` WRITE;
/*!40000 ALTER TABLE `productions` DISABLE KEYS */;
INSERT INTO `productions` VALUES (24,14,'3','5',NULL,'2020-08-18',5,1597764187,'2020-08-18 09:23:07','2020-08-18 09:23:07');
INSERT INTO `productions` VALUES (25,15,'3','1',NULL,'2020-08-18',1,1597764187,'2020-08-18 09:23:07','2020-08-18 09:23:07');
INSERT INTO `productions` VALUES (26,16,'3','10',NULL,'2020-08-19',1,1597765388,'2020-08-18 09:43:08','2020-08-18 09:43:08');
INSERT INTO `productions` VALUES (27,16,'3','10',NULL,NULL,3,1597775384,'2020-08-18 12:29:44','2020-08-18 12:29:44');
INSERT INTO `productions` VALUES (28,16,'3','10',NULL,NULL,5,1597808891,'2020-08-18 21:48:11','2020-08-18 21:48:11');
INSERT INTO `productions` VALUES (29,16,'3','10',NULL,NULL,5,1597808891,'2020-08-18 21:48:11','2020-08-18 21:48:11');
INSERT INTO `productions` VALUES (30,16,'3','10',NULL,NULL,1,1597812151,'2020-08-18 22:42:31','2020-08-18 22:42:31');
INSERT INTO `productions` VALUES (31,17,'3','100',NULL,NULL,1,1597812151,'2020-08-18 22:42:31','2020-08-18 22:42:31');
INSERT INTO `productions` VALUES (32,18,'6','1',NULL,NULL,1,1597812151,'2020-08-18 22:42:31','2020-08-18 22:42:31');
INSERT INTO `productions` VALUES (33,17,'3','100',NULL,NULL,1,1597871594,'2020-08-19 15:13:14','2020-08-19 15:13:14');
INSERT INTO `productions` VALUES (34,23,'3','10000',NULL,NULL,1,1597871594,'2020-08-19 15:13:14','2020-08-19 15:13:14');
INSERT INTO `productions` VALUES (35,23,'3','1000',NULL,NULL,1,1597871594,'2020-08-19 15:13:14','2020-08-19 15:13:14');
INSERT INTO `productions` VALUES (36,17,'3','100',NULL,NULL,2,1597897631,'2020-08-19 22:27:11','2020-08-19 22:27:11');
/*!40000 ALTER TABLE `productions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (3,'2020-07-22 22:19:44','2020-08-20 02:40:06','10-00 2.44 x 1.22 x 3','10002441223','10-00 2.44 x 1.22 x 3',10.74,'490');
INSERT INTO `products` VALUES (4,'2020-07-22 22:20:11','2020-08-17 06:53:21','10-00 2.44 x 1.22 x 5','10002441225','10-00 2.44 x 1.22 x 5',20.74,'920');
INSERT INTO `products` VALUES (6,'2020-07-23 01:26:43','2020-08-17 06:56:41','10-00 2.44 x 1.22 x 6','10002441226','10-00 2.44 x 1.22 x 6',35.00,'1196');
INSERT INTO `products` VALUES (10,'2020-08-20 02:29:07','2020-08-20 02:29:27','19-71 1.90 x 1.30 x 2.5','197119013025','19-71 1.90 x 1.30 x 2.5',7.41,'270');
INSERT INTO `products` VALUES (11,'2020-08-20 02:30:10','2020-08-20 02:30:10','40-10 2.44 x 1.22 x 3','40102441223','40-10 2.44 x 1.22 x 3',10.72,'500');
INSERT INTO `products` VALUES (12,'2020-08-20 02:33:39','2020-08-20 02:33:39','10-00 2.44 x 1.22 x 10','100024412210','10-00 2.44 x 1.22 x 10',35.73,'1826');
INSERT INTO `products` VALUES (14,'2020-08-20 02:36:29','2020-08-20 02:36:29','19-61 2.44 x 1.22 x 3','19612441223','19-61 2.44 x 1.22 x 3',10.72,'626');
INSERT INTO `products` VALUES (15,'2020-08-20 02:36:58','2020-08-20 02:36:58','12-10 2.44 x 1.22 x 3','12102441223','12-10 2.44 x 1.22 x 3',10.72,'626');
INSERT INTO `products` VALUES (16,'2020-08-20 02:37:38','2020-08-20 02:37:38','49-25 2.44 x 1.22 x 3','49252441223','49-25 2.44 x 1.22 x 3',10.72,'626');
INSERT INTO `products` VALUES (17,'2020-08-20 02:38:25','2020-08-20 02:38:25','39-25 2.44 x 1.22 x 3','39252441223','39-25 2.44 x 1.22 x 3',10.72,'656');
INSERT INTO `products` VALUES (18,'2020-08-20 02:39:25','2020-08-20 02:39:25','46-12 2.44 x 1.22 x 3','46122441223','46-12 2.44 x 1.22 x 3',10.72,'656');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@admin.com',NULL,'$2y$10$.pzhRBrUF9Wt69Y1cODAdegr8u1pbCJIQFL.Bu0RDaOGya7KAh/aa','5h4QlYppoWre6UKfMa8IQ6pqfZ43MiDJgf7E74J0H2HrwUcptYktQSaUbJdc','2020-07-22 07:38:25','2020-07-24 21:46:05');
INSERT INTO `users` VALUES (3,'Kuldeep Singh','kuldeep.singh@indiaresults.com',NULL,'$2y$10$qjvp6K00pc6qJNKT39yljOU8HJHA2QuYPxQ8NBAPgWDVtH.emQq1y',NULL,'2020-07-23 01:16:54','2020-07-23 01:16:54');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-08-20 11:19:49
