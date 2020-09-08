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
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tax_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
INSERT INTO `clients` VALUES (1,'2020-08-28 02:30:42','2020-08-28 02:30:42','Dorian','Aguilar','Signs Comunicacion Visual','daguilar@signscv.com','23032303','Mixco','234234-4','Hola');
INSERT INTO `clients` VALUES (2,'2020-09-02 15:26:16','2020-09-02 15:26:16','Walter','Leal','Industrias Panavision S.A. de C.V.','wleal@panavision.com','50125911','12 Calle 1-25 Torre Sur Of. 901','234242-3','Honduras');
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
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
INSERT INTO `migrations` VALUES (8,'2020_08_26_205531_create_productions_table',1);
INSERT INTO `migrations` VALUES (9,'2020_08_26_225722_create_production_products_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_product`
--

DROP TABLE IF EXISTS `order_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `order_product` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` double(10,2) NOT NULL,
  `remaining_quantity` double(10,2) DEFAULT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_product_order_id_index` (`order_id`),
  KEY `order_product_product_id_index` (`product_id`),
  CONSTRAINT `order_product_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_product_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_product`
--

LOCK TABLES `order_product` WRITE;
/*!40000 ALTER TABLE `order_product` DISABLE KEYS */;
INSERT INTO `order_product` VALUES (5,NULL,'2020-08-31 18:19:29',3,1,20.00,1.00,450.00);
INSERT INTO `order_product` VALUES (6,NULL,'2020-09-02 05:14:35',2,1,60.00,0.00,50.00);
INSERT INTO `order_product` VALUES (7,NULL,'2020-09-02 15:28:21',1,1,100.00,0.00,456.00);
INSERT INTO `order_product` VALUES (8,NULL,NULL,4,1,10.00,10.00,450.00);
INSERT INTO `order_product` VALUES (9,NULL,'2020-09-02 15:28:21',4,2,10.00,0.00,750.00);
/*!40000 ALTER TABLE `order_product` ENABLE KEYS */;
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
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client_id` int(10) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `delivery_date` date NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_client_id_index` (`client_id`),
  CONSTRAINT `orders_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,'2020-08-28 02:31:03','2020-09-02 15:39:11','SO-1',1,3,'2020-08-27','asdfa');
INSERT INTO `orders` VALUES (2,'2020-08-31 09:02:27','2020-09-02 05:17:01','SO-2',1,3,'2020-08-25','kjhg');
INSERT INTO `orders` VALUES (3,'2020-08-31 18:15:27','2020-08-31 18:16:02','SO-3',1,2,'2020-08-26','asdf');
INSERT INTO `orders` VALUES (4,'2020-09-02 15:27:20','2020-09-02 15:28:21','SO-4',2,2,'2020-09-08','Honduras, exportacion');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `production_products`
--

DROP TABLE IF EXISTS `production_products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `production_products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `production_id` int(10) unsigned NOT NULL,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `production_products_order_id_foreign` (`order_id`),
  KEY `production_products_product_id_foreign` (`product_id`),
  KEY `production_products_production_id_foreign` (`production_id`),
  CONSTRAINT `production_products_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `production_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `production_products_production_id_foreign` FOREIGN KEY (`production_id`) REFERENCES `productions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `production_products`
--

LOCK TABLES `production_products` WRITE;
/*!40000 ALTER TABLE `production_products` DISABLE KEYS */;
INSERT INTO `production_products` VALUES (1,1,1,1,3.00);
INSERT INTO `production_products` VALUES (2,2,1,1,1.00);
INSERT INTO `production_products` VALUES (5,4,2,1,1.00);
INSERT INTO `production_products` VALUES (6,5,2,1,1.00);
INSERT INTO `production_products` VALUES (7,6,2,1,48.00);
INSERT INTO `production_products` VALUES (8,7,1,1,50.00);
INSERT INTO `production_products` VALUES (9,8,3,1,10.00);
INSERT INTO `production_products` VALUES (10,9,3,1,10.00);
INSERT INTO `production_products` VALUES (11,9,2,1,30.00);
INSERT INTO `production_products` VALUES (12,10,1,1,50.00);
INSERT INTO `production_products` VALUES (13,11,2,1,20.00);
INSERT INTO `production_products` VALUES (14,12,2,1,5.00);
INSERT INTO `production_products` VALUES (15,13,2,1,5.00);
INSERT INTO `production_products` VALUES (16,14,1,1,50.00);
INSERT INTO `production_products` VALUES (17,14,4,2,10.00);
/*!40000 ALTER TABLE `production_products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productions`
--

DROP TABLE IF EXISTS `productions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `productions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_at` timestamp NOT NULL,
  `end_at` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productions`
--

LOCK TABLES `productions` WRITE;
/*!40000 ALTER TABLE `productions` DISABLE KEYS */;
INSERT INTO `productions` VALUES (1,'2020-08-27 20:31:00','2020-08-28 14:30:00','2020-08-28 02:32:20','2020-08-28 02:32:20');
INSERT INTO `productions` VALUES (2,'2020-08-30 21:00:00','2020-08-31 00:00:00','2020-08-31 03:04:36','2020-08-31 03:04:36');
INSERT INTO `productions` VALUES (4,'2020-08-31 04:59:00','2020-08-31 05:00:00','2020-08-31 11:00:07','2020-08-31 11:00:07');
INSERT INTO `productions` VALUES (5,'2020-08-31 18:00:00','2020-09-01 02:00:00','2020-08-31 11:00:28','2020-08-31 11:00:28');
INSERT INTO `productions` VALUES (6,'2020-08-31 05:01:00','2020-08-31 05:02:00','2020-08-31 11:04:53','2020-08-31 11:04:53');
INSERT INTO `productions` VALUES (7,'2020-08-31 17:30:00','2020-09-01 05:31:00','2020-08-31 23:30:42','2020-08-31 23:30:42');
INSERT INTO `productions` VALUES (8,'2020-08-31 18:15:00','2020-08-31 19:17:00','2020-08-31 18:16:02','2020-08-31 18:16:02');
INSERT INTO `productions` VALUES (9,'2020-08-31 18:19:00','2020-08-31 18:20:00','2020-08-31 18:19:29','2020-08-31 18:19:29');
INSERT INTO `productions` VALUES (10,'2020-08-31 19:19:00','2020-08-31 19:20:00','2020-08-31 18:20:15','2020-08-31 18:20:15');
INSERT INTO `productions` VALUES (11,'2020-09-01 21:26:00','2020-09-01 21:28:00','2020-09-02 06:26:55','2020-09-02 06:26:55');
INSERT INTO `productions` VALUES (12,'2020-09-01 21:27:00','2020-09-01 21:29:00','2020-09-02 06:27:46','2020-09-02 06:27:46');
INSERT INTO `productions` VALUES (13,'2020-09-02 05:14:00','2020-09-02 05:15:00','2020-09-02 05:14:35','2020-09-02 05:14:35');
INSERT INTO `productions` VALUES (14,'2020-09-02 15:27:00','2020-09-02 15:30:00','2020-09-02 15:28:21','2020-09-02 15:28:21');
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` int(11) NOT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'2020-08-28 02:29:42','2020-08-28 02:29:42','10-00 2.44 x 1.22 x 3','10002441223','10-00 2.44 x 1.22 x 3',11,'456');
INSERT INTO `products` VALUES (2,'2020-09-02 15:23:58','2020-09-02 15:23:58','10-00 2.44 x 1.22 x 5','10002441225','10-00 2.44 x 1.22 x 5',18,'750');
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
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','admin@admin.com',NULL,'$2y$10$RgW1OXa4GpNeZGLvqgNY5.lDUemPuenkPufqkttfcNmWKT/dP0WPK','sppn3ODyW9wVCNBA9rKZlaLQdRxgtEvN8luZOoPox63xs4GoPw7HMUpCWu1t',NULL,'2020-08-28 02:27:21');
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

-- Dump completed on 2020-09-04 23:12:07
